<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Mahasiswa;
use App\Models\PersonInCharge;
use App\Models\InventoryItem;
use App\Models\Building;
use App\Models\admin;
use App\Models\Inventory;
use App\Models\Loan;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function index () {
        $mahasiswaCount = Mahasiswa::count();
        $pjCount = PersonInCharge::count();
        $inventoryItemCount = InventoryItem::count();
        $buildingCount = Building::count();

        // $inventoryItemDate = InventoryItem::whereBetween('created_at', 
        //  [   (new Carbon)->subDays(360)->startOfDay()->toDateString(),(new Carbon)->now()->addDay(1)->endOfDay()->toDateString()]
        // )->get();
        $fromDate = (new Carbon)->subDays(360)->startOfDay()->toDateString();
        $toDate = (new Carbon)->now()->addDay(1)->endOfDay()->toDateString();

       $inventoryItemDate = DB::table('inventory_item')
        // ->select(DB::raw('count(id) as data'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->selectRaw("count(id) as data , DATE_FORMAT(created_at, '%m-%Y') new_date , YEAR(created_at) year, MONTH(created_at) month")
        ->whereRaw(
            "(created_at >= ? AND created_at <= ?)", 
            [
               $fromDate ." 00:00:00", 
               $toDate ." 23:59:59"
            ]
          )
        ->groupby('year','month')
        ->get()->toArray();
        
        $monthNumber = [1,2,3,4,5,6,7,8,9,10,11,12];
            
        $newInventoryChart = [];
       $asetChart = array_map(function ($data) use ($inventoryItemDate) { 
            foreach ($inventoryItemDate as $itemMonth) {
                if ($data == $itemMonth->month ) {
                   return json_decode(json_encode($itemMonth), true);
                }
            }

            return [
                "data" => 0,
                "new_date" => $data ."-".   $itemMonth->year,
                "year" => $itemMonth->year,
                "month" => $data,
            ]; 
        
        }, $monthNumber);
 
        $getdataMonth = array_map(function ($data) { 

            return $data['data'];
        
        }, $asetChart);
        // dd( $mappingData);
        // dd($inventoryItemDate);
        // $monthsChart = [
        //     [
        //       'name'  
        //     ]  
        // ]; 

        $monthDataEncode = json_encode($getdataMonth);
     
        return view('index', compact('mahasiswaCount', 'pjCount', 'inventoryItemCount', 'buildingCount', 'inventoryItemDate', 'monthDataEncode'));
    }

    public function indexPj () {

        $user = Auth::guard('pj')->user();

        $mahasiswaCount = Mahasiswa::count();
        $pjCount = PersonInCharge::count();
        $inventory_item = DB::table('inventory_item')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
        ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->where('inventory_item.pic_id', '=', $user->id)
        ->get([
            'inventory.inventory_brand', 'inventory.id', 'inventory.asset_id', 'inventory.photo',
            'inventory_item.item_code', 'inventory_item.condition', 'inventory_item.available', 'inventory_item.id as item_id',
            'inventory_item.location_id', 'inventory_item.pic_id', 'person_in_charge.pic_name',
            'person_in_charge.id', 'asset_location.id', 'asset_location.location_name', 'asset.id', 'asset.asset_name'
        ]);

        $inventoryItemCount = $inventory_item->count();
        $building = Building::where('pic_id',$user->id)->get();
        $buildingCount = $building->count();
        $peminjaman = Loan::where('pic_id',$user->id)->get();
        $peminjamanCount = $peminjaman->count();
        $pengusulan = Proposal::where('pic_id',$user->id)->get();
        $pengusulanCount = $pengusulan->count();

        // $inventoryItemDate = InventoryItem::whereBetween('created_at', 
        //  [   (new Carbon)->subDays(360)->startOfDay()->toDateString(),(new Carbon)->now()->addDay(1)->endOfDay()->toDateString()]
        // )->get();
        $fromDate = (new Carbon)->subDays(360)->startOfDay()->toDateString();
        $toDate = (new Carbon)->now()->addDay(1)->endOfDay()->toDateString();

       $inventoryItemDate = DB::table('loan')
        // ->select(DB::raw('count(id) as data'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->selectRaw("count(id) as data , DATE_FORMAT(created_at, '%m-%Y') new_date , YEAR(created_at) year, MONTH(created_at) month")
        ->whereRaw(
            "(created_at >= ? AND created_at <= ?)", 
            [
               $fromDate ." 00:00:00", 
               $toDate ." 23:59:59"
            ]
          )
        ->groupby('year','month')
        ->get()->toArray();
       
        $monthNumber = [1,2,3,4,5,6,7,8,9,10,11,12];
            
        $newInventoryChart = [];
       $asetChart = array_map(function ($data) use ($inventoryItemDate) { 
            foreach ($inventoryItemDate as $itemMonth) {
                if ($data == $itemMonth->month ) {
                   return json_decode(json_encode($itemMonth), true);
                }
            }

            return [
                "data" => 0,
                "new_date" => $data ."-".   $itemMonth->year,
                "year" => $itemMonth->year,
                "month" => $data,
            ]; 
        
        }, $monthNumber);
 
        $getdataMonth = array_map(function ($data) { 

            return $data['data'];
        
        }, $asetChart);
        // dd( $mappingData);
        // dd($inventoryItemDate);
        // $monthsChart = [
        //     [
        //       'name'  
        //     ]  
        // ]; 

        $monthDataEncode = json_encode($getdataMonth);

        $pengusulanDate = DB::table('proposal')
        // ->select(DB::raw('count(id) as data'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        ->selectRaw("count(id) as data , DATE_FORMAT(created_at, '%m-%Y') new_date , YEAR(created_at) year, MONTH(created_at) month")
        ->whereRaw(
            "(created_at >= ? AND created_at <= ?)", 
            [
               $fromDate ." 00:00:00", 
               $toDate ." 23:59:59"
            ]
          )
        ->groupby('year','month')
        ->get()->toArray();
       
        $monthNumber = [1,2,3,4,5,6,7,8,9,10,11,12];
            
        $newInventoryChart = [];
       $pengusulanChart = array_map(function ($data) use ($pengusulanDate) { 
            foreach ($pengusulanDate as $itemMonth) {
                if ($data == $itemMonth->month ) {
                   return json_decode(json_encode($itemMonth), true);
                }
            }

            return [
                "data" => 0,
                "new_date" => $data ."-".   $itemMonth->year,
                "year" => $itemMonth->year,
                "month" => $data,
            ]; 
        
        }, $monthNumber);
 
        $getdataMonth = array_map(function ($data) { 

            return $data['data'];
        
        }, $pengusulanChart);
        // dd( $mappingData);
        // dd($inventoryItemDate);
        // $monthsChart = [
        //     [
        //       'name'  
        //     ]  
        // ]; 

        $monthDataPengusulanEncode = json_encode($getdataMonth);
     
        return view('indexPj', compact('mahasiswaCount', 'pjCount', 'inventoryItemCount', 'buildingCount', 'inventoryItemDate','pengusulanDate', 'monthDataEncode','monthDataPengusulanEncode','peminjamanCount','pengusulanCount'));
    }
}
