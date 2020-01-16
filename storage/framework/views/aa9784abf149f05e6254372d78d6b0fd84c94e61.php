<?php $__env->startSection('before-css'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title mb-3">Add Partner</div>
                            <form role="form" method="post"action="<?php echo e(route('addpartner')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="firstName1">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Partner name">
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>