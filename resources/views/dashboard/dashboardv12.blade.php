@extends('layouts.app')
@section('main-content')
{{ $url}}
            <div class="separator-breadcrumb border-top"></div>

            <iframe src="{{$url}}" width="100%" height="652px" ></iframe>  
Hello Moto


            <div id="FirstModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        

                            <div class="col-md-12">
                          
                            <form role="form" method="post"action="{{route('changepass')}}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <input type="hidden" name="id" value="{{Auth::user()->id}}">

                                    <div class="form-group col-md-12">
                                        <label for="new_password" class="col-sm-2 control-label ">New Password </label>
                                        <div class="col-sm-10">
                                            <input type="password" pattern=".{6,20}" required title="password requires more than 6 characters" class="form-control new_password password" name="new_password" id="new_password" placeholder="New Password... ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="form-group col-md-12">
                                        <label for="confirm_new_password" class="col-sm-2 control-label">Confirm Password </label>
                                        <div class="col-sm-10">
                                            <input type="password"  pattern=".{6,20}" required title="password requires more than 6 characters" class="form-control confirm_new_password password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm Password... ">
                                        </div>
                                    </div>
                                </div>
                                <div class="btn_div" style="display: none;">
                                    <button type="submit" class="btn btn-info pull-right">Change Password</button>

                                </div>
                            </form>




                                </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>

@endsection

@section('page-js')
     <script src="{{asset('assets/js/vendor/echarts.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/echart.options.min.js')}}"></script>
     <script src="{{asset('assets/js/es5/dashboard.v1.script.js')}}"></script>

     <script type="text/javascript">

    

        st = '{!! Auth::user()->first_login !!}';

        if(st == 'Yes'){
            $('#FirstModal').modal('show');
        }




        $(".password").keyup(function () {
            var password = $("#new_password").val();
            var password2 = $("#confirm_new_password").val();
            if (password == password2) {
                $(".btn_div").show();
            } else {
                $(".btn_div").hide();
            }
        });

    </script>

@endsection
