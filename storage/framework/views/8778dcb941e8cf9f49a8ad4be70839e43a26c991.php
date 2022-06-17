    <div class="main-header">
        <div class="logo">
            <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt=""></a>
        </div>

        <div class="menu-toggle">
            <a href="<?php echo e(route('home')); ?>"><i class="i-Home"></i>
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
                        <?php if(Auth::user()->user_level < 2): ?> <div class="col-md-6 p-4">
                            <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration Options
                            </p>
                            <div class="menu-icon-grid w-auto p-0">
                                <a href="<?php echo e(route('users')); ?>"><i class="i-Add-User"></i>Users</a>
                                <a href="<?php echo e(route('clients')); ?>"><i class="i-MaleFemale"></i>Clients</a>
                                <a href="<?php echo e(route('partners')); ?>"><i class="i-Network"></i>Partners</a>
                                <a href="<?php echo e(route('facilities')); ?>"><i class="i-Hospital"></i>Facilities</a>
                                <a href="<?php echo e(route('il_facilities')); ?>"><i class="i-Hospital1"></i>IL Facilities</a>
                                <a href="<?php echo e(route('all_results')); ?>"><i class="i-Big-Data"></i> All Results</a>
                            </div>
                    </div>
                    <div class="col-md-6 p-5">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="<?php echo e(route('vl_results')); ?>"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="<?php echo e(route('eid_results')); ?>"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="<?php echo e(route('hts_all_results')); ?>"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="<?php echo e(route('vl_srl_raw_data')); ?>"><i class="i-Big-Data"></i> VL Remote Login</a>
                            <a href="<?php echo e(route('eid_srl_raw_data')); ?>"><i class="i-Virus-2"></i> EID Remote Login</a>
                            <a href="<?php echo e(route('hts_srl_raw_data')); ?>"><i class="i-Neutron"></i> HTS Remote Login</a>
                            <a href="<?php echo e(route('sms_report')); ?>"><i class="i-Download-from-Cloud"></i> SMS Report</a>
                            <a href="<?php echo e(route('raw_data_form')); ?>"><i class="i-Download-from-Cloud"></i> Raw Data</a>

                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(Auth::user()->user_level == 2): ?>
                    <div class="col-md-12  ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration & Reports
                        </p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="<?php echo e(route('users')); ?>"><i class="i-Add-User"></i>Users</a>
                            <a href="<?php echo e(route('facilities')); ?>"><i class="i-Hospital"></i>Facilities</a>
                            <a href="<?php echo e(route('il_facilities')); ?>"><i class="i-Hospital1"></i>IL Facilities</a>

                            <a href="<?php echo e(route('all_results')); ?>"><i class="i-Big-Data"></i> All Results</a>
                            <a href="<?php echo e(route('vl_results')); ?>"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="<?php echo e(route('eid_results')); ?>"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="<?php echo e(route('hts_all_results')); ?>"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="<?php echo e(route('vl_srl_raw_data')); ?>"><i class="i-Big-Data"></i> VL Remote Login</a>
                            <a href="<?php echo e(route('eid_srl_raw_data')); ?>"><i class="i-Virus-2"></i> EID Remote Login</a>
                            <a href="<?php echo e(route('hts_srl_raw_data')); ?>"><i class="i-Neutron"></i> HTS Remote Login</a>
                            <a href="<?php echo e(route('sms_report')); ?>"><i class="i-Download-from-Cloud"></i> SMS Report</a>
                            <a href="<?php echo e(route('raw_data_form')); ?>"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(Auth::user()->user_level == 3): ?>
                    <div class="col-md-10 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Adminstration & Reports
                        </p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="<?php echo e(route('users')); ?>"><i class="i-Add-User"></i>Users</a>
                            <a href="<?php echo e(route('all_results')); ?>"><i class="i-Big-Data"></i> All Results</a>
                            <a href="<?php echo e(route('vl_results')); ?>"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="<?php echo e(route('eid_results')); ?>"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="<?php echo e(route('hts_all_results')); ?>"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="<?php echo e(route('vl_srl_raw_data')); ?>"><i class="i-Big-Data"></i> VL Remote Login</a>
                            <a href="<?php echo e(route('eid_srl_raw_data')); ?>"><i class="i-Virus-2"></i> EID Remote Login</a>
                            <a href="<?php echo e(route('hts_srl_raw_data')); ?>"><i class="i-Neutron"></i> HTS Remote Login</a>
                            <a href="<?php echo e(route('raw_data_form')); ?>"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(Auth::user()->user_level == 4): ?>
                    <div class="col-md-6 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="<?php echo e(route('all_results')); ?>"><i class="i-Big-Data"></i> All Results</a>
                            <a href="<?php echo e(route('vl_results')); ?>"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="<?php echo e(route('eid_results')); ?>"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="<?php echo e(route('hts_all_results')); ?>"><i class="i-Neutron"></i> HTS Results</a>
                            <a href="<?php echo e(route('vl_srl_raw_data')); ?>"><i class="i-Big-Data"></i> VL Remote Login</a>
                            <a href="<?php echo e(route('eid_srl_raw_data')); ?>"><i class="i-Virus-2"></i> EID Remote Login</a>
                            <a href="<?php echo e(route('hts_srl_raw_data')); ?>"><i class="i-Neutron"></i> HTS Remote Login</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(Auth::user()->user_level == 5): ?>
                    <div class="col-md-10 p-4 ">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <div class="menu-icon-grid w-auto p-0">
                            <a href="<?php echo e(route('facilities')); ?>"><i class="i-Hospital"></i>Facilities</a>
                            <a href="<?php echo e(route('all_results')); ?>"><i class="i-Big-Data"></i> All Results</a>
                            <a href="<?php echo e(route('vl_results')); ?>"><i class="i-Virus"></i>Viral Loads</a>
                            <a href="<?php echo e(route('eid_results')); ?>"><i class="i-Virus-2"></i> EID Results</a>
                            <a href="<?php echo e(route('hts_all_results')); ?>"><i class="i-Neutron"></i> HTS Results</a>                            <a href="<?php echo e(route('eid_srl_results')); ?>"><i class="i-Neutron"></i> Remote Login</a>
                            <a href="<?php echo e(route('vl_srl_raw_data')); ?>"><i class="i-Big-Data"></i> VL Remote Login</a>
                            <a href="<?php echo e(route('eid_srl_raw_data')); ?>"><i class="i-Virus-2"></i> EID Remote Login</a>
                            <a href="<?php echo e(route('hts_srl_raw_data')); ?>"><i class="i-Neutron"></i> HTS Remote Login</a>
                            <a href="<?php echo e(route('raw_data_form')); ?>"><i class="i-Download-from-Cloud"></i> Raw Data</a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- / Mega menu -->
        <div>
            <p></p>
            <h6> Welcome, <b><?php echo e(ucwords(Auth::user()->f_name)); ?> <?php echo e(ucwords(Auth::user()->l_name)); ?></b>:
                <?php if(Auth::user()->user_level < 2): ?> National Dashboard <?php elseif(Auth::user()->user_level == 2): ?>
                    <?php echo e(Auth::user()->partner->name); ?> Dashboard
                    <?php elseif(Auth::user()->user_level == 3): ?> <?php echo e(Auth::user()->facility->name); ?> Dashboard <b>(MFL:
                        <?php echo e(Auth::user()->facility->code); ?>)</b>
                    <?php elseif(Auth::user()->user_level == 4): ?> <?php echo e(Auth::user()->facility->name); ?> Dashboard <b>(MFL:
                        <?php echo e(Auth::user()->facility->code); ?>)</b>
                    <?php elseif(Auth::user()->user_level == 5): ?> <?php echo e(Auth::user()->county->name); ?> County Dashboard
                    <?php endif; ?> </h6>
        </div>
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>

        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="<?php echo e(asset('assets/images/faces/face.png')); ?>" id="userDropdown" alt="" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> <b><?php echo e(ucwords(Auth::user()->f_name)); ?>

                            <?php echo e(ucwords(Auth::user()->l_name)); ?></b>
                    </div>
                    <a class="dropdown-item"><?php if(Auth::user()->user_level < 2): ?> National <?php elseif(Auth::user()->user_level
                            == 2): ?> <?php echo e(Auth::user()->partner->name); ?>

                            <?php elseif(Auth::user()->user_level == 3): ?> <?php echo e(Auth::user()->facility->name); ?>

                            <?php elseif(Auth::user()->user_level == 4): ?> <?php echo e(Auth::user()->facility->name); ?>

                            <?php elseif(Auth::user()->user_level == 5): ?> <?php echo e(Auth::user()->county->name); ?> County
                            <?php endif; ?></a>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Sign out</a>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- header top menu end -->
