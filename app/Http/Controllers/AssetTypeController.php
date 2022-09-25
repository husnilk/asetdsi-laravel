<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        $indexJenis = DB::table('asset_type')
           
        ->get(['asset_type.type_name','asset_type.type_id']);

        return view('pages.jenis.jenis', compact('indexJenis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = DB::table('asset_type')
        ->get(['type_id', 'type_name']);

    
    return view('pages.jenis.create', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenis = AssetType::create([
            
            'type_name'  => $request->type_name
        ]);

      
        return redirect('jenis')->with('success', 'Jenis Aset berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function show(AssetType $assetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function edit($type_id)
    {
        $indexJenis = DB::table('asset_type')
        ->where('asset_type.type_id', '=', $type_id)
        ->get(['type_id', 'type_name']);

    return view('pages.jenis.edit', compact('indexJenis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests  $request
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$type_id)
    {
        $indexJenis = DB::table('asset_type')
        ->where('asset_type.type_id', '=', $type_id)
        ->get(['type_id', 'type_name']);


        $update = DB::table('asset_type')
        ->where('asset_type.type_id', '=', $type_id)
            ->update([
               
                'type_name'=> $request->type_name,
         
            ])
            ;
        

        return redirect('jenis')->with('success', 'Jenis Aset berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function destroy($type_id)
    {
        $jenis = AssetType::find($type_id);
        $jenis->delete();
      
        return redirect('jenis')->with('success', 'Jenis Aset berhasil dihapus');
    }
}
