<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }

    public function createSnapToken(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with(['customer', 'service', 'route'])->findOrFail($request->booking_id);

        // Check if payment already exists or has snap token
        $payment = Payment::where('booking_id', $booking->id)->first();

        if ($payment && $payment->snap_token && $payment->payment_status === 'pending') {
            return response()->json([
                'success' => true,
                'message' => 'Snap token already exists',
                'data' => [
                    'snap_token' => $payment->snap_token,
                ],
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_code . '-' . time(),
                'gross_amount' => (int) $booking->final_price,
            ],
            'customer_details' => [
                'first_name' => $booking->customer_name,
                'email' => $booking->customer_email,
                'phone' => $booking->customer_phone,
            ],
            'item_details' => [
                [
                    'id' => $booking->service_id ?? 'service',
                    'price' => (int) $booking->final_price,
                    'quantity' => 1,
                    'name' => ($booking->service ? $booking->service->title : 'Transport Service') . ' - ' . ($booking->route ? $booking->route->origin_city . ' to ' . $booking->route->destination_city : 'Booking'),
                ]
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            if (!$payment) {
                $payment = new Payment();
                $payment->booking_id = $booking->id;
                $payment->amount = $booking->final_price;
                $payment->payment_method = 'midtrans';
                $payment->payment_status = 'pending';
            }

            $payment->snap_token = $snapToken;
            $payment->save();

            return response()->json([
                'success' => true,
                'message' => 'Snap token generated successfully',
                'data' => [
                    'snap_token' => $snapToken,
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderIdParts = explode('-', $request->order_id);
        $bookingCode = $orderIdParts[0];

        $booking = Booking::where('booking_code', $bookingCode)->first();
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $payment = Payment::where('booking_id', $booking->id)->first();
        if (!$payment) {
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount = $request->gross_amount;
            $payment->payment_method = 'midtrans';
        }

        $transactionStatus = $request->transaction_status;
        $type = $request->payment_type;
        $orderId = $request->order_id;
        $fraud = $request->fraud_status;

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $payment->payment_status = 'challenge';
                } else {
                    $payment->payment_status = 'success';
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $payment->payment_status = 'success';
        } else if ($transactionStatus == 'pending') {
            $payment->payment_status = 'pending';
        } else if ($transactionStatus == 'deny') {
            $payment->payment_status = 'denied';
        } else if ($transactionStatus == 'expire') {
            $payment->payment_status = 'expired';
        } else if ($transactionStatus == 'cancel') {
            $payment->payment_status = 'canceled';
        }

        $payment->payment_type = $type;
        $payment->midtrans_response = json_encode($request->all());
        
        if ($payment->payment_status == 'success') {
            $payment->paid_at = now();
            $booking->payment_status = 'paid';
            $booking->booking_status = 'confirmed';
            $booking->save();
        }

        $payment->save();

        return response()->json(['message' => 'Callback processed']);
    }
}
