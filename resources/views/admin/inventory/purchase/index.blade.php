@extends('admin.layout')

@section('page_title', 'Purchase Orders')
@section('page_subtitle', 'Manage and track your purchase orders')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5">

    {{-- HEADER --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                <div>
                    <h1 class="page-title-main text-primary mb-2">Purchase Orders</h1>
                    <p class="page-subtitle-main text-gray-600">Track and manage all purchase orders</p>
                </div>

                <div class="d-flex gap-2">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" id="bulkActionsBtn">
                            <i class="fas fa-bolt me-2"></i> Bulk Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" id="allApproveBtn">
                                    <i class="fas fa-check-circle me-2 text-success"></i> Approve All Pending
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" id="allFulfillBtn">
                                    <i class="fas fa-truck me-2 text-info"></i> Fulfill All Approved
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" id="deleteFulfilledBtn">
                                    <i class="fas fa-trash me-2"></i> Delete Fulfilled
                                </a>
                            </li>
                        </ul>
                    </div>

                    <button class="btn btn-primary" disabled>
                        Create Purchase (Coming Soon)
                    </button>

                </div>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row mb-5">
        @php
            $summary = $status_summary ?? null;
        @endphp

        @foreach ([
            ['pending','clock','primary'],
            ['approved','check-circle','emerald-600'],
            ['fulfilled','truck','cyan-600'],
            ['cancelled','times-circle','red-600']
        ] as [$key,$icon,$color])
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-container me-3">
                        <i class="fas fa-{{ $icon }} text-{{ $color }}"></i>
                    </div>
                    <div>
                        <div class="stat-value" id="{{ $key }}Count">
                            {{ $summary->$key ?? 0 }}
                        </div>
                        <div class="stat-label">{{ ucfirst($key) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.inventory.purchase.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Outlet</label>
                        <select class="form-select" name="outlet">
                            <option value="All Outlets">All Outlets</option>
                            @foreach($outlets ?? [] as $outlet)
                                <option value="{{ $outlet }}" @selected(($filter_outlet ?? '')==$outlet)>
                                    {{ $outlet }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="All Status">All Status</option>
                            @foreach(['pending','approved','fulfilled','cancelled'] as $st)
                                <option value="{{ $st }}" @selected(($filter_status ?? '')==$st)>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" name="start_date" value="{{ $filter_start_date ?? '' }}">
                            <span class="input-group-text">to</span>
                            <input type="text" class="form-control datepicker" name="end_date" value="{{ $filter_end_date ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i> Apply
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body p-0">
            @php
                $items = $purchase_orders instanceof \Illuminate\Pagination\AbstractPaginator
                    ? $purchase_orders->items()
                    : $purchase_orders;
            @endphp

            @if(count($items))
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="purchaseOrdersTable">
                    <thead>
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="selectAllCheckbox"></th>
                            <th>PO NUMBER</th>
                            <th>VENDOR</th>
                            <th>OUTLET</th>
                            <th>DATE</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                            <th class="text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseOrdersTableBody">
                        @foreach($items as $po)
                        <tr data-po-id="{{ $po->id }}" data-status="{{ $po->status }}">
                            <td class="ps-4">
                                <input type="checkbox" class="po-checkbox"
                                       value="{{ $po->id }}"
                                       data-status="{{ $po->status }}"
                                       data-po-number="{{ $po->po_number }}">
                            </td>

                            <td>
                                <strong>{{ $po->po_number }}</strong><br>
                                <small>{{ count($po->items ?? []) }} items</small>
                            </td>

                            <td>
                                <div class="fw-medium">{{ $po->supplier ?? 'No Vendor' }}</div>
                                <small>{{ Str::limit($po->note ?? 'No note',30) }}</small>
                            </td>

                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $po->outlet }}
                                </span>
                            </td>

                            <td>
                                {{ optional($po->created_at)->format('d M Y') }}<br>
                                <small>{{ optional($po->created_at)->format('H:i') }}</small>
                            </td>

                            <td class="fw-bold">$ {{ number_format($po->total_amount ?? 0,0) }}</td>

                            <td>
                                <span class="badge bg-opacity-10 text-{{ $po->status }}">
                                    {{ ucfirst($po->status) }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary view-detail-btn"
                                        data-po-id="{{ $po->id }}"
                                        data-po-number="{{ $po->po_number }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="text-center py-5">
                <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                <p>No Purchase Orders Found</p>
            </div>
            @endif

            {{-- PAGINATION --}}
            @if($purchase_orders instanceof \Illuminate\Pagination\AbstractPaginator)
                <div class="card-footer">
                    {{ $purchase_orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --primary-blue: #2c7be5;
        --primary-blue-dark: #1c65c9;
        --primary-blue-light: #edf2f9;
        --secondary-blue: #6e84a3;
        --light-gray: #f8fafc;
        --border-color: #e3ebf6;
        --text-dark: #12263f;
        --text-gray: #6e84a3;
    }

    body {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Page Title */
    .page-title-main {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle-main {
        color: var(--text-gray);
        font-size: 1rem;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: white;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(44, 123, 229, 0.1) !important;
    }

    .card-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid var(--border-color);
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.08);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(52, 152, 219, 0.12);
    }

    .stat-icon-container {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-blue-light) 0%, #e3f2fd 100%);
        color: var(--primary-blue);
        font-size: 1.25rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 4px;
    }

    .stat-label {
        color: var(--text-gray);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Pagination Styling */
    .pagination {
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.875rem;
        --bs-pagination-color: var(--text-dark);
        --bs-pagination-bg: transparent;
        --bs-pagination-border-width: 1px;
        --bs-pagination-border-color: var(--border-color);
        --bs-pagination-border-radius: 8px;
        --bs-pagination-hover-color: var(--primary-blue);
        --bs-pagination-hover-bg: var(--primary-blue-light);
        --bs-pagination-hover-border-color: var(--primary-blue);
        --bs-pagination-focus-color: var(--primary-blue);
        --bs-pagination-focus-bg: var(--primary-blue-light);
        --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: var(--primary-blue);
        --bs-pagination-active-border-color: var(--primary-blue);
        --bs-pagination-disabled-color: var(--text-gray);
        --bs-pagination-disabled-bg: transparent;
        --bs-pagination-disabled-border-color: var(--border-color);
    }

    .page-link {
        border-radius: 8px;
        margin: 0 2px;
        font-weight: 500;
        min-width: 36px;
        text-align: center;
    }

    .page-item.active .page-link {
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    }

    /* Search Container */
    .search-container {
        position: relative;
        flex: 1;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-gray);
    }

    .search-input {
        width: 100%;
        padding: 10px 20px 10px 44px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: white;
        color: var(--text-dark);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
    }

    /* Table Styling */
    #purchaseOrdersTable th {
        font-weight: 600;
        color: var(--text-dark);
        border-bottom: 2px solid var(--border-color);
    }

    #purchaseOrdersTable td {
        vertical-align: middle;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .po-icon-circle {
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .po-row:hover .po-icon-circle {
        transform: scale(1.1);
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%) !important;
        color: white !important;
    }

    .po-row:hover .po-icon-circle i {
        color: white !important;
    }

    /* Badge Styling */
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
        border-radius: 6px;
    }

    /* Button Styling */
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border: none;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-blue-dark) 0%, var(--primary-blue) 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    }

    /* Checkbox Styling */
    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        border: 2px solid var(--border-color);
    }

    .form-check-input:checked {
        background-color: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
        border-color: var(--primary-blue);
    }

    /* Bulk Actions Dropdown */
    .btn-group .dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    .dropdown-menu {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 200px;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .dropdown-item:hover {
        background-color: var(--light-gray);
        color: var(--text-dark);
    }

    .dropdown-item:active {
        background-color: var(--primary-blue-light);
    }

    .dropdown-item.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Selected Counter */
    .selected-counter {
        animation: fadeIn 0.3s ease;
    }

    /* Modal Specific Styles */
    .info-card {
        padding: 12px;
        background: var(--light-gray);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    /* Empty State */
    .empty-state {
        padding: 48px 24px;
    }

    .empty-state-icon {
        color: var(--primary-blue);
        opacity: 0.7;
    }

    .empty-state-title {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 12px;
    }

    .empty-state-description {
        color: var(--text-gray);
        max-width: 400px;
        margin: 0 auto 24px;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border-bottom: none;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .btn-close-white:hover {
        opacity: 1;
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .container-fluid {
            padding: 16px !important;
        }
        
        .page-title-main {
            font-size: 1.75rem;
        }
        
        .stat-card {
            padding: 18px;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .stat-icon-container {
            width: 44px;
            height: 44px;
            font-size: 1.2rem;
        }
        
        /* Responsive Pagination */
        .pagination {
            --bs-pagination-padding-x: 0.5rem;
            --bs-pagination-padding-y: 0.25rem;
            --bs-pagination-font-size: 0.8rem;
        }
        
        .page-link {
            min-width: 32px;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 12px !important;
        }
        
        .page-title-main {
            font-size: 1.5rem;
        }
        
        .card-header {
            padding: 20px !important;
        }
        
        .card-body {
            padding: 20px !important;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-value {
            font-size: 1.4rem;
        }
        
        #purchaseOrdersTable th,
        #purchaseOrdersTable td {
            padding: 12px 8px;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 8px 16px;
        }
        
        .search-container {
            width: 100%;
        }
        
        .btn-group {
            margin-right: 0.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 8px !important;
        }
        
        .page-title-main {
            font-size: 1.3rem;
        }
        
        .stat-card {
            padding: 14px;
        }
        
        .stat-icon-container {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }
        
        .stat-value {
            font-size: 1.3rem;
        }
        
        .modal-dialog {
            margin: 8px;
        }
        
        .modal-body {
            padding: 20px !important;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
        
        .btn-sm {
            padding: 6px 10px;
            font-size: 0.85rem;
        }
        
        /* Mobile Pagination */
        .card-footer {
            padding: 16px !important;
        }
        
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .page-link {
            margin: 2px;
            min-width: 28px;
        }
        
        .selected-counter {
            font-size: 0.875rem;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-gray);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-blue);
    }
</style>
@endsection

@section('scripts')
<script>
    // Global flag untuk mencegah duplicate event listeners
    let appInitialized = false;
    let statusHandlersInitialized = false;
    let isProcessingBulkAction = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize hanya sekali
        if (!appInitialized) {
            appInitialized = true;
            
            initializeSearch();
            initializeStatusUpdates();
            initializeViewDetailButtons();
            initializeItemsPerPage();
            initializeFilterForm();
            initializeDateValidation();
            initializeBulkActions();
        }
    });
    
    // ================ BULK ACTIONS FUNCTIONS ================
    
    function initializeBulkActions() {
        // Select All checkbox
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.po-checkbox:not(:disabled)');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActionButtons();
            });
        }
        
        // Individual checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('po-checkbox')) {
                updateBulkActionButtons();
            }
        });
        
        // Clear selection button
        document.getElementById('clearSelectionBtn')?.addEventListener('click', clearSelection);
        
        // Bulk action buttons
        document.getElementById('allApproveBtn')?.addEventListener('click', handleAllApprove);
        document.getElementById('allFulfillBtn')?.addEventListener('click', handleAllFulfill);
        document.getElementById('deleteFulfilledBtn')?.addEventListener('click', handleDeleteFulfilled);
        
        // Initialize bulk actions state
        updateBulkActionButtons();
    }
    
    function updateBulkActionButtons() {
        const checkboxes = Array.from(document.querySelectorAll('.po-checkbox:checked'));
        const selectedCount = checkboxes.length;
        
        // Update counter
        const selectedCounter = document.getElementById('selectedCounter');
        const selectedCountElement = document.getElementById('selectedCount');
        
        if (selectedCount > 0) {
            if (selectedCounter) selectedCounter.classList.remove('d-none');
            if (selectedCountElement) selectedCountElement.textContent = selectedCount;
        } else {
            if (selectedCounter) selectedCounter.classList.add('d-none');
        }
        
        // Count selected by status
        const counts = {
            pending: 0,
            approved: 0,
            fulfilled: 0,
            cancelled: 0
        };
        
        checkboxes.forEach(checkbox => {
            const status = checkbox.dataset.status;
            if (counts.hasOwnProperty(status)) {
                counts[status]++;
            }
        });
        
        // Update Select All checkbox state
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            const totalCheckboxes = document.querySelectorAll('.po-checkbox:not(:disabled)').length;
            selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < totalCheckboxes;
            selectAllCheckbox.checked = selectedCount > 0 && selectedCount === totalCheckboxes;
        }
        
        // Update bulk action buttons
        const allApproveBtn = document.getElementById('allApproveBtn');
        const allFulfillBtn = document.getElementById('allFulfillBtn');
        const deleteFulfilledBtn = document.getElementById('deleteFulfilledBtn');
        const bulkActionsBtn = document.getElementById('bulkActionsBtn');
        
        if (allApproveBtn) {
            const hasPending = counts.pending > 0;
            allApproveBtn.classList.toggle('disabled', !hasPending);
            allApproveBtn.style.pointerEvents = hasPending ? 'auto' : 'none';
            allApproveBtn.style.opacity = hasPending ? '1' : '0.5';
        }
        
        if (allFulfillBtn) {
            const hasApproved = counts.approved > 0;
            allFulfillBtn.classList.toggle('disabled', !hasApproved);
            allFulfillBtn.style.pointerEvents = hasApproved ? 'auto' : 'none';
            allFulfillBtn.style.opacity = hasApproved ? '1' : '0.5';
        }
        
        if (deleteFulfilledBtn) {
            const hasFulfilled = counts.fulfilled > 0;
            deleteFulfilledBtn.classList.toggle('disabled', !hasFulfilled);
            deleteFulfilledBtn.style.pointerEvents = hasFulfilled ? 'auto' : 'none';
            deleteFulfilledBtn.style.opacity = hasFulfilled ? '1' : '0.5';
        }
        
        // Enable/disable bulk actions dropdown
        if (bulkActionsBtn) {
            const hasAnySelection = selectedCount > 0;
            bulkActionsBtn.disabled = !hasAnySelection;
            bulkActionsBtn.style.opacity = hasAnySelection ? '1' : '0.5';
        }
    }
    
    function clearSelection() {
        const checkboxes = document.querySelectorAll('.po-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
        
        updateBulkActionButtons();
    }
    
    function getSelectedPOsByStatus(status = null) {
        const checkboxes = status 
            ? document.querySelectorAll(`.po-checkbox:checked[data-status="${status}"]`)
            : document.querySelectorAll('.po-checkbox:checked');
        
        return Array.from(checkboxes).map(checkbox => ({
            id: checkbox.value,
            poNumber: checkbox.dataset.poNumber,
            status: checkbox.dataset.status
        }));
    }
    
    async function handleAllApprove(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isProcessingBulkAction) return;
        isProcessingBulkAction = true;
        
        const selectedPOs = getSelectedPOsByStatus('pending');
        
        if (selectedPOs.length === 0) {
            showNotification('No pending purchase orders selected', 'warning');
            isProcessingBulkAction = false;
            return;
        }
        
        const poNumbers = selectedPOs.map(po => po.poNumber).join(', ');
        
        if (!confirm(`Approve ${selectedPOs.length} pending purchase order(s)?\n\nPO Numbers: ${poNumbers}\n\nThis will update product stock automatically.`)) {
            isProcessingBulkAction = false;
            return;
        }
        
        try {
            showNotification(`Approving ${selectedPOs.length} purchase order(s)...`, 'info');
            
            const results = [];
            let successCount = 0;
            let failedCount = 0;
            
            // Process each PO
            for (const [index, po] of selectedPOs.entries()) {
                try {
                    const response = await fetch(`/api/purchase-order/${po.id}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': getCSRFToken()
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        successCount++;
                        
                        // Update UI immediately
                        updatePOStatusInTable(po.id, 'approved');
                        updateActionButtons(po.id, 'approved');
                        
                        // Uncheck the checkbox
                        const checkbox = document.querySelector(`.po-checkbox[value="${po.id}"]`);
                        if (checkbox) checkbox.checked = false;
                        
                        // Update stats counter
                        updateStatsCounter('pending', -1);
                        updateStatsCounter('approved', 1);
                        
                    } else {
                        failedCount++;
                        results.push({
                            poNumber: po.poNumber,
                            error: result.message
                        });
                    }
                    
                } catch (error) {
                    failedCount++;
                    results.push({
                        poNumber: po.poNumber,
                        error: error.message
                    });
                }
                
                // Small delay to prevent overwhelming the server
                if (index < selectedPOs.length - 1) {
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
            }
            
            // Show results
            let message = `Successfully approved ${successCount} purchase order(s)`;
            if (failedCount > 0) {
                message += `. ${failedCount} failed:\n`;
                results.forEach((result, index) => {
                    message += `\n${index + 1}. ${result.poNumber}: ${result.error}`;
                });
                showNotification(message, failedCount === selectedPOs.length ? 'danger' : 'warning');
            } else {
                showNotification(message, 'success');
            }
            
            // Update bulk action buttons
            updateBulkActionButtons();
            
        } catch (error) {
            console.error('Error in bulk approve:', error);
            showNotification('Error processing bulk approval', 'danger');
        } finally {
            isProcessingBulkAction = false;
        }
    }
    
    async function handleAllFulfill(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isProcessingBulkAction) return;
        isProcessingBulkAction = true;
        
        const selectedPOs = getSelectedPOsByStatus('approved');
        
        if (selectedPOs.length === 0) {
            showNotification('No approved purchase orders selected', 'warning');
            isProcessingBulkAction = false;
            return;
        }
        
        const poNumbers = selectedPOs.map(po => po.poNumber).join(', ');
        
        if (!confirm(`Mark ${selectedPOs.length} approved purchase order(s) as fulfilled?\n\nPO Numbers: ${poNumbers}`)) {
            isProcessingBulkAction = false;
            return;
        }
        
        try {
            showNotification(`Fulfilling ${selectedPOs.length} purchase order(s)...`, 'info');
            
            const results = [];
            let successCount = 0;
            let failedCount = 0;
            
            // Process each PO
            for (const [index, po] of selectedPOs.entries()) {
                try {
                    const response = await fetch(`/api/purchase-order/${po.id}/fulfill`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': getCSRFToken()
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        successCount++;
                        
                        // Update UI immediately
                        updatePOStatusInTable(po.id, 'fulfilled');
                        updateActionButtons(po.id, 'fulfilled');
                        
                        // Uncheck the checkbox
                        const checkbox = document.querySelector(`.po-checkbox[value="${po.id}"]`);
                        if (checkbox) checkbox.checked = false;
                        
                        // Update stats counter
                        updateStatsCounter('approved', -1);
                        updateStatsCounter('fulfilled', 1);
                        
                    } else {
                        failedCount++;
                        results.push({
                            poNumber: po.poNumber,
                            error: result.message
                        });
                    }
                    
                } catch (error) {
                    failedCount++;
                    results.push({
                        poNumber: po.poNumber,
                        error: error.message
                    });
                }
                
                // Small delay to prevent overwhelming the server
                if (index < selectedPOs.length - 1) {
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
            }
            
            // Show results
            let message = `Successfully marked ${successCount} purchase order(s) as fulfilled`;
            if (failedCount > 0) {
                message += `. ${failedCount} failed:\n`;
                results.forEach((result, index) => {
                    message += `\n${index + 1}. ${result.poNumber}: ${result.error}`;
                });
                showNotification(message, failedCount === selectedPOs.length ? 'danger' : 'warning');
            } else {
                showNotification(message, 'success');
            }
            
            // Update bulk action buttons
            updateBulkActionButtons();
            
        } catch (error) {
            console.error('Error in bulk fulfill:', error);
            showNotification('Error processing bulk fulfillment', 'danger');
        } finally {
            isProcessingBulkAction = false;
        }
    }
    
    async function handleDeleteFulfilled(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isProcessingBulkAction) return;
        isProcessingBulkAction = true;
        
        const selectedPOs = getSelectedPOsByStatus('fulfilled');
        
        if (selectedPOs.length === 0) {
            showNotification('No fulfilled purchase orders selected', 'warning');
            isProcessingBulkAction = false;
            return;
        }
        
        const poNumbers = selectedPOs.map(po => po.poNumber).join(', ');
        
        if (!confirm(`DELETE ${selectedPOs.length} fulfilled purchase order(s)?\n\nPO Numbers: ${poNumbers}\n\nWARNING: This action cannot be undone! All data will be permanently deleted.`)) {
            isProcessingBulkAction = false;
            return;
        }
        
        try {
            showNotification(`Deleting ${selectedPOs.length} purchase order(s)...`, 'info');
            
            const results = [];
            let successCount = 0;
            let failedCount = 0;
            
            // Process each PO
            for (const [index, po] of selectedPOs.entries()) {
                try {
                    const response = await fetch(`/api/purchase-order/${po.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': getCSRFToken()
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        successCount++;
                        
                        // Remove row from table with animation
                        const row = document.querySelector(`[data-po-id="${po.id}"]`);
                        if (row) {
                            row.style.opacity = '0.5';
                            row.style.transition = 'all 0.3s ease';
                            row.style.height = row.offsetHeight + 'px';
                            
                            setTimeout(() => {
                                row.style.height = '0';
                                row.style.padding = '0';
                                row.style.margin = '0';
                                row.style.border = 'none';
                                row.style.overflow = 'hidden';
                                
                                setTimeout(() => {
                                    if (row.parentNode) {
                                        row.remove();
                                    }
                                    
                                    // Update stats counter
                                    updateStatsCounter('fulfilled', -1);
                                    
                                    // Check if table is empty
                                    const remainingRows = document.querySelectorAll('#purchaseOrdersTableBody tr').length;
                                    if (remainingRows === 0) {
                                        setTimeout(() => location.reload(), 500);
                                    }
                                }, 300);
                            }, 100);
                        }
                        
                    } else {
                        failedCount++;
                        results.push({
                            poNumber: po.poNumber,
                            error: result.message
                        });
                    }
                    
                } catch (error) {
                    failedCount++;
                    results.push({
                        poNumber: po.poNumber,
                        error: error.message
                    });
                }
                
                // Small delay to prevent overwhelming the server
                if (index < selectedPOs.length - 1) {
                    await new Promise(resolve => setTimeout(resolve, 100));
                }
            }
            
            // Show results
            let message = `Successfully deleted ${successCount} purchase order(s)`;
            if (failedCount > 0) {
                message += `. ${failedCount} failed:\n`;
                results.forEach((result, index) => {
                    message += `\n${index + 1}. ${result.poNumber}: ${result.error}`;
                });
                showNotification(message, failedCount === selectedPOs.length ? 'danger' : 'warning');
            } else {
                showNotification(message, 'success');
            }
            
            // Update bulk action buttons
            updateBulkActionButtons();
            
        } catch (error) {
            console.error('Error in bulk delete:', error);
            showNotification('Error processing bulk deletion', 'danger');
        } finally {
            isProcessingBulkAction = false;
        }
    }
    
    function updateStatsCounter(status, change) {
        const counterIds = {
            'pending': 'pendingCount',
            'approved': 'approvedCount',
            'fulfilled': 'fulfilledCount',
            'cancelled': 'cancelledCount'
        };
        
        const counterId = counterIds[status];
        if (!counterId) return;
        
        const counterElement = document.getElementById(counterId);
        if (counterElement) {
            let currentCount = parseInt(counterElement.textContent) || 0;
            currentCount += change;
            if (currentCount < 0) currentCount = 0;
            counterElement.textContent = currentCount;
            
            // Add animation
            counterElement.style.transform = 'scale(1.2)';
            counterElement.style.color = change > 0 ? 'var(--success)' : 'var(--danger)';
            
            setTimeout(() => {
                counterElement.style.transform = 'scale(1)';
                counterElement.style.color = '';
            }, 300);
        }
    }
    
    // ================ EXISTING FUNCTIONS (Updated) ================
    
    function initializeItemsPerPage() {
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        if (itemsPerPageSelect) {
            itemsPerPageSelect.removeEventListener('change', handleItemsPerPageChange);
            itemsPerPageSelect.addEventListener('change', handleItemsPerPageChange);
        }
    }
    
    function handleItemsPerPageChange() {
        const perPage = this.value;
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', perPage);
        currentUrl.searchParams.set('page', '1');
        window.location.href = currentUrl.toString();
    }
    
    function initializeFilterForm() {
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                
                if (startDate && endDate) {
                    const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
                    if (!dateRegex.test(startDate) || !dateRegex.test(endDate)) {
                        e.preventDefault();
                        showNotification('Date format should be DD/MM/YYYY', 'warning');
                        return false;
                    }
                    
                    const startParts = startDate.split('/');
                    const endParts = endDate.split('/');
                    const start = new Date(startParts[2], startParts[1] - 1, startParts[0]);
                    const end = new Date(endParts[2], endParts[1] - 1, endParts[0]);
                    
                    if (start > end) {
                        e.preventDefault();
                        showNotification('Start date cannot be after end date', 'warning');
                        return false;
                    }
                }
            });
        }
    }
    
    function initializeDateValidation() {
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        
        if (startDate && endDate) {
            startDate.addEventListener('change', function() {
                if (this.value && endDate.value) {
                    const startParts = this.value.split('/');
                    const endParts = endDate.value.split('/');
                    const start = new Date(startParts[2], startParts[1] - 1, startParts[0]);
                    const end = new Date(endParts[2], endParts[1] - 1, endParts[0]);
                    
                    if (start > end) {
                        showNotification('Start date cannot be after end date', 'warning');
                        this.value = '';
                    }
                }
            });
            
            endDate.addEventListener('change', function() {
                if (this.value && startDate.value) {
                    const startParts = startDate.value.split('/');
                    const endParts = this.value.split('/');
                    const start = new Date(startParts[2], startParts[1] - 1, startParts[0]);
                    const end = new Date(endParts[2], endParts[1] - 1, endParts[0]);
                    
                    if (end < start) {
                        showNotification('End date cannot be before start date', 'warning');
                        this.value = '';
                    }
                }
            });
        }
    }
    
    function initializeSearch() {
        const searchInput = document.getElementById('searchPO');
        const poRows = document.querySelectorAll('#purchaseOrdersTableBody .po-row');
        
        if (searchInput && poRows.length > 0) {
            searchInput.removeEventListener('input', handleSearchInput);
            searchInput.addEventListener('input', handleSearchInput);
        }
    }
    
    function handleSearchInput() {
        const searchTerm = this.value.toLowerCase();
        const poRows = document.querySelectorAll('#purchaseOrdersTableBody .po-row');
        
        poRows.forEach(row => {
            const poNumber = row.querySelector('h6')?.textContent.toLowerCase() || '';
            const vendorName = row.querySelector('.vendor-info .fw-medium')?.textContent.toLowerCase() || '';
            const outlet = row.querySelector('.badge')?.textContent.toLowerCase() || '';
            
            const matches = poNumber.includes(searchTerm) || 
                           vendorName.includes(searchTerm) || 
                           outlet.includes(searchTerm);
            
            row.style.display = matches ? '' : 'none';
        });
        
        const paginationContainer = document.querySelector('.card-footer');
        if (paginationContainer) {
            paginationContainer.style.display = searchTerm === '' ? '' : 'none';
        }
        
        // Reset selection when searching
        clearSelection();
    }
    
    function initializeStatusUpdates() {
        if (statusHandlersInitialized) return;
        statusHandlersInitialized = true;
        
        document.removeEventListener('click', handleStatusButtonClick);
        document.addEventListener('click', handleStatusButtonClick);
    }
    
    function handleStatusButtonClick(e) {
        // Individual delete button
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const poId = button.dataset.poId;
            const poNumber = button.dataset.poNumber;
            e.preventDefault();
            e.stopPropagation();
            deleteSinglePurchaseOrder(poId, poNumber);
            return;
        }
        
        // Approve button
        if (e.target.closest('.approve-btn')) {
            const button = e.target.closest('.approve-btn');
            const poId = button.dataset.poId;
            const poNumber = button.dataset.poNumber;
            e.preventDefault();
            e.stopPropagation();
            approvePurchaseOrder(poId, poNumber);
            return;
        }
        
        // Fulfill button
        if (e.target.closest('.fulfill-btn')) {
            const button = e.target.closest('.fulfill-btn');
            const poId = button.dataset.poId;
            const poNumber = button.dataset.poNumber;
            e.preventDefault();
            e.stopPropagation();
            fulfillPurchaseOrder(poId, poNumber);
            return;
        }
        
        // Cancel button
        if (e.target.closest('.cancel-btn')) {
            const button = e.target.closest('.cancel-btn');
            const poId = button.dataset.poId;
            const poNumber = button.dataset.poNumber;
            e.preventDefault();
            e.stopPropagation();
            cancelPurchaseOrder(poId, poNumber);
            return;
        }
    }
    
    async function deleteSinglePurchaseOrder(poId, poNumber) {
        if (!confirm(`DELETE Purchase Order ${poNumber}?\n\nWARNING: This action cannot be undone! All data will be permanently deleted.`)) {
            return;
        }
        
        try {
            showNotification(`Deleting PO ${poNumber}...`, 'info');
            
            const response = await fetch(`/api/purchase-order/${poId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCSRFToken()
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message, 'success');
                
                // Remove row from table with animation
                const row = document.querySelector(`[data-po-id="${poId}"]`);
                if (row) {
                    row.style.opacity = '0.5';
                    row.style.transition = 'all 0.3s ease';
                    row.style.height = row.offsetHeight + 'px';
                    
                    setTimeout(() => {
                        row.style.height = '0';
                        row.style.padding = '0';
                        row.style.margin = '0';
                        row.style.border = 'none';
                        row.style.overflow = 'hidden';
                        
                        setTimeout(() => {
                            if (row.parentNode) {
                                row.remove();
                            }
                            
                            // Update stats counter
                            updateStatsCounter('fulfilled', -1);
                            
                            // Check if table is empty
                            const remainingRows = document.querySelectorAll('#purchaseOrdersTableBody tr').length;
                            if (remainingRows === 0) {
                                setTimeout(() => location.reload(), 500);
                            }
                        }, 300);
                    }, 100);
                }
                
            } else {
                showNotification(result.message, 'danger');
            }
        } catch (error) {
            console.error('Error deleting PO:', error);
            showNotification('Failed to delete purchase order', 'danger');
        }
    }
    
    async function approvePurchaseOrder(poId, poNumber) {
        if (window.isApprovingPO) return;
        window.isApprovingPO = true;
        
        if (!confirm(`Approve Purchase Order ${poNumber}?\n\nThis will update product stock automatically.`)) {
            window.isApprovingPO = false;
            return;
        }
        
        try {
            showNotification(`Approving PO ${poNumber}...`, 'info');
            
            const response = await fetch(`/api/purchase-order/${poId}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCSRFToken()
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message, 'success');
                
                updatePOStatusInTable(poId, 'approved');
                updateActionButtons(poId, 'approved');
                
                // Update stats counter
                updateStatsCounter('pending', -1);
                updateStatsCounter('approved', 1);
                
            } else {
                showNotification(result.message, 'danger');
            }
        } catch (error) {
            console.error('Error approving PO:', error);
            showNotification('Failed to approve purchase order', 'danger');
        } finally {
            window.isApprovingPO = false;
        }
    }
    
    async function fulfillPurchaseOrder(poId, poNumber) {
        if (window.isFulfillingPO) return;
        window.isFulfillingPO = true;
        
        if (!confirm(`Mark Purchase Order ${poNumber} as fulfilled?`)) {
            window.isFulfillingPO = false;
            return;
        }
        
        try {
            showNotification(`Marking PO ${poNumber} as fulfilled...`, 'info');
            
            const response = await fetch(`/api/purchase-order/${poId}/fulfill`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCSRFToken()
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message, 'success');
                
                updatePOStatusInTable(poId, 'fulfilled');
                updateActionButtons(poId, 'fulfilled');
                
                // Update stats counter
                updateStatsCounter('approved', -1);
                updateStatsCounter('fulfilled', 1);
                
            } else {
                showNotification(result.message, 'danger');
            }
        } catch (error) {
            console.error('Error fulfilling PO:', error);
            showNotification('Failed to mark as fulfilled', 'danger');
        } finally {
            window.isFulfillingPO = false;
        }
    }
    
    async function cancelPurchaseOrder(poId, poNumber) {
        if (window.isCancellingPO) return;
        window.isCancellingPO = true;
        
        if (!confirm(`Cancel Purchase Order ${poNumber}?\n\nThis action cannot be undone.`)) {
            window.isCancellingPO = false;
            return;
        }
        
        try {
            showNotification(`Cancelling PO ${poNumber}...`, 'info');
            
            const response = await fetch(`/api/purchase-order/${poId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': getCSRFToken()
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message, 'success');
                
                updatePOStatusInTable(poId, 'cancelled');
                updateActionButtons(poId, 'cancelled');
                
                // Update stats counter
                updateStatsCounter('pending', -1);
                updateStatsCounter('cancelled', 1);
                
            } else {
                showNotification(result.message, 'danger');
            }
        } catch (error) {
            console.error('Error cancelling PO:', error);
            showNotification('Failed to cancel purchase order', 'danger');
        } finally {
            window.isCancellingPO = false;
        }
    }
    
    function initializeViewDetailButtons() {
        const viewDetailButtons = document.querySelectorAll('.view-detail-btn');
        
        viewDetailButtons.forEach(button => {
            button.removeEventListener('click', handleViewDetailClick);
            button.addEventListener('click', handleViewDetailClick);
        });
    }
    
    function handleViewDetailClick() {
        showPurchaseOrderDetails(this);
    }
    
    async function showPurchaseOrderDetails(button) {
        const poId = button.dataset.poId;
        const poNumber = button.dataset.poNumber;
        
        const modalItems = document.getElementById('modalPoItems');
        modalItems.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">
                    <i class="fas fa-spinner fa-spin fa-2x mb-2 d-block"></i>
                    Loading purchase order details...
                </td>
            </tr>
        `;
        
        try {
            const response = await fetch(`/api/purchase-order/${poId}/details`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Failed to load PO details');
            }
            
            const po = result.purchase_order;
            const items = result.items || [];
            
            updateModalContent(po, items, poId);
            
            const modal = new bootstrap.Modal(document.getElementById('poDetailsModal'));
            modal.show();
            
        } catch (error) {
            console.error('Error loading PO details:', error);
            showNotification('Failed to load purchase order details', 'danger');
            
            modalItems.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="fas fa-exclamation-circle fa-2x mb-2 d-block text-danger"></i>
                        Error loading items: ${error.message}
                    </td>
                </tr>
            `;
        }
    }
    
    function updateModalContent(po, items, poId) {
        const createdDate = po.created_at_tl || po.created_at;
        const fulfilledDate = po.fulfilled_at_tl || po.fulfilled_at;
        
        document.getElementById('modalPoNumber').textContent = po.po_number || 'N/A';
        document.getElementById('modalPoDate').textContent = `Created on ${formatDateForDisplay(createdDate)}`;
        document.getElementById('modalPoVendor').textContent = po.supplier || 'No Vendor';
        document.getElementById('modalPoOutlet').textContent = po.outlet || 'N/A';
        document.getElementById('modalPoTotal').textContent = `$ ${formatNumber(po.total_amount || 0)}`;
        document.getElementById('modalPoStatusText').textContent = po.status ? po.status.charAt(0).toUpperCase() + po.status.slice(1) : 'Unknown';
        document.getElementById('modalPoCreated').textContent = formatDateTimeForDisplay(createdDate);
        document.getElementById('modalPoCreatedBy').textContent = `By: ${po.creator_name || 'Unknown'}`;
        document.getElementById('modalPoFulfilled').textContent = fulfilledDate ? formatDateTimeForDisplay(fulfilledDate) : 'Not yet fulfilled';
        document.getElementById('modalPoFulfilledBy').textContent = `By: ${po.fulfilled_by || '-'}`;
        document.getElementById('modalPoNotes').textContent = po.note || 'No notes available';
        
        const printBtn = document.getElementById('modalPrintBtn');
        if (po.status === 'fulfilled' || po.status === 'approved') {
            printBtn.onclick = function() {
                window.open(`/admin/inventory/purchase/${poId}/print`, '_blank');
            };
            printBtn.disabled = false;
            printBtn.innerHTML = '<i class="fas fa-print me-2"></i> Print PO';
        } else {
            printBtn.disabled = true;
            printBtn.innerHTML = '<i class="fas fa-ban me-2"></i> Print (Not Available)';
        }
        
        updateStatusBadge(po.status);
        updateItemsTable(items);
    }
    
    function updateStatusBadge(status) {
        const statusBadge = document.getElementById('modalPoStatus');
        statusBadge.className = 'badge px-3 py-2 fw-medium ';
        statusBadge.innerHTML = '';
        
        switch(status) {
            case 'pending':
                statusBadge.classList.add('bg-warning', 'bg-opacity-10', 'text-warning');
                statusBadge.innerHTML = '<i class="fas fa-clock me-1"></i> Pending';
                break;
            case 'approved':
                statusBadge.classList.add('bg-info', 'bg-opacity-10', 'text-info');
                statusBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i> Approved';
                break;
            case 'fulfilled':
                statusBadge.classList.add('bg-success', 'bg-opacity-10', 'text-success');
                statusBadge.innerHTML = '<i class="fas fa-truck me-1"></i> Fulfilled';
                break;
            case 'cancelled':
                statusBadge.classList.add('bg-danger', 'bg-opacity-10', 'text-danger');
                statusBadge.innerHTML = '<i class="fas fa-times-circle me-1"></i> Cancelled';
                break;
            default:
                statusBadge.classList.add('bg-secondary', 'bg-opacity-10', 'text-secondary');
                statusBadge.innerHTML = '<i class="fas fa-question-circle me-1"></i> Unknown';
        }
    }
    
    function updateItemsTable(items) {
        const itemsContainer = document.getElementById('modalPoItems');
        let itemsHTML = '';
        let totalAmount = 0;
        
        if (items && items.length > 0) {
            items.forEach(item => {
                const productName = item.product_name || 'Unknown Product';
                const variantName = item.variant_name || '';
                const quantity = item.quantity || 0;
                const unitPrice = item.unit_price || 0;
                const totalPrice = item.total_price || (unitPrice * quantity);
                
                totalAmount += totalPrice;
                
                itemsHTML += `
                    <tr class="border-bottom">
                        <td class="py-3 ps-3">
                            <div class="fw-medium text-dark">${productName}</div>
                            ${variantName ? `<small class="text-muted d-block">Variant: ${variantName}</small>` : ''}
                            <small class="text-muted">
                                SKU: ${item.sku || 'N/A'}
                            </small>
                        </td>
                        <td class="py-3 text-center">
                            <span class="fw-bold text-dark">${quantity}</span>
                            ${item.received_quantity ? `<small class="text-muted d-block">Received: ${item.received_quantity}</small>` : ''}
                        </td>
                        <td class="py-3 text-center">
                            $ ${formatNumber(unitPrice)}
                        </td>
                        <td class="py-3 pe-3 text-end fw-bold text-dark">
                            $ ${formatNumber(totalPrice)}
                        </td>
                    </tr>
                `;
            });
        } else {
            itemsHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                        No items found in this purchase order
                    </td>
                </tr>
            `;
        }
        
        itemsContainer.innerHTML = itemsHTML;
        document.getElementById('modalItemsTotal').textContent = `$ ${formatNumber(totalAmount)}`;
    }
    
    function updatePOStatusInTable(poId, newStatus) {
        const row = document.querySelector(`[data-po-id="${poId}"]`);
        if (!row) return;
        
        row.dataset.status = newStatus;
        
        const statusCell = row.querySelector('td:nth-child(7)');
        if (statusCell) {
            let badgeClass = '';
            let badgeText = '';
            let icon = '';
            
            switch(newStatus) {
                case 'pending':
                    badgeClass = 'bg-warning bg-opacity-10 text-warning';
                    badgeText = 'Pending';
                    icon = 'clock';
                    break;
                case 'approved':
                    badgeClass = 'bg-info bg-opacity-10 text-info';
                    badgeText = 'Approved';
                    icon = 'check-circle';
                    break;
                case 'fulfilled':
                    badgeClass = 'bg-success bg-opacity-10 text-success';
                    badgeText = 'Fulfilled';
                    icon = 'truck';
                    break;
                case 'cancelled':
                    badgeClass = 'bg-danger bg-opacity-10 text-danger';
                    badgeText = 'Cancelled';
                    icon = 'times-circle';
                    break;
            }
            
            statusCell.innerHTML = `
                <span class="badge ${badgeClass} px-3 py-2 fw-medium">
                    <i class="fas fa-${icon} me-1"></i> ${badgeText}
                </span>
            `;
        }
        
        // Update checkbox status
        const checkbox = row.querySelector('.po-checkbox');
        if (checkbox) {
            checkbox.dataset.status = newStatus;
        }
    }
    
    function updateActionButtons(poId, newStatus) {
        const row = document.querySelector(`[data-po-id="${poId}"]`);
        if (!row) return;
        
        const actionCell = row.querySelector('td:last-child');
        const poNumber = row.querySelector('h6').textContent;
        
        let buttonsHTML = '';
        
        // Always show view detail button
        buttonsHTML = `
            <button class="btn btn-sm btn-outline-primary px-3 view-detail-btn" 
                    title="View Details"
                    data-po-id="${poId}"
                    data-po-number="${poNumber}">
                <i class="fas fa-eye"></i>
            </button>
        `;
        
        // Add print button for approved and fulfilled
        if (newStatus === 'approved' || newStatus === 'fulfilled') {
            buttonsHTML += `
                <a href="/admin/inventory/purchase/${poId}/print" 
                   class="btn btn-sm btn-outline-info px-3" 
                   title="Print PO"
                   target="_blank">
                    <i class="fas fa-print"></i>
                </a>
            `;
        }
        
        // Add fulfill button for approved
        if (newStatus === 'approved') {
            buttonsHTML += `
                <button class="btn btn-sm btn-outline-success px-3 fulfill-btn" 
                        title="Mark as Fulfilled"
                        data-po-id="${poId}"
                        data-po-number="${poNumber}">
                    <i class="fas fa-truck"></i>
                </button>
            `;
        }
        
        // Add delete button for fulfilled
        if (newStatus === 'fulfilled') {
            buttonsHTML += `
                <button class="btn btn-sm btn-outline-danger delete-btn" 
                        title="Delete PO"
                        data-po-id="${poId}"
                        data-po-number="${poNumber}">
                    <i class="fas fa-trash"></i>
                </button>
            `;
        }
        
        // Add approve and cancel buttons for pending
        if (newStatus === 'pending') {
            buttonsHTML += `
                <button class="btn btn-sm btn-outline-success px-3 approve-btn" 
                        title="Approve PO"
                        data-po-id="${poId}"
                        data-po-number="${poNumber}">
                    <i class="fas fa-check"></i>
                </button>
                
                <button class="btn btn-sm btn-outline-danger cancel-btn" 
                        title="Cancel PO"
                        data-po-id="${poId}"
                        data-po-number="${poNumber}">
                    <i class="fas fa-times"></i>
                </button>
            `;
        }
        
        actionCell.innerHTML = `<div class="d-flex justify-content-end gap-2">${buttonsHTML}</div>`;
        
        // Re-attach event listeners
        setTimeout(() => {
            const newViewDetailBtn = actionCell.querySelector('.view-detail-btn');
            if (newViewDetailBtn) {
                newViewDetailBtn.removeEventListener('click', handleViewDetailClick);
                newViewDetailBtn.addEventListener('click', handleViewDetailClick);
            }
            
            statusHandlersInitialized = false;
        }, 100);
    }
    
    function getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }
    
    function formatDateForDisplay(dateString) {
        if (!dateString) return '';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
        } catch (e) {
            return dateString;
        }
    }
    
    function formatDateTimeForDisplay(dateString) {
        if (!dateString) return '';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            return dateString;
        }
    }
    
    function formatNumber(num) {
        try {
            return new Intl.NumberFormat('id-ID').format(num || 0);
        } catch (e) {
            return num || 0;
        }
    }
    
    function showNotification(message, type = 'info') {
        const existingAlerts = document.querySelectorAll('.alert.position-fixed');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            border-radius: 8px;
        `;
        
        const icon = type === 'success' ? 'check-circle' : 
                    type === 'danger' ? 'exclamation-circle' : 
                    type === 'warning' ? 'exclamation-triangle' : 'info-circle';
        const title = type === 'success' ? 'Success' : 
                     type === 'danger' ? 'Error' : 
                     type === 'warning' ? 'Warning' : 'Info';
        
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${icon} me-3" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">
                    <strong>${title}</strong>
                    <div style="font-size: 0.9rem;">${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
</script>
@endsection
