@extends('layouts.app')

@section('title','Dashboard')
@section('body-class','dashboard-mode')

@section('content')

@include('layouts.navbar')

<style>

/* ================= DASHBOARD LAYOUT ================= */
.dashboard-wrapper {
    display: flex;
}

/* CONTENT */
.dashboard-content {
    margin-left: 250px;
    padding: 30px 30px 30px;
    width: 100%;
    min-height: 100vh;
    background: #f1f5f9;
    transition: 0.3s ease;
}

/* Jika sidebar collapse */
.sidebar.collapsed ~ .dashboard-content {
    margin-left: 80px;
}

/* TITLE */
.dashboard-content h2 {
    margin: 0;
    font-size: 22px;
    color: #1e293b;
}

.dashboard-content p {
    margin: 5px 0 0 0;
    color: #64748b;
}

/* ================= STAT CARDS ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.stat-card {
    background: #ffffff;
    padding: 22px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-card h3 {
    margin: 0;
    font-size: 14px;
    color: #64748b;
}

.stat-card p {
    font-size: 26px;
    font-weight: bold;
    margin-top: 8px;
    color: #1e293b;
}

</style>

<div class="dashboard-wrapper">

    @include('layouts.sidebar')

    <div class="dashboard-content">

        <h2>Super Admin Dashboard</h2>
        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>

        @role('super-admin')

        <div class="stats-grid">

            <div class="stat-card">
                <h3>Total User</h3>
                <p>{{ \App\Models\User::count() }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Admin</h3>
                <p>{{ \App\Models\User::role('admin')->count() }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Pemda</h3>
                <p>{{ \App\Models\User::role('pemda')->count() }}</p>
            </div>

        </div>

        @endrole

    </div>
</div>

@include('layouts.footer')

@endsection