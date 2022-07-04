@extends('app.master')

@section('konten')

<div class="content-body">

  {{-- <div class="row page-titles mx-0 mt-2">
    <h3 class="col p-md-0">Anggaran</h3>
    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Rencana Anggaran</a></li>
      </ol>
    </div>
  </div> --}}

  <div class="container-fluid">
    <div class="card">
      <div class="card-header pt-4 d-flex justify-content-between align-items-center">
        <div class="header-left d-flex row align-items-center">
            <h4 class="mt-2 mr-2">Rencana Anggaran</h4>
            @if (Auth::user()->level == 'kepala-sekolah')
            <button type="button" title="Tambahkan Rencana Anggaran" class="btn btn-finanz mx-1" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus"></i>
          </button>
            @endif
        </div>
        <div class="header-right">
            <div class="col p-md-0">
               <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Rencana Anggaran</a></li>
              </ol>
            </div>
            @if($rencana_anggaran_count != 0)
              <div class="input-group mb-3 mr-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                </div>
                <input id="searchbar" onkeyup="searchFunction()" type="text" placeholder="Cari.." name="search">
              </div>
            @endif
        </div>
      </div>
      <div class="card-body pt-0">
        <!-- Modal -->
        <form action="{{ route('anggaran.rencana.aksi') }}" method="post">
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Rencana Anggaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @csrf
                  <div class="form-group">
                    <label>Bulan</label>
                    <input type="month" class="form-control" required="required" name="bulan"  autocomplete="off" placeholder="Masukkan bulan .." value="<?php echo date("Y/m/1") ?>">
                  </div>

                  <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" required="required" name="kategori">
                    <option value="">Pilih</option>
                      @foreach($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->kategori }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" autocomplete="off" placeholder="Masukkan keterangan (Opsional) .."></textarea>
                  </div>

                  <div class="form-group">
                    <label>Nominal Per Pcs</label>
                    <input type="number" class="form-control" required="required" name="nominal_per_pcs" autocomplete="off" placeholder="Masukkan nominal per pcs ..">
                  </div>

                  <div class="form-group">
                    <label>Jumlah Barang</label>
                    <input type="number" class="form-control" required="required" name="jumlah_barang" autocomplete="off" placeholder="Masukkan jumlah pcs ..">
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

        @if($rencana_anggaran_count == 0)
          <h3>No Data Available</h3>
        @else



          <div class="table-responsive">
            <table class="table table-bordered" id="table-datatable" style="width: 100%">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center" width="1%">NO</th>
                  <th rowspan="2" class="text-center" width="11%">BULAN</th>
                  <th rowspan="2" class="text-center">KATEGORI</th>
                  <th rowspan="2" class="text-center">KETERANGAN</th>
                  <th rowspan="2" class="text-center">NOMINAL PER PCS</th>
                  <th rowspan="2" class="text-center">JUMLAH BARANG</th>
                  <th rowspan="2" class="text-center">TOTAL</th>
                  @if (Auth::user()->level == 'kepala-sekolah')
                    <th rowspan="2" class="text-center" width="10%">OPSI</th>
                  @endif
                  @if (Auth::user()->level == 'ketua-yayasan')
                    <th rowspan="2" class="text-center" width="10%">VALIDASI</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach($rencana_anggaran as $ra)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ date('M Y', strtotime($ra->bulan )) }}</td>
                    <td class="text-center">{{ $ra->kategori->kategori }}</td>
                    <td class="text-center">{{ $ra->keterangan }}</td>
                          {{-- <td class="text-center">
                            @if($t->jenis == "Pemasukan")
                            {{ "Rp.".number_format($t->nominal).",-" }}
                            @else
                            {{ "-" }}
                            @endif
                          </td>
                          <td class="text-center">
                            @if($t->jenis == "Pengeluaran")
                            {{ "Rp.".number_format($t->nominal).",-" }}
                            @else
                            {{ "-" }}
                            @endif
                          </td> --}}

                    <td class="text-center">{{ "Rp.".number_format($ra->nominal_per_pcs).",-" }}</td>
                    <td class="text-center">{{ $ra->jumlah_barang }} pcs</td>
                    <td class="text-center">{{ "Rp.".number_format($ra->nominal_total).",-" }}</td>

                    @if (Auth::user()->level == 'kepala-sekolah')
                      <td>
                        <div class="text-center w-100">
                          <button type="button" title="Update" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalEdit_{{ $ra->id }}"><i class="fa fa-pencil"></i></button>
                          <button type="button" title="Delete" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete_{{ $ra->id }}"><i class="fa fa-trash"></i></button> `
                        </div>
                        <!-- Modal -->
                        <form method="POST" action="{{ route('anggaran.rencana.update',['id' => $ra->id]) }}">
                          <div class="modal fade" id="modalEdit_{{ $ra->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit Rencana Anggaran</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  @csrf
                                  {{ method_field('PUT') }}

                                  <div class="form-group" style="width: 100%;margin-bottom:20px">
                                    <label>Bulan</label>
                                    <input type="month" class="form-control" required="required" name="bulan"  autocomplete="off" placeholder="Masukkan bulan .." value="<?php echo date("Y/m/1") ?>" style="width: 95%">
                                  </div>

                                  <div class="form-group" style="width: 100%;margin-bottom:20px">
                                    <label>Kategori</label>
                                    <select class="form-control" required="required" name="kategori" style="width: 95%">
                                    <option value="">Pilih</option>
                                      @foreach($kategori as $k)
                                        <option {{ ($ra->kategori->id == $k->id ? "selected='selected'" : "") }} value="{{ $k->id }}">{{ $k->kategori }}</option>
                                      @endforeach
                                    </select>
                                  </div>

                                  <div class="form-group" style="width: 100%; margin-bottom:20px">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" autocomplete="off" placeholder="Masukkan keterangan (Opsional) .." style="width: 95%">{{ $ra->keterangan }}</textarea>
                                  </div>

                                  <div class="form-group" style="width: 100%; margin-bottom:20px">
                                    <label>Nominal Per Pcs</label>
                                    <input type="number" class="form-control" required="required" name="nominal_per_pcs" autocomplete="off" placeholder="Masukkan nominal per pcs .." value="{{ $ra->nominal_per_pcs }}" style="width: 95%">
                                  </div>

                                  <div class="form-group" style="width: 100%; margin-bottom:20px">
                                    <label>Jumlah Barang</label>
                                    <input type="number" class="form-control" required="required" name="jumlah_barang" autocomplete="off" placeholder="Masukkan jumlah pcs .." style="width: 95%" value="{{ $ra->jumlah_barang }}">
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

                        <!-- Modal -->
                        <form method="POST" action="{{ route('anggaran.rencana.delete',['id' => $ra->id]) }}">
                          <div class="modal fade" id="modalDelete_{{ $ra->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">


                                  @csrf
                                  {{ method_field('DELETE') }}

                                  <p>Apakah anda yakin ingin menghapus data ini?</p>

                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Hapus</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </form>
                      </td>
                    @endif
                    @if (Auth::user()->level == 'ketua-yayasan')
                      <td>
                        <div class="text-center">
                          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAnggaranTerima_{{ $ra->id }}"><i class="fa fa-check"></i></button>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalAnggaranTolak_{{ $ra->id }}"><i class="fa fa-times"></i></button>
                        </div>

                        <!-- Modal Validasi -->
                        <form method="POST" action="{{ route('anggaran.aksi.validasi',['id' => $ra->id]) }}">
                          <div class="modal fade" id="modalAnggaranTerima_{{ $ra->id }}" tabindex="-1" role="dialog" aria-labelledby="modalAnggaranTerimaLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Perhatian</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  @csrf

                                  <p>Apakah anda yakin ingin memvalidasi rencana anggaran ini?</p>

                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Submit</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </form>

                        {{-- Modal Tolak --}}
                        <form method="POST" action="{{ route('anggaran.aksi.tolak',['id' => $ra->id]) }}">
                          <div class="modal fade" id="modalAnggaranTolak_{{ $ra->id }}" tabindex="-1" role="dialog" aria-labelledby="modalAnggaranTolakLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Perhatian</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  @csrf

                                  <p>Apakah anda yakin ingin menolak rencana anggaran ini?</p>

                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ti-close m-r-5 f-s-12"></i> Tutup</button>
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane m-r-5"></i> Submit</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </form>
                      </td>

                    @endif
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  function searchFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchbar");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-datatable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[2];
      td2 = tr[i].getElementsByTagName("td")[1];
      td3 = tr[i].getElementsByTagName("td")[3];
      td4 = tr[i].getElementsByTagName("td")[6];
      if (td || td2 || td3 || td4) {
        txtValue = td.textContent || td.innerText;
        txtValue2 = td2.textContent || td2.innerText;
        txtValue3 = td3.textContent || td3.innerText;
        txtValue4 = td4.textContent || td4.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 || txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
</script>

@endsection
