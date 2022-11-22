<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Aset DSI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo-pendek.png') }}">
    @include('layouts.head-css')
    <!-- @notifyCss -->




    @php
    $isAdmin = Auth::guard('web')->check();
    $isPj = Auth::guard('pj')->check();

    @endphp
    <style>
        .kepala {
            background: linear-gradient(120deg, #1A4D2E, #1A4D2E, #4bac71) !important;
        }

        .itams {
            color: black !important;
        }

        .itam {
            color: black !important;
        }

        .itam:hover {
            color: #1a4d2e !important;
        }


        .left-sidenav-menu li>a .menu-icon {
            color: #1a4d2e !important;
            fill: rgba(228, 255, 202, 0.8) !important;
        }

        .left-sidenav-menu li>a:hover {
            color: #1a4d2e !important;
        }


        .left-sidenav-menu li>a i {
            color: #1a4d2e !important;
            fill: rgba(228, 255, 202, 0.8) !important;
        }

        .atur {
            display: flex !important;
            align-items: center !important;
            height: 100% !important;
        }

        /* notif */

        .toast-title {
    font-weight: bold;
}

.toast-message {
    word-wrap: break-word;
}

.toast-message a,
.toast-message label {
    color: #fff;
}

.toast-message a:hover {
    color: #ccc;
    text-decoration: none;
}

.toast-close-button {
    position: relative;
    right: -0.3em;
    top: -0.3em;
    float: right;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.8;
    filter: alpha(opacity=80);
}

.toast-close-button:hover,
.toast-close-button:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: 0.4;
    filter: alpha(opacity=40);
}

/*
    Additional properties for button version
    iOS requires the button element instead of an anchor tag.
    If you want the anchor version, it requires `href="#"`.
 */
button.toast-close-button {
    padding: 0;
    cursor: pointer;
    background: transparent;
    border: 0;
}

.toast-top-center {
    top: 0;
    right: 0;
    width: 100%;
}

.toast-bottom-center {
    bottom: 0;
    right: 0;
    width: 100%;
}

.toast-top-full-width {
    top: 0;
    right: 0;
    width: 100%;
}

.toast-bottom-full-width {
    bottom: 0;
    right: 0;
    width: 100%;
}

.toast-top-left {
    top: 12px;
    left: 12px;
}

.toast-top-right {
    top: 12px;
    right: 12px;
}

.toast-bottom-right {
    right: 12px;
    bottom: 12px;
}

.toast-bottom-left {
    bottom: 12px;
    left: 12px;
}

#toast-container {
    position: fixed;
    z-index: 999999;
}

#toast-container * {
    box-sizing: border-box;
}

#toast-container > div {
    position: relative;
    overflow: hidden;
    margin: 0 0 6px;
    padding: 15px 15px 15px 50px;
    width: 300px;
    border-radius: 3px;
    background-position: 15px center;
    background-repeat: no-repeat;
    transition: box-shadow 0.2s ease-in;
    color: #1A4D2E !important;
    opacity: 0.9;
    filter: alpha(opacity=80);
}

#toast-container > :hover {
    box-shadow: 0 0 12px #000;
    opacity: 1;
    filter: alpha(opacity=100);
    cursor: pointer;
}

#toast-container > .toast::before {
    position: fixed;
    font-family: FontAwesome;
    font-size: 24px;
    line-height: 18px;
    float: left;
    padding-right: 0.5em;
    padding-top: 6px;
    margin: auto 0.5em auto -1.5em;
}

#toast-container > .toast-info::before {
    content: '\f05a';
}

#toast-container > .toast-error::before {
    content: '\f057';
}

#toast-container > .toast-success::before {
    content: '\f058';
}

#toast-container > .toast-warning::before {
    content: '\f06a';
}

#toast-container.toast-top-center > div,
#toast-container.toast-bottom-center > div {
    width: 300px;
    margin: auto;
}

#toast-container.toast-top-full-width > div,
#toast-container.toast-bottom-full-width > div {
    width: 96%;
    margin: auto;
}

.toast {
    background-color: #273138;
    border: 1px solid #313d46;
    border-radius: 4px;
}

