<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laporan Arus Kas</title>
    <link rel="stylesheet" href="{{ asset('asset_admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }} ">
</head>
<body>
    <center>
        <h4>Laporan Arus Kas</h4>
        <h4>Per Tahun {{ $_GET['tahun'] }}</h4>
    </center>
    <br>
    <table>
        <tbody>
            <tr>
                <td colspan="5" >Arus Kas dari Aktivitas Operasional</td>
            </tr>
            @foreach($arus_pemasukan_operasi as $apm)
                <tr>
                    <td colspan="3">{{ $apm->nama }}</td>
                    <td>{{ number_format($apm->nominal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" >Beban - beban</td>
            </tr>
            @foreach($arus_pengeluaran_operasi as $app)
                <tr>
                    <td colspan="2">{{ $app->nama }}</td>
                    <td>{{ "(".number_format($app->nominal).")" }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Arus Kas Bersih dari Aktivitas Operasional</td>
                <td>
                    @if($total_arus_kas_operasional < 0)
                        {{ "(".number_format($total_arus_kas_operasional * -1).")" }}
                    @else
                        {{ number_format($total_arus_kas_operasional) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="5" >Arus Kas dari Aktivitas Investasi</td>
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
            <tr>
                <td colspan="4">Arus Kas Bersih dari Aktivitas Investasi</td>
                <td>
                    @if($total_arus_kas_investasi < 0)
                        {{ "(".number_format($total_arus_kas_investasi * -1).")" }}
                    @else
                        {{ number_format($total_arus_kas_investasi) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="5">Arus Kas dari Aktivitas Pendanaan</td>
            </tr>
            @foreach($arus_pemasukan_pendanaan as $app)
                <tr>
                    <td colspan="3">{{ $app->nama }}</td>
                    <td>{{ number_format($app->nominal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" >Arus Kas Bersih dari Aktivitas Pendanaan</td>
                <td >
                    {{ number_format($arus_pemasukan_pendanaan_total->total) }}
                </td>
            </tr>
            <tr>
                <td colspan="4">Saldo Kas</td>
                <td>
                    @if($total_saldo_kas < 0)
                        {{ "(".number_format($total_saldo_kas * -1).")" }}
                    @else
                        {{ number_format($total_saldo_kas) }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>