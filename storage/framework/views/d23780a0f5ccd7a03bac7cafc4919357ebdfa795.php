<?php $__env->startSection('page-css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
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
            <?php echo e(csrf_field()); ?>

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
        <div id="smsreportcountysent" style="margin: 0 auto; width : 80%"></div>
        <div id="smsreportsent" style="margin: 0 auto; width : 80%"></div>
        <div id="smsreportnonpartnersent" style="margin: 0 auto; width : 80%"></div>
        <div id="smsreportfailed" style="margin: 0 auto; width : 80%"></div>
    </div>

    <div id="dashboard_overlay">
        <img style="  position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;" src="<?php echo e(url('/images/loader.gif')); ?>" alt="loader" />

    </div>

</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>
<script src="<?php echo e(mix('assets/js/laravel/app.js')); ?>"></script>
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
        url: "<?php echo e(route('sms_report_data')); ?>",
        success: function(data) {
            console.log("report", data);
            smsrep(data.cost, data.success, data.absent_subscriber, data.delivery_failure);
            smsrep_nonpartner(data.successNonPartner, data.successPerCounty);
            $("#smsTotal").html(Number(data.total_sum[0].total))
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
            url: "<?php echo e(route('sms_filtered_report_data')); ?>",
            success: function(data) {
                smsrep(data.cost, data.success, data.absent_subscriber, data.delivery_failure);
                smsrep_nonpartner(data.successNonPartner, data.successPerCounty);
                $("#smsTotal").html(Number(data.total_sum[0].total).toFixed(2))
                console.log("filter", data)
                $("#dashboard_overlay").hide();
            }
        });
    });
</script>

<script>
    function smsrep(data_c, data_s, data_as, data_df) {

        var xdats = [];
        var xdatf = [];
        var xdatq = [];
        var xdatb = [];

        data_s?.forEach(function(item) {
            if (item.partner_name === null) {
                xdats.push('Not Specified')
            } else {
                xdats.push(item.partner_name)
            }
        });

        data_as?.forEach(function(item) {
            xdatq.push(item.month);
        });

        data_df?.forEach(function(item) {
            xdatf.push(item.month);
        });

        data_s = data_s?.map(item => {
            if (item.partner_name === null) {
                return {
                    partner_name: 'Not Specified',
                    y: Number(item.y)
                };
            } else {
                return {
                    partner_name: item.partner_name,
                    y: Number(item.y)
                };
            }
        });

        data_c = data_c?.map(item => Number(item.total));
        data_as = data_as?.map(item => Number(item.y));
        data_df = data_df?.map(item => Number(item.y));

        Highcharts.chart('smsreportsent', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Expenditure of Successful SMS By Partner'
            },
            xAxis: {
                categories: xdats
            },
            yAxis: {
                min: 0,
                title: "Successful SMS Cost"
            },
            labels: {
                format: "{value:.0f}", // this stands for showing two decimal places
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    stacking: "normal",
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f}',
                        crop: false,
                        overflow: 'none',
                        inside: false,
                        color: '#000000',
                    }
                }
            },
            series: [{
                name: 'Partners',
                data: data_s,
                color: '#4572A7',
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (KSH)',
            }
        });

        Highcharts.chart('smsreportfailed', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Expenditure of Delivery Failure SMS(month/year)'
            },
            xAxis: {
                title:{
                    text: "Year-Month"
                },
                categories: xdatq
            },
            yAxis: {
                min: 0,
                title: "Failed SMS Cost",
                title:{
                    text: "Failed SMS Cost"
                },
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    stacking: "normal",
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f}',
                        crop: false,
                        overflow: 'none',
                        inside: false,
                        color: '#000000',
                    }
                }
            },
            series: [{
                name: 'Delivery Failure',
                data: data_df,
                color: '#DB843D',
                dataSorting: {
                    enabled: false,
                    sortKey: 'y'
                }
            }, {
                name: 'Blacklist Users',
                data: data_as,
                color: '#910000',
            }, ],
            tooltip: {
                pointFormat: '<b>{point.y}</b>, <b>{series.userOptions.name}</b>, (KSH)',
            }
        });

    }

    function smsrep_nonpartner(data, data1) {

        var xdats = [];
        var xdats1 = [];

        data?.forEach(function(item) {
            if (item.month === null) {
                xdats.push('Not Specified');
            } else {
                xdats.push(item.month);
            }
        });

        data1?.forEach(function(item) {
            if (item.county === null) {
                xdats1.push('Not Specified');
            } else {
                xdats1.push(item.county);
            }
        });

        console.log("months", xdats1);

        data = data?.map(item => Number(item.y));
        data1 = data1?.map(item => Number(item.y));

        Highcharts.chart('smsreportcountysent', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Expenditure of SMS Successful Per County'
            },
            xAxis: {
                categories: xdats1
            },
            yAxis: {
                min: 0,
                title: "Successful SMS Cost"
            },
            labels: {
                format: "{value:.0f}", // this stands for showing two decimal places
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    stacking: "normal",
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f}',
                        crop: false,
                        overflow: 'none',
                        inside: false,
                        color: '#000000',
                    }
                }
            },
            series: [{
                name: 'Counties',
                data: data1,
                color: '#90ed7d',
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (KSH)',
            }
        });

        Highcharts.chart('smsreportnonpartnersent', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Expenditure of Successful SMS By Non Partners'
            },
            xAxis: {
                categories: xdats
            },
            yAxis: {
                min: 0,
                title: "Successful SMS Cost"
            },
            labels: {
                format: "{value:.0f}", // this stands for showing two decimal places
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                    stacking: "normal",
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:,.0f}',
                        crop: false,
                        overflow: 'none',
                        inside: false,
                        color: '#000000',
                    }
                }
            },
            series: [{
                name: 'Non Partners',
                data: data,
                color: '#90ed7d',
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (KSH)',
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>