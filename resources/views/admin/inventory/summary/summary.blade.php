@extends('admin.layout')

@section('title', 'Inventory Summary - BISNIS CLOTHING')
@section('page_title', 'Inventory Summary')
@section('page_subtitle', 'Overview of your inventory and purchase orders')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                <div>
                    <h1 class="page-title-main text-primary mb-2">Inventory Summary</h1>
                    <p class="page-subtitle-main text-gray-600">Real-time overview of your inventory performance</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" onclick="refreshAll()">
                        <i class="fas fa-sync-alt me-2"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Date Range</label>
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control" id="startDateFilter" value="{{ $start_date ?? '' }}" onchange="applyFilters()">
                                <span class="input-group-text">to</span>
                                <input type="date" class="form-control" id="endDateFilter" value="{{ $end_date ?? '' }}" onchange="applyFilters()">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select class="form-select form-select-sm" id="stockCategoryFilter" onchange="applyFilters()">
                                <option value="All">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select class="form-select form-select-sm" id="stockStatusFilter" onchange="applyFilters()">
                                <option value="All">All Status</option>
                                <option value="in_stock">In Stock</option>
                                <option value="low_stock">Low Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Search</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search products..."
                                       id="stockSearch" oninput="applyFilters()">
                                <button class="btn btn-outline-secondary" type="button" onclick="applyFilters()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- INVENTORY STOCK REPORT -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 text-dark fw-bold">
                                <i class="fas fa-boxes me-2 text-primary"></i>
                                Inventory Stock Report
                            </h5>
                            <p class="text-muted mb-0 small mt-1" id="stockReportPeriod">
                                <i class="fas fa-store me-1"></i> All Outlets •
                                <i class="fas fa-calendar me-1 ms-2"></i> Loading period...
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width: 80px;" id="stockItemsPerPage" onchange="applyFilters()">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>

                            <button class="btn btn-sm btn-outline-primary" onclick="refreshStockReport()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="stockReportTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3">Name - Variant</th>
                                    <th>Category</th>
                                    <th class="text-center">PO Incoming</th>
                                    <th class="text-center">Sales</th>
                                    <th class="text-center">Beginning Stock</th>
                                    <th class="text-center">Ending Stock</th>
                                    <th class="text-center">Stock Tersedia</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="stockReportTableBody">
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-spinner fa-spin text-primary fs-2 mb-3"></i>
                                        <p class="text-muted">Loading inventory data...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-light border-0 py-3">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <ul class="pagination pagination-sm mb-0" id="stockPagination"></ul>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="text-muted small" id="stockPaginationInfo">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-90 d-none" style="z-index: 9999;">
    <div class="d-flex flex-column align-items-center justify-content-center h-100">
        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
        <h5 class="text-dark mb-2">Loading Inventory Data</h5>
        <p class="text-muted">Please wait while we fetch the latest information...</p>
    </div>
</div>
@endsection
