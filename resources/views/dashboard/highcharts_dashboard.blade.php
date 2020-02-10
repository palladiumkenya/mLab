@extends('layouts.master')
@section('main-content')

<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12">
    <form role="form" method="post" action="#" id="dataFilter">
        {{ csrf_field() }}
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for=" partners" class="col-form-label"><b>Select Partner(s)</b></label>
                    <select class=" partners form-control selectpicker" id="partners" name="partners[]" multiple
                        data-live-search="true">

                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for=" counties" class="col-form-label"><b>Select County(s)</b></label>
                    <select class=" counties form-control selectpicker" id="counties" name="counties[]" multiple
                        data-live-search="true">

                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="subcounties" class="col-form-label"><b>Select Sub-County(s)</b></label>
                    <select class=" subcounties form-control selectpicker" id="subcounties" name="subcounties[]"
                        multiple data-live-search="true">

                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="facilities" class="col-form-label"><b>Select Facility(s)</b></label>
                    <select class="facilities form-control selectpicker" id="facilities" name="facilities[]" multiple
                        data-live-search="true">

                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="daterange" class="col-form-label"><b>Select Date Range</b></label>
                    <input class="form-control" id="daterange" type="text" name="daterange" />
                </div>
            </div>
        </div>
    </form>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Mailbox-Full"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">All Results</p>
                        <p id="all_records" class="text-primary text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Hospital1"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Facilities </p>
                        <p id="all_facilities" class="text-primary text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Globe"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Counties </p>
                        <p id="county_numbers" class="text-primary text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-People-on-Cloud"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Partners </p>
                        <p id="partner_numbers" class="text-primary text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-success o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Mail-Read"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Pulled Results</p>
                        <p id="sent_records" class="text-success text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-warning o-hidden mb-4">
                <div class="card-body text-center">
                    <i class="i-Mail-Unread"></i>
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Unpulled Results </p>
                        <p id="unsent_records" class="text-warning text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col">
            <div id="vlEIDNumbers" class="row"></div>
            <div id="tats" class="row">
                <div id="tateid"></div>
                <div id="tatvl"></div>
            </div>

        </div>

        <div class="col" id="viralSuppression">

        </div>
        <div class="col" id="eidPositivity">

        </div>
    </div>

    <div class="row" id="map"></div>
</div>
<div id="dashboard_overlay">
    <img style="  position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;" src="{{url('/images/loader.gif')}}" alt="loader" />

</div>

