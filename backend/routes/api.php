<?php

use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Read resources
Route::get('/services', [PublicApiController::class, 'getServices']);
Route::get('/vehicles', [PublicApiController::class, 'getVehicles']);
Route::get('/vehicle-categories', [PublicApiController::class, 'getVehicleCategories']);
Route::get('/routes', [PublicApiController::class, 'getRoutes']);
Route::get('/faqs', [PublicApiController::class, 'getFaqs']);
Route::get('/testimonials', [PublicApiController::class, 'getTestimonials']);
Route::get('/settings', [PublicApiController::class, 'getSettings']);

// Write form records
Route::post('/bookings', [PublicApiController::class, 'createBooking']);
Route::get('/bookings/check', [PublicApiController::class, 'checkBooking']);
Route::post('/charter-requests', [PublicApiController::class, 'createCharter']);
Route::post('/contact-inquiries', [PublicApiController::class, 'createContactInquiry']);

// Payments
use App\Http\Controllers\Api\PaymentController;
Route::post('/payments/snap-token', [PaymentController::class, 'createSnapToken']);
Route::post('/payments/callback', [PaymentController::class, 'callback']);
