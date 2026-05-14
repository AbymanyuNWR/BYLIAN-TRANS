<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BookingInvoiceController extends Controller
{
    /**
     * Generate and stream a PDF invoice for a specific booking.
     */
    public function download(Booking $booking)
    {
        // Eager load necessary relationships
        $booking->load(['service', 'route', 'vehicle', 'invoice']);

        // Generate the PDF from HTML view
        $pdf = Pdf::loadView('pdf.invoice', compact('booking'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

        // Stream PDF to browser
        return $pdf->stream("invoice-{$booking->booking_code}.pdf");
    }
}
