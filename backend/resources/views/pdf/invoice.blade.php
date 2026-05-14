<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #d97706; /* gold border */
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo-section {
            float: left;
            width: 50%;
        }
        .logo-title {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .logo-tagline {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .invoice-title-section {
            float: right;
            width: 50%;
            text-align: right;
        }
        .invoice-title {
            font-size: 26px;
            font-weight: bold;
            color: #d97706; /* Gold */
            margin: 0;
            text-transform: uppercase;
        }
        .invoice-number {
            font-size: 14px;
            color: #475569;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .clear {
            clear: both;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-col {
            width: 50%;
            vertical-align: top;
        }
        .section-heading {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .info-details {
            font-size: 12px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            color: #64748b;
            width: 110px;
            display: inline-block;
        }
        .info-value {
            font-weight: bold;
            color: #0f172a;
        }
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-items th {
            background-color: #0f172a; /* dark header */
            color: #ffffff;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #0f172a;
        }
        .table-items td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            vertical-align: top;
        }
        .table-items tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right !important;
        }
        .summary-section {
            float: right;
            width: 40%;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 5px;
            font-size: 12px;
        }
        .summary-label {
            color: #64748b;
        }
        .summary-value {
            font-weight: bold;
            text-align: right;
            color: #0f172a;
        }
        .total-row td {
            border-top: 2px solid #e2e8f0;
            border-bottom: 2px solid #d97706;
            padding: 12px 5px;
        }
        .total-label {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }
        .total-value {
            font-size: 18px;
            font-weight: bold;
            color: #d97706;
        }
        .payment-instructions {
            float: left;
            width: 55%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
        }
        .payment-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .payment-bank {
            font-weight: bold;
            color: #d97706;
            margin-bottom: 3px;
        }
        .payment-desc {
            font-size: 11px;
            color: #475569;
            margin: 5px 0 0 0;
        }
        .footer {
            margin-top: 60px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <h1 class="logo-title">BYLIAN TRANSPORTASI</h1>
            <p class="logo-tagline">Solusi Transportasi Aman, Nyaman, dan Tepat Waktu</p>
        </div>
        <div class="invoice-title-section">
            <h2 class="invoice-title">Bukti Pemesanan</h2>
            <p class="invoice-number">No: {{ $booking->invoice->invoice_number ?? 'INV/Auto/' . $booking->booking_code }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Info Grid -->
    <table class="info-grid">
        <tr>
            <!-- Customer Details -->
            <td class="info-col">
                <div class="section-heading">Informasi Pelanggan</div>
                <div class="info-details">
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">: {{ $booking->customer_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Telepon</span>
                        <span class="info-value">: {{ $booking->customer_phone }}</span>
                    </div>
                    @if($booking->customer_email)
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">: {{ $booking->customer_email }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Tanggal Cetak</span>
                        <span class="info-value">: {{ now()->format('d M Y - H:i') }} WIB</span>
                    </div>
                </div>
            </td>
            <!-- Booking Details -->
            <td class="info-col">
                <div class="section-heading">Detail Pemesanan</div>
                <div class="info-details">
                    <div class="info-row">
                        <span class="info-label">Kode Booking</span>
                        <span class="info-value" style="color:#d97706;">: {{ $booking->booking_code }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tgl Penjemputan</span>
                        <span class="info-value">: {{ $booking->pickup_date->format('d M Y') }} - {{ substr($booking->pickup_time, 0, 5) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Pesanan</span>
                        <span class="info-value">: {{ strtoupper($booking->booking_status) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status Bayar</span>
                        <span class="info-value">: {{ strtoupper($booking->payment_status) }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Table Items -->
    <table class="table-items">
        <thead>
            <tr>
                <th style="width: 55%">Deskripsi Layanan / Rute</th>
                <th style="width: 25%">Armada</th>
                <th style="width: 5%" class="text-right">Qty</th>
                <th style="width: 15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $booking->service?->title ?? 'Layanan Transportasi' }}</strong><br>
                    <span style="font-size: 11px; color:#475569;">
                        <strong>Jemput:</strong> {{ $booking->pickup_location }}<br>
                        <strong>Tujuan:</strong> {{ $booking->dropoff_location }}
                    </span>
                    @if($booking->notes)
                        <br><span style="font-size: 11px; font-style: italic; color:#64748b;">Catatan: {{ $booking->notes }}</span>
                    @endif
                </td>
                <td>
                    {{ $booking->vehicle?->name ?? 'Avanza / Hiace / unit Standard' }}<br>
                    <span style="font-size: 11px; color:#475569;">{{ $booking->vehicle?->plate_number ?? '-' }}</span>
                </td>
                <td class="text-right">{{ $booking->passenger_count }} pax</td>
                <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Bottom Section -->
    <div>
        <!-- Payment Instructions -->
        <div class="payment-instructions">
            <h4 class="payment-title">Petunjuk Pembayaran</h4>
            <div class="payment-bank">BANK MANDIRI (Rekening Resmi)</div>
            <div style="font-size:12px; font-weight:bold; color:#0f172a; margin-bottom: 5px;">No. Rekening: 131-00-17931-123</div>
            <div style="font-size:11px; color:#475569;">Atas Nama: <strong>CV. Bylian Transportasi Group</strong></div>
            <p class="payment-desc">
                * Harap transfer tepat sesuai total nominal di atas.<br>
                * Kirimkan screenshot bukti transfer Anda ke WhatsApp CS Bylian Transportasi di <strong>0812-3456-7890</strong> untuk verifikasi instan.
            </p>
        </div>

        <!-- Summary -->
        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">Subtotal</td>
                    <td class="summary-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Diskon / Promo</td>
                    <td class="summary-value">Rp 0</td>
                </tr>
                <tr>
                    <td class="summary-label">Biaya Pajak (Ppn)</td>
                    <td class="summary-value">Rp 0</td>
                </tr>
                <tr class="total-row">
                    <td class="total-label">Total Dues</td>
                    <td class="total-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Bylian Transportasi &copy; {{ date('Y') }} — Solusi Perjalanan VIP Anda. Terima kasih atas kepercayaan Anda.</p>
    </div>
</div>

</body>
</html>
