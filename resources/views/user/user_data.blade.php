@extends('layouts.app')

@section('title', 'Data SPPG')
@section('body-class','user-dashboard-mode')

@section('content')

@include('layouts.navbar')
@include('layouts.sidebar')

<style>
/* CONTENT AREA */
.dashboard-content {
    margin-left: 250px;
    padding: 20px;
    background: #f8fafc;
    min-height: 100vh;
    transition: 0.3s ease;
    box-sizing: border-box;
}

/* Jika sidebar collapse */
.sidebar.collapsed ~ .dashboard-content {
    margin-left: 80px;
}

.dashboard-content h2 {
    font-size: 24px;
    color: #1e293b;
    margin-bottom: 10px;
}

.dashboard-content p {
    margin-bottom: 20px;
    color: #475569;
}

/* TABLE */
.table-wrapper {
    width: 100%;
    background: #fff;
    border-radius: 8px;
    overflow-x: auto;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    min-width: 500px;
}

.table-wrapper th, .table-wrapper td {
    padding: 10px 12px;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
}

.table-wrapper th {
    background: #f1f5f9;
    font-weight: 600;
}

.table-wrapper tr:hover { background: #f9fafb; }

/* Responsive */
@media(max-width:768px){
    .dashboard-content { margin-left: 0; padding: 15px; }
    .table-wrapper table { font-size: 13px; }
}
</style>

<div class="dashboard-content">
    <h2>Data SPPG</h2>
    <p>Berikut data SPPG yang tersedia:</p>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataSPPG as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->nama ?? '-' }}</td>
                    <td>{{ $data->alamat ?? '-' }}</td>
                    <td>{{ $data->tanggal ?? '-' }}</td>
                    <td>{{ $data->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('layouts.footer')

@endsection