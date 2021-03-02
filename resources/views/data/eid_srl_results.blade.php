@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3">Showing {{count($results)}}, use the links below to pull sample remote login eid results per page.</h4>
                            <div class="col-md-12" style="margin-top:10px; ">
                                {{ $results->onEachSide(5)->links() }}
                            </div>
                                <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Heein Number</th>
                                                <th>Patient Name</th>
                                                <th>Gender</th>
                                                <th>Prophylaxis Code</th>
                                                <th>Collected</th>
                                                <th>Entry Point</th>
                                                <th>Mother Age</th>
                                                <th>Haart Date</th>
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
                                                        <td>  {{$result->hein_number}}</td>
                                                        <td>  {{$result->patient_name}}</td>
                                                        <td>  {{$result->gender}}</td>
                                                        <td>  {{$result->prophylaxis_code}}</td>
                                                        <td>  {{$result->date_collected}}</td>
                                                        <td>  {{$result->entry_point}}</td>
                                                        <td>  {{$result->mother_age}}</td>    
                                                        <td> @if(!empty($result->haart_date)) {{$result->haart_date}} @else Not Provided @endif</td>
                                                        <td>  {{$result->facility}}</td>
                                                        <td>  {{$result->sub_county}}</td>
                                                        <td>  {{$result->county}}</td>
                                                        <td> @if(!empty($result->partner)) {{$result->partner}} @else Not Provided @endif</td>
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
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true
    });</script>


@endsection
