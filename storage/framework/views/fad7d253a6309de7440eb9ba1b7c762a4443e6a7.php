<?php $__env->startSection('page-css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3"><?php echo e(count($users)); ?> Users</h4>
                            
                            <div style="margin-bottom:10px; ">
                                <a type="button" href="<?php echo e(route('adduserform')); ?>" class="btn btn-primary btn-md pull-right">Add User</a>
                            </div>
                                <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Level</th>
                                                <?php if(Auth::user()->user_level < 2): ?>
                                                <th>Affiliation</th>
                                                <?php endif; ?>
                                                <?php if(Auth::user()->user_level == 2): ?>
                                                <th>Facility</th>
                                                <?php endif; ?>
                                                <th>Status</th>
                                                <th>Date Added</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($users) > 0): ?>
                                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr> 
                                                        <td> <?php echo e($loop->iteration); ?></td>
                                                        <td> <?php echo e(ucwords($user->f_name)); ?> <?php echo e(ucwords($user->l_name)); ?></td>
                                                        <td>  <?php echo e($user->phone_no); ?></td>
                                                        <td>  <?php echo e($user->email); ?></td>
                                                        <td>  <?php if($user->user_level == '0'): ?> National <?php endif; ?>
                                                              <?php if($user->user_level == '1'): ?> National <?php endif; ?>
                                                              <?php if($user->user_level == '2'): ?> Partner <?php endif; ?>
                                                              <?php if($user->user_level == '3'): ?> Facility <?php endif; ?>
                                                              <?php if($user->user_level == '4'): ?> Facility <?php endif; ?>
                                                              <?php if($user->user_level == '5'): ?> County <?php endif; ?>
                                                        </td>
                                                        <?php if(Auth::user()->user_level < 2): ?>
                                                            <td>  <?php if(!empty($user->partner)): ?> <?php echo e($user->partner->name); ?><?php elseif(!empty($user->county)): ?> <?php echo e($user->county->name); ?> County <?php else: ?> None <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if(Auth::user()->user_level == 2): ?>
                                                            <td> <?php echo e($user->facility->name); ?> </td>
                                                        <?php endif; ?>

                                                        </td>
                                                        <td>  <?php echo e($user->status); ?></td>
                                                        <td>  <?php echo e(date('Y-m-d', strtotime($user->created_at))); ?></td>
                                                        <td>
                                                            <button onclick="editUser(<?php echo e($user); ?>);" data-toggle="modal" data-target="#editUser" type="button" class="btn btn-primary btn-sm">Edit</button>
                                                            <button onclick="resetUser(<?php echo e($user->id); ?>);"type="button" class="btn btn-success btn-sm">Reset</button>
                                                            <button onclick="deleteUser(<?php echo e($user->id); ?>);"type="button" class="btn btn-danger btn-sm">Delete</button>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                     
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>
                <!-- end of col -->


                <div id="editUser" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                        
                        <div class="card-title mb-3">Edit User</div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form role="form" method="post"action="<?php echo e(route('edituser')); ?>">
                            <?php echo e(csrf_field()); ?>

                                <div class="row">
                                <input type="hidden" name="id" id="uid">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">First name</label>
                                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter your first name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="lastName1">Last name</label>
                                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter your last name">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" id="phone" name="phone" placeholder="Enter phone">
                                    </div>
                                    <?php if(Auth::user()->user_level == 2): ?> 
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">County</label>
                                            <select  class="form-control" data-width="100%" id="county" name="county_id">
                                                <option value="">Select County</option>
                                                    <?php if(count($counties) > 0): ?>
                                                        <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($county->id); ?>"><?php echo e(ucwords($county->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Sub County</label>
                                            <select  class="form-control" data-width="100%" id="sub_county" name="sub_county_id">
                                                <option value="">Select Sub County</option>
                                                    <?php if(count($subcounties) > 0): ?>
                                                        <?php $__currentLoopData = $subcounties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcounty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($subcounty->id); ?>"><?php echo e(ucwords($subcounty->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="firstName1">Facility</label>
                                            <select  class="form-control" data-width="100%" id="facility" name="code">
                                                <option value="">Select Facility</option>
                                                <?php if(count($facilities) > 0): ?>
                                                        <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($facility->code); ?>"><?php echo e(ucwords($facility->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">User Level</label>
                                        <select id ="level" name="level" class="form-control">
                                            <option >Select</option>
                                        <?php if(Auth::user()->user_level < 2): ?> 
                                            <option value="1">National</option>
                                            <option value="2">Partner</option>
                                            <option value="5">County</option>
                                            <option value="3">Facility Admin</option>
                                            <option value="4">Facility User</option>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->user_level == 2): ?>
                                            <option value="3">Facility Admin</option>
                                            <option value="4">Facility User</option>
                                        <?php endif; ?> 
                                        <?php if(Auth::user()->user_level == 3): ?>
                                            <option value="4">Facility User</option>
                                        <?php endif; ?> 
                                        </select>
                                    </div>

                                    <?php if(Auth::user()->user_level < 2): ?> 
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="picker1">Affiliation</label>
                                            <input id="affiliation" class="form-control" readonly  placeholder="Select Affiliation">
                                            <select hidden class="form-control" data-width="100%" id="county" name="county_id">
                                                <option value="">Select County</option>
                                                    <?php if(count($counties) > 0): ?>
                                                        <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($county->id); ?>"><?php echo e(ucwords($county->name)); ?> County</option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                            <select hidden class="form-control" data-width="100%" id="partner" name="partner_id">
                                                <option value="">Select Partner</option>
                                                    <?php if(count($partners) > 0): ?>
                                                        <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($partner->id); ?>"><?php echo e(ucwords($partner->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                            </select>
                                        
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="picker1">Status</label>
                                        <select id ="status" name="status" class="form-control">
                                            <option >Select</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>                                     
                                        </select>
                                    </div>
                        
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        </div>

                    </div>
                </div>


            <div id="ResetModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to reset this user's password?.</p>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                        <button id="reset" type="button" class="btn btn-success" data-person_id="">Reset</button>
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>


            <div id="DeleteModal" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Delete this user's password?.</p>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                        <button id="delete" type="button" class="btn btn-danger" data-person_id="">Delete</button>
                    </div>
                    <div class="modal-footer">
                       
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

 <script src="<?php echo e(asset('assets/js/vendor/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/datatables.script.js')); ?>"></script>
