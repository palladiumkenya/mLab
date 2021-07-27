@extends('layouts.master')
@section('before-css')

@endsection

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Raw Data</div>

                <h4>Enter the client's KDOD Number....</h4>
                <div class="border-bottom my-3">
                    <form role="form" method="post" action="{{route('fetchOneClient')}}">
                        {{ csrf_field() }}
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName1">KDOD Number</label>
                            <input class="form-control" name="kdod_number" name='kdod_number' type="text" />
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </form>
                </div>
                <div class="my-10"> Or ... </div>
                <h4>Select any of the filters below, and click Fetch when complete. All are required fields.</h4>
                <div class="my-3">

                    <form role="form" method="post" action="{{route('fetchclients')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            @if (Auth::user()->user_level != 3 && Auth::user()->user_level != 4)
                            @if(Auth::user()->user_level < 3) <div class="col-md-6 form-group mb-3">
                                <label for="firstName1">Service</label>
                                <select class="form-control" data-width="100%" id="service" name="service_id">
                                    <option value="">Select Service</option>
                                    @if(Auth::user()->user_level < 2) @if (count($services)> 0)
                                        @foreach($services as $service)
                                        <option value="{{$service->id}}">{{ ucwords($service->name) }}</option>
                                        @endforeach
                                        @endif
                                        @endif
                                        @if(Auth::user()->user_level == 2)

                                        <option value="{{Auth::user()->service->id}}">
                                            {{ ucwords(Auth::user()->service->name) }}</option>
                                        @endif

                                </select>
                        </div>
                        @endif

                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName1">Unit</label>
                            <select  class="form-control" data-width="100%" id="unit" name="unit_id">
                                <option value="">Select Unit</option>
                                @if(Auth::user()->user_level == 5)

                                <option value="{{Auth::user()->unit->id}}">{{ ucwords(Auth::user()->unit->name) }}</option>
                                @endif
                                    
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName1">County</label>
                            <select class="form-control" data-width="100%" id="county" name="county_id">
                                <option value="">Select County</option>
                                @if(Auth::user()->user_level == 5)

                                <option value="{{Auth::user()->county->id}}">{{ ucwords(Auth::user()->county->name) }}
                                </option>
                                @endif

                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName1">Sub County</label>
                            <select class="form-control" data-width="100%" id="sub_county" name="sub_county_id">
                                <option value="">Select Sub County</option>

                            </select>
                        </div>
                        @endif
                        <div class="col-md-6 form-group mb-3">
                            <label for="firstName1">Facility</label>
                            <select class="form-control" data-width="100%" id="facility" name="code">
                                @if (Auth::user()->user_level != 3 && Auth::user()->user_level != 4)
                                <option value="">Select Facility</option>
                                @else

                                <option value="{{Auth::user()->facility->code}}">
                                    {{ ucwords(Auth::user()->facility->name) }}
                                </option>
                                @endif

                            </select>
                        </div>

                </div>
                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@section('page-js')

@endsection

@section('bottom-js')
<script type="text/javascript">

    $('#service').change(function () {

        $('#unit').empty();

        var z = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/get_units',
            data: {
                "service_id": z
            },
            dataType: "json",
            success: function (data) {
                var select = document.getElementById("unit"),
                    opt = document.createElement("option");

                    opt.value = "";
                    opt.textContent = "Select Unit";
                    select.appendChild(opt);
                for (var i = 0; i < data.length; i++) {
                    
                var select = document.getElementById("unit"),
                    opt = document.createElement("option");

                    opt.value = data[i].id;
                    opt.textContent = data[i].name;
                    select.appendChild(opt);
                }
            }
        })
    });

    $('#unit').change(function () {

        $('#county').empty();

        var z = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/get_counties',
            data: {
                "unit_id": z
            },
            dataType: "json",
            success: function (data) {
                var select = document.getElementById("county"),
                    opt = document.createElement("option");

                    opt.value = "";
                    opt.textContent = "Select County";
                    select.appendChild(opt);
                for (var i = 0; i < data.length; i++) {
                    
                var select = document.getElementById("county"),
                    opt = document.createElement("option");

                    opt.value = data[i].id;
                    opt.textContent = data[i].name;
                    select.appendChild(opt);
                }
            }
        })
    });

    $('#county').change(function() {
        $('#sub_county').empty();
        var x = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/get_subcounties',
            data: {
                "county_id": x
            },
            dataType: "json",
            success: function(data) {
                var select = document.getElementById("sub_county"),
                    opt = document.createElement("option");
                opt.value = "";
                opt.textContent = "Select Sub-County";
                select.appendChild(opt);
                for (var i = 0; i < data.length; i++) {
                    var select = document.getElementById("sub_county"),
                        opt = document.createElement("option");
                    opt.value = data[i].id;
                    opt.textContent = data[i].name;
                    select.appendChild(opt);
                }
            }
        })
    });
    
    $('#sub_county').change(function() {
        $('#facility').empty();
        var y = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/get_facilities_data',
            data: {
                "sub_county_id": y
            },
            dataType: "json",
            success: function(data) {
                var select = document.getElementById("facility"),
                    opt = document.createElement("option");
                opt.value = "";
                opt.textContent = "Select Facility";
                select.appendChild(opt);
                for (var i = 0; i < data.length; i++) {
                    var select = document.getElementById("facility"),
                        opt = document.createElement("option");
                    opt.value = data[i].code;
                    opt.textContent = data[i].name;
                    select.appendChild(opt);
                }
            }
        })
    });
</script>

@endsection