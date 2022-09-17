@extends('layouts.master')
@section('title') Daftar Inventory Aset @endsection

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
  background-color:  #52525e !important;
  color: white;
}
</style>

@section('content')
@component('components.breadcrumb')
@slot('li_1') AsetDSI @endslot
@slot('li_2') Inventory @endslot
@slot('li_3') Tambah Inventory @endslot
@slot('title') Inventory @endslot
@endcomponent

<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset; color: #1A4D2E !important;">Tambah Inventory</h4>

      </div>


      <form action="{{route('barang.store')}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">



            <div class="form-group form-group-default">
              <label>Nama Aset</label>
              <select class="form-select form-group-default" id="asset_id" name="asset_id" required>
                <option disabled selected>-Pilih Nama Aset-</option>
                @foreach ($aset as $dt)
                <option value="{{ $dt->asset_id }}">{{$dt->asset_name}}</option>
                @endforeach
              </select>
            </div>



            <hr style=" border-top: 1px dashed">

            <!-- dari sini -->
            <div id="show_item">
              <div class="row border shadow-sm bg-body rounded">

                <div class="container">
                  <div class="row mb-3">
                    <div class="col">
                      <label>Merk Aset</label>
                      <input id="inventory_brand" name="inventory_brand[]" type="text" class="form-control" placeholder="masukkan merk aset" required>
                    </div>

                    <div class="col">
                      <label>Kode Aset</label>
                      <input id="inventory_code"  name="inventory_code[]" type="text" class="form-control inventoryCode" placeholder="masukkan kode aset" readonly>
                    </div>

                  </div>
                </div>

                <div class="container">
                  <div class="row mb-3">
          
                    <div class="col">
                      <label>Kondisi Aset</label>
                      <select class="form-select form-group-default" aria-label="condition" id="condition" name="condition[]">
                        <option selected>Pilih Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="buruk">Buruk</option>
                      </select>
                    </div>

                    <div class="col">
                      <label>Status</label>
                      <select class="form-select form-group-default" aria-label="available" id="condition" name="available[]">
                        <option selected>Pilih Kondisi</option>
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
                      <select class="form-select form-group-default" aria-label="location_id" id="location_id" name="location_id[]">
                        <option selected>Pilih Lokasi</option>
                        @foreach ($lokasi as $dt)
                        <option value="{{ $dt->location_id }}">{{$dt->location_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  

                    <div class="col">
                      <label>Penanggung Jawab Aset</label>
                      <select class="form-select form-group-default" aria-label="pic_id" id="pic_id" name="pic_id[]">
                        <option selected>Pilih Penanggung Jawab</option>
                        @foreach ($pj as $dt)
                        <option value="{{ $dt->pic_id }}">{{$dt->pic_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>

                </div>

               

                <div class="form-group form-group-default">
                  <label for="photo">Foto</label>
                  <input type="file" class="form-control form-control-sm" name="photo[]" id="photo">
                </div>

              </div>

              <div class="btn-group mt-3 mb-3" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn add_item_btn transisi2" style=" font-size : 12px; text-decoration:unset;  "><i class="fa-solid fa-plus"></i> Tambah Barang</a></button>
              </div>
            </div>
            <!-- sampai sini -->


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


<!-- array barang -->
<script>
  $(document).ready(function() {
    $(".add_item_btn").click(function(e) {
      e.preventDefault();
      $("#show_item").prepend(`
      <div class="hide append_item">
      <div class="row border shadow-sm bg-body rounded">

      <div class="container">
                  <div class="row mb-3">
                    <div class="col">
                      <label>Merk Aset</label>
                      <input id="inventory_brand" name="inventory_brand[]" type="text" class="form-control" placeholder="masukkan merk aset" required>
                    </div>

                    <div class="col">
                      <label>Kode Aset</label>
                      <input id="inventory_code" name="inventory_code[]" type="text" class="form-control inventoryCode" placeholder="masukkan kode aset" readonly>
                    </div>

                  </div>
                </div>

                <div class="container">
                  <div class="row mb-3">
                   
                   <div class="col">
                      <label>Kondisi Aset</label>
                      <select class="form-select form-group-default" aria-label="condition" id="condition" name="condition[]">
                        <option selected>Pilih Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="buruk">Buruk</option>
                      </select>
                    </div>

                    <div class="col">
                      <label>Status</label>
                      <select class="form-select form-group-default" aria-label="available" id="condition" name="available[]">
                        <option selected>Pilih Kondisi</option>
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
                      <select class="form-select form-group-default" aria-label="location_id" id="location_id" name="location_id[]">
                        <option selected>Pilih Lokasi</option>
                        @foreach ($lokasi as $dt)
                        <option value="{{ $dt->location_id }}">{{$dt->location_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  

                    <div class="col">
                      <label>Penanggung Jawab Aset</label>
                      <select class="form-select form-group-default" aria-label="pic_id" id="pic_id" name="pic_id[]">
                        <option selected>Pilih Penanggung Jawab</option>
                        @foreach ($pj as $dt)
                        <option value="{{ $dt->pic_id }}">{{$dt->pic_name}}</option>
                        @endforeach
                      </select>
                    </div>

                  </div>

                </div>

               

                <div class="form-group form-group-default">
                  <label for="photo">Foto</label>
                  <input type="file" class="form-control form-control-sm" name="photo[]" id="photo">
                </div>

              </div>
      

              <div class="btn-group mt-3 mb-3" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-danger remove_item_btn" style=" font-size : 12px; text-decoration:unset;"><i class="fa-solid fa-minus"></i> Remove</a></button>
              </div>


              
              </div>
      
      `);
      function makeid(length) {
        var result           = '';
        var characters       = '0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
        }

        const inventoryCode = document.getElementsByClassName('inventoryCode');
        console.log(inventoryCode.length);
        console.log(inventoryCode)

        Array.from(inventoryCode).map((itemHtml, index) => {
          const today = new Date();
          const yyyy = today.getFullYear();
          let mm = today.getMonth() + 1; // Months start at 0!
          let dd = today.getDate();
          var seconds = today.getSeconds();
          var minutes = today.getMinutes();
          var hour = today.getHours();
          // if (index ===  - 1) {
            // itemHtml.value = `DSI-${dd}${mm}${yyyy}-0${inventoryCode.length - index}`
            if(index === 0) {

              itemHtml.value = `DSI-${dd}${mm}${yyyy}-0${hour}${minutes}${seconds}${makeid(3)}`
            }
          // }
        })
    });

    $(document).on('click', '.remove_item_btn', function(e) {
      e.preventDefault();
      let hide_item = $(this).parent().parent();
      $(hide_item).remove();
    });

    $(document).ready(function() {
    console.log($("#asset_id"));
    $('#asset_id').select2()({
      theme: 'bootstrap4',
                    placeholder: "Please Select"
    });

  });

  });

  const inventoryCode = document.getElementsByClassName('inventoryCode');
  document.addEventListener('DOMContentLoaded', (event) => {
  //the event occurred
  // console.log(inventoryCode.length);
 
  function makeid(length) {
        var result           = '';
        var characters       = '0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
        }
  Array.from(inventoryCode).map((itemHtml, index) => {
    
    // if (index ===  - 1) {
      const today = new Date();
      const yyyy = today.getFullYear();
      let mm = today.getMonth() + 1; // Months start at 0!
      let dd = today.getDate();
      let seconds = today.getSeconds();
      let minutes = today.getMinutes();
      let hour = today.getHours();
      // if (index ===  - 1) {
        // itemHtml.value = `DSI-${dd}${mm}${yyyy}-0${inventoryCode.length - index}`
      if(index === 0) {
        itemHtml.value = `DSI-${dd}${mm}${yyyy}-0${hour}${minutes}${seconds}${makeid(3)}`
      }
      // itemHtml.value = `DSI-${dd}${mm}${yyyy}-0${inventoryCode.length - index}`
    // }
  })

  console.log(JSON.parse(inventoryCode))
  })
</script>

<!-- angka -->


<script src="main.js"></script>




@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><!-- array bangunan -->
<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection