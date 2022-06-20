<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = "anggaran";

    protected $fillable = ["bulan", "kategori_id", "nominal_per_pcs", "jumlah_barang", "keterangan", "status", "nominal_total"];

    public function kategori()
	{
		return $this->belongsTo('App\Kategori');
	}
}
