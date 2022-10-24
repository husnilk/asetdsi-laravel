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

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
      
        $pj = PersonInCharge::where('id',$id)->get();


        $peminjamanbarang = DB::select(
            "SELECT asset.asset_name, inventory.inventory_brand,inventory.photo, count(inventory.inventory_brand) as
            jumlah,inventory_item.condition,inventory_item.pic_id, person_in_charge.pic_name, inventory_item.available 
            from inventory_item join inventory on inventory_item.inventory_id=inventory.id 
            join asset on inventory.asset_id=asset.id 
            join person_in_charge on person_in_charge.id=inventory_item.pic_id 
            where inventory_item.available='available' and inventory_item.condition='baik' 
            and inventory_item.pic_id=$id
            GROUP by inventory_brand
            "
        );


        $response = new \stdClass();
        $response->peminjamanbarang= $peminjamanbarang;
        return response()->json([
            'data' => $peminjamanbarang,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    

}
