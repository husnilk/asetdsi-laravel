<!DOCTYPE html>
<html>

<head>
    <title>Daftar Aset Departemen Sistem Informasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 8pt;
            padding: 6px !important;
            border-color: black !important;
        }



        .unand {
            width: 60px;
            float: left;
            position: absolute;
            margin-top: 20px;
        }


        /* ukuran font */
        .ukuran-nama {

            color: #3a3636 !important;
        }

        .ukuran {

            color: black;
        }



        .ukuran-icon {
            font-size: 1.2rem !important;

        }

        .warna-header {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }



        .arai {
            display: block;
        }


        .atur {
            display: flex !important;
            align-items: center !important;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }


        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        @media print {
            tr {
                page-break-inside: avoid !important;
            }
        }
    </style>


    <!-- <div style="margin-right:40px;">
            <img src="{{ URL::asset('assets/images/unand.png') }}" class="unand" alt="...">
        </div> -->
    <!-- <div style="margin-left:40px;">
            <img src="{{ URL::asset('assets/images/unand.png') }}" class="unand" alt="...">
        </div> -->
    <!-- Kop -->
    <!-- <div><br>
            <center>
                <h6><b>DAFTAR ASET</b></h6>
                <h6><b>DEPARTEMEN SISTEM INFORMASI<b></h6>
                <div>
                    <span id="yearTahun"></span>
                    <h6>{{$year}}</h6>
                </div>
            </center>
        </div> -->


    <div style="margin-left:40px;">
        <img src="{{ URL::asset('assets/images/unand.png') }}" class="unand" alt="...">
    </div>
    <!-- Kop -->
    <div style="margin-right:50px"><br>
        <center>
            <h6><b>DAFTAR ASET</b></h6>
            <h6><b>DEPARTEMEN SISTEM INFORMASI<b></h6>
            <div>
                <span id="yearTahun"></span>
                <h6><b>{{$year}}<b></h6>
            </div>
        </center>
    </div>


    <hr>

    <table id="table" class="table table-bordered align-items-center">
        <thead class="text-center">
            <tr>
                <!-- <th scope="col" class="ukuran">No.</th> -->
                <th scope="col" class="ukuran fw-bold" style="width: 15%;">Nama Aset</th>
                <th  style="width: 5%;">Jumlah Aset</th>
                <th scope="col" class="ukuran fw-bold">Merk Barang</th>
                <th scope="col" class="ukuran fw-bold" style="width: 25%;">Kode Barang</th>
                <th scope="col" class="ukuran fw-bold" style="width: 5%;">Kondisi</th>

            </tr>
        </thead>

        <tbody class="list">
         
            @foreach($indexItem as $i)

            <tr>
                @if($i->indexPosition=="start")
                <td style="vertical-align: top;border-bottom:unset !important;">
                    <span class="mb-0 text-md ukuran arai ">{{$i->nama_aset}}</span>
                </td>
                @elseif($i->indexPosition=="middle")
                <td style="vertical-align: top;border-top: unset !important;border-bottom: unset !important;">
                    <span class="mb-0 text-md ukuran arai "></span>
                </td>

                @elseif($i->indexPosition=="end-line")
                <td style="vertical-align: top;border-top: unset !important;">
                    <span class="mb-0 text-md ukuran arai ">
                    </span>
                </td>
                @else
                <td style="vertical-align: top;border-top: unset !important;">
                    <span class="mb-0 text-md ukuran arai "></span>
                </td>
                @endif
                @if($i->indexPosition=="start")
                <td style="vertical-align: top;border-bottom: unset !important">
                    <span class="mb-0 text-md ukuran arai ">{{$i->jumlah}}
                    </span>
                </td>
                @elseif($i->indexPosition=="middle")
                <td style="vertical-align: top;border-top: unset !important; border-bottom: unset !important;">
                    <span class="mb-0 text-md ukuran arai ">
                    </span>
                </td>


                @else
                <td style="vertical-align: top;border-top: unset !important;">
                    <span class="mb-0 text-md ukuran arai ">
                    </span>
                </td>
                @endif

                <td style="vertical-align: top;">

                    <span class="mb-0 text-md ukuran arai">{{$i->nama_barang}}</span>

                </td>

                <td style="vertical-align: top;">

                    <span class="mb-0 text-md ukuran arai">{{$i->kode_aset}}</span>

                <td style="vertical-align: top;">

                    <span class="mb-0 text-md ukuran">{{$i->kondisi}}</span>

                </td>
            </tr>

            @endforeach
        </tbody>


    </table>




</body>

</html>