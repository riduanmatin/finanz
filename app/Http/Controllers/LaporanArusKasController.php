<?php

namespace App\Http\Controllers;

use App\Exports\LaporanArusKasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanArusKasController extends Controller
{
    public function view(){
        if(isset($_GET['tahun'])){
            $arus_pengeluaran_operasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('CONCAT("Beban ", kategori.kategori) as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_operasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->first();
            $arus_pemasukan_operasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pemasukan_operasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->first();
            
            $total_arus_kas_operasional = $arus_pemasukan_operasi_total->total - $arus_pengeluaran_operasi_total->total;

            $arus_pemasukan_investasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_investasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_investasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->first();
            $arus_pemasukan_investasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->first();
            $total_arus_kas_investasi = $arus_pemasukan_investasi_total->total - $arus_pengeluaran_investasi_total->total;

            $arus_pemasukan_pendanaan = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Pendanaan')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pemasukan_pendanaan_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Pendanaan')
                    ->first();

            

            $total_saldo_kas = $total_arus_kas_operasional + $total_arus_kas_investasi + $arus_pemasukan_pendanaan_total->total;
            // dd(count($arus_pengeluaran_investasi));
            
            return view('app.laporan_arus_kas',[
                'arus_pengeluaran_operasi' => $arus_pengeluaran_operasi,
                'arus_pemasukan_operasi' => $arus_pemasukan_operasi,
                'arus_pengeluaran_operasi_total' => $arus_pengeluaran_operasi_total,
                'arus_pemasukan_operasi_total' => $arus_pemasukan_operasi_total,
                'total_arus_kas_operasional' => $total_arus_kas_operasional,
                'arus_pengeluaran_investasi' => $arus_pengeluaran_investasi,
                'arus_pemasukan_investasi' => $arus_pemasukan_investasi,
                'total_arus_kas_investasi' => $total_arus_kas_investasi,
                'total_saldo_kas' => $total_saldo_kas,
                'arus_pemasukan_pendanaan' => $arus_pemasukan_pendanaan,
                'arus_pemasukan_pendanaan_total' => $arus_pemasukan_pendanaan_total
            ]);
        }else{
            // $kategori = Kategori::orderBy('kategori','asc')->get();
            // $transaksi = Transaksi::orderBy('id','desc')->get();
            return view('app.laporan_arus_kas',['transaksi' => array()]);
        }
    }

    public function print_pdf(){
        if(isset($_GET['tahun'])){
            $arus_pengeluaran_operasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('CONCAT("Beban ", kategori.kategori) as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_operasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->first();
            $arus_pemasukan_operasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pemasukan_operasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Operasional')
                    ->first();
            
            $total_arus_kas_operasional = $arus_pemasukan_operasi_total->total - $arus_pengeluaran_operasi_total->total;

            $arus_pemasukan_investasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_investasi = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pengeluaran_investasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pengeluaran')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->first();
            $arus_pemasukan_investasi_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Investasi')
                    ->first();
            $total_arus_kas_investasi = $arus_pemasukan_investasi_total->total - $arus_pengeluaran_investasi_total->total;

            $arus_pemasukan_pendanaan = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Pendanaan')
                    ->groupBy('kategori.kategori')
                    ->get();
            $arus_pemasukan_pendanaan_total = DB::table('transaksi')
                    ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
                    ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
                    ->whereYear('tanggal', '=', $_GET['tahun'])
                    ->where('transaksi.jenis', '=', 'Pemasukan')
                    ->where('kategori.jenis', '=', 'Pendanaan')
                    ->first();

            

            $total_saldo_kas = $total_arus_kas_operasional + $total_arus_kas_investasi + $arus_pemasukan_pendanaan_total->total;
            // dd(count($arus_pengeluaran_investasi));
            
            return view('app.laporan_arus_kas_print',[
                'arus_pengeluaran_operasi' => $arus_pengeluaran_operasi,
                'arus_pemasukan_operasi' => $arus_pemasukan_operasi,
                'arus_pengeluaran_operasi_total' => $arus_pengeluaran_operasi_total,
                'arus_pemasukan_operasi_total' => $arus_pemasukan_operasi_total,
                'total_arus_kas_operasional' => $total_arus_kas_operasional,
                'arus_pengeluaran_investasi' => $arus_pengeluaran_investasi,
                'arus_pemasukan_investasi' => $arus_pemasukan_investasi,
                'total_arus_kas_investasi' => $total_arus_kas_investasi,
                'total_saldo_kas' => $total_saldo_kas,
                'arus_pemasukan_pendanaan' => $arus_pemasukan_pendanaan,
                'arus_pemasukan_pendanaan_total' => $arus_pemasukan_pendanaan_total
            ]);
        }
    }

    public function print_excel(){
        return Excel::download(new LaporanArusKasExport, 'Laporan_arus_kas_'.$_GET['tahun'].'.xlsx');
    }
}
