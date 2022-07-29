<?php

namespace App\Http\Controllers;

use App\models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jenis;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexAset = DB::table('aset')
        ->join('jenis_aset', 'jenis_aset.id_jenis', '=', 'aset.id_jenis')
        ->join('barang','barang.id_aset','=','aset.id_aset' )
        ->get([
            'jenis_aset.nama_jenis','aset.kode_aset','aset.nama_barang', 'barang.merk_barang','barang.keterangan', 
            'barang.no_aset', 'barang.tgl_perolehan', 'barang.asal_perolehan',
            'barang.harga_aset', 'barang.kondisi_aset','barang.foto','aset.id_jenis'
        ]);


    return view('pages.aset.aset', compact('indexAset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $aset = DB::table('aset')
            ->get(['id_aset', 'kode_aset', 'nama_barang']);

        $jenis = DB::table('jenis_aset')
            ->get(['id_jenis', 'nama_jenis']);

        
        return view('pages.aset.create', compact('aset', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        // $jenis = DB::table('jenis_aset')
        //     ->get(['id_jenis', 'nama_jenis']);

        $aset = Aset::create([
            'kode_aset'       => $request->kode_aset,
            'nama_barang'       => $request->nama_barang,
            'id_jenis'  => $request->id_jenis
        ]);

      
        return redirect('aset')->with('success', 'Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function show(Aset $aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function edit(Aset $aset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aset $aset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aset  $aset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aset $aset)
    {
        //
    }
}
