<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function view()
    {
        $kategori = Kategori::orderBy('kategori','asc')->get();
        $transaksi = Transaksi::orderBy('id','desc')->paginate(30);
        $transaksiCount = Transaksi::count();
        return view('app.transaksi',[
            'transaksi' => $transaksi,
            'kategori' => $kategori,
            'transaksiCount' => $transaksiCount
        ]);
    }

    public function input(Request $req)
    {   
        $this->validate($req, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $tanggal = $req->input('tanggal');
        $jenis = $req->input('jenis');
        $kategori = $req->input('kategori');
        $nominal = $req->input('nominal');
        $keterangan = $req->input('keterangan');
        $no_kwitansi = strtoupper($req->input('no_kwitansi'));
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
            'foto_kwitansi' => $filename
        ]);

        return redirect()->back()->with("success","Transaksi telah disimpan!");
    }


    public function update($id, Request $req)
    {   
        $transaksi = Transaksi::find($id);

        if($transaksi->foto_kwitansi == ""){
            $tanggal = $req->input('tanggal');
            $jenis = $req->input('jenis');
            $kategori = $req->input('kategori');
            $nominal = $req->input('nominal');
            $keterangan = $req->input('keterangan');
            $no_kwitansi = strtoupper($req->input('no_kwitansi'));
            $file = $req->file('image');

            if($file != ""){
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
            }
            else{
                $filename = "";
            }
            
            $transaksi->tanggal = $tanggal;
            $transaksi->jenis = $jenis;
            $transaksi->kategori_id = $kategori;
            $transaksi->nominal = $nominal;
            $transaksi->keterangan = $keterangan;
            $transaksi->no_kwitansi = $no_kwitansi;
            $transaksi->foto_kwitansi = $filename;
            $transaksi->save();

            return redirect()->back()->with("success","Transaksi telah diupdate!");
        }
        else{
            $temp = $transaksi->foto_kwitansi;
            $tanggal = $req->input('tanggal');
            $jenis = $req->input('jenis');
            $kategori = $req->input('kategori');
            $nominal = $req->input('nominal');
            $keterangan = $req->input('keterangan');
            $no_kwitansi = $req->input('no_kwitansi');
            $file = $req->file('image');

            if($file != ""){
                $filename = time()."_".$file->getClientOriginalName();
                $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
            }
            else{
                $filename = $temp;
            }
            
            $transaksi->tanggal = $tanggal;
            $transaksi->jenis = $jenis;
            $transaksi->kategori_id = $kategori;
            $transaksi->nominal = $nominal;
            $transaksi->keterangan = $keterangan;
            $transaksi->no_kwitansi = $no_kwitansi;
            $transaksi->foto_kwitansi = $filename;
            $transaksi->save();

            return redirect()->back()->with("success","Transaksi telah diupdate!");
        }
    }

    public function delete($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();
        return redirect()->back()->with("success","Transaksi telah dihapus!");
    }
}
