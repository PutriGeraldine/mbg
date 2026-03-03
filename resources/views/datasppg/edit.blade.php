@extends('layouts.app')

@section('title','Edit Data SPPG')
@section('body-class','dashboard-mode')

@section('content')

@include('layouts.navbar')

<div class="dashboard-wrapper">
    @include('layouts.sidebar')

    <div class="dashboard-content">

        <div class="form-card">
            <h4>Edit Data SPPG</h4>

            <form action="{{ route('datasppg.update',$datasppg->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama SPPG</label>
                    <input type="text" name="nama_sppg"
                        value="{{ $datasppg->nama_sppg }}"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Daerah</label>
                    <input type="text" name="daerah"
                        value="{{ $datasppg->daerah }}"
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jumlah Sekolah</label>
                    <input type="number" name="jumlah_sekolah"
                        id="jumlah_sekolah"
                        value="{{ $datasppg->jumlah_sekolah }}"
                        class="form-control"
                        required onkeyup="hitungTotal()">
                </div>

                <div class="mb-3">
                    <label>Siswa per Sekolah</label>
                    <input type="number" name="siswa_per_sekolah"
                        id="siswa_per_sekolah"
                        value="{{ $datasppg->siswa_per_sekolah }}"
                        class="form-control"
                        required onkeyup="hitungTotal()">
                </div>

                <div class="mb-4">
                    <label>Total Siswa</label>
                    <input type="number"
                        id="total_siswa"
                        value="{{ $datasppg->total_siswa }}"
                        class="form-control"
                        readonly>
                </div>

                <button type="submit" class="btn-primary-custom">Update Data</button>
                <a href="{{ route('datasppg.index') }}" class="btn btn-secondary-custom">Kembali</a>
            </form>

        </div>

    </div>
</div>

@include('layouts.footer')

<script>
function hitungTotal(){
    let sekolah = document.getElementById('jumlah_sekolah').value;
    let siswa = document.getElementById('siswa_per_sekolah').value;
    document.getElementById('total_siswa').value = sekolah * siswa;
}
</script>

@endsection