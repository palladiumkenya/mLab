<?php $__env->startSection('before-css'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Raw Data</div>

                            <h4>Select any of the filters below, and click Fetch when complete. None is a required field.</h4>
                            <form role="form" method="get"action="<?php echo e(route('fetchraw')); ?>">
                            <?php echo e(csrf_field()); ?>

                                <div class="row">
                                <?php if(Auth::user()->user_level != 3 && Auth::user()->user_level != 4): ?>
                                    <?php if(Auth::user()->user_level < 3): ?>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Partner</label>
                                            <select  class="form-control" data-width="100%" id="partner" name="partner_id">
                                                <option value="">Select Partner</option>
                                                <?php if(Auth::user()->user_level < 2): ?>
                                                    <?php if(count($partners) > 0): ?>
                                                        <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($partner->id); ?>"><?php echo e(ucwords($partner->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if(Auth::user()->user_level == 2): ?>

                                                <option value="<?php echo e(Auth::user()->partner->id); ?>"><?php echo e(ucwords(Auth::user()->partner->name)); ?></option>
                                                <?php endif; ?>

                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">County</label>
                                        <select  class="form-control" data-width="100%" id="county" name="county_id">
                                            <option value="">Select County</option>
                                            <?php if(Auth::user()->user_level == 5): ?>

                                            <option value="<?php echo e(Auth::user()->county->id); ?>"><?php echo e(ucwords(Auth::user()->county->name)); ?></option>
                                            <?php endif; ?>
                                               
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Sub County</label>
                                        <select  class="form-control" data-width="100%" id="sub_county" name="sub_county_id">
                                            <option value="">Select Sub County</option>
                                                
                                        </select>
                                    </div>
                                <?php endif; ?>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Facility</label>
                                        <select  class="form-control" data-width="100%" id="facility" name="code">
                                            <?php if(Auth::user()->user_level != 3 && Auth::user()->user_level != 4): ?>                                            
                                            <option value="">Select Facility</option>
                                            <?php else: ?>

                                            <option value="<?php echo e(Auth::user()->facility->code); ?>"><?php echo e(ucwords(Auth::user()->facility->name)); ?></option>
                                            <?php endif; ?>
                                                
                                        </select>
                                    </div>

                                    <div class='col-sm-6'>
                                        <div class="form-group">
                                            <div class="input-group">
                                            <div class="col-md-4">
                                            <label for="firstName1">From</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="date" id="picker3" class="form-control" data-width="100%" placeholder="YYYY-mm-dd" name="from" >
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary"  type="button">
                                                        <i class="icon-regular i-Calendar-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='col-sm-6'>
                                        <div class="form-group">
                                            <div class="input-group">
                                            <div class="col-md-4">
                                            <label for="firstName1">To</label>
                                            </div>
                                            <div class="col-md-10">

                                                <input type="date" id="picker2" class="form-control" placeholder="YYYY-mm-dd" name="to" >
                                               </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary"  type="button">
                                                        <i class="icon-regular i-Calendar-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom-js'); ?>
<script type="text/javascript">

$('#partner').change(function () {

    $('#county').empty();

    var z = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/get_counties',
        data: {
            "partner_id": z
        },
        dataType: "json",
        success: function (data) {
            var select = document.getElementById("county"),
                opt = document.createElement("option");

                opt.value = "";
                opt.textContent = "Select County";
                select.appendChild(opt);
            for (var i = 0; i < data.length; i++) {
                
            var select = document.getElementById("county"),
                opt = document.createElement("option");

                opt.value = data[i].id;
                opt.textContent = data[i].name;
                select.appendChild(opt);
            }
        }
    })
});

$('#county').change(function () {
    $('#sub_county').empty();

    var x = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/get_subcounties',
        data: {
            "county_id": x
        },
        dataType: "json",
        success: function (data) {

            var select = document.getElementById("sub_county"),
                    opt = document.createElement("option");

                opt.value = "";
                opt.textContent = "Select Sub-County";
                select.appendChild(opt);

            for (var i = 0; i < data.length; i++) {
                var select = document.getElementById("sub_county"),
                    opt = document.createElement("option");

                opt.value = data[i].id;
                opt.textContent = data[i].name;
                select.appendChild(opt);
            }
        }
    })
});

$('#sub_county').change(function () {

    $('#facility').empty();

    var y = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/get_facilities_data',
        data: {
            "sub_county_id": y
        },
        dataType: "json",
        success: function (data) {

            var select = document.getElementById("facility"),
                    opt = document.createElement("option");

                opt.value = "";
                opt.textContent = "Select Facility";
                select.appendChild(opt);

            for (var i = 0; i < data.length; i++) {
                var select = document.getElementById("facility"),
                    opt = document.createElement("option");

                opt.value = data[i].code;
                opt.textContent = data[i].name;
                select.appendChild(opt);
            }
        }
    })
});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>