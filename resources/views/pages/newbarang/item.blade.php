@extends('layouts.master')
@section('title') Daftar Inventory Aset @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection


<style>
    @import url('https://fonts.googleapis.com/css?family=Quicksand:400,700');

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

    /* card */
    /* Design */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }



    body {
        color: #272727;
        font-family: 'Quicksand', serif;
        font-style: normal;
        font-weight: 400;
        letter-spacing: 0;
        padding: 1rem;
    }

    .card-custom {
        width: 18rem;
        height: inherit;
        align-items: stretch;
        height: 170;
        display: flex;


    }

    .card-body-custom {
        height: inherit;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 15px !important;
    }

    .card-text-custom {

        flex: 1;
    }

    .icon {
        font-size: 2rem !important;
        color: #1A4D2E;
        align-items: center;
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
@slot('li_2') Inventory @endslot
@slot('li_3') Daftar Inventory @endslot
@slot('title') Inventory @endslot
@endcomponent


<div class="row mt-2">
    <div class="col-md-12 grid-margin">
        <div class="card shadow-sm bg-body rounded">
            <div class="card-header warna-header">

                <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Daftar Penanggung Jawab</h4>

            </div>

            <div class="card-body">
                <div class="container">
                    <div class="row row-cols-4 mt-2">
                        @foreach($pj as $i)
                        <div class="col">
                            <div class="card card-custom shadow-sm" style="width: 18rem;">

                 
                                <div class="card-body card-body-custom">
                                    <i class="mdi mdi-briefcase-account-outline icon mb-3"></i>
                                    <h5 class="card-title" style="text-align: center; color: #1A4D2E !important;">{{$i->pic_name}}</h5>
                                    <p class="card-text card-text-custom" style="text-align: center;">Jumlah</p>
                                    <a href="{{route('newbarang.list',[$i->pic_id])}}" class="btn btn-warning" style="font-size: 9pt;">Lihat Aset</a>
                                </div>


                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>
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