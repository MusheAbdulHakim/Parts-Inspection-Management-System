@extends('layouts.contentLayoutMaster')

@section('title', 'Dashboard')

@section('page-style')
 <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <a href="{{route('users.index')}}"><div class="avatar bg-light-info p-50 mb-1">
                          <div class="avatar-content">
                              <i data-feather="users"></i>
                          </div>
                  </div>
                  </a>
                    <h2 class="fw-bolder">{{$users_count}}</h2>
                    <p class="card-text">Users</p>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <a href="{{route('products.index')}}">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i data-feather="shopping-cart"></i>
                            </div>
                        </div>
                    </a>
                    <h2 class="fw-bolder">{{\App\Models\Product::count()}}</h2>
                    <p class="card-text">Total Products</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <a href="{{route('projects.index')}}">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i data-feather="aperture"></i>
                            </div>
                        </div>
                    </a>
                    <h2 class="fw-bolder">{{\App\Models\Project::count()}}</h2>
                    <p class="card-text">Total Projects</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <a href="{{route('inspections.index')}}">
                        <div class="avatar bg-light-info p-50 mb-1">
                            <div class="avatar-content">
                                <i data-feather="eye"></i>
                            </div>
                        </div>
                    </a>
                    <h2 class="fw-bolder">{{$todayInspections}}</h2>
                    <p class="card-text">Total Inspections Today</p>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChartJS section start -->
<section id="chartjs-chart">

    <div class="row">


        <!-- Weekly Bar Chart Start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">

                    <div class="header-right d-flex align-items-center mt-sm-0 mt-1">
                        Weekly Inspections
                    </div>
                </div>
                <div class="card-body">
                    <canvas class="horizontal-bar-chart-ex chartjs" data-height="600"></canvas>
                </div>
            </div>
        </div>
        <!-- Weekly Bar Chart End -->

        <!-- Yearly Bar Chart End -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-center align-items-sm-center align-items-center">
                    <h3>{{__('Total New Inspections')}}</h3>
                </div>
                <div class="card-body">
                    <canvas class="yearly-bar-chart-ex chartjs" height="300"></canvas>
                </div>
            </div>
        </div>
        <!-- Yearly Bar Chart End -->

    </div>


  </section>
  <!-- ChartJS section end -->
@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
@endsection

@section('page-script')
<script>
    var tooltipShadow = 'rgba(0, 0, 0, 0.25)';
    var grid_line_color = 'rgba(200, 200, 200, 0.2)';
    var labelColor = '#6e6b7b';

    var horizontalBarChartEx = $('.horizontal-bar-chart-ex');
    new Chart(horizontalBarChartEx, {
      type: 'bar',
      options: {
        elements: {
          rectangle: {
            borderWidth: 2,
            borderSkipped: 'right'
          }
        },
        tooltips: {
          // Updated default tooltip UI
          shadowOffsetX: 1,
          shadowOffsetY: 1,
          shadowBlur: 8,
          shadowColor: tooltipShadow,
          backgroundColor: window.colors.solid.white,
          titleFontColor: window.colors.solid.black,
          bodyFontColor: window.colors.solid.black
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration: 500,
        legend: {
          display: false
        },
        layout: {
          padding: {
            bottom: -30,
            left: -25
          }
        },
        scales: {
          xAxes: [
            {
              display: true,
              gridLines: {
                zeroLineColor: grid_line_color,
                borderColor: 'transparent',
                color: grid_line_color
              },
              scaleLabel: {
                display: true
              },
              ticks: {
                min: 1,
                fontColor: labelColor
              }
            }
          ],
          yAxes: [
            {
              display: true,
              gridLines: {
                display: false
              },
              scaleLabel: {
                display: true
              },
              ticks: {
                beginAtZero: true,
                fontColor: labelColor,
                callback: function(value, index, ticks) {
                    if (value % 1 === 0) {return value;}
                }
              }
            }
          ]
        }
      },
      data: {
        labels: ['MON', 'TUE', 'WED ', 'THU', 'FRI', 'SAT', 'SUN'],
        datasets: [
          {
            data: ["{{$mon}}", "{{$tue}}", "{{$wed}}", "{{$thur}}", "{{$fri}}", "{{$sat}}", "{{$sun}}"],
            barThickness: 15,
            backgroundColor: window.colors.solid.info,
            borderColor: 'transparent'
          }
        ]
      }
    });

    var newJobsBarChartEx = $('.yearly-bar-chart-ex');
    new Chart(newJobsBarChartEx, {
      type: 'bar',
      options: {
        elements: {
          rectangle: {
            borderWidth: 2,
            borderSkipped: 'right'
          }
        },
        tooltips: {
          shadowOffsetX: 1,
          shadowOffsetY: 1,
          shadowBlur: 8,
          shadowColor: 'rgba(0, 0, 0, 0.25)',
          backgroundColor: window.colors.solid.white,
          titleFontColor: window.colors.solid.black,
          bodyFontColor: window.colors.solid.black
        },
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration: 500,
        legend: {
          display: false
        },
        layout: {
          padding: {
            bottom: -30,
            left: -25
          }
        },
        scales: {
          xAxes: [
            {
              display: true,
              gridLines: {
                zeroLineColor: 'rgba(200, 200, 200, 0.2)',
                borderColor: 'transparent',
                color: 'rgba(200, 200, 200, 0.2)'
              },
              scaleLabel: {
                display: true
              },
              ticks: {
                min: 0,
                fontColor: '#6e6b7b'
              }
            }
          ],
          yAxes: [
            {
              display: true,
              gridLines: {
                display: false
              },
              scaleLabel: {
                display: true
              },
              ticks: {
                min: 0,
                stepSize: 1,
                fontColor: '#6e6b7b'
              }
            }
          ]
        }
      },
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Total Inspections",
            data: ["{{$months[1]}}", "{{$months[2]}}", "{{$months[3]}}", "{{$months[4]}}",
                "{{$months[5]}}", "{{$months[6]}}", "{{$months[7]}}","{{$months[8]}}","{{$months[9]}}",
                "{{$months[10]}}","{{$months[11]}}","{{$months[12]}}"
            ],
            barThickness: 15,
            backgroundColor: "rgb(142,169,219)",
            hoverBackgroundColor: "rgba(81,117,224,.8)",
            borderColor: "transparent"
          }
        ]
      }
    });
</script>
@endsection
