<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('data_s_p_p_g_s', function (Blueprint $table) {
        $table->id();
        $table->string('nama_sppg');
        $table->string('daerah');
        $table->integer('jumlah_sekolah');
        $table->integer('siswa_per_sekolah');
        $table->integer('total_siswa')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_s_p_p_g_s');
    }
};
