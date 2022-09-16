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
        

        $indexBarang = DB::table('inventory')
        ->join('asset', 'asset.asset_id', '=', 'inventory.asset_id')
        ->join('asset_location', 'asset_location.location_id', '=', 'inventory.location_id')
        ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'inventory.pic_id')
        ->get([
            'asset.asset_name', 'asset.asset_id',
            'inventory.inventory_brand', 'inventory.inventory_code',
            'inventory.condition', 'inventory.available', 'inventory.photo', 'inventory.inventory_id',
            'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id', 'asset_location.location_id', 'asset_location.location_name', 'person_in_charge.pic_name',
            'person_in_charge.pic_id'
        ]);

        $barangCollect = collect($indexBarang);
        // dd($barangCollect, $indexBarang);
        // array_map()
        $jumlahbarangs = $barangCollect->reduce(function ($prev, $current) use ($barangCollect) {
            // if (count($prev) == 0) {
            //     $newBarang = $barangCollect->filter(function ($item) use ($current) {
            //         return ($item->asset_id === $current->asset_id);
            //     });
            //     $prev[$current->asset_id] = $newBarang;
            //     return $prev;
            // }
            $newBarang = $barangCollect->filter(function ($item) use ($current) {
                return ($item->asset_id === $current->asset_id);
            });

            $barangs = [
                'asset_id' => $current->asset_id,
                'jumlah' => count($newBarang),
            ];
            $prev[$current->asset_id] = $barangs;
           return $prev;
        }, []);

        $indexStart = 0;
        $newArray = [];

        for($index2 = 1; $index2 <= count($jumlahbarangs); $index2++) {
            $jumlahbarangs[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $jumlahbarangs[$index2]['jumlah'];
        }

    //    $newArray = array_reduce($barangCollect, function ($val, $next) {
            
    //         if (!$val) {
    //             $val[$next->name] = $next;
    //         }

    //         return $val;
    //     }, []);

        // collect($indexBarang).reduce(())
        // $jumlahs = [
        //     'asset_id' => '',
        //     'jumlah' => '',
        // ];

        $barang = ([
            'items' => $indexBarang,
            'jumlahs' => $jumlahbarangs,
        ]);

        return view('pages.barang.barang', compact('barang'));
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
