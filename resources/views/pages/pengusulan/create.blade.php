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

 
 
  .warna-header{
    background-color: rgba(0, 0, 0, 0.03) !important;
  }
 
.col label{
  font-size:1rem !important;
}

.form-group label{
  font-size:1rem !important;
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

        <h4 class="card-title" style="margin-bottom: unset;">Tambah Pengadaan</h4>

      </div>


      <form action="{{route('pengadaan.store')}}" method="post" id="add_form" enctype="multipart/form-data">
      
      {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">
            <div id="show_item">

              <div class="row">
                <div class="col">
                  <label>Nama Barang</label>
                  <input id="nama_barang" name="nama_barang[]" type="text" class="form-control" placeholder="masukkan nama barang" required>

                </div>
                <div class="col">
                  <label>Jumlah Barang</label>
                  <input id="jumlah_barang" name="jumlah_barang[]" type="text" class="form-control" placeholder="masukkan jumlah barang" required>

                </div>
              </div>

              <div class="btn-group mt-3 mb-3" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn add_item_btn transisi2" style=" font-size : 12px; text-decoration:unset;  "><i class="fa-solid fa-plus"></i> Tambah Barang</a></button>
              </div>

            </div>
            <div class="form-group form-group-default">
              <label>Keterangan</label>
              <input id="keterangan_pengadaan" name="keterangan_pengadaan" type="text" class="form-control" placeholder="masukkan keterangan pengadaan" required>
            </div>
            <div class="form-group form-group-default">
              <label for="surat_pengadaan">Surat Pengadaan</label>
              <input type="file" class="form-control form-control-sm" name="surat_pengadaan" id="surat_pengadaan" required>
            </div>


            <div class="form-group form-group-default">
              <label>Nama Mahasiswa</label>
              <input id="nama" name="nama" type="text" class="form-control" placeholder="masukkan nama mahasiswa" required>
            </div>

            <div class="row">
              <div class="col">
                <label>Username</label>
                <input id="username" name="username" type="text" class="form-control" placeholder="masukkan username" required>

              </div>
              <div class="col">
                <label>Password</label>
                <input id="password" name="password" type="text" class="form-control" placeholder="masukkan" required>

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
      <div class="hide append_item">
      <div class="row">
                <div class="col">
                  <label>Nama Barang</label>
                  <input id="nama_barang" name="nama_barang[]" type="text" class="form-control" placeholder="masukkan nama barang" required>
  
                </div>
                <div class="col">
                  <label>Jumlah Barang</label>
                  <input id="jumlah_barang" name="jumlah_barang[]" type="text" class="form-control" placeholder="masukkan jumlah barang" required>

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

    //ajax request to insert all form data
    // $("#add_form").submit(function(e) {
     
    //   e.preventDefault();
    //   $("#add_btn").val('Adding...');
    //   $.ajax({
    //     url: "{{route('pengadaan.store')}}",
    //     method: 'post',
    //     data: new FormData(this),
    //     success: function(response) {
    //     console.log(response);
    //       window.location.href = "pengadaan";
    //       $("#add_btn").val('Add');
    //       $("#add_form")[0].reset();
    //       $(".apend_item").remove();
    //       $("#show_alert").html(`<div class="alert alert-success" role="alert"></div>
    //      `)
    //     }
    //   });
    // });
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