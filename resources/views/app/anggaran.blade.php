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
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
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
                                                        @if (Auth::user()->level == 'bendahara')
                                                            <th rowspan="2" class="text-center" width="10%">OPSI</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach($anggaran as $a)
                                                        <tr>
                                                            @if ($a->status != "Tolak")
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
                                                                    </td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                                    @foreach($anggaran as $a)
                                                        <tr>
                                                            @if ($a->status == "Tolak")
                                                                <td class="text-center">{{ $no++ }}</td>
                                                                <td class="text-center">{{ date('F Y', strtotime($a->bulan)) }}</td>
                                                                <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                                <td class="text-center">{{ $a->keterangan }}</td>
                                                                <td class="text-center">{{ "Rp.".number_format($a->nominal_per_pcs).",-" }}</td>
                                                                <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                                <td class="text-center">{{ "Rp.".number_format($a->nominal_total).",-" }}</td>
                                                                <td class="text-center">{{ $a->status }}</td>    
                                                            @endif
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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


