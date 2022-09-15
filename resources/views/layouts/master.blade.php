<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Aset DSI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo-pendek.png') }}">
    @include('layouts.head-css')

    

    <style>
        .kepala {
            background: linear-gradient(120deg, #1A4D2E, #1A4D2E, #4bac71) !important;
        }

        .itams {
            color: black !important;
        }

        .itam {
            color: black !important;
        }

        .itam:hover {
            color: #1a4d2e !important;
        }


        .left-sidenav-menu li>a .menu-icon {
            color: #1a4d2e !important;
            fill: rgba(228, 255, 202, 0.8) !important;
        }

        .left-sidenav-menu li>a:hover {
            color: #1a4d2e !important;
        }


        .left-sidenav-menu li>a i {
            color: #1a4d2e !important;
            fill: rgba(228, 255, 202, 0.8) !important;
        }

        .atur {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
        }
    </style>

</head>

<body>
    @include('layouts.sidebar')

    <div class="page-wrapper">
        @include('layouts.topbar')

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>

    </div>
    @include('layouts.vendor-scripts')
</body>

</html>