@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">

    <div class="row mb-2 float-left ">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="display: inline-block">Total Cost : </h5>
                <h4 class="card-text" id="smsTotal" style="display: inline-block"> </h4>
            </div>
        </div>
    </div>

    <div class="row mb-2 float-right">
        <form role="form" method="post" action="#" id="dataFilter" class="form-inline pull-right">
            {{ csrf_field() }}
            <div class="col-md-6 col-sm-6">
                <div class="form-group" >
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

    <div class="row col-md-12 col-sm-12 mb-2">
        <div class="row col-md-6 col-sm-6">
            <div id="smsreportsent" style="margin: 0 auto"></div>
        </div>
        <div class="row col-md-6 col-sm-6">
            <div id="smsreportqueued" style="margin: 0 auto"></div>
        </div>
    </div>

    <div class="row col-md-12 col-sm-12">
        <div class="row col-md-6 col-sm-6">
            <div id="smsreportblacklist" style="margin: 0 auto"></div>
        </div>
        <div class="row col-md-6 col-sm-6">
            <div id="smsreportfailed" style="margin: 0 auto"></div>
        </div>
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
            smsrep(data.cost, data.blacklist, data.sent, data.failed, data.queued);
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
            success: function(data ) {
                smsrep(data.cost, data.blacklist, data.sent, data.failed, data.queued);
                $("#smsTotal").html(Number(data.total_sum[0].total).toFixed(2))
                console.log("filter", data)
                $("#dashboard_overlay").hide();
            }
        });
    });

</script>

<script>

function smsrep(data_c, data_b, data_s, data_f, data_q) {

    var xdats = [];  
    var xdatf = [];  
    var xdatq = [];  
    var xdatb = [];  

    data_s.forEach(function(item) {
        xdats.push(item.partner_name);
    });

    data_q.forEach(function(item) {
        xdatq.push(item.partner_name);
    });

    data_f.forEach(function(item) {
        xdatf.push(item.partner_name);
    });

    data_b.forEach(function(item) {
        xdatb.push(item.partner_name);
    });

    data_s = data_s.map(item => {return { partner_name: item.partner_name, y: Number(item.y)}});
    data_c = data_c.map(item => Number(item.total));
    data_f = data_f.map(item => {return {partner_name: item.partner_name, y: Number(item.y)}});
    data_b = data_b.map(item => {return {partner_name: item.partner_name, y: Number(item.y)}});
    data_q = data_q.map(item => {return {partner_name: item.partner_name, y: Number(item.y)}});

    Highcharts.chart('smsreportsent', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Sent SMS Expenditure (month/year)'
        },
        xAxis: {
            categories: xdats
        },
        yAxis: {
            min: 0,
            title: "SMS Expenditure Sent"
        },
        labels: {
            format: "{value:.2f}",    // this stands for showing two decimal places
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                stacking: "normal",
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,.2f}',
                    crop: false,
                    overflow: 'none',
                    inside: false,
                    color: '#000000',
                }
            }
        },
        series: [{
            name: 'Sent',
            data: data_s,
            color: '#4572A7',
        }
        ], 
        tooltip: {
            pointFormat: '<b>{point.y}</b> (KSH)',
        }
    });

    Highcharts.chart('smsreportqueued', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Queued SMS Expenditure (month/year)'
        },
        xAxis: {
            categories: xdatq
        },
        yAxis: {
            min: 0,
            title: "SMS Expenditure Queued",
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                stacking: "normal",
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,.2f}',
                    crop: false,
                    overflow: 'none',
                    inside: false,
                    color: '#000000',
                }
            }
        },
        series: [{
            name: 'Queued',
            data: data_q,
            color: '#DB843D',
        } 
        ], 
        tooltip: {
            pointFormat: '<b>{point.y}</b> (KSH)',
        }
    });

    Highcharts.chart('smsreportblacklist', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Blacklist SMS Expenditure (month/year)'
        },
        xAxis: {
            categories: xdatb
        },
        yAxis: {
            min: 0,
            title: "SMS Expenditure Blacklist"

        },
        labels: {
            format: "{value:.2f}",    // this stands for showing two decimal places
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                stacking: "normal",
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,.2f}',
                    crop: false,
                    overflow: 'none',
                    inside: false,
                    color: '#000000',
                }
            }
        },
        series: [{
            name: 'Blacklist',
            data: data_b,
            color: 'black',
        }
        ], 
        tooltip: {
            pointFormat: '<b>{point.y}</b> (KSH)',
        }
    });

    Highcharts.chart('smsreportfailed', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Failed SMS Expenditure (month/year)'
        },
        xAxis: {
            categories: xdatf
        },
        yAxis: {
            min: 0,
            title: "SMS Expenditure Failed",
            
        },
        labels: {
            format: "{value:.2f}",    // this stands for showing two decimal places
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                stacking: "normal",
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,.2f}',
                    crop: false,
                    overflow: 'none',
                    inside: false,
                    color: '#000000',
                }
            }
        },
        series: [{
            name: 'Failed',
            data: data_f,
            color: '#910000',
        }
        ], 
        tooltip: {
            pointFormat: '<b>{point.y}</b> (KSH)',
        }
    });

}

</script>

@endsection



