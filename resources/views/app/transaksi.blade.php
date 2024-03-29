@extends('app.master')

@section('konten')

<div class="content-body">

  {{-- <div class="row page-titles mx-0 mt-2">
    <h3 class="col p-md-0">Transaksi</h3>
    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaksi</a></li>
      </ol>
    </div>
  </div> --}}

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4 d-flex justify-content-between align-items-center">
        <div class="header-left d-flex row align-items-center">
            <h4 class="mt-2 mr-2">Transaksi</h4>
            @if (Auth::user()->level == 'bendahara')
            <button type="button" title="Tambahkan Transaksi" class="btn btn-finanz mx-1" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i>
          @endif
        </div>
        <div class ="header-right">
            <div class="col p-md-0">
                <ol class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dasbor</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Transaksi</a></li>
                </ol>
            </div>
            @if($transaksiCount > 1)
              <div class="input-group mb-3 mr-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
                </div>
                <input id="searchbar" onkeyup="searchFunction()" type="text" placeholder="Search.." name="search">
              </div>
            @endif
        </div>
      </div>
      <div class="card-body pt-0">


        <!-- Modal -->
        <form action="{{ route('transaksi.aksi') }}" method="post" enctype="multipart/form-data">
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  @csrf

                  <div class="form-group">
                    <label>Nomor Kwitansi</label>
                    <input type="text" style="text-transform: uppercase" class="form-control" name="no_kwitansi" autocomplete="off" placeholder="Masukkan Nomor Kwitansi (Opsional) ..">
                  </div>

                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control datepicker2" required="required" name="tanggal"  autocomplete="off" placeholder="Masukkan tanggal ..">
                  </div>

                  <div class="form-group">
                    <label>Jenis</label>
                    <select class="form-control" required="required" name="jenis">
                      <option value="">Pilih</option>
                      <option value="Pemasukan">Pemasukan</option>
                      <option value="Pengeluaran">Pengeluaran</option>
                    </select>
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
                    <label>Nominal</label>
                    <input type="number" class="form-control" required="required" name="nominal" autocomplete="off" placeholder="Masukkan nominal ..">
                  </div>

                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="keterangan" autocomplete="off" placeholder="Masukkan keterangan (Opsional) .."></textarea>
                  </div>

                  <div class="form-group">
                    <label>Foto Kwitansi</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" >
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

        @if($transaksiCount == 0)
          <h3>No Data Available</h3>
        @else
          <div class="table-responsive">
            <table class="table table-bordered" id="table-datatable" style="width: 100%">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center" width="1%">NO</th>
                  <th rowspan="2" class="text-center" width="11%">TANGGAL</th>
                  <th rowspan="2" class="text-center">KATEGORI</th>
                  <th rowspan="2" class="text-center">KETERANGAN</th>
                  <th colspan="2" class="text-center">JENIS</th>
                  <th rowspan="2" class="text-center">NO KWITANSI</th>
                  <th rowspan="2" class="text-center">FOTO KWITANSI</th>
                  @if (Auth::user()->level == 'bendahara')
                    <th rowspan="2" class="text-center" width="10%">OPSI</th>
                  @endif
                </tr>
                <tr>
                  <th class="text-center">PEMASUKAN</th>
                  <th class="text-center">PENGELUARAN</th>
                </tr>
              </thead>
              <tbody>
                @php
                $no = 1;
                @endphp
                @foreach($transaksi as $t)
                <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td class="text-center">{{ date('d M Y', strtotime($t->tanggal )) }}</td>
                  <td class="text-center">{{ $t->kategori->kategori }}</td>
                  <td class="text-center">
                    @if($t->keterangan != "")
                      @if($t->anggaran_id != "")
                        {{ $t->keterangan }} <br>
                        <b>Detail Keterangan :</b><br>
                        <?php 
                            $anggaranReal = DB::table('anggaran')->where('id', '=', $t->anggaran_id)->first();
                            echo "Harga Satuan Barang : " . "Rp.".number_format($anggaranReal->nominal_per_pcs).",-" . "<br>";
                            echo "Jumlah Barang : " . $anggaranReal->jumlah_barang." pcs";
                        ?>
                      @else
                        {{ $t->keterangan }}
                      @endif
                    @else
                      -
                    @endif
                  </td>
                  <td class="text-center">
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
                  </td>
                  <td class="text-center">
                    @if($t->no_kwitansi == "")
                      -
                    @else
                      {{ $t->no_kwitansi }}
                    @endif
                  </td>
                  <td class="text-center">
                    @if($t->foto_kwitansi != "")
                      <button type="button" class="btn btn-light" data-toggle="modal" data-target="#imageModal"><i class="fa fa-picture-o"></i></button>

                      <!-- Modal -->
                      <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <!-- Add image inside the body of modal -->
                              <div class="modal-body">
                                  <img id="image" src="{{ asset('gambar/kwitansi_transaksi/'. $t->foto_kwitansi ) }}" alt="Click on button" style="width: 100%"/>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                        </div>
                      </div>
                    @else
                      -
                    @endif
                  </td>
                  @if (Auth::user()->level == 'bendahara')
                    <td>

                      <div class="text-center">
                        <button type="button" title="Update" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalEdit_{{ $t->id }}"><i class="fa fa-pencil"></i></button>
                        <button type="button" title="Delete" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete_{{ $t->id }}"><i class="fa fa-trash"></i></button>
                      </div>

                      <!-- Modal -->
                      <form method="POST" action="{{ route('transaksi.update',['id' => $t->id]) }}" enctype="multipart/form-data">
                        <div class="modal fade" id="modalEdit_{{ $t->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">


                                @csrf
                                {{ method_field('PUT') }}

                                <div class="form-group">
                                  <label>Nomor Kwitansi</label>
                                  <input type="text" class="form-control" name="no_kwitansi" style="text-transform: uppercase" autocomplete="off"  placeholder="Masukkan Nomor Kwitansi (Opsional) .." value="{{ $t->no_kwitansi }}">
                                </div>

                                <div class="form-group" style="width: 100%;margin-bottom:20px">
                                  <label>Tanggal</label>
                                  <input type="text" class="form-control datepicker2 py-0" required="required" name="tanggal" value="{{ $t->tanggal }}" style="width: 100%">
                                </div>

                                <div class="form-group" style="width: 100%;margin-bottom:20px">
                                  <label>Jenis</label>
                                  <select class="form-control py-0" required="required" name="jenis" style="width: 100%">
                                    <option value="">Pilih</option>
                                    <option {{ ($t->jenis == "Pemasukan" ? "selected='selected'" : "") }} value="Pemasukan">Pemasukan</option>
                                    <option {{ ($t->jenis == "Pengeluaran" ? "selected='selected'" : "") }} value="Pengeluaran">Pengeluaran</option>
                                  </select>
                                </div>

                                <div class="form-group" style="width: 100%;margin-bottom:20px">
                                  <label>Kategori</label>
                                  <select class="form-control py-0" required="required" name="kategori" style="width: 100%">
                                    <option value="">Pilih</option>
                                    @foreach($kategori as $k)
                                    <option {{ ($t->kategori->id == $k->id ? "selected='selected'" : "") }}  value="{{ $k->id }}">{{ $k->kategori }}</option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="form-group" style="width: 100%;margin-bottom:20px">
                                  <label>Nominal</label>
                                  <input type="number" class="form-control py-0" required="required" name="nominal" value="{{ $t->nominal }}" style="width: 100%">
                                </div>

                                <div class="form-group" style="width: 100%;margin-bottom:20px">
                                  <label>Keterangan</label>
                                  <textarea class="form-control py-0" name="keterangan"  autocomplete="off" placeholder="Masukkan keterangan (Opsional) .." style="width: 100%">{{ $t->keterangan }}</textarea>
                                </div>

                                <div class="form-group">
                                  <label>Foto Kwitansi</label>
                                  <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" value="{{ $t->foto_kwitansi }}">
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
                      <form method="POST" action="{{ route('transaksi.delete',['id' => $t->id]) }}">
                        <div class="modal fade" id="modalDelete_{{ $t->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
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
                </tr>
                @endforeach
              </tbody>
            </table>
            
            <div class="d-flex justify-content-end align-items-center">
              <?php
                $link_limit = 7;
              ?>
              @if($transaksi->lastpage() > 1)
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item {{ ($transaksi->currentPage() == 1) ? ' disabled' : '' }}" title="Halaman Pertama">
                      <a class="page-link" href="{{ $transaksi->url(1) }}" aria-label="Previous" >
                        <i class="fa fa-fast-backward" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
                    @for($i = 1; $i <= $transaksi->lastPage(); $i++)
                      <?php
                        $half_total_links = floor($link_limit / 2);
                        $from = $transaksi->currentPage() - $half_total_links;
                        $to = $transaksi->currentPage() + $half_total_links;
                        if($transaksi->currentPage() < $half_total_links){
                          $to += $half_total_links - $transaksi->currentPage();
                        }
                        if($transaksi->lastPage() - $transaksi->currentPage() < $half_total_links){
                          $from -= $half_total_links - ($transaksi->lastPage() - $transaksi->currentPage()) - 1;
                        }
                      ?>
                      @if($from < $i && $i < $to)
                        <li class="page-item {{ ($transaksi->currentPage() == $i) ? ' active' : '' }}" title="Halaman {{ $i }}">
                          <a class="page-link" href="{{ $transaksi->url($i) }}">{{ $i }}</a>
                        </li>
                      @endif
                    @endfor
                    <li class="page-item {{ ($transaksi->currentPage() == $transaksi->lastPage()) ? ' disabled' : '' }}" title="Halaman Terakhir">
                      <a class="page-link" href="{{ $transaksi->url($transaksi->lastPage()) }}" aria-label="Next" >
                        <i class="fa fa-fast-forward" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              @endif
              {{-- {{ $transaksi->links() }} --}}
            </div>
          </div>
        @endif


      </div>

    </div>





  </div>
  <!-- #/ container -->
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
