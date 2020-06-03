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
                <div class="form-group">
                    <label for="daterange" class="col-form-label"></label>
                    <button type="submit" class="btn btn-warning"><b>Filter Results</b> <i
                            class="i-Filter"></i></button>
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
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Unsuppressed VL Total</p>
                        <p id="suppressed_negative" class="text-danger text-24 line-height-1 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-warning o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-muted mt-4 mb-0">Positive EID Total</p>
                        <p id="unsuppressed_positive" class="text-warning text-24 line-height-1 mb-2"></p>
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
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col" id="map"></div>
        <div class="col" id="pulledUnpulled">

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
                                            class="form-control new_password password" name="new_password"
                                            id="new_password" placeholder="New Password... ">
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
                                            class="form-control confirm_new_password password"
                                            name="confirm_new_password" id="confirm_new_password"
                                            placeholder="Confirm Password... ">
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
            url: "{{ route('get_data') }}",
            success: function(data) {
                const arr = sumClassifications(data.vl_classifications, data.eid_classifications)
                viralSuppressionRateChart(data.vl_classifications);
                eidPositivityChart(data.eid_classifications);
                tats(data.vl_tat, data.eid_tat);
                maps(data.county_numbers);
                pullCheck(data.pulled_data);
                $('#partners').empty();
                $('#counties').empty();
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
                $("#suppressed_negative").html(arr[0]);
                $("#unsuppressed_positive").html(arr[1]);
                let userlevel = '{!!Auth::user()->user_level!!}';
                if (userlevel == 2) {
                    let partnerId = '{!!Auth::user()->partner_id!!}';
                    $('#partners').attr("disabled", true);
                    $('#partners').selectpicker('val', partnerId);
                    $("#partners").selectpicker('refresh');
                }
                if (userlevel == 3) {
                    let partnerId = '{!!Auth::user()->partner_id!!}';
                    $('#partners').attr("disabled", true);
                    $('#partners').selectpicker('val', partnerId);
                    $("#partners").selectpicker('refresh');
                    let countyId = data.all_counties[0].id;
                    $('#counties').attr("disabled", true);
                    $('#counties').selectpicker('val', countyId);
                    $("#counties").selectpicker('refresh');
                    $('#subcounties').attr("disabled", true);
                    $('#facilities').attr("disabled", true);
                }
                $("#dashboard_overlay").hide();
            }
        });
        $('#dataFilter').on('submit', function(e) {
            e.preventDefault();
            $("#dashboard_overlay").show();
            let partners = $('#partners').val();
            let counties = $('#counties').val();
            let subcounties = $('#subcounties').val();
            let facilities = $('#facilities').val();
            let daterange = $('#daterange').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    "partners": partners,
                    "counties": counties,
                    "subcounties": subcounties,
                    "facilities": facilities,
                    "daterange": daterange
                },
                url: "{{ route('filterDashboard') }}",
                success: function(data) {
                    const arr = sumClassifications(data.vl_classifications,
                        data.eid_classifications)
                    viralSuppressionRateChart(data.vl_classifications);
                    eidPositivityChart(data.eid_classifications);
                    tats(data.vl_tat, data.eid_tat);
                    maps(data.county_numbers);
                    pullCheck(data.pulled_data);
                    $('#partners').empty();
                    $('#counties').empty();
                    $.each(data.all_partners, function(number, partner) {
                        $("#partners").append($('<option>').text(partner.name).attr(
                            'value',
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
                    $("#suppressed_negative").html(arr[0]);
                    $("#unsuppressed_positive").html(arr[1]);
                    $("#dashboard_overlay").hide();
                }
            });
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
                            $("#counties").append($('<option>').text(
                                    county.name)
                                .attr(
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
                            $("#subcounties").append($('<option>').text(
                                    subcounty
                                    .name)
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
                let partners = $('#partners').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    data: {
                        "sub_counties": sub_counties,
                        "partners": partners
                    },
                    url: "{{ route('get_dashboard_facilities') }}",
                    success: function(data) {
                        $('#facilities').empty();
                        $.each(data, function(number, facility) {
                            $("#facilities").append($('<option>').text(
                                    facility
                                    .name)
                                .attr(
                                    'value',
                                    facility.code));
                        });
                        $("#facilities").selectpicker('refresh');
                    }
                });
            });
        });
    </script>

    <script>
        function sumClassifications(vls, eids) {
            let unsuppressed_total = 0;
            let positive_total = 0;
            for (let i = 0; i < vls.length; i++) {
                if (vls[i].data_key !== 1) {
                    unsuppressed_total = unsuppressed_total + vls[i].number;
                }
            }
            for (let i = 0; i < eids.length; i++) {
                if (eids[i].data_key == 4) {
                    positive_total = positive_total + eids[i].number;
                }
            }
            return [unsuppressed_total, positive_total];
        }
        //Highcharts
        //VIRAL SUPPRESSION CHART
        function viralSuppressionRateChart(data) {
            let displayData = [];
            for (let i = 0; i < data.length; i++) {
                let innerObject = {};
                if (data[i].data_key == 1) {
                    innerObject.name = 'Suppressed';
                    innerObject.y = data[i].number;
                    innerObject.color = '#004D1A';
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
        //TaTs Charts
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
                        color: '#004D1A',
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
        //Maps Chart
        async function maps(data) {
            // console.log(data);
            let geojson = await fetchJSON('kenyan-counties.geojson');
            // Initiate the chart
            Highcharts.mapChart('map', {
                chart: {
                    map: geojson,
                    height: 600
                },
                title: {
                    text: 'Results by County'
                },
                legend: {
                    layout: 'horizontal',
                    borderWidth: 0,
                    backgroundColor: 'rgba(255,255,255,0.85)',
                    floating: true,
                    verticalAlign: 'top',
                    y: 25
                },
                exporting: {
                    sourceWidth: 600,
                    sourceHeight: 500
                },
                mapNavigation: {
                    enabled: true
                },
                colorAxis: {
                    min: 1,
                    type: 'logarithmic',
                    minColor: '#EEEEFF',
                    maxColor: '#000022',
                    stops: [
                        [0, '#EFEFFF'],
                        [0.67, '#4444FF'],
                        [1, '#000022']
                    ]
                },
                series: [{
                    data: data,
                    keys: ['facilities', 'results'],
                    joinBy: 'county_id',
                    name: 'Results by County',
                    states: {
                        hover: {
                            color: '#004D1A'
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        format: '{point.properties.COUNTY}'
                    },
                    tooltip: {
                        pointFormat: 'County: {point.properties.COUNTY}<br> Results: {point.results} <br> Facilities: {point.facilities}'
                    }
                }]
            });
        }

        function pullCheck(data) {
            let counties = [];
            let all_results = [];
            let pulled_results = [];
            for (let i = 0; i < data.length; i++) {
                counties.push(data[i].name);
                all_results.push(data[i].all_results);
                pulled_results.push(data[i].pulled_results);
            }
            Highcharts.chart('pulledUnpulled', {
                chart: {
                    type: 'column',
                    height: 600
                },
                title: {
                    text: 'Results Pulled by County'
                },
                xAxis: {
                    categories: counties,
                    crosshair: true
                },
                yAxis: [{
                    title: {
                        text: 'Results'
                    },
                }],
                legend: {
                    shadow: false
                },
                tooltip: {
                    shared: true
                },
                plotOptions: {
                    column: {
                        grouping: false,
                        shadow: false,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'All Results',
                    color: 'rgba(248,161,63,1)',
                    data: all_results,
                    pointPadding: 0.3,
                    pointPlacement: 0.2
                }, {
                    name: 'Pulled Results',
                    color: 'rgba(186,60,61,.9)',
                    data: pulled_results,
                    pointPadding: 0.4,
                    pointPlacement: 0.2
                }]
            });
        }

        function fetchJSON(url) {
            return fetch(url)
                .then(function(response) {
                    return response.json();
                });
        }
    </script>

    @endsection