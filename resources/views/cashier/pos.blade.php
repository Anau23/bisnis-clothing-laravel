@php
    use Illuminate\Support\Str;
@endphp

@extends('cashier.layout')

@section('title', 'Point of Sale - Dili Society')

@section('breadcrumb')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('cashier.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Point of Sale</li>
    </ol>
</nav>
@endsection

@section('content')

<input type="text" id="barcodeInput" autocomplete="off"
       style="opacity:0; position:fixed; top:0; left:0; width:1px; height:1px;">

<div class="mb-4">
    <h1 class="h2 fw-bold text-dark mb-2">Point of Sale</h1>
    <p class="text-muted mb-3">Sistem kasir untuk transaksi langsung</p>
</div>

<input type="hidden" id="shiftActive" value="{{ $cash_drawer ? 'true' : 'false' }}">
<input type="hidden" id="cashDrawerId" value="{{ $cash_drawer ? $cash_drawer->id : 0 }}">

<div id="posMainContainer" class="{{ !$cash_drawer ? 'opacity-50 pointer-events-none' : '' }}">

    <div class="d-lg-none d-flex gap-2 mb-3" id="mobileTabMenu">
        <button id="showProductsBtn" class="btn btn-primary btn-sm flex-fill">Produk</button>
        <button id="showCartBtn" class="btn btn-outline-primary btn-sm flex-fill position-relative">
            Keranjang
            <span id="mobileCartBadge" class="badge bg-danger rounded-pill d-none">0</span>
        </button>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="text" id="product-search"
                                   class="form-control"
                                   placeholder="Cari produk..."
                                   {{ !$cash_drawer ? 'disabled' : '' }}>
                        </div>
                        <div class="col-md-4">
                            <select id="searchType" class="form-select" {{ !$cash_drawer ? 'disabled' : '' }}>
                                <option value="name">Nama</option>
                                <option value="sku">SKU</option>
                                <option value="barcode">Barcode</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-1 flex-wrap">
                        <button class="btn btn-primary category-btn active"
                                data-category="all"
                                {{ !$cash_drawer ? 'disabled' : '' }}>
                            Semua
                        </button>

                        @foreach ($categories as $category)
                            <button class="btn btn-outline-primary category-btn"
                                    data-category="{{ $category->id }}"
                                    data-category-name="{{ strtolower($category->name) }}"
                                    {{ !$cash_drawer ? 'disabled' : '' }}>
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Produk</strong>
                    <span class="badge bg-primary" id="productCount">
                        {{ count($products) }} produk
                    </span>
                </div>

                <div class="card-body">
                    <div class="row g-2">

@foreach ($products as $product)
@php
    $has_variants = $product->variants && count($product->variants) > 0;
    $min_price = $product->price;
    $max_price = $product->price;

    if ($has_variants) {
        $prices = collect($product->variants)->pluck('price');
        if ($prices->count()) {
            $min_price = $prices->min();
            $max_price = $prices->max();
        }
    }

    $stock = $product->available_stock;
    $is_out = !is_null($stock) && $stock <= 0;
@endphp

<div class="col-6 col-md-3">
    <div class="card product-card"
         data-product-id="{{ $product->id }}"
         data-product-name="{{ $product->name }}"
         data-product-price="{{ $product->price }}"
         data-product-stock="{{ $stock }}"
         data-has-variants="{{ $has_variants ? 'true' : 'false' }}"
         data-out-of-stock="{{ $is_out ? 'true' : 'false' }}">

        <div class="card-body text-center">
            <strong>{{ $product->name }}</strong>

            <div class="mt-2 text-primary">
                @if ($min_price === $max_price)
                    {{ (int)$min_price }}
                @else
                    {{ (int)$min_price }} - {{ (int)$max_price }}
                @endif
            </div>

            <button class="btn btn-sm btn-primary mt-2 add-to-cart-modal-btn"
                    {{ $is_out || !$cash_drawer ? 'disabled' : '' }}>
                Tambah
            </button>
        </div>
    </div>
</div>
@endforeach

@if (count($products) === 0)
    <div class="text-center text-muted py-5">
        Tidak ada produk
    </div>
@endif

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="cartSection">
            {{-- CART SIDE – TIDAK DIUBAH --}}
        </div>
    </div>
</div>

<style>
    /* Bootstrap overrides untuk POS */
    .hover-shadow {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(15, 26, 47, 0.15) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--royal-blue), var(--light-blue)) !important;
    }
    
    /* Variant Option Styles */
    .variant-option {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 2px solid var(--border-light);
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .variant-option:hover:not(.disabled) {
        background-color: rgba(29, 78, 216, 0.05);
        border-color: var(--royal-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(29, 78, 216, 0.1);
    }
    
    .variant-option.selected {
        background-color: rgba(29, 78, 216, 0.1);
        border-color: var(--royal-blue);
        border-width: 2px;
        box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.1);
    }
    
    .variant-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: var(--white-off);
        border-color: var(--border-light);
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    /* Mobile Tab Menu Sticky */
    #mobileTabMenu {
        position: sticky;
        top: 70px;
        z-index: 1020;
        background: white;
        padding: 10px 0;
        margin: -15px 0 10px 0;
        border-bottom: 1px solid var(--border-light);
    }
    
    /* Fix untuk menghilangkan teks "Rp" yang tersembunyi */
    .amount-display, .price-display {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        letter-spacing: -0.3px;
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
    }
    
    /* Force remove any currency prefix */
    .amount-display::before,
    .price-display::before,
    .amount-display::after,
    .price-display::after {
        content: '' !important;
    }
    
    /* Keypad specific styles */
    .keypad-btn, .mobile-keypad-btn {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        font-feature-settings: "tnum" !important;
        font-variant-numeric: tabular-nums !important;
    }
    
    /* Remove comma formatting */
    .amount-display,
    .price-display,
    #cashInput,
    #mobileCashInput {
        font-feature-settings: "tnum" !important;
        font-variant-numeric: tabular-nums !important;
    }
    
    /* Style for out of stock product */
    .out-of-stock {
        opacity: 0.7;
        filter: grayscale(0.5);
    }
    
    /* Perbaikan layout mobile */
    @media (max-width: 992px) {
        #cartSection {
            display: none !important;
        }
        
        /* Mobile Tab Menu */
        #mobileTabMenu {
            top: 60px;
            padding: 8px 15px;
            margin: -10px -15px 15px -15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        #mobileTabMenu .btn {
            padding: 8px 12px;
            font-size: 0.85rem;
            border-radius: 8px;
            min-height: 40px;
        }
        
        /* Product Grid Mobile */
        .product-card {
            margin-bottom: 0;
        }
        
        .product-card .card-body {
            padding: 0.5rem !important;
        }
        
        .product-card h6 {
            font-size: 0.8rem;
            height: 32px;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }
        
        .product-card .btn {
            font-size: 0.75rem;
            padding: 0.35rem 0.5rem;
            min-height: 32px;
            border-radius: 6px;
        }
        
        .product-card .price-display {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        #mobileCartBadge {
            font-size: 0.6rem;
            padding: 2px 5px;
            min-width: 18px;
            height: 18px;
        }
        
        /* Categories mobile */
        #categoriesContainer {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
            margin: 0 -10px;
            padding-left: 10px;
        }
        
        .category-btn {
            font-size: 0.75rem;
            padding: 0.4rem 0.9rem;
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        /* Search mobile */
        #product-search {
            font-size: 0.9rem;
            height: 42px;
        }
        
        #searchBtn {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            height: 42px;
            min-width: 45px;
        }
        
        /* Mobile Cart Modal */
        #mobileCartModal .modal-dialog {
            margin: 0;
        }
        
        #mobileCartModal .modal-content {
            border-radius: 0;
            min-height: 100vh;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        #mobileCartModal .modal-header {
            padding: 12px 15px !important;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        
        #mobileCartModal .modal-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
        }
        
        #mobileCartItems {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 15px;
        }
        
        /* Cart items mobile */
        .cart-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .cart-item .h6 {
            font-size: 0.9rem;
        }
        
        /* Payment section mobile */
        #mobileCartModal .bg-light {
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        /* Keypad tombol lebih kecil di mobile */
        .mobile-keypad-btn {
            padding: 0.6rem 0.25rem !important;
            font-size: 1rem;
            min-height: 50px;
            border-radius: 8px;
        }
        
        /* Input uang mobile */
        #mobileCashInput {
            font-size: 1.1rem;
            height: 48px;
            border-radius: 8px;
        }
        
        /* Payment buttons mobile */
        #mobileCartModal .btn {
            padding: 0.75rem;
            font-size: 0.9rem;
            border-radius: 8px;
            min-height: 48px;
        }
        
        /* Amount displays mobile */
        .amount-display {
            font-size: 0.95rem;
        }
        
        #mobileTotalAmount,
        #mobileTotalToPay,
        #mobileChangeAmount {
            font-size: 1.3rem !important;
        }
    }
</style>

