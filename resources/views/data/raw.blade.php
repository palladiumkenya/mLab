@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3">Showing {{count($results)}}, use the links below to pull results per page.</h4>
                            <div class="col-md-12" style="margin-top:10px; ">
                                {{ $results->appends(request()->input())->links() }}
                            </div>
                                <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Type</th>
                                                <th>Patient ID</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Content</th>
                                                <th>Classification</th>
                                                <th>Collected</th>
                                                <th>Sent</th>
                                                <th>Delivered</th>
                                                <th>Read</th>
                                                <th>Facility</th>
                                                <th>Sub-County</th>
                                                <th>County</th>
                                                <th>Partner</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($results) > 0)
                                                @foreach($results as $result)
                                                    <tr> 
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td>  {{$result->result_type}}</td>
                                                        <td> @if(!empty($result->client_id)) {{$result->client_id}} @else Not Provided @endif</td>
                                                        <td>  {{$result->age}}</td>
                                                        <td>  {{$result->gender}}</td>
                                                        <td>  {{$result->result_content}} {{$result->units}}</td>
                                                        <td>  {{$result->data_key}}</td>
                                                        <td>  {{$result->date_collected}}</td>
                                                        <td>  {{$result->date_sent}}</td>
                                                        <td>  {{$result->date_delivered}}</td>    
                                                        <td> @if(!empty($result->date_read)) {{$result->date_read}}  @else Unread @endif</td>                                                            
                                                        <td>  {{$result->facility}}</td>
                                                        <td>  {{$result->sub_county}}</td>
                                                        <td>  {{$result->county}}</td>
                                                        <td>  {{$result->partner}}</td>                                                  
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

@endsection

@section('page-js')

 <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
 <script type="text/javascript">
   // multi column ordering
   $('#multicolumn_ordering_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": false,
        "responsive":true,
        "ordering": true,
        "info": true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });</script>


@endsection
