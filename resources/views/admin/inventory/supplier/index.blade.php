@extends('admin.layout')

@section('title', 'Suppliers - BONUS CLOTHING')
@section('page_title', 'Supplier Management')
@section('page_subtitle', 'Manage your suppliers and vendor information')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5">

    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Supplier Management</h1>
                    <p class="text-muted mb-0">Manage all your suppliers and vendor relationships</p>
                </div>
                <a href="{{ route('admin.inventory.supplier.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus-circle me-2"></i> Add New Supplier
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.inventory.supplier.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="search"
                                   class="form-control"
                                   name="search"
                                   placeholder="Search suppliers..."
                                   value="{{ $search_query ?? '' }}">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <select class="form-select" name="status" id="statusSelect">
                            @foreach(['All','Active','Inactive'] as $status)
                                <option value="{{ $status }}" {{ ($filter_status ?? 'All') === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50" onclick="resetFilters()">
                            <i class="fas fa-times me-2"></i> Clear
                        </button>
                        <button type="submit" class="btn btn-primary w-50">
                            <i class="fas fa-filter me-2"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3"><i class="fas fa-truck"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $suppliers->count() }}</h4>
                        <small class="text-muted">Total Suppliers</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3 text-success"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-success" id="activeCount">0</h4>
                        <small class="text-muted">Active Suppliers</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3 text-warning"><i class="fas fa-pause-circle"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-warning" id="inactiveCount">0</h4>
                        <small class="text-muted">Inactive Suppliers</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-3 text-info"><i class="fas fa-shopping-cart"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-info">{{ $recent_purchases ?? 0 }}</h4>
                        <small class="text-muted">Recent Purchases</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($suppliers->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="suppliersTable">
                    <thead>
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="selectAllSuppliers"></th>
                            <th>SUPPLIER</th>
                            <th>CONTACT</th>
                            <th>ADDRESS</th>
                            <th>STATUS</th>
                            <th class="text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $s)
                        <tr class="supplier-row" data-supplier-id="{{ $s->id }}">
                            <td class="ps-4">
                                <input type="checkbox" class="supplier-checkbox" value="{{ $s->id }}">
                            </td>
                            <td>
                                <strong>{{ $s->name }}</strong><br>
                                <small class="text-muted">ID: {{ $s->id }}</small>
                            </td>
                            <td>
                                {{ $s->phone ?? 'No phone' }}<br>
                                {{ $s->email ?? 'No email' }}
                            </td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($s->address, 40) ?? 'No address' }}
                            </td>
                            <td>
                                <span class="badge {{ $s->status === 'Active' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary edit-btn" data-supplier-id="{{ $s->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info detail-btn" data-supplier-id="{{ $s->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-supplier-id="{{ $s->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center py-5">
                    <h5>No Suppliers Found</h5>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="modalContainer"></div>
<div id="loadingOverlay" class="d-none"></div>
@endsection

@section('styles')
<style>
    :root {
        --primary-blue: #2c7be5;
        --primary-blue-light: #edf2f9;
        --border-color: #e3ebf6;
        --text-dark: #12263f;
        --text-gray: #6e84a3;
        --bg-light: #f8fafc;
    }

    body {
        background: var(--bg-light);
    }

    .card {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.08);
    }

    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        height: 48px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
        outline: none;
    }

    .input-group-text {
        background: var(--primary-blue-light);
        border-color: var(--border-color);
        color: var(--text-gray);
        height: 48px;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1c65c9 100%);
        border: none;
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1c65c9 0%, var(--primary-blue) 100%);
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

    /* Table Styling */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: var(--primary-blue-light);
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        color: var(--text-dark);
        padding: 16px 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    .table tbody tr:hover {
        background: var(--primary-blue-light);
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* Stats Cards */
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-blue-light);
        color: var(--primary-blue);
        font-size: 1.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        
        .card {
            margin-bottom: 16px;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
            height: 44px;
        }
        
        .table-responsive {
            margin: -12px;
            padding: 12px;
        }
        
        .form-control, .form-select {
            height: 44px;
        }
        
        .input-group-text {
            height: 44px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    var supplierStatsData = @json($supplier_stats);
    let currentModal = null;
    let supplierData = {};

    document.addEventListener('DOMContentLoaded', function() {
        // Load supplier data
        loadSupplierData();
        
        // Setup event listeners
        setupEventListeners();
        
        // Calculate stats
        calculateStats();
    });

    function loadSupplierData() {
        // In a real app, this would be an API call
        // For now, we'll extract data from the table
        const rows = document.querySelectorAll('.supplier-row');
        rows.forEach(row => {
            const id = row.getAttribute('data-supplier-id');
            if (!id) return;
            
            const cells = row.querySelectorAll('td');
            supplierData[id] = {
                id: id,
                name: row.querySelector('h6.mb-0')?.textContent || '',
                phone: row.querySelector('.d-flex.align-items-center.mb-1 span')?.textContent || '',
                email: row.querySelector('.d-flex.align-items-center:not(.mb-1) span')?.textContent || '',
                address: row.querySelector('td:nth-child(4) small')?.textContent || '',
                status: row.querySelector('.badge')?.textContent || 'Active',
                created_at: 'N/A',
                updated_at: 'N/A'
            };
        });
    }

    function setupEventListeners() {
        // Select all suppliers checkbox
        const selectAllCheckbox = document.getElementById('selectAllSuppliers');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.supplier-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActions();
            });
        }
        
        // Individual supplier checkboxes
        const supplierCheckboxes = document.querySelectorAll('.supplier-checkbox');
        supplierCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });
        
        // Detail buttons
        document.querySelectorAll('.detail-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const supplierId = this.getAttribute('data-supplier-id');
                showDetailModal(supplierId);
            });
        });
        
        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const supplierId = this.getAttribute('data-supplier-id');
                showEditModal(supplierId);
            });
        });
        
        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const supplierId = this.getAttribute('data-supplier-id');
                showDeleteModal(supplierId);
            });
        });
        
        // Row click (for opening detail modal)
        document.querySelectorAll('.supplier-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.btn') && !e.target.closest('.form-check')) {
                    const supplierId = this.getAttribute('data-supplier-id');
                    showDetailModal(supplierId);
                }
            });
        });
        
        // Auto-submit on Enter key in search
        document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    }

    // Di function showDetailModal:
