@extends('layouts.app')

@section('title','Register')

@section('content')
<h2>Daftar</h2>

@if(session('success'))
<div class="success">{{ session('success') }}</div>
@endif

<form id="form-register" action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Nama Lengkap" required>
    <input type="email" name="email" placeholder="Email" required>
    <select name="role" required>
        <option value="">Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="pemda">Pemda</option>
        <option value="user">User</option>
    </select>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit" class="btn-register">Daftar</button>
</form>

<div class="link">
    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
</div>

<!-- Password Overlay JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cek cuma di halaman register
    const registerForm = document.getElementById('form-register');
    if (!registerForm) return; // kalau gak ada form-register, stop

    const pwInput = registerForm.querySelector('input[name="password"]');
    if (!pwInput) return;

    const overlay = document.createElement('div');
    overlay.classList.add('password-overlay');
    overlay.innerHTML = `
        <ul>
            <li id="rule-length"><span class="text">Minimal 8 karakter</span><span class="check"></span></li>
            <li id="rule-uppercase"><span class="text">Huruf kapital</span><span class="check"></span></li>
            <li id="rule-number"><span class="text">Angka</span><span class="check"></span></li>
            <li id="rule-symbol"><span class="text">Simbol (!@#$%^&*)</span><span class="check"></span></li>
        </ul>
    `;
    pwInput.parentNode.style.position = 'relative';
    pwInput.parentNode.appendChild(overlay);
    overlay.style.top = pwInput.offsetTop + pwInput.offsetHeight + 'px';
    overlay.style.left = '0';

    let hideTimer;
    pwInput.addEventListener('input', function() {
        overlay.style.display = 'block';
        overlay.style.opacity = '1';
        clearTimeout(hideTimer);

        const val = pwInput.value;
        const rules = [
            {id:'rule-length', test: val.length >= 8},
            {id:'rule-uppercase', test: /[A-Z]/.test(val)},
            {id:'rule-number', test: /\d/.test(val)},
            {id:'rule-symbol', test: /[!@#$%^&*]/.test(val)}
        ];

        let allValid = true;
        rules.forEach(r => {
            const el = document.getElementById(r.id);
            const check = el.querySelector('span.check');
            if (r.test) {
                el.classList.add('valid');
                check.textContent = '✓';
            } else {
                el.classList.remove('valid');
                check.textContent = '';
                allValid = false;
            }
        });

        if(allValid && val.length > 0){
            hideTimer = setTimeout(()=>{
                overlay.style.opacity = '0';
                setTimeout(()=>{ overlay.style.display = 'none'; },300);
            },700);
        }
    });
});
</script>
@endsection