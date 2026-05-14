"use client";

import Link from "next/link";
import { Phone, ChevronRight } from "lucide-react";

export default function CTASection() {
  return (
    <section id="kontak" className="relative py-20 bg-[#030712] overflow-hidden font-sans">
      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Full-width Glass Panel Container */}
        <div className="glass-panel p-8 md:p-12 rounded-[32px] border border-white/5 bg-[#0B1726]/60 relative overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-8 items-center shadow-3xl">
          
          {/* Inner ambient glows */}
          <div className="absolute top-0 right-1/4 w-[300px] h-[300px] bg-electric-blue/10 rounded-full blur-[100px] pointer-events-none" />
          <div className="absolute bottom-0 left-1/4 w-[300px] h-[300px] bg-[#F59E0B]/5 rounded-full blur-[100px] pointer-events-none" />

          {/* Left Column copywriting */}
          <div className="lg:col-span-6 flex flex-col items-start text-left gap-4 relative z-10">
            <h2 className="font-accent text-xl sm:text-2xl lg:text-3xl font-black text-white uppercase tracking-tight leading-tight">
              Siap Untuk Perjalanan Nyaman <br />
              Bersama <span className="text-gradient-gold">Bylian Transportasi?</span>
            </h2>
            <p className="text-xs sm:text-sm text-muted-text max-w-md leading-relaxed mt-1">
              Pesan sekarang dan rasakan pengalaman perjalanan terbaik bersama kami.
            </p>
          </div>

          {/* Center Column: Abstract luxury SUV placement matching the mockup */}
          <div className="lg:col-span-2 hidden lg:flex justify-center relative z-10 opacity-70">
            <div className="w-24 h-16 bg-white/5 border border-white/10 rounded-xl flex items-center justify-center text-[#F59E0B]">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
            </div>
          </div>

          {/* Right Column WhatsApp widget card */}
          <div className="lg:col-span-4 flex flex-col gap-4 relative z-10 w-full sm:max-w-md justify-self-end">
            <div className="bg-[#030712]/80 border border-white/5 rounded-2xl p-5 flex flex-col gap-4">
              
              <div className="flex flex-col gap-1.5 text-left">
                <span className="text-[9px] text-muted-text uppercase font-bold tracking-wider">Booking Mudah via WhatsApp</span>
                <Link
                  href="https://wa.me/6281234567890"
                  target="_blank"
                  className="flex items-center gap-3 bg-green-500/10 border border-green-500/20 rounded-xl px-4 py-3.5 text-green-400 hover:bg-green-500/15 transition-all text-sm font-extrabold"
                >
                  <Phone size={16} className="shrink-0 animate-pulse" />
                  <span>0812-3456-7890</span>
                </Link>
              </div>

              <Link
                href="/booking"
                className="w-full bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] py-3.5 rounded-xl font-black font-accent text-primary-dark text-xs uppercase tracking-wider flex items-center justify-center gap-1.5 hover:scale-[1.02] transition-transform duration-300"
              >
                <span>Pesan Sekarang</span>
                <ChevronRight size={14} className="stroke-[3]" />
              </Link>

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
