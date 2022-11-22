<style>
    .background-blue {
        background-color: #e1ecf4 !important;
    }

    .background-default {
        background-color: white !important;
    }


</style>


@php
$isAdmin = Auth::guard('web')->check();
$isPj = Auth::guard('pj')->check();

@endphp
<div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom kepala">
        <ul class="list-unstyled topbar-nav float-end mb-0">

            @if($isAdmin)

            <li class="dropdown notification-list atur">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" style="color:white; height: 100%;
                    display: flex;" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" id="read_notif">
                    <i data-feather="bell" class="align-self-center topbar-icon"></i>
                    <span class="badge bg-danger rounded-pill noti-icon-badge" id="jumlah_notif"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">

                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Notifications <span class="badge bg-primary rounded-pill" id="jumlah_notif_menu"></span>
                    </h6>
                    <div class="notification-menu" data-simplebar>
                        <div id="notification_menu" class="background-blue">

                        </div>
                    </div>
                    <!-- All-->
                    <!-- <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a> -->
                </div>
            </li>

            @elseif($isPj)

            <li class="dropdown notification-list atur">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" style="color:white; height: 100%;
                    display: flex;" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" id="read_notif">
                    <i data-feather="bell" class="align-self-center topbar-icon"></i>
                    <span class="badge bg-danger rounded-pill noti-icon-badge" id="jumlah_notif"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">

                    <h6 class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                        Notifications <span class="badge bg-primary rounded-pill" id="jumlah_notif_menu"></span>
                    </h6>
                    <div class="notification-menu" data-simplebar>
                        <div id="notification_menu" class="background-blue">

                        </div>
                    </div>
                    <!-- All-->

                </div>
            </li>

            @endif
            <li class="dropdown atur">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ (isset(Auth::user()->avatar) && Auth::user()->avatar != '')  ? asset(Auth::user()->avatar) : asset('/assets/images/users/user.png') }}" alt="profile-user" class="rounded-circle thumb-xs" style="background: white; border-radius: 100%; padding:3px;" />
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    @if($isAdmin)
                    <a class="dropdown-item" href="{{route('profile.index')}}"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Profile</a>
                    @endif
                    @if($isPj)
                    <a class="dropdown-item" href="{{route('pj-aset.profile.index')}}"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1"></i> Profile</a>
                    @endif
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> <span key="t-logout">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>



        </ul>
        <!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li class="atur">
                <button class="nav-link button-menu-mobile" style="color:white;">
                    <i data-feather="menu" class="align-self-center topbar-icon"></i>
                </button>
            </li>

        </ul>
    </nav>
    <!-- end navbar-->
</div>


<!-- Notif Admin -->
<script>
    function changeName(object_type) {
        if (object_type == 'pengusulan_barang') {
            return ('Pengusulan Barang');
        }
        if (object_type == 'pengusulan_maintenence') {
            return ('Pengusulan Maintenence');
        }
        if (object_type == 'peminjaman_barang') {
            return ('Peminjaman Barang');
        }
        if (object_type == 'peminjaman_bangunan') {
            return ('Peminjaman Bangunan');
        }
    };

    const notifMenu = document.getElementById('notification_menu')
    const jumlahNotif = document.getElementById('jumlah_notif')
    const jumlahNotifMenu = document.getElementById('jumlah_notif_menu')
    const readNotif = document.getElementById('read_notif');

    function getNotification() {
        $.ajax({
            url: "{{route('notifikasi.index')}}",
            type: "GET",
            success: function(response) {
                var k = response;
                console.log('response---', response);
                const messages = response.data.list;
                jumlahNotif.innerHTML = response.data.unread;
                jumlahNotifMenu.innerHTML = response.data.unread;
                if (response.data.unread === 0) {
                    jumlahNotif.style.display = 'none';
                } else {
                    jumlahNotif.style.display = 'block';
                }

                console.log('panggggggggggggggggggggggggggggggggggggiiiiiiiiiiiiiiiiiiiiiiiiiiiiiil')
                console.log(messages)
                const removeMessage = () => {
                    return new Promise((a,r) =>{
                        setTimeout(() => {
                            messages.map((message) => {
                                const menu = document.getElementById(`notification_menu_${message.id}`);
                                if (menu) {
                                    menu.remove();
                                }
                            })
                            return a(true)
                        }, 500)

                    })
                }

                removeMessage().then(() => {
                    messages.map((message) => {
                    console.log(message.read_at);
                    console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
                   
                    if (message.read_at) {
                        $("#notification_menu").prepend(`

                            <div id="notification_menu_${message.id}" class="background-default">
                            <a href="#" class="dropdown-item py-3">
                                    
                                    <div class="media">
                                        
                                        <div class="media-body align-self-center ms-2 text-truncate">
                                            <h6 class="my-0 fw-normal text-dark">${changeName(message.object_type)}</h6>
                                            <small class="text-muted mb-0">${message.message}</small>
                                        </div>
                                    </div>
                                </a>
                                    </div>

        
                            `);
                        }else {
                        $("#notification_menu").prepend(`

                                <div id="notification_menu_${message.id}" class="background-blue">
                                <a href="#" class="dropdown-item py-3">
                                        
                                        <div class="media">
                                            
                                            <div class="media-body align-self-center ms-2 text-truncate">
                                                <h6 class="my-0 fw-normal text-dark">${changeName(message.object_type)}</h6>
                                                <small class="text-muted mb-0">${message.message}</small>
                                            </div>
                                        </div>
                                    </a>
                                        </div>

                                        

                                `);
                    }          
                
                })
                })
               
            },
            error: function(err) {

                console.log(err);
            }


        });
    }

    function getNotificationCount() {
        $.ajax({
            url: "{{route('notifikasi.index')}}",
            type: "GET",
            success: function(response) {
                var k = response;
                console.log(response);
                const messages = response.data.list;
                jumlahNotif.innerHTML = response.data.unread;
                jumlahNotifMenu.innerHTML = response.data.unread;
                if (response.data.unread === 0) {
                    jumlahNotif.style.display = 'none';
                } else {
                    jumlahNotif.style.display = 'block';
                }
            },
            error: function(err) {

                console.log(err);
            }


        });
    }

    readNotif.addEventListener('click', function(e) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('notifikasi.update')}}",
            type: "POST",
            success: function(response) {
                // cons
                // var k = response;
                console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

                // getNotification()
            }

        })
    });


    notifMenu.addEventListener('mouseleave', function(e) {
        console.log('baca deck')
        getNotificationCount()
    });

    getNotification()
</script>
