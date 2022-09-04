<?php

namespace App\Http\Controllers;

use App\Anggaran;
use App\Exports\LaporanAnggaranExport;
use Illuminate\Http\Request;
use App\Exports\LaporanArusKasExport;

use Illuminate\Support\Facades\DB;

use App\Kategori;
use App\Transaksi;
use App\User;

use Hash;
use Auth;
use File;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Rencana_anggaran;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kategori = Kategori::all();
        $transaksi = Transaksi::all();
        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');

        $pemasukan_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pemasukan_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pemasukan_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pemasukan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->first();

        $pengeluaran_hari_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereDate('tanggal',$tanggal)
        ->first();

        $pengeluaran_bulan_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereMonth('tanggal',$bulan)
        ->first();

        $pengeluaran_tahun_ini = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereYear('tanggal',$tahun)
        ->first();

        $seluruh_pengeluaran = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->first();

        $anggaran_3_bulan = DB::table('anggaran')
        ->select(DB::raw('SUM(nominal_total) as total'))
        ->where('status', 'Terima')
        ->whereMonth('bulan', '>=',$bulan)
        ->whereMonth('bulan', '<=', $bulan+2)
        ->first();

        $bulan_2 = DB::table('transaksi')
        ->select(DB::raw('IF((MONTH(CURDATE()) + 2) > 12, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -10 MONTH), "%b"), DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 2 MONTH), "%b")) as bulan'))
        ->first();

        $total_rencana_anggaran = DB::table('rencana_anggaran')
        ->select(DB::raw('COUNT(id) as total'))
        ->first();

        $total_anggaran = DB::table('anggaran')
        ->select(DB::raw('COUNT(id) as total'))
        ->first();

        $total_anggaran_terima = DB::table('anggaran')
        ->select(DB::raw('COUNT(id) as total'))
        ->where('status', 'Terima')
        ->first();

        $total_anggaran_tolak = DB::table('anggaran')
        ->select(DB::raw('COUNT(id) as total'))
        ->where('status', 'Tolak')
        ->first();

        return view('app.index',
            [
                'pemasukan_hari_ini' => $pemasukan_hari_ini, 
                'pemasukan_bulan_ini' => $pemasukan_bulan_ini,
                'pemasukan_tahun_ini' => $pemasukan_tahun_ini,
                'seluruh_pemasukan' => $seluruh_pemasukan,
                'pengeluaran_hari_ini' => $pengeluaran_hari_ini, 
                'pengeluaran_bulan_ini' => $pengeluaran_bulan_ini,
                'pengeluaran_tahun_ini' => $pengeluaran_tahun_ini,
                'seluruh_pengeluaran' => $seluruh_pengeluaran,
                'kategori' => $kategori,
                'transaksi' => $transaksi,
                'anggaran_3_bulan' =>$anggaran_3_bulan,
                'bulan_2' => $bulan_2,
                'total_rencana_anggaran' => $total_rencana_anggaran,
                'total_anggaran' => $total_anggaran,
                'total_anggaran_terima' => $total_anggaran_terima,
                'total_anggaran_tolak' => $total_anggaran_tolak
            ]
        );
    }

    // public function kategori()
    // {
    //     $kategori = Kategori::orderBy('kategori','asc')->get();
    //     return view('app.kategori',['kategori' => $kategori]);
    // }

    // public function kategori_aksi(Request $req)
    // {
    //     $nama = $req->input('nama');
    //     $jenis = $req->input('jenis');
    //     Kategori::create([
    //         'kategori' => $nama,
    //         'jenis' => $jenis
    //     ]);
    //     return redirect('kategori')->with('success','Kategori telah disimpan');
    // }

    // public function kategori_update($id, Request $req)
    // {
    //     $nama = $req->input('nama');
    //     $jenis = $req->input('jenis');
    //     $kategori = Kategori::find($id);
    //     $kategori->kategori = $nama;
    //     $kategori->jenis = $jenis;
    //     $kategori->save();
    //     return redirect('kategori')->with('success','Kategori telah diupdate');
    // }

    // public function kategori_delete($id)
    // {
    //     $kategori = Kategori::find($id);
    //     $kategori->delete();

    //     $tt = Transaksi::where('kategori_id',$id)->get();

    //     if($tt->count() > 0){
    //         $transaksi = Transaksi::where('kategori_id',$id)->first();
    //         $transaksi->kategori_id = "1";
    //         $transaksi->save();
    //     }
    //     return redirect('kategori')->with('success','Kategori telah dihapus');
    // }

    public function password()
    {
        return view('app.password');
    }

    public function password_update(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password telah diganti!");

    }

    // public function rencana_anggaran()
    // {
    //     $kategori = Kategori::orderBy('kategori', 'asc')->get();
    //     $rencana_anggaran = Rencana_anggaran::orderBy('id', 'desc')->get();
    //     $rencana_anggaran_count = Rencana_anggaran::count();
    //     return view('app.rencana_anggaran', [
    //         'kategori' => $kategori, 
    //         'rencana_anggaran' => $rencana_anggaran,
    //         'rencana_anggaran_count' => $rencana_anggaran_count
    //     ]);
    // }

    // public function rencana_anggaran_aksi(Request $req){
    //     $bulan = $req->input('bulan');
    //     $temp = new DateTime($bulan.'-01');
    //     $bulanFormat = $temp->format('Y/m/01');
    //     $kategori = $req->input('kategori');
    //     $nominal_per_pcs = $req->input('nominal_per_pcs');
    //     $jumlah_barang = $req->input('jumlah_barang');
    //     $keterangan = $req->input('keterangan');
    //     $nominal_total = $nominal_per_pcs * $jumlah_barang;

    //     Rencana_anggaran::create([
    //         'bulan' => $bulanFormat,
    //         'kategori_id' => $kategori,
    //         'nominal_per_pcs' => $nominal_per_pcs,
    //         'jumlah_barang' => $jumlah_barang,
    //         'keterangan' => $keterangan,
    //         'nominal_total' => $nominal_total
    //     ]);

    //     return redirect()->back()->with("success", "Rencana Anggaran telah diajukan!");
    // }

    // public function rencana_anggaran_delete($id){
    //     $rencana_anggaran = Rencana_anggaran::find($id);
    //     $rencana_anggaran->delete();
    //     return redirect()->back()->with("success", "Rencana Anggaran telah dihapus!");
    // }

    // public function rencana_anggaran_update($id, Request $req){
    //     $bulan = $req->input('bulan');
    //     $temp = new DateTime($bulan.'-01');
    //     $bulanFormat = $temp->format('Y/m/01');
    //     $kategori = $req->input('kategori');
    //     $nominal_per_pcs = $req->input('nominal_per_pcs');
    //     $jumlah_barang = $req->input('jumlah_barang');
    //     $keterangan = $req->input('keterangan');
    //     $nominal_total = $nominal_per_pcs * $jumlah_barang;

    //     $rencanaAnggaranUpd = Rencana_anggaran::find($id);
    //     $rencanaAnggaranUpd->bulan = $bulanFormat;
    //     $rencanaAnggaranUpd->kategori_id = $kategori;
    //     $rencanaAnggaranUpd->nominal_per_pcs = $nominal_per_pcs;
    //     $rencanaAnggaranUpd->jumlah_barang = $jumlah_barang;
    //     $rencanaAnggaranUpd->keterangan = $keterangan;
    //     $rencanaAnggaranUpd->nominal_total = $nominal_total;
    //     $rencanaAnggaranUpd->save();

    //     return redirect()->back()->with("success","Rencana Anggaran Telah di Update!");
    // }

    // public function anggaran(){
    //     $kategori = Kategori::orderBy('kategori', 'asc')->get();
    //     $anggaran = Anggaran::orderBy('bulan', 'asc')->get();
    //     $anggaranTerima = Anggaran::orderBy('bulan', 'asc')->where('status', '!=', 'Tolak')->paginate(30);
    //     $anggaranTolak = Anggaran::orderBy('bulan', 'asc')->where('status', '=', 'Tolak')->paginate(30);
    //     $anggaranTerimaCount = Anggaran::where('status', '=', 'Terima')->count();
    //     $anggaranTolakCount = Anggaran::where('status', '=', 'Tolak')->count();
    //     $transaksi = Transaksi::where('anggaran_id', '!=', '')->paginate(30);
    //     $transaksiCount = Transaksi::where('anggaran_id', '!=', '')->count();
    //     return view('app.anggaran', [
    //         'kategori' => $kategori, 
    //         'anggaran' => $anggaran,
    //         'transaksi' => $transaksi,
    //         'anggaranTerimaCount' => $anggaranTerimaCount,
    //         'anggaranTolakCount' => $anggaranTolakCount,
    //         'transaksiCount' => $transaksiCount,
    //         'anggaranTerima' => $anggaranTerima,
    //         'anggaranTolak' => $anggaranTolak
    //     ]);
    // }

    // public function anggaran_aksi_terima($id, Request $req){
    //     $rencanaAnggaran = Rencana_anggaran::find($id);
    //     $kategori = $rencanaAnggaran->kategori_id;
    //     $bulan = $rencanaAnggaran->bulan;
    //     $nominal_per_pcs = $rencanaAnggaran->nominal_per_pcs;
    //     $jumlah_barang = $rencanaAnggaran->jumlah_barang;
    //     $keterangan = $rencanaAnggaran->keterangan;
    //     $nominal_total = $rencanaAnggaran->nominal_total;
    //     $status = "Terima";

    //     Anggaran::create([
    //         'bulan' => $bulan,
    //         'kategori_id' => $kategori,
    //         'nominal_per_pcs' => $nominal_per_pcs,
    //         'jumlah_barang' => $jumlah_barang,
    //         'keterangan' => $keterangan,
    //         'nominal_total' => $nominal_total,
    //         'status' => $status
    //     ]);

    //     $rencanaAnggaran->delete();

    //     return redirect()->back()->with("success", "Rencana Anggaran Telah di Validasi!");
    // }
    
    // public function anggaran_aksi_tolak($id, Request $req){
    //     $rencanaAnggaran = Rencana_anggaran::find($id);
    //     $kategori = $rencanaAnggaran->kategori_id;
    //     $bulan = $rencanaAnggaran->bulan;
    //     $nominal_per_pcs = $rencanaAnggaran->nominal_per_pcs;
    //     $jumlah_barang = $rencanaAnggaran->jumlah_barang;
    //     $keterangan = $rencanaAnggaran->keterangan;
    //     $nominal_total = $rencanaAnggaran->nominal_total;
    //     $status = "Tolak";

    //     Anggaran::create([
    //         'bulan' => $bulan,
    //         'kategori_id' => $kategori,
    //         'nominal_per_pcs' => $nominal_per_pcs,
    //         'jumlah_barang' => $jumlah_barang,
    //         'keterangan' => $keterangan,
    //         'nominal_total' => $nominal_total,
    //         'status' => $status
    //     ]);

    //     $rencanaAnggaran->delete();

    //     return redirect()->back()->with("success", "Rencana Anggaran Telah di Tolak!");
    // }

    // public function anggaran_aksi_realisasi($id, Request $req){
    //     $anggaran = Anggaran::find($id);

    //     $this->validate($req, [
    //         'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
    //     ]);

    //     $tanggal = $req->input('tanggal');
    //     $jenis = "Pengeluaran";
    //     $kategori = $anggaran->kategori_id;
    //     $nominal = $anggaran->nominal_total;
    //     $keterangan = $anggaran->keterangan;
    //     $no_kwitansi = strtoupper($req->input('no_kwitansi'));
    //     $anggaran_id = $anggaran->id;
    //     $file = $req->file('image');
    //     if($file != ""){
    //         $filename = time()."_".$file->getClientOriginalName();
    //         $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
    //     }
    //     else{
    //         $filename = "";
    //     }

    //     Transaksi::create([
    //         'tanggal' => $tanggal,
    //         'jenis' => $jenis,
    //         'kategori_id' => $kategori,
    //         'nominal' => $nominal,
    //         'keterangan' => $keterangan,
    //         'no_kwitansi' => $no_kwitansi,
    //         'foto_kwitansi' => $filename,
    //         'anggaran_id' => $anggaran_id
    //     ]);

    //     $anggaran->status = "Realisasi";
    //     $anggaran->save();

    //     return redirect()->back()->with("success", "Anggaran telah Terealisasi!");
    // }

    // public function transaksi()
    // {
    //     $kategori = Kategori::orderBy('kategori','asc')->get();
    //     $transaksi = Transaksi::orderBy('id','desc')->paginate(30);
    //     $transaksiCount = Transaksi::count();
    //     return view('app.transaksi',[
    //         'transaksi' => $transaksi,
    //         'kategori' => $kategori,
    //         'transaksiCount' => $transaksiCount
    //     ]);
    // }

    // public function transaksi_aksi(Request $req)
    // {   
    //     $this->validate($req, [
    //         'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
    //     ]);

    //     $tanggal = $req->input('tanggal');
    //     $jenis = $req->input('jenis');
    //     $kategori = $req->input('kategori');
    //     $nominal = $req->input('nominal');
    //     $keterangan = $req->input('keterangan');
    //     $no_kwitansi = strtoupper($req->input('no_kwitansi'));
    //     $file = $req->file('image');
        
    //     if($file != ""){
    //         $filename = time()."_".$file->getClientOriginalName();
    //         $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
    //     }
    //     else{
    //         $filename = "";
    //     }

    //     Transaksi::create([
    //         'tanggal' => $tanggal,
    //         'jenis' => $jenis,
    //         'kategori_id' => $kategori,
    //         'nominal' => $nominal,
    //         'keterangan' => $keterangan,
    //         'no_kwitansi' => $no_kwitansi,
    //         'foto_kwitansi' => $filename
    //     ]);

    //     return redirect()->back()->with("success","Transaksi telah disimpan!");
    // }


    // public function transaksi_update($id, Request $req)
    // {   
    //     $transaksi = Transaksi::find($id);

    //     if($transaksi->foto_kwitansi == ""){
    //         $tanggal = $req->input('tanggal');
    //         $jenis = $req->input('jenis');
    //         $kategori = $req->input('kategori');
    //         $nominal = $req->input('nominal');
    //         $keterangan = $req->input('keterangan');
    //         $no_kwitansi = strtoupper($req->input('no_kwitansi'));
    //         $file = $req->file('image');

    //         if($file != ""){
    //             $filename = time()."_".$file->getClientOriginalName();
    //             $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
    //         }
    //         else{
    //             $filename = "";
    //         }
            
    //         $transaksi->tanggal = $tanggal;
    //         $transaksi->jenis = $jenis;
    //         $transaksi->kategori_id = $kategori;
    //         $transaksi->nominal = $nominal;
    //         $transaksi->keterangan = $keterangan;
    //         $transaksi->no_kwitansi = $no_kwitansi;
    //         $transaksi->foto_kwitansi = $filename;
    //         $transaksi->save();

    //         return redirect()->back()->with("success","Transaksi telah diupdate!");
    //     }
    //     else{
    //         $temp = $transaksi->foto_kwitansi;
    //         $tanggal = $req->input('tanggal');
    //         $jenis = $req->input('jenis');
    //         $kategori = $req->input('kategori');
    //         $nominal = $req->input('nominal');
    //         $keterangan = $req->input('keterangan');
    //         $no_kwitansi = $req->input('no_kwitansi');
    //         $file = $req->file('image');

    //         if($file != ""){
    //             $filename = time()."_".$file->getClientOriginalName();
    //             $file->move(public_path('gambar/kwitansi_transaksi'), $filename);
    //         }
    //         else{
    //             $filename = $temp;
    //         }
            
    //         $transaksi->tanggal = $tanggal;
    //         $transaksi->jenis = $jenis;
    //         $transaksi->kategori_id = $kategori;
    //         $transaksi->nominal = $nominal;
    //         $transaksi->keterangan = $keterangan;
    //         $transaksi->no_kwitansi = $no_kwitansi;
    //         $transaksi->foto_kwitansi = $filename;
    //         $transaksi->save();

    //         return redirect()->back()->with("success","Transaksi telah diupdate!");
    //     }
    // }

    // public function transaksi_delete($id)
    // {
    //     $transaksi = Transaksi::find($id);
    //     $transaksi->delete();
    //     return redirect()->back()->with("success","Transaksi telah dihapus!");
    // }

    // public function laporan_anggaran(){
    //     if(isset($_GET['kategori'])){
    //         $kategori = Kategori::orderBy('kategori', 'asc')->get();
    //         if($_GET['kategori'] == ""){
    //             $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
    //             ->whereDate('bulan', '<=', $_GET['sampai'])
    //             ->where('status', '=', 'Realisasi')
    //             ->get();
    //         }else{
    //             $anggaran = Anggaran::where('kategori_id', $_GET['kategori'])
    //             ->whereDate('bulan', '>=', $_GET['dari'])
    //             ->whereDate('bulan', '<=', $_GET['sampai'])
    //             ->where('status', '=', 'Realisasi')
    //             ->get();
    //         }
    //         return view('app.laporan_anggaran',['anggaran' => $anggaran, 'kategori' => $kategori]);
    //     }else{
    //         $kategori = Kategori::orderBy('kategori','asc')->get();
    //         return view('app.laporan_anggaran', ['anggaran' => array(), 'kategori' => $kategori]);
    //     }
    // }

    // public function laporan_print_anggaran(){
    //     if(isset($_GET['kategori'])){
    //         $kategori = Kategori::orderBy('kategori', 'asc')->get();
    //         if($_GET['kategori'] == ""){
    //             $anggaran = Anggaran::whereDate('bulan', '>=', $_GET['dari'])
    //             ->whereDate('bulan', '<=', $_GET['sampai'])
    //             ->where('status', '=', 'Realisasi')
    //             ->get();
    //         }else{
    //             $anggaran = Anggaran::where('kategori_id', $_GET['kategori'])
    //             ->whereDate('bulan', '>=', $_GET['dari'])
    //             ->whereDate('bulan', '<=', $_GET['sampai'])
    //             ->where('status', '=', 'Realisasi')
    //             ->get();
    //         }
    //         return view('app.laporan_anggaran_print',['anggaran' => $anggaran, 'kategori' => $kategori]);
    //     }
    // }

    // public function laporan_excel_anggaran(){
    //     return Excel::download(new LaporanAnggaranExport, 'Laporan_anggaran.xlsx');
    // }

    // public function laporan_arus_kas(){
    //     if(isset($_GET['tahun'])){
    //         $arus_pengeluaran_operasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('CONCAT("Beban ", kategori.kategori) as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_operasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->first();
    //         $arus_pemasukan_operasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pemasukan_operasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->first();
            
    //         $total_arus_kas_operasional = $arus_pemasukan_operasi_total->total - $arus_pengeluaran_operasi_total->total;

    //         $arus_pemasukan_investasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_investasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_investasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->first();
    //         $arus_pemasukan_investasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->first();
    //         $total_arus_kas_investasi = $arus_pemasukan_investasi_total->total - $arus_pengeluaran_investasi_total->total;

    //         $arus_pemasukan_pendanaan = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Pendanaan')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pemasukan_pendanaan_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Pendanaan')
    //                 ->first();

            

    //         $total_saldo_kas = $total_arus_kas_operasional + $total_arus_kas_investasi + $arus_pemasukan_pendanaan_total->total;
    //         // dd(count($arus_pengeluaran_investasi));
            
    //         return view('app.laporan_arus_kas',[
    //             'arus_pengeluaran_operasi' => $arus_pengeluaran_operasi,
    //             'arus_pemasukan_operasi' => $arus_pemasukan_operasi,
    //             'arus_pengeluaran_operasi_total' => $arus_pengeluaran_operasi_total,
    //             'arus_pemasukan_operasi_total' => $arus_pemasukan_operasi_total,
    //             'total_arus_kas_operasional' => $total_arus_kas_operasional,
    //             'arus_pengeluaran_investasi' => $arus_pengeluaran_investasi,
    //             'arus_pemasukan_investasi' => $arus_pemasukan_investasi,
    //             'total_arus_kas_investasi' => $total_arus_kas_investasi,
    //             'total_saldo_kas' => $total_saldo_kas,
    //             'arus_pemasukan_pendanaan' => $arus_pemasukan_pendanaan,
    //             'arus_pemasukan_pendanaan_total' => $arus_pemasukan_pendanaan_total
    //         ]);
    //     }else{
    //         // $kategori = Kategori::orderBy('kategori','asc')->get();
    //         // $transaksi = Transaksi::orderBy('id','desc')->get();
    //         return view('app.laporan_arus_kas',['transaksi' => array()]);
    //     }
    // }

    // public function laporan_arus_kas_print(){
    //     if(isset($_GET['tahun'])){
    //         $arus_pengeluaran_operasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('CONCAT("Beban ", kategori.kategori) as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_operasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->first();
    //         $arus_pemasukan_operasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pemasukan_operasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Operasional')
    //                 ->first();
            
    //         $total_arus_kas_operasional = $arus_pemasukan_operasi_total->total - $arus_pengeluaran_operasi_total->total;

    //         $arus_pemasukan_investasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_investasi = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pengeluaran_investasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pengeluaran')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->first();
    //         $arus_pemasukan_investasi_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Investasi')
    //                 ->first();
    //         $total_arus_kas_investasi = $arus_pemasukan_investasi_total->total - $arus_pengeluaran_investasi_total->total;

    //         $arus_pemasukan_pendanaan = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('kategori.kategori as "nama", SUM(transaksi.nominal) as "nominal"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Pendanaan')
    //                 ->groupBy('kategori.kategori')
    //                 ->get();
    //         $arus_pemasukan_pendanaan_total = DB::table('transaksi')
    //                 ->join('kategori', 'transaksi.kategori_id', '=', 'kategori.id')
    //                 ->select(DB::raw('SUM(transaksi.nominal) as "total"'))
    //                 ->whereYear('tanggal', '=', $_GET['tahun'])
    //                 ->where('transaksi.jenis', '=', 'Pemasukan')
    //                 ->where('kategori.jenis', '=', 'Pendanaan')
    //                 ->first();

            

    //         $total_saldo_kas = $total_arus_kas_operasional + $total_arus_kas_investasi + $arus_pemasukan_pendanaan_total->total;
    //         // dd(count($arus_pengeluaran_investasi));
            
    //         return view('app.laporan_arus_kas_print',[
    //             'arus_pengeluaran_operasi' => $arus_pengeluaran_operasi,
    //             'arus_pemasukan_operasi' => $arus_pemasukan_operasi,
    //             'arus_pengeluaran_operasi_total' => $arus_pengeluaran_operasi_total,
    //             'arus_pemasukan_operasi_total' => $arus_pemasukan_operasi_total,
    //             'total_arus_kas_operasional' => $total_arus_kas_operasional,
    //             'arus_pengeluaran_investasi' => $arus_pengeluaran_investasi,
    //             'arus_pemasukan_investasi' => $arus_pemasukan_investasi,
    //             'total_arus_kas_investasi' => $total_arus_kas_investasi,
    //             'total_saldo_kas' => $total_saldo_kas,
    //             'arus_pemasukan_pendanaan' => $arus_pemasukan_pendanaan,
    //             'arus_pemasukan_pendanaan_total' => $arus_pemasukan_pendanaan_total
    //         ]);
    //     }
    // }

    // public function laporan_arus_kas_excel(){
    //     return Excel::download(new LaporanArusKasExport, 'Laporan_arus_kas_'.$_GET['tahun'].'.xlsx');
    // }

    // public function laporan()
    // {
    //     if(isset($_GET['kategori'])){
    //         $kategori = Kategori::orderBy('kategori','asc')->get();
    //         if($_GET['kategori'] == ""){
    //             $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
    //             ->whereDate('tanggal','<=',$_GET['sampai'])
    //             ->get();
    //         }else{
    //             $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
    //             ->whereDate('tanggal','>=',$_GET['dari'])
    //             ->whereDate('tanggal','<=',$_GET['sampai'])
    //             ->get();
    //         }
    //         // $transaksi = Transaksi::orderBy('id','desc')->get();
    //         return view('app.laporan',['transaksi' => $transaksi, 'kategori' => $kategori]);
    //     }else{
    //         $kategori = Kategori::orderBy('kategori','asc')->get();
    //         // $transaksi = Transaksi::orderBy('id','desc')->get();
    //         return view('app.laporan',['transaksi' => array(), 'kategori' => $kategori]);
    //     }
    // }

    // public function laporan_print()
    // {       
    //     if(isset($_GET['kategori'])){
    //         $kategori = Kategori::orderBy('kategori','asc')->get();
    //         if($_GET['kategori'] == ""){
    //             $transaksi = Transaksi::whereDate('tanggal','>=',$_GET['dari'])
    //             ->whereDate('tanggal','<=',$_GET['sampai'])
    //             ->get();
    //         }else{
    //             $transaksi = Transaksi::where('kategori_id',$_GET['kategori'])
    //             ->whereDate('tanggal','>=',$_GET['dari'])
    //             ->whereDate('tanggal','<=',$_GET['sampai'])
    //             ->get();
    //         }
    //         // $transaksi = Transaksi::orderBy('id','desc')->get();
    //         return view('app.laporan_print',['transaksi' => $transaksi, 'kategori' => $kategori]);
    //     }
    // }

    // public function laporan_excel()
    // {
    //     return Excel::download(new LaporanExport, 'Laporan.xlsx');
    // }

    // public function user()
    // {
    //     $user = User::all();
    //     return view('app.user',['user' => $user]);
    // }

    // public function user_add()
    // {
    //     return view('app.user_tambah');
    // }

    // public function user_aksi(Request $request)
    // {
    //     $this->validate($request, [
    //         'nama' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|min:5',
    //         'level' => 'required',
    //         'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     // menyimpan data file yang diupload ke variabel $file
    //     $file = $request->file('foto');
        
    //     // cek jika gambar kosong
    //     if($file != ""){
    //         // menambahkan waktu sebagai pembuat unik nnama file gambar
    //         $nama_file = time()."_".$file->getClientOriginalName();

    //         // isi dengan nama folder tempat kemana file diupload
    //         $tujuan_upload = 'gambar/user';
    //         $file->move($tujuan_upload,$nama_file);
    //     }else{
    //         $nama_file = "";
    //     }
 
 
    //     User::create([
    //         'name' => $request->nama,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'level' => $request->level,
    //         'foto' => $nama_file
    //     ]);

    //     return redirect(route('user'))->with('success','User telah disimpan');
    // }

    // public function user_edit($id)
    // {
    //     $user = User::find($id);
    //     return view('app.user_edit', ['user' => $user]);
    // }

    //  public function user_update($id, Request $req)
    // {
    //      $this->validate($req, [
    //         'nama' => 'required',
    //         'email' => 'required|email',
    //         'level' => 'required',
    //         'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $name = $req->input('nama');
    //     $email = $req->input('email');
    //     $password = $req->input('password');
    //     $level = $req->input('level');
        

    //     $user = User::find($id);
    //     $user->name = $name;
    //     $user->email = $email;
    //     if($password != ""){
    //         $user->password = bcrypt($password);
    //     }

    //     // menyimpan data file yang diupload ke variabel $file
    //     $file = $req->file('foto');
        
    //     // cek jika gambar tidak kosong
    //     if($file != ""){
    //         // menambahkan waktu sebagai pembuat unik nnama file gambar
    //         $nama_file = time()."_".$file->getClientOriginalName();

    //         // isi dengan nama folder tempat kemana file diupload
    //         $tujuan_upload = 'gambar/user';
    //         $file->move($tujuan_upload,$nama_file);

    //         // hapus file gambar lama
    //         File::delete('gambar/user/'.$user->foto);

    //         $user->foto = $nama_file;
    //     }
    //     $user->level = $level;
    //     $user->save();

    //     return redirect(route('user'))->with("success","User telah diupdate!");
    // }

    // public function user_delete($id)
    // {
    //     $user = User::find($id);
    //     // hapus file gambar lama
    //     File::delete('gambar/user/'.$user->foto);
    //     $user->delete();

    //     return redirect(route('user'))->with("success","User telah dihapus!");
    // }
}
