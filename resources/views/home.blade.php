@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="content">

      <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-3">
          <div class="media widget-media p-4 bg-white border">
            <div class="icon rounded-circle mr-4 bg-primary">
              <i class="mdi mdi-package-variant-closed text-white "></i>
            </div>
            <div class="media-body align-self-center">
              <h4 class="text-primary mb-2"><?= $stok['barang'] ?></h4>
              <p>Barang</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-3">
          <div class="media widget-media p-4 bg-white border">
            <div class="icon rounded-circle mr-4 bg-danger">
              <i class="mdi mdi-cart-outline text-white "></i>
            </div>
            <div class="media-body align-self-center">
              <h4 class="text-primary mb-2"><?= $stok['pembelian']; ?></h4>
              <p>Pembelian</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-3">
          <div class="media widget-media p-4 bg-white border">
            <div class="icon rounded-circle bg-warning mr-4">
              <i class="mdi mdi-cart-outline text-white "></i>
            </div>
            <div class="media-body align-self-center">
              <h4 class="text-primary mb-2"><?= $stok['penjualan'] ?></h4>
              <p>Penjualan</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-3">
          <div class="media widget-media p-4 bg-white border">
            <div class="icon bg-success rounded-circle mr-4">
              <i class="mdi mdi-database text-white "></i>
            </div>
            <div class="media-body align-self-center">
              <h4 class="text-primary mb-2"><?= $stok['allStok'] ?></h4>
              <p>All Stok</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        
        <div class="col-xl-8 col-md-12">
          <!-- Sales Graph -->
          <div class="card card-default" data-scroll-height="550">
            <div class="card-header">
              <h2>Info grafik 6 bulan terakhir</h2>
            </div>
            <div class="card-body">
              <canvas id="grafik" class="chartjs"></canvas>
            </div>
            <div class="card-footer d-flex flex-wrap bg-white p-0">
              <div class="col-6 px-0">
                <div class="text-center p-4">
                  <h4><?= $stok['stokPembelian'] ?></h4>
                  <p class="mt-2">Pembelian</p>
                </div>
              </div>
              <div class="col-6 px-0">
                <div class="text-center p-4 border-left">
                  <h4><?= $stok['stokPenjualan'] ?></h4>
                  <p class="mt-2">Penjualan</p>
                </div>
              </div>
            </div>
          </div>
        </div>
          
          <div class="col-xl-4 col-md-12">
       
            <div class="card card-table-border-none" data-scroll-height="550">
              <div class="card-header justify-content-between">
                <h2>Stok Limited</h2>
                <div>
                    <a href="{{ route('home') }}" class="text-black-50 mr-2 font-size-20"><i class="mdi mdi-cached"></i></a>
                </div>
              </div>
              <div class="card-body slim-scroll py-0">
                <table class="table ">
                  <tbody>
                  @if(count($limit) > 0)  
                    @foreach ($limit as $row)
                      <tr>
                        <td class="text-dark"><?= $row['nama']; ?></td>
                        <td class="text-center"><?= $row['stok']; ?></td>
                        <td class="text-right"><span class="mb-2 mr-2 badge badge-danger">Limit</span></td>
                      </tr>
                    @endforeach
                  @else
                    <tr><td class="text-center">Tidak ada barang limit</td></tr>
                  @endif
                  </tbody>
                </table>

              </div>
              <div class="card-footer bg-white py-4">
                <a href="{{ route('pembelian.index') }}" class="btn-link py-3 text-uppercase">Ke Pembelian</a>
              </div>
            </div>
          </div>
      </div>

    </div>
</div>
@endsection

@section('javascript')

<script type="text/javascript">
  $(document).ready(function(){

var acquisition3 = document.getElementById("grafik");
if (acquisition3 !== null) {
  var acChart3 = new Chart(acquisition3, {
    // The type of chart we want to create
    type: "bar",

    // The data for our dataset
    data: {
      labels: [
            <?php foreach ($bulan as $key => $value) {
              echo "'".$value['date']."',";
            } ?>
      ],
      datasets: [
        {
          label: "Pembelian",
          backgroundColor: "rgb(76, 132, 255)",
          borderColor: "rgba(76, 132, 255,0)",
          data: [
            <?php foreach ($bulan as $key => $value) {
              echo $value['stok_pembelian'].",";
            }?>
          ],
          pointBackgroundColor: "rgba(76, 132, 255,0)",
          pointHoverBackgroundColor: "rgba(76, 132, 255,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        },
        {
          label: "Penjualan",
          backgroundColor: "rgb(254, 196, 0)",
          borderColor: "rgba(254, 196, 0,0)",
          data: [
           <?php foreach ($bulan as $key => $value) {
              echo $value['stok_penjualan'].",";
            }?>
          ],
          pointBackgroundColor: "rgba(254, 196, 0,0)",
          pointHoverBackgroundColor: "rgba(254, 196, 0,1)",
          pointHoverRadius: 3,
          pointHitRadius: 30
        }
      ]
    },

    // Configuration options go here
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [
          {
            gridLines: {
              display: false
            },
            categoryPercentage: 0.3
          }
        ],
        yAxes: [
          {
           gridLines: {
              drawBorder: true,
              display: true,
              color: "#eee",
              zeroLineColor: "#eee"
            },
            ticks: {
              fontColor: "#8a909d",
              fontFamily: "Roboto, sans-serif",
              display: true,
              beginAtZero: true
            }
          }
        ]
      },
      tooltips: {
        mode: "index",
        titleFontColor: "#888",
        bodyFontColor: "#555",
        titleFontSize: 12,
        bodyFontSize: 15,
        backgroundColor: "rgba(256,256,256,0.95)",
        displayColors: true,
        xPadding: 10,
        yPadding: 7,
        borderColor: "rgba(220, 220, 220, 0.9)",
        borderWidth: 2,
        caretSize: 6,
        caretPadding: 5
      }
    }
  });
 
}

  })
</script>

@endsection