<script>
// ==================== GLOBAL VARIABLES ====================
let cart = [];
let selectedProduct = null;
let selectedVariant = null;
let currentQuantity = 1;
let discountApplied = 0;
let currentCategory = 'all';
let cashAmount = 0;
let mobileCashAmount = 0;
let isMobile = window.innerWidth < 992;
let variantModal = null;
let mobileCartModal = null;
let shiftActive = document.getElementById('shiftActive').value === 'true';
let cashDrawerId = parseInt(document.getElementById('cashDrawerId').value) || 0;

// ==================== UTILITY FUNCTIONS ====================
function formatCurrency(amount) {
    if (amount === undefined || amount === null || isNaN(amount)) return '0';
    const numAmount = typeof amount === 'number' ? amount : parseFloat(amount);
    if (isNaN(numAmount)) return '0';
    return Math.round(numAmount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function cleanAllRpText() {
    // Bersihkan teks dari elemen display
    document.querySelectorAll('.amount-display, .price-display, #changeAmount, #mobileChangeAmount').forEach(el => {
        if (el.textContent) {
            el.textContent = el.textContent
                .replace(/Rp\s*/gi, '')
                .replace(/[^\d\$\.]/g, '')
                .replace(/^\$/, '')
                .trim();
            if (el.textContent && !el.textContent.startsWith('$')) {
                el.textContent = '$' + el.textContent;
            }
        }
    });
    
    // Bersihkan input fields
    document.querySelectorAll('#cashInput, #mobileCashInput').forEach(input => {
        if (input.value) {
            input.value = input.value
                .replace(/Rp\s*/gi, '')
                .replace(/[^\d\$\.]/g, '')
                .replace(/^\$/, '')
                .trim();
            if (input.value && !input.value.startsWith('')) {
                const numValue = input.value.replace(/[^\d]/g, '');
                if (numValue) {
                    input.value =  formatCurrency(numValue);
                }
            }
        }
    });
    
    // Bersihkan tombol keypad
    document.querySelectorAll('.keypad-btn, .mobile-keypad-btn').forEach(btn => {
        if (btn.textContent.includes('Rp')) {
            const key = btn.getAttribute('data-key');
            if (key && key !== 'backspace') {
                btn.textContent = key;
            }
        }
    });
}

function updateAmountDisplay(element, amount) {
    if (!element) return;
    element.textContent =  formatCurrency(amount);
    element.classList.add('amount-display');
}

function formatCashInput(input, isMobile = false) {
    let value = input.value.replace(/[^\d]/g, '');
    
    if (value === '') {
        if (isMobile) mobileCashAmount = 0;
        else cashAmount = 0;
        input.value = '';
        return;
    }
    
    if (value.length > 10) value = value.substring(0, 10);
    const amount = parseInt(value) || 0;
    
    if (isMobile) mobileCashAmount = amount;
    else cashAmount = amount;
    
    input.value =  formatCurrency(amount);
    
    if (isMobile) calculateMobileChange();
    else calculateChange();
}

function formatMobileCashInput(input) {
    formatCashInput(input, true);
}

function showNotification(message, type = 'success', duration = 3000) {
    const colors = { success: 'alert-success', error: 'alert-danger', warning: 'alert-warning', info: 'alert-info' };
    const icons = { success: 'bi-check-circle-fill', error: 'bi-exclamation-triangle-fill', warning: 'bi-exclamation-circle-fill', info: 'bi-info-circle-fill' };
    
    const alert = document.createElement('div');
    alert.className = `alert ${colors[type]} alert-dismissible fade show`;
    alert.innerHTML = `<i class="bi ${icons[type]} me-2"></i>${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    
    const container = document.querySelector('.flash-container');
    if (container) {
        container.appendChild(alert);
        setTimeout(() => { if (alert.parentNode) new bootstrap.Alert(alert).close(); }, duration);
    }
}

function getCSRFToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

function getTotalAmount() {
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    return Math.max(0, subtotal - discountApplied);
}

// ==================== FILTER CATEGORY FUNCTIONS ====================
function filterProductsByCategory(categoryId) {
    const productCards = document.querySelectorAll('.product-card-wrapper');
    let visibleCount = 0;
    
    productCards.forEach(wrapper => {
        const productCard = wrapper.querySelector('.product-card');
        const productCategoryId = parseInt(productCard.dataset.categoryId) || 0;
        
        if (categoryId === 'all' || productCategoryId === parseInt(categoryId)) {
            wrapper.style.display = 'block';
            visibleCount++;
        } else {
            wrapper.style.display = 'none';
        }
    });
    
    document.querySelectorAll('.category-btn').forEach(btn => {
        const btnCategoryId = btn.dataset.category;
        if (btnCategoryId === categoryId) {
            btn.classList.add('active');
            btn.classList.replace('btn-outline-primary', 'btn-primary');
        } else {
            btn.classList.remove('active');
            btn.classList.replace('btn-primary', 'btn-outline-primary');
        }
    });
    
    currentCategory = categoryId;
    const productCountEl = document.getElementById('productCount');
    if (productCountEl) productCountEl.textContent = `${visibleCount} produk`;
}

// ==================== MODAL FUNCTIONS ====================
async function openAddToCartModal(productCard) {
    const productId = productCard.dataset.productId;
    const productName = productCard.dataset.productName;
    const productPrice = parseFloat(productCard.dataset.productPrice);
    const productStock = productCard.dataset.productStock === 'null' ? null : parseInt(productCard.dataset.productStock);
    const productCategory = productCard.dataset.productCategory;
    const hasVariants = productCard.dataset.hasVariants === 'true';
    const isOutOfStock = productCard.dataset.outOfStock === 'true';
    
    if (isOutOfStock) {
        showNotification('Produk ini stok habis', 'error');
        return;
    }
    
    selectedProduct = {
        id: productId,
        name: productName,
        price: productPrice,
        stock: productStock,
        category: productCategory,
        has_variants: hasVariants,
        is_out_of_stock: isOutOfStock
    };
    
    selectedVariant = null;
    currentQuantity = 1;
    document.getElementById('quantityInput').value = '1';
    
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('modalProductCategory').textContent = productCategory;
    updateAmountDisplay(document.getElementById('modalProductPrice'), productPrice);
    
    document.getElementById('selectedVariantInfo').classList.add('d-none');
    document.getElementById('confirmAddToCartBtn').disabled = true;
    document.getElementById('decreaseQty').disabled = true;
    document.getElementById('increaseQty').disabled = true;
    
    if (hasVariants) {
        document.getElementById('variantSelectionSection').classList.remove('d-none');
        document.getElementById('variantsList').innerHTML = `<div class="text-center py-4 text-muted"><i class="bi bi-arrow-repeat fa-spin me-2"></i>Memuat variant...</div>`;
        
        try {
            const response = await fetch(`/api/cashier/products/${productId}/variants`);
            const data = await response.json();
            
            if (data.success && data.variants && data.variants.length > 0) {
                displayVariantsInModal(data.variants);
            } else {
                document.getElementById('variantsList').innerHTML = `<div class="text-center py-4 text-muted"><i class="bi bi-box-seam fa-2x mb-3 opacity-50"></i><p class="mb-1">Tidak ada variant tersedia</p><p class="small mb-0">Menampilkan produk utama</p></div>`;
                document.getElementById('variantSelectionSection').classList.add('d-none');
                
                if (productStock !== null && productStock <= 0) {
                    showNotification('Produk ini stok habis', 'error');
                    document.getElementById('confirmAddToCartBtn').disabled = true;
                    document.getElementById('increaseQty').disabled = true;
                    document.getElementById('quantityInput').disabled = true;
                    document.getElementById('maxStock').textContent = '0 out of stock';
                    document.getElementById('maxStock').parentElement.classList.add('text-danger');
                } else {
                    const maxStock = productStock === null ? Infinity : productStock;
                    document.getElementById('quantityInput').max = maxStock === Infinity ? 100 : maxStock;
                    if (maxStock === Infinity) {
                        document.getElementById('maxStock').textContent = '';
                        document.getElementById('maxStock').parentElement.style.display = 'none';
                    } else {
                        document.getElementById('maxStock').textContent = maxStock;
                        document.getElementById('maxStock').parentElement.style.display = 'block';
                    }
                    document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : currentQuantity >= maxStock;
                    document.getElementById('confirmAddToCartBtn').disabled = false;
                }
            }
        } catch (error) {
            console.error('Error loading variants:', error);
            document.getElementById('variantsList').innerHTML = `<div class="text-center py-4 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Gagal memuat variant</div>`;
            document.getElementById('variantSelectionSection').classList.add('d-none');
            
            if (productStock !== null && productStock <= 0) {
                showNotification('Produk ini stok habis', 'error');
                document.getElementById('confirmAddToCartBtn').disabled = true;
                document.getElementById('increaseQty').disabled = true;
                document.getElementById('quantityInput').disabled = true;
                document.getElementById('maxStock').textContent = '0 out of stock';
                document.getElementById('maxStock').parentElement.classList.add('text-danger');
            } else {
                const maxStock = productStock === null ? Infinity : productStock;
                document.getElementById('quantityInput').max = maxStock === Infinity ? 100 : maxStock;
                if (maxStock === Infinity) {
                    document.getElementById('maxStock').textContent = '';
                    document.getElementById('maxStock').parentElement.style.display = 'none';
                } else {
                    document.getElementById('maxStock').textContent = maxStock;
                    document.getElementById('maxStock').parentElement.style.display = 'block';
                }
                document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : currentQuantity >= maxStock;
                document.getElementById('confirmAddToCartBtn').disabled = false;
            }
        }
    } else {
        document.getElementById('variantSelectionSection').classList.add('d-none');
        
        if (productStock !== null && productStock <= 0) {
            showNotification('Produk ini stok habis', 'error');
            document.getElementById('confirmAddToCartBtn').disabled = true;
            document.getElementById('increaseQty').disabled = true;
            document.getElementById('quantityInput').disabled = true;
            document.getElementById('maxStock').textContent = '0';
            document.getElementById('maxStock').parentElement.classList.add('text-danger');
        } else {
            const maxStock = productStock === null ? Infinity : productStock;
            document.getElementById('quantityInput').max = maxStock === Infinity ? 100 : maxStock;
            if (maxStock === Infinity) {
                document.getElementById('maxStock').textContent = '';
                document.getElementById('maxStock').parentElement.style.display = 'none';
            } else {
                document.getElementById('maxStock').textContent = maxStock;
                document.getElementById('maxStock').parentElement.style.display = 'block';
            }
            document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : currentQuantity >= maxStock;
            document.getElementById('confirmAddToCartBtn').disabled = false;
        }
    }
    
    updateModalTotal();
    const modalElement = document.getElementById('variantModal');
    variantModal = new bootstrap.Modal(modalElement);
    variantModal.show();
}

