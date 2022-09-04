<?php

namespace App\Http\Controllers;

use App\Anggaran;
use App\Kategori;
use App\Rencana_anggaran;
use App\Transaksi;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function view(){
        $kategori = Kategori::orderBy('kategori', 'asc')->get();
        $anggaran = Anggaran::orderBy('bulan', 'asc')->get();
        $anggaranTerima = Anggaran::orderBy('bulan', 'asc')->where('status', '!=', 'Tolak')->paginate(30);
        $anggaranTolak = Anggaran::orderBy('bulan', 'asc')->where('status', '=', 'Tolak')->paginate(30);
        $anggaranTerimaCount = Anggaran::where('status', '=', 'Terima')->count();
        $anggaranTolakCount = Anggaran::where('status', '=', 'Tolak')->count();
        $transaksi = Transaksi::where('anggaran_id', '!=', '')->paginate(30);
        $transaksiCount = Transaksi::where('anggaran_id', '!=', '')->count();
        return view('app.anggaran', [
            'kategori' => $kategori, 
            'anggaran' => $anggaran,
            'transaksi' => $transaksi,
            'anggaranTerimaCount' => $anggaranTerimaCount,
            'anggaranTolakCount' => $anggaranTolakCount,
            'transaksiCount' => $transaksiCount,
            'anggaranTerima' => $anggaranTerima,
            'anggaranTolak' => $anggaranTolak
        ]);
    }

    public function input_anggaran_terima($id, Request $req){
        $rencanaAnggaran = Rencana_anggaran::find($id);
        $kategori = $rencanaAnggaran->kategori_id;
        $bulan = $rencanaAnggaran->bulan;
        $nominal_per_pcs = $rencanaAnggaran->nominal_per_pcs;
        $jumlah_barang = $rencanaAnggaran->jumlah_barang;
        $keterangan = $rencanaAnggaran->keterangan;
        $nominal_total = $rencanaAnggaran->nominal_total;
        $status = "Terima";

        Anggaran::create([
            'bulan' => $bulan,
            'kategori_id' => $kategori,
            'nominal_per_pcs' => $nominal_per_pcs,
            'jumlah_barang' => $jumlah_barang,
            'keterangan' => $keterangan,
            'nominal_total' => $nominal_total,
            'status' => $status
        ]);

        $rencanaAnggaran->delete();

        return redirect()->back()->with("success", "Rencana Anggaran Telah di Validasi!");
    }
    
    public function input_anggaran_tolak($id, Request $req){
        $rencanaAnggaran = Rencana_anggaran::find($id);
        $kategori = $rencanaAnggaran->kategori_id;
        $bulan = $rencanaAnggaran->bulan;
        $nominal_per_pcs = $rencanaAnggaran->nominal_per_pcs;
        $jumlah_barang = $rencanaAnggaran->jumlah_barang;
        $keterangan = $rencanaAnggaran->keterangan;
        $nominal_total = $rencanaAnggaran->nominal_total;
        $status = "Tolak";

        Anggaran::create([
            'bulan' => $bulan,
            'kategori_id' => $kategori,
            'nominal_per_pcs' => $nominal_per_pcs,
            'jumlah_barang' => $jumlah_barang,
            'keterangan' => $keterangan,
            'nominal_total' => $nominal_total,
            'status' => $status
        ]);

        $rencanaAnggaran->delete();

        return redirect()->back()->with("success", "Rencana Anggaran Telah di Tolak!");
    }

    public function input_anggaran_realisasi($id, Request $req){
        $anggaran = Anggaran::find($id);

        $this->validate($req, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tanggal = $req->input('tanggal');
        $jenis = "Pengeluaran";
        $kategori = $anggaran->kategori_id;
        $nominal = $anggaran->nominal_total;
        $keterangan = $anggaran->keterangan;
        $no_kwitansi = strtoupper($req->input('no_kwitansi'));
        $anggaran_id = $anggaran->id;
        $file = $req->file('image');
        if($file != ""){
            $filename = time()."_".$file->getClientOriginalName();
            $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
        }
        else{
            $filename = "";
        }

        Transaksi::create([
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'kategori_id' => $kategori,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
            'no_kwitansi' => $no_kwitansi,
            'foto_kwitansi' => $filename,
            'anggaran_id' => $anggaran_id
        ]);

        $anggaran->status = "Realisasi";
        $anggaran->save();

        return redirect()->back()->with("success", "Anggaran telah Terealisasi!");
    }
}
