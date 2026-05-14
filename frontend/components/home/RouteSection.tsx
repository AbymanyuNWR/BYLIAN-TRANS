"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { Clock, ChevronRight, Navigation, Compass, MapPin, Tag } from "lucide-react";
import { api } from "@/lib/api";

const fallbackRoutes = [
  {
    id: 1,
    origin_city: "Bandung",
    destination_city: "Jakarta (Pusat)",
    distance: "150 km",
    duration: "2.5 - 3 Jam",
    price: 150000,
    description: "Travel Eksekutif Bandung ➔ Jakarta via Tol Trans Jawa. Fasilitas armada eksekutif.",
    service: "Travel Antar Kota",
  },
  {
    id: 2,
    origin_city: "Jakarta",
    destination_city: "Semarang",
    distance: "440 km",
    duration: "6 - 7 Jam",
    price: 350000,
    description: "Layanan travel eksekutif Jakarta menuju Semarang via Tol Trans Jawa.",
    service: "Travel Antar Kota",
  },
  {
    id: 3,
    origin_city: "Jakarta",
    destination_city: "Yogyakarta",
    distance: "550 km",
    duration: "8 - 9 Jam",
    price: 400000,
    description: "Perjalanan nyaman Jakarta ke Yogyakarta with door-to-door pickup.",
    service: "Travel Antar Kota",
  },
  {
    id: 4,
    origin_city: "Bandung",
    destination_city: "Surabaya",
    distance: "780 km",
    duration: "10 - 11 Jam",
    price: 650000,
    description: "Rute jarak jauh Bandung menuju Surabaya via Tol dengan armada terbaik.",
    service: "Travel Antar Kota",
  },
  {
    id: 5,
    origin_city: "Surabaya",
    destination_city: "Malang",
    distance: "95 km",
    duration: "1.5 - 2 Jam",
    price: 120000,
    description: "Shuttle cepat Surabaya menuju Malang PP. Jadwal fleksibel setiap jam.",
    service: "Travel Reguler",
  },
  {
    id: 6,
    origin_city: "Semarang",
    destination_city: "Solo",
    distance: "100 km",
    duration: "1.5 - 2 Jam",
    price: 110000,
    description: "Layanan antar kota Semarang menuju Solo via tol. Cepat dan aman.",
    service: "Travel Reguler",
  },
  {
    id: 7,
    origin_city: "Jakarta",
    destination_city: "Bandung",
    distance: "150 km",
    duration: "2.5 - 3 Jam",
    price: 2500000,
    description: "Sewa mobil harian Jakarta ke Bandung termasuk Driver & BBM.",
    service: "Sewa Mobil",
  },
  {
    id: 8,
    origin_city: "Bandung",
    destination_city: "Bandara Soetta",
    distance: "180 km",
    duration: "3 - 3.5 Jam",
    price: 650000,
    description: "Layanan drop off Bandara Soekarno-Hatta khusus private car All-In.",
    service: "Antar Jemput Bandara",
  },
];

