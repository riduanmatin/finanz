@extends('app.master')

@section('konten')
    <div class="content-body">
        {{-- <div class="row page-titles mx-0 mt-2">
            
            <div class="col p-md-0 d-flex flex-column">
                <h3>Anggaran</h3>
            </div>
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Anggaran</a></li>
                </ol>
            </div>
        </div> --}}

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
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
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
                                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
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
    </div>

@endsection


