<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'datasppg_id',
        'nama_sekolah',
        'jumlah_siswa'
    ];

    public function datasppg()
    {
        return $this->belongsTo(DataSPPG::class, 'datasppg_id');
    }
}