export default function RouteSection() {
  const [routes, setRoutes] = useState<any[]>(fallbackRoutes);

  useEffect(() => {
    api.getRoutes()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          const mapped = res.data.map((item: any, idx: number) => ({
            ...item,
            description: item.description || fallbackRoutes[idx % fallbackRoutes.length]?.description,
            distance: item.distance || fallbackRoutes[idx % fallbackRoutes.length]?.distance,
            duration: item.duration || fallbackRoutes[idx % fallbackRoutes.length]?.duration,
          }));
          setRoutes(mapped);
        }
      })
      .catch(() => {
        // Already initialized with fallback
      });
  }, []);

  const displayedRoutes = routes.length > 0 ? routes : fallbackRoutes;

  return (
    <section className="relative py-32 bg-[#030712] overflow-hidden font-sans">
      {/* Background Lighting */}
      <div className="absolute top-1/2 left-0 w-[600px] h-[600px] bg-blue-600/5 rounded-full blur-[140px] pointer-events-none opacity-50" />
      <div className="absolute bottom-0 right-0 w-[400px] h-[400px] bg-emerald-600/5 rounded-full blur-[140px] pointer-events-none opacity-50" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-4 mb-20">
          <div className="flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/5 border border-blue-500/10 backdrop-blur-md">
            <Tag size={12} className="text-blue-400" />
            <span className="text-[10px] font-black uppercase tracking-[0.2em] text-blue-400">Popular Connections</span>
          </div>
          <h2 className="font-accent text-3xl sm:text-4xl md:text-5xl font-black text-white uppercase tracking-tight leading-tight">
            Rute Terpopuler Kami
          </h2>
          <div className="w-24 h-1 bg-gradient-to-r from-blue-600 to-emerald-500 rounded-full" />
          <p className="text-sm sm:text-base text-muted-text max-w-2xl leading-relaxed">
            Pilihan rute perjalanan eksekutif antarkota paling favorit dengan jaminan kenyamanan maksimal di seluruh Pulau Jawa.
          </p>
        </div>

        {/* Routes Grid Layout */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {displayedRoutes.map((route) => (
            <div
              key={route.id}
              className="group relative glass-card rounded-[40px] p-8 flex flex-col justify-between hover:translate-y-[-12px] transition-all duration-700 bg-white/[0.02] border border-white/5 hover:border-blue-500/30 hover:bg-white/[0.04] shadow-2xl"
            >
              {/* Card Glow */}
              <div className="absolute inset-0 bg-gradient-to-br from-blue-600/0 to-blue-600/0 group-hover:from-blue-600/5 group-hover:to-emerald-600/5 transition-all duration-700 rounded-[40px]" />

              <div className="relative">
                <div className="flex items-center justify-between mb-8">
                  <div className="w-14 h-14 rounded-3xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                    <Navigation size={24} className="transform rotate-45" />
                  </div>
                  <div className="flex flex-col items-end">
                    <span className="text-[10px] font-black text-blue-400 uppercase tracking-widest leading-none mb-1">{route.service}</span>
                    <span className="text-[9px] text-muted-text font-bold uppercase tracking-wider">{route.distance}</span>
                  </div>
                </div>

                <div className="mb-8">
                  <div className="flex flex-col gap-1.5">
                    <div className="flex items-center gap-3">
                      <div className="w-2.5 h-2.5 rounded-full border-2 border-blue-500 bg-transparent group-hover:bg-blue-500 transition-colors" />
                      <span className="text-sm font-bold text-white/50 uppercase tracking-wider group-hover:text-white/80 transition-colors">{route.origin_city}</span>
                    </div>
                    <div className="w-[2px] h-8 bg-gradient-to-b from-blue-500 to-emerald-500 ml-1.25 opacity-30 group-hover:opacity-60 transition-opacity" />
                    <div className="flex items-center gap-3">
                      <MapPin size={18} className="text-emerald-400 group-hover:animate-bounce" />
                      <span className="text-xl font-black text-white uppercase tracking-tight">{route.destination_city.split(" (")[0]}</span>
                    </div>
                  </div>
                </div>

                <p className="text-xs text-muted-text leading-relaxed mb-10 opacity-80 group-hover:opacity-100 transition-opacity">
                  {route.description}
                </p>
              </div>

              <div className="relative pt-6 border-t border-white/5">
                <div className="flex items-center justify-between gap-4 mb-6">
                  <div className="flex items-center gap-2 text-[11px] font-bold text-white/60">
                    <Clock size={14} className="text-amber-400" />
                    <span>{route.duration}</span>
                  </div>
                  <div className="flex items-center gap-2 text-[11px] font-bold text-white/60">
                    <Compass size={14} className="text-emerald-400" />
                    <span>Toll Path</span>
                  </div>
                </div>

                <div className="flex items-center justify-between gap-4">
                  <div className="text-left">
                    <span className="text-[9px] text-muted-text uppercase font-black block leading-none mb-1 opacity-60">Investment</span>
                    <span className="text-2xl font-black text-white font-accent group-hover:text-blue-400 transition-colors">
                      <span className="text-sm font-medium text-blue-400 mr-1">Rp</span>
                      {Number(route.price).toLocaleString("id-ID")}
                    </span>
                  </div>
                  <Link
                    href="/booking"
                    className="bg-white/5 border border-white/10 hover:bg-blue-600 hover:border-blue-500 transition-all p-4 rounded-3xl text-white group-hover:shadow-[0_0_20px_rgba(37,99,235,0.4)]"
                  >
                    <ChevronRight size={20} />
                  </Link>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* View All CTA */}
        <div className="mt-20 flex justify-center">
           <Link 
            href="/booking" 
            className="group flex items-center gap-3 px-8 py-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all"
           >
             <span className="text-sm font-black text-white uppercase tracking-widest">Cek Semua Rute</span>
             <div className="w-8 h-8 rounded-xl bg-blue-600 flex items-center justify-center group-hover:translate-x-2 transition-transform">
               <ChevronRight size={16} className="text-white" />
             </div>
           </Link>
        </div>
      </div>
    </section>
  );
}
