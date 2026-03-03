@extends('layouts.app')

@section('title','Role & Permission')
@section('body-class','role-permission-mode')

@section('content')

@include('layouts.navbar')

<style>
/* ================= DASHBOARD LAYOUT ================= */
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

/* CONTENT: geser sesuai lebar sidebar */
.dashboard-content {
    margin-left: 250px;
    flex: 1;
    padding: 20px;
    background: #f8fafc;
    transition: 0.3s ease;
    box-sizing: border-box;
}

/* Content saat sidebar collapse */
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

/* ================= TABLE ================= */
.table-wrapper {
    width: 100%;
    background: #ffffff;
    border-radius: 6px;
    overflow-x: auto;
    border: 1px solid #e2e8f0; /* subtle border */
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.table-wrapper th, .table-wrapper td {
    padding: 12px 15px;
    font-size: 14px;
    border-bottom: 1px solid #e2e8f0; /* garis horizontal */
}

.table-wrapper th {
    background: #f1f5f9;
    color: #1e293b;
    font-weight: 600;
    text-align: left;
    border-bottom: 2px solid #cbd5e1; /* garis header lebih tegas */
}

.table-wrapper tr:hover {
    background-color: #f9fafb; /* hover effect ringan */
}

/* BUTTONS */
.btn-approve, .btn-reject {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: 0.2s ease;
}

.btn-approve { background-color: #22c55e; }
.btn-approve:hover { background-color: #16a34a; transform: translateY(-1px); }

.btn-reject { background-color: #ef4444; }
.btn-reject:hover { background-color: #dc2626; transform: translateY(-1px); }

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
    .table-wrapper table { font-size: 13px; }
}
</style>

<div class="dashboard-wrapper">

    @include('layouts.sidebar')

    <div class="dashboard-content">

        <h2>Role & Permission</h2>
        <p>Daftar permintaan role yang menunggu persetujuan:</p>

        @role('super-admin')
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Requested Role</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->requested_role }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->status == 'pending')
                                <span style="color: orange; font-weight: 600;">
                                    <i class="bi bi-hourglass-split"></i> Pending
                                </span>

                            @elseif($user->status == 'active')
                                <span style="color: green; font-weight: 600;">
                                    <i class="bi bi-check-circle-fill"></i> Active
                                </span>

                            @else
                                <span style="color: red; font-weight: 600;">
                                    <i class="bi bi-x-circle-fill"></i> Rejected
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->status == 'pending')

                                <div style="display:flex; flex-direction:column; gap:6px;">

                                    <form action="{{ route('approve.user', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-approve" type="submit">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('reject.user', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-reject" type="submit">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>

                                </div>

                            @else
                                <span style="color:#94a3b8;">No Action</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada permintaan role.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endrole

    </div>
</div>

@include('layouts.footer')

@endsection