<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('kategori', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('kategori');
        //     $table->enum('jenis',['Operasional','Investasi', 'Pendanaan', 'null']);
        //     $table->timestamps();
        // });
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->integer('jenisKategori_id');
            $table->string('kategori');
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
        Schema::dropIfExists('kategori');
    }
}
