@extends('layouts.app')

@section('title','Login')

@section('content')
<h2>Login</h2>

@if(session('success'))
<div class="success">{{ session('success') }}</div>
@endif


<form action="{{ route('login') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" class="btn-login">Login</button>
</form>

<div class="link">
    Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
</div>
@endsection