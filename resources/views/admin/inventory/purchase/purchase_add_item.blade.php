@extends('admin.layout')

@section('title', 'Add Items to Purchase Order - Admin')
@section('page_title', 'Add Items to Purchase Order')
@section('breadcrumb', 'Purchase > Add Items')

@section('content')
<style>
    .search-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .product-card {
        height: 100%;
        transition: all 0.2s;
        border: 1px solid #dee2e6;
    }
    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    .product-card.selected {
        border-color: #198754;
        background-color: #f8fff9;
    }
    .quantity-input {
        width: 80px;
        text-align: center;
    }
    .category-badge {
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 12px;
    }
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    .selected-items-panel {
        position: sticky;
        top: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #dee2e6;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    .selected-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin-bottom: 8px;
        background-color: white;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }
    .selected-item:hover {
        background-color: #f8f9fa;
    }
    .remove-item {
        color: #dc3545;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0 5px;
    }
    .remove-item:hover {
        color: #bb2d3b;
    }
</style>

<div class="row">
    <div class="col-md-8">
        <!-- Search and Filter Section -->
        <div class="search-container">
            <form method="GET" action="{{ route('inventory.purchase.add_item') }}" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               placeholder="Search by name, SKU, or description"
                               value="{{ $search_query }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}"
                                {{ $category == $category_filter ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-box"></i> Available Products</h5>
                    <small class="text-muted">{{ count($products) }} products found</small>
                </div>
            </div>
            <div class="card-body">
                @if ($products && count($products) > 0)
                <form id="addItemsForm" method="POST" action="{{ route('inventory.purchase.add_item') }}">
                    @csrf
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card product-card" id="product-{{ $product->id }}">
                                <div class="card-body">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input product-checkbox"
                                               type="checkbox"
                                               name="item_ids[]"
                                               value="{{ $product->id }}"
                                               id="check-{{ $product->id }}"
                                               onchange="toggleProductSelection({{ $product->id }})">
                                        <label class="form-check-label" for="check-{{ $product->id }}">
                                            <strong>{{ $product->name }}</strong>
                                        </label>
                                    </div>

                                    @if ($product->category)
                                        <span class="badge bg-info category-badge">{{ $product->category }}</span>
                                    @endif

                                    <p class="mb-1 mt-2">
                                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                    </p>

                                    <p class="mb-2">
                                        <small class="text-muted">
                                            Stock: <strong>{{ $product->stock }}</strong>
                                        </small>
                                    </p>

                                    <h6 class="text-primary mb-2">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </h6>

                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Qty:</span>
                                        <input type="number"
                                               class="form-control quantity-input"
                                               name="quantities[]"
                                               id="qty-{{ $product->id }}"
                                               value="1"
                                               min="1"
                                               max="999"
                                               onchange="updateQuantity({{ $product->id }}, this.value)"
                                               disabled>
                                        <span class="input-group-text">pcs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <input type="submit" id="formSubmit" hidden>
                </form>
                @else
                <div class="no-data">
                    <i class="bi bi-box" style="font-size: 3rem;"></i>
                    <h5>No Products Found</h5>
                    <p class="text-muted">No products match your search criteria</p>
                    <a href="{{ route('inventory.purchase.add_item') }}"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Clear Filters
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Selected Items -->
    <div class="col-md-4">
        <div class="selected-items-panel">
            <h5><i class="bi bi-cart-check"></i> Selected Items</h5>

            <div id="selectedItemsList">
                <div class="text-center text-muted" id="noItemsMessage">
                    <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                    <p>No items selected yet</p>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <span>Total Items:</span>
                    <strong id="totalItemsCount">0</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Total Amount:</span>
                    <strong id="totalAmount">Rp 0</strong>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-success" onclick="submitSelectedItems()">
                        <i class="bi bi-check-circle"></i> Add Selected Items to PO
                    </button>
                    <a href="{{ route('inventory.purchase.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to Create PO
                    </a>
                    <a href="{{ route('inventory.purchase.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- JS ASLI TIDAK DIUBAH --}}
<script>
// Store selected items
let selectedItems = {};

$(document).ready(function() {
    // Load any previously selected items from session
    loadSelectedItems();
});

function toggleProductSelection(productId) {
    const checkbox = $(`#check-${productId}`);
    const quantityInput = $(`#qty-${productId}`);
    const productCard = $(`#product-${productId}`);
    
    if (checkbox.is(':checked')) {
        // Enable quantity input
        quantityInput.prop('disabled', false);
        productCard.addClass('selected');
        
        // Add to selected items
        const productName = $(`#check-${productId}`).next().text().trim();
        const price = parseFloat($(`#product-${productId} .text-primary`).text().replace('Rp ', '').replace(/,/g, ''));
        const quantity = parseInt(quantityInput.val());
        
        selectedItems[productId] = {
            id: productId,
            name: productName,
            price: price,
            quantity: quantity,
            total: price * quantity
        };
    } else {
        // Disable quantity input
        quantityInput.prop('disabled', true);
        productCard.removeClass('selected');
        
        // Remove from selected items
        delete selectedItems[productId];
    }
    
    updateSelectedItemsPanel();
}

function updateQuantity(productId, quantity) {
    if (selectedItems[productId]) {
        selectedItems[productId].quantity = parseInt(quantity);
        selectedItems[productId].total = selectedItems[productId].price * parseInt(quantity);
        updateSelectedItemsPanel();
    }
}

function removeSelectedItem(productId) {
    // Uncheck the checkbox
    $(`#check-${productId}`).prop('checked', false);
    toggleProductSelection(productId);
}

function updateSelectedItemsPanel() {
    const itemsList = $('#selectedItemsList');
    const noItemsMessage = $('#noItemsMessage');
    const totalItemsCount = $('#totalItemsCount');
    const totalAmount = $('#totalAmount');
    
    const items = Object.values(selectedItems);
    
    if (items.length === 0) {
        noItemsMessage.show();
        itemsList.html('<div class="text-center text-muted" id="noItemsMessage">' +
                      '<i class="bi bi-cart-x" style="font-size: 2rem; margin-bottom: 10px;"></i>' +
                      '<p>No items selected yet</p></div>');
        totalItemsCount.text('0');
        totalAmount.text('Rp 0');
        return;
    }
    
    noItemsMessage.hide();
    
    // Calculate totals
    let totalItems = 0;
    let total = 0;
    
    // Build items HTML
    let itemsHTML = '';
    items.forEach(item => {
        totalItems += item.quantity;
        total += item.total;
        
        itemsHTML += `
            <div class="selected-item" id="selected-${item.id}">
                <div>
                    <strong>${item.name}</strong><br>
                    <small class="text-muted">${item.quantity} x Rp ${formatNumber(item.price)}</small>
                </div>
                <div class="text-end">
                    <div class="text-primary">Rp ${formatNumber(item.total)}</div>
                    <div class="remove-item" onclick="removeSelectedItem(${item.id})">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
            </div>
        `;
    });
    
    itemsList.html(itemsHTML);
    totalItemsCount.text(totalItems);
    totalAmount.text(`Rp ${formatNumber(total)}`);
}

function formatNumber(num) {
    return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function submitSelectedItems() {
    // First, update all checkboxes and quantities in the form
    Object.values(selectedItems).forEach(item => {
        $(`#check-${item.id}`).prop('checked', true);
        $(`#qty-${item.id}`).val(item.quantity);
    });
    
    // Then submit the form
    $('#formSubmit').click();
}

function loadSelectedItems() {
    // This function could load previously selected items from session
    // For now, we'll leave it empty as it's a fresh selection
}

// Initialize the form
$(document).ready(function() {
    // Set up event listeners for quantity changes
    $('.quantity-input').on('change', function() {
        const productId = $(this).attr('id').replace('qty-', '');
        updateQuantity(productId, $(this).val());
    });
});
</script>
@endsection
