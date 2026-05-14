"use client";

import { useState, useEffect } from "react";
import { Star, Quote } from "lucide-react";
import { api } from "@/lib/api";

export default function Testimonials() {
  const [testimonials, setTestimonials] = useState<any[]>([]);

  // High-fidelity fallback client reviews matching mockup image 100% exactly
  const fallbackTestimonials = [
    {
      id: 1,
      name: "Andi Pratama",
      service_type: "Pelanggan Setia",
      rating: 5,
      message: "Layanan sangat memuaskan! Driver ramah, mobil bersih dan nyaman. Pasti akan menggunakan lagi.",
    },
    {
      id: 2,
      name: "Siti Rahmawati",
      service_type: "Layanan Bandara",
      rating: 5,
      message: "Antar jemput bandara tepat waktu dan proses booking sangat mudah. Recommended!",
    },
    {
      id: 3,
      name: "Budi Santoso",
      service_type: "Charter Hiace",
      rating: 5,
      message: "Sewa Hiace untuk perjalanan keluarga besar, semua nyaman dan aman sampai tujuan.",
    },
  ];

  useEffect(() => {
    api.getTestimonials()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          setTestimonials(res.data);
        } else {
          setTestimonials(fallbackTestimonials);
        }
      })
      .catch(() => {
        setTestimonials(fallbackTestimonials);
      });
  }, []);

  return (
    <section id="testimoni" className="relative py-24 bg-[#030712] overflow-hidden font-sans">
      {/* Decorative Light Glow */}
      <div className="absolute top-1/2 left-0 w-[300px] h-[300px] bg-electric-blue/5 rounded-full blur-[100px] pointer-events-none" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-3 mb-16">
          <h2 className="font-accent text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">
            Apa Kata Pelanggan Kami
          </h2>
        </div>

        {/* Testimonials 3-Column Grid Layout */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {testimonials.slice(0, 3).map((testi) => (
            <div
              key={testi.id}
              className="glass-card p-8 rounded-2xl flex flex-col justify-between relative group hover:border-[#F59E0B]/25 bg-[#0B1726]/40 border border-white/5 min-h-[220px]"
            >
              {/* Quote Mark Decoration */}
              <Quote className="absolute top-6 right-6 text-white/5 w-10 h-10 pointer-events-none" />

              <div>
                {/* Reviewer details row */}
                <div className="flex items-center gap-3.5 mb-5">
                  {/* Fallback avatar profile circle */}
                  <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[#F59E0B] to-[#FBBF24] flex items-center justify-center font-bold font-accent text-primary-dark text-xs uppercase shadow-lg">
                    {(testi.name || "P").charAt(0)}
                  </div>
                  <div className="text-left">
                    <h4 className="text-xs font-black text-white uppercase tracking-wide">
                      {testi.name || "Pelanggan Anonim"}
                    </h4>
                    <span className="text-[9px] text-muted-text uppercase font-semibold">
                      {testi.service_type || "Klien Terhormat"}
                    </span>
                  </div>
                </div>

                {/* Rating Stars row */}
                <div className="flex items-center gap-1 mb-4 text-left">
                  {Array.from({ length: 5 }).map((_, sIdx) => (
                    <Star
                      key={sIdx}
                      size={12}
                      className={sIdx < testi.rating ? "text-gold fill-gold" : "text-white/10"}
                    />
                  ))}
                </div>

                {/* Testimonial message */}
                <p className="text-xs text-muted-text leading-relaxed italic text-left">
                  &ldquo;{testi.message}&rdquo;
                </p>
              </div>

            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
