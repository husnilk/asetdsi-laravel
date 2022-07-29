<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
// use App\Http\Requests\StoreBarangRequest;
// use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Support\Facades\DB;

use App\models\Aset;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexBarang = DB::table('barang')
        ->join('aset','aset.id_aset','=','barang.id_aset')
        ->get([
            'aset.kode_aset','aset.nama_barang', 'barang.merk_barang','barang.keterangan', 
            'barang.no_aset', 'barang.tgl_perolehan', 'barang.asal_perolehan',
            'barang.harga_aset', 'barang.kondisi_aset','barang.foto','aset.id_jenis'
        ]);


    return view('pages.barang.barang', compact('indexBarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
