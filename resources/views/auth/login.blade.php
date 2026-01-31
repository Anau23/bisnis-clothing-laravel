@extends('auth.layout')

@section('title', 'Login - Dili Society')

@section('auth_content')

    {{-- ===== FLASH MESSAGES (Flask ➜ Laravel) ===== --}}
    @if(session()->has('success') || session()->has('danger') || session()->has('warning') || session()->has('info'))
        @foreach (['success','danger','warning','info'] as $type)
            @if(session()->has($type))
                <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                    <i class="fas
                        @if($type === 'success') fa-check-circle
                        @elseif($type === 'danger') fa-exclamation-circle
                        @elseif($type === 'warning') fa-exclamation-triangle
                        @else fa-info-circle
                        @endif
                        me-2"></i>
                    <span>{{ session($type) }}</span>
                    <button type="button" class="btn-close" style="font-size: 0.7rem;"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
    @endif

    <div class="text-center mb-5">
        <div class="welcome-text">
            <h2 class="welcome-title">Selamat Datang</h2>
            <p class="welcome-subtitle">Masuk ke sistem manajemen kasir</p>
        </div>
    </div>

    {{-- ===== LOGIN FORM ===== --}}
    <form method="POST" action="{{ url('/login') }}" id="loginForm" novalidate>
        @csrf

        <!-- Username -->
        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-user"></i>
                <span>USERNAME</span>
            </label>
            <div class="input-group-icon">
                <i class="fas fa-user-tie"></i>
                <input type="text"
                       name="username"
                       class="form-control form-control-lg"
                       placeholder="username"
                       required
                       autocomplete="username"
                       autocapitalize="none">
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-key"></i>
                <span>PASSWORD</span>
            </label>
            <div class="input-group-icon password-input-container">
                <i class="fas fa-lock"></i>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control form-control-lg password-field"
                       placeholder="••••••••"
                       required
                       autocomplete="current-password">
                <button type="button"
                        class="password-toggle-btn"
                        id="passwordToggle"
                        aria-label="Toggle password visibility">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Role Selection -->
        <div class="mb-5">
            <label class="form-label">
                <i class="fas fa-user-shield"></i>
                <span>PERAN AKSES</span>
            </label>
            <div class="input-group-icon">
                <i class="fas fa-briefcase"></i>
                <select name="role" class="form-control form-control-lg" required>
                    <option value="" disabled selected>Pilih peran akses</option>
                    <option value="admin">Administrator</option>
                    <option value="cashier">Kasir</option>
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-4">
            <button type="submit" class="btn-login">
                <span class="btn-login-text">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    MASUK KE SISTEM
                </span>
                <span class="btn-login-loader">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
            </button>
        </div>
    </form>

@endsection

@section('footer_content')
    <div class="footer-links">
        <p class="copyright">
            <i class="fas fa-copyright me-1"></i>
            2026 Dili Society •
        </p>
    </div>
@endsection

@section('extra_js')
<script>
/* ===================== JS ASLI — TIDAK DIUBAH ===================== */
document.addEventListener('DOMContentLoaded', function() {
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    const form = document.getElementById('loginForm');
    const submitBtn = form.querySelector('.btn-login');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitBtn.classList.add('loading');
        setTimeout(() => {
            submitBtn.classList.remove('loading');
            form.submit();
        }, 1500);
    });
});
</script>