function displayVariantsInModal(variants) {
    if (variants.length === 0) {
        document.getElementById('variantsList').innerHTML = `<div class="text-center py-4 text-muted"><i class="bi bi-box-seam fa-2x mb-3 opacity-50"></i><p class="mb-1">Tidak ada variant tersedia</p></div>`;
        return;
    }
    
    const variantsList = document.getElementById('variantsList');
    variantsList.innerHTML = '';
    let hasAvailableVariant = false;
    
    variants.forEach((variant, index) => {
        const variantId = variant.id;
        const variantName = variant.name || 'Default';
        const variantPrice = parseFloat(variant.price || selectedProduct.price);
        const variantStock = variant.stock !== undefined ? variant.stock : null;
        const variantSKU = variant.sku || '';
        const variantColor = variant.color || '';
        const variantSize = variant.size || '';
        const isOutOfStock = variantStock !== null && variantStock <= 0;
        const stockText = variantStock !== null ? variantStock : '';
        
        if (!isOutOfStock) hasAvailableVariant = true;
        
        const variantElement = document.createElement('div');
        variantElement.className = `variant-option ${isOutOfStock ? 'disabled' : ''}`;
        variantElement.setAttribute('data-variant-id', variantId);
        variantElement.setAttribute('data-index', index);
        
        if (!isOutOfStock) variantElement.onclick = () => selectVariant(variant, variantElement);
        else variantElement.style.cursor = 'not-allowed';
        
        let variantInfo = '';
        if (variantSize) variantInfo += `Size: ${variantSize}`;
        if (variantColor) {
            if (variantInfo) variantInfo += ' | ';
            variantInfo += `Color: ${variantColor}`;
        }
        if (!variantSize && !variantColor && variantName) variantInfo = variantName;
        
        variantElement.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <h6 class="fw-semibold mb-1 ${isOutOfStock ? 'text-muted' : 'text-dark'}">${variantInfo || 'Default'}</h6>
                    <div class="small text-muted">
                        ${variantSKU ? `<div>SKU: ${variantSKU}</div>` : ''}
                        ${stockText ? `<div class="${isOutOfStock ? 'text-danger' : 'text-muted'}">
                            <i class="bi bi-box me-1"></i> Stok: ${stockText} ${isOutOfStock ? '(Habis)' : ''}
                        </div>` : ''}
                    </div>
                </div>
                <div class="text-end ms-3">
                    <div class="h5 fw-bold ${isOutOfStock ? 'text-muted' : 'text-primary'} mb-0 amount-display">$${formatCurrency(variantPrice)}</div>
                </div>
            </div>
        `;
        variantsList.appendChild(variantElement);
    });
    
    if (hasAvailableVariant) {
        const firstAvailableVariant = variants.find(v => v.stock === null || v.stock > 0);
        if (firstAvailableVariant) {
            const firstVariantElement = variantsList.querySelector('.variant-option:not(.disabled)');
            if (firstVariantElement) selectVariant(firstAvailableVariant, firstVariantElement);
        }
    } else {
        document.getElementById('confirmAddToCartBtn').disabled = true;
        document.getElementById('quantityInput').disabled = true;
        document.getElementById('decreaseQty').disabled = true;
        document.getElementById('increaseQty').disabled = true;
        showNotification('Semua variant stok habis', 'error');
    }
}

function selectVariant(variant, variantElement) {
    const variantId = variant.id;
    const variantName = variant.name || 'Default';
    const variantPrice = parseFloat(variant.price || selectedProduct.price);
    const variantStock = variant.stock !== undefined ? variant.stock : null;
    const variantSKU = variant.sku || '';
    const variantColor = variant.color || '';
    const variantSize = variant.size || '';
    
    if (variantStock !== null && variantStock <= 0) {
        showNotification('Variant ini stok habis', 'error');
        document.getElementById('confirmAddToCartBtn').disabled = true;
        document.getElementById('quantityInput').disabled = true;
        document.getElementById('decreaseQty').disabled = true;
        document.getElementById('increaseQty').disabled = true;
        document.getElementById('maxStock').textContent = '0';
        document.getElementById('maxStock').parentElement.classList.add('text-danger');
        return;
    }
    
    document.querySelectorAll('.variant-option').forEach(item => {
        item.classList.remove('selected', 'border-primary', 'bg-primary', 'bg-opacity-10');
        item.classList.add('border-light');
    });
    
    variantElement.classList.remove('border-light');
    variantElement.classList.add('selected', 'border-primary', 'bg-primary', 'bg-opacity-10');
    
    selectedVariant = {
        id: variantId,
        name: variantName,
        price: variantPrice,
        stock: variantStock,
        sku: variantSKU,
        color: variantColor,
        size: variantSize
    };
    
    updateAmountDisplay(document.getElementById('modalProductPrice'), variantPrice);
    const maxStock = variantStock === null ? Infinity : variantStock;
    document.getElementById('quantityInput').max = maxStock === Infinity ? 100 : maxStock;
    if (maxStock === Infinity) {
        document.getElementById('maxStock').textContent = '';
        document.getElementById('maxStock').parentElement.style.display = 'none';
    } else {
        document.getElementById('maxStock').textContent = maxStock;
        document.getElementById('maxStock').parentElement.style.display = 'block';
    }
    document.getElementById('maxStock').parentElement.classList.remove('text-danger');
    
    currentQuantity = 1;
    document.getElementById('quantityInput').value = '1';
    document.getElementById('quantityInput').disabled = false;
    document.getElementById('decreaseQty').disabled = true;
    document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : currentQuantity >= maxStock;
    
    let variantDisplayName = '';
    if (variantSize || variantColor) {
        if (variantSize) variantDisplayName += `Size: ${variantSize}`;
        if (variantColor) {
            if (variantDisplayName) variantDisplayName += ' | ';
            variantDisplayName += `Color: ${variantColor}`;
        }
    } else variantDisplayName = variantName || 'Default';
    
    document.getElementById('selectedVariantName').textContent = variantDisplayName;
    document.getElementById('selectedVariantSKU').textContent = variantSKU ? `SKU: ${variantSKU}` : '';
    updateAmountDisplay(document.getElementById('selectedVariantPrice'), variantPrice);
    document.getElementById('selectedVariantInfo').classList.remove('d-none');
    updateModalTotal();
    document.getElementById('confirmAddToCartBtn').disabled = false;
}

function closeVariantModal() {
    if (variantModal) variantModal.hide();
    selectedProduct = null;
    selectedVariant = null;
    currentQuantity = 1;
}

function updateQuantity(delta) {
    if (!selectedProduct) return;
    
    let maxStock = Infinity;
    if (selectedVariant) maxStock = selectedVariant.stock === null ? Infinity : selectedVariant.stock;
    else maxStock = selectedProduct.stock === null ? Infinity : selectedProduct.stock;
    
    if (maxStock === 0) {
        showNotification('Stok habis', 'error');
        return;
    }
    
    const currentValue = parseInt(document.getElementById('quantityInput').value) || 1;
    let newValue = currentValue + delta;
    newValue = Math.max(1, Math.min(maxStock === Infinity ? 100 : maxStock, newValue));
    
    currentQuantity = newValue;
    document.getElementById('quantityInput').value = newValue;
    document.getElementById('decreaseQty').disabled = newValue <= 1;
    document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : newValue >= maxStock;
    updateModalTotal();
}

function setQuantity(qty) {
    if (!selectedProduct) return;
    
    let maxStock = Infinity;
    if (selectedVariant) maxStock = selectedVariant.stock === null ? Infinity : selectedVariant.stock;
    else maxStock = selectedProduct.stock === null ? Infinity : selectedProduct.stock;
    
    if (maxStock === 0) {
        showNotification('Stok habis', 'error');
        return;
    }
    
    const newValue = Math.max(1, Math.min(maxStock === Infinity ? 100 : maxStock, qty));
    currentQuantity = newValue;
    document.getElementById('quantityInput').value = newValue;
    document.getElementById('decreaseQty').disabled = newValue <= 1;
    document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : newValue >= maxStock;
    updateModalTotal();
}

function validateQuantity() {
    if (!selectedProduct) return;
    
    let value = parseInt(document.getElementById('quantityInput').value) || 1;
    let maxStock = Infinity;
    if (selectedVariant) maxStock = selectedVariant.stock === null ? Infinity : selectedVariant.stock;
    else maxStock = selectedProduct.stock === null ? Infinity : selectedProduct.stock;
    
    if (maxStock === 0) {
        showNotification('Stok habis', 'error');
        document.getElementById('quantityInput').value = '0';
        currentQuantity = 0;
        document.getElementById('decreaseQty').disabled = true;
        document.getElementById('increaseQty').disabled = true;
        document.getElementById('confirmAddToCartBtn').disabled = true;
        return;
    }
    
    value = Math.max(1, Math.min(maxStock === Infinity ? 100 : maxStock, value));
    currentQuantity = value;
    document.getElementById('quantityInput').value = value;
    document.getElementById('decreaseQty').disabled = value <= 1;
    document.getElementById('increaseQty').disabled = maxStock === Infinity ? false : value >= maxStock;
    updateModalTotal();
}

function updateModalTotal() {
    if (!selectedProduct) return;
    const price = selectedVariant ? selectedVariant.price : selectedProduct.price;
    const total = price * currentQuantity;
    updateAmountDisplay(document.getElementById('modalTotalPrice'), total);
}

function addToCartFromModal() {
    if (!selectedProduct) {
        showNotification('Tidak ada produk yang dipilih', 'error');
        return;
    }
    
    if (selectedProduct.is_out_of_stock) {
        showNotification('Produk ini stok habis', 'error');
        return;
    }
    
    if (selectedVariant && selectedVariant.stock !== null && selectedVariant.stock <= 0) {
        showNotification('Variant ini stok habis', 'error');
        return;
    }
    
    if (!selectedVariant && selectedProduct.stock !== null && selectedProduct.stock <= 0) {
        showNotification('Produk ini stok habis', 'error');
        return;
    }
    
    if (selectedProduct.has_variants && !selectedVariant) {
        showNotification('Pilih variant terlebih dahulu', 'error');
        return;
    }
    
    let displayName = selectedProduct.name;
    let variantInfo = '';
    
    if (selectedVariant) {
        if (selectedVariant.size || selectedVariant.color) {
            if (selectedVariant.size) variantInfo += `Size: ${selectedVariant.size}`;
            if (selectedVariant.color) {
                if (variantInfo) variantInfo += ' | ';
                variantInfo += `Color: ${selectedVariant.color}`;
            }
        } else if (selectedVariant.name && selectedVariant.name !== 'Default') {
            variantInfo = selectedVariant.name;
        }
        
        if (variantInfo) displayName = `${selectedProduct.name} (${variantInfo})`;
    }
    
    const itemData = {
        id: selectedProduct.id,
        name: selectedProduct.name,
        price: selectedVariant ? selectedVariant.price : selectedProduct.price,
        quantity: currentQuantity,
        stock: selectedVariant ? (selectedVariant.stock === null ? Infinity : selectedVariant.stock) : (selectedProduct.stock === null ? Infinity : selectedProduct.stock),
        sku: selectedVariant ? selectedVariant.sku : '',
        variant_id: selectedVariant ? selectedVariant.id : null,
        variant_name: selectedVariant ? selectedVariant.name : null,
        variant_size: selectedVariant ? selectedVariant.size : null,
        variant_color: selectedVariant ? selectedVariant.color : null,
        display_name: displayName,
        variant_data: selectedVariant ? { id: selectedVariant.id, name: selectedVariant.name, size: selectedVariant.size, color: selectedVariant.color, sku: selectedVariant.sku } : null,
        is_out_of_stock: selectedVariant ? (selectedVariant.stock !== null && selectedVariant.stock <= 0) : (selectedProduct.stock !== null && selectedProduct.stock <= 0)
    };
    
    if (itemData.is_out_of_stock) {
        showNotification('Stok habis, tidak dapat ditambahkan ke keranjang', 'error');
        return;
    }
    
    const existingIndex = cart.findIndex(item => {
        if (item.variant_id && itemData.variant_id) return item.variant_id === itemData.variant_id;
        else if (!item.variant_id && !itemData.variant_id) return item.id === itemData.id;
        return false;
    });
    
    if (existingIndex !== -1) {
        const newQuantity = cart[existingIndex].quantity + itemData.quantity;
        if (cart[existingIndex].stock !== Infinity && newQuantity > cart[existingIndex].stock) {
            showNotification(`Stok tidak mencukupi! Stok tersisa: ${cart[existingIndex].stock}`, 'error');
            return;
        }
        cart[existingIndex].quantity = newQuantity;
        showNotification(`${itemData.display_name} ditambah menjadi ${newQuantity}`, 'success');
    } else {
        cart.push(itemData);
        showNotification(`${itemData.display_name} ditambahkan ke keranjang`, 'success');
    }
    
    closeVariantModal();
    updateCartUI();
}

// ==================== CART FUNCTIONS ====================
function updateCartUI() {
    const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
    const cartItemCountEl = document.getElementById('cartItemCount');
    if (cartItemCountEl) cartItemCountEl.textContent = `${itemCount} item${itemCount !== 1 ? 's' : ''}`;
    const mobileCartItemCountEl = document.getElementById('mobileCartItemCount');
    if (mobileCartItemCountEl) mobileCartItemCountEl.textContent = `${itemCount} item${itemCount !== 1 ? 's' : ''}`;
    updateDesktopCartItems();
    updateMobileCartItems();
    calculateTotals();
    updateMobileCartBadge();
    initCartEventListeners();
}

function updateDesktopCartItems() {
    const cartItems = document.getElementById('cartItems');
    if (!cartItems) return;
    
    cartItems.innerHTML = '';
    if (cart.length === 0) {
        const emptyMessage = document.getElementById('emptyCartMessage');
        if (emptyMessage) cartItems.appendChild(emptyMessage.cloneNode(true));
    } else {
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            const cartItem = document.createElement('div');
            
            let variantDetails = '';
            if (item.variant_size || item.variant_color) {
                if (item.variant_size) variantDetails += `Size: ${item.variant_size}`;
                if (item.variant_color) {
                    if (variantDetails) variantDetails += ' | ';
                    variantDetails += `Color: ${item.variant_color}`;
                }
            } else if (item.variant_name && item.variant_name !== 'Default') {
                variantDetails = item.variant_name;
            }
            
            cartItem.className = 'cart-item border-bottom pb-2 mb-2';
            cartItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 me-2">
                        <div class="d-flex align-items-start mb-1">
                            <div class="bg-primary bg-opacity-10 rounded p-1 me-2">
                                <i class="bi bi-tshirt-fill text-primary small"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1 text-dark small">${item.display_name || item.name}</h6>
                                <div class="small text-muted">
                                    <div>${item.quantity} x $${formatCurrency(item.price)}</div>
                                    ${variantDetails ? `<div>${variantDetails}</div>` : ''}
                                    ${item.sku ? `<div>SKU: ${item.sku}</div>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="h6 fw-bold text-primary mb-1 amount-display">$${formatCurrency(itemTotal)}</div>
                        <div class="d-flex gap-1">
                            <button class="decrease-item-btn btn btn-sm btn-outline-primary py-0 px-2" data-index="${index}"><i class="bi bi-dash-lg"></i></button>
                            <span class="px-2 py-0 bg-light rounded small d-flex align-items-center">${item.quantity}</span>
                            <button class="increase-item-btn btn btn-sm btn-outline-primary py-0 px-2" data-index="${index}"><i class="bi bi-plus-lg"></i></button>
                            <button class="remove-item-btn btn btn-sm btn-outline-danger py-0 px-2" data-index="${index}"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            `;
            cartItems.appendChild(cartItem);
        });
    }
    updateButtonStates();
}

function updateMobileCartItems() {
    const mobileCartItems = document.getElementById('mobileCartItems');
    if (!mobileCartItems) return;
    
    mobileCartItems.innerHTML = '';
    if (cart.length === 0) {
        const emptyMessage = document.getElementById('mobileEmptyCartMessage');
        if (emptyMessage) mobileCartItems.appendChild(emptyMessage.cloneNode(true));
    } else {
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            const cartItem = document.createElement('div');
            
            let variantDetails = '';
            if (item.variant_size || item.variant_color) {
                if (item.variant_size) variantDetails += `Size: ${item.variant_size}`;
                if (item.variant_color) {
                    if (variantDetails) variantDetails += ' | ';
                    variantDetails += `Color: ${item.variant_color}`;
                }
            } else if (item.variant_name && item.variant_name !== 'Default') {
                variantDetails = item.variant_name;
            }
            
            cartItem.className = 'cart-item border-bottom pb-2 mb-2';
            cartItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 me-2">
                        <div class="d-flex align-items-start mb-1">
                            <div class="bg-primary bg-opacity-10 rounded p-1 me-2">
                                <i class="bi bi-tshirt-fill text-primary small"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1 text-dark small">${item.display_name || item.name}</h6>
                                <div class="small text-muted">
                                    <div>${item.quantity} x ${formatCurrency(item.price)}</div>
                                    ${variantDetails ? `<div>${variantDetails}</div>` : ''}
                                    ${item.sku ? `<div>SKU: ${item.sku}</div>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="h6 fw-bold text-primary mb-1 amount-display">${formatCurrency(itemTotal)}</div>
                        <div class="d-flex gap-1">
                            <button class="mobile-decrease-item-btn btn btn-sm btn-outline-primary py-0 px-2" data-index="${index}"><i class="bi bi-dash-lg"></i></button>
                            <span class="px-2 py-0 bg-light rounded small d-flex align-items-center">${item.quantity}</span>
                            <button class="mobile-increase-item-btn btn btn-sm btn-outline-primary py-0 px-2" data-index="${index}"><i class="bi bi-plus-lg"></i></button>
                            <button class="mobile-remove-item-btn btn btn-sm btn-outline-danger py-0 px-2" data-index="${index}"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            `;
            mobileCartItems.appendChild(cartItem);
        });
    }
    updateMobileButtonStates();
}

function initCartEventListeners() {
    document.querySelectorAll('.remove-item-btn, .mobile-remove-item-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(btn.dataset.index);
            removeFromCart(index);
        });
    });
    
    document.querySelectorAll('.increase-item-btn, .mobile-increase-item-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(btn.dataset.index);
            increaseCartQuantity(index);
        });
    });
    
    document.querySelectorAll('.decrease-item-btn, .mobile-decrease-item-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(btn.dataset.index);
            decreaseCartQuantity(index);
        });
    });
}

function increaseCartQuantity(index) {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    const item = cart[index];
    const newQuantity = item.quantity + 1;
    
    if (item.is_out_of_stock) {
        showNotification('Item ini stok habis', 'error');
        return;
    }
    
    if (item.stock !== Infinity && item.stock !== null && newQuantity > item.stock) {
        showNotification(`Stok tidak mencukupi! Stok tersisa: ${item.stock}`, 'error');
        return;
    }
    
    cart[index].quantity = newQuantity;
    updateCartUI();
}

function decreaseCartQuantity(index) {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    const item = cart[index];
    if (item.quantity > 1) {
        cart[index].quantity -= 1;
        updateCartUI();
    } else removeFromCart(index);
}

function removeFromCart(index) {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    const item = cart[index];
    cart.splice(index, 1);
    updateCartUI();
    showNotification(`${item.display_name || item.name} dihapus dari keranjang`, 'warning');
}

function resetCart() {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    if (cart.length === 0) {
        showNotification('Keranjang sudah kosong', 'info');
        return;
    }
    
    const confirmed = confirm(`Yakin ingin mengosongkan keranjang?\n\nTotal: ${formatCurrency(getTotalAmount())}\n${cart.length} item di keranjang`);
    if (confirmed) {
        cart = [];
        discountApplied = 0;
        cashAmount = 0;
        mobileCashAmount = 0;
        
        const cashInputEl = document.getElementById('cashInput');
        if (cashInputEl) cashInputEl.value = '';
        const changeSectionEl = document.getElementById('changeSection');
        if (changeSectionEl) changeSectionEl.classList.add('d-none');
        
        const mobileCashInputEl = document.getElementById('mobileCashInput');
        if (mobileCashInputEl) mobileCashInputEl.value = '';
        const mobileChangeSectionEl = document.getElementById('mobileChangeSection');
        if (mobileChangeSectionEl) mobileChangeSectionEl.classList.add('d-none');
        
        updateCartUI();
        showNotification('Keranjang telah dikosongkan', 'info');
    }
}

function updateButtonStates() {
    const hasItems = cart.length > 0;
    const payBtnEl = document.getElementById('payBtn');
    if (payBtnEl) payBtnEl.disabled = !hasItems || !shiftActive;
    const printBtnEl = document.getElementById('printBtn');
    if (printBtnEl) printBtnEl.disabled = !hasItems || !shiftActive;
    const resetCartBtnEl = document.getElementById('resetCartBtn');
    if (resetCartBtnEl) resetCartBtnEl.disabled = !shiftActive;
}

function updateMobileButtonStates() {
    const hasItems = cart.length > 0;
    const mobilePayBtnEl = document.getElementById('mobilePayBtn');
    if (mobilePayBtnEl) mobilePayBtnEl.disabled = !hasItems || !shiftActive;
    const mobilePrintBtnEl = document.getElementById('mobilePrintBtn');
    if (mobilePrintBtnEl) mobilePrintBtnEl.disabled = !hasItems || !shiftActive;
    const mobileResetCartBtnEl = document.getElementById('mobileResetCartBtn');
    if (mobileResetCartBtnEl) mobileResetCartBtnEl.disabled = !shiftActive;
}

// ==================== PAYMENT CALCULATIONS ====================
function calculateTotals() {
    cleanAllRpText();
    
    const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
    const total = Math.max(0, subtotal - discountApplied);
    
    updateAmountDisplay(document.getElementById('subtotalAmount'), subtotal);
    updateAmountDisplay(document.getElementById('totalAmount'), total);
    updateAmountDisplay(document.getElementById('totalToPay'), total);
    updateAmountDisplay(document.getElementById('mobileSubtotalAmount'), subtotal);
    updateAmountDisplay(document.getElementById('mobileTotalAmount'), total);
    updateAmountDisplay(document.getElementById('mobileTotalToPay'), total);
    
    const cashInputEl = document.getElementById('cashInput');
    if (cashInputEl) cashInputEl.value = '';
    cashAmount = 0;
    const mobileCashInputEl = document.getElementById('mobileCashInput');
    if (mobileCashInputEl) mobileCashInputEl.value = '';
    mobileCashAmount = 0;
    
    const changeSectionEl = document.getElementById('changeSection');
    if (changeSectionEl) changeSectionEl.classList.add('d-none');
    const mobileChangeSectionEl = document.getElementById('mobileChangeSection');
    if (mobileChangeSectionEl) mobileChangeSectionEl.classList.add('d-none');
    
    updateButtonStates();
    updateMobileButtonStates();
}

function calculateChange() {
    const total = getTotalAmount();
    const change = cashAmount - total;
    const changeSectionEl = document.getElementById('changeSection');
    const changeAmountEl = document.getElementById('changeAmount');
    const payBtnEl = document.getElementById('payBtn');
    
    if (change >= 0 && cashAmount > 0) {
        // HAPUS SEMUA Rp DAN PASTIKAN HANYA $
        if (changeAmountEl.textContent.includes('Rp')) {
            changeAmountEl.textContent = changeAmountEl.textContent.replace(/Rp\s*/gi, '');
        }
        changeAmountEl.textContent =  formatCurrency(change);
        if (changeSectionEl) changeSectionEl.classList.remove('d-none');
        if (payBtnEl) payBtnEl.disabled = false;
    } else {
        if (changeSectionEl) changeSectionEl.classList.add('d-none');
        if (payBtnEl) payBtnEl.disabled = true;
    }
}

function calculateMobileChange() {
    const total = getTotalAmount();
    const change = mobileCashAmount - total;
    const changeSectionEl = document.getElementById('mobileChangeSection');
    const changeAmountEl = document.getElementById('mobileChangeAmount');
    const payBtnEl = document.getElementById('mobilePayBtn');
    
    if (change >= 0 && mobileCashAmount > 0) {
        // HAPUS SEMUA Rp DAN PASTIKAN HANYA $
        if (changeAmountEl.textContent.includes('Rp')) {
            changeAmountEl.textContent = changeAmountEl.textContent.replace(/Rp\s*/gi, '');
        }
        changeAmountEl.textContent = formatCurrency(change);
        if (changeSectionEl) changeSectionEl.classList.remove('d-none');
        if (payBtnEl) payBtnEl.disabled = false;
    } else {
        if (changeSectionEl) changeSectionEl.classList.add('d-none');
        if (payBtnEl) payBtnEl.disabled = true;
    }
}

// ==================== MOBILE VIEW MANAGEMENT ====================
function initMobileView() {
    if (!isMobile) {
        const cartSection = document.getElementById('cartSection');
        if (cartSection) cartSection.classList.remove('d-none');
        return;
    }
    
    const cartSection = document.getElementById('cartSection');
    if (cartSection) cartSection.classList.add('d-none');
    
    const mobileCartModalEl = document.getElementById('mobileCartModal');
    if (mobileCartModalEl) {
        mobileCartModal = new bootstrap.Modal(mobileCartModalEl);
        const showCartBtn = document.getElementById('showCartBtn');
        if (showCartBtn) showCartBtn.addEventListener('click', () => mobileCartModal.show());
    }
}

function updateMobileCartBadge() {
    const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
    const badge = document.getElementById('mobileCartBadge');
    if (badge) {
        if (itemCount > 0) {
            badge.textContent = itemCount > 99 ? '99+' : itemCount;
            badge.classList.remove('d-none');
        } else badge.classList.add('d-none');
    }
}

// ==================== PRINT RECEIPT FUNCTION ====================
function printTransactionReceipt(transactionData) {
    try {
        const printWindow = window.open('', '_blank', 'width=400,height=600');
        if (!printWindow) {
            console.error('Failed to open print window');
            showNotification('Gagal membuka jendela print. Izinkan popup untuk situs ini.', 'error');
            return;
        }
        
        // Helper function to clean price from "Rp" and format
        function cleanAndFormatPrice(price) {
            // If price is already a number, just format it
            if (typeof price === 'number') {
                return price.toFixed(2);
            }
            
            // If price is a string, remove "Rp" and any formatting
            if (typeof price === 'string') {
                // Remove "Rp", commas, dots (except decimal), and spaces
                let cleaned = price.replace(/Rp\s*/gi, '') // Remove Rp
                                   .replace(/\./g, '')     // Remove thousand separators (.)
                                   .replace(/,/g, '.')     // Replace comma with dot for decimal
                                   .replace(/\s/g, '');    // Remove spaces
                
                // Parse to float
                const numPrice = parseFloat(cleaned);
                return isNaN(numPrice) ? '0.00' : numPrice.toFixed(2);
            }
            
            return '0.00';
        }
        
        // Clean transaction data prices
        const cleanedTransactionData = {
            ...transactionData,
            items: transactionData.items.map(item => ({
                ...item,
                // Clean price for display
                displayPrice: cleanAndFormatPrice(item.price),
                displayTotal: cleanAndFormatPrice(item.price * item.quantity)
            })),
            subtotal: cleanAndFormatPrice(transactionData.subtotal),
            discount: cleanAndFormatPrice(transactionData.discount || 0),
            total: cleanAndFormatPrice(transactionData.total),
            paid: cleanAndFormatPrice(transactionData.paid),
            change: cleanAndFormatPrice(transactionData.change)
        };
        
        const receiptContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Struk - Dili Society</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
/* ================= PRINT SETUP ================= */
@media print {
    @page {
        size: 80mm auto;
        margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
    }
}

/* ================= RESET ================= */
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ================= BODY ================= */
body {
    font-family: "Courier New", Courier, monospace;
    font-size: 15px;           /* ⬆️ Diperbesar */
    font-weight: 400;          /* ❌ Tidak bold */
    line-height: 1.5;
    width: 80mm;
    background: #fff;
    color: #000;
}

/* ================= CONTAINER ================= */
.receipt {
    padding: 10px 8px;
}

/* ================= HEADER ================= */
.header {
    text-align: center;
    padding-bottom: 10px;
    border-bottom: 2px dashed #000;
}


.header img {
    max-width: 90px;
    margin-bottom: 6px;
}

.store-name {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 4px;
}

.store-info {
    font-size: 13px;
}


/* ================= TRANSACTION INFO ================= */
.transaction-info {
    font-size: 13px;
    margin: 10px 0;
}


.transaction-info div {
    display: flex;
    justify-content: space-between;
}
    .transaction-info .trx-code {
    font-weight: 400; /* normal, TIDAK bold */
}


/* ================= DIVIDER ================= */
.divider {
    border-top: 1px dashed #000;
    margin: 8px 0;
}

.divider-thick {
    border-top: 2px solid #000;
    margin: 10px 0;
}

/* ================= ITEMS ================= */
.items {
    margin-top: 6px;
}

.item-row {
    display: flex;
    justify-content: space-between;
    margin: 6px 0;
    font-size: 14px;
}

.item-name {
    flex: 3;
}

.item-qty {
    flex: 1;
    text-align: right;
    padding-right: 4px;
}

.item-price {
    flex: 2;
    text-align: right;
}
        
.item-total {
    flex: 2;
    text-align: right;
}
.item-variant {
    font-size: 12px;
    margin-left: 4px;
    margin-bottom: 4px;
}
    

/* ================= TOTAL ================= */
.totals {
    margin-top: 10px;
    padding-top: 8px;
    border-top: 2px solid #000;
}

.total-row {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    margin: 4px 0;
}

/* HANYA TOTAL YANG BOLD */
.total-label,
.total-amount {
    font-weight: 700;
    font-size: 17px;
}

/* ================= PAYMENT ================= */
.payment-info {
    margin-top: 10px;
    padding-top: 6px;
    border-top: 1px dashed #000;
    font-size: 14px;
}

.payment-row {
    display: flex;
    justify-content: space-between;
}

/* ================= BARCODE ================= */
.barcode {
    text-align: center;
    margin: 12px 0;
}

/* ================= FOOTER ================= */
.footer {
    text-align: center;
    margin-top: 14px;
    padding-top: 8px;
    border-top: 2px dashed #000;
    font-size: 12px;
    line-height: 1.4;
}

.thank-you {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
}
</style>

        </head>
        <body>
            <div class="receipt">
                <!-- HEADER -->
                <div class="header">
                     <img src="{{ url_for('static', filename='images/logo.png') }}" alt="Logo" style="max-width: 100px; margin-bottom: 10px;">
                    <div class="store-info">R. Gov. José Celestino da Silva, Díli</div>
                    <div class="store-info">Telp: +670 77430583</div>
                </div>
                
                <div class="divider"></div>
                
                <!-- INFO TRANSAKSI -->
                <div class="transaction-info">
                    <div>
  <span>No. Transaksi:</span>
  <span class="trx-code">${transactionData.code}</span>
</div>
                   <div><span class="text-bold">Tanggal:</span> ${
    new Date().toLocaleDateString('id-ID', {
        timeZone: 'Asia/Dili',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}</div>

<div><span class="text-bold">Waktu:</span> ${
    new Date().toLocaleTimeString('id-ID', {
        timeZone: 'Asia/Dili',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    })
}</div>

                    <div><span class="text-bold">Kasir:</span> ${document.querySelector('meta[name="cashier-name"]')?.getAttribute('content') || 'Kasir'}</div>
                </div>
                
                <div class="divider"></div>
                
                <!-- ITEMS -->
                <div class="items">
                    ${cleanedTransactionData.items.map(item => {
                        let variantText = '';
                        if (item.variant_size || item.variant_color) {
                            variantText = '(';
                            if (item.variant_size) variantText += `Size: ${item.variant_size}`;
                            if (item.variant_color) {
                                if (item.variant_size) variantText += ', ';
                                variantText += `Color: ${item.variant_color}`;
                            }
                            variantText += ')';
                        }
                        
                        return `
                        <div class="item-row">
                            <div class="item-name">${item.name}</div>
                            <div class="item-qty">
    ${item.quantity} ×
</div>
                            <div class="item-price">
    $${item.displayPrice}
</div>
                            <div class="item-total">$${item.displayTotal}</div>
                        </div>
                        ${variantText ? `<div class="item-variant">${variantText}</div>` : ''}
                        `;
                    }).join('')}
                </div>
                
                <div class="divider-thick"></div>
                
                <!-- TOTALS -->
                <div class="totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>$${cleanedTransactionData.subtotal}</span>
                    </div>
                    ${cleanedTransactionData.discount !== '0.00' ? `
                    <div class="total-row">
                        <span>Diskon:</span>
                        <span>-$${cleanedTransactionData.discount}</span>
                    </div>
                    ` : ''}
                    <div class="total-row">
                        <span class="total-label">TOTAL:</span>
                        <span class="total-amount">$${cleanedTransactionData.total}</span>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <!-- PAYMENT -->
                <div class="payment-info">
                    <div class="payment-row">
                        <span>Bayar (Cash):</span>
                        <span>$${cleanedTransactionData.paid}</span>
                    </div>
                    <div class="payment-row">
                        <span class="text-bold">Kembali:</span>
                        <span class="text-bold">$${cleanedTransactionData.change}</span>
                    </div>
                </div>
                
                <div class="divider"></div>
                
            
                
                <!-- FOOTER -->
                <div class="footer">
                    <div class="thank-you">TERIMA KASIH</div>
                    <div>Barang yang sudah dibeli</div>
                    <div>tidak dapat ditukar atau dikembalikan</div>
                    <div style="margin-top: 6px;">--------------------------------</div>

                </div>
            </div>
            
<script>
(function () {
    let printed = false;

    window.onload = function () {
        if (printed) return;
        printed = true;
        window.print();
    };

    window.onafterprint = function () {
        window.close();
    };
})();
<\/script>


        </body>
        </html>
        `;
        
        // Write to print window
        printWindow.document.write(receiptContent);
        printWindow.document.close();
        
    } catch (error) {
        console.error('Error printing receipt:', error);
        showNotification('Error mencetak struk: ' + error.message, 'error');
    }
}

// ==================== BARCODE SCANNER FUNCTIONS ====================
const barcodeInput = document.getElementById('barcodeInput');

// Fungsi untuk fokus ke barcode input
function focusBarcode() {
    if (barcodeInput && !barcodeInput.disabled) {
        barcodeInput.focus();
    }
}

// Fungsi utama untuk handle barcode scan
async function handleBarcodeScan(code) {
    try {
        console.log('📦 Scanning barcode:', code);
        
        const res = await fetch(`/api/cashier/scan-barcode?code=${encodeURIComponent(code)}`);
        const data = await res.json();

        // ===== BLOK STOK HABIS =====
        if (!res.ok && data.blocked) {
            showNotification(`⛔ ${data.message}`, 'error');
            return;
        }

        if (!data.success) {
            showNotification('❌ Barcode tidak dikenal', 'error');
            return;
        }

        // ================= VARIANT =================
        if (data.type === 'variant') {
            addVariantByScan(data.product, data.variant);
        }

        // ================= PRODUCT =================
        if (data.type === 'product') {
            addProductByScan(data.product);
        }

        updateCartUI();
        showNotification('✅ Produk ditambahkan ke keranjang', 'success');

    } catch (err) {
        console.error('Barcode scan error:', err);
        showNotification('❌ Gagal scan barcode', 'error');
    }
}

// Fungsi untuk menambahkan variant dari scan
function addVariantByScan(product, variant) {
    console.log('Adding variant to cart:', variant);
    
    // Cari apakah variant sudah ada di cart
    const existingIndex = cart.findIndex(item => 
        item.variant_id && item.variant_id === variant.id
    );
    
    // Hitung stok tersedia
    const currentStock = variant.stock || 0;
    
    if (existingIndex !== -1) {
        // Jika variant sudah ada di cart
        const currentQuantity = cart[existingIndex].quantity;
        
        if (currentStock !== Infinity && currentQuantity + 1 > currentStock) {
            showNotification('⛔ Stok variant tidak mencukupi', 'warning');
            return;
        }
        
        cart[existingIndex].quantity += 1;
        console.log('Increased variant quantity:', cart[existingIndex]);
    } else {
        // Jika variant belum ada di cart
        if (currentStock <= 0) {
            showNotification('⛔ Stok variant habis', 'error');
            return;
        }
        
        // Format nama untuk display
        let variantInfo = '';
        if (variant.size || variant.color) {
            if (variant.size) variantInfo += `Size: ${variant.size}`;
            if (variant.color) {
                if (variantInfo) variantInfo += ' | ';
                variantInfo += `Color: ${variant.color}`;
            }
        } else if (variant.name && variant.name !== 'Default') {
            variantInfo = variant.name;
        }
        
        const displayName = variantInfo ? 
            `${product.name} (${variantInfo})` : 
            `${product.name}${variant.name && variant.name !== 'Default' ? ` (${variant.name})` : ''}`;
        
        // Buat item dengan struktur yang sama dengan sistem cart
        const newItem = {
            id: product.id,
            name: product.name,
            price: parseFloat(variant.price),
            quantity: 1,
            stock: currentStock === null ? Infinity : currentStock,
            sku: variant.sku || '',
            variant_id: variant.id,
            variant_name: variant.name,
            variant_size: variant.size,
            variant_color: variant.color,
            display_name: displayName,
            variant_data: {
                id: variant.id,
                name: variant.name,
                size: variant.size,
                color: variant.color,
                sku: variant.sku
            },
            is_out_of_stock: currentStock <= 0
        };
        
        cart.push(newItem);
        console.log('Added new variant to cart:', newItem);
    }
}

// Fungsi untuk menambahkan product dari scan
function addProductByScan(product) {
    console.log('Adding product to cart:', product);
    
    // Cari apakah produk sudah ada di cart (tanpa variant)
    const existingIndex = cart.findIndex(item => 
        !item.variant_id && item.id === product.id
    );
    
    // Hitung stok tersedia
    const currentStock = product.stock || 0;
    
    if (existingIndex !== -1) {
        // Jika produk sudah ada di cart
        const currentQuantity = cart[existingIndex].quantity;
        
        if (currentStock !== Infinity && currentQuantity + 1 > currentStock) {
            showNotification('⛔ Stok produk tidak mencukupi', 'warning');
            return;
        }
        
        cart[existingIndex].quantity += 1;
        console.log('Increased product quantity:', cart[existingIndex]);
    } else {
        // Jika produk belum ada di cart
        if (currentStock <= 0) {
            showNotification('⛔ Stok produk habis', 'error');
            return;
        }
        
        // Buat item dengan struktur yang sama dengan sistem cart
        const newItem = {
            id: product.id,
            name: product.name,
            price: parseFloat(product.price),
            quantity: 1,
            stock: currentStock === null ? Infinity : currentStock,
            sku: product.sku || '',
            variant_id: null,
            variant_name: null,
            variant_size: null,
            variant_color: null,
            display_name: product.name,
            variant_data: null,
            is_out_of_stock: currentStock <= 0
        };
        
        cart.push(newItem);
        console.log('Added new product to cart:', newItem);
    }
}

// ==================== PAYMENT PROCESSING ====================
async function processPayment() {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif', 'error');
        return;
    }
    
    const total = getTotalAmount();
    const currentCashAmount = isMobile ? mobileCashAmount : cashAmount;
    
    if (currentCashAmount < total) {
        showNotification(`Uang kurang! Kurang $${formatCurrency(total - currentCashAmount)}`, 'error');
        return;
    }
    
    const transactionData = {
        items: cart.map(item => ({
            product_id: item.id,
            variant_id: item.variant_id || null,
            name: item.display_name || item.name,
            quantity: item.quantity,
            price: item.price,
            sku: item.sku || null,
            variant_name: item.variant_name || null,
            variant_size: item.variant_size || null,
            variant_color: item.variant_color || null
        })),
        subtotal: cart.reduce((total, item) => total + (item.price * item.quantity), 0),
        discount: discountApplied,
        total: total,
        paid: currentCashAmount,
        change: currentCashAmount - total,
        payment_method: 'cash',
        cash_drawer_id: cashDrawerId
    };
    
    const payBtn = document.getElementById(isMobile ? 'mobilePayBtn' : 'payBtn');
    if (payBtn) {
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="bi bi-arrow-repeat fa-spin me-2"></i>Memproses...';
    }
    
    try {
        const response = await fetch('/api/cashier/transaction', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRFToken': getCSRFToken() },
            body: JSON.stringify(transactionData)
        });
        
        const data = await response.json();
        if (data.success) {
            showNotification(`Transaksi berhasil! No: ${data.transaction.code}`, 'success');
            printTransactionReceipt({ ...transactionData, code: data.transaction.code, id: data.transaction.id });
            cart = [];
            discountApplied = 0;
            cashAmount = 0;
            mobileCashAmount = 0;
            document.getElementById('cashInput').value = '';
            document.getElementById('mobileCashInput').value = '';
            updateCartUI();
            if (isMobile && mobileCartModal) mobileCartModal.hide();
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Bayar';
            }
            setTimeout(() => cleanAllRpText(), 1000);
        } else {
            showNotification(`${data.message}`, 'error');
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Bayar';
            }
        }
    } catch (error) {
        console.error('Error processing payment:', error);
        showNotification('Error jaringan saat memproses pembayaran', 'error');
        if (payBtn) {
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="bi bi-credit-card me-2"></i>Bayar';
        }
    }
}

