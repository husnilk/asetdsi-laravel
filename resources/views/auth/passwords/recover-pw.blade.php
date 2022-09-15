@extends('layouts.master-without_nav')

{{-- @section('title') Login @endsection  --}}
<style>
    .kepala-log {
        background-color: #FFF !important;
    }

    .accountbg {

        background-color: #FFFF !important;

        /* background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); */
    }
</style>

@section('content')

<body class="account-body accountbg">

    <!-- Recover-pw page -->
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 auth-header-box kepala-log">
                                <div class="text-center p-3">
                                    <a href="index" class="logo logo-admin">
                                        <img src="{{ URL::asset('assets/images/logo-pendek.png') }}" height="60" alt="logo" class="auth-logo">


                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-black font-18">Reset Password For AsetDSI</h4>
                                    <p class="text-muted  mb-0">Enter your Email and instructions will be sent to you!</p>
                                </div>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('forget.password.post') }}" method="POST">

                                    @csrf

                                    <div class="form-group mb-2">
                                        <label class="form-label" for="username">Email</label>
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                                            @if ($errors->has('email'))

                                            <span class="text-danger">{{ $errors->first('email') }}</span>

                                            @endif
                                        </div>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-warning w-100 waves-effect waves-light" type="submit">Reset<i class="fas fa-sign-in-alt ms-1"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                </form>
                                <!--end form-->
                                <p class="text-muted mb-0 mt-3">Remember It ? <a href="login" class="text-primary ms-2">Sign in here</a></p>
                            </div>
                            <div class="card-body bg-light-alt text-center">
                                <span class="text-muted d-none d-sm-inline-block">asetDSI © <script>
                                        document.write(new Date().getFullYear())
                                    </script></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection