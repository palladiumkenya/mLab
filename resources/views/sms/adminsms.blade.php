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

    <div class="row col-md-12 col-sm-12">
        <div id="smsreport" style=" width:70%; height: 80%; margin: 0 auto"></div>
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
            smsrep(data.cost, data.blacklist, data.sent, data.failed);
            $("#smsTotal").html(parseFloat(data.total_sum[0].total).toFixed(2))
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
                smsrep(data.cost, data.blacklist, data.sent, data.failed);
                $("#smsTotal").html(data.total_sum[0].total)
                console.log("filter", data)
                $("#dashboard_overlay").hide();
            }
        });
    });

</script>

<script>

function smsrep(data_c, data_b, data_s, data_f) {

    var xdat = [];  

    data_c.forEach(function(item) {
        xdat.push(item.partner_name);
    });

    console.log("opt", xdat);

    Highcharts.chart('smsreport', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'SMS Expenditure (month/year)'
        },
        xAxis: {
            categories: xdat
        },
        yAxis: {
            title: "SMS Expenditure"
        },
        labels: {
            format: "{value:.2f}",    // this stands for showing two decimal places
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
            }
        },
        series: [{
            name: 'Failed',
            data: data_f
        }, {
            name: 'Blacklist',
            data: data_b
        }, {
            name: 'Sent',
            data: data_s
        }
        ], 
        tooltip: {
            pointFormat: '<b>{point.y}</b> (KSH)',
        },
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });

}

</script>

@endsection



