@extends('layouts.master')
@section('title') Daftar Pengusulan Aset @endsection

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

  .table th {
    color: #3a3636 !important;
    text-align: center !important;
  }

  .atur {
    display: flex !important;
    align-items: center !important;
  }
</style>


@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Pengusulan @endslot
@slot('li_3') Daftar Pengusulan @endslot
@slot('title') Pengusulan @endslot
@endcomponent


<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card shadow-sm bg-body rounded">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Daftar List Pengusulan Barang</h4>

      </div>

      <div class="card-body">

        <!-- @if(session()->has('notifikasi'))
        <x:notify-messages/>
        @endif -->

        <div class="d-flex justify-content-end m-3 resp">
          <button type="button" class="btn btn-round ml-auto transisi resp" style="line-height:1 !important" data-toggle="modal">

            <a href="{{route('pj-aset.pengusulan.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

              + Pengusulan Aset
            </a>
          </button>

        </div>


        <!-- Card header -->

        <!-- Light table -->
        <div class="table-responsive" style="padding: 40px; padding-top: 10px;">
          <table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
            <thead class="thead-light">
              <tr>

                <th scope="col" class="ukuran" style="width: 15%;">Tanggal Pengusulan</th>
                <th scope="col" class="ukuran">Keterangan</th>

                <th scope="col" class="ukuran" style="width: 15%;">Status Konfirmasi Departemen</th>
                <th scope="col" class="ukuran" style="width: 15%;">Status Konfirmasi Fakultas</th>

                <th scope="col" class="ukuran noExport" style="width: 5%;">Action</th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($indexPengusulan as $i)
              <tr>
                <td>

                  <span class="name mb-0 text-md ukuran arai" style="display: block;">{{ \Carbon\Carbon::parse($i->tanggal)->format('Y-m-d')}}</span>

                </td>
                <td>

                  <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->deskripsi}}</span>

                </td>
                <td>

                  @if ($i->statuspr == 'waiting')
                  <span class="badge rounded-pill bg-warning name mb-0 text-md p-2" style="display: block;color:black !important;">{{$i->statuspr}}</span>
                  @elseif ($i->statuspr == 'accepted')
                  <span class="badge rounded-pill bg-success name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->statuspr}}</span>
                  @elseif ($i->statuspr == 'rejected')
                  <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->statuspr}}</span>
                  @elseif ($i->statuspr == 'cancelled')
                  <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->statuspr}}</span>
                  @endif


                </td>

                <td>

                  @if ($i->status_confirm_faculty == 'waiting')
                  <span class="badge rounded-pill bg-warning name mb-0 text-md p-2" style="display: block;color:black !important;">{{$i->status_confirm_faculty}}</span>
                  @elseif ($i->status_confirm_faculty == 'accepted')
                  <span class="badge rounded-pill bg-success name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->status_confirm_faculty}}</span>
                  @elseif ($i->status_confirm_faculty == 'rejected')
                  <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->status_confirm_faculty}}</span>
                  @elseif ($i->status_confirm_faculty == 'cancelled')
                  <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->status_confirm_faculty}}</span>
                  @endif


                </td>


                <td>
                  <div class="d-flex justify-content-center">
                    <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('pj-aset.pengusulan.show',[$i->id])}}"><i class=" mdi mdi-magnify " style="color:#15b67d;" aria-hidden="true" data-bs-toggle="tooltip" title="lihat detail"></i></a>
                    <!-- <a class="btn btn-sm btn-neutral ukuran-icon" href=""><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true"></i></a>
                  <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true"></i></a> -->
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
            $('#table').DataTable({

              "ordering": false
            });

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