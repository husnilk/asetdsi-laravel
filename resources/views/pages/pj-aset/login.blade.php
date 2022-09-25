@extends('layouts.master-without_nav')

@section('title') Login @endsection

<style>
    .kepala-log{
        background-color: #FFF !important;
    }
    .accountbg {
 
        background-color: #FFFF !important;
       
/* background-image: linear-gradient(to top, #d9afd9 0%, #97d9e1 100%); */
}
    </style>
@section('content')

<body class="account-body accountbg">


<div class="container">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card shadow-sm bg-body rounded">
                        <div class="card-body p-0 auth-header-box kepala-log shadow-sm">
                            <div class="text-center p-4">
                                
                                    <img src="{{ URL::asset('assets/images/logo-pendek.png') }}" height="60" alt="logo" class="auth-logo">
                               
                                <h4 class="mt-3 mb-1 fw-semibold text-black font-18">Selamat Datang</h4>
                                <p class="text-muted  mb-0 font-12">Silahkan Masuk</p>
                            </div>
                        </div>
                        <div class="card-body p-0">
                           
                            <!-- Tab panes -->
                            <div class="tab-content p-2">
                                <div class="tab-pane active  p-3" id="LogIn_Tab" role="tabpanel">

                                    @if(Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            {{Session::get('success')}}
                                        </div>
                                    @endif
                                    <form class="form-horizontal auth-form" method="POST" action="{{ route('pj-aset.login') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Username</label>
                                            <div class="input-group">
                                                <input name="username" class="form-control @error('username') is-invalid @enderror" id="username"  value="{{ old('username')}}" placeholder="Masukkan username" autofocus required>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="userpassword">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword" placeholder="Masukkan password" aria-label="Password" aria-describedby="password-addon">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row my-3">
                                          
                                            <!--end col-->
                                            <div class="text-end">
                                                @if (Route::has('password.request'))
                                                <a href="{{ route('forget.password.get') }}" class="text-muted">Forgot password?</a>
                                                @endif
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <button class="btn btn-warning w-100 waves-effect waves-light" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->
                                    </form>
                                    <!--end form-->
                                    
                                </div>
                                
                            </div>
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