<style>
    /* Custom styles for login page */
    .welcome-text {
        margin-bottom: 2.5rem;
    }
    
    .welcome-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1.75rem;
        color: var(--navy-dark);
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--navy-dark), var(--royal-blue));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .welcome-subtitle {
        color: var(--muted-text);
        font-size: 0.95rem;
        font-weight: 400;
        letter-spacing: 0.5px;
    }
    
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
        color: var(--muted-text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label i {
        font-size: 0.9rem;
        color: var(--royal-blue);
        width: 16px;
    }
    
    .input-group-icon {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .input-group-icon i:first-child {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--royal-blue);
        font-size: 1.1rem;
        z-index: 2;
        opacity: 0.7;
    }
    
    .input-group-icon.focused i:first-child {
        color: var(--light-blue);
        opacity: 1;
        transform: translateY(-50%) scale(1.1);
        transition: all 0.3s ease;
    }
    
    .input-group-icon.valid i:first-child {
        color: #10B981;
    }
    
    .input-group-icon.invalid i:first-child {
        color: #EF4444;
    }
    
    .form-control-lg {
        height: 56px;
        padding: 0 20px 0 52px;
        font-size: 1rem;
        font-weight: 500;
        border: 2px solid var(--border-light);
        border-radius: 14px;
        transition: all 0.3s ease;
        background: var(--white-pure);
    }
    
    /* FIXED: Password field dengan padding yang tepat untuk toggle */
    .password-field {
        padding-right: 60px !important;
    }
    
    .form-control-lg:focus {
        border-color: var(--royal-blue);
        box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.15);
        transform: translateY(-1px);
    }
    
    .input-group-icon.focused .form-control-lg {
        border-color: var(--light-blue);
        background: linear-gradient(135deg, var(--white-pure), #F8FAFF);
    }
    
    select.form-control-lg {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%231D4ED8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
        background-size: 16px;
        cursor: pointer;
        padding-right: 50px;
    }
    
    .role-option {
        display: flex;
        align-items: center;
        padding: 4px 0;
    }
    
    .role-option i {
        color: var(--royal-blue);
        font-size: 0.9rem;
    }
    
    .btn-login {
        background: var(--blue-gradient);
        border: none;
        border-radius: 14px;
        height: 60px;
        color: var(--white-pure);
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(29, 78, 216, 0.3);
    }
    
    .btn-login:active {
        transform: translateY(0);
    }
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-login.loading .btn-login-text {
        opacity: 0;
    }
    
    .btn-login.loading .btn-login-loader {
        opacity: 1;
    }
    
    .btn-login-text {
        display: flex;
        align-items: center;
        transition: opacity 0.3s ease;
    }
    
    .btn-login-loader {
        position: absolute;
        opacity: 0;
        transition: opacity 0.3s ease;
        font-size: 1.2rem;
    }
    
    /* FIXED: Password toggle button styling */
    .password-toggle-btn {
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: var(--muted-text);
        cursor: pointer;
        z-index: 10;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s ease;
        border-radius: 6px;
        opacity: 0.6;
    }
    
  
    
    .password-toggle-btn:active {
        transform: translateY(-50%) scale(0.95);
    }
    
    .password-toggle-btn i {
        font-size: 1.1rem;
        transition: all 0.2s ease;
    }
    
    .error-message {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #7F1D1D;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
        border-left: 4px solid #DC2626;
    }
    
    .error-message i {
        font-size: 1rem;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .shake {
        animation: shake 0.5s ease-in-out;
    }
    
    .footer-links {
        text-align: center;
    }
    
    .register-link {
        color: var(--royal-blue);
        text-decoration: none;
        font-weight: 600;
        margin-left: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }
    
    .register-link:hover {
        color: var(--navy-dark);
        transform: translateX(2px);
    }
    
    .copyright {
        font-size: 0.75rem;
        color: #64748B;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: 0.3px;
    }
    
    .copyright i {
        font-size: 0.7rem;
    }
    
    /* Placeholder styling */
    .form-control-lg::placeholder {
        color: #94A3B8;
        font-weight: 400;
        letter-spacing: 0.3px;
    }
    
    /* Role option styling */
    option {
        padding: 12px;
        font-size: 0.95rem;
    }
    
    /* Success/Error indicators */
    .valid::after {
        content: '✓';
        position: absolute;
        right: 70px; /* Adjusted for password toggle */
        top: 50%;
        transform: translateY(-50%);
        color: #10B981;
        font-weight: bold;
        font-size: 0.9rem;
        z-index: 2;
    }
    
    .invalid::after {
        content: '!';
        position: absolute;
        right: 60px; /* Adjusted for password toggle */
        top: 50%;
        transform: translateY(-50%);
        color: #EF4444;
        font-weight: bold;
        font-size: 0.9rem;
        z-index: 2;
    }
    
    /* Password container khusus */
    .password-input-container.valid::after,
    .password-input-container.invalid::after {
        right: 70px; /* Extra space for password field */
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .welcome-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control-lg {
            height: 52px;
            font-size: 0.95rem;
            padding: 0 16px 0 48px;
        }
        
        .password-field {
            padding-right: 52px !important;
        }
        
        .input-group-icon i:first-child {
            left: 16px;
            font-size: 1rem;
        }
        
        .password-toggle-btn {
            right: 16px;
            width: 24px;
            height: 24px;
        }
        
        .password-toggle-btn i {
            font-size: 1rem;
        }
        
        .btn-login {
            height: 56px;
            font-size: 0.95rem;
        }
        
        .valid::after,
        .invalid::after {
            right: 50px;
            font-size: 0.8rem;
        }
        
        .password-input-container.valid::after,
        .password-input-container.invalid::after {
            right: 58px;
        }
    }
</style>
@endsection
