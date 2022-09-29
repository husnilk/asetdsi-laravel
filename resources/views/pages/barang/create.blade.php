@extends('layouts.master')
@section('title') Tambah Barang @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection

<style>
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
    font-size: 13px !important;
  }

  .transisi:hover {

    background-color: #FE9E28 !important;
    color: white;
  }

  .transisi2 {
    background: unset !important;
    background-color: #1A4D2E !important;
    color: white !important;
    border-color: #1A4D2E !important;
  }

  .transisi2:hover {

    background-color: #4bac71 !important;
    color: white;
  }



  .warna-header {
    background-color: rgba(0, 0, 0, 0.03) !important;
  }

  .col label {
    font-size: 1rem !important;
  }

  .form-group label {
    font-size: 1rem !important;
  }
</style>

@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Inventory @endslot
@slot('li_3') Tambah Barang @endslot
@slot('title') inventory @endslot
@endcomponent

<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Tambah Barang</h4>

      </div>


      <form action="{{route('barang.store')}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">

            <div class="form-group form-group-default">
              <label>Nama Aset</label>
              <select class="form-select form-group-default" name="asset_id" id="asset_id">
                <option disabled selected>-Pilih Aset-</option>
                @foreach ($aset as $dt)
                <option value="{{ $dt->id }}">{{$dt->asset_name}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group form-group-default">
              <label>Merk Barang</label>
              <input id="inventory_brand" name="inventory_brand" type="text" class="form-control" placeholder="masukkan nama barang" required>
            </div>

            <div class="form-group form-group-default">
              <label for="photo">Foto</label>
              <input type="file" class="form-control form-control-sm" name="photo" id="photo">
            </div>


            <div class="field mt-3" style="display: flex; justify-content: flex-end;">
              <button type="submit" name="tambah" class="btn btn-round transisi" id="add_btn">Submit</button>
            </div>


          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@endsection
@section('script')
<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection