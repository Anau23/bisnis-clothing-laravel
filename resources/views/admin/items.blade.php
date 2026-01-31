@extends('admin.layout')

@section('title', 'Items - Bonus Clothing')
@section('page_title', 'Items')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-semibold mb-3">Items</h4>

                    <p class="text-muted">
                        Halaman ini akan segera dilengkapi.
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
