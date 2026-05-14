"use client";

import Link from "next/link";
import { ChevronRight, Clock, MapPin, Award } from "lucide-react";

export default function HeroSection3D() {
  return (
    <section className="relative min-h-screen pt-32 pb-24 flex items-center justify-center overflow-hidden bg-[#0F172A]">
      
      {/* 1. Full-Bleed Commercial Showroom Background Image Layer */}
      <div className="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div 
          className="absolute inset-0 w-full h-full bg-cover bg-center transform scale-105 animate-subtle-zoom"
          style={{
            backgroundImage: `url('/bylian_trans_fleet_staff.png')`,
          }}
        />

        {/* Elegant Dark Gradients for Text Legibility & Contrast */}
        {/* Dark gradient from left for main heading text */}
        <div className="absolute inset-0 bg-gradient-to-r from-[#0F172A]/95 via-[#0F172A]/80 to-transparent" />
        {/* Bottom gradient connecting to the rest of the page */}
        <div className="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-transparent to-[#0F172A]/40" />
        {/* Soft overall tint */}
        <div className="absolute inset-0 bg-[#0F172A]/30 backdrop-blur-[1px]" />
      </div>

      {/* Lighting Accents */}
      <div className="absolute top-1/4 left-1/4 w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none" />
      <div className="absolute bottom-1/4 right-1/4 w-[450px] h-[450px] bg-amber-500/10 rounded-full blur-[140px] pointer-events-none" />

      {/* 2. Main Hero Content Layout */}
      <div className="max-w-7xl mx-auto px-6 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
        
        {/* Left Column: Copywriting & CTA */}
        <div className="lg:col-span-7 flex flex-col items-start gap-6 text-left z-20">
          <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md shadow-lg">
            <Award size={14} className="text-amber-400" />
            <span className="text-[10px] font-black text-white uppercase tracking-widest font-accent">Layanan Transportasi #1 Indonesia</span>
          </div>

          <h1 className="font-accent text-4xl sm:text-5xl xl:text-6xl font-black leading-tight tracking-tight text-white uppercase">
            Perjalanan Lebih <br />
            Nyaman Bersama <br />
            <span className="text-gradient-gold">Bylian Trans</span>
          </h1>

          <p className="text-sm sm:text-base text-white/90 max-w-xl leading-relaxed font-medium backdrop-blur-sm bg-black/10 p-4 rounded-2xl border border-white/5">
            Solusi Transportasi Aman, Nyaman & Tepat Waktu. Kami menghadirkan armada terawat dan driver profesional untuk kebutuhan Rental Mobil, Travel antarkota, Charter VIP, & Airport Transfer.
          </p>

          <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full sm:w-auto mt-2">
            <Link
              href="/booking"
              className="bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] px-8 py-4 rounded-xl font-black font-accent text-primary-dark shadow-xl shadow-amber-500/20 flex items-center justify-center gap-2 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-amber-500/40"
            >
              <span>Pesan Sekarang</span>
              <ChevronRight size={16} className="stroke-[3]" />
            </Link>
            <Link
              href="/#armada"
              className="border border-white/20 bg-white/10 backdrop-blur-md hover:bg-white/20 transition-all duration-300 px-8 py-4 rounded-xl font-black font-accent text-white flex items-center justify-center gap-2 text-xs uppercase tracking-wider"
            >
              <span>Lihat Armada Kami</span>
            </Link>
          </div>

          <div className="grid grid-cols-3 gap-4 w-full border-t border-white/10 mt-6 pt-6 text-[10px] sm:text-xs text-white/90 font-bold font-accent uppercase backdrop-blur-sm">
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
              </div>
              <span>Driver Profesional</span>
            </div>
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
              </div>
              <span>Armada Terawat</span>
            </div>
            <div className="flex items-center gap-3">
              <div className="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-inner">
                <Clock size={16} />
              </div>
              <span>Tepat Waktu</span>
            </div>
          </div>
        </div>

        {/* Right Column: Floating Glass HUD Cards over the Showcase Photograph */}
        <div className="lg:col-span-5 relative min-h-[450px] lg:min-h-[550px] flex flex-col justify-between py-6">
          
          <div className="self-end glass-panel px-5 py-4 rounded-2xl flex flex-col gap-1.5 shadow-2xl border border-white/20 backdrop-blur-xl max-w-[240px] animate-float">
            <span className="text-[9px] font-black tracking-widest text-amber-400 uppercase">Rute Populer</span>
            <div className="flex items-center gap-2 text-white font-accent text-xs font-bold">
              <span>Jakarta</span>
              <ChevronRight size={12} className="text-muted-text" />
              <span>Semarang</span>
            </div>
            <div className="text-[10px] text-muted-text mt-1 border-t border-white/10 pt-1.5 flex items-center justify-between">
              <span>Jadwal Pagi</span>
              <span className="text-green-400 font-bold">Siap Berangkat</span>
            </div>
          </div>

          <div className="self-start glass-panel p-5 rounded-2xl flex items-center gap-3 border border-white/20 backdrop-blur-xl shadow-2xl animate-float" style={{ animationDelay: '1s' }}>
            <div className="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400">
              <Clock size={18} />
            </div>
            <div>
              <span className="text-[9px] text-muted-text uppercase font-bold block tracking-wider">Garansi Kecepatan</span>
              <strong className="text-white text-xs font-accent block mt-0.5">Tepat Waktu & Nyaman</strong>
            </div>
          </div>

          <div className="self-end glass-panel p-5 rounded-2xl flex flex-col gap-2 border border-white/20 backdrop-blur-xl shadow-2xl max-w-[220px] animate-float" style={{ animationDelay: '2s' }}>
            <div className="flex items-center justify-between gap-4 border-b border-white/10 pb-2">
              <span className="text-[9px] font-black text-muted-text uppercase tracking-wider">Unit Tersedia</span>
              <span className="px-2 py-0.5 rounded-full bg-green-500/20 border border-green-500/40 text-[9px] text-green-400 font-extrabold uppercase">Online</span>
            </div>
            <div className="text-xs text-white font-accent font-bold">
              Innova Zenix • Avanza • HiAce VIP
            </div>
          </div>

        </div>
      </div>

      <style jsx global>{`
        @keyframes subtleZoom {
          0%, 100% { transform: scale(1.02); }
          50% { transform: scale(1.05); }
        }
        @keyframes float {
          0%, 100% { transform: translateY(0px); }
          50% { transform: translateY(-8px); }
        }
        .animate-subtle-zoom {
          animation: subtleZoom 15s ease-in-out infinite;
        }
        .animate-float {
          animation: float 4s ease-in-out infinite;
        }
      `}</style>
    </section>
  );
}