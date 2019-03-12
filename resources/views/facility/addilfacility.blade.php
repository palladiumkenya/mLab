@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Add IL Facility</div>
                            <form role="form" method="post"action="{{route('addilfacility')}}">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">County</label>
                                        <select  class="form-control" data-width="100%" id="county" name="county_id">
                                            <option value="">Select County</option>
                                                @if (count($counties) > 0)
                                                    @foreach($counties as $county)
                                                    <option value="{{$county->id }}">{{ ucwords($county->name) }}</option>
                                                        @endforeach
                                                @endif
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Sub County</label>
                                        <select  class="form-control" data-width="100%" id="sub_county" name="sub_county_id">
                                            <option value="">Select Sub County</option>
                                                
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Facility</label>
                                        <select  class="form-control" data-width="100%" id="facility" name="code">
                                            <option value="">Select Facility</option>
                                                
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" id="phone" name="phone" placeholder="Enter phone">
                                    </div>
                        
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('page-js')




@endsection

@section('bottom-js')
<script type="text/javascript">

$('#county').change(function () {

$("#sub_county").empty();

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
    success: function (data) {

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

$('#sub_county').change(function () {

$("#facility").empty();

var y = $(this).val();
$.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    url: '/get_facilities',
    data: {
        "sub_county_id": y
    },
    dataType: "json",
    success: function (data) {

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
