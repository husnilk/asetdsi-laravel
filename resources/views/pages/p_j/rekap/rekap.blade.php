@extends('layouts.master')
@section('title') Rekap Aset Departemen Sistem Informasi @endsection

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
        background-color: #4E9525 !important;
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
    }

    .transisi:hover {

        background-color: #67b33b !important;
        color: white;
    }

    .transisi2 {
        position: relative;
        background-color: #2E5A1C !important;
        border: none;

        color: #FFFFFF;

        text-align: center;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
        text-decoration: none;
        overflow: hidden;
        cursor: pointer;
        margin-right: 1rem !important;
        padding: 0.8rem !important;
    }

    .transisi2:hover {

        background-color: #396926 !important;
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

    .transisi4 {
        position: relative;
        background-color: #FF5C00 !important;
        border: none;

        color: #FFFFFF;

        text-align: center;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
        text-decoration: none;
        overflow: hidden;
        cursor: pointer;
        margin-right: 1rem !important;
        padding: 0.8rem !important;
    }

    .transisi4:hover {

        background-color: #fa6816 !important;
        color: white;
    }

    /* page */
    .page-item.active .page-link {
        z-index: 3;
        color: #fff !important;
        background-color: #1A4D2E !important;
        border-color: #1A4D2E !important;
    }

    .page-link:hover {
        z-index: 2;
        color: #1A4D2E !important;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-link {
        position: relative;
        display: block;
        color: #1A4D2E !important;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
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
@slot('li_2') Rekap @endslot
@slot('li_3') Aset @endslot
@slot('title') Rekap Aset @endslot
@endcomponent


<div class="row mt-2">
    <div class="col-md-12 grid-margin">
        <div class="card shadow-sm bg-body rounded">
            <div class="card-header warna-header">

                <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Rekap Aset</h4>

            </div>

            <div class="card-body">
                <div class="d-flex justify-content-end me-5 mt-3">
                    <button type="button" class="btn btn-round ml-auto transisi4" style="line-height:1 !important" data-toggle="modal">

                        <i class=" mdi mdi-printer " style="color: white;" data-bs-toggle="tooltip" title="print"><a href="{{route('pj-aset.rekap.print')}}" class="button" style="color:white !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                                Rekap Aset Keseluruhan 
                            </a></i>


                    </button>
                    <button type="button" class="btn btn-round ml-auto transisi2" style="line-height:1 !important" data-toggle="modal">

                        <i class=" mdi mdi-printer " style="color: white;" data-bs-toggle="tooltip" title="print"><a href="{{route('pj-aset.rekap.printbarang')}}" class="button" style="color:white !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                                Rekap Aset Barang
                            </a></i>


                    </button>
                    <button type="button" class="btn btn-round ml-auto transisi" style="line-height:1 !important" data-toggle="modal">

                        <i class=" mdi mdi-printer " style="color: white;" data-bs-toggle="tooltip" title="print"><a href="{{route('pj-aset.rekap.printbangunan')}}" class="button" style="color:white !important; text-decoration:none; font-size:0.9rem;" class=" mdi mdi-plus">

                                Rekap Aset Bangunan
                            </a></i>


                    </button>

                </div>

                <!-- Card header -->

                <!-- Light table -->
                <div class="table-responsive mt-3" style="padding: 40px; padding-top: 10px;">
                    <table id="table" class="table table-bordered border-dark table-hover align-items-center table-flush pt-2 ">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="ukuran fw-bold">Nama Aset</th>
                                <th scope="col" class="ukuran fw-bold" style="width: 5%;">Jumlah Aset</th>
                                <th scope="col" class="ukuran fw-bold">Merk Barang</th>
                                <th scope="col" class="ukuran fw-bold">Kode Aset</th>
                                <th scope="col" class="ukuran fw-bold">Kondisi</th>
                                <th scope="col" class="ukuran fw-bold">Penanggung Jawab</th>
                                <th scope="col" class="ukuran fw-bold">Status</th>
                                <th scope="col" class="ukuran fw-bold" style="width: 3%;">Foto</th>


                            </tr>
                        </thead>

                        <tbody class="list">
                            @foreach($indexItem as $i)
                            <tr>

                                @if($i->indexPosition=="start")
                                <td style="vertical-align: top;border-bottom:unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;">{{$i->nama_aset}}</span>
                                </td>
                                @elseif($i->indexPosition=="middle")
                                <td style="vertical-align: top;border-top: unset !important; border-bottom: unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;"></span>
                                </td>
                                @else
                                <td style="vertical-align: top;border-top: unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;"></span>
                                </td>
                                @endif


                                @if($i->indexPosition=="start")
                                <td style="vertical-align: top;border-bottom: unset !important">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;">{{$i->jumlah}}
                                    </span>
                                </td>
                                @elseif($i->indexPosition=="middle")
                                <td style="vertical-align: top;border-top: unset !important; border-bottom: unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;">
                                    </span>
                                </td>
                                @else
                                <td style="vertical-align: top;border-top: unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;">
                                    </span>
                                </td>
                                @endif

                                <td style="vertical-align: top;">

                                    <span class="name mb-0 text-md ukuran arai" style="display: block;padding-top:10px;">{{$i->nama_barang}}</span>

                                </td>

                                <td style="vertical-align: top;">

                                    <span class="name mb-0 text-md ukuran arai" style="display: block;padding-top:10px;">{{$i->kode_aset}}</span>

                                <td style="vertical-align: top;">

                                    <span class="name mb-0 text-md ukuran" style="display: block;padding-top:10px;">{{$i->kondisi}}</span>

                                </td>
                                <td style="vertical-align: top;">

                                    <span class="name mb-0 text-md ukuran" style="display: block;padding-top:10px;">{{$i->pj}}</span>

                                </td>
                                <td style="vertical-align: top;">
                                    @if ($i->status == 'available')
                                    <span class="badge rounded-pill bg-warning name mb-0 text-md p-2" style="display: block;margin-top:10px !important;line-height:1 !important; margin-bottom:5px !important;color:black !important;">{{$i->status}}</span>
                                    @else ($i->status' == 'not-available')
                                    <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;margin-top:10px !important;line-height:1 !important; margin-bottom:5px !important; color:white !important;">{{$i->status}}</span>
                                    @endif
                                </td>
                                <td style="vertical-align: top;">
                                    <span class="name mb-0 text-md ukuran d-flex justify-content-center" style="color: white;" style="display: block;padding-top:10px;">
                                        <button type="button" class="btn btn-round ml-auto transisi3 " style="line-height:1 !important; margin-bottom:5px;" data-toggle="modal">

                                            <a onclick="gg(this, ('{{$i->photo}}'), '{{$i->nama_barang}}' )" class="button" id="myImg" style="color:white !important; text-decoration:none; font-size:0.9rem;">

                                                Lihat
                                            </a>
                                    </span>


                                    <!-- The Modal -->
                                    <div id="myModal" class="modal">
                                        <span class="close">&times;</span>
                                        <img class="modal-content" id="img01">
                                        <div id="caption">kecoak</div>
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