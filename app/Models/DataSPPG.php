<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSPPG extends Model
{
    protected $table = 'data_s_p_p_g_s';

    protected $fillable = [
        'nama_sppg',
        'daerah',
        'total_siswa'
    ];

    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class, 'datasppg_id');
    }
}
