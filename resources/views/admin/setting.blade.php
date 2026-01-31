@extends('admin.layout')

@section('title', 'System Settings - Admin')
@section('page_title', 'System Settings')

@section('styles')
<style>
.settings-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}
.settings-section:last-child { border-bottom: none; }
.settings-card { transition: transform 0.3s; }
.settings-card:hover { transform: translateY(-5px); }

.color-picker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #dee2e6;
    cursor: pointer;
    display: inline-block;
    margin-right: 10px;
}
.color-picker.active {
    border-color: #007bff;
    transform: scale(1.1);
}
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="card settings-card mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="bi bi-menu-button"></i> Settings Navigation</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="bi bi-gear"></i> General Settings
                </a>
                <a href="#store" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-shop"></i> Store Settings
                </a>
                <a href="#receipt" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-printer"></i> Receipt Settings
                </a>
                <a href="#tax" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-percent"></i> Tax & Discount
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-shield-lock"></i> Security
                </a>
                <a href="#backup" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-database"></i> Backup & Restore
                </a>
                <a href="#integrations" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-plug"></i> Integrations
                </a>
                <a href="#advanced" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="bi bi-tools"></i> Advanced
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="tab-content">

            {{-- GENERAL --}}
            <div class="tab-pane fade show active" id="general">
                <div class="card settings-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-gear"></i> General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Application Name</label>
                                    <input type="text" class="form-control" value="Bisnis Clothing POS">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Version</label>
                                    <input type="text" class="form-control" value="2.1.0" readonly>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save General Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- STORE --}}
            <div class="tab-pane fade" id="store">
                <div class="card settings-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-shop"></i> Store Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Store Name</label>
                                <input type="text" class="form-control" value="Bisnis Clothing Store">
                            </div>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Store Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RECEIPT --}}
            <div class="tab-pane fade" id="receipt">
                <div class="card settings-card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-printer"></i> Receipt Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-save"></i> Save Receipt Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TAX --}}
            <div class="tab-pane fade" id="tax">
                <div class="card settings-card">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="bi bi-percent"></i> Tax & Discount</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-warning">
                            <i class="bi bi-save"></i> Save Tax Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- SECURITY --}}
            <div class="tab-pane fade" id="security">
                <div class="card settings-card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Security</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-danger">
                            <i class="bi bi-save"></i> Save Security Settings
                        </button>
                    </div>
                </div>
            </div>

            {{-- ADVANCED --}}
            <div class="tab-pane fade" id="advanced">
                <div class="card settings-card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-tools"></i> Advanced</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-dark">
                            <i class="bi bi-save"></i> Save Advanced Settings
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('.list-group-item').click(function () {
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');
    });

    $('.color-picker').click(function () {
        $('.color-picker').removeClass('active');
        $(this).addClass('active');
        console.log('Selected color:', $(this).data('color'));
    });

    $('form').on('submit', function (e) {
        e.preventDefault();
        alert('Settings saved successfully!');
    });
});
</script>
@endsection
