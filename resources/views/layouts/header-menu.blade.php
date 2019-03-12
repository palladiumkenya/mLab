    <div class="main-header">
            <div class="logo">
                <img src="{{asset('assets/images/logo.png')}}" alt="">
            </div>

            <div class="menu-toggle">
                <h1 style="color: blue;"> mLab</h1>
            </div>

            <div class="d-flex align-items-center">
                <!-- Mega menu -->
                <div class=" dropdown mega-menu">
                    <a href="#" class="btn text-muted dropdown-toggle mr-3" id="dropdownMegaMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Main Menu</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="row m-0">
                            <div class="col-md-4 p-4 ">
                            <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration Options</p>
                                <div class="menu-icon-grid w-auto p-0">
                                    <a href="{{route('users')}}"><i class="i-Add-User"></i>Users</a>
                                    <a href="{{route('partners')}}"><i class="i-Network"></i>Partners</a>
                                    <a href="{{route('facilities')}}"><i class="i-Hospital"></i>Facilities</a>
                                    <a href="{{route('il_facilities')}}"><i class="i-Hospital1"></i>IL Facilities</a>
                                </div>
                            </div>
                            <div class="col-md-4 p-4">
                                <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                                <div class="menu-icon-grid w-auto p-0">
                                    <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                                    <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                                    <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                                    <a href="{{route('raw_data_form')}}"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                                </div>
                            </div>
                            <div class="col-md-4 p-4">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Mega menu -->
                <div >
                <p></p>
                   <h6> Welcome, {{ ucwords(Auth::user()->f_name)}} {{ ucwords(Auth::user()->l_name)}}: @if(Auth::user()->user_level < 2)   National Dashboard 
                   @elseif(Auth::user()->user_level == 2) Partner Dashboard
                   @elseif(Auth::user()->user_level == 3) Facility Dashboard
                   @elseif(Auth::user()->user_level == 4) Facility Dashboard
                   @elseif(Auth::user()->user_level == 5) County Dashboard
                   @endif </h6>
                </div>
            </div>

            <div style="margin: auto"></div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
    
                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div  class="user col align-self-end">
                        <img src="{{asset('assets/images/faces/face.png')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{ ucwords(Auth::user()->f_name)}} {{ ucwords(Auth::user()->l_name)}}
                            </div>
                            <a class="dropdown-item">@if(Auth::user()->user_level < 2)   National
                   @elseif(Auth::user()->user_level == 2) Partner
                   @elseif(Auth::user()->user_level == 3) Facility
                   @elseif(Auth::user()->user_level == 4) Facility
                   @elseif(Auth::user()->user_level == 5) County
                   @endif</a>
                            <a class="dropdown-item" href="{{route('logout')}}">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- header top menu end -->
