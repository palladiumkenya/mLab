<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>mLab System</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
<?php echo $__env->yieldContent('before-css'); ?>
    
    <?php echo toastr_css(); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/styles/css/themes/lite-blue.min.css')); ?>">
 <link rel="stylesheet" href="<?php echo e(asset('assets/styles/vendor/perfect-scrollbar.css')); ?>">
 
 <?php echo $__env->yieldContent('page-css'); ?>
</head>

<body>
    <div class="app-admin-wrap">

      <?php echo $__env->make('layouts.header-menu', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">

           <?php echo $__env->yieldContent('main-content'); ?>

            <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <!-- ============ Body content End ============= -->
    </div>
    <!--=============== End app-admin-wrap ================-->

    <!-- ============ Search UI Start ============= -->
  <?php echo $__env->make('layouts.search', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- ============ Search UI End ============= -->


<script src="<?php echo e(asset('assets/js/common-bundle-script.js')); ?>"></script>
    
    <?php echo $__env->yieldContent('page-js'); ?>

    
    
    <script src="<?php echo e(asset('assets/js/es5/script.min.js')); ?>"></script>

    
    <script src="<?php echo e(mix('assets/js/laravel/app.js')); ?>"></script> 

    <?php echo $__env->yieldContent('bottom-js'); ?>
</body>
    <?php echo toastr_js(); ?>
    <?php echo app('toastr')->render(); ?>
</html>
