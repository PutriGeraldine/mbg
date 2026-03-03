@extends('layouts.app')

@section('title','Data SPPG')
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
    padding: 30px;
    width: 100%;
    min-height: 100vh;
    background: #f1f5f9;
    transition: 0.3s ease;
}

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
    margin: 5px 0 20px 0;
    color: #64748b;
}

/* ================= STAT CARDS ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
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

/* ================= TABLE ================= */
.table-wrapper {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

table {
    width: 100%;
}

.btn-add-sppg {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    transition: 0.3s ease;
}

.btn-add-sppg:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(59,130,246,0.4);
    color: #fff;
}

</style>

<div class="dashboard-wrapper">

    @include('layouts.sidebar')

    <div class="dashboard-content">

        <h2>Data SPPG</h2>
        <p>Daftar seluruh data SPPG yang terdaftar di sistem.</p>

        {{-- ================= STATISTIK ================= --}}
        <div class="stats-grid">

            <div class="stat-card">
                <h3>Total SPPG</h3>
                <p>{{ $data->count() }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Sekolah Dilayani</h3>
                <p>{{ $data->sum('jumlah_sekolah') }}</p>
            </div>

            <div class="stat-card">
                <h3>Total Siswa Dilayani</h3>
                <p>{{ $data->sum('total_siswa') }}</p>
            </div>

        </div>

        {{-- ================= TABEL ================= --}}
        <div class="table-wrapper">

            @role('admin')
            @if($data->count() == 0)
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('datasppg.create') }}" class="btn-add-sppg">
                    <i class="fas fa-plus"></i> Tambah Data</a>
                <p></p>
            </div>
            @endif
            @endrole

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama SPPG</th>
                        <th>Daerah</th>
                        <th>Jumlah Sekolah</th>
                        <th>Siswa/Sekolah</th>
                        <th>Total Siswa</th>
                        @role('admin')
                        <th>Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->nama_sppg }}</td>
                        <td>{{ $row->daerah }}</td>
                        <td>{{ $row->jumlah_sekolah }}</td>
                        <td>{{ $row->siswa_per_sekolah }}</td>
                        <td><strong>{{ $row->total_siswa }}</strong></td>

                        @role('admin')
                        <td>
                            <a href="{{ route('datasppg.edit',$row->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('datasppg.destroy',$row->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>

@include('layouts.footer')

@endsection