@extends('layouts.master')
@section('title') Daftar User AsetDSI @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection


<style>
  /* ukuran font */
  .ukuran {
    font-size: 1rem !important;
    color: black;
  }

  .ukuran-icon {
    font-size: 1.2rem !important;

  }

  .warna-header {
    background-color: rgba(0, 0, 0, 0.03) !important;
  }

  /* warna button */
  .warna1 {
    background: unset !important;
    background-color: #206A5D !important;
    color: white !important;
    border-color: #206A5D !important;
    transition: all 0.5s;
    cursor: pointer;
  }

  .warna1 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;

  }

  .warna1 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .warna1:hover span {
    padding-right: 25px;
  }

  .warna1:hover span:after {
    opacity: 1;
    right: 0;
  }


  .warna2 {
    background: unset !important;
    background-color: #81B214 !important;
    color: white !important;
    border-color: #81B214 !important;
  }

  .warna2 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }

  .warna2 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .warna2:hover span {
    padding-right: 25px;
  }

  .warna2:hover span:after {
    opacity: 1;
    right: 0;
  }

  .warna3 {
    background: unset !important;
    background-color: #FFCC29 !important;
    color: black !important;
    border-color: #FFCC29 !important;
  }

  .warna3 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }

  .warna3 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .warna3:hover span {
    padding-right: 25px;
  }

  .warna3:hover span:after {
    opacity: 1;
    right: 0;
  }


  .warna4 {
    background: unset !important;
    background-color: #7042da !important;
    color: white !important;
    border-color: #7042da !important;
  }

  .warna4 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }

  .warna4 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .warna4:hover span {
    padding-right: 25px;
  }

  .warna4:hover span:after {
    opacity: 1;
    right: 0;
  }

  .warna5 {
    background: unset !important;
    background-color: #15b67d !important;
    color: white !important;
    border-color: #15b67d !important;
  }

  .warna5 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }

  .warna5 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .warna5:hover span {
    padding-right: 25px;
  }

  .warna5:hover span:after {
    opacity: 1;
    right: 0;
  }

  .transisi {
    position: relative;
    background-color: #ffaf00 !important;
    border: none;

    color: #FFFFFF;

    text-align: center;
    -webkit-transition-duration: 0.4s;
    /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;

    padding: 0.8rem !important;
    margin-right: -0.2rem !important;
  }

  .transisi:hover {

    background-color: #FE9E28 !important;
    color: white;
  }


  .transisi3 {
    position: relative;
    background-color: #1A4D2E !important;
    border: none;

    color: #FFFFFF;

    text-align: center;
    -webkit-transition-duration: 0.4s;
    /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
    margin-right: 2rem !important;
    padding: 0.8rem !important;
  }

  .transisi3:hover {

    background-color: #4bac71 !important;
    color: white;
  }


  /* warna header */

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 1px solid #338f00;

    background: #1A4D2E;
  }

  .arai {
    display: block;
  }

  td.bg_red {
    background-color: red;
  }

  td.bg_yellow {
    background-color: yellow;
  }

  td.bg_green {
    background-color: green;
  }

  .atur {
    display: flex !important;
    align-items: center !important;
  }


  .nav-tabs .nav-item.show .nav-link,
  .nav-tabs .nav-link.active {
    color: #1A4D2E !important;
    background-color: #fff !important;
    border-color: #dee2e6 #dee2e6 #fff !important;
  }

  .nav-link .itam {
    display: block;
    padding: .5rem 1rem;
    color: black !important;
    text-decoration: none;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out;
  }

  /* modal foto */
  #foto {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  #foto:hover {
    opacity: 0.7;
  }

  /* The Modal (background) */
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9);
    /* Black w/ opacity */
  }

  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 60%;
    max-width: 600px;
  }

  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation */
  .modal-content,
  #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {
      -webkit-transform: scale(0)
    }

    to {
      -webkit-transform: scale(1)
    }
  }

  @keyframes zoom {
    from {
      transform: scale(0)
    }

    to {
      transform: scale(1)
    }
  }

  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  .ijau{
    color: #1A4D2E !important;
  }


  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px) {
    .modal-content {
      width: 100%;
    }
  }
</style>


@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('title') Profile @endslot
@endcomponent


<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card shadow-sm bg-body rounded">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Profil</h4>

      </div>
      @foreach($indexPJ as $i)
      <form action="{{route('pj-aset.profile.update',[$i->id])}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="card-body">

          <div class="content-wrapper">
            <!-- Content Header (Page header) -->


            <!-- Content Header (Page header) -->
            <div class="content">

              <div class="row">
                <div class="col-md-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ URL::asset('assets/images/users.png')}}" alt="Admin" class="rounded" width="150">

                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0 fw-bold ijau">Nama Penanggung Jawab</h6>
                        </div>
                        <div class="col-sm-9">
                        {{$i->pic_name, Auth::user()->username}}
                        </div>
                      </div>
                   
                    
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0 fw-bold ijau">Email</h6>
                        </div>
                        <div class="col-sm-9">
                        {{$i->email, Auth::user()->username}}
                        </div>
                      </div>
                    
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0 fw-bold ijau">Username</h6>
                        </div>
                        <div class="col-sm-9">
                        {{$i->username, Auth::user()->username}}
                        </div>
                      </div>
                      <hr>


                      <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight"> <a class="btn btn-warning" target="__blank" href="{{route('pj-aset.profile.edit')}}">
                        <i class=" mdi mdi-pencil " style="color: black;"></i>
                        Edit</a></div>
                        <div class="p-2 bd-highlight"> <a class="btn btn-danger" target="__blank" href="{{ route('pj-aset.changePasswordGet') }}">
                        <i class=" mdi mdi-lock-outline " style="color: white;"></i>
                      
                        Change Password</a></div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>

            </div>


          </div>
        </div>

      </form>
      @endforeach
    </div>
    <!-- Card footer -->
  </div>
</div>



@endsection
@section('script')

<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection