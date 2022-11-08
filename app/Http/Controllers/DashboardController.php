<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Mahasiswa;
use App\Models\PersonInCharge;
use App\Models\InventoryItem;
use App\Models\Building;
use App\Models\admin;
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
}
