<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('anggaran', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('bulan');
        //     $table->integer('kategori_id');
        //     $table->integer('nominal_per_pcs');
        //     $table->integer('jumlah_barang');
        //     $table->text('keterangan')->nullable();
        //     $table->enum('status', ['Tolak', 'Terima', 'Realisasi']);
        //     $table->integer('nominal_total');
        //     $table->timestamps();
        // });
        Schema::create('anggaran', function (Blueprint $table) {
            $table->id();
            $table->date('bulan');
            $table->integer('kategori_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('anggaran');
    }
}
