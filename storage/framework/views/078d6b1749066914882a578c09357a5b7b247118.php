<?php $__env->startSection('page-css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3"><?php echo e(count($facilities)); ?> Facilties</h4>
                            <?php if(Auth::user()->user_level == 2): ?>
                            <div style="margin-bottom:10px; ">
                                <a type="button" href="<?php echo e(route('addfacilityform')); ?>" class="btn btn-primary btn-md pull-right">Add Facility</a>
                            </div>  
                            <?php endif; ?>
                            
                            <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>MFL</th>
                                                <th>Level</th>
                                                <?php if(Auth::user()->user_level < 2): ?>
                                                <th>Partner</th>
                                                <?php endif; ?>
                                                <th>Sub County</th>
                                                <th>County</th>
                                                <th>Phone No.</th>
                                                <th>Date Added</th>
                                                <?php if(Auth::user()->user_level == 2): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($facilities) > 0): ?>
                                                <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr> 
                                                        <td> <?php echo e($loop->iteration); ?></td>
                                                        <td> <?php echo e(ucwords($facility->name)); ?></td>
                                                        <td>  <?php echo e($facility->code); ?></td>
                                                        <td>  <?php echo e($facility->keph_level); ?></td>
                                                        <?php if(Auth::user()->user_level < 2): ?>
                                                        <td>  <?php echo e(ucwords($facility->partner->name)); ?></td>
                                                        <?php endif; ?>
                                                        <td>  <?php echo e(ucwords($facility->sub_county->name)); ?></td>
                                                        <td>  <?php echo e(ucwords($facility->sub_county->county->name)); ?></td>
                                                        <td>  <?php echo e($facility->mobile); ?></td>
                                                        <td>  <?php echo e(date('Y-m-d', strtotime($facility->updated_at))); ?></td>
                                                        <?php if(Auth::user()->user_level == 2): ?>
                                                        <td> 
                                                            <button onclick="editFacility(<?php echo e($facility); ?>);" data-toggle="modal" data-target="#editFacility" type="button" class="btn btn-primary btn-sm">Edit</button>
                                                            <button onclick="removeFacility(<?php echo e($facility->id); ?>);"type="button" class="btn btn-danger btn-sm">Remove</button>
                                                        </td>
                                                        <?php endif; ?>
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

                <div id="editFacility" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                        
                        <div class="card-title mb-3">Edit facility</div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                        <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form role="form" method="post"action="<?php echo e(route('edit_facility')); ?>">
                            <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="firstName1">Facility Name</label>
                                        <input type="text" class="form-control"  readonly id="name" name="name" >
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="lastName1">MFL Code</label>
                                        <input type="text" class="form-control" readonly id="code" name="code" >
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="exampleInputEmail1">County</label>
                                        <input type="text" class="form-control" readonly id="county" name="county" >
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Sub-County</label>
                                        <input class="form-control" id="subcounty" readonly name="subcounty" >
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="phone">Phone Number</label>
                                        <input class="form-control" id="phone" name="phone" >
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

                <div id="RemoveModal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Remove Facility</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove this Facility?</p>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                            <button id="remove" type="button" class="btn btn-danger" >Remove</button>
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

function editFacility(facility){

    console.log(facility);

    $('#name').val(facility.name);
    $('#code').val(facility.code);
    $('#county').val(facility.sub_county.county.name);
    $('#subcounty').val(facility.sub_county.name);
    $('#phone').val(facility.mobile);
}



function removeFacility(id){
    $('#RemoveModal').modal('show');

    $(document).off("click", "#remove").on("click", "#remove", function (event) {
        $.ajax({
            type: "POST",
            url: '/remove/facility',
            data: {
                "id": id, "_token": "<?php echo e(csrf_token()); ?>"
            },
            dataType: "json",
            success: function (data) {
                toastr.success(data.details);
                $('#RemoveModal').modal('hide');
            }
        })
    });

}

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>