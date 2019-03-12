@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3">{{count($facilities)}} Facilties</h4>
                            
                            <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>MFL</th>
                                                <th>Level</th>
                                                <th>Partner</th>
                                                <th>Sub County</th>
                                                <th>County</th>
                                                <th>Phone No.</th>
                                                <th>Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($facilities) > 0)
                                                @foreach($facilities as $facility)
                                                    <tr> 
                                                        <td> {{ $loop->iteration }}</td>
                                                        <td> {{ ucwords($facility->name)}}</td>
                                                        <td>  {{$facility->code}}</td>
                                                        <td>  {{$facility->keph_level}}</td>
                                                        <td>  {{ucwords($facility->partner->name)}}</td>
                                                        <td>  {{ucwords($facility->sub_county->name)}}</td>
                                                        <td>  {{ucwords($facility->sub_county->county->name)}}</td>
                                                        <td>  {{$facility->mobile}}</td>
                                                        <td>  {{date('Y-m-d', strtotime($facility->updated_at))}}</td>
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
<script src="{{asset('assets/js/datatables.script.js')}}"></script>


@endsection
