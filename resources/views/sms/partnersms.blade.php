@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">

    <div class="row mb-2 float-left ">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="display: inline-block">Total Cost :Ksh. </h5>
                <h5 class="card-text" id="smsTotal" style="display: inline-block"> </h5>
            </div>
        </div>
    </div>

    <div class="row mb-2 float-right">
        <form role="form" method="post" action="#" id="dataFilter" class="form-inline pull-right">
            {{ csrf_field() }}
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="daterange" class="col-form-label"><b>Select Date Range</b></label>
                    <input class="form-control" id="daterange" type="text" name="daterange" />
                </div>
            </div>

            <div class="col-md-4 col-sm-4" style="margin-top: 40px">
                <div class="form-group">
                    <label for="daterange" class="col-form-label"></label>
                    <button type="submit" class="btn btn-warning"><b>Filter SMS</b> <i class="i-Filter"></i></button>
                </div>
            </div>
        </form>
    </div>

    <div class="row col-md-12 col-sm-12">
        <div id="smsreport" style=" width:60%; height: 80%; margin: 0 auto"></div>
        <div id="smsreportpiechart" style="margin: 0 auto; width : 40%"></div>
    </div>

    <div id="dashboard_overlay">
        <img style="  position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;" src="{{url('/images/loader.gif')}}" alt="loader" />

    </div>

</div>


@endsection

@section('page-js')
<script src="{{mix('assets/js/laravel/app.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js">
</script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/bullet.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
    $(function() {
        $('#daterange').daterangepicker({
            "minYear": 2017,
            "autoApply": true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            },
            "startDate": "04/10/2017",
            "endDate": moment().format('MM/DD/YYYY'),
            "opens": "left"
        }, function(start, end, label) {});
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'GET',
        url: "{{ route('sms_report_data') }}",
        success: function(data) {
            console.log("report", data);
            smsrep(data.cost, data.absent_subscriber, data.success, data.delivery_failure, data.breakdown);
            $("#smsTotal").html(Number(data.total_sum[0].total).toFixed(2))
            $("#dashboard_overlay").hide();
        }
    });
    $('#dataFilter').on('submit', function(e) {
        e.preventDefault();
        $("#dashboard_overlay").show();
        let daterange = $('#daterange').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            data: {
                "daterange": daterange
            },
            url: "{{ route('sms_filtered_report_data') }}",
            success: function(data) {
                console.log("report filtered", data);
                smsrep(data.cost, data.absent_subscriber, data.success, data.delivery_failure, data.breakdown);
                $("#smsTotal").html(Number(data.total_sum[0].total).toFixed(2))
                $("#dashboard_overlay").hide();
            }
        });
    });
</script>

<script>
    function smsrep(data, data_as, data_s, data_df, data_br) {

        var xdat = [];
        var xdatp = [];

        data?.forEach(function(item) {
            xdat.push(new Date(item.month).toLocaleString('en-us',{month:'short', year:'numeric'}))

        });

        data_s = data_s?.map(item => Number(item.y));
        data = data?.map(item => Number(item.total));
        data_df = data_df?.map(item => Number(item.y));
        data_as = data_as?.map(item => Number(item.y));

        for (let i = 0; i < data_br?.length; i++) {
            let innerObject = {};
            if (data_br[i].status == 'Success') {
                innerObject.name = 'Success';
                innerObject.y = parseInt(data_br[i].total);
                innerObject.color = '#004D1A';
            } else if (data_br[i].status == 'Failed' && data_br[i].failure_reason == 'UserInBlackList') {
                innerObject.name = 'User In BlackList';
                innerObject.y = parseInt(data_br[i].total);
                innerObject.color = '#ffd500';
            } else if (data_br[i].failure_reason == 'InvalidPhoneNumber') {
                innerObject.name = 'Invalid Phone Number';
                innerObject.y = parseInt(data_br[i].total);
                innerObject.color = '#cc0000';
            } else if (data_br[i].status == 'Failed' && data_br[i].failure_reason == 'DeliveryFailure') {
                innerObject.name = 'Delivery Failure';
                innerObject.y = parseInt(data_br[i].total);
                innerObject.color = '#d3d3d3';
            }
            xdatp.push(innerObject);
        }

        Highcharts.chart('smsreport', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Expenditure of SMS By(month/year)'
            },
            xAxis: {
                categories: xdat,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: "SMS Expenditure"
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    stacking: "normal",
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f}'
                    }
                }
            },
            series: [{
                name: 'Delivery Failure',
                data: data_df
            }, {
                name: 'Blacklist',
                data: data_as
            }, {
                name: 'Success',
                data: data_s
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (KSH)',
            },
        });

        Highcharts.chart('smsreportpiechart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Expenditure Based On Delivery Status'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        connectorColor: 'silver',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Delivery Status',
                data: xdatp
            }]
        });

    }
</script>

@endsection