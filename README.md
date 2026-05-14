# 🚐 Bylian Transportasi - Premium Booking System

<p align="center">
  <img src="https://img.shields.io/badge/Next.js-15-black?style=for-the-badge&logo=next.js" alt="Next.js">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## ✨ Tentang Proyek
**Bylian Transportasi** adalah platform reservasi transportasi premium yang menggabungkan kemewahan visual dengan fungsionalitas tingkat tinggi. Dibangun menggunakan arsitektur *Headless*, proyek ini memisahkan pengalaman visual pengguna (**Next.js**) dengan sistem manajemen data yang tangguh (**Laravel & Filament**).

> "Menyediakan layanan sewa mobil, travel, dan charter eksekutif dengan pengalaman digital yang mulus."

---

## 🚀 Fitur Unggulan

- 💎 **Premium UI/UX**: Antarmuka berbasis *Glassmorphism* yang modern dan responsif di semua perangkat.
- ⚡ **Instant Rendering**: Optimasi performa menggunakan server-side rendering dan instant fallback.
- 🛠️ **Advanced Admin Panel**: Dashboard lengkap untuk mengelola armada, rute, dan pesanan secara real-time.
- 💳 **Automated Payment**: Integrasi penuh dengan **Midtrans** untuk pembayaran otomatis dan aman.
- 📱 **WhatsApp Seamless Integration**: Menghubungkan pelanggan langsung dengan CS untuk koordinasi cepat.
- 🗺️ **Dynamic Routes**: Peta rute populer yang informatif dan interaktif.

---

## 🛠️ Tech Stack

### **Frontend**
*   **Core**: [Next.js 15](https://nextjs.org/) (App Router)
*   **Styling**: [Tailwind CSS](https://tailwindcss.com/)
*   **Animation**: [Framer Motion](https://www.framer.com/motion/)
*   **Icons**: [Lucide React](https://lucide.dev/)
*   **Smooth Scroll**: [Lenis](https://github.com/darkroomengineering/lenis)

### **Backend**
*   **Framework**: [Laravel 11](https://laravel.com/)
*   **Admin Panel**: [Filament PHP v3](https://filamentphp.com/)
*   **Payment Gateway**: [Midtrans SDK](https://midtrans.com/)
*   **Database**: MySQL

---

## 📦 Panduan Instalasi

### 1. Prasyarat
*   PHP >= 8.2
*   Node.js >= 18
*   Composer
*   MySQL

### 2. Setup Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=8080
```

### 3. Setup Frontend (Next.js)
```bash
cd frontend
npm install
cp .env.example .env.local
npm run dev
```

---

## 🛠️ Konfigurasi Midtrans
Pastikan Anda telah mengisi Access Keys di file `.env` (Backend) dan `.env.local` (Frontend):
*   `MIDTRANS_SERVER_KEY`
*   `MIDTRANS_CLIENT_KEY`

---

## 🤝 Kontribusi
Kontribusi selalu terbuka! Jika Anda ingin meningkatkan proyek ini, silakan buat *Pull Request* atau buka *Issue*.

---

## 👤 Author
*   **Abymanyu Nur Wakhid Rokhiim** - *Lead Developer* - [GitHub Profile](https://github.com/AbymanyuNWR)

---
<p align="center">
  Dibuat dengan ❤️ untuk industri transportasi Indonesia yang lebih baik.
</p>
