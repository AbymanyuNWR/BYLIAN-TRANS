"use client";

import { useState, useEffect } from "react";
import { Plus, Minus, HelpCircle } from "lucide-react";
import { api } from "@/lib/api";

export default function FAQSection() {
  const [faqs, setFaqs] = useState<any[]>([]);
  const [openIdx, setOpenIdx] = useState<number | null>(0); // open first FAQ by default

  // High-fidelity fallback FAQs presets
  const fallbackFaqs = [
    {
      id: 1,
      question: "Apakah bisa melakukan pemesanan langsung lewat WhatsApp?",
      answer: "Sangat bisa! Layanan Customer Service kami aktif 24 jam sehari. Anda bisa langsung mengklik ikon WhatsApp di bagian kanan bawah untuk langsung memesan unit secara instan tanpa ribet.",
    },
    {
      id: 2,
      question: "Apakah tarif sewa sudah termasuk pengemudi (driver)?",
      answer: "Secara standar, paket sewa mobil harian kami sudah All-In (termasuk mobil, driver profesional, bbm). Namun kami juga menyediakan opsi sewa mobil lepas kunci khusus untuk korporat atau sewa bulanan.",
    },
    {
      id: 3,
      question: "Bagaimana sistem pembayaran di Bylian Transportasi?",
      answer: "Pembayaran dapat dilakukan dengan mudah via transfer bank resmi Mandiri CV. Bylian Transportasi Group. Kami meminta komitmen deposit (DP) minimal 30% untuk mengunci ketersediaan armada, lalu sisa pembayaran bisa dilunasi H-1 perjalanan.",
    },
    {
      id: 4,
      question: "Apakah saya bisa menjadwal ulang (reschedule) tanggal keberangkatan?",
      answer: "Bisa! Kebijakan reschedule gratis dilayani maksimal H-2 dari tanggal penjemputan awal, tergantung ketersediaan armada kosong di tanggal baru tersebut.",
    },
    {
      id: 5,
      question: "Apakah melayani perjalanan luar kota jarak jauh?",
      answer: "Ya, kami melayani perjalanan charter, drop-off bandara, pariwisata, dan travel reguler antar kota lintas provinsi Jawa Barat, DKI Jakarta, Banten, hingga Jawa Tengah & Yogyakarta.",
    },
  ];

  useEffect(() => {
    api.getFaqs()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          setFaqs(res.data);
        } else {
          setFaqs(fallbackFaqs);
        }
      })
      .catch(() => {
        setFaqs(fallbackFaqs);
      });
  }, []);

  const toggleFaq = (idx: number) => {
    if (openIdx === idx) {
      setOpenIdx(null);
    } else {
      setOpenIdx(idx);
    }
  };

  return (
    <section id="faq" className="relative py-28 bg-secondary-dark/40 overflow-hidden">
      <div className="max-w-4xl mx-auto px-6 relative z-10">
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-4 mb-16">
          <span className="text-[11px] font-black tracking-widest text-electric-blue uppercase font-accent">
            Tanya Jawab
          </span>
          <h2 className="font-accent text-3xl sm:text-4xl font-black text-white uppercase tracking-tight">
            Pertanyaan Yang <br />
            <span className="text-gradient-gold">Sering Ditanyakan</span>
          </h2>
          <div className="w-16 h-[3px] bg-cta-orange mt-2" />
        </div>

        {/* FAQs Accordions list */}
        <div className="flex flex-col gap-4">
          {faqs.map((faq, idx) => {
            const isOpen = openIdx === idx;
            return (
              <div
                key={faq.id}
                className={`border rounded-2xl transition-all duration-300 overflow-hidden cursor-pointer ${
                  isOpen
                    ? "bg-white/[0.04] border-white/10"
                    : "bg-white/[0.01] border-white/5 hover:border-white/10"
                }`}
                onClick={() => toggleFaq(idx)}
              >
                {/* Accordion Trigger */}
                <div className="flex items-center justify-between gap-4 p-6 sm:p-7">
                  <div className="flex items-start gap-3.5">
                    <HelpCircle size={18} className="text-cta-orange shrink-0 mt-1" />
                    <h3 className="text-sm sm:text-base font-extrabold text-white">
                      {faq.question}
                    </h3>
                  </div>
                  <div className="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center text-muted-text shrink-0">
                    {isOpen ? <Minus size={14} className="text-gold" /> : <Plus size={14} />}
                  </div>
                </div>

                {/* Accordion Content Panel */}
                <div
                  className={`transition-all duration-300 ${
                    isOpen ? "max-h-[300px] border-t border-white/5" : "max-h-0 opacity-0 pointer-events-none"
                  }`}
                >
                  <div className="p-6 sm:p-7 text-xs sm:text-sm text-muted-text leading-relaxed">
                    {faq.answer}
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
