<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BONUS CLOTHING')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Montserrat:wght@600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-dark:#0F1A2F;--navy-deep:#0d1529;--royal-blue:#1D4ED8;
            --light-blue:#60A5FA;--blue-gradient:linear-gradient(135deg,#0F1A2F 0%,#1D4ED8 50%,#60A5FA 100%);
            --gold-accent:#EAB308;--white-pure:#FFFFFF;--white-off:#F8FAFC;
            --dark-text:#0F172A;--muted-text:#334155;--border-light:#CBD5E1;
            --shadow-soft:0 4px 20px rgba(15,26,47,.08);
            --shadow-deep:0 15px 50px rgba(15,26,47,.2);
        }

        *{margin:0;padding:0;box-sizing:border-box}

        body{
            font-family:'Inter',sans-serif;
            background:var(--navy-dark);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            color:var(--dark-text);
        }

        body::before{
            content:'';
            position:absolute;inset:0;
            background:
                radial-gradient(circle at 20% 30%,rgba(29,78,216,.03) 0%,transparent 50%),
                radial-gradient(circle at 80% 70%,rgba(96,165,250,.03) 0%,transparent 50%);
            z-index:0;
        }

        .auth-container{width:100%;max-width:420px;z-index:10}
        .auth-card{
            background:var(--white-pure);
            border-radius:24px;
            box-shadow:var(--shadow-deep);
            overflow:hidden;
            position:relative;
        }

        .auth-card::before{
            content:'';
            position:absolute;top:0;left:0;right:0;height:4px;
            background:var(--blue-gradient);
        }

        .auth-header{
            padding:40px 40px 30px;
            text-align:center;
            border-bottom:1px solid var(--border-light);
        }

        .logo-container{
            width:120px;height:120px;
            margin:0 auto 25px;
            display:flex;align-items:center;justify-content:center;
        }

        .logo-image{
            width:210%;height:210%;
            object-fit:contain;padding:15px;
        }

        .logo-placeholder{
            font-size:48px;
            font-weight:800;
            font-family:'Montserrat',sans-serif;
            background:var(--blue-gradient);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .auth-body{padding:40px}

        .auth-footer{
            text-align:center;
            margin-top:32px;
            padding-top:32px;
            border-top:1px solid var(--border-light);
            color:var(--muted-text);
            font-size:.875rem;
        }

        .alert{
            border-radius:14px;
            padding:18px 20px;
            margin-bottom:24px;
            font-size:.9rem;
            box-shadow:var(--shadow-soft);
        }

        .alert-danger{background:#FEE2E2;color:#7F1D1D;border-left:4px solid #DC2626}
        .alert-success{background:#DCFCE7;color:#14532D;border-left:4px solid #16A34A}
        .alert-warning{background:#FEF3C7;color:#92400E;border-left:4px solid #F59E0B}

        @media(max-width:576px){
            .auth-body{padding:32px 24px}
            .auth-header{padding:32px 24px}
            .logo-container{width:100px;height:100px}
        }
    </style>

    @yield('extra_css')
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        {{-- HEADER --}}
        @section('auth_header')
        <div class="auth-header">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Bonus Clothing Logo"
                     class="logo-image"
                     onerror="this.style.display='none';this.parentElement.innerHTML='<div class=\'logo-placeholder\'>BC</div>';">
            </div>
        </div>
        @show

        {{-- BODY --}}
        <div class="auth-body">
            @yield('auth_content')
        </div>

        {{-- FOOTER --}}
        @section('auth_footer')
        <div class="auth-footer">
            @yield('footer_content')
        </div>
        @show

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@yield('extra_js')

</body>
</html>
