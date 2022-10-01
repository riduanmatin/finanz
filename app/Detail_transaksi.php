<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_transaksi extends Model
{
    protected $table = "detail_transaksi";

    protected $fillable = ["nominal","keterangan","no_kwitansi","foto_kwitansi","transaksi_id"];

    public function detail_transaksi(){
        return $this->belongsTo('App\Transaksi');
    }
}
