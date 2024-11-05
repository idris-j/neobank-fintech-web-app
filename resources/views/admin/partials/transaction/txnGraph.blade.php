<div class="col-xl-12">
    <div class="card transaction-card mb-3 mb-lg-5" id="RecentTransactionGraph">
        <!-- Header -->
        <div class="card-header card-header-content-sm-between">
            <h4 class="card-header-title mb-2 mb-sm-0">@lang("Transaction Graph") @if(isset($code)) for {{ $code }}@endif</h4>

            <!-- Nav -->
            <ul class="nav nav-segment nav-fill" id="projectsTab" role="tablist">
                <li class="nav-item this-month" data-bs-toggle="chart" data-datasets="0"
                    data-trigger="click"
                    data-action="toggle">
                    <a class="nav-link active" href="javascript:void(0);"
                       data-bs-toggle="tab">@lang("This Month")</a>
                </li>
                <li class="nav-item" data-bs-toggle="chart" data-datasets="1" data-trigger="click"
                    data-action="toggle">
                    <a class="nav-link" href="javascript:void(0);"
                       data-bs-toggle="tab">@lang("Last Month")</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="card-body">
            <div class="row align-items-sm-center mb-4">
                <div class="col-sm mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <span class="h5 mb-0"> @lang("Transaction:") <span class="transaction_amount"></span> </span>
                    </div>
                </div>
                <!-- End Col -->
                <div class="col-sm-auto">
                    <!-- Legend Indicators -->
                    <div class="row fs-6">
                        <div class="col-auto">
                            <span class="legend-indicator bg-primary"></span> @lang("Transaction")
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->

            <!-- Bar Chart -->
            <div class="chartjs-custom chartjs-height">
                <canvas id="updatingLineChart" data-hs-chartjs-options='{
                      "type": "line",
                      "data": {
                         "labels": @json($statistics['schedule']->keys()),
                         "datasets": [{
                          "backgroundColor": ["rgba(55,125,255, .5)", "rgba(255, 255, 255, .2)"],
                          "borderColor": "#377dff",
                          "borderWidth": 2,
                          "pointRadius": 0,
                          "hoverBorderColor": "#377dff",
                          "pointBackgroundColor": "#377dff",
                          "pointBorderColor": "#fff",
                          "pointHoverRadius": 0,
                          "tension": 0.4
                        },
                        {
                          "backgroundColor": ["rgba(0, 201, 219, .5)", "rgba(255, 255, 255, .2)"],
                          "borderColor": "#00c9db",
                          "borderWidth": 2,
                          "pointRadius": 0,
                          "hoverBorderColor": "#00c9db",
                          "pointBackgroundColor": "#00c9db",
                          "pointBorderColor": "#fff",
                          "pointHoverRadius": 0,
                          "tension": 0.4
                        }]
                      },
                      "options": {
                        "gradientPosition": {"y1": 200},
                         "scales": {
                            "y": {
                              "grid": {
                                "color": "#e7eaf3",
                                "drawBorder": false,
                                "zeroLineColor": "#e7eaf3"
                              },
                              "ticks": {
                                "min": 0,
                                "max": 100,
                                "stepSize": 100,
                                "fontColor": "#97a4af",
                                "fontFamily": "Open Sans, sans-serif",
                                "padding": 10,
                                "postfix": "k"
                              }
                            },
                            "x": {
                              "grid": {
                                "display": false,
                                "drawBorder": false
                              },
                              "ticks": {
                                "fontSize": 12,
                                "fontColor": "#97a4af",
                                "fontFamily": "Open Sans, sans-serif",
                                "padding": 5
                              }
                            }
                        },
                        "plugins": {
                          "tooltip": {
                            "prefix": "{{ basicControl()->currency_symbol }}",
                            "hasIndicator": true,
                            "mode": "index",
                            "intersect": false,
                            "lineMode": true,
                            "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                          }
                        },
                        "hover": {
                          "mode": "nearest",
                          "intersect": true
                        }
                      }
                    }'>
                </canvas>
            </div>
        </div>
    </div>
</div>


