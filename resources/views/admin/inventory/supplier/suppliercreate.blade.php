@extends('admin.layout')

@section('title', 'Add Supplier')
@section('page_title', 'Add Supplier')

@section('breadcrumb')
    <a href="{{ route('admin.inventory.supplier') }}">Supplier</a> / Create
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-truck"></i> New Supplier
                </h5>
            </div>

            <form method="POST" action="{{ route('admin.inventory.supplier.store') }}">
                @csrf

                <div class="card-body">
                    <!-- Supplier Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            Supplier Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="e.g. PT Sumber Jaya Abadi"
                               required>
                    </div>

                    <!-- Phone & Email -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="supplier@email.com">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Supplier address..."></textarea>
                    </div>

                    <!-- Note -->
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea name="note"
                                  rows="2"
                                  class="form-control"
                                  placeholder="Optional note..."></textarea>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.inventory.supplier.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
