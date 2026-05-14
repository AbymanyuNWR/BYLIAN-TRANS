"use client";

import { useState } from "react";
import { Search, Calendar, MapPin, Clock, User, Car, ShieldCheck, Ticket, CreditCard, ChevronRight } from "lucide-react";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import { api } from "@/lib/api";

export default function CheckBookingPage() {
  const [bookingCode, setBookingCode] = useState("");
  const [phone, setPhone] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [bookingResult, setBookingResult] = useState<any | null>(null);
  const [hasSearched, setHasSearched] = useState(false);

  const handleCheckStatus = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!bookingCode || !phone) {
      alert("Harap isi Kode Booking & Nomor WhatsApp Anda.");
      return;
    }

    setIsLoading(true);
    setHasSearched(true);

    // Setup visual tester sandbox fallback code
    if (bookingCode.toUpperCase() === "BYT-DEMO" || bookingCode.toUpperCase() === "BYT-20260512-0001") {
      setTimeout(() => {
        setBookingResult({
          booking_code: bookingCode.toUpperCase(),
          customer_name: "Bapak Muhammad Rian",
          customer_phone: phone,
          pickup_location: "Jl. Pasteur No. 12, Bandung",
          dropoff_location: "Terminal 3, Bandara Soekarno Hatta (CGK)",
          pickup_date: "2026-05-15",
          pickup_time: "05:30:00",
          booking_status: "assigned", // pending, confirmed, assigned, on_trip, completed, cancelled
          payment_status: "paid", // unpaid, waiting_verification, paid
          total_price: 650000,
          passenger_count: 3,
          notes: "Bawa koper berukuran sedang 2 buah.",
          service: { title: "Antar Jemput Bandara" },
          vehicle: { name: "Toyota Hiace Commuter", plate_number: "D 7931 BY" },
          driver: { name: "Agus Santoso", phone: "0812-9988-7766" },
        });
        setIsLoading(false);
      }, 800);
      return;
    }

    try {
      // Hit actual Laravel search API
      const res = await api.checkBookingStatus(bookingCode, phone);
      if (res.success && res.data) {
        setBookingResult(res.data);
      } else {
        setBookingResult(null);
      }
    } catch (err) {
      setBookingResult(null);
    } finally {
      setIsLoading(false);
    }
  };

  // Status mapping to localized labels and matching color classes
  const getStatusBadge = (status: string) => {
    const maps: Record<string, { label: string; color: string }> = {
      pending: { label: "Menunggu Konfirmasi", color: "bg-yellow-500/10 text-yellow-400 border-yellow-500/10" },
      confirmed: { label: "Telah Dikonfirmasi", color: "bg-blue-500/10 text-blue-400 border-blue-500/10" },
      assigned: { label: "Sopir Ditugaskan", color: "bg-indigo-500/10 text-indigo-400 border-indigo-500/10" },
      on_trip: { label: "Dalam Perjalanan", color: "bg-amber-500/10 text-amber-400 border-amber-500/10" },
      completed: { label: "Selesai", color: "bg-green-500/10 text-green-400 border-green-500/10" },
      cancelled: { label: "Dibatalkan", color: "bg-red-500/10 text-red-400 border-red-500/10" },
    };
    return maps[status] || { label: status, color: "bg-white/5 text-muted-text border-white/5" };
  };

  return (
    <>
      <Navbar />

      <main className="bg-gradient-hero min-h-screen pt-32 pb-20 relative overflow-hidden">
        {/* Lights */}
        <div className="absolute top-1/4 left-1/4 w-[350px] h-[350px] bg-electric-blue/10 rounded-full blur-[100px] pointer-events-none" />

        <div className="max-w-4xl mx-auto px-6 relative z-10 w-full flex flex-col gap-10">
          
          {/* Header titles */}
          <div className="flex flex-col items-center text-center gap-3">
            <span className="text-[11px] font-black tracking-widest text-electric-blue uppercase font-accent">
              Layanan Mandiri
            </span>
            <h1 className="font-accent text-2xl sm:text-4xl font-black text-white uppercase tracking-tight">
              Cek Status <span className="text-gradient-gold">Booking Anda</span>
            </h1>
            <p className="text-xs sm:text-sm text-muted-text max-w-md leading-relaxed mt-1">
              Masukkan Kode Booking perjalanan dan nomor WhatsApp yang digunakan untuk mengecek progres jadwal armada secara real-time.
            </p>
          </div>

          {/* Search Card Box */}
          <div className="glass-panel p-8 rounded-2xl relative overflow-hidden">
            <div className="absolute top-0 left-0 w-full h-[4px] bg-gradient-to-r from-cta-orange to-gold" />
            <form onSubmit={handleCheckStatus} className="grid grid-cols-1 sm:grid-cols-12 gap-6 items-end">
              <div className="sm:col-span-5 flex flex-col gap-1.5">
                <label className="text-xs font-bold text-foreground/80 tracking-wide uppercase font-accent flex items-center gap-1.5">
                  <Ticket size={13} className="text-cta-orange" />
                  <span>Kode Booking</span>
                </label>
                <input
                  type="text"
                  required
                  placeholder="e.g. BYT-20260512-0001 / BYT-DEMO"
                  value={bookingCode}
                  onChange={(e) => setBookingCode(e.target.value)}
                  className="w-full bg-secondary-dark border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-electric-blue font-mono uppercase tracking-wider placeholder:font-sans placeholder:normal-case"
                />
              </div>
              <div className="sm:col-span-5 flex flex-col gap-1.5">
                <label className="text-xs font-bold text-foreground/80 tracking-wide uppercase font-accent flex items-center gap-1.5">
                  <User size={13} className="text-electric-blue" />
                  <span>No. WhatsApp Pemesan</span>
                </label>
                <input
                  type="tel"
                  required
                  placeholder="e.g. 081234567890"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  className="w-full bg-secondary-dark border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-electric-blue"
                />
              </div>
              <div className="sm:col-span-2">
                <button
                  type="submit"
                  disabled={isLoading}
                  className="w-full bg-gradient-cta py-3.5 rounded-xl font-bold font-accent text-primary-dark shadow-xl flex items-center justify-center gap-1.5 text-xs cursor-pointer hover:scale-[1.02] transition-transform"
                >
                  <Search size={14} />
                  <span>{isLoading ? "Checking..." : "Cari"}</span>
                </button>
              </div>
            </form>
          </div>

          {/* Results Block */}
          {hasSearched && (
            isLoading ? (
              <div className="flex flex-col items-center justify-center py-12 gap-4 text-center">
                <div className="w-10 h-10 border-4 border-cta-orange border-t-transparent rounded-full animate-spin" />
                <span className="text-xs text-muted-text font-accent font-bold uppercase tracking-widest">Memuat database perjalanan...</span>
              </div>
            ) : bookingResult ? (
              <div className="glass-panel p-8 sm:p-10 rounded-[28px] border border-white/10 flex flex-col gap-8 relative overflow-hidden animate-fade-in">
                <div className="absolute top-0 left-0 w-full h-[4px] bg-gradient-to-r from-green-400 via-transparent to-transparent" />
                
                {/* Result header meta */}
                <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-white/5 pb-6">
                  <div>
                    <span className="text-[10px] text-muted-text font-bold uppercase tracking-wider block">Ringkasan Berkas</span>
                    <h2 className="text-xl font-accent font-black tracking-wider text-white mt-0.5">{bookingResult.booking_code}</h2>
                  </div>
                  <div className="flex flex-wrap items-center gap-3">
                    <span className={`px-4 py-1.5 rounded-full border text-xs font-bold font-accent ${getStatusBadge(bookingResult.booking_status).color}`}>
                      {getStatusBadge(bookingResult.booking_status).label}
                    </span>
                    <span className={`px-4 py-1.5 rounded-full border text-[10px] font-bold font-accent uppercase ${
                      bookingResult.payment_status === "paid" 
                        ? "bg-green-500/15 text-green-400 border-green-500/10" 
                        : "bg-white/5 text-muted-text border-white/5"
                    }`}>
                      {bookingResult.payment_status === "paid" ? "Lunas" : "Unpaid"}
                    </span>
                  </div>
                </div>

                {/* Itinerary grid info */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs sm:text-sm">
                  <div className="flex flex-col gap-4">
                    <div className="flex items-start gap-3">
                      <MapPin size={18} className="text-cta-orange shrink-0 mt-0.5" />
                      <div>
                        <span className="text-[10px] text-muted-text uppercase font-semibold">Penjemputan</span>
                        <p className="text-white font-extrabold mt-0.5">{bookingResult.pickup_location}</p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <MapPin size={18} className="text-electric-blue shrink-0 mt-0.5" />
                      <div>
                        <span className="text-[10px] text-muted-text uppercase font-semibold">Alamat Tujuan</span>
                        <p className="text-white font-extrabold mt-0.5">{bookingResult.dropoff_location}</p>
                      </div>
                    </div>
                  </div>

                  <div className="flex flex-col gap-4 border-t md:border-t-0 md:border-l border-white/5 pt-4 md:pt-0 md:pl-8">
                    <div className="flex items-start gap-3">
                      <Calendar size={18} className="text-cta-orange shrink-0 mt-0.5" />
                      <div>
                        <span className="text-[10px] text-muted-text uppercase font-semibold">Waktu</span>
                        <p className="text-white font-extrabold mt-0.5">
                          {bookingResult.pickup_date} — Jam {bookingResult.pickup_time.slice(0, 5)} WIB
                        </p>
                      </div>
                    </div>
                    <div className="flex items-start gap-3">
                      <CreditCard size={18} className="text-electric-blue shrink-0 mt-0.5" />
                      <div>
                        <span className="text-[10px] text-muted-text uppercase font-semibold">Estimasi Tagihan</span>
                        <p className="text-gold font-accent font-extrabold text-base mt-0.5">
                          Rp {Number(bookingResult.total_price).toLocaleString("id-ID")}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Assigned resources columns */}
                {(bookingResult.vehicle || bookingResult.driver) && (
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white/[0.02] border border-white/5 p-6 rounded-2xl">
                    {/* Vehicle */}
                    {bookingResult.vehicle ? (
                      <div className="flex items-center gap-4">
                        <div className="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-cta-orange border border-white/5">
                          <Car size={18} />
                        </div>
                        <div>
                          <span className="text-[10px] text-muted-text uppercase block">Unit Kendaraan</span>
                          <strong className="text-white text-xs block">{bookingResult.vehicle.name}</strong>
                          <span className="text-[10px] text-gold font-mono font-bold tracking-wider uppercase block mt-0.5">
                            Plat: {bookingResult.vehicle.plate_number}
                          </span>
                        </div>
                      </div>
                    ) : (
                      <div className="text-xs text-muted-text italic">Menunggu penetapan armada kendaraan...</div>
                    )}

                    {/* Driver */}
                    {bookingResult.driver ? (
                      <div className="flex items-center gap-4 border-t md:border-t-0 md:border-l border-white/5 pt-4 md:pt-0 md:pl-6">
                        <div className="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-electric-blue border border-white/5">
                          <User size={18} />
                        </div>
                        <div>
                          <span className="text-[10px] text-muted-text uppercase block">Driver Anda</span>
                          <strong className="text-white text-xs block">{bookingResult.driver.name}</strong>
                          <span className="text-[10px] text-muted-text block mt-0.5">Hp: {bookingResult.driver.phone}</span>
                        </div>
                      </div>
                    ) : (
                      <div className="text-xs text-muted-text italic flex items-center border-t md:border-t-0 md:border-l border-white/5 pt-4 md:pt-0 md:pl-6">
                        Menunggu penetapan sopir driver...
                      </div>
                    )}
                  </div>
                )}
              </div>
            ) : (
              <div className="glass-panel p-10 rounded-2xl border border-white/10 text-center flex flex-col items-center gap-3">
                <p className="text-sm font-bold text-red-400">Kode Booking Tidak Ditemukan</p>
                <p className="text-xs text-muted-text max-w-sm leading-relaxed">
                  Harap verifikasi kembali penulisan kode booking Anda (e.g. `BYT-YYYYMMDD-0001`) dan masukkan nomor WhatsApp yang benar.
                </p>
              </div>
            )
          )}

        </div>
      </main>

      <Footer />
    </>
  );
}
