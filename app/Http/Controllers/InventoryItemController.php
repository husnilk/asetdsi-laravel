<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use Carbon\Carbon;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {


        $selected = DB::table('inventory')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id', 'inventory.id', 'asset.asset_name', 'asset.id'
            ]);


        $indexItem = DB::table('inventory_item')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->orderBy('pic_name')
            ->get([
                'inventory.inventory_brand', 'inventory.id', 'inventory.asset_id', 'inventory.photo',
                'inventory_item.item_code', 'inventory_item.condition', 'inventory_item.available', 'inventory_item.id as item_id',
                'inventory_item.location_id', 'inventory_item.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id', 'asset_location.id', 'asset_location.location_name', 'asset.id', 'asset.asset_name'
            ]);


        $indexItem->jumlah = count($indexItem);
        $lokasi = DB::table('asset_location')
            ->get(['id', 'location_name']);

        $pj = DB::table('person_in_charge')
            ->get(['id', 'pic_name']);


        return view('pages.stock.index', compact('indexItem', 'selected', 'lokasi', 'pj'));
    }


    public function item()
    {

        $pj = DB::table('person_in_charge')->get();

        $pjsmap = collect($pj)->map(function ($item) {
            $indexBangunan = DB::table('building')
                ->join('asset', 'asset.id', '=', 'building.asset_id')
                ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
                ->where('person_in_charge.id', '=', $item->id)
                ->select([
                    'asset.asset_name as nama_aset', 'building.building_name as nama_barang', 'building.building_code as kode_aset',
                    'building.condition as kondisi', 'building.available as status', 'person_in_charge.pic_name as pj', 'building.photo as photo',
                    'asset.id as asset_id'

                ]);
            $indexItems = DB::table('inventory_item')
                ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
                ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
                ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
                ->join('asset', 'asset.id', '=', 'inventory.asset_id')
                ->where('person_in_charge.id', '=', $item->id)
                ->select([
                    'asset.asset_name as nama_aset', 'inventory.inventory_brand as nama_barang', 'inventory_item.item_code as kode_aset',
                    'inventory_item.condition as kondisi', 'inventory_item.available as status', 'person_in_charge.pic_name as pj', 'inventory.photo as photo',
                    'asset.id as asset_id'

                ])
                ->union($indexBangunan)->get()->count();


            $item->jumlah =  $indexItems;

            return $item;
        });


        return view('pages.newbarang.item', compact('pj', 'pjsmap'));
    }

    public function list($id)
    {

        $selected = DB::table('person_in_charge')
            ->where('person_in_charge.id', '=', $id)
            ->get();


        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->where('person_in_charge.id', '=', $id)
            ->select([
                'asset.asset_name as nama_aset', 'building.building_name as nama_barang', 'building.building_code as kode_aset',
                'building.condition as kondisi', 'building.available as status', 'person_in_charge.pic_name as pj', 'building.photo as photo',
                'asset.id as asset_id',  'person_in_charge.id as pj_id'

            ]);

        $indexItems = DB::table('inventory_item')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('person_in_charge.id', '=', $id)
            ->select([
                'asset.asset_name as nama_aset', 'inventory.inventory_brand as nama_barang', 'inventory_item.item_code as kode_aset',
                'inventory_item.condition as kondisi', 'inventory_item.available as status', 'person_in_charge.pic_name as pj', 'inventory.photo as photo',
                'asset.id as asset_id', 'person_in_charge.id as pj_id'

            ])
            ->union($indexBangunan)->get();

        $newItems = collect($indexItems);

        $indexItem = $newItems->map(function ($item, $index)  use ($newItems) {
            $filterItem = $newItems->filter(function ($itemFIlter) use ($item) {
                return $itemFIlter->asset_id ===  $item->asset_id;
            });
            // dd($newItems[0]->nama_aset);
            $item->jumlah = count($filterItem);
            if ($index == 0) {
                $item->indexPosition = 'start';
            } else if ($newItems[$index - 1]->nama_aset != $item->nama_aset) {
                $item->indexPosition = 'start';
            } else if (count($newItems) - 1 === $index) {
                $item->indexPosition = 'end';
            } else if ($newItems[$index + 1]->nama_aset != $item->nama_aset) {
                $item->indexPosition = 'end';
            } else {
                $item->indexPosition = 'middle';
            }
            // $item->indexPosition = 
            return $item;
        });




        return view('pages.newbarang.list', compact('indexItem', 'selected'));
    }

    public function print($id)
    {
        $selected = DB::table('person_in_charge')
            ->where('person_in_charge.id', '=', $id)
            ->get();


        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
            ->where('person_in_charge.id', '=', $id)
            ->select([
                'asset.asset_name as nama_aset', 'building.building_name as nama_barang', 'building.building_code as kode_aset',
                'building.condition as kondisi', 'building.available as status', 'person_in_charge.pic_name as pj', 'building.photo as photo',
                'asset.id as asset_id', 'person_in_charge.id as pj_id'

            ]);


        $indexItems = DB::table('inventory_item')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('person_in_charge.id', '=', $id)
            ->select([
                'asset.asset_name as nama_aset', 'inventory.inventory_brand as nama_barang', 'inventory_item.item_code as kode_aset',
                'inventory_item.condition as kondisi', 'inventory_item.available as status', 'person_in_charge.pic_name as pj', 'inventory.photo as photo',
                'asset.id as asset_id', 'person_in_charge.id as pj_id'

            ])
            ->union($indexBangunan)->get();

        $newItems = collect($indexItems);

        $indexItem = $newItems->map(function ($item, $index)  use ($newItems) {
            $filterItem = $newItems->filter(function ($itemFIlter) use ($item) {
                return $itemFIlter->asset_id ===  $item->asset_id;
            });
            // dd($newItems[0]->nama_aset);
            $item->jumlah = count($filterItem);
            if ($index == 0) {
                $item->indexPosition = 'start';
            } else if ($newItems[$index - 1]->nama_aset != $item->nama_aset) {
                $item->indexPosition = 'start';
            } else if (count($newItems) - 1 === $index) {
                $item->indexPosition = 'end';
            } else if ($newItems[$index + 1]->nama_aset != $item->nama_aset) {
                $item->indexPosition = 'end';
            } else {
                $item->indexPosition = 'middle';
            }
            // $item->indexPosition = 
            return $item;
        });
        $now = Carbon::today();
        $year = $now->year;

        $pdf = pdf::loadview('pages.newbarang.cetak', ['indexItem' => $indexItem, 'selected' => $selected], ['year' => $year])->setPaper('A4', 'portrait');
        return $pdf->stream('barang-pdf');
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
     * @param  \App\Http\Requests\StoreInventoryItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $i = 0;
        foreach ($request->item_code as $data) {

            $stock = InventoryItem::create(
                [

                    'item_code' => $request->item_code[$i],
                    'condition'  => $request->condition[$i],
                    'available' => $request->available[$i],

                    'inventory_id'  => $request->inventory_id,
                    'location_id'  => $request->location_id[$i],
                    'pic_id'  => $request->pic_id[$i]

                ]
            );



            $i++;
        }



        return redirect('barang')->with('success', 'stock berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = DB::table('inventory_item')
            ->get([
                'inventory_item.item_code',
                'inventory_item.condition', 'inventory_item.available',
                'inventory_item.location_id', 'inventory_item.pic_id'
            ]);

        $barang = DB::table('inventory')
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id'
            ]);


        $lokasi = DB::table('asset_location')
            ->get(['id', 'location_name']);

        $pj = DB::table('person_in_charge')
            ->get(['id', 'pic_name']);

        $selected = DB::table('inventory')
            ->where('inventory.id', '=', $id)
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id', 'inventory.id'
            ]);


        return view('pages.bangunan.edit', compact('indexBangunan', 'aset', 'pj'));
    }

    //create item barang
    public function stock($id)
    {

        $item = DB::table('inventory_item')
            ->get([
                'inventory_item.item_code',
                'inventory_item.condition', 'inventory_item.available',
                'inventory_item.location_id', 'inventory_item.pic_id'
            ]);

        $barang = DB::table('inventory')
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id'
            ]);


        $lokasi = DB::table('asset_location')
            ->get(['id', 'location_name']);

        $pj = DB::table('person_in_charge')
            ->get(['id', 'pic_name']);

        $selected = DB::table('inventory')
            ->where('inventory.id', '=', $id)
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id', 'inventory.id'
            ]);



        return view('pages.stock.stock', compact('barang', 'item', 'lokasi', 'pj', 'selected'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryItemRequest  $request
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $selected = DB::table('inventory')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id', 'inventory.id', 'asset.asset_name', 'asset.id'
            ]);


        $indexItem = DB::table('inventory_item')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->get([
                'inventory.inventory_brand', 'inventory.id', 'inventory.asset_id', 'inventory.photo',
                'inventory_item.item_code', 'inventory_item.condition', 'inventory_item.available', 'inventory_item.id',
                'inventory_item.location_id', 'inventory_item.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id', 'asset_location.id', 'asset_location.location_name', 'asset.id', 'asset.asset_name'
            ]);



        $update = DB::table('inventory_item')
            ->where('inventory_item.id', '=', $id)
            ->update([
                'condition' => $request->condition,
                'pic_id' => $request->pic_id,
                'location_id' => $request->location_id,
                'available' => $request->available
            ]);



        return redirect()->back()->with('success', 'Item berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryItem  $inventoryItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = InventoryItem::find($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }
}
