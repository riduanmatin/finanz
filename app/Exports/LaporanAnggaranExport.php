<?php

namespace App\Exports;

use App\Anggaran;
use App\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanAnggaranExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {	
		
    	$kategori = Kategori::orderBy('kategori', 'asc')->get();
            if($_GET['kategori'] == ""){
                $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }else{
                $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('kategori_id', $_GET['kategori'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }
            return view('app.laporan_anggaran_excel',['anggaran' => $anggaran, 'kategori' => $kategori]);
    }
}