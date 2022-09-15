<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //    $count = DB::table('inventory')
        //    ->count(['inventory.inventory_brand']);

        $indexAset = DB::table('asset')
            ->get([
                'asset.asset_name',
                'asset.type_id', 'asset.asset_id'
            ]);


        $barang = DB::table('inventory')
            ->join('asset_location', 'asset_location.location_id', '=', 'inventory.location_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'inventory.pic_id')
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
            foreach ($barang as $data) {
                if ($data->asset_id == $aset->asset_id) {

                    // $pengadaan->requests = array_push $data;
                    array_push($aset->requests, $data);
                    $newAset[$index] = $aset;
                }
            }
            $index++;
        }

        foreach ($AsetsMap as $aset) {
            foreach ($barang as $data) {
                if ($data->asset_id == $aset->asset_id) {

                    // $pengadaan->requests = array_push $data;
                    $aset->jumlah = count($aset->requests);
                    // $newAset[$index] = $aset;
                }
            }
            $index++;
        }



        // 1. cari pengadaan
        // 2. cari request pengadaan
        // 3. looping request pengadaan 
        // 4. hasil looping request pengadaan di masukan ke dalam key requests di dalam object pengadaan
        // 5. untuk request pengadaan yg memiliki id pengadaan yg sama di masukan ke dalam object yg sama 



        return view('pages.barang.barang', compact('newAset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = DB::table('inventory')
            ->get([
                'inventory.inventory_brand', 'inventory.inventory_code',
                'inventory.condition', 'inventory.available', 'inventory.photo',
                'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id'
            ]);

        $aset = DB::table('asset')
            ->get(['asset_id', 'asset_name']);

        $lokasi = DB::table('asset_location')
            ->get(['location_id', 'location_name']);

        $pj = DB::table('person_in_charge')
            ->get(['pic_id', 'pic_name']);


        return view('pages.barang.create', compact('barang', 'aset', 'lokasi', 'pj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!$request->photo) {

            $i = 0;
            foreach ($request->inventory_brand as $data) {
                $barang = Inventory::create(
                    [
                        'inventory_brand' => $data,
                        'inventory_code' => $request->inventory_code[$i],
                        'condition'  => $request->condition[$i],
                        'available' => $request->available[$i],
                        'asset_id'  => $request->asset_id,
                        'location_id'  => $request->location_id[$i],
                        'pic_id'  => $request->pic_id[$i]

                    ]

                );

                $i++;
            }
        } else {
            $i = 0;
            foreach ($request->inventory_brand as $data) {
                $filefoto = cloudinary()->upload($request->file('photo')[$i]->getRealPath())->getSecurePath();


                $barang = Inventory::create(
                    [
                        'inventory_brand' => $data,
                        'inventory_code' => $request->inventory_code[$i],
                        'condition'  => $request->condition[$i],
                        'available' => $request->available[$i],
                        'photo'  => $filefoto,
                        'asset_id'  => $request->asset_id,
                        'location_id'  => $request->location_id[$i],
                        'pic_id'  => $request->pic_id[$i]

                    ]
                );

                $i++;
            }
        };


        return redirect('barang')->with('success', 'Inventory berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($inventory_id)
    {
        $aset = DB::table('asset')
            ->get(['asset_id', 'asset_name']);

        $lokasi = DB::table('asset_location')
            ->get(['location_id', 'location_name']);

        $pj = DB::table('person_in_charge')
            ->get(['pic_id', 'pic_name']);

        $indexBarang = DB::table('inventory')
            ->join('asset', 'asset.asset_id', '=', 'inventory.asset_id')
            ->join('asset_location', 'asset_location.location_id', '=', 'inventory.location_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'inventory.pic_id')
            ->where('inventory.inventory_id', '=', $inventory_id)
            ->get([
                'asset.asset_name', 'asset.asset_id',
                'inventory.inventory_brand', 'inventory.inventory_code',
                'inventory.condition', 'inventory.available', 'inventory.photo', 'inventory.inventory_id',
                'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id', 'asset_location.location_id', 'asset_location.location_name', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]);

        return view('pages.barang.edit', compact('indexBarang', 'aset', 'lokasi', 'pj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $inventory_id)
    {
        $indexBarang = DB::table('inventory')
            ->join('asset', 'asset.asset_id', '=', 'inventory.asset_id')
            ->join('asset_location', 'asset_location.location_id', '=', 'inventory.location_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'inventory.pic_id')
            ->where('inventory.inventory_id', '=', $inventory_id)
            ->get([
                'asset.asset_name', 'asset.asset_id',
                'inventory.inventory_brand', 'inventory.inventory_code',
                'inventory.condition', 'inventory.available', 'inventory.photo', 'inventory.inventory_id',
                'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id', 'asset_location.location_id', 'asset_location.location_name', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ]);

        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

            $update = DB::table('inventory')
                ->where('inventory.inventory_id', '=', $inventory_id)
                ->update([
                    'inventory_brand' => $request->inventory_brand,
                    'inventory_code' => $request->inventory_code,
                    'condition' => $request->condition,
                    'available' => $request->available,
                    'photo' => $file,
                    'asset_id' => $request->asset_id,
                    'location_id' => $request->location_id,
                    'pic_id' => $request->pic_id

                ]);
        } else {
            $update = DB::table('inventory')
                ->where('inventory.inventory_id', '=', $inventory_id)
                ->update([
                    'inventory_brand' => $request->inventory_brand,
                    'inventory_code' => $request->inventory_code,
                    'condition' => $request->condition,
                    'available' => $request->available,
                    'asset_id' => $request->asset_id,
                    'location_id' => $request->location_id,
                    'pic_id' => $request->pic_id

                ]);
        }



        return redirect('barang')->with('success', 'Aset berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($inventory_id)
    {
        $barang = Inventory::find($inventory_id);
        $barang->delete();

        return redirect('barang')->with('success', 'Aset berhasil dihapus');
    }
}