<div id="FirstModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-md-12">

                    <form role="form" method="post" action="{{route('changepass')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">

                            <div class="form-group col-md-12">
                                <label for="new_password" class="col-sm-2 control-label ">New Password </label>
                                <div class="col-sm-10">
                                    <input type="password" pattern=".{6,20}" required
                                        title="password requires more than 6 characters"
                                        class="form-control new_password password" name="new_password" id="new_password"
                                        placeholder="New Password... ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="confirm_new_password" class="col-sm-2 control-label">Confirm Password
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" pattern=".{6,20}" required
                                        title="password requires more than 6 characters"
                                        class="form-control confirm_new_password password" name="confirm_new_password"
                                        id="confirm_new_password" placeholder="Confirm Password... ">
                                </div>
                            </div>
                        </div>
                        <div class="btn_div" style="display: none;">
                            <button type="submit" class="btn btn-info pull-right">Change Password</button>

                        </div>
                    </form>

                </div><!-- /.box-body -->
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')

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
            "startDate": "01/31/2020",
            "endDate": "02/06/2020",
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
        url: "{{ route('get_data') }}",
        success: function(data) {
            vlEIDNumbersChart(data.vl_records, data.eid_records);
            viralSuppressionRateChart(data.vl_classifications);
            eidPositivityChart(data.eid_classifications);
            tats(data.vl_tat, data.eid_tat);
            maps(data.county_numbers);
            $.each(data.all_partners, function(number, partner) {
                $("#partners").append($('<option>').text(partner.name).attr('value',
                    partner.id));
            });
            $.each(data.all_counties, function(number, county) {
                $("#counties").append($('<option>').text(county.name).attr('value',
                    county.id));
            });
            $("#partners").selectpicker('refresh');
            $("#counties").selectpicker('refresh');
            $("#all_records").html(data.all_records);
            $("#all_facilities").html(data.facilities);
            $("#county_numbers").html(data.counties);
            $("#partner_numbers").html(data.partners);
            $("#sent_records").html(data.sent_records);
            $("#unsent_records").html(data.all_records - data.sent_records);
            $("#dashboard_overlay").hide();
        }
    });
    st = '{!! Auth::user()->first_login !!}';
    if (st == 'Yes') {
        $('#FirstModal').modal('show');
    }
    $(".password").keyup(function() {
        var password = $("#new_password").val();
        var password2 = $("#confirm_new_password").val();
        if (password == password2) {
            $(".btn_div").show();
        } else {
            $(".btn_div").hide();
        }
    });
    $(document).ready(function() {
        $('.partners').selectpicker({});
        $("#partners").change(function() {
            let partners = $('#partners').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    "partners": partners
                },
                url: "{{ route('get_dashboard_counties') }}",
                success: function(data) {
                    $('#counties').empty();
                    $.each(data, function(number, county) {
                        $("#counties").append($('<option>').text(county.name).attr(
                            'value',
                            county.id));
                    });
                    $("#counties").selectpicker('refresh');
                }
            });
        });
        $("#counties").change(function() {
            let counties = $('#counties').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    "counties": counties
                },
                url: "{{ route('get_dashboard_sub_counties') }}",
                success: function(data) {
                    $('#subcounties').empty();
                    $.each(data, function(number, subcounty) {
                        $("#subcounties").append($('<option>').text(subcounty.name)
                            .attr(
                                'value',
                                subcounty.id));
                    });
                    $("#subcounties").selectpicker('refresh');
                }
            });
        });
        $("#subcounties").change(function() {
            let sub_counties = $('#subcounties').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    "sub_counties": sub_counties
                },
                url: "{{ route('get_dashboard_facilities') }}",
                success: function(data) {
                    $('#facilities').empty();
                    $.each(data, function(number, facility) {
                        $("#facilities").append($('<option>').text(facility.name)
                            .attr(
                                'value',
                                facility.id));
                    });
                    $("#facilities").selectpicker('refresh');
                }
            });
        });
    });
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/bullet.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    //Highcharts
    //VLEIDNUMBERSCHART
    function vlEIDNumbersChart(vl, eid) {}
    //VIRAL SUPPRESSION CHART
    function viralSuppressionRateChart(data) {
        let displayData = [];
        for (let i = 0; i < data.length; i++) {
            let innerObject = {};
            if (data[i].data_key == 1) {
                innerObject.name = 'Suppressed';
                innerObject.y = data[i].number;
                innerObject.color = '#006200';
            } else if (data[i].data_key == 2) {
                innerObject.name = 'Un-Suppressed';
                innerObject.y = data[i].number;
                innerObject.color = '#ffd500';
            } else if (data[i].data_key == 3) {
                innerObject.name = 'Invalid';
                innerObject.y = data[i].number;
                innerObject.color = '#cc0000';
            } else {
                innerObject.name = 'Indeterminate';
                innerObject.y = data[i].number;
                innerObject.color = '#d3d3d3';
            }
            displayData.push(innerObject);
        }
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });
        // Build the chart
        Highcharts.chart('viralSuppression', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Viral Suppression Rates'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        connectorColor: 'silver'
                    }
                }
            },
            series: [{
                name: 'Viral Loads',
                data: displayData
            }]
        });
    }
    //EID Positivity Chart
    function eidPositivityChart(data) {
        let displayData = [];
        for (let i = 0; i < data.length; i++) {
            let innerObject = {};
            if (data[i].data_key == 4) {
                innerObject.name = 'Negative';
                innerObject.y = data[i].number;
                innerObject.color = '#000062';
            } else if (data[i].data_key == 5) {
                innerObject.name = 'Positive';
                innerObject.y = data[i].number;
                innerObject.color = '#623100';
            } else if (data[i].data_key == 6) {
                innerObject.name = 'Invalid';
                innerObject.y = data[i].number;
                innerObject.color = '#620000';
            } else {
                innerObject.name = 'Indeterminate';
                innerObject.y = data[i].number;
                innerObject.color = '#d3d3d3';
            }
            displayData.push(innerObject);
        }
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });
        // Build the chart
        Highcharts.chart('eidPositivity', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'EID Positivity Chart'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        connectorColor: 'silver'
                    }
                }
            },
            series: [{
                name: 'Viral Loads',
                data: displayData
            }]
        });
    }

    function tats(vl, eid) {
        Highcharts.setOptions({
            chart: {
                inverted: true,
                marginLeft: 135,
                type: 'bullet'
            },
            title: {
                text: null
            },
            legend: {
                enabled: false
            },
            yAxis: {
                gridLineWidth: 0
            },
            plotOptions: {
                series: {
                    pointPadding: 0.25,
                    borderWidth: 0,
                    color: '#000062',
                    targetOptions: {
                        width: '200%'
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }
        });
        Highcharts.chart('tateid', {
            chart: {
                marginTop: 40,
                height: 200
            },
            title: {
                text: 'Turn Around Times (days)'
            },
            xAxis: {
                categories: ['<span class="hc-cat-title">EID</span><br/>']
            },
            yAxis: {
                title: "EID TaT"
            },
            series: [{
                data: [{
                    y: Math.floor(eid[0].avg),
                    target: Math.floor(eid[0].avg)
                }]
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (days)'
            }
        });
        Highcharts.setOptions({
            chart: {
                inverted: true,
                marginLeft: 135,
                type: 'bullet'
            },
            title: {
                text: null
            },
            legend: {
                enabled: false
            },
            yAxis: {
                gridLineWidth: 0
            },
            plotOptions: {
                series: {
                    pointPadding: 0.25,
                    borderWidth: 0,
                    color: '#006200',
                    targetOptions: {
                        width: '200%'
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }
        });
        Highcharts.chart('tatvl', {
            chart: {
                marginTop: 40,
                height: 200
            },
            xAxis: {
                categories: ['<span class="hc-cat-title">Viral Load</span><br/>']
            },
            yAxis: {
                title: "VL TaT"
            },
            series: [{
                data: [{
                    y: Math.floor(vl[0].avg),
                    target: Math.floor(vl[0].avg)
                }]
            }],
            tooltip: {
                pointFormat: '<b>{point.y}</b> (days)'
            }
        });
    }

    function maps(data) {
        // console.log(data);
        Highcharts.getJSON(
            'https://africaopendata.org/dataset/a8f8b195-aafd-449b-9b1a-ab337fd9925f/resource/4fb2e27e-c001-4b7f-b71d-4fee4a96a0f8/download/kenyan-counties.geojson',
            function(geojson) {
                // Initiate the chart
                Highcharts.mapChart('map', {
                    chart: {
                        map: geojson
                    },
                    title: {
                        text: 'GeoJSON in Highmaps'
                    },
                    mapNavigation: {
                        enabled: true,
                        buttonOptions: {
                            verticalAlign: 'bottom'
                        }
                    },
                    colorAxis: {
                        tickPixelInterval: 100
                    },
                    series: [{
                        data: [],
                        // keys: ['COUNTY', 'value'],
                        // joinBy: 'COUNTY',
                        name: 'Random data',
                        states: {
                            hover: {
                                color: '#a4edba'
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.properties.COUNTY}'
                        }
                    }]
                });
            });
    }
</script>

@endsection