<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rencana_anggaran_tolak extends Model
{
    protected $table = "rencana_anggaran_tolak";

    protected $fillable = ["bulan", "kategori_id", "nominal_per_pcs", "jumlah_barang", "keterangan", "nominal_total"];

    public function kategori()
	{
		return $this->belongsTo('App\Kategori');
	}
}
