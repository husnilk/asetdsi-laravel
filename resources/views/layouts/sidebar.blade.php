 <div class="left-sidenav">
     <!-- LOGO -->
     <div class="brand">
         <a href="index" class="logo">
             <span>
                 <img src="{{ URL::asset('assets/images/logo-panjang.png') }}" alt="logo-small" class="logo-sm" style="width:130px; height:40px;margin:1rem;">
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
             <li>
                 <a href="{{ url('/') }}" style="text-decoration: none;"> <i data-feather="home" class="align-self-center menu-icon "></i><span class="itam">Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>

             </li>


             <hr class="hr-dashed hr-menu">
             <li class="menu-label my-2 itams">Kelola Menu</li>

             <li>
                 <a href="javascript: void(0);" style="text-decoration: none;"><i data-feather="box" class="align-self-center menu-icon"></i><span class="itam">Aset</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                 <ul class="nav-second-level" aria-expanded="false">
                     <li>
                         <a href="{{route('aset.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Data Aset<span class="menu-arrow left-has-menu">
                                 <i class="mdi mdi-chevron-right"></i></span></a>

                     </li>
                     <li>
                         <a href="{{route('barang.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Data Barang<span class="menu-arrow left-has-menu">
                                 <i class="mdi mdi-chevron-right"></i></span></a>

                     </li>
                     <li>
                         <a href="{{route('jenis.index')}}" style="color: black; text-decoration:none;"><i class="ti-control-record"></i>Jenis Aset<span class="menu-arrow left-has-menu">
                                 <i class="mdi mdi-chevron-right"></i></span></a>

                     </li>

                 </ul>
             </li>

             <li>

                 <a href="{{route('pengadaan.index')}}" style="text-decoration: none;"><i data-feather="list" class="align-self-center menu-icon"></i><span class="itam">Pengadaan</span><span class="menu-arrow">
                         <i class="mdi mdi-chevron-right"></i></span></a>
             </li>

             <li>

                 <a href="widgets" style="text-decoration: none;"><i data-feather="monitor" class="align-self-center menu-icon"></i><span class="itam">Peminjaman</span><span class="menu-arrow">
                         <i class="mdi mdi-chevron-right"></i></span></a>
             </li>

             <li>

                 <a href="widgets" style="text-decoration: none;"><i data-feather="layers" class="align-self-center menu-icon"></i><span class="itam">Distribusi Aset</span><span class="menu-arrow">
                         <i class="mdi mdi-chevron-right"></i></span></a>
             </li>

             <li>

                 <a href="widgets" style="text-decoration: none;"><i data-feather="users" class="align-self-center menu-icon"></i><span class="itam">Pengguna</span><span class="menu-arrow">
                         <i class="mdi mdi-chevron-right"></i></span></a>
             </li>


         </ul>


     </div>
 </div>