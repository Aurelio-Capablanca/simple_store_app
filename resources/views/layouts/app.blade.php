<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<style>
    footer.footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    main {
        padding-bottom: 60px;
        /* adjust to footer height */
    }
</style>

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.side_panel')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        @yield('content')
        <div class="container-fluid py-2">
            @include('layouts.footer')
        </div>
        @include('layouts.fixed_plugin')
    </main>
    <!--   Core JS Files   -->
    <script src="{{asset('../assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('../assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('../assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('../assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('../assets/js/plugins/chartjs.min.js')}}"></script>
    <script src="{{asset('../assets/js/script_1.js')}}"></script>
    <script src="{{asset('../assets/js/script_2.js')}}"></script>
    <script async defer src="{{asset('https://buttons.github.io/buttons.js')}}"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('../assets/js/material-dashboard.js')}}"></script>
</body>

</html>