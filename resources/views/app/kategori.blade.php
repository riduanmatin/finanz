@extends('app.master')

@section('konten')

<div class="content-body">

  {{-- <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Kategori</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Kategori</a></li>
      </ol>
    </div>

  </div> --}}

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4 d-flex justify-content-between align-items-center">
        <div class="header-left d-flex row align-items-center ">
          <h4 class="mt-2 mr-2">Kategori</h4>
          <button type="button" title="Tambahkan Kategori" class="btn btn-finanz mx-1" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus"></i>
             {{-- &nbsp TAMBAH KATEGORI --}}
          </button>
        </div>
        <div class="header-right">
          <div class="col p-md-0">
            <ol class="breadcrumb bg-white">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Dasbor</a></li>
              <li class="breadcrumb-item active"><a href="javascript:void(0)">Kategori</a></li>
            </ol>
          </div>
        </div>


      </div>
      <div class="card-body pt-0">

        <!-- Modal -->
        <form action="{{ route('kategori.aksi') }}" method="post">
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  @csrf
                  <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama" required="required" class="form-control" placeholder="Nama Kategori ..">
                  </div>
                  <div class="form-group">
                    <label>Jenis Kategori</label>
                    <select class="form-control" name="jenis" required="required">
                      <option value="" >Pilih</option>
                      <option value="Operasional">Operasional</option>
                      <option value="Investasi">Investasi</option>
                      <option value="Pendanaan">Pendanaan</option>
                    </select>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                  <button type="submit" class="btn btn-finanz"><i class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>


        <div class="table-responsive">


          <table class="table table-bordered" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th>NAMA KATEGORI</th>
                <th class="text-center" width="15%">JENIS KATEGORI</th>
                <th class="text-center" width="10%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              @php
              $no = 1;
              @endphp
              @foreach($kategori as $k)
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $k->kategori }}</td>
                <td class="text-center">{{ $k->jenis }}</td>
                <td>

                  @if($k->id != 1)
                  <div class="text-center">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#edit_kategori_{{ $k->id }}">
                      <i class="fa fa-cog"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_kategori_{{ $k->id }}">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                  @endif

                  <form action="{{ route('kategori.update',['id' => $k->id]) }}" method="post">
                    <div class="modal fade" id="edit_kategori_{{$k->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">

                            @csrf
                            {{ method_field('PUT') }}

                            <div class="form-group" style="width:100%">
                              <label>Nama Kategori</label>
                              <input type="hidden" name="id" value="{{ $k->id }}">
                              <input type="text" name="nama" required="required" class="form-control" placeholder="Nama Kategori .." value="{{ $k->kategori }}" style="width:100%">
                            </div>
                            <div class="form-group" style="width:100%">
                              <label>Jenis Kategori</label>
                              <select class="form-control" name="jenis" required="required">
                                <option value="" >Pilih</option>
                                <option {{ ($k->jenis == "Operasional" ? "selected='selected'" : "") }} value="Operasional">Operasional</option>
                                <option {{ ($k->jenis == "Investasi" ? "selected='selected'" : "") }} value="Investasi">Investasi</option>
                                <option {{ ($k->jenis == "Pendanaan" ? "selected='selected'" : "") }} value="Pendanaan">Pendanaan</option>
                              </select>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                            <button type="submit" class="btn btn-finanz"><i class="fa fa-paper-plane m-r-5"></i> Simpan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>

                  <!-- modal hapus -->
                  <form method="POST" action="{{ route('kategori.delete',['id' => $k->id]) }}">
                    <div class="modal fade" id="hapus_kategori_{{$k->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <button type="submit" class="btn btn-finanz"><i class="fa fa-paper-plane m-r-5"></i> Ya, Hapus</button>
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