// ==================== KEYPAD FUNCTIONS ====================
function handleKeypadInput(key, isMobile = false) {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    const cashInputEl = document.getElementById(isMobile ? 'mobileCashInput' : 'cashInput');
    if (!cashInputEl) return;
    
    let currentValue = cashInputEl.value.replace(/[^\d]/g, '');
    
    if (key === '000') {
        if (currentValue === '0' || currentValue === '') currentValue = '0';
        else currentValue += '000';
    } else {
        if (currentValue === '0') currentValue = key;
        else currentValue += key;
    }
    
    if (currentValue.length > 10) currentValue = currentValue.substring(0, 10);
    cashInputEl.value = currentValue;
    formatCashInput(cashInputEl, isMobile);
    
    // PASTIKAN TIDAK ADA Rp DI KEYPAD
    setTimeout(() => {
        if (cashInputEl.value.includes('Rp')) {
            cashInputEl.value = cashInputEl.value.replace(/Rp\s*/gi, '$');
        }
    }, 10);
}

function handleBackspace(isMobile = false) {
    if (!shiftActive || cashDrawerId === 0) {
        showNotification('Shift tidak aktif. Buka shift terlebih dahulu.', 'error');
        return;
    }
    
    const cashInputEl = document.getElementById(isMobile ? 'mobileCashInput' : 'cashInput');
    if (!cashInputEl) return;
    
    let currentValue = cashInputEl.value.replace(/[^\d]/g, '');
    if (currentValue.length > 0) currentValue = currentValue.slice(0, -1);
    cashInputEl.value = currentValue;
    formatCashInput(cashInputEl, isMobile);
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('POS System Initialized');
    
    try {
        shiftActive = document.getElementById('shiftActive').value === 'true';
        cashDrawerId = parseInt(document.getElementById('cashDrawerId').value) || 0;
        
        console.log('Shift Active:', shiftActive);
        console.log('Cash Drawer ID:', cashDrawerId);
        
        // Bersihkan semua Rp
        cleanAllRpText();
        setTimeout(() => cleanAllRpText(), 100);
        setTimeout(() => cleanAllRpText(), 500);
        
        // Monitor dan hapus Rp secara berkala
        setInterval(() => {
            document.querySelectorAll('.amount-display, .price-display, #changeAmount, #mobileChangeAmount, #cashInput, #mobileCashInput').forEach(el => {
                if (el.textContent && el.textContent.includes('Rp')) {
                    el.textContent = el.textContent.replace(/Rp\s*/gi, '$');
                }
                if (el.value && el.value.includes('Rp')) {
                    el.value = el.value.replace(/Rp\s*/gi, '$');
                }
            });
        }, 300);
        
        // Setup event listeners
        setupEventListeners();
        
        // Setup barcode scanner
        setupBarcodeScanner();
        
        // Initialize mobile view
        initMobileView();
        
        // Update cart UI
        updateCartUI();
        
        const variantModalEl = document.getElementById('variantModal');
        if (variantModalEl) variantModalEl.addEventListener('shown.bs.modal', () => cleanAllRpText());
        
        const mobileCartModalEl = document.getElementById('mobileCartModal');
        if (mobileCartModalEl) mobileCartModalEl.addEventListener('shown.bs.modal', () => cleanAllRpText());
        
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                isMobile = window.innerWidth < 992;
                initMobileView();
            }, 100);
        });
        
    } catch (error) {
        console.error('Initialization error:', error);
        showNotification('❌ Error initializing POS system', 'error');
    }
});

