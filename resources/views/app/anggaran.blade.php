@extends('app.master')

@section('konten')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4">
                    <div class="top d-flex row align-items-center justify-content-between">
                        <h3 class="mt-2 mx-3">Status Anggaran</h3>
                        <div class="top-right">
                            <div class="col p-md-0 mt-2">
                                <ol class="breadcrumb bg-white">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dasbor</a></li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Anggaran</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs card-title" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#terima" role="tab" aria-controls="terima"
                            aria-selected="false">Anggaran Diterima</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tolak" role="tab" aria-controls="tolak"
                            aria-selected="false">Anggaran Ditolak</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#realisasi" data-toggle="tab" role="tab" aria-controls="realisasi" 
                            aria-selected="false">Realisasi Anggaran</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="terima" role="tabpanel" aria-labelledby="home-tab">
                                    @if($anggaranTerimaCount == 0)
                                        <h3>Tidak terdapat data</h3>
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
                                                        <th rowspan="2" class="text-center">STATUS</th>
                                                        @if (Auth::user()->level == 'bendahara')
                                                            <th rowspan="2" class="text-center" width="10%">OPSI</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach($anggaranTerima as $a)
                                                    @if( $a->status != "Realisasi")
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td class="text-center">{{ date('F Y', strtotime($a->bulan )) }}</td>
                                                            <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                            <td class="text-center">{{ $a->keterangan }}</td>
                                                            <td class="text-center">{{ "Rp.".number_format($a->nominal_per_pcs).",-" }}</td>
                                                            <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                            <td class="text-center">{{ "Rp.".number_format($a->nominal_total).",-" }}</td>
                                                            <td class="text-center">{{ $a->status }}</td>
                                                            @if (Auth::user()->level == 'bendahara')
                                                                <td class="text-center">
                                                                    @if($a->status != "Realisasi")
                                                                        <button type="button" title="Realisasikan Anggaran" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEdit_{{ $a->id }}">
                                                                            <i class="fa fa-exchange"></i>
                                                                        </button>

                                                                        <!-- Modal -->
                                                                        <form method="POST" action="{{ route('anggaran.aksi.realisasi',['id' => $a->id]) }}" enctype="multipart/form-data">
                                                                            <div class="modal fade" id="modalEdit_{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="exampleModalLabel">MEREALISASIKAN ANGGARAN</h5>
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                
                                                                
                                                                                            @csrf
                                                                                            {{ method_field('POST') }}
                                                                
                                                                                            <div class="form-group">
                                                                                                <label>Nomor Kwitansi</label>
                                                                                                <input type="text" style="text-transform: uppercase" class="form-control" name="no_kwitansi" autocomplete="off"  placeholder="Masukkan Nomor Kwitansi (Opsional) .." >
                                                                                            </div>
                                                                
                                                                                            <div class="form-group" style="width: 100%;margin-bottom:20px">
                                                                                                <p>Bulan Anggaran yang direncana kan : {{ date('F Y', strtotime($a->bulan )) }}</p>
                                                                                                <label>Tanggal</label>
                                                                                                <input type="text" class="form-control datepicker2 py-0" required="required" name="tanggal" style="width: 100%">
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
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="d-flex justify-content-end align-items-center">
                                                <?php
                                                    $link_limit = 7
                                                ?>
                                                @if($anggaranTerima->lastpage() > 1)
                                                <nav aria-label="Page navigation example">
                                                  <ul class="pagination">
                                                    <li class="page-item {{ ($anggaranTerima->currentPage() == 1) ? ' disabled' : '' }}" title="Halaman Pertama">
                                                      <a class="page-link" href="{{ $anggaranTerima->url(1) }}" aria-label="Previous" >
                                                        <i class="fa fa-fast-backward" aria-hidden="true"></i>
                                                        <span class="sr-only">Previous</span>
                                                      </a>
                                                    </li>
                                                    @for($i = 1; $i <= $anggaranTerima->lastPage(); $i++)
                                                      <?php
                                                        $half_total_links = floor($link_limit / 2);
                                                        $from = $anggaranTerima->currentPage() - $half_total_links;
                                                        $to = $anggaranTerima->currentPage() + $half_total_links;
                                                        if($anggaranTerima->currentPage() < $half_total_links){
                                                          $to += $half_total_links - $anggaranTerima->currentPage();
                                                        }
                                                        if($anggaranTerima->lastPage() - $anggaranTerima->currentPage() < $half_total_links){
                                                          $from -= $half_total_links - ($anggaranTerima->lastPage() - $anggaranTerima->currentPage()) - 1;
                                                        }
                                                      ?>
                                                      @if($from < $i && $i < $to)
                                                        <li class="page-item {{ ($anggaranTerima->currentPage() == $i) ? ' active' : '' }}" title="Halaman {{ $i }}">
                                                          <a class="page-link" href="{{ $anggaranTerima->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                      @endif
                                                    @endfor
                                                    <li class="page-item {{ ($anggaranTerima->currentPage() == $anggaranTerima->lastPage()) ? ' disabled' : '' }}" title="Halaman Terakhir">
                                                      <a class="page-link" href="{{ $anggaranTerima->url($anggaranTerima->lastPage()) }}" aria-label="Next" >
                                                        <i class="fa fa-fast-forward" aria-hidden="true"></i>
                                                        <span class="sr-only">Next</span>
                                                      </a>
                                                    </li>
                                                  </ul>
                                                </nav>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="tolak" role="tabpanel" aria-labelledby="profile-tab">
                                    @if($anggaranTolakCount == 0)
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
                                                        <th rowspan="2" class="text-center">STATUS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach($anggaranTolak as $a)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td class="text-center">{{ date('F Y', strtotime($a->bulan)) }}</td>
                                                            <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                            <td class="text-center">{{ $a->keterangan }}</td>
                                                            <td class="text-center">{{ "Rp.".number_format($a->nominal_per_pcs).",-" }}</td>
                                                            <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                            <td class="text-center">{{ "Rp.".number_format($a->nominal_total).",-" }}</td>
                                                            <td class="text-center">{{ $a->status }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <?php
                                                    $link_limit = 7
                                                ?>
                                                @if($anggaranTolak->lastpage() > 1)
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination">
                                                            <li class="page-item {{ ($anggaranTolak->currentPage() == 1) ? ' disabled' : '' }}" title="Halaman Pertama">
                                                                <a class="page-link" href="{{ $anggaranTolak->url(1) }}" aria-label="Previous" >
                                                                    <i class="fa fa-fast-backward" aria-hidden="true"></i>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                            </li>
                                                            @for($i = 1; $i <= $anggaranTolak->lastPage(); $i++)
                                                                <?php
                                                                    $half_total_links = floor($link_limit / 2);
                                                                    $from = $anggaranTolak->currentPage() - $half_total_links;
                                                                    $to = $anggaranTolak->currentPage() + $half_total_links;
                                                                    if($anggaranTolak->currentPage() < $half_total_links){
                                                                        $to += $half_total_links - $anggaranTolak->currentPage();
                                                                    }
                                                                    if($anggaranTolak->lastPage() - $anggaranTolak->currentPage() < $half_total_links){
                                                                        $from -= $half_total_links - ($anggaranTolak->lastPage() - $anggaranTolak->currentPage()) - 1;
                                                                    }
                                                                ?>
                                                                @if($from < $i && $i < $to)
                                                                    <li class="page-item {{ ($anggaranTolak->currentPage() == $i) ? ' active' : '' }}" title="Halaman {{ $i }}">
                                                                        <a class="page-link" href="{{ $anggaranTolak->url($i) }}">{{ $i }}</a>
                                                                    </li>
                                                                @endif
                                                            @endfor`
                                                            <li class="page-item {{ ($anggaranTolak->currentPage() == $anggaranTolak->lastPage()) ? ' disabled' : '' }}" title="Halaman Terakhir">
                                                            <a class="page-link" href="{{ $anggaranTolak->url($anggaranTolak->lastPage()) }}" aria-label="Next" >
                                                                <i class="fa fa-fast-forward" aria-hidden="true"></i>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="realisasi" role="tabpanel" aria-labelledby="realisasi-tab">
                                    @if($transaksiCount == 0)
                                        <h3>No Data Available</h3>
                                    @else
                                        <div class="table-responsive">
                                            <div class="table table-bordered" id="table-datatable" style="width: 100%">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" class="text-center" width="1%">NO</th>
                                                            <th rowspan="2" class="text-center" width="11%">TANGGAL</th>
                                                            <th rowspan="2" class="text-center">KATEGORI</th>
                                                            <th rowspan="2" class="text-center">KETERANGAN</th>
                                                            <th rowspan="2" class="text-center">PENGELUARAN</th>
                                                            <th rowspan="2" class="text-center">NO KWITANSI</th>
                                                            <th rowspan="2" class="text-center">FOTO KWITANSI</th>
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
                                                                    {{ $t->keterangan }} <br>
                                                                    <b>Detail Keterangan :</b><br>
                                                                    <?php 
                                                                        $anggaranReal = DB::table('anggaran')->where('id', '=', $t->anggaran_id)->first();
                                                                        echo "Harga Satuan Barang : " . "Rp.".number_format($anggaranReal->nominal_per_pcs).",-" . "<br>";
                                                                        echo "Jumlah Barang : " . $anggaranReal->jumlah_barang." pcs";
                                                                    ?>
                                                                @else
                                                                    -
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
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


