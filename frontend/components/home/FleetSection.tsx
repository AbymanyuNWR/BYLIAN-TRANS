"use client";

import { useState, useEffect } from "react";
import { ChevronDown, ChevronUp } from "lucide-react";
import { api } from "@/lib/api";

const fallbackVehicles = [
  {
    id: 1,
    name: "City Car",
    capacity: 4,
    transmission: "Manual",
    ac: "AC",
    daily_price: 350000,
    image: "/fleet_city_car.png",
  },
  {
    id: 2,
    name: "MPV",
    capacity: 6,
    transmission: "Manual",
    ac: "AC",
    daily_price: 550000,
    image: "/fleet_mpv.png",
  },
  {
    id: 3,
    name: "Hiace / Minibus",
    capacity: 14,
    transmission: "Manual",
    ac: "AC",
    daily_price: 950000,
    image: "/fleet_hiace.png",
  },
  {
    id: 4,
    name: "Luxury Car",
    capacity: 4,
    transmission: "Automatic",
    ac: "AC",
    daily_price: 1500000,
    image: "/fleet_luxury_car.png",
  },
  {
    id: 5,
    name: "Big Bus",
    capacity: "30-58",
    transmission: "Manual",
    ac: "AC",
    daily_price: 2500000,
    image: "/fleet_big_bus.png",
  },
  {
    id: 6,
    name: "SUV Premium",
    capacity: 7,
    transmission: "Automatic",
    ac: "AC",
    daily_price: 1200000,
    image: "/fleet_suv_premium.png",
  },
  {
    id: 7,
    name: "Wedding Car",
    capacity: 4,
    transmission: "Automatic",
    ac: "AC",
    daily_price: 1800000,
    image: "/fleet_wedding_car.png",
  },
  {
    id: 8,
    name: "Medium Bus",
    capacity: 30,
    transmission: "Manual",
    ac: "AC",
    daily_price: 1900000,
    image: "/fleet_medium_bus.png",
  },
  {
    id: 9,
    name: "Double Cabin 4x4",
    capacity: 5,
    transmission: "Manual",
    ac: "AC",
    daily_price: 1100000,
    image: "/fleet_double_cabin.png",
  },
  {
    id: 10,
    name: "Luxury VIP Sprinter",
    capacity: 11,
    transmission: "Automatic",
    ac: "AC",
    daily_price: 3800000,
    image: "/service_charter_kendaraan.png",
  },
];

export default function FleetSection() {
  const [vehicles, setVehicles] = useState<any[]>(fallbackVehicles);
  const [isExpanded, setIsExpanded] = useState(false);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    api.getVehicles()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          const mapped = res.data.map((item: any, idx: number) => ({
            ...item,
            capacity: item.capacity || fallbackVehicles[idx % 10]?.capacity,
            ac: "AC",
            image: fallbackVehicles[idx % 10]?.image,
          }));
          
          if (mapped.length <= 5) {
            setVehicles([...mapped, ...fallbackVehicles.slice(5)]);
          } else {
            setVehicles(mapped);
          }
        }
      })
      .catch(() => {
        // Already initialized with fallback
      })
      .finally(() => {
        setIsLoading(false);
      });
  }, []);

  const displayedVehicles = isExpanded ? vehicles : vehicles.slice(0, 5);

  return (
    <section id="armada" className="relative py-24 bg-[#07111F]/50 overflow-hidden font-sans">
      <div className="absolute top-0 right-0 w-[400px] h-[400px] bg-amber-500/5 rounded-full blur-[120px] pointer-events-none" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-3 mb-16">
          <h2 className="font-accent text-3xl sm:text-4xl font-black text-white uppercase tracking-tight">
            Armada Kami
          </h2>
          <p className="text-xs sm:text-sm text-muted-text max-w-xl leading-relaxed">
            Unit kendaraan terawat dan berkelas dengan standar kenyamanan serta keselamatan tertinggi
          </p>
        </div>

        {/* Vehicles Grid Layout */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 transition-all duration-500">
          {displayedVehicles.map((veh) => (
            <div
              key={veh.id}
              className="glass-card hover:translate-y-[-8px] hover:border-amber-500/30 transition-all duration-500 overflow-hidden flex flex-col justify-between p-5 min-h-[380px] bg-[#0B1726]/60 border border-white/10 rounded-3xl shadow-xl flex-grow group"
            >
              {/* Top Meta */}
              <div className="flex items-center justify-between">
                <span className="text-xs font-accent font-black text-white uppercase tracking-wider group-hover:text-amber-400 transition-colors">
                  {veh.name}
                </span>
                <span className="bg-white/10 border border-white/15 text-white/90 text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-md shadow-sm">
                  {veh.capacity} Kursi
                </span>
              </div>

              {/* High-Resolution Commercial Image Container */}
              <div className="relative w-full h-40 bg-slate-900/60 rounded-2xl overflow-hidden my-4 border border-white/10 shadow-inner group-hover:shadow-2xl transition-all duration-300">
                <div 
                  className="absolute inset-0 w-full h-full bg-cover bg-center transform group-hover:scale-110 transition-transform duration-700 ease-out"
                  style={{ backgroundImage: `url(${veh.image})` }}
                />
                <div className="absolute inset-0 bg-gradient-to-t from-[#0B1726] via-transparent to-transparent opacity-60" />
              </div>

              {/* Specs & Pricing */}
              <div>
                <div className="flex items-center gap-4 text-[10px] text-white/80 uppercase font-bold border-b border-white/10 pb-3 mb-3">
                  <div className="flex items-center gap-1.5">
                    <div className="w-2 h-2 rounded-full bg-blue-400" />
                    <span>{veh.transmission.split("/")[0]}</span>
                  </div>
                  <div className="flex items-center gap-1.5">
                    <div className="w-2 h-2 rounded-full bg-amber-400" />
                    <span>AC</span>
                  </div>
                </div>

                <div className="flex flex-col text-left">
                  <span className="text-[10px] text-muted-text uppercase font-bold tracking-wider">Harga Sewa Mulai</span>
                  <strong className="text-white font-accent text-base sm:text-lg font-black mt-0.5 group-hover:text-amber-400 transition-colors">
                    Rp {Number(veh.daily_price).toLocaleString("id-ID")}
                    <span className="text-[10px] text-muted-text font-medium lowercase"> /hari</span>
                  </strong>
                </div>
              </div>

            </div>
          ))}
        </div>

        {/* Expand Button */}
        <div className="flex justify-center mt-12">
          <button
            onClick={() => setIsExpanded(!isExpanded)}
            className="border border-white/20 bg-white/10 hover:bg-white/20 hover:border-white/30 px-8 py-4 rounded-xl font-black font-accent text-xs uppercase tracking-wider text-white flex items-center gap-2 transition-all duration-300 shadow-lg cursor-pointer"
          >
            <span>{isExpanded ? "Sembunyikan Armada" : "Lihat Semua Armada"}</span>
            {isExpanded ? (
              <ChevronUp size={16} className="stroke-[3]" />
            ) : (
              <ChevronDown size={16} className="stroke-[3]" />
            )}
          </button>
        </div>

      </div>
    </section>
  );
}
