<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexAset = DB::table('asset')
            ->get([
                'asset.asset_name',
                'asset.type_id', 'asset.asset_id'
            ]);


        $bangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->get();

        $newAset = [];
        $index = 0;

        $request_index = 0;

        // wajib ubah ke collect dulu kalau mau map array
        $AsetsMap = collect($indexAset); // now it's a Laravel Collection object
        // and you can use functions like map, foreach, sort, ...
        $AsetsMap->map(function ($item) {
            $item->requests = [];
            $item->jumlah = 0;
            return $item;
        });

        // dd($indexPengadaan);
        foreach ($AsetsMap as $aset) {
            foreach ($bangunan as $data) {
                if ($data->asset_id == $aset->asset_id) {

                    // $pengadaan->requests = array_push $data;
                    array_push($aset->requests, $data);
                    $newAset[$index] = $aset;
                }
            }
            $index++;
        }

        foreach ($AsetsMap as $aset) {
            foreach ($bangunan as $data) {
                if ($data->asset_id == $aset->asset_id) {

                    // $pengadaan->requests = array_push $data;
                    $aset->jumlah = count($aset->requests);
                    // $newAset[$index] = $aset;
                }
            }
            $index++;
        }



        // 1. cari Aset
        // 2. cari request bangunan
        // 3. looping request bangunan 
        // 4. hasil looping request bangunan di masukan ke dalam key requests di dalam object aset
        // 5. untuk request bangunan yg memiliki id aset yg sama di masukan ke dalam object yg sama 



        return view('pages.bangunan.bangunan', compact('newAset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bangunan = DB::table('building')
            ->get([
                'building.building_name','building.building_code',
                'building.condition','building.available', 'building.photo',
                'building.asset_id', 'building.pic_id'
            ]);

        $aset = DB::table('asset')
            ->get(['asset_id', 'asset_name']);



        $pj = DB::table('person_in_charge')
            ->get(['pic_id', 'pic_name']);


        return view('pages.bangunan.create', compact('bangunan', 'aset', 'pj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBuildingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = 0;
        foreach ($request->building_name as $data) {
            $filefoto = cloudinary()->upload($request->file('photo')[$i]->getRealPath())->getSecurePath();


            $bangunan = Building::create(
                [
                    'building_name' => $data,
                    'building_code'  => $request->building_code[$i],
                    'condition'  => $request->condition[$i],
                    'available' => $request->available[$i],
                    'photo'  => $filefoto,
                    'asset_id'  => $request->asset_id,
                    'pic_id'  => $request->pic_id[$i]

                ]
            );

            $i++;
        };

        return redirect('bangunan')->with('success', 'Bangunan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit($building_id)
    {
        $aset = DB::table('asset')
            ->get(['asset_id', 'asset_name']);


        $pj = DB::table('person_in_charge')
            ->get(['pic_id', 'pic_name']);

        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->where('building.building_id', '=', $building_id)
            ->get([
                'asset.asset_name', 'asset.asset_id', 'building.building_id',
                'building.building_name','building.building_code','building.condition','building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]);

        return view('pages.bangunan.edit', compact('indexBangunan', 'aset', 'pj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBuildingRequest  $request
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $building_id)
    {
        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->where('building.building_id', '=', $building_id)
            ->get([
                'asset.asset_name', 'asset.asset_id', 'building.building_id',
                'building.building_name','building.building_code','building.condition','building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]);

        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

            $update = DB::table('building')
                ->where('building.building_id', '=', $building_id)
                ->update([
                    'building_name' => $request->building_name,
                    'building_code'  => $request->building_code,
                    'condition'  => $request->condition,
                    'available'  => $request->available,
                    'photo' => $file,
                    'asset_id' => $request->asset_id,
                    'pic_id' => $request->pic_id

                ]);
        } else {
            $update = DB::table('building')
                ->where('building.building_id', '=', $building_id)
                ->update([
                    'building_name' => $request->building_name,
                    'building_code'  => $request->building_code,
                    'condition'  => $request->condition,
                    'available'  => $request->available,
                    'asset_id' => $request->asset_id,
                    'pic_id' => $request->pic_id

                ]);
        }



        return redirect('bangunan')->with('success', 'Bangunan berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy($building_id)
    {
        $bangunan = Building::find($building_id);
        $bangunan->delete();
      
        return redirect('bangunan')->with('success', 'Bangunan berhasil dihapus');
    }
}
