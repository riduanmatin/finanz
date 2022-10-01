<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaAnggaranTerimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_anggaran_terima', function (Blueprint $table) {
            $table->id();
            $table->date('bulan');
            $table->integer('kategori_id');
            $table->integer('nominal_per_pcs');
            $table->integer('jumlah_barang');
            $table->text('keterangan')->nullable();
            $table->integer('nominal_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rencana_anggaran_terima');
    }
}
