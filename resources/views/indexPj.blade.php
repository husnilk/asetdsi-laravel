@extends('layouts.master')


<style>
    .toast-title {
    font-weight: bold;
}

.toast-message {
    word-wrap: break-word;
}

.toast-message a,
.toast-message label {
    color: #fff;
}

.toast-message a:hover {
    color: #ccc;
    text-decoration: none;
}

.toast-close-button {
    position: relative;
    right: -0.3em;
    top: -0.3em;
    float: right;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.8;
    filter: alpha(opacity=80);
}

.toast-close-button:hover,
.toast-close-button:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: 0.4;
    filter: alpha(opacity=40);
}

/*
    Additional properties for button version
    iOS requires the button element instead of an anchor tag.
    If you want the anchor version, it requires `href="#"`.
 */
button.toast-close-button {
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
}

.toast-top-center {
    top: 0;
    right: 0;
    width: 100%;
}

.toast-bottom-center {
    bottom: 0;
    right: 0;
    width: 100%;
}

.toast-top-full-width {
    top: 0;
    right: 0;
    width: 100%;
}

.toast-bottom-full-width {
    bottom: 0;
    right: 0;
    width: 100%;
}

.toast-top-left {
    top: 12px;
    left: 12px;
}

.toast-top-right {
    top: 12px;
    right: 12px;
}

.toast-bottom-right {
    right: 12px;
    bottom: 12px;
}

.toast-bottom-left {
    bottom: 12px;
    left: 12px;
}

#toast-container {
    position: fixed;
    z-index: 999999;
}

#toast-container * {
    box-sizing: border-box;
}

#toast-container > div {
    position: relative;
    overflow: hidden;
    margin: 0 0 6px;
    padding: 15px 15px 15px 50px;
    width: 300px;
    border-radius: 3px;
    background-position: 15px center;
    background-repeat: no-repeat;
    transition: box-shadow 0.2s ease-in;
    color: #1A4D2E !important;
    opacity: 0.9;
    filter: alpha(opacity=80);
}

#toast-container > :hover {
    box-shadow: 0 0 12px #000;
    opacity: 1;
    filter: alpha(opacity=100);
    cursor: pointer;
}

#toast-container > .toast::before {
    position: fixed;
    font-family: FontAwesome;
    font-size: 24px;
    line-height: 18px;
    float: left;
    padding-right: 0.5em;
    padding-top: 6px;
    margin: auto 0.5em auto -1.5em;
}

#toast-container > .toast-info::before {
    content: '\f05a';
}

#toast-container > .toast-error::before {
    content: '\f057';
}

#toast-container > .toast-success::before {
    content: '\f058';
}

#toast-container > .toast-warning::before {
    content: '\f06a';
}

#toast-container.toast-top-center > div,
#toast-container.toast-bottom-center > div {
    width: 300px;
    margin: auto;
}

#toast-container.toast-top-full-width > div,
#toast-container.toast-bottom-full-width > div {
    width: 96%;
    margin: auto;
}

.toast {
    background-color: #273138;
    border: 1px solid #313d46;
    border-radius: 4px;
}

.toast-info {
    box-shadow: 0 0 12px #2f96b4;
    background: white !important;
}

/*
    Responsive Design
*/
@media all and (max-width: 240px) {
    #toast-container > div {
        padding: 8px 8px 8px 50px;
        width: 11em;
    }

    #toast-container .toast-close-button {
        right: -0.2em;
        top: -0.2em;
    }
}

@media all and (min-width: 241px) and (max-width: 480px) {
    #toast-container > div {
        padding: 8px 8px 8px 50px;
        width: 18em;
    }

    #toast-container .toast-close-button {
        right: -0.2em;
        top: -0.2em;
    }
}

@media all and (min-width: 481px) and (max-width: 768px) {
    #toast-container > div {
        padding: 15px 15px 15px 50px;
        width: 25em;
    }
}


</style>

@section('title') Dashboard @endsection

