<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin:0;
            font-family:'Inter', sans-serif;
            background:#e0f0ff;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        body.dashboard-mode {
            display:block !important;
        }

        .card {
            background:#fff;
            padding:40px;
            border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
            width:400px;
            max-width:90%;
            text-align:center;
            position:relative;
        }

        .logo {
            width:120px;
            margin-bottom:5px;
        }

        .subtext {
            font-size:14px;
            color:#555;
            margin-bottom:20px;
        }

        .alert-error {
            background: #ffe5e5;
            color: #d8000c;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: left;
        }

        .input-error {
            color: #d8000c;
            font-size: 13px;
            margin-top: -5px;
            margin-bottom: 8px;
            text-align: left;
        }

        input, select {
            width:100%;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:16px;
            box-sizing:border-box;
        }

        button {
            width:100%;
            padding:12px;
            margin-top:10px;
            border:none;
            border-radius:8px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .btn-register {
            background:#3399ff;
            color:#fff;
        }

        .btn-register:hover {
            background:#007acc;
        }

        .link {
            margin-top:15px;
            font-size:14px;
        }

        .link a {
            color:#3399ff;
            text-decoration:none;
            font-weight:600;
        }

        .btn-login {
            background: #3399ff;
            color: #fff;
        }

        .btn-login:hover {
            background: #007acc;
        }

        .password-overlay {
            position:absolute;
            left:0;
            width:100%;
            background:#fff;
            border:1px solid #ddd;
            border-radius:10px;
            padding:14px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
            opacity:0;
            visibility:hidden;
            transform:translateY(-5px);
            transition:all 0.25s ease;
            z-index:20;
        }

        .password-overlay.show {
            opacity:1;
            visibility:visible;
            transform:translateY(0);
        }

        .password-overlay ul {
            list-style:none;
            padding:0;
            margin:0;
        }

        .password-overlay li {
            display:flex;
            align-items:center;
            gap:10px;
            font-size:14px;
            margin:6px 0;
            color:#555;
            transition:0.2s;
        }

        .password-overlay li span {
            width:20px;
            height:20px;
            border-radius:50%;
            border:1px solid #ccc;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
        }

        .password-overlay li.valid {
            color:green;
        }

        .password-overlay li.valid span {
            background:green;
            color:#fff;
            border:none;
        }

        /* DASHBOARD MODE */
        body.dashboard-mode {
            display:block !important;
            height:auto !important;
            background:#f4f6f9;
            padding-bottom: 80px;
            padding-top: 60px;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 60px);
        }

        .dashboard-wrapper.collapsed .sidebar {
            width: 70px;
        }

        .dashboard-wrapper.collapsed .sidebar .sidebar-header,
        .dashboard-wrapper.collapsed .sidebar-menu span {
            display: none;
        }

        .dashboard-content {
            flex:1;
            padding:30px;
        }

        body.dashboard-mode .card {
            display:none;
        }

    </style>
</head>


<!-- TAMBAHAN -->
<body class="@yield('body-class')">

@if(trim($__env->yieldContent('body-class')) == '')
    <div class="card">

        <img src="{{ asset('assets/logo.png') }}" class="logo">
        <div class="subtext">Satuan Penjamin Pemenuhan Gizi</div>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')

    </div>
@else
    @yield('content')
@endif

<!-- END TAMBAHAN -->

<script>
document.addEventListener('DOMContentLoaded', function() {

    const registerForm = document.getElementById('form-register');
    if (!registerForm) return;

    const pwInput = registerForm.querySelector('input[name="password"]');
    if (!pwInput) return;

    const overlay = document.createElement('div');
    overlay.className = 'password-overlay';
    overlay.innerHTML = `
        <ul>
            <li data-rule="length"><span></span> Minimal 8 karakter</li>
            <li data-rule="uppercase"><span></span> Huruf kapital</li>
            <li data-rule="number"><span></span> Angka</li>
            <li data-rule="symbol"><span></span> Simbol (!@#$%^&*)</li>
        </ul>
    `;

    pwInput.parentNode.style.position = 'relative';
    pwInput.parentNode.appendChild(overlay);
    overlay.style.top = pwInput.offsetTop + pwInput.offsetHeight + 5 + 'px';

    let typingTimer;

    pwInput.addEventListener('input', function() {

        overlay.classList.add('show');
        clearTimeout(typingTimer);

        const val = pwInput.value;

        const rules = {
            length: val.length >= 8,
            uppercase: /[A-Z]/.test(val),
            number: /\d/.test(val),
            symbol: /[!@#$%^&*]/.test(val)
        };

        overlay.querySelectorAll('li').forEach(li => {
            const ruleName = li.getAttribute('data-rule');
            const span = li.querySelector('span');

            if (rules[ruleName]) {
                li.classList.add('valid');
                span.textContent = '✓';
            } else {
                li.classList.remove('valid');
                span.textContent = '';
            }
        });

        typingTimer = setTimeout(() => {
            overlay.classList.remove('show');
        }, 300);

    });

});
</script>

<script>
document.getElementById('toggleSidebar').addEventListener('click', function() {

    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
    document.querySelector('.navbar').classList.toggle('expanded');

});
</script>

</body>
</html>