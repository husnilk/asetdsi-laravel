@extends('layouts.master')
@section('title') Change Password @endsection

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
@slot('title') Change Password @endslot
@endcomponent

<div class="row mt-2">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-header warna-header">

                <h4 class="card-title" style="margin-bottom: unset;">Change Password</h4>

            </div>


            {{csrf_field()}}
            <div class="panel-body m-3">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if($errors)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @endif
                <form class="form-horizontal" autocomplete="off" method="POST" action="{{ route('pj-aset.changePasswordPost') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                        <label for="new-password" class="col-md-4 control-label">Current Password</label>

                        <div class="col-md-12">
                            <input id="current-password" type="password" class="form-control" name="current-password" autocomplete="new-password" required>

                            @if ($errors->has('current-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                        <label for="new-password" class="col-md-4 control-label">New Password</label>

                        <div class="col-md-12">
                            <input id="new-password" type="password" class="form-control" name="new-password" required>

                            @if ($errors->has('new-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new-password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                        <div class="col-md-12">
                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="field mt-3" style="display: flex; justify-content: flex-end;">
                            <button type="submit" name="tambah" class="btn btn-round transisi" id="add_btn"> Change Password</button>
                        </div>

                    
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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