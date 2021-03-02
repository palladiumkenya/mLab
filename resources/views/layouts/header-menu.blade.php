    <div class="main-header">
        <div class="logo">
            <a href="{{route('home')}}"><img src="{{asset('assets/images/logo.png')}}" alt=""></a>
        </div>

        <div class="menu-toggle">
            <a href="{{route('home')}}"><i class="i-Home"></i>
                <h1 style="color:blue;">mLab</h1>
            </a>
        </div>

        <div class="d-flex align-items-center">
            <!-- Mega menu -->
            <div class=" dropdown mega-menu">
                <a href="#" class="btn text-muted dropdown-toggle mr-3" id="dropdownMegaMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Main Menu</a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="row m-0">
                        @if(Auth::user()->user_level < 2) <div class="col-md-6 p-4">
                            <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration Options
                            </p>
                            <div class="menu-icon-grid w-auto p-0">
                                <a href="{{route('users')}}"><i class="i-Add-User"></i>Users</a>
                                <a href="{{route('clients')}}"><i class="i-MaleFemale"></i>Clients</a>
                                <a href="{{route('partners')}}"><i class="i-Network"></i>Partners</a>
                                <a href="{{route('facilities')}}"><i class="i-Hospital"></i>Facilities</a>
                                <a href="{{route('il_facilities')}}"><i class="i-Hospital1"></i>IL Facilities</a>
                            </div>
                    </div>
                    <div class="col-md-6 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                            <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="{{route('hts_all_results')}}"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="{{route('vl_srl_results')}}"><i class="i-Neutron"></i> VL Remote Login</a>
                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> EID Remote Login</a>
                            <a href="{{route('raw_data_form')}}"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->user_level == 2)
                    <div class="col-md-12 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration & Reports
                        </p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{route('users')}}"><i class="i-Add-User"></i>Users</a>
                            <a href="{{route('facilities')}}"><i class="i-Hospital"></i>Facilities</a>
                            <a href="{{route('il_facilities')}}"><i class="i-Hospital1"></i>IL Facilities</a>

                            <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                            <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="{{route('hts_all_results')}}"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="{{route('vl_srl_results')}}"><i class="i-Neutron"></i> VL Remote Login</a>
                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> EID Remote Login</a>
                            <a href="{{route('raw_data_form')}}"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->user_level == 3)
                    <div class="col-md-10 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration & Reports
                        </p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{route('users')}}"><i class="i-Add-User"></i>Users</a>
                            <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                            <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="{{route('hts_all_results')}}"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="{{route('vl_srl_results')}}"><i class="i-Neutron"></i> VL Remote Login</a>
                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> EID Remote Login</a>
                            <a href="{{route('raw_data_form')}}"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->user_level == 4)
                    <div class="col-md-6 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                            <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="{{route('hts_all_results')}}"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="{{route('vl_srl_results')}}"><i class="i-Neutron"></i> VL Remote Login</a>
                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> EID Remote Login</a>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->user_level == 5)
                    <div class="col-md-10 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="{{route('facilities')}}"><i class="i-Hospital"></i>Facilities</a>
                            <a href="{{route('all_results')}}"><i class="i-Big-Data"></i> All Results</a>
                            <a href="{{route('vl_results')}}"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="{{route('eid_results')}}"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="{{route('hts_all_results')}}"><i class="i-Neutron"></i> HTS Results</a>                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> Remote Login</a>
                            <a href="{{route('vl_srl_results')}}"><i class="i-Neutron"></i> VL Remote Login</a>
                            <a href="{{route('eid_srl_results')}}"><i class="i-Neutron"></i> EID Remote Login</a>
                            <a href="{{route('raw_data_form')}}"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <!-- / Mega menu -->
        <div>
            <p></p>
            <h6> Welcome, <b>{{ ucwords(Auth::user()->f_name)}} {{ ucwords(Auth::user()->l_name)}}</b>:
                @if(Auth::user()->user_level < 2) National Dashboard @elseif(Auth::user()->user_level == 2)
                    {{Auth::user()->partner->name}} Dashboard
                    @elseif(Auth::user()->user_level == 3) {{Auth::user()->facility->name}} Dashboard <b>(MFL:
                        {{Auth::user()->facility->code}})</b>
                    @elseif(Auth::user()->user_level == 4) {{Auth::user()->facility->name}} Dashboard <b>(MFL:
                        {{Auth::user()->facility->code}})</b>
                    @elseif(Auth::user()->user_level == 5) {{Auth::user()->county->name}} County Dashboard
                    @endif </h6>
        </div>
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{asset('assets/images/faces/face.png')}}" id="userDropdown" alt="" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> <b>{{ ucwords(Auth::user()->f_name)}}
                            {{ ucwords(Auth::user()->l_name)}}</b>
                    </div>
                    <a class="dropdown-item">@if(Auth::user()->user_level < 2) National @elseif(Auth::user()->user_level
                            == 2) {{Auth::user()->partner->name}}
                            @elseif(Auth::user()->user_level == 3) {{Auth::user()->facility->name}}
                            @elseif(Auth::user()->user_level == 4) {{Auth::user()->facility->name}}
                            @elseif(Auth::user()->user_level == 5) {{Auth::user()->county->name}} County
                            @endif</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Sign out</a>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- header top menu end -->