@extends('admin.layout')

@section('title', 'User Management - Admin')
@section('page_title', 'User Management')

@section('styles')
<style>
:root {
    --primary-blue: #2563eb;
    --primary-light: #eff6ff;
    --border-soft: #e5e7eb;
    --text-dark: #1f2937;
}

.table thead {
    background: var(--primary-light);
}

.table thead th {
    color: var(--primary-blue);
    font-weight: 600;
    border-bottom: 1px solid var(--border-soft);
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

.badge-admin {
    background: #fee2e2;
    color: #991b1b;
}

.badge-cashier {
    background: #dcfce7;
    color: #166534;
}

.modal-header {
    background: var(--primary-light);
    border-bottom: none;
}

.modal-title {
    color: var(--primary-blue);
    font-weight: 600;
}

.form-control:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.15);
}
</style>
@endsection

@section('content')

<div class="mb-4">
    <p class="text-muted">Kelola akun kasir – hanya untuk administrator</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-semibold text-dark">Daftar User</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="fas fa-user-plus me-2"></i>Tambah Kasir
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <strong>{{ $user->username }}</strong>
                            @if ($user->id === auth()->id())
                                <span class="badge bg-info ms-2">Anda</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->role === 'admin')
                                <span class="badge badge-admin">Administrator</span>
                            @else
                                <span class="badge badge-cashier">Kasir</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Non-aktif</span>
                            @endif
                        </td>
                        <td>
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        onclick="editUser({{ $user->id }}, '{{ $user->username }}')">
                                    <i class="fas fa-edit"></i>
                                </button>

                                @if ($user->role !== 'admin' && $user->id !== auth()->id())
                                    <button class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal"
                                            onclick="deleteUser({{ $user->id }}, '{{ $user->username }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CREATE USER -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kasir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="confirm_password" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT USER -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editUserForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="editUsername" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="new_password" minlength="6">
                        <small class="text-muted">Kosongkan jika tidak diubah</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE USER -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus user <strong id="deleteUsername"></strong>?
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
function editUser(id, username) {
    document.getElementById('editUsername').value = username;
    document.getElementById('editUserForm').action = `/admin/users/${id}/update`;
}

function deleteUser(id, username) {
    document.getElementById('deleteUsername').textContent = username;
    document.getElementById('confirmDeleteBtn').onclick = () => {
        const f = document.createElement('form');
        f.method = 'POST';
        f.action = `/admin/users/${id}/delete`;
        f.innerHTML = '@csrf';
        document.body.appendChild(f);
        f.submit();
    };
}
</script>

@endsection
