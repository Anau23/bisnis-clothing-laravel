@extends('admin.layout')

@section('title', 'Categories - BONUS CLOTHING')
@section('page_title', 'Categories')
@section('page_subtitle', 'Manage product categories')

@section('content')
<div class="container-fluid px-3 px-md-4 px-lg-5">

    {{-- HEADER --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                <div>
                    <h1 class="page-title-main text-primary mb-2">Categories Management</h1>
                    <p class="page-subtitle-main text-gray-600">Organize your products with custom categories</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="search-container position-relative d-none d-md-block">
                        <i class="fas fa-search search-icon text-muted"></i>
                        <input type="text" class="form-control search-input ps-5" id="searchCategory" placeholder="Search categories...">
                    </div>
                    <button class="btn btn-outline-primary d-md-none" id="searchToggleBtn">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                        <i class="fas fa-plus-circle me-2"></i> Add Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-container me-3">
                        <i class="fas fa-tags text-primary"></i>
                    </div>
                    <div>
                        <div class="stat-value" id="totalCategories">{{ $categories->total() }}</div>
                        <div class="stat-label">Total Categories</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-container me-3">
                        <i class="fas fa-box text-success"></i>
                    </div>
                    <div>
                        <div class="stat-value text-success" id="totalProducts">{{ $total_products }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-container me-3">
                        <i class="fas fa-question-circle text-warning"></i>
                    </div>
                    <div>
                        <div class="stat-value text-warning" id="uncategorized">{{ $uncategorized_count }}</div>
                        <div class="stat-label">Uncategorized</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="categoriesTable">
                    <thead>
                        <tr>
                            <th class="ps-4">CATEGORY NAME</th>
                            <th>PRODUCT COUNT</th>
                            <th class="pe-4 text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">

                        @forelse($categories as $category)
                            @php
                                $productCount = $category->products_count ?? 0;
                            @endphp

                            <tr class="category-row" data-category-id="{{ $category->id }}">
                                <td class="ps-4">
                                    <h6 class="fw-bold">{{ $category->name }}</h6>
                                    <small class="text-muted">
                                        {{ $category->description ?: 'No description' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $productCount }} items
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-info" onclick="viewCategoryDetails({{ $category->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" onclick="editCategory({{ $category->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <h5>No Categories Found</h5>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="card-footer bg-white border-0 py-4">
                {{ $categories->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>
{{-- Modal belum dibuat (Flask tidak punya) --}}
{{-- @include('admin.library.categories.partials.modals') --}}


@endsection
