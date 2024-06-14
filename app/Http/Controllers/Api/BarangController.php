<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Inventory;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $barang = Inventory::all();
        $barang = DB::select("SELECT inventory.inventory_brand,inventory.photo, count(inventory.inventory_brand) as jumlah,inventory_item.condition,
        inventory_item.pic_id, person_in_charge.pic_name, inventory_item.available from inventory_item 
        join inventory on inventory_item.inventory_id=inventory.id
        join person_in_charge on person_in_charge.id=inventory_item.pic_id
        where inventory_item.available='available' and inventory_item.condition='baik'
        GROUP by inventory_brand");
        $response = new \stdClass();
        $response->barang = $barang;
        return response()->json([
            'data' => $barang,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    
    public function daftarBarang()
    {
        $barang = DB::select("SELECT inventory.inventory_brand,inventory.photo, count(inventory.inventory_brand) as jumlah,inventory_item.condition,
        inventory_item.pic_id, person_in_charge.pic_name, inventory_item.available from inventory_item 
        join inventory on inventory_item.inventory_id=inventory.id
        join person_in_charge on person_in_charge.id=inventory_item.pic_id
        where inventory_item.available='available' and inventory_item.condition='baik'
        GROUP by inventory_brand,pic_id
        ");

        $response = new \stdClass();
        $response->barang = $barang;
        return response()->json([
            'data' => $barang,
            'success' => true,
            'message' => 'Success',
        ]);
    }
}
