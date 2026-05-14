<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CharterRequest;
use App\Models\ContactInquiry;
use App\Models\Faq;
use App\Models\Route;
use App\Models\Testimonial;
use App\Models\TransportService;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\WebsiteSetting;
use App\Models\WhatsappSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicApiController extends Controller
{
    /**
     * Get active transport services list.
     */
    public function getServices()
    {
        $services = TransportService::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    /**
     * Get active fleet vehicles list with category details.
     */
    public function getVehicles()
    {
        $vehicles = Vehicle::with('category')
            ->where('status', 'available')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $vehicles,
        ]);
    }

    /**
     * Get active vehicle categories.
     */
    public function getVehicleCategories()
    {
        $categories = VehicleCategory::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get active route directories.
     */
    public function getRoutes()
    {
        $routes = Route::where('status', 'active')->get();

        return response()->json([
            'success' => true,
            'data' => $routes,
        ]);
    }

    /**
     * Get active FAQs list.
     */
    public function getFaqs()
    {
        $faqs = Faq::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $faqs,
        ]);
    }

    /**
     * Get active client testimonials list.
     */
    public function getTestimonials()
    {
        $testimonials = Testimonial::where('status', 'active')
            ->orderBy('sort_order', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials,
        ]);
    }

    /**
     * Get website branding settings & WhatsApp configurations.
     */
    public function getSettings()
    {
        $webSettings = WebsiteSetting::first();
        $waSettings = WhatsappSetting::first();

        return response()->json([
            'success' => true,
            'data' => [
                'site' => $webSettings,
                'whatsapp' => $waSettings,
            ],
        ]);
    }

    /**
     * Handle quick-booking submissions from public forms.
     */
    public function createBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:transport_services,id',
            'route_id' => 'nullable|exists:routes,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string',
            'passenger_count' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $validated = $validator->validated();
            $validated['booking_status'] = 'pending';
            $validated['payment_status'] = 'unpaid';
            $validated['source'] = 'website';
            $validated['discount'] = 0;
            $validated['final_price'] = $validated['total_price'];

            // Create booking
            $booking = Booking::create($validated);

            // Automatically generate a draft invoice
            $booking->invoice()->create([
                'subtotal' => $booking->total_price,
                'discount' => 0,
                'tax' => 0,
                'total' => $booking->total_price,
                'status' => 'draft',
                'due_date' => $booking->pickup_date,
                'issued_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil diajukan',
                'data' => $booking->load(['service', 'invoice']),
            ], 210); // 210 created
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle inbound charter/quote requests.
     */
    public function createCharter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'pickup_location' => 'required|string',
            'destination' => 'required|string',
            'trip_type' => 'required|string|in:one_way,round_trip,multi_day,city_tour,custom',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'passenger_count' => 'required|integer|min:1',
            'vehicle_preference' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'estimated_budget' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $charter = CharterRequest::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Permintaan penawaran charter berhasil dikirim',
                'data' => $charter,
            ], 210);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check booking status by code and phone.
     */
    public function checkBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $booking = Booking::with(['service', 'vehicle', 'driver', 'payments', 'invoice'])
            ->where('booking_code', $request->code)
            ->where('customer_phone', $request->phone)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan. Periksa kembali kode booking dan nomor telepon Anda.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking,
        ]);
    }

    /**
     * Handle contact form submissions.
     */
    public function createContactInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $inquiry = ContactInquiry::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim ke admin',
                'data' => $inquiry,
            ], 210);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }
}
