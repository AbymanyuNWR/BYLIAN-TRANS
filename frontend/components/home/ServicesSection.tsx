"use client";

import { useState, useEffect } from "react";
import { ArrowRight, Car, Compass, Plane, Users, Building2, MapPin, X, CheckCircle2 } from "lucide-react";
import { useRouter } from "next/navigation";
import { api } from "@/lib/api";

const fallbackServices = [
  {
    id: 1,
    title: "Sewa Mobil",
    icon: "car",
    image: "/service_sewa_mobil.png",
    short_description: "Sewa mobil harian, mingguan atau bulanan dengan pilihan armada terbaik.",
    long_desc: "Layanan sewa mobil harian, mingguan, atau bulanan yang dirancang khusus untuk kenyamanan mobilitas Anda. Kami menawarkan pilihan armada terawat mulai dari hatchback ekonomis, MPV keluarga yang luas, hingga SUV premium tangguh.",
    benefits: ["Pilihan Lepas Kunci / Dengan Driver", "Asuransi Perjalanan Komprehensif", "Layanan Emergency Roadside 24 Jam", "Kondisi Interior Bersih & Wangi"],
  },
  {
    id: 2,
    title: "Travel Antar Kota",
    icon: "travel",
    image: "/service_travel_kota.png",
    short_description: "Perjalanan antar kota nyaman, aman, dan tepat waktu.",
    long_desc: "Layanan travel reguler point-to-point eksekutif yang menghubungkan kota-kota besar (seperti koridor Jakarta - Bandung). Menawarkan kenyamanan berkendara kelas satu dengan titik jemput dan antar yang fleksibel.",
    benefits: ["Full Tol Trans Jawa & Cipularang", "Armada Nyaman dengan Reclining Seat", "Gratis Air Mineral & Snack Paket", "Jaminan Tepat Waktu Keberangkatan"],
  },
  {
    id: 3,
    title: "Antar Jemput Bandara",
    icon: "plane",
    image: "/service_antar_bandara.png",
    short_description: "Layanan antar jemput bandara 24/7 tepat waktu dan nyaman.",
    long_desc: "Layanan penjemputan dan pengantaran bandara khusus (Soekarno-Hatta CGK, Halim HLP, Kertajati KJT) dengan sistem reservasi awal. Driver kami akan standby minimal 30 menit sebelum jadwal kedatangan pesawat Anda.",
    benefits: ["Gratis Biaya Menunggu Delay Pesawat", "Bantuan Penanganan Bagasi", "Tarif All-In (Tol, Parkir, Driver)", "Standby Monitor Penerbangan Realtime"],
  },
  {
    id: 4,
    title: "Charter Kendaraan",
    icon: "charter",
    image: "/service_charter_kendaraan.png",
    short_description: "Sewa kendaraan untuk rombongan, acara, atau kebutuhan khusus.",
    long_desc: "Sewa mobil rombongan privat berskala sedang hingga besar menggunakan unit Hiace Commuter, Hiace Premio, Coaster, atau Minibus. Sangat ideal untuk kegiatan reuni, pernikahan keluarga, ziarah, atau kunjungan kerja.",
    benefits: ["Kapasitas Lega hingga 14-19 Penumpang", "Driver Menguasai Medan Jalan Wisata", "Fasilitas Entertainment TV/Audio/Karaoke", "Jadwal Perjalanan Sangat Fleksibel"],
  },
  {
    id: 5,
    title: "Wisata & Tour",
    icon: "tour",
    image: "/service_wisata_tour.png",
    short_description: "Paket wisata menarik dengan kendaraan nyaman dan driver berpengalaman.",
    long_desc: "Nikmati liburan tak terlupakan dengan paket wisata terkurasi di berbagai destinasi favorit Jawa Barat, Jakarta, hingga Yogyakarta. Dilengkapi pemandu wisata profesional dan rincian destinasi yang menarik.",
    benefits: ["Rekomendasi Kuliner Terlaris Lokal", "Termasuk Tiket Masuk Objek Wisata", "Dokumentasi Foto Perjalanan", "Armada Mewah Nyaman Selama Wisata"],
  },
  {
    id: 6,
    title: "Transportasi Corporate",
    icon: "corporate",
    image: "/service_corporate.png",
    short_description: "Solusi transportasi untuk perusahaan, event, dan karyawan.",
    long_desc: "Kemitraan jangka panjang eksklusif untuk kebutuhan dinas operasional perusahaan, antar-jemput karyawan pabrik/kantor, serta transportasi VIP tamu kehormatan korporat dengan standar keamanan dan privasi tinggi.",
    benefits: ["Sistem Pembayaran Invoice Bulanan", "Armada Back-up Selalu Siaga", "Pengemudi Berbahasa Inggris (Opsional)", "Laporan Perjalanan Operasional Detail"],
  },
];

