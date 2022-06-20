@extends('app.master')

@section('konten')

<div class="content-body">
    
  <div class="row page-titles mx-0 mt-2">
    <h3 class="col p-md-0">Anggaran Keuangan</h3>
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
        @if (Auth::user()->level == 'kepala-sekolah')
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus"></i> &nbsp BUAT RENCANA ANGGARAN
          </button>
        @endif
        <h3 class="card-title">Rencana Anggaran Keuangan</h3>
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
                        
                  <td class="text-center">{{ $ra->nominal_per_pcs }}</td>
                  <td class="text-center">{{ $ra->jumlah_barang }}</td>
                  <td class="text-center">{{ $ra->nominal_total }}</td>
                  
                  @if (Auth::user()->level == 'kepala-sekolah')
                    <td class="text-center">
                      <div class="text-center">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalEdit_{{ $ra->id }}"><i class="fa fa-cog"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete_{{ $ra->id }}"><i class="fa fa-trash"></i></button> `
                      </div>
                      
                    </td>
                  @endif
                  @if (Auth::user()->level == 'ketua-yayasan')
                    <td class="text-center">
                      <div class="text-center">
                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                        <button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                      </div>
                    </td>
                  @endif
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Kepala Sekolah Membuat anggaran --}}
{{-- Ketua yayasan memvalidasi --}}
{{-- bendahara merealisasikan anggaran --}}

@endsection