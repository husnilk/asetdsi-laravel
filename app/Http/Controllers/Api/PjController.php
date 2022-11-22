<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Inventory;
use App\Models\Mahasiswa;
use App\Models\PersonInCharge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pj = PersonInCharge::all();

        $pjsmap = collect($pj)->map(function ($item) {
            $indexBangunan = DB::table('building')
                ->join('asset', 'asset.id', '=', 'building.asset_id')
                ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
                ->where('building.available','=','available')
                ->where('building.condition','=','baik')
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
                ->where('inventory_item.available','=','available')
                ->where('inventory_item.condition','=','baik')
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

        $response = new \stdClass();
        $response->pjsmap = $pjsmap;
        return response()->json([
            'data' => $pjsmap,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function indexpengusulan()
    {

        $pj = PersonInCharge::all();

        $pjsmap = collect($pj)->map(function ($item) {
            $indexBangunan = DB::table('building')
                ->join('asset', 'asset.id', '=', 'building.asset_id')
                ->join('person_in_charge', 'person_in_charge.id', '=', 'building.pic_id')
                ->where('building.available','=','available')
                ->where('building.condition','=','baik')
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
                ->where('inventory_item.condition','=','baik')
                ->where('inventory_item.available','=','available')
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

        $response = new \stdClass();
        $response->pjsmap = $pjsmap;
        return response()->json([
            'data' => $pjsmap,
            'success' => true,
            'message' => 'Success',
        ]);
    }


    

}
