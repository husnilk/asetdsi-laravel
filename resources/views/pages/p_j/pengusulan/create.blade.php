@extends('layouts.master')
@section('title') Daftar Pengadaan Aset @endsection

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
@slot('li_1') Faseti @endslot
@slot('li_2') Pengadaan @endslot
@slot('li_3') Tambah Pengadaan @endslot
@slot('title') Pengadaan @endslot
@endcomponent

<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Tambah Pengusulan Barang</h4>

      </div>


      <form action="{{route('pj-aset.pengusulan.store')}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">
            <div class="form-group form-group-default">
              <label>Keterangan</label>
              <input id="proposal_description" name="proposal_description" type="text" class="form-control" placeholder="masukkan keterangan pengusulan barang" required>
            </div>

            <div id="show_item" class="m-2">
              <div class="row border shadow-sm bg-body rounded">


                <div class="container">
                  <div class="row mb-2">
                    <div class="col">
                      <label>Nama Barang</label>
                      <input id="asset_name" name="asset_name[]" type="text" class="form-control" placeholder="masukkan nama barang" required>

                    </div>
                    
                    <div class="col">
                      <label>Detail Spesifikasi</label>
                      <input id="spesification_detail" name="spesification_detail[]" type="text" class="form-control" placeholder="masukkan detail spesifikasi barang" required>

                    </div>
                  </div>
                </div>

                <div class="container">
                  <div class="row mb-2">
                  
                    <div class="col">
                      <label>Jumlah Barang</label>
                      <input id="amount" name="amount[]" type="number" class="form-control" placeholder="masukkan jumlah barang" required>
                    </div>
                    <div class="col">
                      <label>Harga Satuan</label>
                      <input id="unit_price" name="unit_price[]" type="number" class="form-control" placeholder="masukkan harga satuan" required>
                    </div>
                  </div>
                </div>

                <div class="form-group form-group-default ">
                  <label>Sumber Toko</label>
                  <input id="source_shop" name="source_shop[]" type="text" class="form-control" placeholder="masukkan sumber toko" required>
                </div>

              </div>

              <div class="btn-group mt-3 mb-3" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn add_item_btn transisi2" style=" font-size : 12px; text-decoration:unset;  "><i class="fa-solid fa-plus"></i> Tambah Barang</a></button>
              </div>

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
<script>
  $(document).ready(function() {
    $(".add_item_btn").click(function(e) {
      e.preventDefault();
      $("#show_item").prepend(`
      <div id="show_item" class="m-2">
              <div class="row border shadow-sm bg-body rounded">


                <div class="container">
                  <div class="row mb-2">
                    <div class="col">
                      <label>Nama Barang</label>
                      <input id="asset_name" name="asset_name[]" type="text" class="form-control" placeholder="masukkan nama barang" required>

                    </div>
                    <div class="col">
                      <label>Detail Spesifikasi</label>
                      <input id="spesification_detail" name="spesification_detail[]" type="text" class="form-control" placeholder="masukkan detail spesifikasi barang" required>

                    </div>
                   
                  </div>
                </div>

                <div class="container">
                  <div class="row mb-2">
                   
                  <div class="col">
                      <label>Jumlah Barang</label>
                      <input id="amount" name="amount[]" type="text" class="form-control" placeholder="masukkan jumlah barang" required>
                    </div>
                    <div class="col">
                      <label>Harga Satuan</label>
                      <input id="unit_price" name="unit_price[]" type="text" class="form-control" placeholder="masukkan harga satuan" required>
                    </div>
                  </div>
                </div>

                <div class="form-group form-group-default ">
                  <label>Sumber Toko</label>
                  <input id="source_shop" name="source_shop[]" type="text" class="form-control" placeholder="masukkan sumber toko" required>
                </div>

              </div>

              <div class="btn-group mt-3 mb-3" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-danger remove_item_btn" style=" font-size : 12px; text-decoration:unset;"><i class="fa-solid fa-minus"></i> Remove</a></button>
              </div>

            </div>
      
      `);
    });

    $(document).on('click', '.remove_item_btn', function(e) {
      e.preventDefault();
      let hide_item = $(this).parent().parent();
      $(hide_item).remove();
    });


  });
</script>

@endsection
@section('script')
<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection