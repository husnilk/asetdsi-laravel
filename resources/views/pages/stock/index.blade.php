@extends('layouts.master')
@section('title') Detail inventory @endsection

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

                @foreach ($selected as $s)

                <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Detail Barang {{$s->inventory_brand}}</h4>

            </div>

            <div class="card-body">

                <!-- Card header -->
                <div class="card buat shadow-sm" style="width: 25rem;display:flex;flex-direction:row;">
                    <div class="card-body">
                        <div style="display: flex;align-items:center">
                            <i class="mdi mdi-rename-box" style="color: #1a4d2e;"></i>
                            <h5 class="card-title" style="margin-left: 1rem;color:#1A4D2E">Nama Aset : {{$s->asset_name}}</h5>

                        </div>
                        <div style="display: flex;align-items:center">
                            <i class="mdi mdi-car-door" style="color: #1a4d2e;"> </i>
                            <h6 class="card-subtitle text-dark" style="margin-left: 1rem;">Merk Barang : {{$s->inventory_brand}}</h6>

                        </div>
                    </div>
                    <img alt="img" src="{{$s->photo}}" style="width:80px;object-fit:cover;" />
                </div>
                @endforeach
                <!-- Light table -->
                <div class="table-responsive" style="padding: 10px; padding-top: 10px;">
                    <table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col" class="ukuran">kode Barang</th>
                                <th scope="col" class="ukuran" style="width:8%;">Kondisi</th>
                                <th scope="col" class="ukuran">Penanggung Jawab</th>
                                <th scope="col" class="ukuran">Lokasi Barang</th>
                                <th scope="col" class="ukuran" style="width:8%;">Status</th>
                                <th scope="col" class="ukuran" style="width:8%;">Action</th>

                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($indexItem as $i)
                            <tr>


                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->item_code}}</span>
                                </td>
                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->condition}}</span>
                                </td>
                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->pic_name}}</span>
                                </td>
                                <td>
                                    <span class="name mb-0 text-md ukuran">{{$i->location_name}}</span>
                                </td>
                                <td style="vertical-align: top;">
                                    @if ($i->available == 'available')
                                    <span class="badge rounded-pill bg-warning name mb-0 text-md p-2" style="display: block;color:black !important;">{{$i->available}}</span>
                                    @else ($i->available' == 'not-available')
                                    <span class="badge rounded-pill bg-danger name mb-0 text-md p-2" style="display: block;color:white !important;">{{$i->available}}</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-sm btn-neutral ukuran-icon">
                                            <i class=" mdi mdi-pencil " style="color: green;" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$i->item_id}}"></i></a>
                                        <a class="btn btn-sm btn-neutral brgdeletebtn ukuran-icon" href="{{route('stock.destroy',[$i->item_id])}}" onclick="return confirm('Yakin Ingin Menghapus?')"><i class=" mdi mdi-delete " style="color: red;" aria-hidden="true"></i></a>

                                        @foreach($indexItem as $data)
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal-{{$data->item_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color:#1A4D2E !important;">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('stock.update',[$data->item_id])}}" method="post" id="add_form" enctype="multipart/form-data">

                                                        <div class="modal-body">


                                                            {{csrf_field()}}
                                                            <div class="content m-3 p-1">

                                                                <div class="col-12 col-md-12">

                                                                    <div class="row mb-3">

                                                                        <div class="col">
                                                                            <label>Kondisi Aset</label>
                                                                            <select class="form-select form-group-default" aria-label="condition" id="condition" name="condition">
                                                                                <option selected>{{$data->condition}}</option>
                                                                                <option value="baik">baik</option>
                                                                                <option value="buruk">buruk</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>



                                                                    <div class="row mb-3">

                                                                        <div class="col">
                                                                            <label>Status</label>
                                                                            <select class="form-select form-group-default" aria-label="available" id="condition" name="available">
                                                                                <option selected>{{$data->available}}</option>
                                                                                <option value="available">available</option>
                                                                                <option value="not-available">not Available</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>




                                                                    <div class="row mb-3">

                                                                        <div class="col">
                                                                            <label>Penanggung Jawab Aset</label>
                                                                            <select class="form-select form-group-default" aria-label="pic_id" id="pic_id" name="pic_id">
                                                                                <option selected value="{{ $data->pic_id }}">{{ $data->pic_name }}</option>
                                                                                @foreach ($pj as $dt)
                                                                                <option value="{{ $dt->id }}">{{$dt->pic_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                    </div>



                                                                    <div class="row mb-3">
                                                                        <div class="col">
                                                                            <label>Lokasi Aset</label>
                                                                            <select class="form-select form-group-default" aria-label="location_id" id="location_id" name="location_id">
                                                                                <option selected value="{{ $data->location_id }}">{{ $data->location_name }}</option>
                                                                                @foreach ($lokasi as $dt)
                                                                                <option value="{{ $dt->id }}">{{$dt->location_name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning">Save changes</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach
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