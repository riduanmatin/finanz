@extends('app.master')

@section('konten')
    <div class="content-body">
        <div class="row page-titles mx-0 mt-2">
            
            <div class="col p-md-0 d-flex flex-column">
                <h3>Anggaran Keuangan</h3>
            </div>
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Anggaran</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4">
                    {{-- <h3 class="card-title">Anggaran Keuangan</h3> --}}
                    <ul class="nav nav-tabs card-title" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                            aria-selected="false">Anggaran Diterima</a>
                        </li>
                        <li class="nav-item active">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                            aria-selected="false">Anggaran Ditolak</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach($anggaran as $a)
                                                        <tr>
                                                            @if ($a->status == "Terima")
                                                                <td class="text-center">{{ $no++ }}</td>
                                                                <td class="text-center">{{ date('M Y', strtotime($a->bulan )) }}</td>
                                                                <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                                <td class="text-center">{{ $a->keterangan }}</td>
                                                                <td class="text-center">{{ $a->nominal_per_pcs }}</td>
                                                                <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                                <td class="text-center">{{ $a->nominal_total }}</td>
                                                                <td class="text-center">{{ $a->status }}</td>    
                                                            @endif
                                                            
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                                                <td class="text-center">{{ date('M Y', strtotime($a->bulan )) }}</td>
                                                                <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                                <td class="text-center">{{ $a->keterangan }}</td>
                                                                <td class="text-center">{{ $a->nominal_per_pcs }}</td>
                                                                <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                                <td class="text-center">{{ $a->nominal_total }}</td>
                                                                <td class="text-center">{{ $a->status }}</td>    
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
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="false">Anggaran Diterima</a>
                    </li>
                    <li class="nav-item active">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">Anggaran Ditolak</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header pt-4">
                                    @if (Auth::user()->level == 'kepala-sekolah')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-plus"></i> &nbsp BUAT RENCANA ANGGARAN
                                        </button>
                                    @endif
                                    <h3 class="card-title">Rencana Anggaran Keuangan</h3>
                                </div>
                                <div class="card-body pt-0">
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
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">{{ date('M Y', strtotime($a->bulan )) }}</td>
                                                        <td class="text-center">{{ $a->kategori->kategori }}</td>
                                                        <td class="text-center">{{ $a->keterangan }}</td>
                                                        <td class="text-center">{{ $a->nominal_per_pcs }}</td>
                                                        <td class="text-center">{{ $a->jumlah_barang }}</td>
                                                        <td class="text-center">{{ $a->nominal_total }}</td>
                                                        <td class="text-center">{{ $a->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Profile</h3>
                    </div>
                </div>
            </div>
        </div> --}}
        
    </div>

@endsection


