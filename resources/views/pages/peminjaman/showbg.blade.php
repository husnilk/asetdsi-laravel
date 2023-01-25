@extends('layouts.master')
@section('title') Detail Peminjaman @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
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
@slot('li_3') Daftar Bangunan @endslot
@slot('title') Detail @endslot
@endcomponent


<div class="row mt-2">
    <div class="col-md-12 grid-margin">
        <div class="card shadow-sm bg-body rounded">
            <div class="card-header warna-header">


                <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Detail Peminjaman</h4>

            </div>

            @if (session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
            @endif

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
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Pukul : {{ Carbon\Carbon::parse($s->waktu)->format('H:i') }} - {{ Carbon\Carbon::parse($s->waktu_akhir)->format('H:i') }}</h6>

                            </div>

                            <div style="display: flex;align-items:center">
                                <i class="mdi mdi-car-door" style="color: #1a4d2e;"> </i>

                                @if ($s->statuspj == 'waiting')
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Status :</h6><span class="badge rounded bg-warning name mb-0 text-md p-1 ms-3" style="display: block;color:black !important;">{{$s->statuspj}}</span>
                                @elseif ($s->statuspj == 'accepted')
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Status :</h6><span class="badge rounded bg-success name mb-0 text-md p-1 ms-3" style="display: block;color:white !important;">{{$s->statuspj}}</span>
                                @elseif ($s->statuspj == 'rejected')
                                <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Status :</h6><span class="badge rounded bg-danger name mb-0 text-md p-1 ms-3" style="display: block;color:white !important;">{{$s->statuspj}}</span>
                                @endif




                            </div>


                        </div>



                    </div>
                    @endforeach


                    <div class="card buat shadow-sm" style="width: 10rem;display:flex;flex-direction:row;align-self:flex-start !important">
                        <div class="card-body">
                            <div class="mb-2" style="align-items:center">

                                <h5 class="card-title text-center" style="margin-left: 1rem;color:#1A4D2E">Setujui/Tolak</h5>
                                <hr>

                            </div>
                            @if(count($indexPeminjamanBangunan)>0)
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-sm me-2"><a class="ukuran-icon" id="setuju">
                                        <i class=" mdi mdi-check" aria-hidden="true" style="color: white;" data-bs-toggle="tooltip" title="setuju"></i></a>

                                </button>

                                <button class="btn btn-danger btn-sm"><a class="ukuran-icon" id="tolak">
                                        <i class=" mdi mdi-close" aria-hidden="true" style="color: white;" data-bs-toggle="tooltip" title="tolak"></i></a>

                                </button>
                            </div>
                            @endif

                        </div>
                    </div>

                </div>


                <!-- Light table -->
                <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
                    <table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col" class="ukuran">Nama Bangunan</th>
                                <th scope="col" class="ukuran">Status Bangunan</th>
                                <!-- <th scope="col" class="ukuran" style="width:8%;">Jumlah</th> -->
                                <th scope="col" class="ukuran">Kondisi</th>



                            </tr>
                        </thead>
                        <tbody class="list">


                            @foreach($indexPeminjamanBangunan as $i)
                            <tr>
                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->merk_barang}}</span>
                                </td>

                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->available}}</span>
                                </td>

                                <!-- <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->jumlah}}</span>
                                </td> -->

                                <td>

                                    <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->kondisi}}</span>

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

                <script>
                    $('#setuju').click(function() {
                        const href = "{{route('pj-aset.peminjamanbg.acc',[$indexPeminjamanBangunan[0]->loan_id])}}"
                        Swal.fire({
                            title: 'Confirm Peminjaman',
                            text: "Apakah kamu yakin ingin menyetujui?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#157347',
                            cancelButtonColor: '#bb2d3b',
                            confirmButtonText: 'Setujui',
                            cancelButtonText: 'Batal'
                        }).then(function(result) {
                            if (result.value) {
                                document.location.href = href;
                                Swal.fire(
                                    'Sukses!',
                                    'Peminjaman berhasil disetujui',
                                    'success'
                                )
                            }
                        })
                    });


                    $('#tolak').click(function() {
                       
                        Swal.fire({
                            title: 'Confirm Peminjaman',
                            text: "Apakah kamu yakin ingin menolak?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#157347',
                            cancelButtonColor: '#bb2d3b',
                            confirmButtonText: 'Tolak',
                            cancelButtonText: 'Batal',
                            input: 'textarea',
                            inputPlaceholder: 'Masukkan Alasan Penolakan....'
                        }).then(function(result) {
                            if (result.value) {
                                const value = result?.value || 'cancel'
                                const href = "{{route('pj-aset.peminjamanbg.reject',['id' => $indexPeminjamanBangunan[0]->loan_id,'messages' => ' '])}}" + value
                                document.location.href = href;
                                Swal.fire(
                                    'Sukses!',
                                    'Peminjaman berhasil ditolak',
                                    'success'
                                )
                            }
                        })
                    });
                </script>




                <!-- Card footer -->
            </div>
        </div>

    </div>
</div>

@endsection
@section('script')
<!-- sweeetalert -->
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.sweet-alert.init.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection