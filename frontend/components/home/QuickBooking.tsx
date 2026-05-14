"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { MapPin, Calendar, ClipboardList, Search, ShieldCheck } from "lucide-react";
import { api } from "@/lib/api";

export default function QuickBooking() {
  const router = useRouter();
  
  // Mounted safeguard for Hydration
  const [mounted, setMounted] = useState(false);
  
  // Field States
  const [pickupLocation, setPickupLocation] = useState("");
  const [dropoffLocation, setDropoffLocation] = useState("");
  const [pickupDate, setPickupDate] = useState("");
  const [serviceId, setServiceId] = useState("");

  // API dynamic dropdown list (fallback to static options on API disconnect)
  const [services, setServices] = useState<any[]>([
    { id: 1, title: "Sewa Mobil Harian" },
    { id: 2, title: "Travel Antar Kota" },
    { id: 3, title: "Antar Jemput Bandara" },
    { id: 4, title: "Charter Kendaraan" },
    { id: 5, title: "Wisata & Tour" },
    { id: 6, title: "Transportasi Corporate" },
  ]);

  useEffect(() => {
    setMounted(true);
    
    // Attempt to pull services dynamically from Laravel API
    api.getServices()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          setServices(res.data);
          setServiceId(res.data[0].id.toString());
        } else {
          setServiceId("1");
        }
      })
      .catch(() => {
        setServiceId("1"); // Use default fallback ID on network failure
      });
  }, []);

  if (!mounted) {
    return (
      <div className="relative max-w-6xl mx-auto px-6 -mt-16 sm:-mt-24 z-20">
        <div className="glass-panel p-8 md:p-10 rounded-[28px] shadow-3xl h-36 bg-secondary-dark/60 animate-pulse border border-white/5" />
      </div>
    );
  }

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();

    if (!pickupLocation || !dropoffLocation || !pickupDate || !serviceId) {
      alert("Harap lengkapi kriteria perjalanan Anda.");
      return;
    }

    // Save search data to sessionStorage to pre-fill the multi-step booking page
    const bookingParams = {
      pickup_location: pickupLocation,
      dropoff_location: dropoffLocation,
      pickup_date: pickupDate,
      pickup_time: "08:00", // Default baseline time
      passenger_count: 1,
      service_id: Number(serviceId),
    };

    sessionStorage.setItem("quick_booking_data", JSON.stringify(bookingParams));
    
    // Redirect to Checkout form page
    router.push("/booking");
  };

  return (
    <div className="relative max-w-6xl mx-auto px-6 -mt-12 sm:-mt-20 z-20 font-sans">
      <div className="glass-panel p-6 sm:p-8 rounded-[24px] shadow-3xl border border-white/10 relative overflow-hidden bg-[#0B1726]/80 backdrop-blur-2xl">
        {/* Glow corner line */}
        <div className="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-cta-orange via-gold to-electric-blue" />
        
        <form onSubmit={handleSearch} className="flex flex-col gap-5">
          {/* Header Title with Icon */}
          <div className="flex items-center gap-2.5 text-white/90 pb-3 border-b border-white/5">
            <div className="w-6 h-6 rounded-md bg-electric-blue/10 flex items-center justify-center text-electric-blue">
              <ShieldCheck size={14} className="stroke-[2.5]" />
            </div>
            <h3 className="text-xs font-black tracking-wider uppercase font-accent">Booking Cepat</h3>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-5 items-end">
            
            {/* 1. Lokasi Jemput */}
            <div className="lg:col-span-3 flex flex-col gap-1.5 text-left">
              <label className="text-[10px] font-black text-muted-text tracking-widest uppercase font-accent flex items-center gap-1.5">
                <MapPin size={11} className="text-cta-orange" />
                <span>Lokasi Jemput</span>
              </label>
              <input
                type="text"
                required
                placeholder="Pilih lokasi jemput"
                value={pickupLocation}
                onChange={(e) => setPickupLocation(e.target.value)}
                className="w-full bg-secondary-dark border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-muted-text/50 focus:outline-none focus:border-electric-blue transition-all"
              />
            </div>

            {/* 2. Tujuan */}
            <div className="lg:col-span-3 flex flex-col gap-1.5 text-left">
              <label className="text-[10px] font-black text-muted-text tracking-widest uppercase font-accent flex items-center gap-1.5">
                <MapPin size={11} className="text-electric-blue" />
                <span>Tujuan</span>
              </label>
              <input
                type="text"
                required
                placeholder="Pilih tujuan"
                value={dropoffLocation}
                onChange={(e) => setDropoffLocation(e.target.value)}
                className="w-full bg-secondary-dark border border-white/5 rounded-xl px-4 py-3 text-xs text-white placeholder-muted-text/50 focus:outline-none focus:border-electric-blue transition-all"
              />
            </div>

            {/* 3. Tanggal */}
            <div className="lg:col-span-2 flex flex-col gap-1.5 text-left">
              <label className="text-[10px] font-black text-muted-text tracking-widest uppercase font-accent flex items-center gap-1.5">
                <Calendar size={11} className="text-cta-orange" />
                <span>Tanggal</span>
              </label>
              <input
                type="date"
                required
                value={pickupDate}
                onChange={(e) => setPickupDate(e.target.value)}
                className="w-full bg-secondary-dark border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-electric-blue transition-all cursor-pointer"
              />
            </div>

            {/* 4. Jenis Layanan */}
            <div className="lg:col-span-2 flex flex-col gap-1.5 text-left">
              <label className="text-[10px] font-black text-muted-text tracking-widest uppercase font-accent flex items-center gap-1.5">
                <ClipboardList size={11} className="text-electric-blue" />
                <span>Jenis Layanan</span>
              </label>
              <select
                value={serviceId}
                onChange={(e) => setServiceId(e.target.value)}
                className="w-full bg-secondary-dark border border-white/5 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-electric-blue transition-all cursor-pointer"
              >
                {services.map((srv) => (
                  <option key={srv.id} value={srv.id} className="bg-[#030712]">
                    {srv.title}
                  </option>
                ))}
              </select>
            </div>

            {/* Submit Action Button */}
            <div className="lg:col-span-2">
              <button
                type="submit"
                className="w-full bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] py-3 rounded-xl font-black font-accent text-primary-dark text-xs uppercase tracking-wider flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform duration-300 shadow-lg shadow-cta-orange/15 cursor-pointer"
              >
                <Search size={13} className="stroke-[3]" />
                <span>Cari Sekarang</span>
              </button>
            </div>

          </div>
        </form>
      </div>
    </div>
  );
}
