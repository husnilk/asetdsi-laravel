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
use App\Models\Proposal;
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

    public function store(Request $request, $id)
    {

        $pj = PersonInCharge::where('id',$id)->get();
        $user_id = auth('sanctum')->user()->id;
  
            $proposal = Proposal::create([
                'proposal_description' => $request->proposal_description,
                'status'   => "waiting",
                'type_id' => 1,
                'pic_id' => $id,
                'mahasiswa_id'=> $user_id
    
            ]);

            $i = 0;
            foreach ($request->aset as $data) {
                $request_aset = RequestProposalAsset::create(
                    [
                        'asset_name' => $request->aset[$i]['asset_name'],
                        'spesification_detail' => $request->aset[$i]['spesification_detail'],
                        'amount'   => $request->aset[$i]['amount'],
                        'unit_price' => $request->aset[$i]['unit_price'],
                        'source_shop' => $request->aset[$i]['source_shop'],
                        'proposal_id' => $proposal->id
                    ]
                );
    
                $i++;
            };
    

            return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan']);
 
    
    
    //         return redirect('pengadaan')->with('success', 'Pengadaan berhasil ditambahkan');
        }
    }

