<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->select([
                'asset.asset_name', 'asset.asset_id', 'building.building_id',
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ])->orderBy('asset.asset_name')
            ->paginate(10);

        $bangunanCollect = collect($indexBangunan->items());

        $jumlahBangunans = $bangunanCollect->reduce(function ($prev, $current) use ($bangunanCollect) {

            $newBangunan = $bangunanCollect->filter(function ($item) use ($current) {
                return ($item->asset_id === $current->asset_id);
            });

            $bangunans = [
                'asset_id' => $current->asset_id,
                'jumlah' => count($newBangunan),

            ];
            $prev[$current->asset_id] = $bangunans;
            return $prev;
        }, []);

        $indexStart = 0;
        $newArray = [];

        
        $newArrayJumlahBangunan =  array_values($jumlahBangunans);
        for ($index2 = 0; $index2 <= count($jumlahBangunans) - 1; $index2++) {
            $newArrayJumlahBangunan[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahBangunan[$index2]['jumlah'];
        }

        $bangunan = ([
            'items' => $indexBangunan,
            'jumlahs' => $newArrayJumlahBangunan,
        ]);

        
        return view('pages.bangunan.bangunan', compact('bangunan'));
    }

    public function search(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;
        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->where('asset_name', 'like', "%" . $cari . "%")
            ->orWhere('pic_name', 'like', "%" . $cari . "%")
            ->orWhere('building_code', 'like', "%" . $cari . "%")
            ->orWhere('building_name', 'like', "%" . $cari . "%")
            ->orWhere('condition', 'like', "%" . $cari . "%")
            ->select([
                'asset.asset_name', 'asset.asset_id', 'building.building_id',
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]) ->paginate(10);

        $bangunanCollect = collect($indexBangunan->items());

        $jumlahBangunans = $bangunanCollect->reduce(function ($prev, $current) use ($bangunanCollect) {

            $newBangunan = $bangunanCollect->filter(function ($item) use ($current) {
                return ($item->asset_id === $current->asset_id);
            });

            $bangunans = [
                'asset_id' => $current->asset_id,
                'jumlah' => count($newBangunan),

            ];
            $prev[$current->asset_id] = $bangunans;
            return $prev;
        }, []);

        $indexStart = 0;
        $newArray = [];

        $newArrayJumlahBangunan =  array_values($jumlahBangunans);
        for ($index2 = 0; $index2 <= count($jumlahBangunans) - 1; $index2++) {
            $newArrayJumlahBangunan[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahBangunan[$index2]['jumlah'];
        }

        $bangunan = ([
            'items' => $indexBangunan,
            'jumlahs' => $newArrayJumlahBangunan,
        ]);

        return view('pages.bangunan.bangunan', compact('bangunan'));
    }

    public function print()
    {
        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.asset_id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'building.pic_id')
            ->get([
                'asset.asset_name', 'asset.asset_id', 'building.building_id',
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]);

        $bangunanCollect = collect($indexBangunan);

        $jumlahBangunans = $bangunanCollect->reduce(function ($prev, $current) use ($bangunanCollect) {

            $newBangunan = $bangunanCollect->filter(function ($item) use ($current) {
                return ($item->asset_id === $current->asset_id);
            });

            $bangunans = [
                'asset_id' => $current->asset_id,
                'jumlah' => count($newBangunan),

            ];
            $prev[$current->asset_id] = $bangunans;
            return $prev;
        }, []);

        $indexStart = 0;
        $newArray = [];

        $newArrayJumlahBangunan =  array_values($jumlahBangunans);
        for ($index2 = 0; $index2 <= count($jumlahBangunans) - 1; $index2++) {
            $newArrayJumlahBangunan[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahBangunan[$index2]['jumlah'];
        }

        $bangunan = ([
            'items' => $indexBangunan,
            'jumlahs' => $newArrayJumlahBangunan,
        ]);



        $pdf = pdf::loadview('pages.bangunan.cetak', ['bangunan' => $bangunan]);
        return $pdf->stream('bangunan-pdf');
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
                'building.building_name', 'building.building_code',
                'building.condition', 'building.available', 'building.photo',
                'building.asset_id', 'building.pic_id'
            ]);

        $aset = DB::table('asset')
        ->where('asset.type_id', '=', 2)
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
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
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
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
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
