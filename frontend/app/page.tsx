import Navbar from "@/components/layout/Navbar";
import HeroSection3D from "@/components/home/HeroSection3D";
import QuickBooking from "@/components/home/QuickBooking";
import AboutSection from "@/components/home/AboutSection";
import ServicesSection from "@/components/home/ServicesSection";
import FleetSection from "@/components/home/FleetSection";
import RouteSection from "@/components/home/RouteSection";
import HowItWorksSection from "@/components/home/HowItWorksSection";
import WhyChooseUs from "@/components/home/WhyChooseUs";
import Testimonials from "@/components/home/Testimonials";
import FAQSection from "@/components/home/FAQSection";
import CTASection from "@/components/home/CTASection";
import Footer from "@/components/layout/Footer";

export default function Home() {
  return (
    <>
      {/* Sticky Premium Header */}
      <Navbar />

      <main className="flex-1">
        {/* Cinematic Hero */}
        <HeroSection3D />

        {/* Floating Quick Checkout Widget */}
        <QuickBooking />

        {/* About Company Section */}
        <AboutSection />

        {/* Services Showcase */}
        <ServicesSection />

        {/* Fleet Listings & Filter Catalog */}
        <FleetSection />

        {/* Popular Inter-city Routes */}
        <RouteSection />

        {/* 4-Step Booking Tutorial */}
        <HowItWorksSection />

        {/* Brand Core Values */}
        <WhyChooseUs />

        {/* Authenticated Reviews Slider */}
        <Testimonials />

        {/* Accordions FAQ Directory */}
        <FAQSection />

        {/* Conversions Call-to-Action WhatsApp Banner */}
        <CTASection />
      </main>

      {/* Corporate Footnotes Block */}
      <Footer />
    </>
  );
}
