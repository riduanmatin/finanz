<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";

	protected $fillable = ["kategori", "jenis"];

	// protected $fillable = ["kategori", "jenisKategori_id"];

	// public function jenisKategori(){
	// 	return $this->belongsTo('App\Jenis_kategori');
	// }

	public function transaksi()
	{
		return $this->hasMany(['App\Transaksi', 'App/Rencana_anggaran', 'App/Anggaran', 
		// 'App/Rencana_anggaran_tolak', 'App/Rencana_anggaran_terima'
	]);
	}
}
