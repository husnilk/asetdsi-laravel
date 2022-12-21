@extends('layouts.master')
@section('title') Daftar User AsetDSI @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection


<style>
  /* ukuran font */
  .ukuran-nama {
    font-size: 1rem !important;
    color: #3a3636 !important;
  }

  .ukuran {
    font-size: 1rem !important;
    color: black;
  }

  .table th {
    color: #3a3636 !important;
    text-align: center !important;
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

  .list tr {
    border: unset !important;
  }

  .list tr td {
    border: 1px #ccc solid !important;
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
@slot('li_2') User @endslot
@slot('li_3') Daftar User @endslot
@slot('title') User @endslot
@endcomponent


<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card shadow-sm bg-body rounded">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Daftar List User</h4>

      </div>

      <div class="card-body">
        <!-- <div class="d-flex justify-content-end m-3">
          <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

            <a href="{{route('bangunan.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

              + Tambah Bangunan
            </a>
          </button>

        </div> -->

        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link itam active" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true">Admin</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link itam" id="pj-tab" data-bs-toggle="tab" data-bs-target="#pj" type="button" role="tab" aria-controls="pj" aria-selected="false">Penanggung Jawab</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link itam" id="mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#mahasiswa" type="button" role="tab" aria-controls="mahasiswa" aria-selected="false">Mahasiswa</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <div class="d-flex justify-content-end m-3">
              <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

                <a href="{{route('admin.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                  + Tambah Admin
                </a>
              </button>
            </div>

            <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
              <table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="ukuran">No.</th>
                    <th scope="col" class="ukuran">NIP</th>
                    <th scope="col" class="ukuran">Nama</th>
                    <th scope="col" class="ukuran">Email</th>
                    <th scope="col" class="ukuran">No HP</th>
                    <th scope="col" class="ukuran">Username</th>
                    <th scope="col" class="ukuran noExport" style="width: 10%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($indexAdmin as $i)
                  <tr>
                    <td>
                      <span class="name mb-0 text-md ukuran">{{$loop->iteration}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->nip}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->name}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->email}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->phone_number}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->username}}</span>
                    </td>


                    <td class="text-left d-flex justify-content-center">

                      <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('admin.edit',[$i->id])}}"><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true" data-bs-toggle="tooltip" title="edit admin"></i></a>
                      <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('admin.destroy',[$i->id])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true" data-bs-toggle="tooltip" title="hapus admin"></i></a>

                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
          <div class="tab-pane fade" id="pj" role="tabpanel" aria-labelledby="pj-tab">

            <div class="d-flex justify-content-end m-3">
              <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

                <a href="{{route('pj.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                  + Tambah PJ
                </a>
              </button>

            </div>

            <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
              <table id="table-pj" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="ukuran">No.</th>
                    <th scope="col" class="ukuran">Nama PJ</th>
                    <th scope="col" class="ukuran">Email</th>
                    <th scope="col" class="ukuran">Username</th>

                    <th scope="col" class="ukuran noExport" style="width: 10%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($indexPJ as $i)
                  <tr>
                    <td>
                      <span class="name mb-0 text-md ukuran">{{$loop->iteration}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->pic_name}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->email}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->username}}</span>
                    </td>

                    <td class="text-left d-flex justify-content-center">

                      <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('pj.edit',[$i->id])}}"><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true" data-bs-toggle="tooltip" title="edit penanggung jawab"></i></a>
                      <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('pj.destroy',[$i->id])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true" data-bs-toggle="tooltip" title="hapus penanggung jawab"></i></a>

                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="Mahasiswa" role="tabpanel" aria-labelledby="mahasiswa-tab">

            <div class="d-flex justify-content-end m-3">
              <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

                <a href="{{route('mahasiswa.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                  + Tambah Mahasiswa
                </a>
              </button>

            </div>

            <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
              <table id="table-mahasiswa" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="ukuran">No.</th>
                    <th scope="col" class="ukuran">NIM</th>
                    <th scope="col" class="ukuran">Nama</th>
                    <th scope="col" class="ukuran">Email</th>
                    <th scope="col" class="ukuran">Username</th>
                    <th scope="col" class="ukuran noExport" style="width: 10%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($indexMahasiswa as $i)
                  <tr>
                    <td>
                      <span class="name mb-0 text-md ukuran">{{$loop->iteration}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->nim}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->name}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->email}}</span>
                    </td>
                    <td>
                      <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->username}}</span>
                    </td>


                    <td class="text-left d-flex justify-content-center">

                      <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('mahasiswa.edit',[$i->id])}}"><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true" data-bs-toggle="tooltip" title="edit mahasiswa"></i></a>
                      <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('mahasiswa.destroy',[$i->id])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true" data-bs-toggle="tooltip" title="hapus mahasiswa"></i></a>

                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
        </div>



      </div>

    </div>
  </div>

  <!-- Datatables -->
  <!-- <script src="../../assets/js/plugin/datatables/datatables.min.js"></script> -->
  <script type="text/javascript">
    $.noConflict();
    jQuery(document).ready(function($) {
      $('#table').DataTable();

    });


    jQuery(document).ready(function($) {
      $('#table-pj').DataTable();

    });


    jQuery(document).ready(function($) {
      $('#table-mahasiswa').DataTable();

    });
  </script>



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