@extends('layouts.master')
@section('title') Daftar Aset Bangunan @endsection

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

  .atur {
    display: flex !important;
    align-items: center !important;
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
    max-width: 700px;
    height: 150px;
    /* height: 100%; */
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
@slot('li_2') Bangunan @endslot
@slot('li_3') Daftar Bangunan @endslot
@slot('title') Bangunan @endslot
@endcomponent


<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card shadow-sm bg-body rounded">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset;">Daftar List Bangunan</h4>

      </div>

      <div class="card-body">
        <div class="d-flex justify-content-end m-3">
          <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

            <a href="{{route('bangunan.create')}}" class="button" style="color:black !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

              + Tambah Bangunan
            </a>
          </button>

        </div>

        <!-- Card header -->

        <!-- Light table -->
        <div class="table-responsive" style="padding: 40px; padding-top: 10px;">
          <table id="table" class="table align-items-center table-flush pt-2 ">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="ukuran">No.</th>
                <th scope="col" class="ukuran">Nama Aset</th>
                <th scope="col" class="ukuran">Nama Bangunan</th>
                <th scope="col" class="ukuran">Kode Aset</th>
                <th scope="col" class="ukuran">Jumlah Aset</th>
                <th scope="col" class="ukuran">Kondisi</th>
                <th scope="col" class="ukuran">Penanggung Jawab</th>
                <th scope="col" class="ukuran">Status</th>
                <th scope="col" class="ukuran" style="width: 3%;">Foto</th>

                <th scope="col" class="ukuran noExport" style="width: 10%;">Action</th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($newAset as $i)
              <tr>
                <td>
                  <span class="name mb-0 text-md ukuran">{{$loop->iteration}}</span>
                </td>
                <td>
                  <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->asset_name}}</span>
                </td>

                <td>
                  @foreach($i->requests as $a)
                  <span class="name mb-0 text-md ukuran arai" style="display: block;padding-top:10px;">{{$a->building_name}}</span>
                  @endforeach
                </td>
                
                <td>
                  @foreach($i->requests as $a)
                  <span class="name mb-0 text-md ukuran arai" style="display: block;padding-top:10px;">{{$a->building_code}}</span>
                  @endforeach
                </td>
                <td>
                  <span class="name mb-0 text-md ukuran" style="display: block;padding-top:10px;">{{ $i->jumlah }}</span>
                </td>
                <td>
                  @foreach($i->requests as $a)
                  <span class="name mb-0 text-md ukuran" style="display: block;padding-top:10px;">{{$a->condition}}</span>
                  @endforeach
                </td>
                <td>
                  @foreach($i->requests as $a)
                  <span class="name mb-0 text-md ukuran" style="display: block;padding-top:10px;">{{$a->pic_name}}</span>
                  @endforeach
                </td>
                <td style="vertical-align: top;">
                  @foreach($i->requests as $a)
                  <span class="badge bg-warning name mb-0 text-md text-dark ukuran" style="display: block;margin-top:10px !important;line-height:1 !important; margin-bottom:5px !important;">{{$a->available}}</span>
                  @endforeach
                </td>
                <td>
                  @foreach($i->requests as $a)
                  @if($a->photo==null)

                  <span class="name mb-0 text-md ukuran " style="color: white;" style="display: block;padding-top:10px;">

                    <button type="button" class="btn btn-round ml-auto transisi3" style="line-height:1 !important; margin-bottom:5px;" data-toggle="modal">

                      <a img_data="{{ URL::asset('assets/images/default-image.jpg')}}" id="myImg" class="button" style="color:white !important; text-decoration:none; font-size:0.9rem;">

                        @php
                        $path="assets/images/default-image.jpg";
                        @endphp
                        <a onclick="gg(this, ('{{ URL::asset($path)}}') , '{{$a->building_name}}')" class="button" id="myImg" style="color:white !important; text-decoration:none; font-size:0.9rem;">

                          Lihat
                        </a></span>

                  @else

                  <span class="name mb-0 text-md ukuran " style="color: white;" style="display: block;padding-top:10px;">
                    <button type="button" class="btn btn-round ml-auto transisi3" style="line-height:1 !important; margin-bottom:5px;" data-toggle="modal">

                      <a onclick="gg(this, ('{{$a->photo}}'), '{{$a->building_name}}' )" class="button" id="myImg" style="color:white !important; text-decoration:none; font-size:0.9rem;">

                        Lihat
                      </a>
                  </span>

                  @endif

                  <!-- The Modal -->
                  <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption">kecoak</div>
                  </div>
                  @endforeach
                </td>

                <td class="text-left">
                @foreach($i->requests as $a)
                  <a class="btn btn-sm btn-neutral ukuran-icon" href="{{route('bangunan.edit',[$a->building_id])}}"><i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true" data-bs-toggle="tooltip" title="edit barang"></i></a>
                 
                  <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('bangunan.destroy',[$a->building_id])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true" data-bs-toggle="tooltip" title="hapus barang"></i></a>
               @endforeach
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
              dom: 'Bfrtip',
              buttons: [{
                  extend: 'copy',
                  className: "warna1"
                },
                {
                  extend: 'csv',
                  className: "warna2"
                },
                {
                  extend: 'excel',
                  className: "warna3"
                },
                {
                  extend: 'pdf',
                  className: "warna4",
                  exportOptions: {
                    columns: "thead th:not(.noExport)",


                  },

                  pageSize: 'A4', //A3 , A5 , A6 , legal , letter

                },
                {

                  extend: 'print',
                  className: "warna5",
                  // customize: function(win) {
                  //   $(win.document.body).find('table').addClass('display').css('font-size', '9px');

                  //   $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                  //     $(this).css('background-color', '#D0D0D0');

                  //   })

                  //   ;
                  //   $(win.document.body).find('h1').css('text-align', 'center');
                  // },

                  exportOptions: {
                    //columns : [0,1,2,4],
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                      body: function(inner, rowidx, colidx, node) {
                        if (node.classList.contains('bg_red')) {
                          return '<span class="bg_red">' + inner + '</span>';
                        } else if (node.classList.contains('bg_yellow')) {
                          return '<span class="bg_yellow">' + inner + '</span>';
                        } else if (node.classList.contains('bg_green')) {
                          return '<span class="bg_green">' + inner + '</span>';
                        } else {
                          return inner;
                        }
                      }
                    }
                  },
                  customize: function(win, butt, tbl) {
                    $(win.document.body).find('span.bg_red').parent().css('background-color', 'red');
                    $(win.document.body).find('span.bg_yellow').parent().css('background-color', 'yellow');
                    $(win.document.body).find('span.bg_green').parent().css('background-color', 'green');
                    $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                      $(this).css('background-color', '#D0D0D0');

                    })
                  }
                }









              ],



            });

          });

          $(document).ready(function() {
            // Function to convert an img URL to data URL
            function getBase64FromImageUrl(url) {
              var img = new Image();
              img.crossOrigin = "anonymous";
              img.onload = function() {
                var canvas = document.createElement("canvas");
                canvas.width = this.width;
                canvas.height = this.height;
                var ctx = canvas.getContext("2d");
                ctx.drawImage(this, 0, 0);
                var dataURL = canvas.toDataURL("image/png");
                return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
              };
              img.src = url;
            }
            // DataTable initialisation
            $('#example').DataTable({
              "dom": '<"dt-buttons"Bf><"clear">lirtp',
              "paging": true,
              "autoWidth": true,
              "buttons": [{
                text: 'Custom PDF',
                extend: 'pdfHtml5',
                filename: 'dt_custom_pdf',
                orientation: 'landscape', //portrait
                pageSize: 'A4', //A3 , A5 , A6 , legal , letter
                exportOptions: {
                  columns: ':visible',
                  search: 'applied',
                  order: 'applied'
                },
                customize: function(doc) {
                  //Remove the title created by datatTables
                  doc.content.splice(0, 1);
                  //Create a date string that we use in the footer. Format is dd-mm-yyyy
                  var now = new Date();
                  var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                  // Logo converted to base64
                  // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');
                  // The above call should work, but not when called from codepen.io
                  // So we use a online converter and paste the string in.
                  // Done on http://codebeautify.org/image-to-base64-converter
                  // It's a LONG string scroll down to see the rest of the code !!!
                  var logo = 'data:image/jpeg;base64,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ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA=';
                  // A documentation reference can be found at
                  // https://github.com/bpampuch/pdfmake#getting-started
                  // Set page margins [left,top,right,bottom] or [horizontal,vertical]
                  // or one number for equal spread
                  // It's important to create enough space at the top for a header !!!
                  doc.pageMargins = [20, 60, 20, 30];
                  // Set the font size fot the entire document
                  doc.defaultStyle.fontSize = 7;
                  // Set the fontsize for the table header
                  doc.styles.tableHeader.fontSize = 7;
                  // Create a header object with 3 columns
                  // Left side: Logo
                  // Middle: brandname
                  // Right side: A document title
                  doc['header'] = (function() {
                    return {
                      columns: [{
                          image: logo,
                          width: 24
                        },
                        {
                          alignment: 'left',
                          italics: true,
                          text: 'dataTables',
                          fontSize: 18,
                          margin: [10, 0]
                        },
                        {
                          alignment: 'right',
                          fontSize: 14,
                          text: 'Custom PDF export with dataTables'
                        }
                      ],
                      margin: 20
                    }
                  });
                  // Create a footer object with 2 columns
                  // Left side: report creation date
                  // Right side: current page and total pages
                  doc['footer'] = (function(page, pages) {
                    return {
                      columns: [{
                          alignment: 'left',
                          text: ['Created on: ', {
                            text: jsDate.toString()
                          }]
                        },
                        {
                          alignment: 'right',
                          text: ['page ', {
                            text: page.toString()
                          }, ' of ', {
                            text: pages.toString()
                          }]
                        }
                      ],
                      margin: 20
                    }
                  });
                  // Change dataTable layout (Table styling)
                  // To use predefined layouts uncomment the line below and comment the custom lines below
                  // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
                  var objLayout = {};
                  objLayout['hLineWidth'] = function(i) {
                    return .5;
                  };
                  objLayout['vLineWidth'] = function(i) {
                    return .5;
                  };
                  objLayout['hLineColor'] = function(i) {
                    return '#aaa';
                  };
                  objLayout['vLineColor'] = function(i) {
                    return '#aaa';
                  };
                  objLayout['paddingLeft'] = function(i) {
                    return 4;
                  };
                  objLayout['paddingRight'] = function(i) {
                    return 4;
                  };
                  doc.content[0].layout = objLayout;
                }
              }]
            });
          });
        </script>


        <!-- modal foto -->
        <script>
          // Mendapatkan modal
          var modal = document.getElementById("myModal");

          // Dapatkan gambar dan sisipkan di dalam modal - gunakan teks "alt" sebagai keterangan
          var img = document.getElementById("myImg");
          var modalImg = document.getElementById("img01");
          var captionText = document.getElementById("caption");

          function gg(e, val, alt) {
            console.log(val);
            modal.style.display = "block";
            modalImg.src = val;
            captionText.innerHTML = alt;
          }

          // Dapatkan elemen <span> yang menutup modal
          var span = document.getElementsByClassName("close")[0];
          // When the user clicks on <span> (x), close the modal
          span.onclick = function() {
            modal.style.display = "none";
          }
          //
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