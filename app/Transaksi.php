<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $table = "transaksi";

	protected $fillable = ["tanggal","jenis","kategori_id","nominal","keterangan","no_kwitansi","foto_kwitansi","anggaran_id"];

	// protected $fillable = ["tanggal","jenisTransaksi","kategori_id","user_id","anggaran_id"];

	// public function detailTransaksi(){
	// 	return $this->hasOne('App/Detail_transaksi');
	// }

	public function kategori()
	{
		return $this->belongsTo('App\Kategori', 
		// 'App\User'
	);
	}
}
