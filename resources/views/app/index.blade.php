@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="container-fluid mt-3">
    <div class="d-flex row justify-content-center">
      {{-- Total Anggaran dan Rencana Anggaran --}}
      <div class="col-lg-3 col-sm-6">
        <div id="carouselCount" class="card bg-white carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card-body">
                <h3 class="card-title text-black-50">Total Rencana Anggaran</h3>
                <div class="d-inline-block">
                  <h3 class="text-warning">{{ $total_rencana_anggaran->total }}</h3>
                  <p class="text-black-50 mb-0">Buah</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Total Anggaran</h3>
                <div class="d-inline-block">
                  <h3 class="text-warning">{{ $total_anggaran->total }}</h3>
                  <p class="text-black-50 mb-0">Buah</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Anggaran yang Diterima</h3>
                <div class="d-inline-block">
                  <h3 class="text-warning">{{ $total_anggaran_terima->total }}</h3>
                  <p class="text-black-50 mb-0">Buah</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Anggaran yang Ditolak</h3>
                <div class="d-inline-block">
                  <h3 class="text-warning">{{ $total_anggaran_tolak->total }}</h3>
                  <p class="text-black-50 mb-0">Buah</p>
                </div>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselCount" role="button" data-slide="prev">
            <span class="fa fa-chevron-left text-dark" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselCount" role="button" data-slide="next">
            <span class="fa fa-chevron-right text-dark" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>


      {{-- anggaran --}}
      @if(Auth::user()->level != 'admin')
        <div class="col-lg-3 col-sm-6">
          <div class="card bg-white">
            <div class="card-body">
              <h3 class="card-title text-black-50">Total Anggaran 3 Bulan</h3>
              <div class="d-inline-block">
                <div class="row mx-auto">
                  <h3 class="text-warning">Rp</h3>
                  <h3 class="text-dark"> {{ ". ".number_format($anggaran_3_bulan->total)." ,-" }}</h3>
                </div>
                <p class="text-black-50 mb-0">{{ date('M') }} - {{ $bulan_2->bulan }}</p>
              </div>
            </div>
          </div>
        </div>
      @endif
      

      {{-- carousel pemasukan --}}
      <div class="col-lg-3 col-sm-6">
        <div id="carouselPemasukan" class="card bg-white carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pemasukan Hari Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pemasukan_hari_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('d-m-Y') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pemasukan Bulan Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pemasukan_bulan_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('M') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pemasukan Tahun Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pemasukan_tahun_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('Y') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Seluruh Pemasukan</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($seluruh_pemasukan->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">Semua</p>
                </div>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselPemasukan" role="button" data-slide="prev">
            <span class="fa fa-chevron-left text-dark" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselPemasukan" role="button" data-slide="next">
            <span class="fa fa-chevron-right text-dark" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      {{-- </div> --}}

      {{-- carousel pengeluaran --}}

      {{-- <div class="row"> --}}
      <div class="col-lg-3 col-sm-6">
        <div id="carouselPengeluaran" class="card bg-white carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pengeluaran Hari Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pengeluaran_hari_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('d-m-Y') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pengeluaran Bulan Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pengeluaran_bulan_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('M') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Pengeluaran Tahun Ini</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($pengeluaran_tahun_ini->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">{{ date('Y') }}</p>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="card-body">
                <h3 class="card-title text-black-50">Seluruh Pengeluaran</h3>
                <div class="d-inline-block">
                  <div class="row mx-auto">
                    <h3 class="text-warning">Rp</h3>
                    <h3 class="text-dark"> {{ ". ".number_format($seluruh_pengeluaran->total)." ,-" }}</h3>
                  </div>
                  <p class="text-black-50 mb-0">Semua</p>
                </div>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselPengeluaran" role="button" data-slide="prev">
            <span class="fa fa-chevron-left text-dark" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselPengeluaran" role="button" data-slide="next">
            <span class="fa fa-chevron-right text-dark" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>

    <div class="row">

      <style type="text/css">
        .card-grafik canvas{
          width: 100% !important;
          position: relative !important;
          height: auto !important;
        }
      </style>

      <section class="col-lg-6">

        <div class="card card-grafik">
          <div class="card-header pt-4">
            <h5 class="card-title">Grafik Keuangan <b>Per Bulan</b> Di Tahun Ini</h5>
          </div>
          <div class="card-body">

            <canvas id="grafik1"></canvas>

          </div>
        </div>

      </section>


      <section class="col-lg-6">

        <div class="card card-grafik">
          <div class="card-header pt-4">
            <h5 class="card-title">Grafik Keuangan <b>Per Tahun</b></h5>
          </div>
          <div class="card-body">

           <canvas id="grafik2"></canvas>

         </div>
       </div>

     </section>

     {{-- carousel grafik --}}

    

     <section class="col-lg-12">

      <div class="card card-grafik">
        <div class="card-header pt-4">
          <h5 class="card-title">Grafik Keuangan <b>Per Hari</b> Di Bulan Ini</h5>
        </div>
        <div class="card-body">

          <div style="overflow-x: scroll;">
            <canvas id="grafik3"></canvas>
          </div>

        </div>
      </div>

      </section>

      <section class="col-lg-12">

        <div class="card card-grafik">
          <div class="card-header pt-4">
            <h5 class="card-title">Grafik Keuangan <b>Per Kategori</b> Bulan Ini</h5>
          </div>
          <div class="card-body">

          <canvas id="grafik4"></canvas>

          </div>
        </div>

      </section>
    </div>
  </div>
