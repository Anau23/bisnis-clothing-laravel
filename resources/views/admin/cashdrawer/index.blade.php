@extends('admin.layout')

@section('title', 'Cash Drawer Management - BISNIS CLOTHING')
@section('styles')
<style>
:root {
    --primary-blue: #2c7be5;
    --primary-blue-dark: #1c65c9;
    --primary-blue-light: #edf2f9;
    --secondary-blue: #6e84a3;
    --success-green: #00d97e;
    --warning-orange: #f6c343;
    --danger-red: #e63757;
    --info-cyan: #39afd1;
    --light-gray: #f8fafc;
    --border-color: #e3ebf6;
    --text-dark: #12263f;
    --text-gray: #ffffffff;
}

/* Layout and Cards */
.cash-drawer-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(44, 123, 229, 0.08);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #ffffff 0%, var(--light-gray) 100%);
    border-left: 6px solid var(--primary-blue);
    height: 100%;
}

.cash-drawer-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(44, 123, 229, 0.15);
}

/* Status and Badges */
.status-badge {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    padding: 4px 12px;
    border-radius: 20px;
}

/* Amount Displays */
.amount-display {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    letter-spacing: 0.5px;
}

.expected-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.actual-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--success-green);
}

/* Difference Indicators */
.difference-positive {
    color: var(--success-green);
}

.difference-negative {
    color: var(--danger-red);
}

/* Denomination Styling */
.denomination-input {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.denomination-input:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
}

.denomination-row {
    padding: 12px 0;
    border-bottom: 1px solid var(--border-color);
    transition: background-color 0.3s ease;
}

.denomination-row:hover {
    background-color: var(--primary-blue-light);
}

.denomination-total {
    font-weight: 600;
    color: var(--text-dark);
    min-width: 100px;
    text-align: right;
}

/* Card Headers */
.card-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border: none;
    border-radius: 12px 12px 0 0 !important;
    padding: 1.25rem 1.5rem;
}

.card-header h5 {
    margin: 0;
    font-weight: 600;
    color: white;
}