function setupEventListeners() {
    // Category filter
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!btn.disabled) filterProductsByCategory(btn.dataset.category);
        });
    });
    
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart-modal-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.disabled) {
                const productCard = this.closest('.product-card');
                const isOutOfStock = productCard.dataset.outOfStock === 'true';
                if (isOutOfStock) showNotification('Produk ini stok habis', 'error');
                return;
            }
            const productCard = this.closest('.product-card');
            openAddToCartModal(productCard);
        });
    });
    
    // Modal controls
    const decreaseQtyBtn = document.getElementById('decreaseQty');
    if (decreaseQtyBtn) decreaseQtyBtn.addEventListener('click', (e) => { e.preventDefault(); updateQuantity(-1); });
    const increaseQtyBtn = document.getElementById('increaseQty');
    if (increaseQtyBtn) increaseQtyBtn.addEventListener('click', (e) => { e.preventDefault(); updateQuantity(1); });
    const quantityInput = document.getElementById('quantityInput');
    if (quantityInput) {
        quantityInput.addEventListener('change', validateQuantity);
        quantityInput.addEventListener('input', validateQuantity);
    }
    const confirmAddToCartBtn = document.getElementById('confirmAddToCartBtn');
    if (confirmAddToCartBtn) confirmAddToCartBtn.addEventListener('click', (e) => { e.preventDefault(); addToCartFromModal(); });
    
    // Keypad buttons - HAPUS Rp DARI KEYPAD
    document.querySelectorAll('.keypad-btn[data-key], .mobile-keypad-btn[data-key]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (!btn.disabled) {
                const key = btn.dataset.key;
                const isMobileBtn = btn.classList.contains('mobile-keypad-btn');
                handleKeypadInput(key, isMobileBtn);
                // Pastikan tombol keypad tidak punya teks Rp
                if (btn.textContent.includes('Rp')) {
                    btn.textContent = btn.textContent.replace(/Rp\s*/gi, '');
                }
            }
        });
    });
    
    // Backspace
    const backspaceBtn = document.getElementById('backspaceBtn');
    if (backspaceBtn) backspaceBtn.addEventListener('click', (e) => { e.preventDefault(); if (!backspaceBtn.disabled) handleBackspace(false); });
    const mobileBackspaceBtn = document.getElementById('mobileBackspaceBtn');
    if (mobileBackspaceBtn) mobileBackspaceBtn.addEventListener('click', (e) => { e.preventDefault(); if (!mobileBackspaceBtn.disabled) handleBackspace(true); });
    
    // Payment buttons
    const payBtn = document.getElementById('payBtn');
    if (payBtn) payBtn.addEventListener('click', (e) => { e.preventDefault(); if (!payBtn.disabled) processPayment(); });
    const mobilePayBtn = document.getElementById('mobilePayBtn');
    if (mobilePayBtn) mobilePayBtn.addEventListener('click', (e) => { e.preventDefault(); if (!mobilePayBtn.disabled) processPayment(); });
    
    // Reset buttons
    const resetCartBtn = document.getElementById('resetCartBtn');
    if (resetCartBtn) resetCartBtn.addEventListener('click', (e) => { e.preventDefault(); if (!resetCartBtn.disabled) resetCart(); });
    const mobileResetCartBtn = document.getElementById('mobileResetCartBtn');
    if (mobileResetCartBtn) mobileResetCartBtn.addEventListener('click', (e) => { e.preventDefault(); if (!mobileResetCartBtn.disabled) resetCart(); });
    
    // Cash input enter
    const cashInput = document.getElementById('cashInput');
    if (cashInput) cashInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') { e.preventDefault(); processPayment(); } });
    const mobileCashInput = document.getElementById('mobileCashInput');
    if (mobileCashInput) mobileCashInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') { e.preventDefault(); processPayment(); } });
    
    // Print buttons
    const printBtn = document.getElementById('printBtn');
    if (printBtn) printBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!this.disabled && cart.length > 0) {
            const transactionData = {
                items: cart.map(item => ({
                    product_id: item.id,
                    variant_id: item.variant_id || null,
                    name: item.display_name || item.name,
                    quantity: item.quantity,
                    price: item.price,
                    sku: item.sku || null,
                    variant_name: item.variant_name || null,
                    variant_size: item.variant_size || null,
                    variant_color: item.variant_color || null
                })),
                subtotal: cart.reduce((total, item) => total + (item.price * item.quantity), 0),
                discount: discountApplied,
                total: getTotalAmount(),
                code: 'TEMP-' + Date.now().toString().slice(-6),
                paid: 0,
                change: 0
            };
            printTransactionReceipt(transactionData);
        }
    });
    
    const mobilePrintBtn = document.getElementById('mobilePrintBtn');
    if (mobilePrintBtn) mobilePrintBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!this.disabled && cart.length > 0) {
            const transactionData = {
                items: cart.map(item => ({
                    product_id: item.id,
                    variant_id: item.variant_id || null,
                    name: item.display_name || item.name,
                    quantity: item.quantity,
                    price: item.price,
                    sku: item.sku || null,
                    variant_name: item.variant_name || null,
                    variant_size: item.variant_size || null,
                    variant_color: item.variant_color || null
                })),
                subtotal: cart.reduce((total, item) => total + (item.price * item.quantity), 0),
                discount: discountApplied,
                total: getTotalAmount(),
                code: 'TEMP-' + Date.now().toString().slice(-6),
                paid: 0,
                change: 0
            };
            printTransactionReceipt(transactionData);
        }
    });
}

// Setup barcode scanner
function setupBarcodeScanner() {
    // Event listener untuk barcode input
    barcodeInput.addEventListener('keydown', async (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const code = barcodeInput.value.trim();
            barcodeInput.value = '';

            if (!code) return;

            console.log('📦 BARCODE SCANNED:', code);
            await handleBarcodeScan(code);
        }
    });

    // Auto-focus barcode input
    document.addEventListener('click', focusBarcode);
    window.addEventListener('focus', focusBarcode);
    
    // Focus on load
    setTimeout(focusBarcode, 500);
}

// ==================== EXPORT FUNCTIONS ====================
window.closeVariantModal = closeVariantModal;
window.formatCashInput = formatCashInput;
window.formatMobileCashInput = formatMobileCashInput;
window.validateQuantity = validateQuantity;

console.log('POS System JavaScript loaded successfully');
</script>
@endsection
