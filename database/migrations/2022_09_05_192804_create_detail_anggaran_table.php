<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_anggaran', function (Blueprint $table) {
            $table->id();
            $table->integer('anggaran_id');
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
        Schema::dropIfExists('detail_anggaran');
    }
}
