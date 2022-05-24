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

<div id="ClientResults" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title res"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="resultTable" class="display table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>CCC Number</th>
                            <th>MFL Code</th>
                            <th>Date Collected</th>
                            <th>Result</th>
                            <th>Lab Name</th>
                            <th>Date Available</th>
                        </tr>
                    </thead>
                </table>
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
                for (let i = 0; i < data.length; i++) {
                    let num = i + 1;
                    $('#resultTable').append(
                        '<tr>' +
                        '<td> ' + num + '</td>' +
                        '<td>' + data[i].client_id + '</td>' +
                        '<td>' + data[i].mfl_code + '</td>' +
                        '<td>' + data[i].date_collected + '</td>' +
                        '<td>' + data[i].result_content + '</td>' +
                        '<td>' + data[i].lab_name + '</td>' +
                        '<td>' + data[i].created_at.substr(0, 10) + '</td>' +
                        '</tr>');
                }
                $('.res').html(`Client ${data[0].client_id} Results`)
                $('#ClientResults').modal('show');
            }
        })
    }
</script>
@endsection