<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Arus Kas</title>
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
</head>
<style>
    .table-borderless > tbody > tr > td,
    .table-borderless > tbody > tr > th,
    .table-borderless > tfoot > tr > td,
    .table-borderless > tfoot > tr > th,
    .table-borderless > thead > tr > td,
    .table-borderless > thead > tr > th {
        border: none;
    }
</style>
<body>
    <center>
        <h4>Laporan Arus Kas</h4>
        <h4>Per Tahun {{ $_GET['tahun'] }}</h4>
    </center>

    <br>
    <table class="table table-borderless p-4">
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

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>