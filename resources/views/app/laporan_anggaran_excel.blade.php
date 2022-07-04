<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
    <title>Laporan Keuangan</title>
</head>
<body>
    <center>
        <h4>LAPORAN ANGGARAN</h4>
    </center>
    <table>
        <tr>
            <td>DARI TANGGAL</td>
            <td>:</td>
            <td>{{ date('d M Y',strtotime($_GET['dari'])) }}</td>
        </tr>
        <tr>
            <td>SAMPAI TANGGAL</td>
            <td>:</td>
            <td>{{ date('d M Y',strtotime($_GET['sampai'])) }}</td>
        </tr>
        <tr>
            <td>KATEGORI</td>
            <td>:</td>
            <td>
                @php
                    $id_kategori = $_GET['kategori'];
                @endphp

                @if($id_kategori == "")
                    @php
                        $kat = "SEMUA KATEGORI";
                    @endphp
                @else
                    @php
                        $katt = DB::table('kategori')->where('id',$id_kategori)->first();
                        $kat = $katt->kategori
                    @endphp
                @endif

                {{$kat}}
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>BULAN</th>
                <th>KATEGORI</th>
                <th>KETERANGAN</th>
                <th>NOMINAL PER PCS</th>
                <th>JUMLAH BARANG</th>
                <th>NOMINAL TOTAL</th>
            </tr>
        </thead>
        <br>
        <tbody>
            @php
                $no = 1;
                $total_anggaran = 0;
            @endphp
            @foreach($anggaran as $a)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ date('F Y', strtotime($a->bulan )) }}</td>
                    <td>{{ $a->kategori->kategori }}</td>
                    <td>{{ $a->keterangan }}</td>
                    <td>{{  "Rp.".number_format($a->nominal_per_pcs).",-" }}</td>
                    <td>{{ $a->jumlah_barang }}</td>
                    <td>
                        {{  "Rp.".number_format($a->nominal_total).",-" }}
                        @php $total_anggaran += $a->nominal_total @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">TOTAL</td>
                <td>{{  "Rp.".number_format($total_anggaran).",-" }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>