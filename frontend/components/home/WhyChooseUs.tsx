"use client";

import { DollarSign, ShieldCheck, HeartHandshake, PhoneCall, HelpCircle, Timer } from "lucide-react";

export default function WhyChooseUs() {
  const reasons = [
    {
      title: "Harga Transparan",
      desc: "Harga jelas tanpa biaya tambahan tersembunyi.",
      icon: DollarSign,
      color: "text-cta-orange bg-cta-orange/10 border-cta-orange/20",
    },
    {
      title: "Driver Berpengalaman",
      desc: "Driver profesional, ramah, dan berpengalaman.",
      icon: HeartHandshake,
      color: "text-electric-blue bg-electric-blue/10 border-electric-blue/20",
    },
    {
      title: "Booking Mudah",
      desc: "Pesan kapan saja melalui website atau WhatsApp.",
      icon: ShieldCheck,
      color: "text-[#FBBF24] bg-[#FBBF24]/10 border-[#FBBF24]/20",
    },
    {
      title: "Layanan 24/7",
      desc: "Siap melayani Anda kapan pun dibutuhkan.",
      icon: PhoneCall,
      color: "text-cta-orange bg-cta-orange/10 border-cta-orange/20",
    },
    {
      title: "Armada Terawat",
      desc: "Kendaraan rutin diservis dan selalu bersih.",
      icon: HelpCircle,
      color: "text-electric-blue bg-electric-blue/10 border-electric-blue/20",
    },
    {
      title: "Tepat Waktu",
      desc: "Komitmen kami adalah ketepatan waktu Anda.",
      icon: Timer,
      color: "text-[#FBBF24] bg-[#FBBF24]/10 border-[#FBBF24]/20",
    },
  ];

  return (
    <section className="relative py-24 bg-[#030712] overflow-hidden font-sans">
      {/* Decorative Glow */}
      <div className="absolute top-1/2 left-1/2 w-[350px] h-[350px] bg-electric-blue/5 rounded-full blur-[120px] pointer-events-none -translate-x-1/2 -translate-y-1/2" />

      <div className="max-w-7xl mx-auto px-6 relative z-10 text-center">
        
        {/* Section Header */}
        <div className="flex flex-col items-center gap-3 mb-16">
          <h2 className="font-accent text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">
            Mengapa Memilih Bylian Transportasi?
          </h2>
        </div>

        {/* 6 Grid layout columns matching Mockup */}
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
          {reasons.map((item, idx) => {
            const Icon = item.icon;
            return (
              <div
                key={idx}
                className="flex flex-col items-center text-center p-5 rounded-2xl border border-white/5 bg-[#0B1726]/40 hover:border-cta-orange/15 transition-all duration-300 group"
              >
                {/* Rounded Hexagonal Graphic circle icon */}
                <div className={`w-12 h-12 rounded-full border flex items-center justify-center mb-5 ${item.color} shadow-lg transform group-hover:scale-105 transition-transform`}>
                  <Icon size={18} className="stroke-[2.5]" />
                </div>
                
                <h3 className="font-accent text-xs font-black tracking-wide text-white uppercase">
                  {item.title}
                </h3>
                <p className="text-[10px] text-muted-text mt-2.5 leading-relaxed max-w-[140px]">
                  {item.desc}
                </p>
              </div>
            );
          })}
        </div>

      </div>
    </section>
  );
}
