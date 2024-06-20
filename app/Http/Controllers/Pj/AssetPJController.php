<?php

namespace App\Http\Controllers\Pj;
use App\Http\Controllers\Controller;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use App\AssetType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AssetPJController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
        $indexAset = DB::table('asset')
        ->join('asset_type', 'asset_type.id', '=', 'asset.type_id')
        ->get([
            'asset_type.type_name','asset.asset_name','asset.id','asset_type.id as id_type','asset.type_id'
        ]);
     


    return view('pages.p_j.aset.aset', compact('indexAset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aset = DB::table('asset')
            ->get(['id','asset_name']);

        $jenis = DB::table('asset_type')
            ->get(['id', 'type_name']);

        
        return view('pages.p_j.aset.create', compact('aset', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aset = Asset::create([
            'asset_name'       => $request->asset_name,
            'type_id'  => $request->type_id
        ]);

      
        return redirect('pj-aset/aset')->with('success', 'Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indexAset = DB::table('asset')
        // ->distinct('request_pengadaan.i                                    d_pengadaan')
        ->join('asset_type', 'asset_type.id', '=', 'asset.type_id')
        ->where('asset.id', '=', $id)
        // ->join('request_pengadaan', 'request_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
        ->get([
            'asset_type.type_name','asset.asset_name','asset.id','asset_type.id as id_type','asset.type_id'
        ]);
     

        $jenis = DB::table('asset_type')
        ->get(['id', 'type_name']);


    return view('pages.p_j.aset.edit', compact('indexAset','jenis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $indexAset = DB::table('asset')
            // ->distinct('request_pengadaan.i                                    d_pengadaan')
            ->join('asset_type', 'asset_type.id', '=', 'asset.type_id')
            ->where('asset.id', '=', $id)
            // ->join('request_pengadaan', 'request_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
            ->get([
                'asset_type.type_name','asset.asset_name','asset.id','asset_type.id as id_type','asset.type_id'
            ]);

            
            $update = DB::table('asset')
            ->where('asset.id', '=', $id)
            ->update([
                'asset_name'=> $request->asset_name,
                'type_id'=> $request->type_id
            ])
            ;
        

        return redirect('pj-aset/aset')->with('success', 'Aset berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aset = Asset::find($id);
        
        $aset->delete();

        return redirect('pj-aset/aset')->with('success', 'Aset berhasil dihapus');
    }
}
