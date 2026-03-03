<?php

namespace App\Http\Controllers;

use App\Models\DataSPPG;
use Illuminate\Http\Request;

class DataSPPGController extends Controller
{
    public function index()
    {
        $data = DataSPPG::all();
        return view('datasppg.index', compact('data'));
    }

    public function create()
    {
        return view('datasppg.create');
    }

    public function store(Request $request)
    {
        // Cek apakah data sudah ada
        if (DataSPPG::count() >= 1) {
            return redirect()->route('datasppg.index')
                ->with('error', 'Data SPPG sudah ada. Anda hanya bisa mengedit.');
        }

        $request->validate([
            'nama_sppg' => 'required',
            'daerah' => 'required',
            'jumlah_sekolah' => 'required|integer',
            'siswa_per_sekolah' => 'required|integer',
        ]);

        $total = $request->jumlah_sekolah * $request->siswa_per_sekolah;

        DataSPPG::create([
            'nama_sppg' => $request->nama_sppg,
            'daerah' => $request->daerah,
            'jumlah_sekolah' => $request->jumlah_sekolah,
            'siswa_per_sekolah' => $request->siswa_per_sekolah,
            'total_siswa' => $total,
        ]);

        return redirect()->route('datasppg.index')
            ->with('success','Data berhasil ditambahkan');
    }

    public function edit(DataSPPG $datasppg)
    {
        return view('datasppg.edit', compact('datasppg'));
    }

    public function update(Request $request, DataSPPG $datasppg)
    {
        $total = $request->jumlah_sekolah * $request->siswa_per_sekolah;

        $datasppg->update([
            'nama_sppg' => $request->nama_sppg,
            'daerah' => $request->daerah,
            'jumlah_sekolah' => $request->jumlah_sekolah,
            'siswa_per_sekolah' => $request->siswa_per_sekolah,
            'total_siswa' => $total,
        ]);

        return redirect()->route('datasppg.index')
            ->with('success','Data berhasil diupdate');
    }

    public function destroy(DataSPPG $datasppg)
    {
        $datasppg->delete();

        return redirect()->route('datasppg.index')
            ->with('success','Data berhasil dihapus');
    }
}