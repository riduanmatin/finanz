<?php

namespace App\Http\Controllers;

use App\Anggaran;
use App\Exports\LaporanAnggaranExport;
use App\Kategori;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanAnggaranController extends Controller
{
    public function view(){
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori', 'asc')->get();
            if($_GET['kategori'] == ""){
                $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }else{
                $anggaran = Anggaran::where('kategori_id', $_GET['kategori'])
                ->whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }
            return view('app.laporan_anggaran',['anggaran' => $anggaran, 'kategori' => $kategori]);
        }else{
            $kategori = Kategori::orderBy('kategori','asc')->get();
            return view('app.laporan_anggaran', ['anggaran' => array(), 'kategori' => $kategori]);
        }
    }

    public function print_pdf(){
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori', 'asc')->get();
            if($_GET['kategori'] == ""){
                $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }else{
                $anggaran = Anggaran::where('kategori_id', $_GET['kategori'])
                ->whereDate('bulan', '>=', $_GET['dari'])
                ->whereDate('bulan', '<=', $_GET['sampai'])
                ->where('status', '=', 'Realisasi')
                ->get();
            }
            return view('app.laporan_anggaran_print',['anggaran' => $anggaran, 'kategori' => $kategori]);
        }
    }

    public function print_excel(){
        return Excel::download(new LaporanAnggaranExport, 'Laporan_anggaran.xlsx');
    }
}
