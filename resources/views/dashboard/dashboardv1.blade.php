@extends('layouts.master')
@section('main-content')

            <div class="separator-breadcrumb border-top"></div>


            @php
                                $username = 'admin'; // Username  

                                $cip = $_SERVER['REMOTE_ADDR'];       
                                $server = 'https://tableau.mhealthkenya.co.ke/trusted'; 

                                echo $username;
                                echo $ip;
                                echo $server;
                                
                            @endphp
                            @if(Auth::user()->user_level < 2)
                                @php
                                    $view = "/views/MLABDASH_0/MDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no";
                                @endphp

                            @endif
                            @if(Auth::user()->user_level == 2)
                                @php
                                    $view = "/views/MLABDASH_0/PartnerDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no";
                                @endphp

                            @endif
                            @if((Auth::user()->user_level == 3) || (Auth::user()->user_level == 4))
                                @php
                                    $view = "/views/MLABDASH_0/FacilityDSBD?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no";
                                @endphp

                            @endif
                            @if(Auth::user()->user_level == 5)
                                @php
                                    $view = "/views/MLABDASH_0/CountyDashboard?iframeSizedToWindow=true&:embed=y&:showAppBanner=false&:display_count=no&:showVizHome=no";
                                @endphp

                            @endif


                            @php
                                
                                $ch = curl_init($server); // Initializes cURL session 



                                $data = array('username' => $username, 'client_ip' => $cip); // What data to send to Tableau Server  

                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_POST, true); // Tells cURL to use POST method  
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // What data to post  
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return ticket to variable  


                                $ticket = curl_exec($ch); // Execute cURL function and retrieve ticket  
                                curl_close($ch); // Close cURL session  

                                $clnd_view = str_replace(' ', '%20', $view);
                                $url = $server . '/' . $ticket . '/' . $clnd_view;

                                ?>  


                                <iframe src="<?= $server ?>/<?= $ticket ?>/<?= $clnd_view ?>" width="100%" height="652px" ></iframe> 
                            @endphp

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
