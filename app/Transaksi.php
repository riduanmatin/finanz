<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	protected $table = "transaksi";

	protected $fillable = ["tanggal","jenis","kategori_id","nominal","keterangan","no_kwitansi","foto_kwitansi","anggaran_id"];

	public function kategori()
	{
		return $this->belongsTo('App\Kategori');
	}
}
