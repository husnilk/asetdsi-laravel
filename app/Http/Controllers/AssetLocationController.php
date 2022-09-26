<?php

namespace App\Http\Controllers;

use App\Models\AssetLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexLokasi = DB::table('asset_location')
           
        ->get(['asset_location.location_name','asset_location.id']);

        return view('pages.lokasi.lokasi', compact('indexLokasi'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = DB::table('asset_location')
        ->get(['id', 'location_name']);

    
    return view('pages.lokasi.create', compact('lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lokasi = AssetLocation::create([
            
            'location_name'  => $request->location_name
        ]);

      
        return redirect('lokasi')->with('success', 'Lokasi Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetLocation  $assetLocation
     * @return \Illuminate\Http\Response
     */
    public function show(AssetLocation $assetLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetLocation  $assetLocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indexLokasi = DB::table('asset_location')
        ->where('asset_location.id', '=', $id)
        ->get(['id', 'location_name']);

    return view('pages.lokasi.edit', compact('indexLokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @param  \App\Models\AssetLocation  $assetLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $indexLokasi = DB::table('asset_location')
        ->where('asset_location.id', '=', $id)
        ->get(['id', 'location_name']);


        $update = DB::table('asset_location')
        ->where('asset_location.id', '=', $id)
            ->update([
               
                'location_name'=> $request->location_name,
         
            ])
            ;
        

        return redirect('lokasi')->with('success', 'Lokai Aset berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetLocation  $assetLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasi = AssetLocation::find($id);
        $lokasi->delete();
      
        return redirect('lokasi')->with('success', 'Lokasi Aset berhasil dihapus');
    }
}
