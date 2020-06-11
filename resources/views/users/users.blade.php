@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">{{count($users)}} Users</h4>

            <div style="margin-bottom:10px; ">
                <a type="button" href="{{route('adduserform')}}" class="btn btn-primary btn-md pull-right">Add User</a>
            </div>
            <div class="table-responsive">
                <table id="multicolumn_ordering_table" class="display table table-striped table-bordered"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Level</th>
                            @if(Auth::user()->user_level < 2) <th>Affiliation</th>
                                @endif
                                @if(Auth::user()->user_level == 2)
                                <th>Facility</th>
                                @endif
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) > 0)
                        @foreach($users as $user)
                        <tr>
                            <td> {{ $loop->iteration }}</td>
                            <td> {{ ucwords($user->f_name)}} {{ ucwords($user->l_name)}}</td>
                            <td> {{$user->phone_no}}</td>
                            <td> {{$user->email}}</td>
                            <td> @if($user->user_level == '0') National @endif
                                @if($user->user_level == '1') National @endif
                                @if($user->user_level == '2') Partner @endif
                                @if($user->user_level == '3') Facility @endif
                                @if($user->user_level == '4') Facility @endif
                                @if($user->user_level == '5') County @endif
                            </td>
                            @if(Auth::user()->user_level < 2) <td> @if(!empty($user->partner))
                                {{$user->partner->name}}@elseif(!empty($user->facility->sub_county->county))
                                {{$user->facility->sub_county->county->name}} County @else None @endif
                                @endif
                                @if(Auth::user()->user_level == 2)
                                <td> @if(!empty($user->facility)){{$user->facility->name}}@else None @endif </td>
                                @endif

                                </td>
                                <td> {{$user->status}}</td>
                                <td> {{date('Y-m-d', strtotime($user->created_at))}}</td>
                                <td>
                                    <button onclick="editUser({{$user}});" data-toggle="modal" data-target="#editUser"
                                        type="button" class="btn btn-primary btn-sm">Edit</button>
                                    <button onclick="resetUser({{$user->id}});" type="button"
                                        class="btn btn-success btn-sm">Reset</button>
                                    <button onclick="deleteUser({{$user->id}});" type="button"
                                        class="btn btn-danger btn-sm">Delete</button>

                                </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
<!-- end of col -->

