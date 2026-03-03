@extends('layouts.app')

@section('title','Dashboard Pemda')
@section('body-class','pemda-dashboard-mode')

@section('content')

@include('layouts.navbar')

<style>
.dashboard-wrapper {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

/* SIDEBAR */
.dashboard-wrapper .sidebar {
    width: 250px;
    flex-shrink: 0;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    background-color: #1e293b;
    overflow-y: auto;
}

/* CONTENT */
.dashboard-content {
    margin-left: 250px;
    flex: 1;
    padding: 20px;
    background: #f8fafc;
    transition: 0.3s ease;
    box-sizing: border-box;
}

/* Saat sidebar collapse */
.dashboard-wrapper .sidebar.collapsed ~ .dashboard-content {
    margin-left: 80px;
}

/* TITLE */
.dashboard-content h2 {
    font-size: 24px;
    color: #1e293b;
    margin-bottom: 10px;
}

.dashboard-content p {
    margin-bottom: 20px;
    color: #475569;
}

/* CARD */
.card-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    flex: 1 1 250px;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.2s;
    text-align: center;
    cursor: pointer;
}

.card:hover {
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.card i {
    font-size: 32px;
    color: #10b981;
    margin-bottom: 10px;
}

/* Responsive */
@media(max-width: 768px){
    .dashboard-wrapper {
        flex-direction: column;
    }
    .dashboard-wrapper .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
    .dashboard-content {
        margin-left: 0;
        padding: 15px;
    }
}
</style>

<div class="dashboard-wrapper">

    @include('layouts.sidebar')

    <div class="dashboard-content">

        <h2>Selamat Datang, {{ Auth::user()->name }}</h2>
        <p>Anda memiliki akses sebagai Pemda.</p>

        <div class="card-wrapper">

            {{-- Card Data SPPG --}}
            <div class="card" onclick="window.location.href='{{ route('lihat.data') }}'">
                <i class="fas fa-database"></i>
                <h3>Data SPPG</h3>
                <p>Melihat dan memverifikasi data SPPG.</p>
            </div>

        </div>

    </div>
</div>

@include('layouts.footer')

@endsection