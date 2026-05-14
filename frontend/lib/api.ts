import axios from 'axios';

// Backend Base URL - easily pointing to the local Laravel server
const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8080';

const client = axios.create({
  baseURL: `${API_BASE_URL}/api`,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
  withCredentials: true,
  withXSRFToken: true,
});

export const api = {
  // Fetch lists
  getServices: async () => {
    const response = await client.get('/services');
    return response.data;
  },

  getVehicles: async () => {
    const response = await client.get('/vehicles');
    return response.data;
  },

  getVehicleCategories: async () => {
    const response = await client.get('/vehicle-categories');
    return response.data;
  },

  getRoutes: async () => {
    const response = await client.get('/routes');
    return response.data;
  },

  getFaqs: async () => {
    const response = await client.get('/faqs');
    return response.data;
  },

  getTestimonials: async () => {
    const response = await client.get('/testimonials');
    return response.data;
  },

  getSettings: async () => {
    const response = await client.get('/settings');
    return response.data;
  },

  // Post forms
  createBooking: async (data: {
    customer_name: string;
    customer_phone: string;
    customer_email?: string;
    service_id: number;
    route_id?: number;
    schedule_id?: number;
    vehicle_id?: number;
    pickup_location: string;
    dropoff_location: string;
    pickup_date: string;
    pickup_time: string;
    passenger_count: number;
    total_price: number;
    notes?: string;
  }) => {
    const response = await client.post('/bookings', data);
    return response.data;
  },

  createCharter: async (data: {
    name: string;
    phone: string;
    email?: string;
    pickup_location: string;
    destination: string;
    trip_type: string;
    departure_date: string;
    return_date?: string;
    passenger_count: number;
    vehicle_preference?: string;
    duration?: string;
    message?: string;
    estimated_budget?: number;
  }) => {
    const response = await client.post('/charter-requests', data);
    return response.data;
  },

  createContactInquiry: async (data: {
    name: string;
    phone: string;
    email?: string;
    subject?: string;
    message: string;
  }) => {
    const response = await client.post('/contact-inquiries', data);
    return response.data;
  },

  // Check booking status
  checkBookingStatus: async (code: string, phone: string) => {
    // Falls back to direct booking API route (or custom check status endpoint if registered)
    const response = await client.get(`/bookings/check`, {
      params: { code, phone },
    });
    return response.data;
  },

  // Payments
  createSnapToken: async (data: { booking_id: number | string }) => {
    const response = await client.post('/payments/snap-token', data);
    return response.data;
  },
};
