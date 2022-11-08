@php
$isAdmin = Auth::guard('web')->check();
$isPj = Auth::guard('pj')->check();

@endphp

<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand">
        <a href="index" class="logo">
            <span>
                <img src="{{ URL::asset('assets/images/logo-panjang-new.png') }}" alt="logo-small" class="logo-sm" style="width:130px; height:40px;margin:1rem;">
            </span>
            <!-- <span>
                    <img src="{{ URL::asset('assets/images/logo.png') }}" alt="logo-large" class="logo-lg logo-light">
                    <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg logo-dark">
                </span> -->
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0 itams">Main</li>
            @if($isAdmin)

            <li>
                <a href="{{ url('/') }}" style="text-decoration: none;"> <i data-feather="home" class="align-self-center menu-icon "></i><span class="itam">Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>

            </li>

            @elseif($isPj)
            <li>
                <a href="{{ url('/') }}" style="text-decoration: none;"> <i data-feather="home" class="align-self-center menu-icon "></i><span class="itam">Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>

            </li>
            @endif

            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2 itams">Kelola Menu</li>
            @if($isAdmin)

            <li>
                <a href="javascript: void(0);" style="text-decoration: none;"><i data-feather="box" class="align-self-center menu-icon"></i><span class="itam">Aset</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('aset.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Data Aset<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>

                    <li>
                        <a href="{{route('lokasi.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Lokasi Aset<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>


                </ul>
            </li>

            <li>

                <a href="{{route('barang.index')}}" style="text-decoration: none;"><i data-feather="layers" class="align-self-center menu-icon"></i><span class="itam">Aset Barang</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            <li>

                <a href="{{route('bangunan.index')}}" style="text-decoration: none;"><i data-feather="grid" class="align-self-center menu-icon"></i><span class="itam">Aset Bangunan</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            <li>

                <a href="{{route('newbarang.item')}}" style="text-decoration: none;"><i data-feather="airplay" class="align-self-center menu-icon"></i><span class="itam">Aset Penanggung Jawab</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>


            <li>

                <a href="{{route('rekap.index')}}" style="text-decoration: none;"><i data-feather="printer" class="align-self-center menu-icon"></i><span class="itam">Rekap Aset</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            <li>

                <a href="{{route('admin.index')}}" style="text-decoration: none;"><i data-feather="users" class="align-self-center menu-icon"></i><span class="itam">Pengguna</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            @elseif($isPj)

            <li>
                <a href="javascript: void(0);" style="text-decoration: none;"><i data-feather="box" class="align-self-center menu-icon"></i><span class="itam">Aset</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('pj-aset.aset.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Data Aset<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>

                    <li>
                        <a href="{{route('pj-aset.lokasi.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Lokasi Aset<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>


                </ul>
            </li>

            <li>

                <a href="{{route('pj-aset.barang.index')}}" style="text-decoration: none;"><i data-feather="layers" class="align-self-center menu-icon"></i><span class="itam">Aset Barang</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            <li>

                <a href="{{route('pj-aset.bangunan.index')}}" style="text-decoration: none;"><i data-feather="grid" class="align-self-center menu-icon"></i><span class="itam">Aset Bangunan</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            <li>
                <a href="javascript: void(0);" style="text-decoration: none;"><i data-feather="archive" class="align-self-center menu-icon"></i><span class="itam">Peminjaman Aset</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('pj-aset.peminjaman.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Peminjaman Barang<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>

                    <li>
                        <a href="{{route('pj-aset.peminjamanbangunan.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Peminjaman Bangunan<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>


                </ul>
            </li>



            <li>
                <a href="javascript: void(0);" style="text-decoration: none;"><i data-feather="folder-plus" class="align-self-center menu-icon"></i><span class="itam">Pengusulan Aset</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('pj-aset.pengusulan.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Pengusulan Aset Barang<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>

                    <li>
                        <a href="{{route('pj-aset.pengusulanmt.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Maintenence Aset<span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i></span></a>

                    </li>


                </ul>
            </li>


          
            
            <li>

                <a href="{{route('pj-aset.returnaset.index')}}" style="text-decoration: none;"><i data-feather="external-link" class="align-self-center menu-icon"></i><span class="itam">Pengembalian Aset</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>



            <li>

                <a href="{{route('pj-aset.rekap.index')}}" style="text-decoration: none;"><i data-feather="printer" class="align-self-center menu-icon"></i><span class="itam">Rekap Aset</span><span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i></span></a>
            </li>

            @endif
        </ul>


    </div>
</div>