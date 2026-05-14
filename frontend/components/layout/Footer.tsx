"use client";

import Link from "next/link";
import { Mail, Phone, MapPin, Clock, Send } from "lucide-react";

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-[#030712] border-t border-white/5 pt-20 pb-10 relative overflow-hidden font-sans">
      {/* Background ambient lighting */}
      <div className="absolute bottom-0 right-0 w-[400px] h-[400px] bg-electric-blue/5 rounded-full blur-[120px] pointer-events-none" />
      <div className="absolute top-0 left-0 w-[300px] h-[300px] bg-cta-orange/5 rounded-full blur-[100px] pointer-events-none" />

      {/* 6 Columns Grid */}
      <div className="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-10 relative z-10 text-left">
        
        {/* Col 1 (Brand Column) - spans 3 columns on large screens */}
        <div className="lg:col-span-3 flex flex-col gap-5">
          <Link href="/" className="flex items-center gap-3.5 group">
            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-[#F59E0B] to-[#FBBF24] flex items-center justify-center text-[#030712] font-black text-xl shadow-[0_0_15px_rgba(245,158,11,0.25)] font-accent">
              B
            </div>
            <div className="flex flex-col">
              <span className="font-accent text-base font-black tracking-tight text-white uppercase mt-0.5 leading-none">
                Bylian
              </span>
              <span className="text-[9px] text-[#F59E0B] font-extrabold uppercase tracking-widest mt-1 leading-none">
                Transportasi
              </span>
            </div>
          </Link>
          <p className="text-xs text-muted-text leading-relaxed">
            Solusi transportasi terpercaya untuk harian, wisata, bisnis dan luar kota dengan layanan profesional, aman, nyaman, dan tepat waktu dengan layanan terbaik.
          </p>
          {/* Social Icons row */}
          <div className="flex items-center gap-2.5 mt-2">
            <Link
              href="https://facebook.com"
              target="_blank"
              className="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-muted-text hover:text-white hover:border-white/25 transition-all"
            >
              <svg viewBox="0 0 24 24" className="w-3.5 h-3.5 fill-current"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
            </Link>
            <Link
              href="https://instagram.com"
              target="_blank"
              className="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-muted-text hover:text-white hover:border-white/25 transition-all"
            >
              <svg viewBox="0 0 24 24" className="w-3.5 h-3.5 stroke-current fill-none" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </Link>
            {/* Custom Twitter/X SVG */}
            <Link
              href="https://twitter.com"
              target="_blank"
              className="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-muted-text hover:text-white hover:border-white/25 transition-all"
            >
              <svg viewBox="0 0 24 24" aria-hidden="true" className="w-3.5 h-3.5 fill-current"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </Link>
            <Link
              href="https://youtube.com"
              target="_blank"
              className="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-muted-text hover:text-white hover:border-white/25 transition-all"
            >
              <svg viewBox="0 0 24 24" className="w-3.5 h-3.5 fill-current"><path d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </Link>
          </div>
        </div>

        {/* Col 2 (Kontak Kami Column) - spans 3 columns */}
        <div className="lg:col-span-3 flex flex-col gap-4">
          <h4 className="font-accent text-xs font-black tracking-wider uppercase text-white pb-1.5 border-b border-white/5">
            Kontak Kami
          </h4>
          <ul className="flex flex-col gap-3 text-xs text-muted-text leading-relaxed">
            <li className="flex items-center gap-2.5">
              <Phone size={13} className="text-electric-blue shrink-0" />
              <Link href="tel:081234567890" className="hover:text-white transition-colors">
                0812-3456-7890
              </Link>
            </li>
            <li className="flex items-center gap-2.5">
              <Mail size={13} className="text-electric-blue shrink-0" />
              <Link href="mailto:info@byliantransportasi.com" className="hover:text-white transition-colors">
                info@byliantransportasi.com
              </Link>
            </li>
            <li className="flex items-start gap-2.5">
              <MapPin size={13} className="text-cta-orange shrink-0 mt-0.5" />
              <span>Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta</span>
            </li>
            <li className="flex items-center gap-2.5">
              <Clock size={13} className="text-cta-orange shrink-0" />
              <span>Senin - Minggu (24 Jam)</span>
            </li>
          </ul>
        </div>

        {/* Col 3 (Link Cepat) - spans 2 columns */}
        <div className="lg:col-span-2 flex flex-col gap-4">
          <h4 className="font-accent text-xs font-black tracking-wider uppercase text-white pb-1.5 border-b border-white/5">
            Link Cepat
          </h4>
          <ul className="flex flex-col gap-2.5 text-xs text-muted-text">
            <li><Link href="/" className="hover:text-[#FBBF24] transition-colors">Beranda</Link></li>
            <li><Link href="/#tentang" className="hover:text-[#FBBF24] transition-colors">Tentang Kami</Link></li>
            <li><Link href="/#layanan" className="hover:text-[#FBBF24] transition-colors">Layanan</Link></li>
            <li><Link href="/#armada" className="hover:text-[#FBBF24] transition-colors">Armada</Link></li>
            <li><Link href="/#rute" className="hover:text-[#FBBF24] transition-colors">Rute</Link></li>
          </ul>
        </div>

        {/* Col 4 (Layanan) - spans 2 columns */}
        <div className="lg:col-span-2 flex flex-col gap-4">
          <h4 className="font-accent text-xs font-black tracking-wider uppercase text-white pb-1.5 border-b border-white/5">
            Layanan
          </h4>
          <ul className="flex flex-col gap-2.5 text-xs text-muted-text">
            <li><Link href="/booking" className="hover:text-[#FBBF24] transition-colors">Sewa Mobil</Link></li>
            <li><Link href="/booking" className="hover:text-[#FBBF24] transition-colors">Travel Antar Kota</Link></li>
            <li><Link href="/booking" className="hover:text-[#FBBF24] transition-colors">Antar Jemput Bandara</Link></li>
            <li><Link href="/booking" className="hover:text-[#FBBF24] transition-colors">Charter Kendaraan</Link></li>
            <li><Link href="/booking" className="hover:text-[#FBBF24] transition-colors">Wisata & Tour</Link></li>
          </ul>
        </div>

        {/* Col 5 (Newsletter Column) - spans 2 columns */}
        <div className="lg:col-span-2 flex flex-col gap-4">
          <h4 className="font-accent text-xs font-black tracking-wider uppercase text-white pb-1.5 border-b border-white/5">
            Newsletter
          </h4>
          <div className="flex flex-col gap-2.5">
            <p className="text-[10px] text-muted-text leading-relaxed">
              Dapatkan info promo dan update terbaru dari kami.
            </p>
            <form onSubmit={(e) => e.preventDefault()} className="relative flex items-center mt-1">
              <input
                type="email"
                required
                placeholder="Masukkan email Anda"
                className="w-full bg-secondary-dark border border-white/10 rounded-lg pl-3 pr-9 py-2.5 text-[10px] text-white focus:outline-none focus:border-electric-blue transition-all"
              />
              <button
                type="submit"
                className="absolute right-1 text-muted-text hover:text-[#FBBF24] transition-colors p-1"
              >
                <Send size={12} className="stroke-[2.5]" />
              </button>
            </form>
          </div>
        </div>

      </div>

      {/* Bottom Legal Section */}
      <div className="max-w-7xl mx-auto px-6 border-t border-white/5 mt-16 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[10px] text-muted-text">
        <p>&copy; 2026 Bylian Transportasi. All Rights Reserved.</p>
        <div className="flex items-center gap-6">
          <Link href="/syarat-ketentuan" className="hover:text-white transition-colors">
            Syarat & Ketentuan
          </Link>
          <Link href="/kebijakan-privasi" className="hover:text-white transition-colors">
            Kebijakan Privasi
          </Link>
        </div>
      </div>
    </footer>
  );
}