<!-- #/ container -->
</div>



<script>
  var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

  var barChartData = {
    labels : ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
    datasets : [
    {
      label: 'Pemasukan',
      // fillColor : "rgba(51, 240, 113, 0.61)",
      // strokeColor : "rgba(11, 246, 88, 0.61)",
      fillColor : "rgba(255,131,3,1)",
      strokeColor : "rgba(255,131,3,1)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      <?php
      for($bulan=1;$bulan<=12;$bulan++){
        $tahun = date('Y');
        $pemasukan_perbulan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereMonth('tanggal',$bulan)
        ->whereYear('tanggal',$tahun)
        ->first();
        $total = $pemasukan_perbulan->total;
        if($pemasukan_perbulan->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }
      }
      ?>
      ]
    },
    {
      label: 'Pengeluaran',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(151,187,205,1)",
      data : [
      <?php
      for($bulan=1;$bulan<=12;$bulan++){
        $tahun = date('Y');
        $pengeluaran_perbulan = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereMonth('tanggal',$bulan)
        ->whereYear('tanggal',$tahun)
        ->first();
        $total = $pengeluaran_perbulan->total;
        if($pengeluaran_perbulan->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }
      }
      ?>
      ]
    }
    ]

  }




  var barChartData2 = {
    labels : [
    <?php 
    $thn2 = DB::table('transaksi')
    ->select(DB::raw('year(tanggal) as tahun'))
    ->distinct()
    ->orderBy('tahun','asc')
    ->get();
    foreach($thn2 as $t){
      ?>
      "<?php echo $t->tahun; ?>",
      <?php 
    }
    ?>
    ],
    datasets : [
    {
      label: 'Pemasukan',
      // fillColor : "rgba(51, 240, 113, 0.61)",
      // strokeColor : "rgba(11, 246, 88, 0.61)",
      fillColor : "rgba(255,131,3,1)",
      strokeColor : "rgba(255,131,3,1)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      <?php
      foreach($thn2 as $t){
        $thn = $t->tahun;
        $tahun = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereYear('tanggal',$thn)
        ->first();
        $total = $tahun->total;
        if($tahun->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }

      }
      ?>
      ]
    },
    {
      label: 'Pengeluaran',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(254, 29, 29, 0)",
      data : [
      <?php
      foreach($thn2 as $t){
        $thn = $t->tahun;
        $tahun = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereYear('tanggal',$thn)
        ->first();
        $total = $tahun->total;
        if($tahun->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }

      }
      ?>
      ]
    }
    ]

  }

  var barChartData3 = {
    <?php
    $dateBegin = strtotime("first day of this month");  
    $dateEnd = strtotime("last day of this month");

    $awal = date("Y-m-d", $dateBegin);         
    $akhir = date("Y-m-d", $dateEnd);
    ?>
    labels : [
    <?php 
    for($a=$awal;$a<=$akhir;$a++){
      ?>
      "<?php echo date('d-m-Y',strtotime($a)) ?>",
      <?php 
    }
    ?>
    ],
    datasets : [
    {
      label: 'Pemasukan',
      // fillColor : "rgba(51, 240, 113, 0.61)",
      // strokeColor : "rgba(11, 246, 88, 0.61)",
      fillColor : "rgba(255,131,3,1)",
      strokeColor : "rgba(255,131,3,1)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      <?php 
      for($a=$awal;$a<=$akhir;$a++){
        $tgl = $a;
        $pemasukan_perhari = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pemasukan')
        ->whereDate('tanggal',$tgl)
        ->first();
        $total = $pemasukan_perhari->total;
        if($pemasukan_perhari->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }
      }
      ?>
      ]
    },{
      label: 'Pengeluaran',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(254, 29, 29, 0)",
      data : [
      <?php 
      for($a=$awal;$a<=$akhir;$a++){
        $tgl = $a;
        $pemasukan_perhari = DB::table('transaksi')
        ->select(DB::raw('SUM(nominal) as total'))
        ->where('jenis','Pengeluaran')
        ->whereDate('tanggal',$tgl)        ->first();
        $total = $pemasukan_perhari->total;
        if($pemasukan_perhari->total == ""){
          echo "0,";
        }else{
          echo $total.",";
        }

      }
      ?>
      ]
    }
    ]

  }


  var barChartData4 = {
    labels : [
    @foreach($kategori as $k)
    "{{ $k->kategori }}",
    @endforeach
    ],
    datasets : [
    {
      label: 'Pemasukan',
      // fillColor : "rgba(51, 240, 113, 0.61)",
      // strokeColor : "rgba(11, 246, 88, 0.61)",
      fillColor : "rgba(255,131,3,1)",
      strokeColor : "rgba(255,131,3,1)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      @foreach($kategori as $k)
      <?php 
      $id_kategori = $k->id;
      $pemasukan_perkategori = DB::table('transaksi')
      ->select(DB::raw('SUM(nominal) as total'))
      ->where('jenis','Pemasukan')
      ->where('kategori_id',$id_kategori)
      ->first();
      $total = $pemasukan_perkategori->total;
      if($pemasukan_perkategori->total == ""){
        echo "0,";
      }else{
        echo $total.",";
      }
      ?>
      @endforeach
      ]
    },{
      label: 'Pengeluaran',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(254, 29, 29, 0)", 
      data : [
      @foreach($kategori as $k)
      <?php 
      $bln = date('m');
      $id_kategori = $k->id;
      $pemasukan_perkategori = DB::table('transaksi')
      ->select(DB::raw('SUM(nominal) as total'))
      ->where('jenis','Pengeluaran')
      ->where('kategori_id',$id_kategori)
      ->whereMonth('tanggal',$bln)
      ->first();
      $total = $pemasukan_perkategori->total;
      if($pemasukan_perkategori->total == ""){
        echo "0,";
      }else{
        echo $total.",";
      }
      ?>
      @endforeach
      ]
    }
    ]

  }



  window.onload = function(){
    var ctx = document.getElementById("grafik1").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData, {
     responsive : true,
     animation: true,
     barValueSpacing : 5,
     barDatasetSpacing : 1,
     tooltipFillColor: "rgba(0,0,0,0.8)",
     multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
   });

    var ctx = document.getElementById("grafik2").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData2, {
     responsive : true,
     animation: true,
     barValueSpacing : 5,
     barDatasetSpacing : 1,
     tooltipFillColor: "rgba(0,0,0,0.8)",
     multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
   });

    var ctx = document.getElementById("grafik3").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData3, {
     responsive : true,
     animation: true,
     barValueSpacing : 5,
     barDatasetSpacing : 1,
     tooltipFillColor: "rgba(0,0,0,0.8)",
     multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
   });

    var ctx = document.getElementById("grafik4").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData4, {
     responsive : true,
     animation: true,
     barValueSpacing : 5,
     barDatasetSpacing : 1,
     tooltipFillColor: "rgba(0,0,0,0.8)",
     multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
   });

  }





</script>

@endsection