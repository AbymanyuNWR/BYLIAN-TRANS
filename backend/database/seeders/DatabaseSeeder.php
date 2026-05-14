<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\VehicleCategory;
use App\Models\Vehicle;
use App\Models\TransportService;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\WebsiteSetting;
use App\Models\WhatsappSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admins and Drivers User accounts
        $adminUser = User::create([
            'name' => 'Bylian Super Admin',
            'email' => 'admin@byliantransportasi.com',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $driverUser1 = User::create([
            'name' => 'Agus Santoso',
            'email' => 'agus@byliantransportasi.com',
            'phone' => '081211112222',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'status' => 'active',
        ]);

        $driverUser2 = User::create([
            'name' => 'Bambang Tri',
            'email' => 'bambang@byliantransportasi.com',
            'phone' => '081233334444',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'status' => 'active',
        ]);

        // 2. Create Drivers Profiles
        $driver1 = Driver::create([
            'user_id' => $driverUser1->id,
            'name' => 'Agus Santoso',
            'phone' => '081211112222',
            'email' => 'agus@byliantransportasi.com',
            'address' => 'Jl. Kopo No. 45, Bandung',
            'license_number' => 'SIM-9908123456',
            'license_expired_at' => now()->addYears(3),
            'identity_number' => '3273012345670001',
            'emergency_contact' => '081299998888 (Istri)',
            'experience_years' => 8,
            'status' => 'available',
        ]);

        $driver2 = Driver::create([
            'user_id' => $driverUser2->id,
            'name' => 'Bambang Tri',
            'phone' => '081233334444',
            'email' => 'bambang@byliantransportasi.com',
            'address' => 'Jl. Cibiru No. 102, Bandung',
            'license_number' => 'SIM-9507111222',
            'license_expired_at' => now()->addYears(2),
            'identity_number' => '3273012345670002',
            'emergency_contact' => '081288887777 (Kakak)',
            'experience_years' => 12,
            'status' => 'available',
        ]);

        // 3. Create Customers
        Customer::create([
            'name' => 'Andi Pratama',
            'phone' => '081234567890',
            'email' => 'andi@email.com',
            'address' => 'Jl. Sudirman No. 20, Jakarta Pusat',
            'city' => 'Jakarta',
            'identity_number' => '3171012345670001',
            'notes' => 'Langganan tetap travel Bandung-Jakarta, sering bepergian akhir pekan',
            'status' => 'active',
        ]);

        Customer::create([
            'name' => 'Siti Rahmawati',
            'phone' => '085611112222',
            'email' => 'siti@email.com',
            'address' => 'Jl. Dago No. 12, Bandung',
            'city' => 'Bandung',
            'identity_number' => '3273022345670003',
            'notes' => 'Sering sewa Hiace untuk dinas luar kota',
            'status' => 'active',
        ]);

        Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '087812345678',
            'email' => 'budi@email.com',
            'address' => 'Jl. Setiabudi No. 110, Bandung',
            'city' => 'Bandung',
            'identity_number' => '3273032345670004',
            'notes' => 'Sering sewa mobil harian lepas kunci',
            'status' => 'active',
        ]);

        // 4. Create Vehicle Categories
        $catCity = VehicleCategory::create([
            'name' => 'City Car',
            'slug' => 'city-car',
            'description' => 'Mobil kompak yang lincah dan hemat bahan bakar, cocok untuk wilayah perkotaan padat.',
            'icon' => 'car',
            'sort_order' => 1,
        ]);

        $catMpv = VehicleCategory::create([
            'name' => 'MPV',
            'slug' => 'mpv',
            'description' => 'Multi Purpose Vehicle, mobil keluarga dengan kapasitas luas dan kenyamanan tinggi.',
            'icon' => 'users',
            'sort_order' => 2,
        ]);

        $catHiace = VehicleCategory::create([
            'name' => 'Hiace / Minibus',
            'slug' => 'hiace-minibus',
            'description' => 'Minibus berkapasitas besar, pilihan utama untuk perjalanan rombongan kecil, wisata, atau antar jemput bandara.',
            'icon' => 'bus',
            'sort_order' => 3,
        ]);

        $catLuxury = VehicleCategory::create([
            'name' => 'Luxury Car',
            'slug' => 'luxury-car',
            'description' => 'Mobil premium kelas atas untuk perjalanan VIP, eksekutif, bisnis, atau acara pernikahan resmi.',
            'icon' => 'crown',
            'sort_order' => 4,
        ]);

        $catBus = VehicleCategory::create([
            'name' => 'Big Bus',
            'slug' => 'big-bus',
            'description' => 'Bus Pariwisata ukuran besar dengan kapasitas maksimal, fasilitas AC, TV, Karaoke, untuk liburan skala besar.',
            'icon' => 'truck',
            'sort_order' => 5,
        ]);

        // 5. Create Vehicles
        $vehicleAgya = Vehicle::create([
            'vehicle_category_id' => $catCity->id,
            'name' => 'Toyota Agya',
            'brand' => 'Toyota',
            'model' => 'Agya GR Sport',
            'plate_number' => 'D 1412 ABY',
            'year' => 2022,
            'capacity' => 4,
            'fuel_type' => 'bensin',
            'transmission' => 'manual',
            'color' => 'Putih',
            'features' => ['AC Dingin', 'Audio Bluetooth', 'USB Charger', 'Dual SRS Airbag'],
            'daily_price' => 350000,
            'hourly_price' => 45000,
            'airport_price' => 250000,
            'status' => 'available',
            'last_service_date' => now()->subMonths(1),
            'next_service_date' => now()->addMonths(2),
        ]);

        $vehicleAvanza = Vehicle::create([
            'vehicle_category_id' => $catMpv->id,
            'name' => 'Toyota Avanza',
            'brand' => 'Toyota',
            'model' => 'All New Avanza',
            'plate_number' => 'D 1775 CD',
            'year' => 2023,
            'capacity' => 6,
            'fuel_type' => 'bensin',
            'transmission' => 'manual',
            'color' => 'Hitam Metalik',
            'main_image' => 'vehicles/avanza.png',
            'features' => ['Double Blower AC', 'Touch Screen Audio', 'Power Outlet', 'USB Port', 'ISOFIX'],
            'daily_price' => 550000,
            'hourly_price' => 65000,
            'airport_price' => 350000,
            'status' => 'available',
            'last_service_date' => now()->subMonths(2),
            'next_service_date' => now()->addMonth(),
        ]);

        $vehicleHiace = Vehicle::create([
            'vehicle_category_id' => $catHiace->id,
            'name' => 'Toyota Hiace Commuter',
            'brand' => 'Toyota',
            'model' => 'Hiace Commuter',
            'plate_number' => 'D 7122 HI',
            'year' => 2022,
            'capacity' => 14,
            'fuel_type' => 'solar',
            'transmission' => 'manual',
            'color' => 'Silver',
            'main_image' => 'vehicles/hiace.png',
            'features' => ['Reclining Seats', 'Air Conditioner', 'Audio System', 'USB Charging Port', 'Cool Box', 'Kabin Luas'],
            'daily_price' => 950000,
            'hourly_price' => 120000,
            'airport_price' => 650000,
            'status' => 'available',
            'last_service_date' => now()->subMonths(1),
            'next_service_date' => now()->addMonths(2),
        ]);

        $vehicleAlphard = Vehicle::create([
            'vehicle_category_id' => $catLuxury->id,
            'name' => 'Toyota Alphard Vellfire',
            'brand' => 'Toyota',
            'model' => 'Alphard Vellfire G',
            'plate_number' => 'B 1 BYL',
            'year' => 2023,
            'capacity' => 7,
            'fuel_type' => 'bensin',
            'transmission' => 'automatic',
            'color' => 'Hitam Premium',
            'main_image' => 'vehicles/alphard.png',
            'features' => ['Pilot Seat Luxury', 'Dual Sunroof', 'Ambient Lights', 'JBL Premium Audio', 'Wireless Charger', 'Suspensi Udara'],
            'daily_price' => 1500000,
            'hourly_price' => 200000,
            'airport_price' => 950000,
            'status' => 'available',
            'last_service_date' => now()->subMonths(3),
            'next_service_date' => now()->addMonth(),
        ]);

        $vehicleBigBus = Vehicle::create([
            'vehicle_category_id' => $catBus->id,
            'name' => 'Jetbus Big Bus Pariwisata',
            'brand' => 'Hino',
            'model' => 'Jetbus 3+ HDD',
            'plate_number' => 'D 9955 BUS',
            'year' => 2021,
            'capacity' => 50,
            'fuel_type' => 'solar',
            'transmission' => 'manual',
            'color' => 'Putih/Biru Striping',
            'main_image' => 'vehicles/bigbus.png',
            'features' => ['Karaoke & TV System', 'Full AC', 'Reclining Seats 2-2', 'Charger HP', 'Bagasi Ekstra Luas', 'Cooler Box'],
            'daily_price' => 2500000,
            'hourly_price' => 350000,
            'airport_price' => 1800000,
            'status' => 'available',
            'last_service_date' => now()->subMonths(2),
            'next_service_date' => now()->addMonths(4),
        ]);

        // 6. Create Transport Services
        TransportService::create([
            'title' => 'Sewa Mobil Harian',
            'slug' => 'sewa-mobil-harian',
            'short_description' => 'Layanan sewa mobil harian, mingguan atau bulanan dengan pilihan armada terbaik.',
            'description' => 'Kami menawarkan berbagai pilihan mobil dari city car yang lincah hingga MPV keluarga yang luas untuk disewa harian, mingguan, atau bulanan. Dilengkapi opsi dengan pengemudi ramah berpengalaman maupun lepas kunci untuk privasi perjalanan maksimal.',
            'image' => 'services/sewa-mobil.png',
            'icon' => 'car',
            'service_type' => 'rental_car',
            'price_start_from' => 350000,
            'features' => ['Armada Bersih & Terawat', 'Pilihan Transmisi Manual/Matik', 'Dukungan Darurat Jalan 24 Jam', 'Asuransi Kendaraan Lengkap'],
            'includes' => ['Mobil Bersih', 'Driver Berpengalaman (bila dipilih)', 'Peralatan Keamanan Sandar'],
            'suitable_for' => ['Perjalanan Keluarga', 'Urusan Bisnis', 'Acara Pernikahan/Wisuda', 'Kebutuhan Harian'],
            'terms' => 'Pemesanan minimal dilakukan 12 jam sebelum penjemputan. Pembatalan kurang dari 6 jam dikenakan biaya administrasi.',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        TransportService::create([
            'title' => 'Travel Antar Kota',
            'slug' => 'travel-antar-kota',
            'short_description' => 'Layanan perjalanan antar kota terjadwal dengan armada nyaman, aman, dan tepat waktu.',
            'description' => 'Rasakan pengalaman perjalanan rute populer antarkota dengan aman dan nyaman tanpa lelah menyetir sendiri. Dilengkapi jadwal keberangkatan fleksibel, kursi reclining yang ergonomis, sistem pendingin udara prima, serta pengantaran door-to-door yang praktis.',
            'image' => 'services/travel-kota.png',
            'icon' => 'map-pin',
            'service_type' => 'travel_route',
            'price_start_from' => 180000,
            'features' => ['Layanan Door to Door', 'Jadwal Pasti Tepat Waktu', 'Reclining Seat Mewah', 'Free Air Mineral & Masker'],
            'includes' => ['Tiket Perjalanan', 'Bensin, Tol, dan Driver', 'Reclining Seat', 'Air Mineral'],
            'suitable_for' => ['Pekerja Komuter', 'Mahasiswa Pulang Kampung', 'Pemudik Liburan', 'Pebisnis Mobile'],
            'terms' => 'Tiket hanya berlaku sesuai jadwal tertera. Keterlambatan kedatangan penumpang di titik jemput maksimal 10 menit.',
            'status' => 'active',
            'sort_order' => 2,
        ]);

        TransportService::create([
            'title' => 'Antar Jemput Bandara',
            'slug' => 'antar-jemput-bandara',
            'short_description' => 'Layanan antar jemput bandara 24/7 prima, tepat waktu, bebas stres, dan nyaman.',
            'description' => 'Pastikan Anda tiba di bandara tepat waktu atau disambut dengan ramah setelah penerbangan melelahkan. Driver kami memonitor jadwal penerbangan Anda sehingga kedatangan tepat waktu dijamin. Tidak perlu antre taksi umum yang panjang.',
            'image' => 'services/airport.png',
            'icon' => 'plane',
            'service_type' => 'airport_transfer',
            'price_start_from' => 250000,
            'features' => ['Airport Meet & Greet', 'Monitor Jadwal Flight Realtime', 'Bebas Antre Taksi Bandara', 'Tarif Flat Sudah Termasuk Tol/Parkir'],
            'includes' => ['Bensin & Biaya Tol Utama', 'Driver & Biaya Parkir Bandara', 'Air Mineral', 'Maksimal Kapasitas Bagasi'],
            'suitable_for' => ['Eksekutif/Pebisnis', 'Wisatawan Mancanegara/Domestik', 'Keluarga Berlibur', 'Penjemputan Tamu VIP'],
            'terms' => 'Pemesanan minimal dilakukan 6 jam sebelum keberangkatan. Harap menginformasikan nomor penerbangan saat melakukan booking.',
            'status' => 'active',
            'sort_order' => 3,
        ]);

        TransportService::create([
            'title' => 'Charter Kendaraan',
            'slug' => 'charter-kendaraan',
            'short_description' => 'Sewa kendaraan komplit (bensin + driver) untuk rombongan, wisata, atau event khusus.',
            'description' => 'Solusi transportasi private fleksibel untuk acara rombongan keluarga, perjalanan wisata ziarah, dinas instansi pemerintah, rombongan perkawinan, hingga event olahraga besar. Tersedia pilihan bus pariwisata berfasilitas mewah, Hiace, maupun Elf modern.',
            'image' => 'services/charter.png',
            'icon' => 'users',
            'service_type' => 'charter',
            'price_start_from' => 950000,
            'features' => ['Rute Perjalanan Bebas Custom', 'Kapasitas Hingga 50 Penumpang', 'Fasilitas Karaoke & LCD TV', 'Driver Spesialis Luar Kota'],
            'includes' => ['Kendaraan Premium', 'Bensin / Solar Penuh', 'Driver Berpengalaman'],
            'suitable_for' => ['Rombongan Wisata', 'Ziarah Keagamaan', 'Iring-iringan Pengantin', 'Corporate Outing'],
            'terms' => 'Tarif charter bervariasi sesuai jarak rute tujuan dan jumlah hari. Deposit minimal 30% dari total tagihan saat deal pemesanan.',
            'status' => 'active',
            'sort_order' => 4,
        ]);

        TransportService::create([
            'title' => 'Wisata & Tour',
            'slug' => 'wisata-tour',
            'short_description' => 'Paket wisata terintegrasi dengan kendaraan premium nyaman dan driver berpengalaman.',
            'description' => 'Nikmati liburan seru tanpa pusing menyusun itinerary. Kami menyediakan paket tour lengkap dengan kendaraan pariwisata nyaman, sopir merangkap guide lokal ramah, serta destinasi wisata ikonik di berbagai kota besar di Indonesia.',
            'image' => 'services/wisata.png',
            'icon' => 'compass',
            'service_type' => 'tour_transport',
            'price_start_from' => 1200000,
            'features' => ['Itinerary Terencana Lengkap', 'Driver Merangkap Guide Lokal', 'Pilihan Rute Wisata Menarik', 'Fleksibel Atur Waktu Kunjungan'],
            'includes' => ['Kendaraan, Bensin, Tol, Parkir', 'Driver / Guide Lokal', 'Rekomendasi Kuliner Enak'],
            'suitable_for' => ['Liburan Keluarga', 'Studi Tour Sekolah', 'Kunjungan Kerja Sambil Wisata', 'Gathering Perusahaan'],
            'terms' => 'Harga tidak termasuk tiket masuk wahana wisata dan makan pribadi kecuali dicantumkan dalam klausul kontrak tertulis.',
            'status' => 'active',
            'sort_order' => 5,
        ]);

        TransportService::create([
            'title' => 'Transportasi Corporate',
            'slug' => 'transportasi-corporate',
            'short_description' => 'Solusi layanan kontrak transportasi bulanan untuk karyawan, ekspatriat, dan logistik kantor.',
            'description' => 'Kami menyediakan layanan kontrak eksklusif jangka panjang untuk menunjang operasional perusahaan Anda. Mulai dari mobil dinas eksekutif VIP untuk jajaran direksi, antar jemput harian karyawan pabrik/kantor, hingga pengiriman logistik ringan.',
            'image' => 'services/corporate.png',
            'icon' => 'briefcase',
            'service_type' => 'corporate_transport',
            'price_start_from' => 5000000,
            'features' => ['Sistem Pembayaran Bulanan / Invoice', 'Mobil Pengganti Instan bila Maintenance', 'Driver Berseragam Profesional', 'Laporan Operasional Bulanan Terstruktur'],
            'includes' => ['Mobil Khusus & Pajak Kendaraan', 'Driver Profesional Tersertifikasi', 'Perawatan Rutin Bengkel Resmi'],
            'suitable_for' => ['Perusahaan Nasional/BUMN', 'Kedutaan & Tamu Asing', 'Antar Jemput Staff Kantor', 'Logistik Logam/Dokumen'],
            'terms' => 'Pemesanan korporat memerlukan ikatan kontrak resmi minimal 6 bulan. Proses verifikasi dokumen perusahaan membutuhkan waktu 3 hari kerja.',
            'status' => 'active',
            'sort_order' => 6,
        ]);

        // 7. Create Routes
        $route1 = Route::create([
            'origin_city' => 'Bandung',
            'destination_city' => 'Jakarta',
            'slug' => 'bandung-to-jakarta',
            'distance_km' => 150,
            'estimated_duration' => '3 Jam',
            'base_price' => 180000,
            'description' => 'Rute populer Bandung ke Jakarta via Tol Cipularang. Titik naik utama di Pool Bylian Pasteur Bandung, titik turun utama di Pool Semanggi Jakarta.',
            'pickup_points' => ['Pool Bylian Pasteur', 'Cipaganti', 'Dago (Spesial)', 'Bandara Husein Sastranegara'],
            'dropoff_points' => ['Pool Bylian Semanggi', 'Kuningan', 'Bandara Halim Perdanakusuma', 'Stasiun Gambir'],
            'status' => 'active',
        ]);

        $route2 = Route::create([
            'origin_city' => 'Bandung',
            'destination_city' => 'Bandara Soekarno Hatta',
            'slug' => 'bandung-to-bandara-soekarno-hatta',
            'distance_km' => 180,
            'estimated_duration' => '3.5 Jam',
            'base_price' => 250000,
            'description' => 'Rute khusus shuttle bandara Bandung langsung menuju Terminal 1, 2, dan 3 Bandara Internasional Soekarno-Hatta (CGK).',
            'pickup_points' => ['Pool Bylian Pasteur', 'Pool Bylian Buah Batu', 'Rumah Pelanggan (Extra Charge)'],
            'dropoff_points' => ['Terminal 1 CGK', 'Terminal 2 CGK', 'Terminal 3 CGK'],
            'status' => 'active',
        ]);

        // 8. Create Schedules
        Schedule::create([
            'route_id' => $route1->id,
            'vehicle_id' => $vehicleHiace->id,
            'driver_id' => $driver1->id,
            'departure_date' => now()->toDateString(),
            'departure_time' => '08:00:00',
            'arrival_estimation' => '11:00:00',
            'available_seats' => 14,
            'total_seats' => 14,
            'price' => 180000,
            'status' => 'open',
        ]);

        Schedule::create([
            'route_id' => $route1->id,
            'vehicle_id' => $vehicleAlphard->id,
            'driver_id' => $driver2->id,
            'departure_date' => now()->addDay()->toDateString(),
            'departure_time' => '14:00:00',
            'arrival_estimation' => '17:00:00',
            'available_seats' => 7,
            'total_seats' => 7,
            'price' => 180000,
            'status' => 'open',
        ]);

        // 9. Create FAQs
        Faq::create([
            'question' => 'Apakah bisa melakukan booking lewat WhatsApp?',
            'answer' => 'Ya, tentu saja sangat bisa. Anda cukup mengeklik tombol WhatsApp melayang di pojok kanan bawah, atau klik tombol "Pesan via WhatsApp" di formulir. Customer service kami siap membantu mencatat dan memproses pesanan Anda dalam hitungan menit secara responsif.',
            'category' => 'Booking',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        Faq::create([
            'question' => 'Apakah harga sewa mobil sudah termasuk driver?',
            'answer' => 'Seluruh paket harga sewa mobil standar yang kami tampilkan di website sudah termasuk dengan jasa driver profesional kami yang ramah dan berpengalaman. Untuk beberapa jenis armada tertentu, kami juga melayani sistem sewa lepas kunci dengan syarat dan ketentuan dokumen verifikasi khusus.',
            'category' => 'Sewa Mobil',
            'status' => 'active',
            'sort_order' => 2,
        ]);

        Faq::create([
            'question' => 'Bagaimana sistem pembayaran perjalanan di Bylian Transportasi?',
            'answer' => 'Pembayaran dapat dilakukan dengan mudah melalui transfer bank ke rekening resmi kami (Mandiri, BCA, BRI) maupun pembayaran instan via scan QRIS. Setelah mengirimkan transfer, harap melakukan upload bukti pembayaran di halaman invoice atau via WhatsApp kami untuk verifikasi instan dari tim finance.',
            'category' => 'Pembayaran',
            'status' => 'active',
            'sort_order' => 3,
        ]);

        Faq::create([
            'question' => 'Apakah bisa melakukan reschedule atau pembatalan jadwal?',
            'answer' => 'Reschedule jadwal atau perubahan titik penjemputan diperbolehkan maksimal 12 jam sebelum jadwal keberangkatan tanpa dikenakan biaya tambahan. Untuk pembatalan sepihak kurang dari 6 jam sebelum keberangkatan, dana yang sudah ditransfer akan hangus atau dikenakan potongan administrasi sebesar 50%.',
            'category' => 'Pembatalan',
            'status' => 'active',
            'sort_order' => 4,
        ]);

        Faq::create([
            'question' => 'Apakah armada selalu dibersihkan sebelum bertolak?',
            'answer' => 'Kesehatan, keamanan, dan kenyamanan Anda adalah prioritas mutlak kami. Setiap armada mobil, minibus, maupun bus pariwisata yang kami kelola wajib melewati tahap pembersihan eksterior, disinfeksi interior, serta pemeriksaan AC dan tekanan ban secara ketat oleh tim mekanik kami sebelum berangkat menjemput Anda.',
            'category' => 'Armada',
            'status' => 'active',
            'sort_order' => 5,
        ]);

        // 10. Create Testimonials
        Testimonial::create([
            'customer_name' => 'Andi Pratama',
            'customer_position' => 'Pebisnis Mandiri',
            'message' => 'Layanan travel sangat memuaskan! Driver ramah, tepat waktu, mobil selalu bersih, dan wangi sepanjang perjalanan Bandung-Jakarta. Pasti akan berlangganan lagi.',
            'rating' => 5,
            'service_type' => 'Travel Antar Kota',
            'photo' => 'testimonials/andi.jpg',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        Testimonial::create([
            'customer_name' => 'Siti Rahmawati',
            'customer_position' => 'Ibu Rumah Tangga',
            'message' => 'Antar jemput bandaranya tepat waktu banget, jadi saya tidak khawatir ketinggalan pesawat. Proses booking via website sangat simpel dan praktis. Recommended!',
            'rating' => 5,
            'service_type' => 'Antar Jemput Bandara',
            'photo' => 'testimonials/siti.jpg',
            'status' => 'active',
            'sort_order' => 2,
        ]);

        Testimonial::create([
            'customer_name' => 'Budi Santoso',
            'customer_position' => 'Manager, PT Jaya Bersama',
            'message' => 'Sewa Hiace Commuter untuk perjalanan wisata keluarga besar kemarin berjalan dengan lancar. Kendaraannya terawat, suspensinya empuk, AC dingin, dan sopirnya mengemudi dengan sangat hati-hati.',
            'rating' => 5,
            'service_type' => 'Charter Kendaraan',
            'photo' => 'testimonials/budi.jpg',
            'status' => 'active',
            'sort_order' => 3,
        ]);

        // 11. Create Website Setting
        WebsiteSetting::create([
            'site_name' => 'Bylian Transportasi',
            'site_tagline' => 'Solusi Transportasi Aman, Nyaman, dan Tepat Waktu',
            'site_description' => 'Layanan travel antar kota, rental mobil eksklusif, charter minibus/bus pariwisata, antar jemput bandara door-to-door dengan driver bersertifikasi profesional dan armada terbaru.',
            'logo' => 'settings/logo.png',
            'favicon' => 'settings/favicon.png',
            'phone' => '0812-3456-7890',
            'whatsapp_number' => '081234567890',
            'email' => 'info@byliantransportasi.com',
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta',
            'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.196328734045!2d106.8183042!3d-6.177682!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2db8c8d37%3A0x7d6f5df5df586d5d!2sMonumen%20Nasional!5e0!3m2!1sid!2sid!4v1700000000000" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'instagram_url' => 'https://instagram.com/byliantransportasi',
            'facebook_url' => 'https://facebook.com/byliantransportasi',
            'tiktok_url' => 'https://tiktok.com/@byliantransportasi',
            'business_hours' => 'Senin - Minggu (24 Jam)',
            'footer_text' => 'Bylian Transportasi berkomitmen memberikan layanan perjalanan premium terbaik dengan armada terawat dan supir tersertifikasi demi kenyamanan maksimal perjalanan Anda.',
            'meta_title' => 'Bylian Transportasi | Layanan Travel, Rental Mobil & Charter Pariwisata Premium',
            'meta_description' => 'Sewa mobil harian dengan driver, antar jemput bandara Halim/Soekarno-Hatta, travel rute Bandung-Jakarta PP, sewa Hiace/Bus pariwisata harga terbaik dan armada bersih terawat.',
            'meta_keywords' => 'travel bandung jakarta, rental mobil bandung, sewa mobil jakarta, antar jemput bandara cgk, sewa hiace bandung, bus pariwisata murah, bylian transportasi',
        ]);

        // 12. Create WhatsApp Setting
        WhatsappSetting::create([
            'phone_number' => '081234567890',
            'default_message' => "Halo Bylian Transportasi, saya ingin bertanya mengenai layanan perjalanan transportasi Anda.",
            'booking_message' => "Halo Bylian Transportasi, saya ingin konfirmasi booking layanan dengan data berikut:\n\nKode Booking: {booking_code}\nNama: {customer_name}\nLayanan: {service_title}\nTanggal Penjemputan: {pickup_date}\nJam Penjemputan: {pickup_time}\nLokasi Jemput: {pickup_location}\nTujuan: {dropoff_location}\nTotal Harga: {total_price}\n\nMohon dibantu konfirmasi pesanannya ya.",
            'charter_message' => "Halo Bylian Transportasi, saya telah mengajukan permintaan penawaran charter kendaraan:\n\nNama: {name}\nTelepon: {phone}\nJenis Trip: {trip_type}\nLokasi Jemput: {pickup_location}\nKota Tujuan: {destination}\nTanggal Keberangkatan: {departure_date}\nJumlah Penumpang: {passenger_count}\nJenis Kendaraan: {vehicle_preference}\n\nMohon berikan rincian harga terbaik untuk sewa kami. Terima kasih.",
            'payment_message' => "Halo Finance Bylian Transportasi, saya ingin melampirkan bukti transfer untuk booking {booking_code} atas nama {customer_name} sebesar {amount}. Mohon dibantu verifikasi dan update statusnya.",
            'driver_message' => "Pemberitahuan Tugas Perjalanan!\n\nSopir: {driver_name}\nKendaraan: {vehicle_name} ({plate_number})\nRute Perjalanan: {route_title}\nTanggal Berangkat: {departure_date} - {departure_time}\nJumlah Penumpang: {passenger_count}\n\nSelamat bertugas, selalu utamakan keselamatan berkendara!",
            'is_active' => true,
        ]);
    }
}
