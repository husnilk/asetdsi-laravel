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

        $indexBangunans = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->get([
                'asset.asset_name', 'asset.id', 'building.id as building_id',
                'building.asset_id', 'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id'
            ]);


        $newItems = collect($indexBangunans);

        $indexBangunan = $newItems->map(function ($item, $index)  use ($newItems) {
            $filterItem = $newItems->filter(function ($itemFIlter) use ($item) {
                return $itemFIlter->asset_id ===  $item->asset_id;
            });
            // dd($newItems[0]->building_name);
            $item->jumlah = count($filterItem);
            if ($index == 0) {
                $item->indexPosition = 'start';
            } else if ($newItems[$index - 1]->asset_name != $item->asset_name) {
                $item->indexPosition = 'start';
            } else if (count($newItems) - 1 === $index) {
                $item->indexPosition = 'end';
            } else if ($newItems[$index + 1]->asset_name != $item->asset_name) {
                $item->indexPosition = 'end';
            } else {
                $item->indexPosition = 'middle';
            }
            // $item->indexPosition = 
            return $item;
        }); 

        return view('pages.bangunan.bangunan', compact('indexBangunan'));
    }

    public function search(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;
        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->where('asset_name', 'like', "%" . $cari . "%")
            ->orWhere('pic_name', 'like', "%" . $cari . "%")
            ->orWhere('building_code', 'like', "%" . $cari . "%")
            ->orWhere('building_name', 'like', "%" . $cari . "%")
            ->orWhere('condition', 'like', "%" . $cari . "%")
            ->select([
                'asset.asset_name', 'asset.id', 'building.id as building_id',
                'building.asset_id', 'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id'
            ])->paginate(10);

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
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->get([
                'asset.asset_name', 'asset.id', 'building.id as building_id',
                'building.asset_id', 'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id'
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
            ->get(['id', 'asset_name']);


        $pj = DB::table('person_in_charge')
            ->get(['id', 'pic_name']);


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

            if ($request->photo) {

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
            } else {

                $filefoto = "https://res.cloudinary.com/nishia/image/upload/v1663485047/default-image_yasmsd.jpg";

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
            }

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
    public function edit($id)
    {
        $aset = DB::table('asset')
            ->where('asset.type_id', '=', 2)
            ->get(['id', 'asset_name']);


        $pj = DB::table('person_in_charge')
            ->get(['id', 'pic_name']);

        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->where('building.id', '=', $id)
            ->get([
                'asset.asset_name', 'asset.id', 'building.id as building_id',
                'building.asset_id', 'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id'
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
    public function update(Request $request, $id)
    {


        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->where('building.id', '=', $id)
            ->get([
                'asset.asset_name', 'asset.id', 'building.id as building_id',
                'building.building_name', 'building.building_code', 'building.condition', 'building.available', 'building.photo', 'building.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id'
            ]);


        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

            $update = DB::table('building')
                ->where('building.id', '=', $id)
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
                ->where('building.id', '=', $id)
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
    public function destroy($id)
    {
        $bangunan = Building::find($id);
        $bangunan->delete();

        return redirect('bangunan')->with('success', 'Bangunan berhasil dihapus');
    }
}
