"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { Menu, X, ChevronRight } from "lucide-react";

export default function Navbar() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const pathname = usePathname();

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 20) {
        setIsScrolled(true);
      } else {
        setIsScrolled(false);
      }
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  const navLinks = [
    { name: "Beranda", href: "/" },
    { name: "Tentang", href: "/#tentang" },
    { name: "Layanan", href: "/#layanan" },
    { name: "Armada", href: "/#armada" },
    { name: "Rute", href: "/#rute" },
    { name: "Testimoni", href: "/#testimoni" },
    { name: "Kontak", href: "/#kontak" },
  ];

  return (
    <>
      <nav
        className={`fixed top-0 left-0 w-full z-50 transition-all duration-500 ${
          isScrolled
            ? "bg-[#030712]/90 backdrop-blur-xl border-b border-white/5 py-4 shadow-2xl"
            : "bg-transparent py-6"
        }`}
      >
        <div className="max-w-7xl mx-auto px-6 flex items-center justify-between">
          {/* Logo Brand matching Mockup */}
          <Link href="/" className="flex items-center gap-3.5 group">
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#F59E0B] to-[#FBBF24] flex items-center justify-center text-[#030712] font-black text-2xl shadow-[0_0_15px_rgba(245,158,11,0.3)] font-accent transform group-hover:scale-105 transition-all">
              B
            </div>
            <div className="flex flex-col">
              <span className="font-accent text-lg sm:text-xl font-black tracking-tight text-white uppercase mt-0.5 leading-none">
                Bylian
              </span>
              <span className="text-[10px] text-[#F59E0B] font-extrabold uppercase tracking-widest mt-1 leading-none">
                Transportasi
              </span>
            </div>
          </Link>

          {/* Center Navigation Links */}
          <div className="hidden lg:flex items-center gap-8">
            {navLinks.map((link) => {
              const isActive = pathname === link.href;
              return (
                <Link
                  key={link.name}
                  href={link.href}
                  className={`text-xs font-bold tracking-wider uppercase transition-all duration-300 py-1 ${
                    isActive ? "text-[#F59E0B]" : "text-foreground/80 hover:text-white"
                  }`}
                >
                  {link.name}
                </Link>
              );
            })}
          </div>

          {/* CTA Right Button */}
          <div className="hidden lg:flex items-center">
            <Link
              href="/booking"
              className="bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] px-5 py-2.5 rounded-lg text-xs font-black flex items-center gap-1.5 shadow-[0_4px_20px_rgba(245,158,11,0.25)] text-primary-dark font-accent transition-all duration-300 hover:scale-[1.03] hover:shadow-[0_4px_25px_rgba(245,158,11,0.4)]"
            >
              <span>Booking Sekarang</span>
              <ChevronRight size={13} className="stroke-[3]" />
            </Link>
          </div>

          {/* Mobile Toggle */}
          <button
            onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            className="lg:hidden text-white focus:outline-none p-1.5 rounded-lg border border-white/10 bg-white/5"
          >
            {isMobileMenuOpen ? <X size={22} /> : <Menu size={22} />}
          </button>
        </div>
      </nav>

      {/* Mobile Nav Overlay */}
      <div
        className={`fixed inset-0 z-40 bg-primary-dark/95 backdrop-blur-2xl transition-all duration-500 lg:hidden flex flex-col justify-center px-10 gap-8 ${
          isMobileMenuOpen ? "opacity-100 translate-x-0" : "opacity-0 translate-x-full pointer-events-none"
        }`}
      >
        <div className="flex flex-col gap-6 text-center">
          {navLinks.map((link) => (
            <Link
              key={link.name}
              href={link.href}
              onClick={() => setIsMobileMenuOpen(false)}
              className="text-2xl font-bold font-accent text-white hover:text-[#F59E0B] transition-colors duration-300"
            >
              {link.name}
            </Link>
          ))}
        </div>

        <div className="flex flex-col gap-4 mt-8">
          <Link
            href="/booking"
            onClick={() => setIsMobileMenuOpen(false)}
            className="bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] py-3.5 rounded-xl text-center font-black font-accent shadow-lg text-primary-dark flex items-center justify-center gap-2"
          >
            <span>Booking Sekarang</span>
            <ChevronRight size={16} className="stroke-[3]" />
          </Link>
        </div>
      </div>
    </>
  );
}
