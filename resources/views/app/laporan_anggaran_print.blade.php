<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laporan Anggaran</title>
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
</head>
<body>
    <center>
        <h4>LAPORAN ANGGARAN</h4>
    </center>

    <table style="width: 40%">
        <tr>
            <td width="30%">DARI TANGGAL</td>
            <td width="5%" class="text-center">:</td>
            <td>{{ date('d M Y',strtotime($_GET['dari'])) }}</td>
        </tr>
        <tr>
            <td width="30%">SAMPAI TANGGAL</td>
            <td width="5%" class="text-center">:</td>
            <td>{{ date('d M Y',strtotime($_GET['sampai'])) }}</td>
        </tr>
        <tr>
            <td width="30%">KATEGORI</td>
            <td width="5%" class="text-center">:</td>
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
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" width="1%">NO</th>
                <th rowspan="2" class="text-center" width="11%">BULAN</th>
                <th rowspan="2" class="text-center">KATEGORI</th>
                <th rowspan="2" class="text-center">KETERANGAN</th>
                <th rowspan="2" class="text-center">NOMINAL PER PCS</th>
                <th rowspan="2" class="text-center">JUMLAH BARANG</th>
                <th rowspan="2" class="text-center">NOMINAL TOTAL</th>
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
                    <td class="text-center">{{ date('F Y', strtotime($a->bulan )) }}</td>
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

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>