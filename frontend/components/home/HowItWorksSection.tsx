"use client";

import { ChevronRight, Car, MapPin, CreditCard, ShieldCheck } from "lucide-react";

export default function HowItWorksSection() {
  const steps = [
    {
      id: "01",
      title: "Pilih Layanan",
      desc: "Pilih layanan sesuai kebutuhan perjalanan Anda, mulai dari Travel reguler hingga Private Charter.",
      icon: Car,
      color: "text-electric-blue",
      borderColor: "group-hover:border-electric-blue/50",
      bgGlow: "bg-electric-blue/5",
    },
    {
      id: "02",
      title: "Isi Detail",
      desc: "Masukkan lokasi jemput, tujuan, serta jadwal keberangkatan yang Anda inginkan secara akurat.",
      icon: MapPin,
      color: "text-cta-orange",
      borderColor: "group-hover:border-cta-orange/50",
      bgGlow: "bg-cta-orange/5",
    },
    {
      id: "03",
      title: "Konfirmasi",
      desc: "Periksa kembali detail pesanan Anda dan lakukan konfirmasi pemesanan melalui sistem kami.",
      icon: CreditCard,
      color: "text-amber-400",
      borderColor: "group-hover:border-amber-400/50",
      bgGlow: "bg-amber-400/5",
    },
    {
      id: "04",
      title: "Perjalanan",
      desc: "Nikmati perjalanan aman dan nyaman bersama driver profesional kami yang siap menjemput Anda.",
      icon: ShieldCheck,
      color: "text-emerald-400",
      borderColor: "group-hover:border-emerald-400/50",
      bgGlow: "bg-emerald-400/5",
    },
  ];

  return (
    <section id="rute" className="relative py-32 bg-[#030712] overflow-hidden font-sans">
      {/* Dynamic Background Elements */}
      <div className="absolute top-0 left-1/4 w-[500px] h-[500px] bg-electric-blue/5 rounded-full blur-[140px] pointer-events-none opacity-50" />
      <div className="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-cta-orange/5 rounded-full blur-[140px] pointer-events-none opacity-50" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-4 mb-20">
          <div className="px-4 py-1.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
            <span className="text-[10px] font-black uppercase tracking-[0.2em] text-electric-blue">Our Process</span>
          </div>
          <h2 className="font-accent text-3xl sm:text-4xl md:text-5xl font-black text-white uppercase tracking-tight">
            Rute & Cara Kerja
          </h2>
          <div className="w-20 h-1 bg-gradient-to-r from-electric-blue to-cta-orange rounded-full mb-2" />
          <p className="text-sm sm:text-base text-muted-text max-w-2xl leading-relaxed">
            Proses mudah untuk perjalanan yang nyaman. Kami menyederhanakan setiap langkah agar Anda dapat fokus pada tujuan Anda.
          </p>
        </div>

        {/* Steps Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {steps.map((step, index) => {
            const Icon = step.icon;
            return (
              <div 
                key={step.id} 
                className={`group relative p-8 rounded-[32px] bg-white/[0.02] border border-white/5 hover:bg-white/[0.04] transition-all duration-500 hover:translate-y-[-10px] ${step.borderColor}`}
              >
                {/* Step Number Background */}
                <div className="absolute top-4 right-8 text-7xl font-black text-white/[0.03] pointer-events-none group-hover:text-white/[0.05] transition-colors">
                  {step.id}
                </div>

                {/* Glow Effect */}
                <div className={`absolute inset-0 opacity-0 group-hover:opacity-100 blur-3xl transition-opacity duration-700 pointer-events-none rounded-[32px] ${step.bgGlow}`} />

                {/* Icon Container */}
                <div className={`relative w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500 shadow-2xl`}>
                  <Icon size={28} className={`${step.color} stroke-[1.5]`} />
                </div>

                {/* Content */}
                <div className="relative">
                  <h3 className="font-accent text-xl font-black text-white uppercase tracking-wide mb-4 group-hover:text-white transition-colors">
                    {step.title}
                  </h3>
                  <p className="text-sm text-muted-text leading-relaxed">
                    {step.desc}
                  </p>
                </div>

                {/* Connector Arrow (Desktop only) */}
                {index < steps.length - 1 && (
                  <div className="hidden lg:block absolute top-1/2 -right-4 translate-y-[-50%] z-20">
                    <ChevronRight size={24} className="text-white/10 group-hover:text-white/30 transition-colors" />
                  </div>
                )}
              </div>
            );
          })}
        </div>

        {/* Service Summary Tagline */}
        <div className="mt-24 flex flex-wrap justify-center gap-8 opacity-40 hover:opacity-100 transition-opacity duration-500">
           {["Premium Travel", "Luxury Charter", "Airport Transfer", "Corporate Rental"].map((tag) => (
             <span key={tag} className="text-[11px] font-black uppercase tracking-widest text-white border-b border-white/20 pb-1">
               {tag}
             </span>
           ))}
        </div>
      </div>
    </section>
  );
}