@section('css')
    <link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection

    @section('content')
        @component('components.breadcrumb')
            @slot('li_1') Dastone @endslot
            @slot('li_2') Dashboard @endslot
            @slot('li_3') Analytics @endslot
            @slot('title') Analytics @endslot
        @endcomponent

        <div class="row">
            <div class="col-lg-9">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-3">
                        <div class="card report-card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col">
                                        <p class="text-dark mb-0 fw-semibold">Total Peminjaman</p>
                                        <h3 class="m-0">{{ $peminjamanCount }}</h3>
                                        <!-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> New Sessions Today</p> -->
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <div class="report-main-icon bg-light-alt">
                                            <i data-feather="archive" class="align-self-center text-muted icon-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!--end col-->
                    <div class="col-md-6 col-lg-3">
                        <div class="card report-card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col">
                                        <p class="text-dark mb-0 fw-semibold">Total Pengusulan</p>
                                        <h3 class="m-0">{{ $pengusulanCount }}</h3>
                                        <!-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>1.5%</span> Weekly Avg.Sessions</p> -->
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <div class="report-main-icon bg-light-alt">
                                            <i data-feather="folder-plus" class="align-self-center text-muted icon-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!--end col-->
                    <div class="col-md-6 col-lg-3">
                        <div class="card report-card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col">
                                        <p class="text-dark mb-0 fw-semibold">Total Aset Barang</p>
                                        <h3 class="m-0">{{ $inventoryItemCount }}</h3>
                                        <!-- <p class="mb-0 text-truncate text-muted"><span class="text-danger"><i class="mdi mdi-trending-down"></i>35%</span> Bounce Rate Weekly</p> -->
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <div class="report-main-icon bg-light-alt">
                                            <i data-feather="layers" class="align-self-center text-muted icon-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!--end col-->
                    <div class="col-md-6 col-lg-3">
                        <div class="card report-card">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center">
                                    <div class="col">
                                        <p class="text-dark mb-0 fw-semibold">Total bangunan</p>
                                        <h3 class="m-0">{{ $buildingCount }}</h3>
                                        <!-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>10.5%</span> Completions Weekly</p> -->
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <div class="report-main-icon bg-light-alt">
                                            <i data-feather="grid" class="align-self-center text-muted icon-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div> <!--end col-->
                </div><!--end row-->
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Grafik Peminjaman & Pengusulan</h4>
                            </div><!--end col-->
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        This Year<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Today</a>
                                        <a class="dropdown-item" href="#">Last Week</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">This Year</a>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div>  <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="">
                            <div id="chart_grafik_list" class="apex-charts"></div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Chart Asset</h4>
                            </div><!--end col-->
                            <div class="col-auto">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        All<i class="las la-angle-down ms-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Purchases</a>
                                        <a class="dropdown-item" href="#">Emails</a>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div>  <!--end row-->
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="text-center">
                            <div id="peminjaman_chart" class="apex-charts"></div>
                            <!-- <h6 class="bg-light-alt py-3 px-2 mb-0">
                                <i data-feather="calendar" class="align-self-center icon-xs me-1"></i>
                                01 January 2020 to 31 December 2020
                            </h6> -->
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table border-dashed mb-0">
                                <thead>
                                <tr>
                                    <th>Aset</th>
                                    <th class="text-end">Total</th>
                                    <!-- <th class="text-end">Day</th>
                                    <th class="text-end">Week</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Aset Barang</td>
                                    <td class="text-end">{{ $inventoryItemCount }}</td>
                                    <!-- <td class="text-end">-3</td> -->
                                    <!-- <td class="text-end">-12</td> -->
                                </tr>
                                <tr>
                                    <td>Aset bangunan</td>
                                    <td class="text-end">{{ $buildingCount }}</td>
                                    <!-- <td class="text-end">-5</td> -->
                                    <!-- <td class="text-end">-2</td> -->
                                </tr>
                                </tbody>
                            </table><!--end /table-->
                        </div><!--end /div-->
                    </div><!--end card-body-->
                </div><!--end card-->
            </div> <!--end col-->
        </div>


@endsection
@section('script')
        <script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
        <script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
        <script src="{{ URL::asset('assets/js/app.js') }}"></script>
            <script>
            console.log('------------2--4');
             const itemCount= {!! $inventoryItemCount !!};
             const buildingCount= {!! $buildingCount !!};
            console.log('------------2--');

            const assetData =  {!! $monthDataEncode !!};
            const pengusulanData =  {!! $monthDataPengusulanEncode !!};

            console.log('--------------');
            console.log(assetData);
            var options = {
            chart: {
                height: 270,
                type: 'donut',
            }, 
            plotOptions: {
                pie: {
                donut: {
                    size: '85%'
                }
                }
            },
            dataLabels: {
                enabled: false,
            },
            
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            
            series: [itemCount, buildingCount],
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                verticalAlign: 'middle',
                floating: false,
                fontSize: '13px',
                offsetX: 0,
                offsetY: 0,
            },
            labels: [ "Barang","Bangunan" ],
            colors: ["#2a76f4","rgba(42, 118, 244, .5)"],
            
            responsive: [{
                breakpoint: 600,
                options: {
                    plotOptions: {
                        donut: {
                        customScale: 0.2
                        }
                    },        
                    chart: {
                        height: 240
                    },
                    legend: {
                        show: false
                    },
                }
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        // return   val + " %"
                        return val
                    }
                }
            }
            
            }
            
            var chart = new ApexCharts(
            document.querySelector("#peminjaman_chart"),
            options
            );
            
            chart.render();

var options = {
  chart: {
      height: 320,
      type: 'area',
      stacked: true,
      toolbar: {
        show: false,
        autoSelected: 'zoom'
      },
  },
  colors: ['#2a77f4', '#a5c2f1'],
  dataLabels: {
      enabled: false
  },
  stroke: {
      curve: 'smooth',
      width: [1.5, 1.5],
      dashArray: [0, 4],
      lineCap: 'round',
  },
  grid: {
    padding: {
      left: 0,
      right: 0
    },
    strokeDashArray: 3,
  },
  markers: {
    size: 0,
    hover: {
      size: 0
    }
  },
  series: [{
      name: 'Grafik Peminjaman',
      data: assetData,
  },{
      name: 'Grafik Pengusulan',
      data: pengusulanData,
  },
//    {
//       name: 'Unique Visits',
//       data: [0,45,10,75,35,94,40,115,30,105,65,110]
//   }
],

  xaxis: {
      type: 'month',
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      axisBorder: {
        show: true,
      },  
      axisTicks: {
        show: true,
      },                  
  },
  fill: {
    type: "gradient",
    gradient: {
      shadeIntensity: 1,
      opacityFrom: 0.4,
      opacityTo: 0.3,
      stops: [0, 90, 100]
    }
  },
  
  tooltip: {
      x: {
          format: 'dd/MM/yy HH:mm'
      },
  },
  legend: {
    position: 'top',
    horizontalAlign: 'right'
  },
}

var chart = new ApexCharts(
  document.querySelector("#chart_grafik_list"),
  options
);

chart.render();



            </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f78996b4da73604c205e', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('asetdsi-channel');
    channel.bind('peminjamanaset', function(data) {
        toastr.info(JSON.stringify(data.message));
        getNotification();
        
    });
</script>
@endsection