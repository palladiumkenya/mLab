<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>mLab System</title>
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css">
        @yield('before-css')

        {{-- theme css --}}
        @toastr_css
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-blue.min.css')}}">
        <style>
            #dashboard_overlay {
                position: fixed;
                /* Sit on top of the page content */
                display: block;
                /* Hidden by default */
                width: 100%;
                /* Full width (cover the whole page) */
                height: 100%;
                /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.865);
                /* Black background with opacity */
                z-index: 2;
                /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer;
                /* Add a pointer on hover */
            }
        </style>
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
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        {{-- page specific javascript --}}
        @yield('page-js')

        {{-- theme javascript --}}
        {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
        <script src="{{asset('assets/js/es5/script.min.js')}}"></script>

        {{-- laravel js --}}
        <script src="{{mix('assets/js/laravel/app.js')}}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js">
        </script>

        @yield('bottom-js')
        </script>
    </body>

    @toastr_js
    @toastr_render

</html>