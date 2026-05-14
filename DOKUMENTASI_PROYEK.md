# Dokumentasi Proyek: Bylian Transportasi

## 1. Pendahuluan & Tujuan Proyek
**Bylian Transportasi** adalah platform digital modern yang dirancang khusus untuk industri layanan transportasi premium. Proyek ini bertujuan untuk menyediakan solusi "all-in-one" bagi pelanggan yang membutuhkan layanan sewa mobil, travel antar kota, dan charter kendaraan dengan standar eksekutif.

### Tujuan Utama:
*   **Transformasi Digital**: Mengubah sistem pemesanan konvensional menjadi otomatis dan berbasis data.
*   **Pengalaman Pengguna Premium**: Memberikan antarmuka yang mewah (Glassmorphism) dan responsif untuk meningkatkan kepercayaan pelanggan.
*   **Otomasi Pembayaran**: Mengintegrasikan sistem pembayaran langsung untuk mempercepat proses konfirmasi jadwal armada.
*   **Efisiensi Manajemen**: Memberikan panel admin yang kuat untuk mengelola rute, harga, dan ketersediaan armada secara real-time.

---

## 2. Teknologi yang Digunakan (Tech Stack)

### **Frontend (Sisi Pengguna)**
Membangun pengalaman visual yang cepat dan interaktif menggunakan teknologi terbaru:
*   **Next.js 15 (App Router)**: Framework React terbaik untuk performa tinggi, SEO yang optimal, dan rendering yang sangat cepat.
*   **Tailwind CSS**: Digunakan untuk desain UI kustom yang konsisten dengan pendekatan "Utility-First".
*   **Framer Motion**: Untuk animasi transisi dan mikro-interaksi yang memberikan kesan premium.
*   **Lenis Scroll**: Teknologi *Smooth Scrolling* untuk navigasi yang terasa sangat halus di semua browser.
*   **Lucide Icons**: Ikonografi berbasis vektor (SVG) yang ringan dan tajam.

### **Backend (Sisi Server & Database)**
Mengelola logika bisnis, database, dan keamanan data:
*   **Laravel 11**: Framework PHP modern yang menjamin keamanan tingkat tinggi dan struktur kode yang rapi.
*   **Filament PHP v3**: Panel admin berbasis TALL-stack yang sangat canggih untuk mengelola data operasional (Booking, Customer, Fleet, Schedule).
*   **MySQL**: Sistem manajemen database relasional untuk menyimpan data rute, transaksi, dan pengaturan website.
*   **RESTful API**: Arsitektur yang memisahkan antara frontend dan backend, memungkinkan pengembangan aplikasi mobile (Android/iOS) di masa depan dengan basis data yang sama.

---

## 3. Fitur Utama Website

### **Bagi Pelanggan:**
1.  **Quick Booking Widget**: Form pemesanan cepat di halaman utama untuk kemudahan akses.
2.  **Multi-Step Booking Wizard**: Proses pemesanan 4 langkah yang terorganisir (Trip -> Armada -> Klien -> Konfirmasi).
3.  **Real-Time Route Showcase**: Menampilkan rute-rute terpopuler dengan detail jarak dan estimasi waktu.
4.  **Automatic Payment (Midtrans)**: Pembayaran otomatis menggunakan kartu kredit, transfer bank (VA), atau e-wallet (Gopay/ShopeePay).
5.  **WhatsApp Integration**: Tombol konfirmasi langsung ke customer service untuk bantuan personal.

### **Bagi Admin (Panel Kendali):**
1.  **Manajemen Armada**: Menambah, mengedit, dan memantau status kendaraan (tersedia/disewa).
2.  **Manajemen Rute & Harga**: Pengaturan fleksibel untuk rute antar kota dan tarif layanan.
3.  **Monitoring Transaksi**: Melihat riwayat booking dan status pembayaran secara real-time.
4.  **Laporan Operasional**: Data pesanan masuk yang terintegrasi dengan data pelanggan.

---

## 4. Integrasi Sistem Pembayaran (Midtrans)
Platform ini menggunakan **Midtrans Snap SDK** untuk menangani transaksi keuangan secara aman.
*   **Proses**: Setelah user melakukan booking, sistem akan menghasilkan *Snap Token*.
*   **Antarmuka**: Popup pembayaran akan muncul tanpa meninggalkan website (Snap UI).
*   **Otomasi Status**: Menggunakan *Webhook/Callback*, sistem akan otomatis mengubah status pesanan dari "Unpaid" menjadi "Paid" segera setelah pembayaran berhasil diverifikasi oleh bank.

---

## 5. Kesimpulan
Website **Bylian Transportasi** bukan sekadar halaman informasi, melainkan alat bisnis digital yang lengkap. Dengan kombinasi **Next.js** di sisi visual dan **Laravel** di sisi manajemen data, platform ini siap untuk menangani volume transaksi tinggi dengan performa yang tetap stabil dan desain yang tetap memukau.

---
*Dibuat oleh Antigravity untuk Bylian Transportasi.*
