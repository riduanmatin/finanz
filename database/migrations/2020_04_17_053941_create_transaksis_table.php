<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('transaksi', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('tanggal');
        //     $table->enum('jenis',['Pemasukan','Pengeluaran']);
        //     $table->integer('kategori_id');
        //     $table->integer('nominal');
        //     $table->text('keterangan')->nullable();
        //     $table->text('no_kwitansi')->nullable();
        //     $table->string('foto_kwitansi')->nullable();
        //     $table->string('anggaran_id')->nullable();
        //     $table->timestamps();
        // });
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenisTransaksi',['Pemasukan','Pengeluaran']);
            $table->integer('kategori_id');
            $table->integer('user_id');
            $table->string('anggaran_id')->nullable();
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
        Schema::dropIfExists('transaksi');
    }
}
