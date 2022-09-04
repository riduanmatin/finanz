<?php

namespace App\Http\Controllers;

use App\User;
use File;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view()
    {
        $user = User::all();
        return view('app.user',['user' => $user]);
    }

    public function user_add()
    {
        return view('app.user_tambah');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('foto');
        
        // cek jika gambar kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);
        }else{
            $nama_file = "";
        }
 
 
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => $request->level,
            'foto' => $nama_file
        ]);

        return redirect(route('user'))->with('success','User telah disimpan');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('app.user_edit', ['user' => $user]);
    }

     public function update($id, Request $req)
    {
         $this->validate($req, [
            'nama' => 'required',
            'email' => 'required|email',
            'level' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $name = $req->input('nama');
        $email = $req->input('email');
        $password = $req->input('password');
        $level = $req->input('level');
        

        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        if($password != ""){
            $user->password = bcrypt($password);
        }

        // menyimpan data file yang diupload ke variabel $file
        $file = $req->file('foto');
        
        // cek jika gambar tidak kosong
        if($file != ""){
            // menambahkan waktu sebagai pembuat unik nnama file gambar
            $nama_file = time()."_".$file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'gambar/user';
            $file->move($tujuan_upload,$nama_file);

            // hapus file gambar lama
            File::delete('gambar/user/'.$user->foto);

            $user->foto = $nama_file;
        }
        $user->level = $level;
        $user->save();

        return redirect(route('user'))->with("success","User telah diupdate!");
    }

    public function delete($id)
    {
        $user = User::find($id);
        // hapus file gambar lama
        File::delete('gambar/user/'.$user->foto);
        $user->delete();

        return redirect(route('user'))->with("success","User telah dihapus!");
    }
}
