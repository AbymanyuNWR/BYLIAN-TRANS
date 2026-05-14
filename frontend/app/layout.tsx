import type { Metadata } from "next";
import { Plus_Jakarta_Sans, Montserrat } from "next/font/google";
import "./globals.css";
import SmoothScrollProvider from "@/components/animation/SmoothScrollProvider";
import Script from "next/script";

const plusJakartaSans = Plus_Jakarta_Sans({
  subsets: ["latin"],
  variable: "--font-sans",
  weight: ["300", "400", "500", "600", "700", "800"],
});

const montserrat = Montserrat({
  subsets: ["latin"],
  variable: "--font-accent",
  weight: ["400", "500", "600", "700", "800", "900"],
});

export const metadata: Metadata = {
  title: "Bylian Trans - Sewa Mobil, Travel Antar Kota & Charter Premium",
  description: "Bylian Trans menyediakan layanan sewa mobil harian dengan driver, travel Bandung-Jakarta PP, sewa Hiace pariwisata, dan antar jemput bandara tepercaya. Armada bersih, aman & tepat waktu.",
  keywords: "travel bandung jakarta, rental mobil bandung, sewa mobil murah, sewa hiace pariwisata, antar jemput bandara, bylian trans, bylian transportasi",
  openGraph: {
    title: "Bylian Trans - Sewa Mobil, Travel Antar Kota & Charter Premium",
    description: "Layanan rental mobil, travel, dan charter premium terpercaya di Indonesia dengan pengemudi profesional dan armada terawat harian.",
    type: "website",
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="id" className={`${plusJakartaSans.variable} ${montserrat.variable} scroll-smooth`}>
      <body className="bg-primary-dark text-foreground font-sans antialiased selection:bg-cta-orange selection:text-primary-dark">
        <Script 
          src="https://app.sandbox.midtrans.com/snap/snap.js" 
          data-client-key={process.env.NEXT_PUBLIC_MIDTRANS_CLIENT_KEY}
          strategy="beforeInteractive"
        />
        <SmoothScrollProvider>
          <div className="relative min-h-screen flex flex-col justify-between overflow-x-hidden">
            {children}
          </div>
        </SmoothScrollProvider>
      </body>
    </html>
  );
}