.card-header .badge {
    background-color: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

/* Summary Items */
.summary-item {
    background: var(--light-gray);
    border-radius: 10px;
    padding: 20px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    height: 100%;
}

.summary-item:hover {
    border-color: var(--primary-blue);
    transform: translateY(-2px);
}

.summary-item-label {
    color: var(--text-gray);
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.summary-item-value {
    color: var(--text-dark);
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

.summary-item-change {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-blue-dark) 0%, var(--primary-blue) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(44, 123, 229, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, var(--success-green) 0%, #00c46a 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #00c46a 0%, var(--success-green) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 215, 126, 0.3);
}

.btn-outline-primary {
    border: 2px solid var(--primary-blue);
    color: var(--primary-blue);
    background: transparent;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-blue);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(44, 123, 229, 0.2);
}

/* Tables */
.table th {
    background-color: var(--primary-blue-light);
    color: var(--text-dark);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border: none;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-color: var(--border-color);
    color: var(--text-dark);
}

.table-hover tbody tr:hover {
    background-color: var(--primary-blue-light);
}

/* Form Controls */
.form-control, .form-select {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 10px 16px;
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
}

.input-group-text {
    background-color: var(--primary-blue-light);
    border: 2px solid var(--border-color);
    color: var(--text-dark);
    font-weight: 500;
}

/* Badges */
.badge {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 20px;
}

.badge.bg-success {
    background-color: var(--success-green) !important;
}

.badge.bg-info {
    background-color: var(--info-cyan) !important;
}

.badge.bg-warning {
    background-color: var(--warning-orange) !important;
}

.badge.bg-danger {
    background-color: var(--danger-red) !important;
}

.badge.bg-primary {
    background-color: var(--primary-blue) !important;
}

/* Empty State */
.empty-state {
    padding: 3rem 1rem;
    text-align: center;
}

.empty-state-icon {
    color: var(--border-color);
    font-size: 3.5rem;
    margin-bottom: 1rem;
}

/* Reconciliation Box */
.reconciliation-box {
    background: linear-gradient(135deg, #ffffff 0%, var(--light-gray) 100%);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.reconciliation-box h5 {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 1rem;
}

.reconciliation-value {
    font-size: 1.8rem;
    font-weight: 700;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

.reconciliation-difference {
    font-size: 1.5rem;
    font-weight: 700;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.difference-perfect {
    background-color: rgba(0, 215, 126, 0.1);
    color: var(--success-green);
    border: 2px solid var(--success-green);
}

.difference-overage {
    background-color: rgba(246, 195, 67, 0.1);
    color: var(--warning-orange);
    border: 2px solid var(--warning-orange);
}

.difference-shortage {
    background-color: rgba(230, 55, 87, 0.1);
    color: var(--danger-red);
    border: 2px solid var(--danger-red);
}

/* Cashier Info */
.cashier-info {
    background: linear-gradient(135deg, var(--primary-blue-light) 0%, #ffffff 100%);
    border-radius: 10px;
    padding: 15px;
    border: 1px solid var(--border-color);
    margin-bottom: 1.5rem;
}

.cashier-info h6 {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.cashier-info p {
    color: var(--text-gray);
    margin: 0;
    font-size: 0.875rem;
}

/* Sales Items Styles */
.sales-item {
    border-bottom: 1px solid var(--border-color);
    padding: 0.75rem 0;
    transition: background-color 0.2s ease;
}

.sales-item:hover {
    background-color: var(--light-gray);
}

.sales-item-name {
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.sales-item-variant {
    font-size: 0.875rem;
    color: var(--text-gray);
}

.sales-item-quantity {
    font-weight: 600;
    color: var(--primary-blue);
}

.sales-item-price {
    font-weight: 600;
    color: var(--text-dark);
    text-align: right;
}

.sales-item-subtotal {
    font-weight: 700;
    color: var(--success-green);
    text-align: right;
}

.sales-total {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    padding: 1rem 0;
    border-top: 2px solid var(--border-color);
}

/* Tabs Navigation */
.nav-tabs {
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 1.5rem;
}

.nav-tabs .nav-link {
    border: none;
    color: var(--text-gray);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: 8px 8px 0 0;
    margin-right: 0.5rem;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    color: var(--primary-blue);
    background-color: var(--primary-blue-light);
}

.nav-tabs .nav-link.active {
    color: var(--primary-blue);
    background-color: white;
    border-bottom: 3px solid var(--primary-blue);
}

/* Pagination Styles */
.pagination-container {
    margin-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: var(--light-gray);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.pagination-info {
    font-size: 0.875rem;
    color: var(--text-gray);
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.page-item.active .page-link {
    background-color: var(--primary-blue);
    border-color: var(--primary-blue);
    color: white;
}

.page-link {
    color: var(--primary-blue);
    border: 1px solid var(--border-color);
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
}

.page-link:hover {
    background-color: var(--primary-blue-light);
    border-color: var(--primary-blue);
    color: var(--primary-blue);
}

.page-item.disabled .page-link {
    color: var(--text-gray);
    background-color: var(--light-gray);
    border-color: var(--border-color);
}

/* Pagination per page selector */
.per-page-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.per-page-selector select {
    width: 80px;
    padding: 0.25rem;
    border-radius: 4px;
    border: 1px solid var(--border-color);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cash-drawer-card {
        margin-bottom: 1rem;
    }
    
    .summary-item {
        margin-bottom: 1rem;
    }
    
    .denomination-row {
        padding: 8px 0;
    }
    
    .table-responsive {
        margin-bottom: 1rem;
    }
    
    .sales-item-price,
    .sales-item-subtotal {
        text-align: left;
        margin-top: 0.5rem;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination-controls {
        flex-wrap: wrap;
        justify-content: center;
    }
}

/* Loading animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.loading {
    animation: pulse 1.5s infinite;
}

/* Custom scrollbar */
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
    background: var(--secondary-blue);
}

/* Progress bars */
.progress {
    height: 8px;
    background-color: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    border-radius: 4px;
}

/* Tooltips */
.tooltip {
    font-size: 0.875rem;
}

/* Time badge styling */
.time-badge {
    font-size: 0.7rem;
    padding: 4px 8px;
    font-family: 'Courier New', monospace;
    background-color: var(--light-gray);
    color: var(--text-dark);
    border: 1px solid var(--border-color);
}

.date-badge {
    font-size: 0.75rem;
    padding: 4px 10px;
    background-color: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}
</style>
@endsection

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title text-primary mb-2">Cash Drawer Management</h1>
                <p class="page-subtitle text-gray-600">Monitor and reconcile cash drawer activities</p>
            </div>
            <div class="d-flex gap-2">
                @if (!$currentDrawer)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openDrawerModal">
                    <i class="fas fa-cash-register me-2"></i>Open New Drawer
                </button>
                @endif
                <button class="btn btn-outline-primary" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>
</div>

@if ($todayLogs->count())
<table class="table table-hover">
    <thead>
        <tr>
            <th>Date & Time</th>
            <th>Type</th>
            <th>Description</th>
            <th class="text-end">Amount</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($todayLogs as $log)
        <tr>
            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
            <td>
                <span class="badge bg-{{ $log->transaction_type === 'sale' ? 'success' : 'secondary' }}">
                    {{ ucfirst($log->transaction_type) }}
                </span>
            </td>
            <td>{{ $log->description ?? '-' }}</td>
            <td class="text-end">
                {{ number_format($log->amount, 2) }}
            </td>
            <td>{{ $log->user->username ?? 'System' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $todayLogs->links() }}
@else
<div class="empty-state">
    <h6>No Cash Transactions Today</h6>
</div>
@endif

@if ($todaySales->count())
<table class="table table-hover">
    <thead>
        <tr>
            <th>Transaction</th>
            <th class="text-end">Items</th>
            <th class="text-end">Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($todaySales as $sale)
        <tr>
            <td>{{ $sale->transaction_code }}</td>
            <td class="text-end">{{ $sale->items_count }}</td>
            <td class="text-end">{{ number_format($sale->total_amount, 2) }}</td>
            <td>
                <span class="badge bg-success">{{ ucfirst($sale->status) }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $todaySales->links() }}
@endif

@if ($soldItems->count())
<table class="table table-hover">
    <thead>
        <tr>
            <th>Product</th>
            <th class="text-end">Qty</th>
            <th class="text-end">Revenue</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($soldItems as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td class="text-end">{{ $item->total_quantity }}</td>
            <td class="text-end">{{ number_format($item->total_revenue, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $soldItems->links() }}
@endif

@if ($currentDrawer)
@php
$denominations = [
    100, 50, 20, 10, 5, 1, 0.25, 0.10, 0.05, 0.01
];
@endphp

<form id="reconcileForm" data-drawer-id="{{ $currentDrawer->id }}">
    @foreach ($denominations as $d)
    <input type="number" class="denomination-input" data-value="{{ $d }}" value="0">
    @endforeach
</form>
@endif

@if ($drawerHistory->count())
<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Drawer</th>
            <th>Cashier</th>
            <th class="text-end">Difference</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($drawerHistory as $drawer)
        <tr>
            <td>{{ $drawer->opened_at?->format('d M Y') }}</td>
            <td>#{{ $drawer->drawer_number }}</td>
            <td>{{ $drawer->cashier->username ?? '-' }}</td>
            <td class="text-end">{{ number_format($drawer->difference, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $drawerHistory->links() }}
@endif

@section('scripts')
<script>
// Format currency for display
function formatCurrency(amount) {
    return '$' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Format number for input fields (remove formatting)
function formatNumber(number) {
    return parseFloat(number).toFixed(2);
}

// Calculate total from denomination inputs
function calculateTotal() {
    let total = 0;
    
    document.querySelectorAll('.denomination-input').forEach(input => {
        const value = parseFloat(input.dataset.value) || 0;
        const quantity = parseInt(input.value) || 0;
        const subtotal = value * quantity;
        
        // Update subtotal display
        const totalElement = document.getElementById(`total-${value}`);
        if (totalElement) {
            totalElement.textContent = formatCurrency(subtotal);
        }
        
        total += subtotal;
    });
    
    // Update displays
    const totalCounted = document.getElementById('totalCounted');
    const actualCashInput = document.getElementById('actualCashInput');
    
    if (totalCounted) totalCounted.textContent = formatCurrency(total);
    if (actualCashInput) actualCashInput.value = formatNumber(total);
    
    // Calculate and update difference
    updateDifference(total);
}

// Update difference display
function updateDifference(actualCash) {
    const expectedElement = document.getElementById('expectedCash');
    if (!expectedElement) return;
    
    const expectedValue = parseFloat(expectedElement.value.replace(/[^0-9.]/g, '')) || 0;
    const difference = actualCash - expectedValue;
    
    const differenceAmount = document.getElementById('differenceAmount');
    const differenceContainer = document.getElementById('differenceContainer');
    const statusText = document.getElementById('differenceStatus');
    
    if (!differenceAmount || !differenceContainer || !statusText) return;
    
    differenceAmount.textContent = formatCurrency(difference);
    
    // Update styling based on difference
    if (Math.abs(difference) < 0.01) { // Less than 1 cent difference
        differenceContainer.className = 'reconciliation-difference text-center difference-perfect';
        statusText.textContent = '✓ Perfectly balanced';
        statusText.className = 'small text-success';
    } else if (difference > 0) {
        differenceContainer.className = 'reconciliation-difference text-center difference-overage';
        statusText.textContent = `↑ Overage: ${formatCurrency(difference)}`;
        statusText.className = 'small text-warning';
    } else {
        differenceContainer.className = 'reconciliation-difference text-center difference-shortage';
        statusText.textContent = `↓ Shortage: ${formatCurrency(Math.abs(difference))}`;
        statusText.className = 'small text-danger';
    }
}

// Reconcile drawer
function reconcileDrawer() {
    const drawerId = document.getElementById('reconcileForm')?.dataset.drawerId;
    if (!drawerId) {
        showNotification('No active drawer found', 'danger');
        return;
    }
    
    const actualCash = parseFloat(document.getElementById('actualCashInput').value.replace(/[^0-9.]/g, '')) || 0;
    const notes = document.getElementById('reconcileNotes').value;
    
    // Collect denominations
    const denominations = [];
    document.querySelectorAll('.denomination-input').forEach(input => {
        const value = parseFloat(input.dataset.value);
        const quantity = parseInt(input.value) || 0;
        if (quantity > 0) {
            denominations.push({
                denomination: value,
                quantity: quantity
            });
        }
    });
    
    // Validate
    if (actualCash === 0) {
        showNotification('Please count cash first by entering denominations', 'warning');
        return;
    }
    
    // Show confirmation with details
    const expectedValue = parseFloat(document.getElementById('expectedCash').value.replace(/[^0-9.]/g, ''));
    const difference = actualCash - expectedValue;
    const message = `Are you sure you want to reconcile and close this drawer?\n\n` +
                    `Expected: $${formatNumber(expectedValue)}\n` +
                    `Actual: $${formatNumber(actualCash)}\n` +
                    `Difference: ${formatCurrency(difference)}\n\n` +
                    `This action cannot be undone.`;
    
    if (!confirm(message)) {
        return;
    }
    
    // Show loading
    const reconcileBtn = document.getElementById('reconcileBtn');
    const originalText = reconcileBtn.innerHTML;
    reconcileBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    reconcileBtn.disabled = true;
    
    // Send request
    fetch(`/admin/cashdrawer/${drawerId}/reconcile`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            actual_cash: actualCash,
            denominations: denominations,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Drawer reconciled successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Failed to reconcile drawer', 'danger');
            reconcileBtn.innerHTML = originalText;
            reconcileBtn.disabled = false;
        }
    })
    .catch(error => {
        showNotification('Error: ' + error.message, 'danger');
        reconcileBtn.innerHTML = originalText;
        reconcileBtn.disabled = false;
        console.error('Error:', error);
    });
}

// Add cash in
function addCashIn() {
    const drawerId = document.getElementById('reconcileForm')?.dataset.drawerId;
    if (!drawerId) {
        showNotification('No active drawer found', 'danger');
        return;
    }
    
    const amount = prompt('Enter amount to add to cash drawer:', '0.00');
    if (amount && parseFloat(amount) > 0) {
        fetch(`/admin/cashdrawer/${drawerId}/cash-in`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                amount: parseFloat(amount),
                description: 'Manual cash addition'
            })
        })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Cash added successfully', 'success');
            location.reload();
        } else {
            showNotification('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showNotification('Error: ' + error.message, 'danger');
    });
    }
}

// Add cash out
function addCashOut() {
    const drawerId = document.getElementById('reconcileForm')?.dataset.drawerId;
    if (!drawerId) {
        showNotification('No active drawer found', 'danger');
        return;
    }
    
    const amount = prompt('Enter amount to withdraw from cash drawer:', '0.00');
    if (amount && parseFloat(amount) > 0) {
        fetch(`/admin/cashdrawer/${drawerId}/cash-out`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                amount: parseFloat(amount),
                description: 'Manual cash withdrawal'
            })
        })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Cash withdrawn successfully', 'success');
            location.reload();
        } else {
            showNotification('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showNotification('Error: ' + error.message, 'danger');
    });
    }
}

// Open new drawer
function openNewDrawer() {
    const cashierId = document.getElementById('cashierSelect').value;
    const openingBalance = document.getElementById('openingBalance').value;
    const drawerNumber = document.getElementById('drawerNumber').value || '1';
    
    if (!cashierId) {
        showNotification('Please select a cashier', 'warning');
        return;
    }
    
    if (!openingBalance || parseFloat(openingBalance) <= 0) {
        showNotification('Please enter a valid opening balance', 'warning');
        return;
    }
    
    fetch('/admin/cashdrawer/open', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            cashier_id: cashierId,
            opening_balance: parseFloat(openingBalance),
            drawer_number: drawerNumber
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Cash drawer opened successfully', 'success');
            $('#openDrawerModal').modal('hide');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showNotification('Error: ' + error.message, 'danger');
    });
}

// Refresh data
function refreshData() {
    location.reload();
}

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingAlerts = document.querySelectorAll('.custom-alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `custom-alert alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: none;
        border-radius: 8px;
        animation: slideIn 0.3s ease;
    `;
    
    const icon = type === 'success' ? 'check-circle' : 
                type === 'danger' ? 'exclamation-circle' : 
                type === 'warning' ? 'exclamation-triangle' : 'info-circle';
    
    alertDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${icon} me-3" style="font-size: 1.25rem;"></i>
            <div class="flex-grow-1">
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Add animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    // Add to body
    document.body.appendChild(alertDiv);
    
    // Auto remove
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.classList.remove('show');
            setTimeout(() => alertDiv.remove(), 300);
        }
    }, 5000);
}

// Change per page for transactions
function changeTransactionsPerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('page', '1');
    url.searchParams.set('per_page', perPage);
    // Preserve other pagination parameters
    if (url.searchParams.has('sales_page')) {
        url.searchParams.set('sales_page', '1');
    }
    if (url.searchParams.has('items_page')) {
        url.searchParams.set('items_page', '1');
    }
    if (url.searchParams.has('history_page')) {
        url.searchParams.set('history_page', '1');
    }
    window.location.href = url.toString();
}

// Change per page for sales
function changeSalesPerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('sales_page', '1');
    url.searchParams.set('sales_per_page', perPage);
    // Preserve other pagination parameters
    if (url.searchParams.has('page')) {
        url.searchParams.set('page', '1');
    }
    window.location.href = url.toString();
}

// Change per page for items
function changeItemsPerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('items_page', '1');
    url.searchParams.set('items_per_page', perPage);
    // Preserve other pagination parameters
    if (url.searchParams.has('page')) {
        url.searchParams.set('page', '1');
    }
    window.location.href = url.toString();
}

// Change per page for history
function changeHistoryPerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('history_page', '1');
    url.searchParams.set('history_per_page', perPage);
    // Preserve other pagination parameters
    if (url.searchParams.has('page')) {
        url.searchParams.set('page', '1');
    }
    window.location.href = url.toString();
}

// View drawer details
function viewDrawerDetails(drawerId) {
    fetch(`/admin/cashdrawer/${drawerId}/details`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const drawer = data.drawer;
            
            // Create modal content
            let modalContent = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Drawer Details #${drawer.drawer_number}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Cashier:</strong> ${drawer.cashier}
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong> <span class="badge bg-${drawer.status === 'reconciled' ? 'success' : 'secondary'}">${drawer.status}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Opened:</strong> ${drawer.opened_at_wib || drawer.opened_at}
                            </div>
                            <div class="col-md-6">
                                <strong>Closed:</strong> ${drawer.closed_at_wib || drawer.closed_at || 'N/A'}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Opening Balance:</strong><br>
                                <span class="text-primary fw-bold">${formatCurrency(drawer.opening_balance)}</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Expected Cash:</strong><br>
                                <span class="text-dark fw-bold">${formatCurrency(drawer.expected_cash)}</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Actual Cash:</strong><br>
                                <span class="text-success fw-bold">${formatCurrency(drawer.actual_cash)}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Difference:</strong><br>
                                <span class="badge ${drawer.difference === 0 ? 'bg-success' : drawer.difference > 0 ? 'bg-warning text-dark' : 'bg-danger'}">
                                    ${drawer.difference === 0 ? 'Balanced' : formatCurrency(drawer.difference)}
                                </span>
                            </div>
                        </div>
            `;
            
            // Add notes if available
            if (drawer.notes) {
                modalContent += `
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Notes:</strong><br>
                            <div class="alert alert-info">${drawer.notes}</div>
                        </div>
                    </div>
                `;
            }
            
            modalContent += `
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            `;
            
            // Create and show modal
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'drawerDetailsModal';
            modal.tabIndex = '-1';
            modal.innerHTML = modalContent;
            
            document.body.appendChild(modal);
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
            
            // Remove modal from DOM when hidden
            modal.addEventListener('hidden.bs.modal', function () {
                document.body.removeChild(modal);
            });
        } else {
            showNotification('Failed to load drawer details', 'danger');
        }
    })
    .catch(error => {
        showNotification('Error: ' + error.message, 'danger');
    });
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    // Calculate initial total if reconciliation form exists
    if (document.getElementById('reconcileForm')) {
        calculateTotal();
        
        // Add auto-calculation on input
        document.querySelectorAll('.denomination-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    }
    
    // Initialize tabs
    const triggerTabList = [].slice.call(document.querySelectorAll('#cashDrawerTabs button'));
    triggerTabList.forEach(function (triggerEl) {
        const tabTrigger = new bootstrap.Tab(triggerEl);
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
            
            // Save active tab to localStorage
            localStorage.setItem('cashdrawerActiveTab', triggerEl.id);
        });
    });
    
    // Restore active tab from localStorage
    const savedTab = localStorage.getItem('cashdrawerActiveTab');
    if (savedTab) {
        const savedTabElement = document.querySelector(`#${savedTab}`);
        if (savedTabElement) {
            const tab = new bootstrap.Tab(savedTabElement);
            tab.show();
        }
    }
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + R to refresh
        if (e.ctrlKey && e.key === 'r') {
            e.preventDefault();
            refreshData();
        }
    });
});
</script>
@endsection







