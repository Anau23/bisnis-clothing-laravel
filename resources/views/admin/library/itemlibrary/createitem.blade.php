@extends('admin.layout')

@section('title', 'Create Item - BONUS CLOTHING')
@section('page_title', 'Create Item')
@section('page_subtitle', 'Add new product to your library')

@section('content')
<div class="container-fluid">
    <form id="createItemForm" method="POST" enctype="multipart/form-data"
          action="{{ route('admin.items.store') }}">
        @csrf

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">

                <!-- GENERAL INFORMATION -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-4">
                        <h6 class="mb-0 fw-bold text-primary">GENERAL INFORMATION</h6>
                        <p class="text-muted mb-0 mt-1" style="font-size: 0.875rem;">
                            Basic product details and description
                        </p>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <!-- IMAGE -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark mb-3">Product Image</label>

                                <div class="image-upload-container border-2 border-dashed rounded-lg p-4 text-center bg-blue-50 position-relative"
                                     onclick="document.getElementById('productImage').click()"
                                     style="cursor:pointer;">
                                    <div class="image-preview mb-3" id="imagePreview">
                                        <div class="placeholder-image bg-white rounded-lg d-flex flex-column align-items-center justify-content-center"
                                             style="height:140px;width:140px;margin:0 auto;border:2px dashed #cbd5e0;">
                                            <i class="fas fa-camera text-blue-400 mb-2" style="font-size:2rem;"></i>
                                            <small class="text-gray-500">Click to upload</small>
                                            <small class="text-gray-400 mt-1" style="font-size:0.75rem;">Max 5MB</small>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-outline-primary btn-sm px-4">
                                        <i class="fas fa-cloud-upload-alt me-2"></i> Upload Image
                                    </button>
                                </div>

                                <input type="file" class="d-none" id="productImage"
                                       name="product_image" accept="image/*">
                            </div>

                            <!-- PRODUCT INFO -->
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        Product Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           name="product_name"
                                           placeholder="Write product name..."
                                           required>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-2">Category</label>
                                        <select class="form-select" name="category">
                                            <option value="" selected>Uncategorized</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->name }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-2">Brand</label>
                                        <input type="text" class="form-control"
                                               name="brand"
                                               placeholder="Contoh: Nike, Adidas, H&M">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark mb-2">Description</label>
                                    <textarea class="form-control" name="description" rows="4"
                                              placeholder="Write a detailed product description..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VARIANTS -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-4 d-flex justify-content-between">
                        <div>
                            <h6 class="fw-bold text-primary mb-0">PRODUCT VARIANTS</h6>
                            <p class="text-muted mt-1 mb-0" style="font-size:0.875rem;">
                                Add different sizes, colors, or options
                            </p>
                        </div>
                        <button type="button" class="btn btn-primary px-4"
                                data-bs-toggle="modal"
                                data-bs-target="#addVariantModal">
                            <i class="fas fa-plus-circle me-2"></i> Add Variant
                        </button>
                    </div>

                    <div class="card-body">
                        <div id="variantsContainer">
                            <div class="text-center py-5" id="noVariantsMessage">
                                <i class="fas fa-box-open text-blue-300 mb-3" style="font-size:3rem;"></i>
                                <h5 class="text-gray-500 mb-2">No Variants Added</h5>
                                <p class="text-muted mb-4" style="max-width:400px;margin:auto;">
                                    Create variants to manage different sizes, colors, or options
                                </p>
                                <button type="button" class="btn btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addVariantModal">
                                    <i class="fas fa-plus me-2"></i> Add First Variant
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-4">
                <!-- Inventory + Actions -->
                {{-- ISI TETAP, TIDAK DIUBAH --}}
            </div>
        </div>
    </form>
</div>

@include('admin.library.itemlibrary._variant_modal')
@endsection
