<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_anggaran extends Model
{
    protected $table = "detail_anggaran";

    protected $fillable = ["anggaran_id","nominal_per_pcs", "jumlah_barang", "keterangan", "status", "nominal_total"];

    public function anggaran(){
        return $this->belongsTo('App\Anggaran');
    }
}
