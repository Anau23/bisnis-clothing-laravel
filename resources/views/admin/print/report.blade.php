<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Analytics Report - {{ $report['store_name'] }}</title>

    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: Arial, sans-serif; font-size: 12pt; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; }
        .store-name { font-size: 24pt; font-weight: bold; }
        .store-info { font-size: 10pt; }
        .report-title { font-size: 16pt; font-weight: bold; margin-top: 15px; }
        .section-title { font-size: 14pt; font-weight: bold; margin: 25px 0 10px; border-bottom: 1px solid #000; }
        table { width: 100%; border-collapse: collapse; font-size: 10pt; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { background: #f2f2f2; font-weight: bold; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .summary-card { border: 1px solid #000; padding: 10px; text-align: center; }
        .summary-label { font-size: 10pt; text-transform: uppercase; }
        .summary-value { font-size: 16pt; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 9pt; text-align: center; border-top: 1px solid #000; }
        .no-print { display: none; }
    </style>
</head>

<body>

{{-- ================= HEADER ================= --}}
<div class="header">
    <div class="store-name">{{ $report['store_name'] }}</div>
    <div class="store-info">
        {{ $report['store_address'] }} | Telp: {{ $report['store_phone'] }}
    </div>
    <div class="report-title">LAPORAN ANALITIK BISNIS</div>
    <div>
        Periode: {{ $report['start_date'] }} s/d {{ $report['end_date'] }}<br>
        Dicetak: {{ $report['generated_at'] }} oleh {{ $report['generated_by'] }}
    </div>
</div>

{{-- ================= SUMMARY ================= --}}
<div class="section-title">RINGKASAN KINERJA</div>
<div class="summary-grid">
    <div class="summary-card">
        <div class="summary-label">Total Penjualan</div>
        <div class="summary-value">Rp {{ number_format($report['total_sales'], 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Total Transaksi</div>
        <div class="summary-value">{{ $report['total_transactions'] }}</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Rata-rata Transaksi</div>
        <div class="summary-value">Rp {{ number_format($report['average_transaction'], 0, ',', '.') }}</div>
    </div>
</div>

{{-- ================= FINANCIAL ================= --}}
<div class="section-title">RINGKASAN KEUANGAN</div>
@php
    $netProfit = $report['total_sales']
        - $report['total_discount']
        + $report['total_tax']
        - $report['purchase_total'];
@endphp

<table>
    <tr>
        <td>Total Penjualan</td>
        <td class="text-right">Rp {{ number_format($report['total_sales'],0,',','.') }}</td>
        <td class="text-right">100%</td>
    </tr>
    <tr>
        <td>Diskon</td>
        <td class="text-right">- Rp {{ number_format($report['total_discount'],0,',','.') }}</td>
        <td class="text-right">
            {{ $report['total_sales'] > 0 ? round($report['total_discount']/$report['total_sales']*100,2) : 0 }}%
        </td>
    </tr>
    <tr>
        <td>Pajak</td>
        <td class="text-right">+ Rp {{ number_format($report['total_tax'],0,',','.') }}</td>
        <td class="text-right">
            {{ $report['total_sales'] > 0 ? round($report['total_tax']/$report['total_sales']*100,2) : 0 }}%
        </td>
    </tr>
    <tr class="total-row">
        <td>LABA / RUGI BERSIH</td>
        <td class="text-right">Rp {{ number_format($netProfit,0,',','.') }}</td>
        <td class="text-right">
            {{ $report['total_sales'] > 0 ? round($netProfit/$report['total_sales']*100,2) : 0 }}%
        </td>
    </tr>
</table>

{{-- ================= DAILY ================= --}}
<div class="section-title">TRANSAKSI HARIAN</div>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th class="text-right">Transaksi</th>
            <th class="text-right">Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report['daily_data'] as $day)
        <tr>
            <td>{{ $day['date'] }}</td>
            <td class="text-right">{{ $day['transactions'] }}</td>
            <td class="text-right">Rp {{ number_format($day['sales'],0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= TOP PRODUCTS ================= --}}
<div class="section-title">PRODUK TERLARIS</div>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th class="text-right">Terjual</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($report['top_products'] as $i => $product)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $product['name'] }}</td>
            <td class="text-right">{{ $product['quantity_sold'] }}</td>
            <td class="text-right">Rp {{ number_format($product['total_sales'],0,',','.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= FOOTER ================= --}}
<div class="footer">
    <div>Laporan dibuat otomatis oleh sistem</div>
    <div>Dicetak: {{ $report['generated_at'] }}</div>
</div>

<script>
    window.onload = function () {
        // window.print();
    };
</script>

</body>
</html>
