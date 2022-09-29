<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class RekapController extends Controller
{
    public function index()
    {

        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
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
            ->select([
                'asset.asset_name as nama_aset', 'inventory.inventory_brand as nama_barang', 'inventory_item.item_code as kode_aset',
                'inventory_item.condition as kondisi', 'inventory_item.available as status', 'person_in_charge.pic_name as pj', 'inventory.photo as photo',
                'asset.id as asset_id'

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


        return view('pages.rekap.rekap', compact('indexItem'));
    }

    public function print()
    {

        $indexBangunan = DB::table('building')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
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
            ->select([
                'asset.asset_name as nama_aset', 'inventory.inventory_brand as nama_barang', 'inventory_item.item_code as kode_aset',
                'inventory_item.condition as kondisi', 'inventory_item.available as status', 'person_in_charge.pic_name as pj', 'inventory.photo as photo',
                'asset.id as asset_id'

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

        $pdf = pdf::loadview('pages.rekap.cetak', ['indexItem' => $indexItem],['year' => $year])->setPaper('A4', 'portrait');
        return $pdf->stream('rekap-asetDSI-pdf');

    }
}
