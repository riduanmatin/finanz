<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Rencana_anggaran;
use DateTime;
use Illuminate\Http\Request;

class RencanaAnggaranController extends Controller
{
    public function view()
    {
        $kategori = Kategori::orderBy('kategori', 'asc')->get();
        $rencana_anggaran = Rencana_anggaran::orderBy('id', 'desc')->get();
        $rencana_anggaran_count = Rencana_anggaran::count();
        return view('app.rencana_anggaran', [
            'kategori' => $kategori, 
            'rencana_anggaran' => $rencana_anggaran,
            'rencana_anggaran_count' => $rencana_anggaran_count
        ]);
    }

    public function input(Request $req){
        $bulan = $req->input('bulan');
        $temp = new DateTime($bulan.'-01');
        $bulanFormat = $temp->format('Y/m/01');
        $kategori = $req->input('kategori');
        $nominal_per_pcs = $req->input('nominal_per_pcs');
        $jumlah_barang = $req->input('jumlah_barang');
        $keterangan = $req->input('keterangan');
        $nominal_total = $nominal_per_pcs * $jumlah_barang;

        Rencana_anggaran::create([
            'bulan' => $bulanFormat,
            'kategori_id' => $kategori,
            'nominal_per_pcs' => $nominal_per_pcs,
            'jumlah_barang' => $jumlah_barang,
            'keterangan' => $keterangan,
            'nominal_total' => $nominal_total
        ]);

        return redirect()->back()->with("success", "Rencana Anggaran telah diajukan!");
    }

    public function delete($id){
        $rencana_anggaran = Rencana_anggaran::find($id);
        $rencana_anggaran->delete();
        return redirect()->back()->with("success", "Rencana Anggaran telah dihapus!");
    }

    public function update($id, Request $req){
        $bulan = $req->input('bulan');
        $temp = new DateTime($bulan.'-01');
        $bulanFormat = $temp->format('Y/m/01');
        $kategori = $req->input('kategori');
        $nominal_per_pcs = $req->input('nominal_per_pcs');
        $jumlah_barang = $req->input('jumlah_barang');
        $keterangan = $req->input('keterangan');
        $nominal_total = $nominal_per_pcs * $jumlah_barang;

        $rencanaAnggaranUpd = Rencana_anggaran::find($id);
        $rencanaAnggaranUpd->bulan = $bulanFormat;
        $rencanaAnggaranUpd->kategori_id = $kategori;
        $rencanaAnggaranUpd->nominal_per_pcs = $nominal_per_pcs;
        $rencanaAnggaranUpd->jumlah_barang = $jumlah_barang;
        $rencanaAnggaranUpd->keterangan = $keterangan;
        $rencanaAnggaranUpd->nominal_total = $nominal_total;
        $rencanaAnggaranUpd->save();

        return redirect()->back()->with("success","Rencana Anggaran Telah di Update!");
    }
}
