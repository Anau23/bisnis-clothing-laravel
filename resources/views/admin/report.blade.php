@extends('admin.layout')

@section('title', 'Laporan Penjualan - Bonus Clothing')
@section('page_title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ url('/admin/print/report/pdf') }}" 
       target="_blank"
       class="btn btn-danger">
        <i class="fas fa-file-pdf me-2"></i> Export PDF
    </a>
    <a href="{{ url('/admin/print/report') }}" 
        target="_blank"
        class="btn btn-outline-secondary me-2">
        <i class="fas fa-print me-1"></i> Print
        </a>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-semibold mb-3">Laporan Penjualan</h4>

                    <p class="text-muted">
                        Halaman laporan akan segera dilengkapi.
                    </p>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
