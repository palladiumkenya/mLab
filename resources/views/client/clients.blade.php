@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="title card-title mb-3">MFL: {{$data->mfl_code}} , <b><i>{{count($data->clients)}} Clients
                    </i></b></h4>

            <div class="table-responsive">
                <table id="multicolumn_ordering_table" class="display table table-striped table-bordered"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>CCC Number</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Date Enrolled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data->clients) > 0)
                        @foreach($data->clients as $client)
                        <tr>
                            <td> {{ $loop->iteration }}</td>
                            <td> <a class="btn btn-secondary"
                                    onclick="getResults({{ $client->clinic_number }});">{{ $client->clinic_number }}</a>
                            </td>
                            <td> {{ $client->f_name }}</td>
                            <td> {{ $client->m_name }}</td>
                            <td> {{ $client->l_name }}</td>
                            <td> {{date('Y-m-d', strtotime($client->enrollment_date))}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
<script type="text/javascript">
    function getResults(ccc) {
        $.ajax({
            type: "POST",
            url: '/get/client/results',
            data: {
                "ccc_number": ccc,
                "_token": "{{ csrf_token()}}"
            },
            dataType: "json",
            success: function(data) {
                if (data.length === 0) {
                    toastr.success("No results found for this client in mLab!");
                }
                console.log(data)
                // $('#ClientResults').modal('show');
            }
        })
    }
</script>
@endsection