.toast-info {
    box-shadow: 0 0 12px #2f96b4;
    background: white !important;
}

/*
    Responsive Design
*/
@media all and (max-width: 240px) {
    #toast-container > div {
        padding: 8px 8px 8px 50px;
        width: 11em;
    }

    #toast-container .toast-close-button {
        right: -0.2em;
        top: -0.2em;
    }
}

@media all and (min-width: 241px) and (max-width: 480px) {
    #toast-container > div {
        padding: 8px 8px 8px 50px;
        width: 18em;
    }

    #toast-container .toast-close-button {
        right: -0.2em;
        top: -0.2em;
    }
}

@media all and (min-width: 481px) and (max-width: 768px) {
    #toast-container > div {
        padding: 15px 15px 15px 50px;
        width: 25em;
    }
}
/* sampai sini notif */
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>
    @include('layouts.sidebar')

    <div class="page-wrapper">
        @include('layouts.topbar')

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
                <!-- @if(session()->has('notifikasi'))
                <x:notify-messages />
                @endif -->
            </div>
            @include('layouts.footer')


            @if($isAdmin)
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
            <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
            <script>
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('f78996b4da73604c205e', {
                    cluster: 'ap1'
                });

                var channel = pusher.subscribe('asetdsi-channel');
                channel.bind('pengusulanaset', function(data) {
                    toastr.info(JSON.stringify(data.message));
                    getNotification();

                });
            </script>
            @elseif($isPj)

            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
            <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
            <script>
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('f78996b4da73604c205e', {
                    cluster: 'ap1'
                });

                var channel = pusher.subscribe('asetdsi-channel');
                channel.bind('peminjamanaset', function(data) {
                    toastr.info(JSON.stringify(data.message));
                    getNotification();

                });
            </script>
            @endif
            <!-- Notif Pj -->
            <!-- <script>
    function changeNamePj(object_type) {
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


    const notifMenuPj = document.getElementById('notification_menu_pj')
    const jumlahNotifPj = document.getElementById('jumlah_notif_pj')
    const jumlahNotifMenuPj = document.getElementById('jumlah_notif_menu_pj')
    const readNotifPj = document.getElementById('read_notif_pj');
    function getNotification() {
        $.ajax({
            url: "{{route('notifikasi.index')}}",
            type: "GET",
            success: function(response) {
                // var k = response;
                console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
                console.log(response.data.list);
                  //         const messages = response.data;
                const messagesPj = response.data.list;
                jumlahNotifPj.innerHTML = response.data.unread;
                jumlahNotifMenuPj.innerHTML = response.data.unread;
                if (response.data.unread === 0) {
                    jumlahNotifPj.style.display = 'none';
                } else {
                    jumlahNotifPj.style.display = 'block';
                }

                messagesPj.map((message) => {
                    console.log(message.read_at);
                    console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
                    if (message.read_at) {

                        $("#notification_menu_pj").prepend(`

                            <div id="notification_menu_pj" class="background-default">
                            <a href="#" class="dropdown-item py-3">
                                    
                                    <div class="media">
                                        
                                        <div class="media-body align-self-center ms-2 text-truncate">
                                            <h6 class="my-0 fw-normal text-dark">${changeNamePj(message.object_type)}</h6>
                                            <small class="text-muted mb-0">${message.message}</small>
                                        </div>
                                    </div>
                                </a>
                                    </div>

        
                            `);
                    } else {
                        $("#notification_menu_pj").prepend(`

                                <div id="notification_menu_pj" class="background-blue">
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
            },
            error: function(err) {

                console.log(err);
            }


        });
    }

    readNotifPj.addEventListener('click', function(e) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('notifikasi.update')}}",
            type: "POST",
            success: function(response) {
                // cons
                // var k = response;
                // console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

                // getNotification()
            }

        })
    });


    notifMenuPj.addEventListener('mouseleave', function(e) {
        getNotification()
    });

    getNotification()
</script> -->

        </div>

    </div>
    @include('layouts.vendor-scripts')

</body>
@notifyJs

</html>