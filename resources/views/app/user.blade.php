@extends('app.master')

@section('konten')

<div class="content-body">

  {{-- <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Pengguna</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengguna</a></li>
      </ol>
    </div>

  </div> --}}

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4 d-flex justify-content-between align-items-center">
        <div class="header-left d-flex row align-items-center">
          <h4 class="mt-2 mr-2">Data Pengguna Sistem</h4>
          {{-- <a href="{{ route('user.tambah') }}" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp TAMBAH PENGGUNA</a> --}}
          <button type="button" class="btn btn-finanz mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> &nbsp TAMBAH PENGGUNA</button>
        </div>
        <div class="header-right">
          <div class="col p-md-0">
            <ol class="breadcrumb bg-white">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
              <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengguna</a></li>
            </ol>
          </div>
        </div>

      </div>
      <div class="card-body pt-0">
        <!-- Modal -->
        <form action="{{ route('user.aksi') }}" method="post" enctype="multipart/form-data">
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @csrf

                  <div class="form-group">
                    <div class="form-group has-feedback">
                      <label class="text-dark">Nama</label>
                      <input id="nama" type="text" placeholder="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autocomplete="off">
                      @error('nama')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-group has-feedback">
                      <label class="text-dark">Email</label>
                      <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off">

                      @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-group has-feedback">
                      <label class="text-dark">Level</label>
                      <select class="form-control @error('level') is-invalid @enderror" name="level">
                        <option <?php if(old("level") == "admin"){echo "selected='selected'";} ?> value="admin">Admin</option>
                        <option <?php if(old("level") == "bendahara"){echo "selected='selected'";} ?> value="bendahara">Bendahara</option>
                        <option <?php if(old("level") == "kepala-sekolah"){echo "selected='selected'";} ?> value="kepala-sekolah">Kepala Sekolah</option>
                        <option <?php if(old("level") == "ketua-yayasan"){echo "selected='selected'";} ?> value="ketua-yayasan">Ketua Yayasan</option>
                      </select>
                      
                      @error('level')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="form-group has-feedback">
                      <label class="text-dark">Password</label>
                      <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-group has-feedback">
                      <label class="text-dark">Foto Profil</label>
                      <br>
                      <input id="foto" type="file" placeholder="foto" class="@error('foto') is-invalid @enderror" name="foto" value="{{ old('foto') }}" autocomplete="off">
                      <br>
                      <small class="text-muted"><i>Boleh dikosongkan</i></small>
                      @error('foto')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        {{-- End Modal --}}

    
        <div class="table-responsive">

          <table class="table table-bordered" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th>NAMA</th>
                <th class="text-center">EMAIL</th>
                <th class="text-center">LEVEL</th>
                <th class="text-center" width="10%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              @php
              $no = 1;
              @endphp
              @foreach($user as $u)
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>
                  @if($u->foto == "")
                  <img src="{{ asset('gambar/sistem/user.png') }}" style="width: 30px" class="mr-2">
                  @else
                  <img src="{{ asset('gambar/user/'.$u->foto) }}" style="width: 30px" class="mr-2">
                  @endif


                  {{ $u->name }}
                  @if(Auth::id() == $u->id)
                  <span class="badge badge-primary">Saya</span>
                  @endif
                </td>
                <td class="text-center">{{ $u->email }}</td>
                <td class="text-center">
                  @if($u->level == "admin")
                    Admin
                  @elseif($u->level == "bendahara")
                    Bendahara
                  @elseif($u->level == "ketua-yayasan")
                    Ketua Yayasan
                  @elseif($u->level == "kepala-sekolah")
                    Kepala Sekolah
                  @endif
                  {{-- {{ $u->level }} --}}
                </td>
                <td>    

                  <div class="text-center">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#edit_user_{{ $u->id }}">
                      <i class="fa fa-cog"></i>
                    </button>
                    {{-- <a href="{{ route('user.edit', ['id' => $u->id]) }}" class="btn btn-default btn-sm">
                      <i class="fa fa-cog"></i>
                    </a> --}}

                  @if($u->level != "admin")
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_user_{{ $u->id }}">
                      <i class="fa fa-trash"></i>
                    </button>
                  @endif
                  </div>

                  {{-- modal edit --}}
                  <form method="POST" action="{{ route('user.update', ['id' => $u->id]) }}" enctype="multipart/form-data">
                    <div class="modal fade" id="edit_user_{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            @csrf
                            {{ method_field('PUT') }}

                            <div class="form-group">
                              <div class="form-group has-feedback">
                                <label class="text-dark">Nama</label>
                                <input id="nama" type="text" placeholder="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama', $u->name) }}" autocomplete="off">
                                @error('nama')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
              
                            <div class="form-group">
                              <div class="form-group has-feedback">
                                <label class="text-dark">Email</label>
                                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $u->email) }}" autocomplete="off">
              
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
              
                            <div class="form-group">
                              <div class="form-group has-feedback">
                                <label class="text-dark">Level</label>
                                <select class="form-control @error('level') is-invalid @enderror" name="level">
                                  <option <?php if(old("level", $u->level) == "admin"){echo "selected='selected'";} ?> value="admin">Admin</option>
                                  <option <?php if(old("level", $u->level) == "bendahara"){echo "selected='selected'";} ?> value="bendahara">Bendahara</option>
                                  <option <?php if(old("level", $u->level) == "kepala-sekolah"){echo "selected='selected'";} ?> value="kepala-sekolah">Kepala Sekolah</option>
                                  <option <?php if(old("level", $u->level) == "ketua-yayasan"){echo "selected='selected'";} ?> value="ketua-yayasan">Ketua Yayasan</option>
                                </select>
                                
                                @error('level')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
              
              
                            <div class="form-group">
                              <div class="form-group has-feedback">
                                <label class="text-dark">Password</label>
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                <small class="text-muted"><i>Kosongkan jika tidak ingin mengubah password</i></small>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
              
                            <div class="form-group">
                              <div class="form-group has-feedback">
                                <label class="text-dark">Foto Profil</label>
                                <br>
                                <input id="foto" type="file" placeholder="foto" class="@error('foto') is-invalid @enderror" name="foto" value="{{ old('foto') }}" autocomplete="off">
                                <br>
                                <small class="text-muted"><i>Boleh dikosongkan</i></small>
                                @error('foto')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>

                  <!-- modal hapus -->
                  <form method="POST" action="{{ route('user.delete',['id' => $u->id]) }}">
                    <div class="modal fade" id="hapus_user_{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            <p>Yakin ingin menghapus data ini ?</p>

                            @csrf
                            {{ method_field('DELETE') }}


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Ya, Hapus</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>


                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>





  </div>
  <!-- #/ container -->
</div>

@endsection