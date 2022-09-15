@extends('layouts.master')
@section('title') Daftar Admin AsetDSI @endsection

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
@slot('li_2') Admin @endslot
@slot('li_3') Tambah Admin @endslot
@slot('title') Admin @endslot
@endcomponent

<div class="row mt-2">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-header warna-header">

        <h4 class="card-title" style="margin-bottom: unset;">Edit Admin</h4>

      </div>


      @foreach($indexAdmin as $i)
      <form action="{{route('admin.update',[$i->id])}}" method="post" id="add_form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="content m-3 p-1">

          <div class="col-12 col-md-12">

            <div class="container">
              <div class="row mb-3">
                <div class="col">
                  <label>NIP</label>
                  <input id="nip" name="nip" type="text" class="form-control" placeholder="masukkan nip" value="{{$i->nip}}" required>
                </div>

                <div class="col">
                  <label>Nama</label>
                  <input id="name" name="name" type="text" class="form-control" placeholder="masukkan nama" value="{{$i->name}}" required>
                </div>

              </div>
            </div>

            <div class="container">
              <div class="row mb-3">
                <div class="col">
                  <label>Email</label>
                  <input id="email" name="email" type="text" class="form-control" placeholder="masukkan email" value="{{$i->email}}" required>
                </div>

                <div class="col">
                  <label>No Hp</label>
                  <input id="phone_number" name="phone_number" type="numbe" class="form-control" placeholder="masukkan no Hp" value="{{$i->phone_number}}" required>
                </div>

              </div>
            </div>


            <div class="container">
              <label style="font-size:1rem !important;">Username</label>
              <input id="username" name="username" type="text" class="form-control" autocomplete="off" placeholder="masukkan username" value="{{$i->username}}" required>
            </div>


            <div class="field mt-3" style="display: flex; justify-content: flex-end;">
              <button type="submit" name="tambah" class="btn btn-round transisi" id="add_btn" style="margin-right: 1.5rem !important;">Edit</button>
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
  var showPassword = document.getElementById('showPassword')
  var password = document.getElementById('password')
  var icon = document.querySelector('#showPassword i')


  showPassword.addEventListener('click', function(e) {
    if (password.type === 'password') {
      password.setAttribute('type', 'text')
      icon.classList.remove('mdi mdi-eye-off')
      icon.classList.add('mdi mdi-eye')
    } else {
      password.setAttribute('type', 'password')
      icon.classList.remove('mdi mdi-eye')

      icon.classList.add('mdi mdi-eye-off')

    }

  })
</script>

@endsection
@section('script')
<script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>
@endsection