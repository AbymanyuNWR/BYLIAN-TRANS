"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { CheckCircle2, MessageSquare, Home, ArrowRight, ShieldCheck, CreditCard } from "lucide-react";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { api } from "@/lib/api";

declare global {
  interface Window {
    snap: any;
  }
}

export default function BookingSuccessPage() {
  const router = useRouter();
  const [bookingId, setBookingId] = useState<string | null>(null);
  const [bookingCode, setBookingCode] = useState("BYT-XXXXXXXX-XXXX");
  const [totalPrice, setTotalPrice] = useState("0");
  const [isPaying, setIsPaying] = useState(false);

  useEffect(() => {
    // Gather recently created booking attributes from sessionStorage
    const id = sessionStorage.getItem("recent_booking_id");
    const code = sessionStorage.getItem("recent_booking_code");
    const price = sessionStorage.getItem("recent_booking_price");

    if (id) setBookingId(id);
    if (code) setBookingCode(code);
    if (price) {
      setTotalPrice(Number(price).toLocaleString("id-ID"));
    }
  }, []);

  const handlePayment = async () => {
    if (!bookingId) {
      alert("ID Pemesanan tidak ditemukan.");
      return;
    }

    setIsPaying(true);
    try {
      if (!window.snap) {
        alert("Sistem pembayaran (Snap.js) belum termuat. Harap periksa koneksi internet Anda.");
        setIsPaying(false);
        return;
      }

      const res = await api.createSnapToken({ booking_id: bookingId });
      
      if (res.success && res.data.snap_token) {
        window.snap.pay(res.data.snap_token, {
          onSuccess: function(result: any) {
            console.log('Payment success:', result);
            alert("Pembayaran Berhasil!");
            router.push('/');
          },
          onPending: function(result: any) {
            console.log('Payment pending:', result);
            alert("Pembayaran sedang diproses (Pending).");
          },
          onError: function(result: any) {
            console.error('Payment error:', result);
            alert("Terjadi kesalahan pada pembayaran.");
          },
          onClose: function() {
            console.log('Customer closed the popup without finishing the payment');
          }
        });
      } else {
        alert("Gagal mengambil token pembayaran: " + (res.message || "Unknown error"));
      }
    } catch (error: any) {
      const errorMsg = error.response?.data?.message || error.message || "Gagal terhubung ke sistem pembayaran.";
      alert("Error: " + errorMsg);
    } finally {
      setIsPaying(false);
    }
  };

  // WhatsApp redirection url composed of booking credentials
  const waNumber = "6281234567890";
  const waMessage = encodeURIComponent(
    `Halo CS Bylian Trans,\n\nSaya ingin mengonfirmasi booking perjalanan saya.\n\n` +
    `*Kode Booking:* ${bookingCode}\n` +
    `*Total Tagihan:* Rp ${totalPrice}\n\n` +
    `Mohon info ketersediaan driver & tata cara penyelesaian deposit (DP) lebih lanjut. Terima kasih!`
  );
  const waUrl = `https://wa.me/${waNumber}?text=${waMessage}`;

  return (
    <>
      <Navbar />

      <main className="bg-gradient-hero min-h-screen pt-32 pb-20 flex items-center justify-center relative overflow-hidden">
        {/* Glow ambient background lights */}
        <div className="absolute top-1/2 left-1/2 w-[400px] h-[400px] bg-cta-orange/10 rounded-full blur-[120px] transform -translate-x-1/2 -translate-y-1/2 pointer-events-none" />

        <div className="max-w-2xl mx-auto px-6 w-full relative z-10">
          <div className="glass-panel p-10 sm:p-14 rounded-[32px] border border-white/10 flex flex-col items-center text-center gap-6 relative overflow-hidden shadow-3xl">
            <div className="absolute top-0 left-0 w-full h-[4px] bg-gradient-to-r from-transparent via-green-400 to-transparent" />

            {/* Pulsing Success Circle Icon */}
            <div className="w-20 h-20 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center text-green-400 mb-2 shadow-[0_0_20px_rgba(34,197,94,0.1)]">
              <CheckCircle2 size={44} className="animate-pulse" />
            </div>

            {/* Titles */}
            <h1 className="font-accent text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">
              Booking Berhasil <span className="text-green-400">Diajukan!</span>
            </h1>

            <p className="text-xs sm:text-sm text-muted-text max-w-md leading-relaxed">
              Pemesanan Anda berhasil kami catat. Untuk mengunci jadwal armada, silakan lakukan pembayaran sekarang.
            </p>

            {/* Booking Details Card Sheet */}
            <div className="w-full bg-secondary-dark/60 border border-white/5 p-6 rounded-2xl flex flex-col gap-4 text-xs sm:text-sm my-2 text-left">
              <div className="flex items-center justify-between border-b border-white/5 pb-3">
                <span className="text-muted-text">Kode Booking</span>
                <strong className="text-gold font-accent tracking-wider font-extrabold">{bookingCode}</strong>
              </div>
              <div className="flex items-center justify-between border-b border-white/5 pb-3">
                <span className="text-muted-text">Estimasi Harga</span>
                <strong className="text-white">Rp {totalPrice}</strong>
              </div>
              <div className="flex items-center justify-between">
                <span className="text-muted-text">Status Pesanan</span>
                <span className="text-xs font-bold text-yellow-400 bg-yellow-500/10 px-3 py-1 rounded-full border border-yellow-500/10">
                  Menunggu Pembayaran
                </span>
              </div>
            </div>

            {/* Action buttons CTA */}
            <div className="flex flex-col gap-4 w-full mt-4 justify-center">
              <button
                onClick={handlePayment}
                disabled={isPaying}
                className="w-full bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] px-8 py-4 rounded-xl font-black font-accent text-primary-dark shadow-xl shadow-amber-500/20 flex items-center justify-center gap-2.5 transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:transform-none"
              >
                <CreditCard size={18} />
                <span>{isPaying ? "Memproses..." : "Bayar Sekarang (Otomatis)"}</span>
              </button>

              <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full">
                <Link
                  href={waUrl}
                  target="_blank"
                  className="flex-1 bg-white/5 border border-white/10 hover:bg-white/10 px-8 py-3.5 rounded-xl font-bold font-accent text-white flex items-center justify-center gap-2.5 transition-all duration-300"
                >
                  <MessageSquare size={16} className="text-green-400" />
                  <span>Konfirmasi via WA</span>
                </Link>
                <Link
                  href="/"
                  className="flex-1 border border-white/10 bg-white/5 hover:bg-white/10 px-8 py-3.5 rounded-xl font-bold font-accent text-white flex items-center justify-center gap-2 transition-all duration-300"
                >
                  <Home size={14} className="text-electric-blue" />
                  <span>Kembali</span>
                </Link>
              </div>
            </div>

            <div className="flex items-center gap-1.5 text-[9px] text-muted-text uppercase font-semibold mt-4">
              <ShieldCheck size={12} className="text-green-400" />
              <span>Pembayaran Aman & Terverifikasi Otomatis</span>
            </div>
          </div>
        </div>
      </main>

      <Footer />
    </>
  );
}