<div id="editUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <div class="card-title mb-3">Edit User</div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form role="form" method="post" action="{{route('edituser')}}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <input type="hidden" name="id" id="uid">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">First name</label>
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            placeholder="Enter your first name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="lastName1">Last name</label>
                                        <input type="text" class="form-control" id="lname" name="lname"
                                            placeholder="Enter your last name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email">
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" id="phone" name="phone" placeholder="Enter phone">
                                    </div>
                                    @if(Auth::user()->user_level == 2)
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">County</label>
                                        <select class="form-control" data-width="100%" id="county" name="county_id">
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
                                        <select class="form-control" data-width="100%" id="sub_county"
                                            name="sub_county_id">
                                            <option value="">Select Sub County</option>
                                            @if (count($subcounties) > 0)
                                            @foreach($subcounties as $subcounty)
                                            <option value="{{$subcounty->id }}">{{ ucwords($subcounty->name) }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Facility</label>
                                        <select class="form-control" data-width="100%" id="facility" name="code">
                                            <option value="">Select Facility</option>
                                            @if (count($facilities) > 0)
                                            @foreach($facilities as $facility)
                                            <option value="{{$facility->code }}">{{ ucwords($facility->name) }}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    @endif

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">User Level</label>
                                        <select id="level" name="level" class="form-control">
                                            <option>Select</option>
                                            @if(Auth::user()->user_level < 2) <option value="1">National</option>
                                                <option value="2">Partner</option>
                                                <option value="5">County</option>
                                                <option value="3">Facility Admin</option>
                                                <option value="4">Facility User</option>
                                                @endif
                                                @if(Auth::user()->user_level == 2)
                                                <option value="3">Facility Admin</option>
                                                <option value="4">Facility User</option>
                                                @endif
                                                @if(Auth::user()->user_level == 3)
                                                <option value="4">Facility User</option>
                                                @endif
                                        </select>
                                    </div>

                                    @if(Auth::user()->user_level < 2) <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">Affiliation</label>
                                        <input id="affiliation" class="form-control" readonly
                                            placeholder="Select Affiliation">
                                        <select hidden class="form-control" data-width="100%" id="county"
                                            name="county_id">
                                            <option value="">Select County</option>
                                            @if (count($counties) > 0)
                                            @foreach($counties as $county)
                                            <option value="{{$county->id }}">{{ ucwords($county->name) }} County
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <select hidden class="form-control" data-width="100%" id="partner"
                                            name="partner_id">
                                            <option value="">Select Partner</option>
                                            @if (count($partners) > 0)
                                            @foreach($partners as $partner)
                                            <option value="{{$partner->id }}">{{ ucwords($partner->name) }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                </div>
                                @endif

                                <div class="col-md-6 form-group mb-3">
                                    <label for="picker1">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option>Select</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

</div>
</div>

<div id="ResetModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reset this user's password?.</p>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                <button id="reset" type="button" class="btn btn-success" data-person_id="">Reset</button>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="DeleteModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Delete this user's password?.</p>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                <button id="delete" type="button" class="btn btn-danger" data-person_id="">Delete</button>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
<script type="text/javascript">
    $('#level').on('change', function() {
        var level = this.value;
        if (level == 1) {
            $('#affiliation').val("National");
            $('#affiliation').removeAttr('hidden');
            $('#partner').attr("hidden", true);
            $('#county').attr("hidden", true);
        }
        if (level == 2) {
            $('#partner').removeAttr('hidden');
            $('#affiliation').attr("hidden", true);
            $('#county').attr("hidden", true);
        }
        if (level == 5) {
            $('#county').removeAttr('hidden');
            $('#partner').attr("hidden", true);
            $('#affiliation').attr("hidden", true);
        }
    });

    function editUser(user) {
        var p = '{!!Auth::user() !!}';
        console.log(p);
        if (p.user_level < 2) {
            if (user.user_level < 2) {
                $('#affiliation').val('National');
            }
            if (user.user_level == 2) {
                $('#partner').removeAttr('hidden');
                $('#affiliation').attr("hidden", true);
                $('#county').attr("hidden", true);
                $('#partner').val(user.partner.id);
            }
            if (user.user_level == 5) {
                $('#county').removeAttr('hidden');
                $('#partner').attr("hidden", true);
                $('#affiliation').attr("hidden", true);
                $('#county').val(user.county.id);
            }
            if (user.user_level == 3 || user.user_level == 4) {
                $('#partner').removeAttr('hidden');
                $('#affiliation').attr("hidden", true);
                $('#county').attr("hidden", true);
                $('#partner').val(user.partner.id);
            }
        }
        $('#fname').val(user.f_name);
        $('#lname').val(user.l_name);
        $('#email').val(user.email);
        if (p.user_level > 1) {
            $('#county').val(user.facility.sub_county.county.id);
            $('#sub_county').val(user.facility.sub_county.id);
            $('#facility').val(user.facility.code);
        }
        $('#phone').val(user.phone_no);
        $('#uid').val(user.id);
        $('#level').val(user.user_level);
        $('#status').val(user.status);
        $('#email').val(user.email);
    }

    function resetUser(uid) {
        $('#ResetModal').modal('show');
        $(document).off("click", "#reset").on("click", "#reset", function(event) {
            $.ajax({
                type: "POST",
                url: '/reset/user',
                data: {
                    "uid": uid,
                    "_token": "{{ csrf_token()}}"
                },
                dataType: "json",
                success: function(data) {
                    toastr.success(data.details);
                    $('#ResetModal').modal('hide');
                }
            })
        });
    }

    function deleteUser(uid) {
        $('#DeleteModal').modal('show');
        console.log(uid);
        $(document).off("click", "#delete").on("click", "#delete", function(event) {
            $.ajax({
                type: "POST",
                url: '/delete/user',
                data: {
                    "uid": uid,
                    "_token": "{{ csrf_token()}}"
                },
                dataType: "json",
                success: function(data) {
                    toastr.success(data.details);
                    $('#DeleteModal').modal('hide');
                }
            })
        });
    }
    $('#county').change(function() {
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
            success: function(data) {
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
            success: function(data) {
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