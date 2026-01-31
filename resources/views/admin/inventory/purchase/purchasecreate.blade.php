@extends('admin.layout')

@section('title', 'Create Purchase Order - BONUS CLOTHING')
@section('page_title', 'Create Purchase Order')
@section('page_subtitle', 'Add new items to your inventory')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5">

    {{-- HEADER --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                <div>
                    <h1 class="page-title-main text-primary mb-2">Create Purchase Order</h1>
                    <p class="page-subtitle-main text-gray-600">Add new inventory items from suppliers</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.inventory.purchase.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="card-title mb-0 text-dark fw-bold">
                        <i class="fas fa-info-circle me-2 text-primary"></i> Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.inventory.purchase.store') }}"
                          id="createPOForm">
                        @csrf

                        <div class="row g-4">
                            {{-- OUTLET --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-store me-2 text-primary"></i>
                                    Outlet <span class="text-danger">*</span>
                                </label>
                                <select class="form-select"
                                        name="outlet"
                                        id="outletSelect"
                                        required>
                                    <option value="" disabled selected>Select Outlet</option>
                                    @forelse ($outlets ?? [] as $outlet)
                                        <option value="{{ $outlet }}">{{ $outlet }}</option>
                                    @empty
                                        <option value="Main Outlet">Main Outlet</option>
                                        <option value="Outlet 2">Outlet 2</option>
                                        <option value="Outlet 3">Outlet 3</option>
                                    @endforelse
                                </select>
                            </div>

                            {{-- SUPPLIER --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-truck me-2 text-primary"></i> Supplier
                                </label>
                                <select class="form-select" name="supplier_id">
                                    <option value="">-- Select Supplier --</option>
                                    @foreach ($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- NOTES --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-sticky-note me-2 text-primary"></i> Order Notes
                                </label>
                                <textarea class="form-control"
                                          name="note"
                                          rows="3"></textarea>
                            </div>
                        </div>

                        {{-- HIDDEN --}}
                        <input type="hidden" name="selected_items" id="selectedItemsInput">
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                        <input type="hidden" name="action" id="actionInput" value="create">
                    </form>
                </div>
            </div>

            {{-- ITEMS --}}
            @if (!empty($products) && count($products) > 0)
                @include('admin.inventory.purchase._items_table')
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p>No products available</p>
                    <a href="{{ route('admin.inventory.item.create') }}" class="btn btn-primary">
                        Add Product
                    </a>
                </div>
            @endif
        </div>

        {{-- SIDEBAR --}}
        @include('admin.inventory.purchase._summary_sidebar')
    </div>
</div>
@endsection
