<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


use function PHPSTORM_META\map;

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
            ->select([
                'asset.asset_name', 'asset.asset_id',
                'inventory.inventory_brand', 'inventory.inventory_code',
                'inventory.condition', 'inventory.available', 'inventory.photo', 'inventory.inventory_id',
                'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id', 'asset_location.location_id', 'asset_location.location_name', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ])
            ->paginate(10);



        $barangCollect = collect($indexBarang->items());
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

        // $aa = array_map(function($item, $index1) {
        //     $newArray[$index1] = $item;
        //     return  $item;
        // }, $jumlahbarangs, array_keys($jumlahbarangs));

        // dd('newArray', count($jumlahbarangs));
        // for ($index2 = 0; $index2 <= count($jumlahbarangs); $index2++) {
        //     $newArray[$index2] = $indexStart;
        // }
        // dd (count($jumlahbarangs));
        $newArrayJumlahbarang =  array_values($jumlahbarangs);
        for ($index2 = 0; $index2 <= count($jumlahbarangs) - 1; $index2++) {
            $newArrayJumlahbarang[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahbarang[$index2]['jumlah'];
        }


        // foreach ($jumlahbarangs as $mapJumlah) {
        //     $mapJumlah['indexStart'] = $indexStart;
        //     $indexStart +=  $mapJumlah['jumlah'];
        //     var_dump($indexStart);
        // }
        // (function ($mapJumlah) use ($indexStart) {
        //     $mapJumlah['indexStart'] = $indexStart;
        //     $indexStart +=  $mapJumlah['jumlah'];
        //     var_dump($indexStart);
        //     return $mapJumlah;
        // });
        // var_dump($indexStart);
        // die();
        // dd($indexStart);



        $barang = ([
            'items' => $indexBarang,
            'jumlahs' => $newArrayJumlahbarang,
        ]);



        return view('pages.barang.barang', compact('barang'));
    }


    public function search(Request $request)
    {
        // menangkap data pencarian
        $cari = $request->cari;

        $indexBarang = DB::table('inventory')
            ->join('asset', 'asset.asset_id', '=', 'inventory.asset_id')
            ->join('asset_location', 'asset_location.location_id', '=', 'inventory.location_id')
            ->join('person_in_charge', 'person_in_charge.pic_id', '=', 'inventory.pic_id')
            ->where('asset_name', 'like', "%" . $cari . "%")
            ->orWhere('pic_name', 'like', "%" . $cari . "%")
            ->orWhere('inventory_code', 'like', "%" . $cari . "%")
            ->orWhere('inventory_brand', 'like', "%" . $cari . "%")
            ->orWhere('condition', 'like', "%" . $cari . "%")
            ->orWhere('location_name', 'like', "%" . $cari . "%")
            ->select([
                'asset.asset_name', 'asset.asset_id',
                'inventory.inventory_brand', 'inventory.inventory_code',
                'inventory.condition', 'inventory.available', 'inventory.photo', 'inventory.inventory_id',
                'inventory.asset_id', 'inventory.location_id', 'inventory.pic_id', 'asset_location.location_id', 'asset_location.location_name', 'person_in_charge.pic_name',
                'person_in_charge.pic_id'
            ])
            ->paginate(10);

        $barangCollect = collect($indexBarang->items());

        $jumlahbarangs = $barangCollect->reduce(function ($prev, $current) use ($barangCollect) {

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
        // $newJumlahBarangs = collect($jumlahbarangs)->map(function ($mapJumlah) use ($indexStart) {
        //     $mapJumlah['indexStart'] = $indexStart;
        //     $indexStart +=  $mapJumlah['jumlah'];
        //     return $mapJumlah;
        // });
        $newArrayJumlahbarang =  array_values($jumlahbarangs);
        for ($index2 = 0; $index2 <= count($jumlahbarangs) - 1; $index2++) {
            $newArrayJumlahbarang[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahbarang[$index2]['jumlah'];
        }

        $barang = ([
            'items' => $indexBarang,
            'jumlahs' => $newArrayJumlahbarang,
        ]);


        // mengirim data barang ke view index
        return view('pages.barang.barang', compact('barang'));
    }

    public function print()
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

        $jumlahbarangs = $barangCollect->reduce(function ($prev, $current) use ($barangCollect) {

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

        $newArrayJumlahbarang =  array_values($jumlahbarangs);
        for ($index2 = 0; $index2 <= count($jumlahbarangs) - 1; $index2++) {
            $newArrayJumlahbarang[$index2]['indexStart'] = $indexStart;
            $indexStart +=  $newArrayJumlahbarang[$index2]['jumlah'];
        }



        $barang = ([
            'items' => $indexBarang,
            'jumlahs' => $newArrayJumlahbarang,
        ]);


        $pdf = pdf::loadview('pages.barang.cetak', ['barang' => $barang]);
        return $pdf->stream('barang-pdf');
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
