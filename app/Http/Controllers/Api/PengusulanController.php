<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Mahasiswa;
use App\Models\PersonInCharge;
use App\Models\Photos;
use App\Models\Proposal;
use App\Models\RequestMaintenenceAsset;
use App\Models\RequestProposalAsset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengusulanController extends Controller
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
            jumlah,inventory_item.condition,inventory_item.pic_id, person_in_charge.pic_name, inventory_item.available, inventory_item.item_code,
            inventory_item.inventory_id, inventory_item.id
            from inventory_item join inventory on inventory_item.inventory_id=inventory.id 
            join asset on inventory.asset_id=asset.id 
            join person_in_charge on person_in_charge.id=inventory_item.pic_id 
            where inventory_item.available='not-available' and inventory_item.condition='buruk' 
            and inventory_item.pic_id=$id
            GROUP by inventory_brand
            "
        );

        // $updateValue= DB::table('inventory_item')
        // ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        // ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
        // ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
        // ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        // ->where('person_in_charge.id', '=', $id)
        // ->select([
        //     'amount' => $request->value_jumlah

        // ]);

        $response = new \stdClass();
        $response->peminjamanbarang = $peminjamanbarang;
        return response()->json([
            'data' => $peminjamanbarang,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    // public function store(Request $request, $id)
    // {

    //     // dd($request->all());
    //     $pj = PersonInCharge::where('id',$id)->get();
    //     $user_id = auth('sanctum')->user()->id;

    //         $proposal = Proposal::create([
    //             'proposal_description' => $request->proposal_description,
    //             'status'   => "waiting",
    //             'type_id' => 1,
    //             'pic_id' => $id,
    //             'mahasiswa_id'=> $user_id

    //         ]);


    //         $i = 0;
    //         foreach ($request->aset as $data) {
    //             $request_aset = RequestProposalAsset::create(
    //                 [
    //                     // 'asset_name' => $request->asset_name[$i],
    //                     // 'spesification_detail' => $request->spesification_detail[$i],
    //                     // 'amount'   => $request->amount[$i],
    //                     // 'unit_price' => $request->unit_price[$i],
    //                     // 'source_shop' => $request->source_shop[$i],
    //                     // 'proposal_id' => $proposal->id

    //                     'asset_name' => $request->aset[$i]['asset_name'],
    //                     'spesification_detail' => $request->aset[$i]['spesification_detail'],
    //                     'amount'   => $request->aset[$i]['amount'],
    //                     'unit_price' => $request->aset[$i]['unit_price'],
    //                     'source_shop' => $request->aset[$i]['source_shop'],
    //                     'proposal_id' => $proposal->id
    //                 ]
    //             );


    //             $i++;
    //         };


    //         return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan']);



    // //         return redirect('pengadaan')->with('success', 'Pengadaan berhasil ditambahkan');
    //     }
    // }

    public function store(Request $request, $id)
    {
        // $pj = PersonInCharge::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;

        $proposal = Proposal::create([
            'proposal_description' => $request->proposal_description,
            'status'   => "waiting",
            'type_id' => 1,
            'mahasiswa_id' => $user_id
        ]);
        if ($request->data) {
            foreach ($request->data as $data) {
                if ($data) {
                    $array = json_decode($data, true);
                    $request_aset = RequestProposalAsset::create(
                        [
                            'asset_name' => $array['nama_pengusulan_barang'],
                            'spesification_detail' => $array['detail_spesifikasi_pengusulan_barang'],
                            'amount'   => $array['jumlah_pengusulan_barang'],
                            'unit_price' => $array['harga_pengusulan_barang'],
                            'source_shop' => $array['sumber_pengusulan_barang'],
                            'proposal_id' => $proposal->id,
                        ]
                    );
                }
            };
        }

        return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan']);

        //         return redirect('pengadaan')->with('success', 'Pengadaan berhasil ditambahkan');
    }

    public function storemt(Request $request, $id)
    {
        $pj = PersonInCharge::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;

        $proposal = Proposal::create([
            'proposal_description' => $request->proposal_description,
            'status'   => "waiting",
            'type_id' => 2,
            'pic_id' => $id,
            'mahasiswa_id' => $user_id
        ]);

       
        if ($request->data) {
            foreach ($request->data as $data) {
              
                $request_aset = RequestMaintenenceAsset::create(
                    [

                        'inventory_item_id' => $data['inventory_item_id'],
                        'problem_description' => $data['problem_description'],
                        'proposal_id' => $proposal->id

                    ]
                );

                if ($data['photo']) {

                    foreach ($data['photo'] as $photo) {
                    $file = $photo['photo_name'];
                    Photos::create(
                        [
                            'photo_name' => $file,
                            'req_maintenence_id' => $request_aset->id
                        ]);
        
                }
                }else {

                    $file = "https://res.cloudinary.com/nishia/image/upload/v1663485047/default-image_yasmsd.jpg";
        
                    Photos::create(
                        [
                            'photo_name' => $file,
                            'req_maintenence_id' => $request_aset->id
                    ]);
                }

    
        
        }
    }
        return response()->json(['message' => 'Pengusulan Maintenence berhasil dilaksanakan']);

        //         return redirect('pengadaan')->with('success', 'Pengadaan berhasil ditambahkan');
    }
}