<script type="text/javascript">

$('#level').on('change', function() {
  var level = this.value;

  if(level == 1){
    $('#affiliation').val("National");
    $('#affiliation').removeAttr('hidden');
    $('#partner').attr("hidden",true);
    $('#county').attr("hidden",true);
  }
  if(level == 2){
    $('#partner').removeAttr('hidden');
    $('#affiliation').attr("hidden",true);
    $('#county').attr("hidden",true);
  }
  if(level == 5){
    $('#county').removeAttr('hidden');
    $('#partner').attr("hidden",true);
    $('#affiliation').attr("hidden",true);
  }
  
});


function editUser(user){

    var p = <?php echo Auth:: user(); ?>;
    if(p.user_level < 2){
        if (user.user_level < 2){
            $('#affiliation').val('National');
        }
        if (user.user_level == 2){
            $('#partner').removeAttr('hidden');
            $('#affiliation').attr("hidden",true);
            $('#county').attr("hidden",true);
            $('#partner').val(user.partner.id);
        }
        if (user.user_level == 5){
            $('#county').removeAttr('hidden');
            $('#partner').attr("hidden",true);
            $('#affiliation').attr("hidden",true);
            $('#county').val(user.county.id);
        }
        if (user.user_level == 3 || user.user_level == 4){
            $('#partner').removeAttr('hidden');
            $('#affiliation').attr("hidden",true);
            $('#county').attr("hidden",true);
            $('#partner').val(user.partner.id);
        }
    }
    $('#fname').val(user.f_name);
    $('#lname').val(user.l_name);
    $('#email').val(user.email);
    if(p.user_level > 1){
        $('#county').val(user.facility.sub_county.county.id);
        $('#sub_county').val(user.facility.sub_county.id);
        $('#facility').val(user.facility.code);

    }
    $('#phone').val(user.phone_no);
    $('#uid').val(user.id);
    $('#level').val(user.user_level);
    $('#status').val(user.status);
    $('#email').val(user.email);

}


function resetUser(uid){
    $('#ResetModal').modal('show');

    $(document).off("click", "#reset").on("click", "#reset", function (event) {
        $.ajax({
            type: "POST",
            url: '/reset/user',
            data: {
                "uid": uid, "_token": "<?php echo e(csrf_token()); ?>"
            },
            dataType: "json",
            success: function (data) {
                toastr.success(data.details);
                $('#ResetModal').modal('hide');
            }
        })
    });

}

function deleteUser(uid){
    $('#DeleteModal').modal('show');

               
    console.log(uid);
    $(document).off("click", "#delete").on("click", "#delete", function (event) {
        $.ajax({
            type: "POST",
            url: '/delete/user',
            data: {
                "uid": uid, "_token": "<?php echo e(csrf_token()); ?>"
            },
            dataType: "json",
            success: function (data) {
                toastr.success(data.details);
                $('#DeleteModal').modal('hide');
            }
        })
    });

}


$('#county').change(function () {

$("#sub_county").empty();

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

$("#facility").empty();

var y = $(this).val();
$.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    url: '/get_partner_facilities_mlab',
    data: {
        "sub_county_id": y
    },
    dataType: "json",
    success: function (data) {

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