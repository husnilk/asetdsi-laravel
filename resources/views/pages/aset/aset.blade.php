@extends('layouts.master')
@section('title') Daftar Aset @endsection

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

  .table th {
    color: #3a3636 !important;
    text-align: center !important;
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
    margin-right: 2rem !important;
    padding: 0.8rem !important;
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

  .list tr {
    border: unset !important;
  }

  .list tr td {
    border: 1px #ccc solid !important;
  }


  .atur {
    display: flex !important;
    align-items: center !important;
  }
  

   /* 100% Image Width on Smaller Screens */
   @media only screen and (max-width: 700px) {
    .transisi{
            margin: unset !important;
        }
    }
 
</style>


@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Aset @endslot
@slot('li_3') Daftar Barang @endslot
@slot('title') Aset @endslot
@endcomponent


<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card shadow-sm bg-body rounded">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Daftar List Aset</h4>

      </div>

      <div class="card-body">
        <div class="d-flex justify-content-end m-3 resp">
          <button type="button" class="btn btn-round ml-auto transisi resp" style="line-height:1 !important" data-toggle="modal">

            <a href="{{route('aset.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

              + Tambah Aset
            </a>
          </button>

        </div>

        <!-- Card header -->

        <!-- Light table -->
        <div class="table-responsive" style="padding: 40px; padding-top: 10px;">
          <table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="ukuran ukuran fw-bold" style="width:5%">No.</th>
                <th scope="col" class="ukuran ukuran fw-bold ">Jenis Aset</th>
                <th scope="col" class="ukuran ukuran fw-bold ">Nama Aset</th>


                <th scope="col" class="ukuran  ukuran fw-bold noExport">Action</th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($indexAset as $i)
              <tr>
                <td>
                  <span class="name mb-0 text-md ukuran">{{$loop->iteration}}</span>
                </td>
                <td>
                  <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->type_name}}</span>
                </td>
                <td>
                  <span class="name mb-0 text-md ukuran">{{$i->asset_name}}</span>
                </td>


                <td>
                  <div class="d-flex justify-content-center">
                    <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('aset.edit',[$i->id_aset])}}"><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true"></i></a>
                    <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('aset.destroy',[$i->id_aset])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true"></i></a>
                  </div>
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Datatables -->
        <!-- <script src="../../assets/js/plugin/datatables/datatables.min.js"></script> -->
        <script type="text/javascript">
          $.noConflict();
          jQuery(document).ready(function($) {
            $('#table').DataTable();

          });
        </script>


        <!-- Card footer -->
      </div>
    </div>

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