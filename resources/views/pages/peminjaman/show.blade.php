@extends('layouts.master')
@section('title') Detail Peminjaman @endsection

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

    .table th {
        color: #3a3636 !important;
        text-align: center !important;
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

    .list tr {
        border: unset !important;
    }

    .list tr td {
        border: 1px #ccc solid !important;
    }


    /* Add Animation */

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }

        .buat {
            width: 20rem !important;

        }

        .resp {
            flex-direction: column;

        }

        h5.card-title {
            font-size: 0.9rem;
        }

        h6.card-subtitle {
            font-size: 0.9rem;
        }

    }
</style>


@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Detail @endslot
@slot('li_3') Daftar Barang @endslot
@slot('title') Detail @endslot
@endcomponent


<div class="row mt-2">
    <div class="col-md-12 grid-margin">
        <div class="card shadow-sm bg-body rounded">
            <div class="card-header warna-header">


                <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Detail Peminjaman</h4>

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between m-3 resp">
                    @foreach($indexPeminjaman as $s)
                    <!-- Card header -->
                    <div class="card buat shadow-sm" style="width: 25rem;display:flex;flex-direction:row;">
                        <div class="card-body">
                            <div style="display: flex;align-items:center">
                                <i class="mdi mdi-rename-box" style="color: #1a4d2e;"></i>
                                <h5 class="card-title" style="margin-left: 1rem;color:#1A4D2E">Nama Mahasiswa : {{$s->nama_mahasiswa}}</h5>

                            </div>
                            <div style="display: flex;align-items:center">
                                <i class="mdi mdi-car-door" style="color: #1a4d2e;"> </i>
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Keterangan Peminjaman : {{$s->deskripsi}}</h6>

                            </div>
                            <div style="display: flex;align-items:center">
                                <i class="mdi mdi-calendar" style="color: #1a4d2e;"> </i>
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Untuk Tanggal : {{$s->tanggal}}</h6>

                            </div>

                            <div style="display: flex;align-items:center">
                                <i class="mdi mdi-clock-outline" style="color: #1a4d2e;"> </i>
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Pukul : {{$s->waktu}}</h6>

                            </div>


                        </div>



                    </div>
                    @endforeach


                    <div class="card buat shadow-sm" style="width: 10rem;display:flex;flex-direction:row;">
                        <div class="card-body">
                            <div class="mb-2" style="align-items:center">

                                <h5 class="card-title text-center" style="margin-left: 1rem;color:#1A4D2E">Setujui/Tolak</h5>
                                <hr>

                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm me-2"><a class="ukuran-icon" href="{{route('pj-aset.peminjaman.acc',[$indexItem[0]->loan_id])}}" onclick="return confirm('Yakin Ingin Menyetujui?')">
                                        <i class=" mdi mdi-check" aria-hidden="true" style="color: white;"></i></a>

                                </button>

                                <button class="btn btn-danger btn-sm"><a class="ukuran-icon" href="{{route('pj-aset.peminjaman.reject',[$indexItem[0]->loan_id])}}" onclick="return confirm('Yakin Ingin Menolak?')">
                                        <i class=" mdi mdi-close" aria-hidden="true" style="color: white;"></i></a>

                                </button>
                            </div>


                        </div>
                    </div>

                </div>
                <!-- Light table -->
                <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
                    <table id="table" class="table table-bordered border-dark table-hover align-items-center table-flush pt-2 ">

                        <thead class="thead-light">
                            <tr>

                                <th scope="col" class="ukuran">Nama Barang</th>
                                <th scope="col" class="ukuran" style="width:8%;">Jumlah</th>
                                <th scope="col" class="ukuran">Kode Barang</th>
                                <th scope="col" class="ukuran">Kondisi</th>
                                <th scope="col" class="ukuran" style="width:8%;">Status</th>


                            </tr>
                        </thead>
                        <tbody class="list">

                            @foreach($indexItem as $i)
                            <tr>

                                @if($i->indexPosition=="start")
                                <td style="vertical-align: top;border-bottom:unset !important;">
                                    <span class="name mb-0 text-md ukuran arai " style="display: block;padding-top:10px;">{{$i->merk_barang}}</span>
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


                                <!-- <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->merk_barang}}</span>
                                </td> -->

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

                                <!-- <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->jumlah}}</span>
                                </td> -->
                                <td>

                                    <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->kode}}</span>

                                </td>

                                <td>

                                    <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->kondisi}}</span>

                                </td>
                                <td>

                                    @if ($i->statuspj == 'waiting')
                                    <span class="badge rounded-pill bg-warning name mb-0 text-md p-2" style="display: block;color:black !important;">{{$i->statuspj}}</span>
                                    @elseif ($i->statuspj == 'accepted')
                                    <span class="badge rounded-pill bg-success name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->statuspj}}</span>
                                    @elseif ($i->statuspj == 'rejected')
                                    <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->statuspj}}</span>
                                    @endif


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