export default function ServicesSection() {
  const router = useRouter();
  const [services, setServices] = useState<any[]>(fallbackServices);
  const [isLoading, setIsLoading] = useState(true);
  
  // Modal State
  const [activeService, setActiveService] = useState<any | null>(null);

  useEffect(() => {
    api.getServices()
      .then((res) => {
        if (res.success && res.data.length > 0) {
          const mapped = res.data.map((item: any, idx: number) => ({
            ...item,
            icon: item.icon || fallbackServices[idx]?.icon || "car",
            image: fallbackServices[idx % 6]?.image,
            long_desc: item.long_desc || fallbackServices[idx % 6]?.long_desc,
            benefits: item.benefits || fallbackServices[idx % 6]?.benefits,
          }));
          setServices(mapped);
        }
      })
      .catch(() => {
        // Already initialized with fallback
      })
      .finally(() => {
        setIsLoading(false);
      });
  }, []);

  const getServiceIcon = (iconName: string) => {
    switch (iconName) {
      case "car":
        return <Car className="w-6 h-6 text-cta-orange" />;
      case "travel":
        return <MapPin className="w-6 h-6 text-electric-blue" />;
      case "plane":
        return <Plane className="w-6 h-6 text-[#FBBF24]" />;
      case "charter":
        return <Users className="w-6 h-6 text-electric-blue" />;
      case "tour":
        return <Compass className="w-6 h-6 text-cta-orange" />;
      case "corporate":
        return <Building2 className="w-6 h-6 text-electric-blue" />;
      default:
        return <Car className="w-6 h-6 text-cta-orange" />;
    }
  };

  const handleBookingRedirect = (serviceId: number) => {
    const bookingParams = {
      pickup_location: "",
      dropoff_location: "",
      pickup_date: new Date().toISOString().split("T")[0],
      pickup_time: "08:00",
      passenger_count: 1,
      service_id: serviceId,
    };
    sessionStorage.setItem("quick_booking_data", JSON.stringify(bookingParams));
    setActiveService(null);
    router.push("/booking");
  };

  return (
    <section id="layanan" className="relative py-24 bg-[#030712] overflow-hidden">
      {/* Ambient Lighting Accents */}
      <div className="absolute top-1/2 left-0 w-[400px] h-[400px] bg-electric-blue/5 rounded-full blur-[120px] pointer-events-none" />

      <div className="max-w-7xl mx-auto px-6 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center gap-3 mb-16">
          <h2 className="font-accent text-3xl sm:text-4xl font-black text-white uppercase tracking-tight">
            Layanan Kami
          </h2>
          <p className="text-xs sm:text-sm text-muted-text max-w-xl leading-relaxed">
            Berbagai pilihan layanan transportasi eksklusif untuk setiap kebutuhan mobilitas Anda
          </p>
        </div>

        {/* Services Grid Layout with Commercial Image Banners */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          {services.map((srv) => (
            <div
              key={srv.id}
              className="glass-card rounded-3xl overflow-hidden flex flex-col justify-between items-stretch hover:translate-y-[-8px] hover:border-[#FBBF24]/30 transition-all duration-500 group bg-[#0B1726]/60 border border-white/10 shadow-2xl flex-grow"
            >
              <div>
                {/* High-Resolution Commercial Image Banner Container */}
                <div className="relative w-full h-52 overflow-hidden bg-slate-900">
                  <div 
                    className="absolute inset-0 w-full h-full bg-cover bg-center transform group-hover:scale-110 transition-transform duration-700 ease-out"
                    style={{ backgroundImage: `url(${srv.image})` }}
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-[#0B1726] via-transparent to-transparent opacity-90" />

                  {/* Icon Badge Overlay */}
                  <div className="absolute bottom-4 left-6 w-12 h-12 rounded-2xl bg-[#0B1726]/80 border border-white/20 backdrop-blur-md flex items-center justify-center shadow-xl group-hover:rotate-12 transition-transform">
                    {getServiceIcon(srv.icon)}
                  </div>
                </div>

                {/* Content Box */}
                <div className="p-6 pt-4 text-left">
                  <h3 className="font-accent text-lg font-black text-white tracking-wide uppercase group-hover:text-amber-400 transition-colors">
                    {srv.title}
                  </h3>
                  <p className="text-xs text-muted-text mt-2.5 leading-relaxed">
                    {srv.short_description}
                  </p>
                </div>
              </div>

              {/* Action Trigger Block */}
              <div className="px-6 pb-6 pt-2">
                <button
                  onClick={() => setActiveService(srv)}
                  className="w-full py-3 px-4 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-bold text-electric-blue hover:text-amber-400 flex items-center justify-between transition-all font-accent tracking-wider uppercase cursor-pointer group-hover:border-electric-blue/40"
                >
                  <span>Selengkapnya</span>
                  <ArrowRight size={14} className="transform group-hover:translate-x-1 transition-transform" />
                </button>
              </div>
            </div>
          ))}
        </div>

      </div>

      {/* DETAILED SERVICE MODAL */}
      {activeService && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#030712]/80 backdrop-blur-md animate-fadeIn">
          <div className="relative w-full max-w-xl bg-[#0B1726]/95 border border-white/15 rounded-3xl overflow-hidden shadow-2xl max-h-[90vh] flex flex-col">
            
            {/* Modal Header Banner Image */}
            <div className="relative w-full h-48 bg-slate-900 shrink-0">
              <div 
                className="absolute inset-0 w-full h-full bg-cover bg-center"
                style={{ backgroundImage: `url(${activeService.image})` }}
              />
              <div className="absolute inset-0 bg-gradient-to-t from-[#0B1726] via-[#0B1726]/40 to-transparent" />
              
              <button
                onClick={() => setActiveService(null)}
                className="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/40 border border-white/20 hover:bg-black/60 flex items-center justify-center text-white backdrop-blur-md transition-all cursor-pointer z-10"
              >
                <X size={18} />
              </button>

              <div className="absolute bottom-4 left-6 flex items-center gap-3.5">
                <div className="w-12 h-12 rounded-2xl bg-[#0B1726] border border-white/20 flex items-center justify-center shadow-xl">
                  {getServiceIcon(activeService.icon)}
                </div>
                <div>
                  <span className="text-[9px] text-[#FBBF24] font-black uppercase tracking-widest font-accent block">LAYANAN UNGGULAN</span>
                  <h3 className="text-xl font-accent font-black text-white uppercase tracking-tight mt-0.5">
                    {activeService.title}
                  </h3>
                </div>
              </div>
            </div>

            {/* Scrollable Body */}
            <div className="p-6 sm:p-8 overflow-y-auto text-left flex-grow">
              <p className="text-xs text-white/90 leading-relaxed border-b border-white/10 pb-5 mb-5 bg-white/5 p-4 rounded-2xl border border-white/5">
                {activeService.long_desc}
              </p>

              <div className="flex flex-col gap-3 mb-6">
                <h4 className="text-[10px] text-amber-400 font-black uppercase tracking-widest font-accent">Fasilitas & Keunggulan Layanan</h4>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1">
                  {activeService.benefits?.map((benefit: string, bIdx: number) => (
                    <div key={bIdx} className="flex items-start gap-2.5 bg-white/5 p-2.5 rounded-xl border border-white/5">
                      <CheckCircle2 size={15} className="text-blue-400 shrink-0 mt-0.5" />
                      <span className="text-[11px] text-white/80 font-medium leading-tight">{benefit}</span>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            {/* Modal Bottom CTA */}
            <div className="p-6 pt-4 border-t border-white/10 bg-[#0B1726] grid grid-cols-2 gap-4 shrink-0">
              <button
                onClick={() => setActiveService(null)}
                className="w-full bg-white/5 border border-white/10 hover:bg-white/10 text-white font-accent font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider transition-all cursor-pointer"
              >
                Kembali
              </button>
              <button
                onClick={() => handleBookingRedirect(activeService.id)}
                className="w-full bg-gradient-to-r from-[#F59E0B] to-[#FBBF24] text-primary-dark font-accent font-black py-3.5 rounded-xl text-xs uppercase tracking-wider flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform duration-300 shadow-xl shadow-amber-500/10 cursor-pointer"
              >
                <span>Pesan Sekarang</span>
                <ArrowRight size={14} className="stroke-[3]" />
              </button>
            </div>

          </div>
        </div>
      )}
    </section>
  );
}
