@extends('app.master')

@section('konten')
    <div class="content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header pt-4 d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Laporan Arus Kas</h3>
                    <div class="header-right">
                      <div class="col p-md-0">
                        <ol class="breadcrumb bg-white">
                          <li class="breadcrumb-item"><a href="javascript:void(0)">Dasbor</a></li>
                          <li class="breadcrumb-item active"><a href="javascript:void(0)">Laporan Arus Kas</a></li>
                        </ol>
                      </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('laporan.arus.kas') }}">
                        @csrf
                        <div class="row">
              
                          <div class="col-lg-offset-2 col-lg-3">
                            <div class="form-group">
                              <label>Tahun</label>
                              <input class="form-control " placeholder="contoh: 2018, 2019, dll" type="year" required="required" name="tahun" value="<?php if(isset($_GET['tahun'])){echo $_GET['tahun'];} ?>">
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <div class="form-group">
                              <input type="submit" class="btn btn-finanz" value="Tampilkan" style="margin-top: 25px">
                            </div>
                          </div>
              
                        </div>
              
                      </form>
                </div>
            </div>

            @if(isset($_GET['tahun']))
                <div class="card">
                    <div class="card-header pt-4">
                        <h3 class="card-title">Laporan Arus Kas</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between">
                            <table style="width: 50%">
                                <tr>
                                    <th width="25%">PER TAHUN</th>
                                    <th width="5%" class="text-center">:</th>
                                    <td>{{ $_GET['tahun'] }}</td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <div class="d-flex flex-column">
                                <a target="_BLANK" href="{{ route('laporan.arus.kas.excel',['tahun' => $_GET['tahun']]) }}" class="btn btn-outline-secondary mb-2"><i class="fa fa-file-excel-o "></i> &nbsp; CETAK EXCEL</a>
                                <a target="_BLANK" href="{{ route('laporan.arus.kas.print',['tahun' => $_GET['tahun']]) }}" class="btn btn-outline-secondary"><i class="fa fa-print "></i> &nbsp; CETAK PRINT</a>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="font-weight-bold">Arus Kas dari Aktivitas Operasional</td>
                                    </tr>
                                    @foreach($arus_pemasukan_operasi as $apm)
                                        <tr>
                                            <td colspan="3">{{ $apm->nama }}</td>
                                            <td>{{ number_format($apm->nominal) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="font-weight-bold">Beban - beban</td>
                                    </tr>
                                    @foreach($arus_pengeluaran_operasi as $app)
                                        <tr>
                                            <td colspan="2">{{ $app->nama }}</td>
                                            <td>{{ "(".number_format($app->nominal).")" }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="border-bottom: 1px solid black;">
                                        <td class="font-weight-bold" colspan="4" style="width: 80%; overflow: hidden;">Arus Kas Bersih dari Aktivitas Operasional</td>
                                        <td class="font-weight-bold">
                                            @if($total_arus_kas_operasional < 0)
                                                {{ "(".number_format($total_arus_kas_operasional * -1).")" }}
                                            @else
                                                {{ number_format($total_arus_kas_operasional) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="font-weight-bold">Arus Kas dari Aktivitas Investasi</td>
                                    </tr>
                                    @if(count($arus_pemasukan_investasi) != 0)
                                        @foreach($arus_pemasukan_investasi as $api)
                                            <tr>
                                                <td colspan="3">{{ $api->nama }}</td>
                                                <td>{{ number_format($api->nominal) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if(count($arus_pengeluaran_investasi) != 0)
                                        @foreach($arus_pengeluaran_investasi as $api)
                                            <tr>
                                                <td colspan="2">{{ $api->nama }}</td>
                                                <td>{{ "(".number_format($api->nominal).")" }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr style="border-bottom: 1px solid black;">
                                        <td class="font-weight-bold" colspan="4" style="width: 80%; overflow: hidden;">Arus Kas Bersih dari Aktivitas Investasi</td>
                                        <td class="font-weight-bold">
                                            @if($total_arus_kas_investasi < 0)
                                                {{ "(".number_format($total_arus_kas_investasi * -1).")" }}
                                            @else
                                                {{ number_format($total_arus_kas_investasi) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="font-weight-bold">Arus Kas dari Aktivitas Pendanaan</td>
                                    </tr>
                                    @foreach($arus_pemasukan_pendanaan as $app)
                                        <tr>
                                            <td colspan="3">{{ $app->nama }}</td>
                                            <td>{{ number_format($app->nominal) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr style="border-bottom: 1px solid black;">
                                        <td class="font-weight-bold" colspan="4" style="width: 80%; overflow: hidden;">Arus Kas Bersih dari Aktivitas Pendanaan</td>
                                        <td class="font-weight-bold">
                                            {{ number_format($arus_pemasukan_pendanaan_total->total) }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid black;">
                                        <td class="font-weight-bold" colspan="4" style="width: 80%; overflow: hidden;">Saldo Kas</td>
                                        <td class="font-weight-bold">
                                            @if($total_saldo_kas < 0)
                                                {{ "(".number_format($total_saldo_kas * -1).")" }}
                                            @else
                                                {{ number_format($total_saldo_kas) }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection