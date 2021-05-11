@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Add User</div>
                            <form role="form" method="post"action="{{route('adduser')}}">
                            {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">First name</label>
                                        <input type="text" class="form-control" id="firstName1" name="fname" placeholder="Enter your first name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="lastName1">Last name</label>
                                        <input type="text" class="form-control" id="lastName1" name="lname" placeholder="Enter your last name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" id="phone" name="phone" placeholder="Enter phone">
                                    </div>



                                    @if(Auth::user()->user_level == 2) 
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
                                    @endif

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">User Level</label>
                                        <select id ="level" name="level" class="form-control">
                                            <option >Select</option>
                                        @if(Auth::user()->user_level < 2)    
                                            <option value="1">Super Admin</option>
                                            <option value="2">Program Staff</option>
                                            <option value="5">Unit Manager</option>
                                        @endif
                                        @if(Auth::user()->user_level == 2)
                                            <option value="3">Healthcare Worker</option>
                                            <option value="4">Facility User</option>
                                        @endif 
                                        @if(Auth::user()->user_level == 3)
                                            <option value="4">Facility User</option>
                                        @endif 
                                        </select>
                                    </div>
                                    @if(Auth::user()->user_level < 2) 
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="picker1">Affiliation</label>
                                            <input id="affiliation" class="form-control" readonly  placeholder="Select Affiliation">
                                            <select hidden class="form-control" data-width="100%" id="county" name="county_id">
                                                <option value="">Select County</option>
                                                    @if (count($counties) > 0)
                                                        @foreach($counties as $county)
                                                        <option value="{{$county->id }}">{{ ucwords($county->name) }}</option>
                                                            @endforeach
                                                    @endif
                                            </select>
                                            <select hidden class="form-control" data-width="100%" id="partner" name="partner_id">
                                                <option value="">Select Partner</option>
                                                    @if (count($partners) > 0)
                                                        @foreach($partners as $partner)
                                                        <option value="{{$partner->id }}">{{ ucwords($partner->name) }}</option>
                                                            @endforeach
                                                    @endif
                                            </select>
                                        
                                        </div>
                                    @endif
                        
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

$('#level').on('change', function() {
  var level = this.value;

  if(level == 1){
    $('#affiliation').val("National");
    $('#affiliation').removeAttr('hidden');
    $('#partner').attr("hidden",true);
    $('#county').attr("hidden",true);
  }
  if(level == 2){
    $('#partner').removeAttr('hidden');
    $('#affiliation').attr("hidden",true);
    $('#county').attr("hidden",true);
  }
  if(level == 5){
    $('#county').removeAttr('hidden');
    $('#partner').attr("hidden",true);
    $('#affiliation').attr("hidden",true);
  }
});


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
    url: '/get_partner_facilities_mlab',
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
