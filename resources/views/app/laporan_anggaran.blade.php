@extends('app.master')
@section('konten')
    <div class="content-body">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Laporan Anggaran</h3>
                    <div class="header-right">
                        <div class="col p-md-0">
                            <ol class="breadcrumb bg-white">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Anggaran</a></li>
                            </ol>
                        </div>
                    </div>
                </div>`

                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.anggaran') }}">
                        @csrf
                        <div class="row">
              
                          <div class="col-lg-offset-2 col-lg-3">
                            <div class="form-group">
                              <label>Dari Tanggal</label>
                              <input class="form-control datepicker2" placeholder="Dari Tanggal" type="text" required="required" name="dari" value="<?php if(isset($_GET['dari'])){echo $_GET['dari'];} ?>">
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <div class="form-group">
                              <label>Sampai Tanggal</label>
                              <input class="form-control datepicker2" placeholder="Sampai Tanggal" type="text" required="required" name="sampai" value="<?php if(isset($_GET['sampai'])){echo $_GET['sampai'];} ?>">
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>Kategori</label>
                              <select class="form-control" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($kategori as $k)
                                    <option <?php if(isset($_GET['kategori'])){ if($_GET['kategori'] == $k->id){echo "selected='selected'";} } ?> value="{{ $k->id }}">{{ $k->kategori }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <div class="form-group">
                              <input type="submit" class="btn btn-primary" value="Tampilkan" style="margin-top: 25px">
                            </div>
                          </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>

            @if(isset($_GET['kategori']))
            <div class="card">
                <div class="card-header pt-4">
                    <h3 class="card-title">Laporan Anggaran</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <table style="width: 50%">
                            <tr>
                                <th width="25%">DARI TANGGAL</th>
                                <th width="5%" class="text-center">:</th>
                                <td>{{ date('d-m-Y',strtotime($_GET['dari'])) }}</td>
                            </tr>
                            <tr>
                                <th width="25%">SAMPAI TANGGAL</th>
                                <th width="5%" class="text-center">:</th>
                                <td>{{ date('d-m-Y',strtotime($_GET['sampai'])) }}</td>
                            </tr>
                            <tr>
                                <th width="25%">KATEGORI</th>
                                <th width="5%" class="text-center">:</th>
                                <td>
                                    @php
                                        $id_kategori = $_GET['kategori'];
                                    @endphp
                                    @if($id_kategori == "")
                                        @php
                                            $kat = "SEMUA KATEGORI"
                                        @endphp
                                    @else
                                        @php
                                            $katt = DB::table('kategori')->where('id', $id_kategori)->first();
                                            $kat = $katt->kategori;
                                        @endphp
                                    @endif
                                    {{ $kat }}
                                </td>
                            </tr>
                        </table>
    
                        <div class="d-flex flex-column" style="width: 15%">
                            <a target="_BLANK" href="{{ route('laporan.anggaran.excel',['kategori' => $_GET['kategori'], 'dari' => $_GET['dari'], 'sampai' => $_GET['sampai']]) }}" class="btn btn-outline-secondary mb-2"><i class="fa fa-file-excel-o "></i> &nbsp; CETAK EXCEL</a>
                            <a target="_BLANK" href="{{ route('laporan.anggaran.print',['kategori' => $_GET['kategori'], 'dari' => $_GET['dari'], 'sampai' => $_GET['sampai']]) }}" class="btn btn-outline-secondary"><i class="fa fa-print "></i> &nbsp; CETAK PRINT</a>
                        </div>
                        
                    </div>
                    <br>
                    <br>
                    <br>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center" width="1%">NO</th>
                                    <th rowspan="2" class="text-center" width="11%">BULAN</th>
                                    <th rowspan="2" class="text-center">KATEGORI</th>
                                    <th rowspan="2" class="text-center">KETERANGAN</th>
                                    <th rowspan="2" class="text-center">NOMINAL PER PCS</th>
                                    <th rowspan="2" class="text-center">JUMLAH BARANG</th>
                                    <th rowspan="2" class="text-center">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $total_anggaran = 0;
                                @endphp
                                @foreach($anggaran as $a)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-center">{{ date('M Y', strtotime($a->bulan )) }}</td>
                                            <td class="text-center">{{ $a->kategori->kategori }}</td>
                                            <td class="text-center">{{ $a->keterangan }}</td>
                                            <td class="text-center">{{ "Rp.".number_format($a->nominal_per_pcs).",-" }}</td>
                                            <td class="text-center">{{ $a->jumlah_barang }}</td>
                                            <td class="text-center">
                                                {{ "Rp.".number_format($a->nominal_total).",-" }}
                                                @php $total_anggaran += $a->nominal_total @endphp
                                            </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-info text-white font-weight-bold">
                                <tr>
                                    <td colspan="6" class="text-bold text-center">TOTAL</td>
                                    <td class="text-center">{{ "Rp.".number_format($total_anggaran).",-" }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
    
@endsection