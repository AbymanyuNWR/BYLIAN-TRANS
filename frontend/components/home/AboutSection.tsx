"use client";

import { ShieldCheck, Users, Trophy, Headphones, Check } from "lucide-react";

export default function AboutSection() {
  const stats = [
    {
      label: "Klien Puas",
      value: "10K+",
      icon: Users,
      color: "text-electric-blue bg-electric-blue/10 border-electric-blue/20",
    },
    {
      label: "Unit Armada",
      value: "50+",
      icon: Trophy,
      color: "text-cta-orange bg-cta-orange/10 border-cta-orange/20",
    },
    {
      label: "Tepat Waktu",
      value: "99.8%",
      icon: ShieldCheck,
      color: "text-[#FBBF24] bg-[#FBBF24]/10 border-[#FBBF24]/20",
    },
    {
      label: "Layanan CS",
      value: "24/7",
      icon: Headphones,
      color: "text-electric-blue bg-electric-blue/10 border-electric-blue/20",
    },
  ];

  const coreValues = [
    "Armada Terawat & Sanitasi Berstandar Tinggi",
    "Sopir Terlatih, Sopan, Ramah, & Berlisensi Resmi",
    "Layanan Tanggap Bantuan Darurat Jalan Raya 24 Jam",
    "Proses Transaksi & Pembayaran Terverifikasi Aman",
  ];

  return (
    <section id="tentang" className="relative py-24 bg-[#030712] overflow-hidden font-sans border-t border-b border-white/5">
      {/* Glow backgrounds */}
      <div className="absolute top-1/2 left-0 w-[350px] h-[350px] bg-[#FBBF24]/5 rounded-full blur-[100px] pointer-events-none -translate-y-1/2" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
          
          {/* Left Column: Glass Company statistics matching premium theme */}
          <div className="lg:col-span-5 grid grid-cols-2 gap-5 relative order-2 lg:order-1">
            {/* Ambient decorative line */}
            <div className="absolute -inset-4 bg-gradient-to-tr from-electric-blue/5 to-cta-orange/5 rounded-3xl blur-2xl -z-10" />

            {stats.map((stat, idx) => {
              const Icon = stat.icon;
              return (
                <div
                  key={idx}
                  className="glass-card p-6 rounded-2xl border border-white/5 bg-[#0B1726]/40 flex flex-col items-center text-center group hover:border-[#FBBF24]/15 transition-all duration-300"
                >
                  <div className={`w-11 h-11 rounded-xl border flex items-center justify-center mb-4 ${stat.color} transform group-hover:scale-105 transition-transform`}>
                    <Icon size={18} className="stroke-[2.5]" />
                  </div>
                  <strong className="text-2xl sm:text-3xl font-black font-accent text-white tracking-tight">
                    {stat.value}
                  </strong>
                  <span className="text-[10px] text-muted-text uppercase font-bold tracking-wider mt-1">
                    {stat.label}
                  </span>
                </div>
              );
            })}
          </div>

          {/* Right Column: Narrative Copywriting */}
          <div className="lg:col-span-7 flex flex-col items-start text-left gap-5 order-1 lg:order-2">
            <span className="text-[10px] font-black tracking-widest text-[#FBBF24] uppercase font-accent">
              Tentang Kami
            </span>
            <h2 className="font-accent text-2xl sm:text-3xl lg:text-4xl font-black text-white uppercase tracking-tight leading-tight">
              Lebih Dari Sekedar Perjalanan, <br />
              Kami Memberikan <span className="text-gradient-gold">Kenyamanan VIP</span>
            </h2>
            <div className="w-16 h-[3px] bg-electric-blue mt-1" />
            
            <p className="text-xs sm:text-sm text-muted-text leading-relaxed mt-2 max-w-xl">
              Bylian Transportasi adalah penyedia jasa layanan transportasi premium terkemuka yang melayani rental mobil harian, travel antar kota, dan charter pariwisata. Didirikan dengan dedikasi penuh untuk merevolusi kenyamanan perjalanan darat Anda, kami memastikan setiap titik keberangkatan berjalan aman, tepat waktu, dengan pelayanan berkelas bintang lima.
            </p>

            {/* Checkmark value list */}
            <div className="flex flex-col gap-3 mt-4">
              {coreValues.map((val, vIdx) => (
                <div key={vIdx} className="flex items-center gap-3">
                  <div className="w-5 h-5 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center text-green-400 shrink-0">
                    <Check size={11} className="stroke-[3]" />
                  </div>
                  <span className="text-xs text-white/80 font-medium leading-relaxed">{val}</span>
                </div>
              ))}
            </div>
          </div>

        </div>
      </div>
    </section>
  );
}
