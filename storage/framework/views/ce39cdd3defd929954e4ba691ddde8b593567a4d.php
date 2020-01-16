<?php $__env->startSection('page-css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

<div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <h4 class="card-title mb-3">Showing <?php echo e(count($results)); ?>, use the links below to pull results per page.</h4>
                            <div class="col-md-12" style="margin-top:10px; ">
                                <?php echo e($results->onEachSide(5)->links()); ?>

                            </div>
                                <div class="table-responsive">                                    
                                    <table id="multicolumn_ordering_table" class="display table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Patient ID</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Test</th>
                                                <th>Result</th>
                                                <th>Submitted</th>
                                                <th>Released</th>
                                                <th>Sent</th>
                                                <th>Delivered</th>
                                                <th>Read</th>
                                                <th>Facility</th>
                                                <th>Sub-County</th>
                                                <th>County</th>
                                                <th>Partner</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($results) > 0): ?>
                                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr> 
                                                        <td> <?php echo e($loop->iteration); ?></td>
                                                        <td> <?php if(!empty($result->patient_id)): ?> <?php echo e($result->patient_id); ?> <?php else: ?> Not Provided <?php endif; ?></td>
                                                        <td>  <?php echo e($result->age); ?></td>
                                                        <td>  <?php echo e($result->gender); ?></td>
                                                        <td>  <?php echo e($result->test); ?> </td>
                                                        <td>  <?php echo e($result->result_value); ?></td>
                                                        <td>  <?php echo e($result->submit_date); ?></td>
                                                        <td>  <?php echo e($result->date_released); ?></td>
                                                        <td>  <?php echo e($result->date_sent); ?></td>
                                                        <td>  <?php echo e($result->date_delivered); ?></td>    
                                                        <td> <?php if(!empty($result->date_read)): ?> <?php echo e($result->date_read); ?>  <?php else: ?> Unread <?php endif; ?></td>                                                            
                                                        <td>  <?php echo e($result->facility); ?></td>
                                                        <td>  <?php echo e($result->sub_county); ?></td>
                                                        <td>  <?php echo e($result->county); ?></td>
                                                        <td>  <?php echo e($result->partner); ?></td>                                                  
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-js'); ?>

 <script src="<?php echo e(asset('assets/js/vendor/datatables.min.js')); ?>"></script>
 <script type="text/javascript">
   // multi column ordering
   $('#multicolumn_ordering_table').DataTable({
        columnDefs: [{
            targets: [0],
            orderData: [0, 1]
        }, {
            targets: [1],
            orderData: [1, 0]
        }, {
            targets: [4],
            orderData: [4, 0]
        }],
        "paging": true,
        "responsive":true,
        "ordering": true,
        "info": true
    });</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>