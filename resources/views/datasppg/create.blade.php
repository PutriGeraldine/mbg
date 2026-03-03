@extends('layouts.app')

@section('title','Tambah Data SPPG')
@section('body-class','dashboard-mode')

@section('content')

@include('layouts.navbar')

<style>
.dashboard-wrapper {
    display: flex;
}

.dashboard-content {
    margin-left: 250px;
    padding: 40px;
    width: 100%;
    min-height: 100vh;
    background: #f8fafc;
    transition: 0.3s ease;
}

.sidebar.collapsed ~ .dashboard-content {
    margin-left: 80px;
}

.form-container {
    max-width: 1000px;
    margin: auto;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-title {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
    color: #0f172a;
}

.page-subtitle {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    background: #0872db;
    text-decoration: none;
    font-size: 13px;
    color: #eef3f9;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.arrow {
    font-size: 14px;
}

.back-link {
    text-decoration: none;
    font-size: 14px;
    color: #64748b;
    transition: 0.2s;
}

.back-link:hover {
    color: #0f172a;
}

.form-card {
    background: #ffffff;
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.04);
}

.form-control {
    border-radius: 8px;
    padding: 10px;
}

.section-title {
    font-weight: 600;
    margin: 30px 0 15px 0;
    color: #0f172a;
}

/* 🔥 SCROLL AREA */
.sekolah-scroll-area {
    max-height: 350px;
    overflow-y: auto;
    padding-right: 10px;
}

/* Scrollbar clean */
.sekolah-scroll-area::-webkit-scrollbar {
    width: 6px;
}

.sekolah-scroll-area::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.sekolah-scroll-area::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.sekolah-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

@media (max-width: 768px) {
    .sekolah-grid {
        grid-template-columns: 1fr;
    }
}

.sekolah-item {
    background: #f9fafb;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px;
    position: relative;
}

.sekolah-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 12px;
    color: #334155;
}

.remove-btn {
    position: absolute;
    top: 25px;
    right: 12px;
    background: #ef4444;
    border: none;
    color: white;

    width: 40px;
    height: 20px;

    display: flex;              /* 🔥 bikin center */
    align-items: center;        /* vertical center */
    justify-content: center;    /* horizontal center */

    border-radius: 6px;
    font-size: 20px;
    cursor: pointer;
}

.remove-btn:hover {
    background: #dc2626;
}

.btn-add {
    margin-top: 15px;
    background: #e2e8f0;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-add:hover {
    background: #cbd5e1;
}

.btn-primary-custom {
    margin-top: 30px;
    background: #2563eb;
    border: none;
    padding: 10px 22px;
    border-radius: 8px;
    color: white;
    font-size: 14px;
}

.total-box {
    margin-top: 20px;
}

</style>

<div class="dashboard-wrapper">
    @include('layouts.sidebar')

    <div class="dashboard-content">
        <div class="form-container">

            <div class="top-bar">
                <div>
                    <h4 class="page-title">Tambah Data SPPG</h4>
                    <div class="page-subtitle">Isi informasi SPPG dan data sekolah terkait</div>
                </div>

                <a href="{{ route('datasppg.index') }}" class="btn-back">
                    <span class="arrow">←</span>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="form-card">
                <form action="{{ route('datasppg.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nama SPPG</label>
                        <input type="text" name="nama_sppg" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Daerah</label>
                        <input type="text" name="daerah" class="form-control" required>
                    </div>

                    <div class="section-title">Data Sekolah</div>

                    <!-- 🔥 SCROLLABLE AREA -->
                    <div class="sekolah-scroll-area">
                        <div id="sekolah-wrapper" class="sekolah-grid">
                            <div class="sekolah-item">
                                <div class="sekolah-title">Sekolah 1</div>

                                <div class="mb-2">
                                    <label>Nama Sekolah</label>
                                    <input type="text" name="nama_sekolah[]" class="form-control" required>
                                </div>

                                <div>
                                    <label>Jumlah Siswa</label>
                                    <input type="number" name="jumlah_siswa[]" class="form-control siswa-input" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="tambahSekolah()" class="btn-add">
                        + Tambah Sekolah
                    </button>

                    <div class="total-box">
                        <label>Total Seluruh Siswa</label>
                        <input type="number" id="total_siswa" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn-primary-custom">
                        Simpan Data
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@include('layouts.footer')

<script>
function tambahSekolah() {
    let wrapper = document.getElementById('sekolah-wrapper');
    let jumlah = document.querySelectorAll('.sekolah-item').length + 1;

    let html = `
    <div class="sekolah-item">
        <button type="button" class="remove-btn" onclick="hapusSekolah(this)">×</button>
        <div class="sekolah-title">Sekolah ${jumlah}</div>

        <div class="mb-2">
            <label>Nama Sekolah</label>
            <input type="text" name="nama_sekolah[]" class="form-control" required>
        </div>

        <div>
            <label>Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa[]" class="form-control siswa-input" required>
        </div>
    </div>`;

    wrapper.insertAdjacentHTML('beforeend', html);
}

function hapusSekolah(button) {
    button.parentElement.remove();
    hitungTotal();
}

document.addEventListener('input', function(){
    hitungTotal();
});

function hitungTotal(){
    let inputs = document.querySelectorAll('.siswa-input');
    let total = 0;

    inputs.forEach(input => {
        total += parseInt(input.value) || 0;
    });

    document.getElementById('total_siswa').value = total;
}
</script>

@endsection