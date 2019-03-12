@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3">{{count($partners)}} Partners</h4>
                            
                            <div style="margin-bottom:10px; ">
                                <a type="button" href="{{route('addpartnerform')}}" class="btn btn-primary btn-md pull-right">Add Partner</a>
                            </div>
                                <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Date Added</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($partners) > 0)
                                                @foreach($partners as $partner)
                                                    <tr> 
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td> {{ ucwords($partner->name)}}</td>
                                                        <td>  {{$partner->status}}</td>
                                                        <td>  {{date('Y-m-d', strtotime($partner->created_at))}}</td>
                                                        <td>
                                                            <button onclick="editpartner({{$partner}});" data-toggle="modal" data-target="#editpartner" type="button" class="btn btn-primary btn-sm">Edit</button>
                                                            <button onclick="deletepartner({{$partner->id}});"type="button" class="btn btn-danger btn-sm">Delete</button>
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


                <div id="editpartner" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                        
                        <div class="card-title mb-3">Edit Partner</div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form role="form" method="post" action="{{route('editpartner')}}">
                            {{ csrf_field() }}
                                <div class="row">
                                <input type="hidden" name="pid" id="pid">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Partner Name">
                                    </div>

                                   

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">Status</label>
                                        <select id ="status" name="status" class="form-control">
                                            <option >Select</option>
                                            <option value="Active">Active</option>
                                            <option value="Disabled">Disabled</option>
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

                <div id="DeleteModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Partner</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Partner?</p>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                            <button id="delete" type="button" class="btn btn-danger" >Delete</button>
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



function editpartner(partner){

    $('#name').val(partner.name);
    $('#status').val(partner.status);
    $('#pid').val(partner.id);


}


function deletepartner(pid){

    console.log(pid);
    $('#DeleteModal').modal('show');

    $(document).off("click", "#delete").on("click", "#delete", function (event) {
        $.ajax({
            type: "POST",
            url: '/delete/partner',
            data: {
                "pid": pid, "_token": "{{ csrf_token()}}"
            },
            dataType: "json",
            success: function (data) {
                toastr.success(data.details);
                $('#DeleteModal').modal('hide');
            }
        })
    });

}

</script>

@endsection
