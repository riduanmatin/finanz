<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Transaksi;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function view()
    {
        $kategori = Kategori::orderBy('kategori','asc')->get();
        return view('app.kategori',['kategori' => $kategori]);
    }

    public function input(Request $req)
    {
        $nama = $req->input('nama');
        $jenis = $req->input('jenis');
        Kategori::create([
            'kategori' => $nama,
            'jenis' => $jenis
        ]);
        return redirect('kategori')->with('success','Kategori telah disimpan');
    }

    public function update($id, Request $req)
    {
        $nama = $req->input('nama');
        $jenis = $req->input('jenis');
        $kategori = Kategori::find($id);
        $kategori->kategori = $nama;
        $kategori->jenis = $jenis;
        $kategori->save();
        return redirect('kategori')->with('success','Kategori telah diupdate');
    }

    public function delete($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        $tt = Transaksi::where('kategori_id',$id)->get();

        if($tt->count() > 0){
            $transaksi = Transaksi::where('kategori_id',$id)->first();
            $transaksi->kategori_id = "1";
            $transaksi->save();
        }
        return redirect('kategori')->with('success','Kategori telah dihapus');
    }
}
