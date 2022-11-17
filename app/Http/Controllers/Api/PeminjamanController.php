<?php

namespace App\Http\Controllers\Api;

use App\Events\PeminjamanAset;
use App\Events\PengusulanAset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\AssetLoanDetail;
use App\Models\BuildingLoanDetail;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Mahasiswa;
use App\Models\Notification;
use App\Models\PersonInCharge;
use Error;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Arr;
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

        $pj = PersonInCharge::where('id', $id)->get();


        $peminjamanbarang = DB::select(
            "SELECT asset.asset_name, inventory.inventory_brand,inventory.photo, count(inventory.inventory_brand) as
            jumlah,inventory_item.condition,inventory_item.pic_id, person_in_charge.pic_name, inventory_item.available,
            inventory_item.inventory_id, inventory_item.id 
            from inventory_item join inventory on inventory_item.inventory_id=inventory.id 
            join asset on inventory.asset_id=asset.id 
            join person_in_charge on person_in_charge.id=inventory_item.pic_id 
            where inventory_item.available='available' and inventory_item.condition='baik' 
            and inventory_item.pic_id=$id
            GROUP by inventory_brand
            "
        );


        $response = new \stdClass();
        $response->peminjamanbarang = $peminjamanbarang;
        return response()->json([
            'data' => $peminjamanbarang,
            'success' => true,
            'message' => 'Success',
        ]);
    }


    public function indexBangunan($id)
    {

        $pj = PersonInCharge::where('id', $id)->get();


        $peminjamanbangunan = DB::select(
            "SELECT asset.asset_name, building.building_name, count(building.building_name) as
            jumlah,building.available,building.photo,building.pic_id, person_in_charge.pic_name, building.id as building_id
            from building 
            join asset on building.asset_id=asset.id 
            join person_in_charge on person_in_charge.id=building.pic_id 
            where building.available='available' and building.condition='baik' 
            and building.pic_id=$id
            GROUP by building_name
            "
        );


        $response = new \stdClass();
        $response->peminjamanbangunan = $peminjamanbangunan;
        return response()->json([
            'data' => $peminjamanbangunan,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function storeBarang($id, Request $request)
    {

        $pj = PersonInCharge::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;
        $user_name = auth('sanctum')->user()->name;

        $loan = Loan::create([
            'loan_date' => $request->loan_date,
            'loan_description' => $request->loan_description,
            'loan_time' => $request->loan_time,
            'status'   => "waiting",
            'type_id' => 1,
            'pic_id' => $id,
            'mahasiswa_id' => $user_id,
        ]);

        if ($request->data) {
            foreach ($request->data as $data) {
                if ($data) {
                    $array = json_decode($data, true);

                    $inventoryItems = InventoryItem::where([
                        'inventory_id' => $array['inventory_id'],
                        'available' => 'available',
                        'pic_id'  => $id
                    ])->limit($array['value_jumlah'])->get();

                    // $inv = json_decode(json_encode($inventoryItems->toArray();
                    if (count($inventoryItems) < $array['value_jumlah']) throw new Error('Stock tidak cukup');
                    $itemsArr = [];
                    foreach ($inventoryItems as $item) {
                        $detail = AssetLoanDetail::create([
                            'inventory_item_id' => $item['id'],
                            'loan_id' => $loan->id
                        ]);
                    }
                }
            };
        }

        PeminjamanAset::dispatch($user_name . ' Melakukan Peminjaman Barang');

        $create = Notification::create([
            'sender_id' => $user_id ,
            'sender' => 'mahasiswa',
            'receiver_id' => $id,
            'receiver' => 'person_in_charge',
            'message' => $user_name . ' Melakukan Peminjaman Barang',
            'object_type_id' => $loan->id,
            'object_type' => 'peminjaman_barang'
        ]);

        $response = new \stdClass();
        return response()->json([
            'success' => true,
            'message' => 'Success',
        ]);
    }

    // public function storeBarang($id, Request $request)
    // {

    //     $pj = PersonInCharge::where('id', $id)->get();
    //     $user_id = auth('sanctum')->user()->id;

    //     $loan = Loan::create([
    //         'loan_date' => $request->loan_date,
    //         'loan_description' => $request->loan_description,
    //         'loan_time' => $request->loan_time,
    //         'status'   => "waiting",
    //         'type_id' => 1,
    //         'pic_id' => $id,
    //         'mahasiswa_id' => $user_id
    //     ]);

    //     $data = [
    //         'loan_description' =>  $loan->loan_description,
    //         'loan_date' => $loan->loan_date,
    //         'loan_time' => $loan->loan_time,
    //         'status' => $loan->status,
    //         'type_id' => $loan->type,
    //         'pic_id' => $loan->pic_id,
    //         'mahasiswa_id' => $loan->mahasiswa_id,
    //         'inventoryItems' => []


    //     ];



    //     if (isset($request->aset) && is_array($request->aset)) {
    //         foreach ($request->aset as $value) {
    //             // dd($value);
    //             $inventoryItems = InventoryItem::where([
    //                 'inventory_id' => $value['inventory_id'],
    //                 'available' => 'available',
    //                 'pic_id'  => $id
    //             ])->limit($value['amount'])->get();

    //             // $inv = json_decode(json_encode($inventoryItems->toArray();
    //             if (count($inventoryItems) < $value['amount']) throw new Error('Stock tidak cukup');
    //             $itemsArr = [];
    //             foreach ($inventoryItems as $item) {


    //                 $detail = AssetLoanDetail::create([
    //                     'inventory_item_id' => $item['id'],
    //                     'loan_id' => $loan->id


    //                 ]);
    //                 // $item->update(['available'=>'not-available']);

    //                 $barang = DB::select("SELECT inventory.inventory_brand,inventory.photo, 
    //                 count(inventory.inventory_brand) as jumlah,
    //                 inventory_item.condition,inventory_item.pic_id, person_in_charge.pic_name, 
    //                 inventory_item.available,
    //                 asset.asset_name 
    //                 from inventory_item 
    //                 join inventory on inventory_item.inventory_id=inventory.id
    //                 join person_in_charge on person_in_charge.id=inventory_item.pic_id
    //                 join asset on inventory.asset_id=asset.id
    //                 where inventory_id = $item->inventory_id
    //                 GROUP by asset_name");

    //                 $detail->barang = $barang;
    //                 // array_push($detailLoan,  $detail);
    //                 $item->detailLoan = $detail;
    //                 array_push($itemsArr,  $item);
    //             }
    //             array_push($data['inventoryItems'], $itemsArr);
    //         }
    //     }

    //     $response = new \stdClass();
    //     $response->data = $data;
    //     return response()->json([
    //         'data' => $data,
    //         'success' => true,
    //         'message' => 'Success',
    //     ]);
    // }


    public function storeBangunan($id, Request $request)
    {

        $pj = PersonInCharge::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;
        $user_name = auth('sanctum')->user()->name;

        $loan = Loan::create([
            'loan_date' => $request->loan_date,
            'loan_description' => $request->loan_description,
            'loan_time' => $request->loan_time,
            'status'   => "waiting",
            'type_id' => 2,
            'pic_id' => $id,
            'mahasiswa_id' => $user_id
        ]);


        $detail = BuildingLoanDetail::create([
            'building_id' => $request->building_id,
            'loan_id' => $loan->id

        ]);

        PeminjamanAset::dispatch($user_name . ' Melakukan Peminjaman Bangunan');

        $create = Notification::create([
            'sender_id' => $user_id ,
            'sender' => 'mahasiswa',
            'receiver_id' => $id,
            'receiver' => 'person_in_charge',
            'message' => $user_name . ' Melakukan Peminjaman Bangunan',
            'object_type_id' => $loan->id,
            'object_type' => 'peminjaman_bangunan'
        ]);

        $response = new \stdClass();
        return response()->json([
            // 'data' => $data,
            'success' => true,
            'message' => 'Success',
        ]);
    }
} 
       
    // public function storeBangunan($id, Request $request)
    // {

    //     $pj = PersonInCharge::where('id',$id)->get();
    //     $user_id = auth('sanctum')->user()->id;
    //     $data = [];
    //    if (isset($request->aset) && is_array($request->aset)) {
    //        foreach ($request->aset as $value) {
    //         // dd($value);
    //          $inventoryItems = InventoryItem::where([
    //             'inventory_id' => $value['inventory_id'], 
    //             'available' => 'available', 
    //             'pic_id'  => $id
    //             ])->limit($value['amount'])->get();

    //         if(count($inventoryItems) < $value['amount']) throw new Error('Stock tidak cukup');

    //             $loan = Loan::create([
    //                 'loan_date' => $request->loan_date,
    //                 'loan_description' =>$request->loan_description,
    //                 'loan_time'=>$request->loan_time,
    //                 'status'   => "waiting",
    //                 'type_id' => 1,
    //                 'pic_id' => $id,
    //                 'mahasiswa_id'=> $user_id
    //             ]);
    //             $inventoryItems->loan = $loan;
    //             $inventoryItems->detailLoan = [];
    //             foreach ($inventoryItems as $item) {


    //                $detail = AssetLoanDetail::create([
    //                     'inventory_item_id'=>$item['id'],
    //                     'loan_id' => $loan->id

    //                 ]);
    //                 array_push($inventoryItems->detailLoan,  $detail);
    //             }

    //            array_push($data, $inventoryItems);
    //        }
    //    } 


    //     $response = new \stdClass();
    //     return response()->json([
    //         'data' => $data,
    //         'success' => true,
    //         'message' => 'Success',
    //     ]);
    // }
