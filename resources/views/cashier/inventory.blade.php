@extends('cashier.layout')

@section('title', 'Inventori - Dili Society')

@section('page_title', 'Inventori')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4 mx-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h2 class="h3 mb-2 fw-bold text-navy-dark">Inventori Produk</h2>
                    <p class="text-muted mb-0">Daftar produk & varian. Pantau ketersediaan stok Anda.</p>
                </div>
                <div>
                    <div class="d-flex align-items-center px-3 py-2 rounded-lg bg-gradient-to-r from-blue-50 to-white border border-blue-100">
                        <div class="w-3 h-3 rounded-circle bg-primary me-2"></div>
                        <span class="fw-medium text-primary">Total: {{ products.total }} produk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="card border-0 shadow-sm mb-4 mx-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- Search Input -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input 
                            type="text" 
                            id="searchInput"
                            placeholder="Cari produk atau SKU..."
                            class="form-control border-start-0"
                            value="{{ search_query or '' }}"
                        >
                    </div>
                </div>
                
                <!-- Desktop Filters -->
                <div class="col-md-8 d-flex gap-2">
                    <!-- Category Filter -->
                    <div class="flex-grow-1">
                        <select 
                            id="categoryFilter" 
                            class="form-select"
                        >
                            <option value="">Semua Kategori</option>
                            {% for category in categories %}
                            <option value="{{ category.id }}" {% if selected_category_id == category.id|string %}selected{% endif %}>
                                {{ category.name }}
                            </option>
                            {% endfor %}
                        </select>
                    </div>
                    
                    <!-- Stock Status Filter -->
                    <div class="flex-grow-1">
                        <select 
                            id="stockFilter" 
                            class="form-select"
                        >
                            <option value="">Semua Status</option>
                            <option value="low" {% if stock_status == 'low' %}selected{% endif %}>Stok Rendah</option>
                            <option value="critical" {% if stock_status == 'critical' %}selected{% endif %}>Stok Kritis</option>
                            <option value="out" {% if stock_status == 'out' %}selected{% endif %}>Habis Stok</option>
                        </select>
                    </div>
                    
                    <!-- Items Per Page Filter -->
                    <div>
                        <select 
                            id="perPageFilter" 
                            class="form-select"
                            onchange="changePerPage(this.value)"
                        >
                            <option value="10" {% if per_page == 10 %}selected{% endif %}>10 per halaman</option>
                            <option value="25" {% if per_page == 25 %}selected{% endif %}>25 per halaman</option>
                            <option value="50" {% if per_page == 50 %}selected{% endif %}>50 per halaman</option>
                            <option value="100" {% if per_page == 100 %}selected{% endif %}>100 per halaman</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Quick Stats -->
    <div class="d-md-none mb-4 mx-4">
        <div class="row g-2">
            <div class="col-4">
                <div class="card bg-primary bg-opacity-10 border-primary border-opacity-25">
                    <div class="card-body p-3 text-center">
                        <div class="text-primary small mb-1">Total Produk</div>
                        <div class="h4 fw-bold text-navy-dark">{{ products.total }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-success bg-opacity-10 border-success border-opacity-25">
                    <div class="card-body p-3 text-center">
                        <div class="text-success small mb-1">Ditampilkan</div>
                        <div class="h4 fw-bold text-navy-dark">{{ products.items|length }}</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-purple bg-opacity-10 border-purple border-opacity-25">
                    <div class="card-body p-3 text-center">
                        <div class="text-purple small mb-1">Halaman</div>
                        <div class="h4 fw-bold text-navy-dark">{{ products.page }}/{{ products.pages }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel inventori -->
    <div class="card border-0 shadow-sm mx-4">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 ps-4" style="width: 35%">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-box me-2 text-primary"></i>
                                <span>Produk</span>
                            </div>
                        </th>
                        <th class="border-0" style="width: 15%">
                            <span>Kategori</span>
                        </th>
                        <th class="border-0" style="width: 15%">
                            <span>Harga</span>
                        </th>
                        <th class="border-0" style="width: 20%">
                            <span>Stok</span>
                        </th>
                        <th class="border-0 pe-4" style="width: 15%">
                            <span>Status</span>
                        </th>
                    </tr>
                </thead>

                <tbody class="border-top-0">
                    {% for product in products.items %}
                    
                    <!-- Baris Produk Utama -->
                    <tr class="hover-bg">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle bg-gradient-to-br {% if product.variants %}bg-purple bg-opacity-10 border border-purple border-opacity-25{% else %}bg-primary bg-opacity-10 border border-primary border-opacity-25{% endif %} d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-box {% if product.variants %}text-purple{% else %}text-primary{% endif %}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-navy-dark">{{ product.name }}</div>
                                    {% if product.sku %}
                                    <div class="badge bg-primary bg-opacity-10 text-primary border-0 mt-1">
                                        SKU: {{ product.sku }}
                                    </div>
                                    {% endif %}
                                    {% if product.variants %}
                                    <div class="badge bg-purple bg-opacity-10 text-purple border-0 mt-1">
                                        {{ product.variants|length }} varian
                                    </div>
                                    {% endif %}
                                </div>
                            </div>
                        </td>

                        <td class="py-3">
                            <span class="badge bg-light text-dark border">
                                {{ product.category.name if product.category else 'Tidak berkategori' }}
                            </span>
                        </td>

                        <td class="py-3">
                            <span class="fw-medium">
                                {% if product.variants %}
                                <span class="text-muted">-</span>
                                {% else %}
                                $ {{ "{:,.2f}".format(product.price) }}
                                {% endif %}
                            </span>
                        </td>

                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                {% if product.variants %}
                                <span class="fw-bold text-muted me-2">-</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                </div>
                                {% else %}
                                <span class="fw-bold text-navy-dark me-2">{{ product.stock or 0 }}</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    {% if product.stock and product.stock > 0 %}
                                        {% if product.stock > 10 %}
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                        {% elif product.stock > 5 %}
                                        <div class="progress-bar bg-success" style="width: 70%"></div>
                                        {% elif product.stock > 3 %}
                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                        {% else %}
                                        <div class="progress-bar bg-danger" style="width: 30%"></div>
                                        {% endif %}
                                    {% else %}
                                        <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                    {% endif %}
                                </div>
                                {% endif %}
                            </div>
                        </td>

                        <td class="pe-4 py-3">
                            {% if product.variants %}
                            <span class="badge bg-purple bg-opacity-10 text-purple border border-purple border-opacity-25 d-inline-flex align-items-center">
                                <span class="rounded-circle bg-purple me-1" style="width: 8px; height: 8px;"></span>
                                Multi Varian
                            </span>
                            {% else %}
                                {% if product.stock %}
                                    {% if product.stock > 10 %}
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span>
                                        Normal
                                    </span>
                                    {% elif product.stock > 5 %}
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span>
                                        Normal
                                    </span>
                                    {% elif product.stock > 3 %}
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-warning me-1" style="width: 8px; height: 8px;"></span>
                                        Stok Rendah
                                    </span>
                                    {% elif product.stock > 0 %}
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-danger me-1" style="width: 8px; height: 8px;"></span>
                                        Kritis
                                    </span>
                                    {% else %}
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-secondary me-1" style="width: 8px; height: 8px;"></span>
                                        Habis Stok
                                    </span>
                                    {% endif %}
                                {% else %}
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-secondary me-1" style="width: 8px; height: 8px;"></span>
                                    Habis Stok
                                </span>
                                {% endif %}
                            {% endif %}
                        </td>
                    </tr>

                    <!-- Baris Varian -->
                    {% for variant in product.variants %}
                    <tr class="hover-bg border-start border-primary border-opacity-25">
                        <td class="ps-5 py-2">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm text-navy-dark">
                                        {{ variant.name }}
                                    </div>
                                    {% if variant.sku %}
                                    <div class="text-xs text-muted mt-1">
                                        SKU: {{ variant.sku }}
                                    </div>
                                    {% endif %}
                                </div>
                            </div>
                        </td>

                        <td class="py-2">
                            <span class="badge bg-light text-muted border">
                                Varian
                            </span>
                        </td>

                        <td class="py-2">
                            <span class="text-sm fw-medium">
                                $ {{ "{:,.2f}".format(variant.price) }}
                            </span>
                        </td>

                        <td class="py-2">
                            <div class="d-flex align-items-center">
                                <span class="fw-medium text-navy-dark me-2">{{ variant.stock or 0 }}</span>
                                <div class="progress flex-grow-1" style="height: 4px;">
                                    {% if variant.stock and variant.stock > 0 %}
                                        {% if variant.stock > 10 %}
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                        {% elif variant.stock > 5 %}
                                        <div class="progress-bar bg-success" style="width: 70%"></div>
                                        {% elif variant.stock > 3 %}
                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                        {% else %}
                                        <div class="progress-bar bg-danger" style="width: 30%"></div>
                                        {% endif %}
                                    {% else %}
                                        <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                    {% endif %}
                                </div>
                            </div>
                        </td>

                        <td class="pe-4 py-2">
                            {% if variant.stock %}
                                {% if variant.stock > 10 %}
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                    Normal
                                </span>
                                {% elif variant.stock > 5 %}
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                    Normal
                                </span>
                                {% elif variant.stock > 3 %}
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-warning me-1" style="width: 6px; height: 6px;"></span>
                                    Stok Rendah
                                </span>
                                {% elif variant.stock > 0 %}
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span>
                                    Kritis
                                </span>
                                {% else %}
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                    Habis Stok
                                </span>
                                {% endif %}
                            {% else %}
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                Habis Stok
                            </span>
                            {% endif %}
                        </td>
                    </tr>
                    {% endfor %}
                    
                    {% endfor %}

                    <!-- Kosong state -->
                    {% if products.total == 0 %}
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                                    <i class="fas fa-box fa-2x text-primary"></i>
                                </div>
                                <h4 class="fw-medium text-navy-dark mb-2">Tidak ada produk ditemukan</h4>
                                <p class="text-muted">
                                    {% if search_query or selected_category_id or stock_status %}
                                    Coba ubah filter pencarian Anda.
                                    {% else %}
                                    Tambahkan produk pertama Anda untuk mulai mengelola inventori.
                                    {% endif %}
                                </p>
                            </div>
                        </td>
                    </tr>
                    {% endif %}
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-md-none">
            <div class="list-group list-group-flush">
                {% for product in products.items %}
                <!-- Product Card -->
                <div class="list-group-item border-0">
                    <!-- Product Header -->
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle {% if product.variants %}bg-purple bg-opacity-10 border border-purple border-opacity-25{% else %}bg-primary bg-opacity-10 border border-primary border-opacity-25{% endif %} d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="fas fa-box {% if product.variants %}text-purple{% else %}text-primary{% endif %}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold text-navy-dark mb-1">{{ product.name }}</h5>
                                {% if product.sku %}
                                <div class="badge bg-primary bg-opacity-10 text-primary border-0">
                                    SKU: {{ product.sku }}
                                </div>
                                {% endif %}
                                {% if product.variants %}
                                <div class="badge bg-purple bg-opacity-10 text-purple border-0">
                                    {{ product.variants|length }} varian
                                </div>
                                {% endif %}
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            {% if product.variants %}
                            <span class="badge bg-purple bg-opacity-10 text-purple border border-purple border-opacity-25 d-inline-flex align-items-center">
                                <span class="rounded-circle bg-purple me-1" style="width: 6px; height: 6px;"></span>
                                Varian
                            </span>
                            {% else %}
                                {% if product.stock %}
                                    {% if product.stock > 10 %}
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                        Normal
                                    </span>
                                    {% elif product.stock > 5 %}
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                        Normal
                                    </span>
                                    {% elif product.stock > 3 %}
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-warning me-1" style="width: 6px; height: 6px;"></span>
                                        Stok Rendah
                                    </span>
                                    {% elif product.stock > 0 %}
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span>
                                        Kritis
                                    </span>
                                    {% else %}
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                        <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                        Habis Stok
                                    </span>
                                    {% endif %}
                                {% else %}
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                    <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                    Habis Stok
                                </span>
                                {% endif %}
                            {% endif %}
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="text-muted small mb-1">Kategori</div>
                            <div class="fw-medium text-navy-dark">
                                {{ product.category.name if product.category else '-' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small mb-1">Harga</div>
                            <div class="fw-bold text-navy-dark">
                                {% if product.variants %}
                                <span class="text-muted">-</span>
                                {% else %}
                                $ {{ "{:,.2f}".format(product.price) }}
                                {% endif %}
                            </div>
                        </div>
                    </div>

                    <!-- Stock Info -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="text-muted small">Stok Tersedia</div>
                            <div class="fw-bold text-navy-dark">
                                {% if product.variants %}
                                <span class="text-muted">-</span>
                                {% else %}
                                {{ product.stock or 0 }} unit
                                {% endif %}
                            </div>
                        </div>
                        <div class="progress" style="height: 6px;">
                            {% if product.variants %}
                            <div class="progress-bar bg-secondary" style="width: 100%"></div>
                            {% else %}
                                {% if product.stock and product.stock > 0 %}
                                    {% if product.stock > 10 %}
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                    {% elif product.stock > 5 %}
                                    <div class="progress-bar bg-success" style="width: 70%"></div>
                                    {% elif product.stock > 3 %}
                                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                                    {% else %}
                                    <div class="progress-bar bg-danger" style="width: 30%"></div>
                                    {% endif %}
                                {% else %}
                                    <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                {% endif %}
                            {% endif %}
                        </div>
                    </div>

                    <!-- Varian Toggle -->
                    {% if product.variants|length > 0 %}
                    <div class="pt-3 border-top">
                        <button onclick="toggleVariants({{ product.id }})" 
                                class="w-100 btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center">
                            <span>Tampilkan Varian ({{ product.variants|length }})</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                    </div>
                    {% endif %}

                    <!-- Variants Section -->
                    {% if product.variants|length > 0 %}
                    <div id="variants-{{ product.id }}" class="collapse mt-3">
                        <div class="card bg-light border-0">
                            <div class="card-body p-3">
                                {% for variant in product.variants %}
                                <div class="border-bottom pb-3 mb-3 {% if not loop.last %}border-bottom{% endif %}">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="fw-medium text-navy-dark">{{ variant.name }}</div>
                                        <div>
                                            {% if variant.stock %}
                                                {% if variant.stock > 10 %}
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                                    <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                                    Normal
                                                </span>
                                                {% elif variant.stock > 5 %}
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 d-inline-flex align-items-center">
                                                    <span class="rounded-circle bg-success me-1" style="width: 6px; height: 6px;"></span>
                                                    Normal
                                                </span>
                                                {% elif variant.stock > 3 %}
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 d-inline-flex align-items-center">
                                                    <span class="rounded-circle bg-warning me-1" style="width: 6px; height: 6px;"></span>
                                                    Stok Rendah
                                                </span>
                                                {% elif variant.stock > 0 %}
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 d-inline-flex align-items-center">
                                                    <span class="rounded-circle bg-danger me-1" style="width: 6px; height: 6px;"></span>
                                                    Kritis
                                                </span>
                                                {% else %}
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                                    <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                                    Habis Stok
                                                </span>
                                                {% endif %}
                                            {% else %}
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 d-inline-flex align-items-center">
                                                <span class="rounded-circle bg-secondary me-1" style="width: 6px; height: 6px;"></span>
                                                Habis Stok
                                            </span>
                                            {% endif %}
                                        </div>
                                    </div>
                                    
                                    <div class="row g-2 small">
                                        <div class="col-6">
                                            <div class="text-muted">Harga</div>
                                            <div class="fw-medium">$ {{ "{:,.2f}".format(variant.price) }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted">Stok</div>
                                            <div class="fw-medium">{{ variant.stock or 0 }} unit</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <div class="progress" style="height: 4px;">
                                            {% if variant.stock and variant.stock > 0 %}
                                                {% if variant.stock > 10 %}
                                                <div class="progress-bar bg-success" style="width: 100%"></div>
                                                {% elif variant.stock > 5 %}
                                                <div class="progress-bar bg-success" style="width: 70%"></div>
                                                {% elif variant.stock > 3 %}
                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                {% else %}
                                                <div class="progress-bar bg-danger" style="width: 30%"></div>
                                                {% endif %}
                                            {% else %}
                                                <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                            {% endif %}
                                        </div>
                                    </div>
                                    
                                    {% if variant.sku %}
                                    <div class="mt-2 text-muted small">
                                        SKU: {{ variant.sku }}
                                    </div>
                                    {% endif %}
                                </div>
                                {% endfor %}
                            </div>
                        </div>
                    </div>
                    {% endif %}
                </div>
                {% endfor %}

                <!-- Empty State Mobile -->
                {% if products.total == 0 %}
                <div class="list-group-item border-0 py-5">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                            <i class="fas fa-box fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-medium text-navy-dark mb-2">Tidak ada produk ditemukan</h4>
                        <p class="text-muted text-center">
                            {% if search_query or selected_category_id or stock_status %}
                            Coba ubah filter pencarian Anda.
                            {% else %}
                            Tambahkan produk pertama Anda untuk mulai mengelola inventori.
                            {% endif %}
                        </p>
                    </div>
                </div>
                {% endif %}
            </div>
        </div>

        <!-- Pagination -->
        {% if products.pages > 1 %}
        <div class="card-footer bg-white border-top">
            <!-- Mobile Pagination -->
            <div class="d-md-none">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="text-muted small">
                        Menampilkan {{ ((products.page - 1) * products.per_page) + 1 }} sampai 
                        {{ min(products.page * products.per_page, products.total) }} dari {{ products.total }} produk
                    </div>
                </div>
                
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <button 
                        onclick="goToPage({{ products.prev_num }})"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center flex-grow-1"
                        {% if not products.has_prev %}disabled{% endif %}
                    >
                        <i class="fas fa-chevron-left me-1"></i>
                        Sebelumnya
                    </button>
                    
                    <div class="fw-medium text-navy-dark px-3">
                        {{ products.page }}/{{ products.pages }}
                    </div>
                    
                    <button 
                        onclick="goToPage({{ products.next_num }})"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-center flex-grow-1"
                        {% if not products.has_next %}disabled{% endif %}
                    >
                        Selanjutnya
                        <i class="fas fa-chevron-right ms-1"></i>
                    </button>
                </div>
            </div>
            
            <!-- Desktop Pagination -->
            <div class="d-none d-md-block">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div class="text-muted">
                        Menampilkan 
                        <span class="fw-medium">{{ ((products.page - 1) * products.per_page) + 1 }}</span>
                        sampai 
                        <span class="fw-medium">{{ min(products.page * products.per_page, products.total) }}</span>
                        dari 
                        <span class="fw-medium">{{ products.total }}</span>
                        produk
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <!-- Previous Button -->
                        <button 
                            onclick="goToPage({{ products.prev_num }})"
                            class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                            {% if not products.has_prev %}disabled{% endif %}
                        >
                            <i class="fas fa-chevron-left me-1"></i>
                            Sebelumnya
                        </button>
                        
                        <!-- Page Numbers -->
                        <div class="d-flex align-items-center gap-1">
                            {% if products.page > 3 %}
                            <button 
                                onclick="goToPage(1)"
                                class="btn btn-outline-secondary btn-sm"
                            >
                                1
                            </button>
                            {% if products.page > 4 %}
                            <span class="text-muted px-2">...</span>
                            {% endif %}
                            {% endif %}
                            
                            {% for page_num in products.iter_pages(left_edge=1, right_edge=1, left_current=2, right_current=2) %}
                                {% if page_num %}
                                    {% if page_num == products.page %}
                                    <button class="btn btn-primary btn-sm">
                                        {{ page_num }}
                                    </button>
                                    {% else %}
                                    <button 
                                        onclick="goToPage({{ page_num }})"
                                        class="btn btn-outline-secondary btn-sm"
                                    >
                                        {{ page_num }}
                                    </button>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                        </div>
                        
                        <!-- Next Button -->
                        <button 
                            onclick="goToPage({{ products.next_num }})"
                            class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                            {% if not products.has_next %}disabled{% endif %}
                        >
                            Selanjutnya
                            <i class="fas fa-chevron-right ms-1"></i>
                        </button>
                    </div>
                    
                    <!-- Page Size Info -->
                    <div class="text-muted small">
                        <select 
                            id="perPageSelect" 
                            class="form-select form-select-sm"
                            onchange="changePerPage(this.value)"
                            style="width: auto;"
                        >
                            <option value="10" {% if per_page == 10 %}selected{% endif %}>10 per halaman</option>
                            <option value="25" {% if per_page == 25 %}selected{% endif %}>25 per halaman</option>
                            <option value="50" {% if per_page == 50 %}selected{% endif %}>50 per halaman</option>
                            <option value="100" {% if per_page == 100 %}selected{% endif %}>100 per halaman</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {% endif %}
    </div>

    <!-- Footer info -->
    <div class="mt-4 mx-4">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-muted small">
            <div class="mb-3 mb-md-0">
                <div class="d-flex flex-wrap gap-3">
                    <span class="d-inline-flex align-items-center">
                        <span class="rounded-circle bg-success me-2" style="width: 8px; height: 8px;"></span>
                        <span>Normal</span>
                    </span>
                    <span class="d-inline-flex align-items-center">
                        <span class="rounded-circle bg-warning me-2" style="width: 8px; height: 8px;"></span>
                        <span>Stok Rendah</span>
                    </span>
                    <span class="d-inline-flex align-items-center">
                        <span class="rounded-circle bg-danger me-2" style="width: 8px; height: 8px;"></span>
                        <span>Kritis</span>
                    </span>
                    <span class="d-inline-flex align-items-center">
                        <span class="rounded-circle bg-secondary me-2" style="width: 8px; height: 8px;"></span>
                        <span>Habis Stok</span>
                    </span>
                    <span class="d-inline-flex align-items-center">
                        <span class="rounded-circle bg-purple me-2" style="width: 8px; height: 8px;"></span>
                        <span>Multi Varian</span>
                    </span>
                </div>
            </div>
            <div>
                Data diperbarui secara real-time
            </div>
        </div>
    </div>
</div>

<script>
function goToPage(page) {
    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    window.location.href = url.toString();
}

function changePerPage(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

// Search functionality
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        const url = new URL(window.location.href);
        url.searchParams.set('search', this.value);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
});

// Desktop filter functionality
const desktopCategoryFilter = document.getElementById('categoryFilter');
const desktopStockFilter = document.getElementById('stockFilter');

if (desktopCategoryFilter) {
    desktopCategoryFilter.addEventListener('change', function() {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('category', this.value);
        } else {
            url.searchParams.delete('category');
        }
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });
}

if (desktopStockFilter) {
    desktopStockFilter.addEventListener('change', function() {
        const url = new URL(window.location.href);
        if (this.value) {
            url.searchParams.set('stock_status', this.value);
        } else {
            url.searchParams.delete('stock_status');
        }
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });
}

// Mobile variant toggle
function toggleVariants(productId) {
    const variantsSection = document.getElementById(`variants-${productId}`);
    if (variantsSection) {
        const collapse = new bootstrap.Collapse(variantsSection, {
            toggle: true
        });
    }
}
</script>

<style>
/* Custom styles */
.hover-bg:hover {
    background-color: rgba(15, 26, 47, 0.03) !important;
}

.bg-purple {
    background-color: var(--purple) !important;
}

.text-purple {
    color: var(--purple) !important;
}

.border-purple {
    border-color: var(--purple) !important;
}

/* Custom color variable for purple */
:root {
    --purple: #3a82edff;
}

.bg-gradient-to-r {
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
}

.from-blue-50 {
    --tw-gradient-from: #eff6ff;
}

.to-white {
    --tw-gradient-to: #ffffff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .mx-4 {
        margin-left: 1rem;
        margin-right: 1rem;
    }
}
</style>
@endsection