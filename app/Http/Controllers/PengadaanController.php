<?php

namespace App\Http\Controllers;

use App\models\Pengadaan;
use App\models\RequestPengadaan;
use App\models\Mahasiswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;
use Shanmuga\LaravelCloudinary\Facades\CloudinaryFacade as LaravelCloudinary;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $indexPengadaan = DB::table('pengadaan')
            // ->distinct('request_pengadaan.i                                    d_pengadaan')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa', '=', 'pengadaan.id_mahasiswa')
            // ->join('request_pengadaan', 'request_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
            ->get([
                'mahasiswa.nama', 'pengadaan.keterangan_pengadaan',
                'pengadaan.surat_pengadaan', 'pengadaan.status', 'pengadaan.id_pengadaan'
            ]);

        $request_pengadaan = DB::table('request_pengadaan')->get();
        $newPengadaan = [];
        $index = 0;

        $request_index = 0;

        // wajib ubah ke collect dulu kalau mau map array
        $pengadaansMap = collect($indexPengadaan); // now it's a Laravel Collection object
        // and you can use functions like map, foreach, sort, ...
        $pengadaansMap->map(function ($item) {
            $item->requests = [];
            return $item;
        });

        // dd($indexPengadaan);
        foreach ($pengadaansMap as $pengadaan) {
            foreach ($request_pengadaan as $data) {
                if ($data->id_pengadaan == $pengadaan->id_pengadaan) {
                    // $pengadaan->requests = array_push $data;
                    array_push($pengadaan->requests, $data);
                    $newPengadaan[$index] = $pengadaan;
                }
            }
            $index++;
        }

        // 1. cari pengadaan
        // 2. cari request pengadaan
        // 3. looping request pengadaan 
        // 4. hasil looping request pengadaan di masukan ke dalam key requests di dalam object pengadaan
        // 5. untuk request pengadaan yg memiliki id pengadaan yg sama di masukan ke dalam object yg sama 



        return view('pages.pengadaan.pengadaan', compact('newPengadaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $pengadaan = DB::table('pengadaan')
            ->get(['id_pengadaan', 'keterangan_pengadaan', 'surat_pengadaan']);

        $mahasiswa = DB::table('mahasiswa')
            ->get(['id_mahasiswa', 'nama', 'username', 'password']);

        $request_pengadaan = DB::table('request_pengadaan')
            ->get(['id_request', 'nama_barang', 'jumlah_barang']);

        return view('pages.pengadaan.create', compact('pengadaan', 'mahasiswa', 'request_pengadaan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $mahasiswa = Mahasiswa::create([
            'nama'       => $request->nama,
            'username'       => $request->username,
            'password'       => $request->password,

        ]);



        $this->validate($request, [
            'surat_pengadaan'       => 'mimes:doc,docx,pdf',
        ]);

        $file = cloudinary()->upload($request->file('surat_pengadaan')->getRealPath(), [
            'folder' => 'TA',
            // 'transformation' => [
            //           'width' => 100,
            //           'height' => 100
            //  ]
        ])->getSecurePath();
        $pengadaan = Pengadaan::create([
            'keterangan_pengadaan' => $request->keterangan_pengadaan,
            'surat_pengadaan' => $file,

            'status'   => "waiting",
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,


        ]);

        $i = 0;
        foreach ($request->nama_barang as $data) {
            $request_pengadaan = RequestPengadaan::create(
                [
                    'nama_barang' => $data,
                    'jumlah_barang' => $request->jumlah_barang[$i],
                    'id_pengadaan'   => $pengadaan->id_pengadaan,
                ]
            );

            $i++;
        };




        return redirect('pengadaan')->with('success', 'Pengadaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pengadaan  $Pengadaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pengadaan $Pengadaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pengadaan  $Pengadaan
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pengadaan)
    {
        $indexPengadaan = DB::table('pengadaan')
            // ->distinct('request_pengadaan.i                                    d_pengadaan')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa', '=', 'pengadaan.id_mahasiswa')
            ->where('pengadaan.id_pengadaan', '=', $id_pengadaan)
            // ->join('request_pengadaan', 'request_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
            ->get([
                'mahasiswa.nama', 'mahasiswa.username', 'mahasiswa.password', 'pengadaan.keterangan_pengadaan',
                'pengadaan.surat_pengadaan', 'pengadaan.status', 'pengadaan.id_pengadaan'
            ]);

        $request_pengadaan = DB::table('request_pengadaan')
            ->join('pengadaan', 'pengadaan.id_pengadaan', '=', 'request_pengadaan.id_pengadaan')
            ->where('request_pengadaan.id_pengadaan', '=', $id_pengadaan)
            ->get(['request_pengadaan.id_request','request_pengadaan.nama_barang', 'request_pengadaan.jumlah_barang']);

        return view('pages.pengadaan.edit', compact('indexPengadaan', 'request_pengadaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pengadaan  $Pengadaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pengadaan)
    {

        // dd($request->all());
        //update table pengadaan
        //return id mahasiswa
        //update table mahasiswa
        //update request pengadaan

        if ($request->surat_pengadaan) {

            $new = $request->surat_pengadaan;
            $updated = [
                'keterangan_pengadaan' => $request->keterangan_pengadaan,
            ];
            if ($request->surat_pengadaan) {

                $file = cloudinary()->upload($request->file('surat_pengadaan')->getRealPath())->getSecurePath();

                $updated['surat_pengadaan'] = $file;
            }

            $update = DB::table('pengadaan')
                ->where('pengadaan.id_pengadaan', '=', $id_pengadaan)
                ->update($updated);
        } else {
            $update = DB::table('pengadaan')
                ->where('pengadaan.id_pengadaan', '=', $id_pengadaan)
                ->update([
                    'keterangan_pengadaan' => $request->keterangan_pengadaan,
                ])
                ;
        }
        $indexPengadaan = DB::table('pengadaan')
            // ->distinct('request_pengadaan.i                                    d_pengadaan')
            ->join('mahasiswa', 'mahasiswa.id_mahasiswa', '=', 'pengadaan.id_mahasiswa')
            ->where('pengadaan.id_pengadaan', '=', $id_pengadaan)
            // ->join('request_pengadaan', 'request_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
            ->get([
                'mahasiswa.id_mahasiswa','mahasiswa.nama', 'mahasiswa.username', 'mahasiswa.password', 'pengadaan.keterangan_pengadaan',
                'pengadaan.surat_pengadaan', 'pengadaan.status', 'pengadaan.id_pengadaan'
            ]);


            $update2 = DB::table('mahasiswa')
            ->where('mahasiswa.id_mahasiswa', '=', $indexPengadaan[0]->id_mahasiswa)
            ->update([
                'nama' => $request->nama,
                'username'=> $request->username,
                'password'=> $request->password
            ])
            ;

            $request_pengadaan = DB::table('request_pengadaan')
            ->join('pengadaan', 'pengadaan.id_pengadaan', '=', 'request_pengadaan.id_pengadaan')
            ->where('request_pengadaan.id_pengadaan', '=', $id_pengadaan)
            ->get(['request_pengadaan.nama_barang', 'request_pengadaan.jumlah_barang']);
     
            $request_pengadaan_array = [];


            $index = 0;

        $request_index = 0;

        // wajib ubah ke collect dulu kalau mau map array
        $pengadaans_namabarangMap = collect($request->nama_barang); // now it's a Laravel Collection object
        $pengadaans_jumahbarangMap = collect($request->jumlah_barang); // now it's a Laravel Collection object
        $pengadaans_idrequestMap = collect($request->id_request); // now it's a Laravel Collection object

        $pengadaans_namabarangMap->map(function ($item, $i) {
            $request_pengadaan_array = array(
                "nama_barang" => $item
            );

            return $request_pengadaan_array;
        });

        $namabarang_index= 0;
        foreach ($pengadaans_namabarangMap as $data) {
            $request_pengadaan_array[$namabarang_index] = array(
                "nama_barang" => $data,
            );
            $namabarang_index++;
        };

        $jumahbarang_index= 0;
        foreach ($pengadaans_jumahbarangMap as $data) {
            $request_pengadaan_array[$jumahbarang_index] = collect($request_pengadaan_array[$jumahbarang_index])->merge(array(
                "jumlah_barang" => $data,
            ));
            $jumahbarang_index++;
        };

        $idrequest_index= 0;
        foreach ($pengadaans_idrequestMap as $data) {
            $request_pengadaan_array[$idrequest_index] = collect($request_pengadaan_array[$idrequest_index])->merge(array(
                "id_request" => $data,
            ));
            $idrequest_index++;
        };

        // $pengadaans_jumahbarangMap->map(function ($item, $i) {
        //     $request_pengadaan_array[$i] = array([
        //         "jumlah_barang" => $item
        //     ]);
        // });

        // $pengadaans_idrequestMap->map(function ($item, $i) {
        //     $request_pengadaan_array[$i] = array([
        //         "id_request" => $item
        //     ]);
        // });
  
        collect($request_pengadaan_array)->map(function($data, $index) use ($id_pengadaan) {
            $data['nama_barang'];
            $data['jumlah_barang'];
            $id_request = $data['id_request'] ?? null;

            // update here
            if($id_request != null){
                $update3 = DB::table('request_pengadaan')
                    ->where('request_pengadaan.id_request', '=', $data['id_request'])
                    ->update([
                        'nama_barang' => $data['nama_barang'],
                        'jumlah_barang'=> $data['jumlah_barang'],
                        
                    ]);
                
            } else {
                $request_pengadaan = RequestPengadaan::create(
                    [
                        'nama_barang' =>  $data['nama_barang'],
                        'jumlah_barang' => $data['jumlah_barang'],
                        'id_pengadaan' => $id_pengadaan
                    ]
                );
            }
        });

        return redirect('pengadaan')->with('success', 'Pengadaan berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pengadaan  $Pengadaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pengadaan)
    {
        $pengadaan = Pengadaan::find($id_pengadaan);
        $pengadaan->delete();
      
        return redirect('pengadaan')->with('success', 'Pengadaan berhasil dihapus');
    }

    
}
