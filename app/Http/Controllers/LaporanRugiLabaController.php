<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Kategori;
use App\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanRugiLabaController extends Controller
{
    public function view()
    {
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori','asc')->get();
            if($_GET['kategori'] == ""){
                $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }else{
                $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
                ->whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan',['transaksi' => $transaksi, 'kategori' => $kategori]);
        }else{
            $kategori = Kategori::orderBy('kategori','asc')->get();
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan',['transaksi' => array(), 'kategori' => $kategori]);
        }
    }

    public function print_pdf()
    {       
        if(isset($_GET['kategori'])){
            $kategori = Kategori::orderBy('kategori','asc')->get();
            if($_GET['kategori'] == ""){
                $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }else{
                $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
                ->whereDate('tanggal','>=',$_GET['dari'])
                ->whereDate('tanggal','<=',$_GET['sampai'])
                ->get();
            }
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan_print',['transaksi' => $transaksi, 'kategori' => $kategori]);
        }
    }

    public function print_excel()
    {
        return Excel::download(new LaporanExport, 'Laporan.xlsx');
    }
}
