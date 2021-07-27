@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
    <div class="card text-left">

        <div class="card-body">
            <h4 class="card-title mb-3">SMS Costs</h4>
            
                <div class="table-responsive">                                    
                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Partner</th>
                                <th>Cost</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($costs) > 0)
                                @foreach($costs as $cost)
                                    <tr> 
                                        <td> {{ $loop->iteration }}</td>
                                        <td> {{ ucwords($cost->partner)}}</td>
                                        <td>  {{$cost->amount}}</td>
                                        <td>  {{date('Y-m-d', strtotime($cost->created_at))}}</td>
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