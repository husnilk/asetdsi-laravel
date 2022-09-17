<!DOCTYPE html>
<html>
<head>
	<title>Daftar Aset Departemen Sistem Informasi</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 12pt;
		}

     
    /* ukuran font */
    .ukuran-nama {
     
        color: #3a3636 !important;
    }

    .ukuran {
      
        color: black;
    }

    .table th {
        color: #3a3636 !important;
        text-align: center !important;
    }

    .ukuran-icon {
        font-size: 1.2rem !important;

    }

    .warna-header {
        background-color: rgba(0, 0, 0, 0.03) !important;
    }

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
        cursor: pointer;
        margin-right: 2rem !important;
        padding: 0.8rem !important;
    }

    .transisi:hover {

        background-color: #FE9E28 !important;
        color: white;
    }

    .transisi2 {
        position: relative;
        background-color: #7042da !important;
        border: none;

        color: #FFFFFF;

        text-align: center;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
        text-decoration: none;
        overflow: hidden;
        cursor: pointer;
        margin-right: 1rem !important;
        padding: 0.8rem !important;
    }

    .transisi2:hover {

        background-color: #9558fa !important;
        color: white;
    }


    .transisi3 {
        position: relative;
        background-color: #1A4D2E !important;
        border: none;

        color: #FFFFFF;

        text-align: center;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
        text-decoration: none;
        overflow: hidden;
        cursor: pointer;
        margin-right: 2rem !important;
        padding: 0.8rem !important;
    }

    .transisi3:hover {

        background-color: #4bac71 !important;
        color: white;
    }


    /* warna header */

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 1px solid #338f00;

        background: #1A4D2E;
    }

    .arai {
        display: block;
    }

    td.bg_red {
        background-color: red;
    }

    td.bg_yellow {
        background-color: yellow;
    }

    td.bg_green {
        background-color: green;
    }

    .atur {
        display: flex !important;
        align-items: center !important;
    }


    /* page */
    .page-item.active .page-link {
        z-index: 3;
        color: #fff !important;
        background-color: #1A4D2E !important;
        border-color: #1A4D2E !important;
    }

    .page-link:hover {
        z-index: 2;
        color: #1A4D2E !important;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-link {
        position: relative;
        display: block;
        color: #1A4D2E !important;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
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
	<center>
		<h6>Daftar Aset</h6>
        <h6>Departemen Sistem Informasi<h6>
		
	</center>
 
	<table id="table" class="table table-bordered table-hover align-items-center table-flush pt-2 ">
                <thead class="thead-light">
                    <tr>
                        <!-- <th scope="col" class="ukuran">No.</th> -->
                        <th scope="col" class="ukuran fw-bold">Nama Aset</th>
                        <th scope="col" class="ukuran fw-bold" style="width: 5%;">Jumlah Aset</th>
                        <th scope="col" class="ukuran fw-bold">Merk Aset</th>
                        <th scope="col" class="ukuran fw-bold">Kode Aset</th>
                        <th scope="col" class="ukuran fw-bold">Kondisi</th>
                        <th scope="col" class="ukuran fw-bold">Penanggung Jawab</th>
                
                    </tr>
                </thead>
                @php
                $j = 0;

                @endphp
                <tbody class="list">
                    @foreach($barang['items'] as $key => $i)
                    <tr>
                        @foreach($barang['jumlahs'] as $t)
                        @if ($t['asset_id'] == $i->asset_id)
                        @if ($j == $t['indexStart'] )
                        <td style="vertical-align: top;" rowspan="{{ $t['jumlah'] }}">
                            <span class="name mb-0 text-md ukuran-nama arai fw-bold" style="display: block;">{{$i->asset_name}}</span>
                        </td>
                        @endif
                        @endif
                        @endforeach

                        @foreach($barang['jumlahs'] as $t)
                        @if ($t['asset_id'] == $i->asset_id)
                        @if ($j == $t['indexStart'])
                        <td class="text-center" style="vertical-align: top;" rowspan="{{ $t['jumlah'] }}">

                            <span class="name mb-0 text-md ukuran" style="display: block;">{{ $t['jumlah'] }}</span>

                        </td>
                        @endif
                        @endif
                        @endforeach

                        <td style="vertical-align: top;">

                            <span class="name mb-0 text-md ukuran arai" style="display: block;">{{$i->inventory_brand}}</span>

                        </td>
                        <td style="vertical-align: top;">

                            <span class="name mb-0 text-md ukuran" style="display: block;">{{$i->inventory_code}}</span>

                        </td>
                        <td style="vertical-align: top;">

                            <span class="name mb-0 text-md ukuran" style="display: block;">{{$i->condition}}</span>

                        </td>
              
                        <td style="vertical-align: top;">

                            <span class="name mb-0 text-md ukuran" style="display: block;">{{$i->pic_name}}</span>

                        </td>

                    </tr>
                    @php
                    $j++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
 
</body>
</html>