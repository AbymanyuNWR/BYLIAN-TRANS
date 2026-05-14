<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role')->default('admin');
            $table->string('avatar')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. CUSTOMERS
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('identity_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 3. VEHICLE CATEGORIES
        Schema::create('vehicle_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. VEHICLES
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_category_id')->constrained('vehicle_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('plate_number')->unique();
            $table->integer('year')->nullable();
            $table->integer('capacity')->default(4);
            $table->string('fuel_type')->nullable();
            $table->string('transmission')->default('manual');
            $table->string('color')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('features')->nullable();
            $table->decimal('daily_price', 12, 2)->default(0);
            $table->decimal('hourly_price', 12, 2)->default(0);
            $table->decimal('airport_price', 12, 2)->default(0);
            $table->string('status')->default('available');
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 5. DRIVERS
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('license_number');
            $table->date('license_expired_at');
            $table->string('identity_number');
            $table->string('emergency_contact')->nullable();
            $table->integer('experience_years')->default(0);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_trips')->default(0);
            $table->string('status')->default('available');
            $table->timestamps();
        });

        // 6. TRANSPORT SERVICES
        Schema::create('transport_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('service_type');
            $table->decimal('price_start_from', 12, 2)->default(0);
            $table->json('features')->nullable();
            $table->json('includes')->nullable();
            $table->json('suitable_for')->nullable();
            $table->text('terms')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 7. ROUTES
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('origin_city');
            $table->string('destination_city');
            $table->string('slug')->unique();
            $table->integer('distance_km')->nullable();
            $table->string('estimated_duration')->nullable();
            $table->decimal('base_price', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->json('pickup_points')->nullable();
            $table->json('dropoff_points')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 8. SCHEDULES
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->string('arrival_estimation')->nullable();
            $table->integer('available_seats')->default(0);
            $table->integer('total_seats')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 9. BOOKINGS
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 50)->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained('transport_services')->onDelete('set null');
            $table->foreignId('route_id')->nullable()->constrained('routes')->onDelete('set null');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('set null');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->integer('passenger_count');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2);
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->string('booking_status', 30)->default('pending');
            $table->string('payment_status', 30)->default('unpaid');
            $table->string('source', 30)->default('website');
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['booking_code'], 'idx_code');
            $table->index(['booking_status'], 'idx_status');
            $table->index(['pickup_date'], 'idx_date');
        });

        // 10. CHARTER REQUESTS
        Schema::create('charter_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('pickup_location');
            $table->string('destination');
            $table->string('trip_type')->default('one_way');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->integer('passenger_count');
            $table->string('vehicle_preference')->nullable();
            $table->string('duration')->nullable();
            $table->text('message')->nullable();
            $table->decimal('estimated_budget', 12, 2)->nullable();
            $table->string('status')->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 11. PAYMENTS
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('payment_code', 50)->unique();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method');
            $table->string('payment_proof')->nullable();
            $table->string('payment_status')->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 12. INVOICES
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('invoice_number', 50)->unique();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status')->default('draft');
            $table->date('due_date')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 13. PROMO CODES
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('discount_type');
            $table->decimal('discount_value', 10, 2);
            $table->decimal('max_discount', 12, 2)->nullable();
            $table->decimal('minimum_order', 12, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 14. TESTIMONIALS
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_position')->nullable();
            $table->text('message');
            $table->tinyInteger('rating')->default(5);
            $table->string('service_type')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 15. FAQS
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 16. POST CATEGORIES
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 17. POSTS
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->onDelete('set null');
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active');
            $table->integer('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // 18. CONTACT INQUIRIES
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('status')->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 19. WEBSITE SETTINGS
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Bylian Transportasi');
            $table->string('site_tagline')->nullable();
            $table->text('site_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('google_maps_embed')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('business_hours')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });

        // 20. WHATSAPP SETTINGS
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->text('default_message')->nullable();
            $table->text('booking_message')->nullable();
            $table->text('charter_message')->nullable();
            $table->text('payment_message')->nullable();
            $table->text('driver_message')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('contact_inquiries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('promo_codes');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('charter_requests');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('transport_services');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_categories');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('users');
    }
};