function showDetailModal(supplierId) {
    const supplier = supplierData[supplierId];
    if (!supplier) {
        showNotification('Supplier data not found', 'error');
        return;
    }
    
    // Ambil stats dari data yang dikirim Flask
    const stats = supplierStatsData[supplierId] || {
        total_orders: 0,
        fulfilled_orders: 0
    };
    
    // Close existing modal
    if (currentModal) {
        const existingModal = bootstrap.Modal.getInstance(currentModal);
        if (existingModal) existingModal.hide();
    }
    
    const modalHtml = `
        <div class="modal fade" id="detailModal${supplierId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fas fa-eye me-2"></i> Supplier Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <!-- Supplier Information -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-truck text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 fw-bold text-dark">${supplier.name}</h4>
                                        <div class="d-flex align-items-center gap-3 mt-1">
                                            <span class="badge ${supplier.status === 'Active' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary'} px-3 py-1">
                                                ${supplier.status}
                                            </span>
                                            <small class="text-muted">ID: ${supplier.id}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="showEditModal('${supplierId}')">
                                        <i class="fas fa-edit me-2"></i> Edit Supplier
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Details -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h6 class="card-title mb-0 text-dark fw-bold">
                                            <i class="fas fa-address-card me-2 text-primary"></i> Contact Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark mb-2">
                                                <i class="fas fa-phone me-2 text-primary"></i> Phone Number
                                            </label>
                                            <p class="mb-0">${supplier.phone || 'Not provided'}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-dark mb-2">
                                                <i class="fas fa-envelope me-2 text-primary"></i> Email Address
                                            </label>
                                            <p class="mb-0">${supplier.email || 'Not provided'}</p>
                                        </div>
                                        <div>
                                            <label class="form-label fw-bold text-dark mb-2">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> Address
                                            </label>
                                            <p class="mb-0">${supplier.address || 'Not provided'}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h6 class="card-title mb-0 text-dark fw-bold">
                                            <i class="fas fa-chart-bar me-2 text-primary"></i> Quick Stats
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="bg-primary bg-opacity-10 rounded p-3 text-center">
                                                    <div class="h4 fw-bold text-primary mb-1">${stats.total_orders}</div>
                                                    <small class="text-muted">Total Orders</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-success bg-opacity-10 rounded p-3 text-center">
                                                    <div class="h4 fw-bold text-success mb-1">${stats.fulfilled_orders}</div>
                                                    <small class="text-muted">Fulfilled</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-top">
                                            <small class="text-muted d-block mb-1">Created: ${supplier.created_at}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3 text-dark">
                                <i class="fas fa-history me-2 text-primary"></i> Recent Activity
                            </h6>
                            <div class="alert ${stats.total_orders > 0 ? 'alert-success' : 'alert-info'} border-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas ${stats.total_orders > 0 ? 'fa-shopping-cart' : 'fa-info-circle'} me-3 mt-1"></i>
                                    <div>
                                        <small class="text-dark d-block mb-1 fw-medium">
                                            ${stats.total_orders > 0 
                                                ? `${stats.total_orders} purchase order(s) created` 
                                                : 'No recent activity'}
                                        </small>
                                        <small class="text-muted">
                                            ${stats.total_orders > 0 
                                                ? `${stats.fulfilled_orders} order(s) fulfilled` 
                                                : 'Create a purchase order to see activity from this supplier'}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Close
                        </button>
                        <a href="/admin/inventory/purchase/create?supplier=${supplierId}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i> Create Purchase Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Clear and add new modal
    document.getElementById('modalContainer').innerHTML = modalHtml;
    
    // Show modal
    const modalElement = document.getElementById(`detailModal${supplierId}`);
    currentModal = modalElement;
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

    function showEditModal(supplierId) {
    const supplier = supplierData[supplierId];
    if (!supplier) {
        showNotification('Supplier data not found', 'error');
        return;
    }
    
    // Close existing modal
    if (currentModal) {
        const existingModal = bootstrap.Modal.getInstance(currentModal);
        if (existingModal) existingModal.hide();
    }
    
    const modalHtml = `
        <div class="modal fade" id="editModal${supplierId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white border-0 py-3">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="fas fa-edit me-2"></i> Edit Supplier
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="/admin/inventory/supplier/${supplierId}/update" id="editForm${supplierId}">
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark mb-2">Supplier Name *</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="name" 
                                       value="${supplier.name}" 
                                       required>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-2">Phone Number</label>
                                    <input type="tel" 
                                           class="form-control" 
                                           name="phone" 
                                           value="${supplier.phone || ''}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-2">Email Address</label>
                                    <input type="email" 
                                           class="form-control" 
                                           name="email" 
                                           value="${supplier.email || ''}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark mb-2">Address</label>
                                <textarea class="form-control" 
                                          name="address" 
                                          rows="3">${supplier.address || ''}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark mb-2">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" ${supplier.status === 'Active' ? 'selected' : ''}>Active</option>
                                    <option value="Inactive" ${supplier.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    // Clear and add new modal
    document.getElementById('modalContainer').innerHTML = modalHtml;
    
    // Show modal
    const modalElement = document.getElementById(`editModal${supplierId}`);
    currentModal = modalElement;
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

    function showDeleteModal(supplierId) {
    const supplier = supplierData[supplierId];
    if (!supplier) {
        showNotification('Supplier data not found', 'error');
        return;
    }
    
    // Close existing modal
    if (currentModal) {
        const existingModal = bootstrap.Modal.getInstance(currentModal);
        if (existingModal) existingModal.hide();
    }
    
    const modalHtml = `
        <div class="modal fade" id="deleteModal${supplierId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header border-0 py-3">
                        <h5 class="modal-title fw-bold mb-0 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i> Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="/admin/inventory/supplier/${supplierId}/delete" id="deleteForm${supplierId}">
                        <div class="modal-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-trash text-danger fa-3x"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Delete Supplier?</h6>
                            <p class="text-muted mb-3">
                                Are you sure you want to delete <strong>${supplier.name}</strong>? 
                                This action cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-0">
                            <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i> Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
    
    // Clear and add new modal
    document.getElementById('modalContainer').innerHTML = modalHtml;
    
    // Show modal
    const modalElement = document.getElementById(`deleteModal${supplierId}`);
    currentModal = modalElement;
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

    // Rest of the functions remain the same as before...
    function calculateStats() {
    // Hitung dari data supplier yang ada di table
    const rows = document.querySelectorAll('.supplier-row');
    let active = 0, inactive = 0;
    
    rows.forEach(row => {
        const statusBadge = row.querySelector('.badge');
        if (statusBadge) {
            if (statusBadge.textContent.includes('Active')) active++;
            else if (statusBadge.textContent.includes('Inactive')) inactive++;
        }
    });
    
    // Update statistik di header cards
    document.getElementById('activeCount').textContent = active;
    document.getElementById('inactiveCount').textContent = inactive;
}

    function updateBulkActions() {
        const selectedCheckboxes = document.querySelectorAll('.supplier-checkbox:checked');
        const selectedCount = selectedCheckboxes.length;
        
        document.getElementById('selectedCount').textContent = `${selectedCount} supplier${selectedCount !== 1 ? 's' : ''} selected`;
        
        const bulkActionsBar = document.getElementById('bulkActions');
        if (selectedCount > 0) {
            bulkActionsBar.style.display = 'block';
        } else {
            bulkActionsBar.style.display = 'none';
        }
        
        const selectAllCheckbox = document.getElementById('selectAllSuppliers');
        const allCheckboxes = document.querySelectorAll('.supplier-checkbox');
        selectAllCheckbox.checked = allCheckboxes.length > 0 && selectedCount === allCheckboxes.length;
        selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < allCheckboxes.length;
    }

    function resetFilters() {
        document.querySelector('input[name="search"]').value = '';
        document.getElementById('statusSelect').value = 'All';
        document.getElementById('filterForm').submit();
    }

    function deselectAll() {
        const checkboxes = document.querySelectorAll('.supplier-checkbox:checked');
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateBulkActions();
    }
    
    function bulkActivate() {
        const selectedIds = getSelectedSupplierIds();
        if (selectedIds.length === 0) {
            showNotification('Please select at least one supplier', 'warning');
            return;
        }
        
        if (confirm(`Activate ${selectedIds.length} selected supplier(s)?`)) {
            showLoading(true);
            // In real application, you would make an API call here
            setTimeout(() => {
                showLoading(false);
                showNotification(`Successfully activated ${selectedIds.length} supplier(s)`, 'success');
                setTimeout(() => location.reload(), 1500);
            }, 1000);
        }
    }
    
    function bulkDeactivate() {
        const selectedIds = getSelectedSupplierIds();
        if (selectedIds.length === 0) {
            showNotification('Please select at least one supplier', 'warning');
            return;
        }
        
        if (confirm(`Deactivate ${selectedIds.length} selected supplier(s)?`)) {
            showLoading(true);
            setTimeout(() => {
                showLoading(false);
                showNotification(`Successfully deactivated ${selectedIds.length} supplier(s)`, 'success');
                setTimeout(() => location.reload(), 1500);
            }, 1000);
        }
    }
    
    function bulkDelete() {
        const selectedIds = getSelectedSupplierIds();
        if (selectedIds.length === 0) {
            showNotification('Please select at least one supplier', 'warning');
            return;
        }
        
        if (confirm(`Permanently delete ${selectedIds.length} selected supplier(s)? This action cannot be undone.`)) {
            showLoading(true);
            setTimeout(() => {
                showLoading(false);
                showNotification(`Successfully deleted ${selectedIds.length} supplier(s)`, 'success');
                setTimeout(() => location.reload(), 1500);
            }, 1000);
        }
    }
    
    function getSelectedSupplierIds() {
        const selectedIds = [];
        const selectedCheckboxes = document.querySelectorAll('.supplier-checkbox:checked');
        selectedCheckboxes.forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });
        return selectedIds;
    }
    
    function exportSuppliers() {
        showLoading(true);
        const headers = ['ID', 'Name', 'Phone', 'Email', 'Address', 'Status'];
        const rows = [];
        
        const suppliers = document.querySelectorAll('.supplier-row');
        suppliers.forEach(row => {
            const id = row.getAttribute('data-supplier-id') || '';
            const name = row.querySelector('h6.mb-0')?.textContent || '';
            const phone = row.querySelector('.d-flex.align-items-center.mb-1 span')?.textContent || '';
            const email = row.querySelector('.d-flex.align-items-center:not(.mb-1) span')?.textContent || '';
            const address = row.querySelector('td:nth-child(4) small')?.textContent || '';
            const status = row.querySelector('.badge')?.textContent.trim() || '';
            
            rows.push([id, name, phone, email, address, status]);
        });
        
        const csvContent = [
            headers.join(','),
            ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
        ].join('\n');
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `suppliers-${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        showLoading(false);
        showNotification('Suppliers exported successfully', 'success');
    }
    
    function showLoading(show) {
        const overlay = document.getElementById('loadingOverlay');
        if (show) {
            overlay.classList.remove('d-none');
        } else {
            overlay.classList.add('d-none');
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            border-radius: 8px;
        `;
        
        const icon = type === 'success' ? 'check-circle' : 
                    type === 'danger' ? 'exclamation-circle' : 
                    type === 'warning' ? 'exclamation-triangle' : 'info-circle';
        
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${icon} me-3" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">
                    <strong>${type.charAt(0).toUpperCase() + type.slice(1)}</strong><br>
                    ${message}
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
