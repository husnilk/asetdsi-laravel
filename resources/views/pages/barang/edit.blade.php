@extends('layouts.master')
@section('title') Edit Barang @endsection

@section('css')
<link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

  .select2-selection--single .select2-selection__rendered {
  color: unset !important;
  line-height: 38px;
}

.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
  background-color: #52525e !important;
  color: white;
}
</style>

@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Aset @endslot
@slot('li_3') Edit Aset @endslot
@slot('title') Aset @endslot
@endcomponent

<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Edit Aset</h4>

      </div>

      
      @foreach($indexBarang as $i)
      <form action="{{route('barang.update',[$i->inventory_id])}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">

          <div class="form-group form-group-default">
              <label>Nama Aset</label>
              <select class="form-select form-group-default" id="asset_id" name="asset_id">
                <option selected value="{{ $i->asset_id }}">{{$i->asset_name}}</option>
                @foreach ($aset as $dt)
                <option value="{{ $dt->asset_id }}">{{$dt->asset_name}}</option>
                @endforeach
              </select>
            </div>

            <hr style=" border-top: 1px dashed">

            <!-- dari sini -->
            <div id="show_item">

              <div class="row border shadow-sm  bg-body rounded">

              <div class="container">
                  <div class="row mb-3">
                    <div class="col">
                      <label>Merk Aset</label>
                      <input id="inventory_brand" name="inventory_brand" type="text" class="form-control" placeholder="masukkan merk aset" value="{{$i->inventory_brand}}" required>
                    </div>

                    <div class="col">
                      <label>Kode Aset</label>
                      <input id="inventory_code" name="inventory_code" type="text" class="form-control" placeholder="masukkan kode aset" value="{{$i->inventory_code}}" required>
                    </div>

                  </div>
                </div>

                <div class="container">
                  <div class="row mb-3">
                    
                    <div class="col">
                      <label>Kondisi Aset</label>
                      <select class="form-select form-group-default" aria-label="condition" id="condition" name="condition">
                        <option selected>{{$i->condition}}</option>
                        <option value="baik">Baik</option>
                        <option value="buruk">Buruk</option>
                      </select>
                    </div>

                    <div class="col">
                      <label>Status</label>
                      <select class="form-select form-group-default" aria-label="available" id="condition" name="available">
                        <option selected>{{$i->available}}</option>
                        <option value="available">Available</option>
                        <option value="not-available">Not Available</option>
                      </select>
                    </div>

                  </div>

                </div>

                <div class="container ">
                  <div class="row mb-3">
                    <div class="col">
                      <label>Lokasi Aset</label>
                      <select class="form-select form-group-default" aria-label="location_id" id="location_id" name="location_id">
                        <option selected value="{{ $i->location_id }}">{{$i->location_name}}</option>
                        @foreach ($lokasi as $dt)
                        <option value="{{ $dt->location_id }}">{{$dt->location_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  

                    <div class="col">
                      <label>Penanggung Jawab Aset</label>
                      <select class="form-select form-group-default" aria-label="pic_id" id="pic_id" name="pic_id">
                        <option selected value="{{ $i->pic_id }}">{{$i->pic_name}}</option>
                        @foreach ($pj as $dt)
                        <option value="{{ $dt->pic_id }}">{{$dt->pic_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>

                </div>

               

                <div class="form-group form-group-default">
                  <label for="photo">Foto</label>
                  <div>
                      <img src="{{$i->photo}}" alt="" style="width: 100px;height:100px;">
                    </div>
                  <input type="file" class="form-control form-control-sm" name="photo" id="photo" value="{{$i->photo}}">
                  
                </div>

              </div>


        


            </div>
            <!-- sampai sini -->

            <div class="field mt-3" style="display: flex; justify-content: flex-end;">
              <button type="submit" name="tambah" class="btn btn-round transisi" id="add_btn">Submit</button>
            </div>


          </div>
        </div>

      </form>
      @endforeach


    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
   $(document).ready(function() {
    console.log($("#asset_id"));
    $('#asset_id').select2()({
      theme: 'bootstrap4',
                    placeholder: "Please Select"
    });

  });
</script>

@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><!-- array bangunan -->
<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection