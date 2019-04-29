<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>mLab System</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
@yield('before-css')
    {{-- theme css --}}
    @toastr_css
<link rel="stylesheet" href="{{mix('assets/styles/css/themes/lite-blue.min.css')}}">
 <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
 {{-- page specific css --}}
 @yield('page-css')
</head>

<body>
    <div class="app-admin-wrap">

      @include('layouts.header-menu')
      {{-- end of header menu --}}

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">

           @yield('main-content')

            @include('layouts.footer')
        </div>
        <!-- ============ Body content End ============= -->
    </div>
    <!--=============== End app-admin-wrap ================-->

    <!-- ============ Search UI Start ============= -->
  @include('layouts.search')
    <!-- ============ Search UI End ============= -->

{{-- common js --}}
<script src="{{mix('assets/js/common-bundle-script.js')}}"></script>
    {{-- page specific javascript --}}
    @yield('page-js')

    {{-- theme javascript --}}
    {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
    <script src="{{asset('assets/js/es5/script.min.js')}}"></script>

    {{-- laravel js --}}
    <script src="{{mix('assets/js/laravel/app.js')}}"></script> 

    @yield('bottom-js')
</body>
    @toastr_js
    @toastr_render
</html>
