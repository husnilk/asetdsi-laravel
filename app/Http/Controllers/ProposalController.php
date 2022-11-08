<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('type_id', '=', 1)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        return view('pages.pengusulan.pengusulan', compact('indexPengusulan'));
    }

    public function indexmt()
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('type_id', '=', 2)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        return view('pages.pengusulan.pengusulanmt', compact('indexPengusulan'));
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
     * @param  \App\Http\Requests\StoreProposalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::guard('pj')->user();

        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('proposal.type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();


        $indexReqBarang = DB::table('request_proposal_asset')
            ->join('proposal', 'proposal.id', '=', 'request_proposal_asset.proposal_id')
            ->where('request_proposal_asset.proposal_id', '=', $id)
            ->select([
                'request_proposal_asset.asset_name',
                'request_proposal_asset.spesification_detail',
                'request_proposal_asset.amount',
                'request_proposal_asset.unit_price',
                'request_proposal_asset.source_shop',
                'request_proposal_asset.proposal_id'
            ])
            ->orderBy('asset_name')
            ->get();

        return view('pages.pengusulan.show', compact('indexReqBarang', 'indexPengusulan'));
    }

    public function showmt($id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('proposal.type_id', '=', 2)
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

         
        $indexReqBarang = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('inventory_item', 'inventory_item.id', '=', 'request_maintenence_asset.inventory_item_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.inventory_item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id',

            ])
            ->orderBy('merk_barang')
            ->get();
            $photos=[];

        if (count($indexReqBarang) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $indexReqBarang[0]->id)
                ->select([
                    'photos.photo_name'
                ])
                ->get();
        }




        return view('pages.pengusulan.showmt', compact('indexReqBarang', 'indexPengusulan', 'photos'));
    }

    public function acc(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();
    

            $user_id = $indexPengusulan[0]->mahasiswa_id;

        $indexReqBarang = DB::table('request_proposal_asset')
            ->join('proposal', 'proposal.id', '=', 'request_proposal_asset.proposal_id')
            ->where('request_proposal_asset.proposal_id', '=', $id)
            ->select([
                'request_proposal_asset.asset_name',
                'request_proposal_asset.spesification_detail',
                'request_proposal_asset.amount',
                'request_proposal_asset.unit_price',
                'request_proposal_asset.source_shop',
                'request_proposal_asset.proposal_id'
            ])
            ->orderBy('asset_name')
            ->get();
        
        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'accepted',

            ]);

          

            if ($update) {
                //berhasil login, kirim notifikasi
                $this->sendNotification($user_id);
            } 

        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang', 'update'));
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

 
            $user_id = $indexPengusulan[0]->mahasiswa_id;

        $indexReqBarang = DB::table('request_proposal_asset')
            ->join('proposal', 'proposal.id', '=', 'request_proposal_asset.proposal_id')
            ->where('request_proposal_asset.proposal_id', '=', $id)
            ->select([
                'request_proposal_asset.asset_name',
                'request_proposal_asset.spesification_detail',
                'request_proposal_asset.amount',
                'request_proposal_asset.unit_price',
                'request_proposal_asset.source_shop',
                'request_proposal_asset.proposal_id'
            ])
            ->orderBy('asset_name')
            ->get();


        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

            if ($update) {
                //berhasil login, kirim notifikasi
                $this->sendNotification($user_id);
            } 


        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang', 'update'));
    }

    public function accmt(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

 
            $user_id = $indexPengusulan[0]->mahasiswa_id;

        $indexReqBarang = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('inventory_item', 'inventory_item.id', '=', 'request_maintenence_asset.inventory_item_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.inventory_item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id',

            ])
            ->orderBy('merk_barang')
            ->get();

        if (count($indexReqBarang) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $indexReqBarang[0]->id)
                ->select([
                    'photos.photo_name'
                ])
                ->get();
        }


        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'accepted',

            ]);

            if ($update) {
                //berhasil login, kirim notifikasi
                $this->sendNotification($user_id);
            } 

        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang', 'update'));
    }

    public function rejectmt(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();
         
            $user_id = $indexPengusulan[0]->mahasiswa_id;

        $indexReqBarang = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('inventory_item', 'inventory_item.id', '=', 'request_maintenence_asset.inventory_item_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.inventory_item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id',

            ])
            ->orderBy('merk_barang')
            ->get();

        if (count($indexReqBarang) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $indexReqBarang[0]->id)
                ->select([
                    'photos.photo_name'
                ])
                ->get();
        }


        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

            if ($update) {
                //berhasil login, kirim notifikasi
                $this->sendNotification($user_id);
            } 


        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang', 'update'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProposalRequest  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        //
    }

    //Notifikasi
    public function sendNotification($user_id)
    {
       
        $mahasiswa= DB::table('mahasiswa')
        ->where('id', '=', $user_id)
        ->get(
            'mahasiswa.remember_token'
        );

        $fcm_token = $mahasiswa[0]->remember_token;
        // dd($fcm_token);

        // dd($mahasiswa);
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "to" : "'.$fcm_token.'",
    "notification":{
        "title" : "Permintaan Aset",
        "body" : "Permintaanmu Sudah Di Proses"
    }
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=AAAAM1IGgOM:APA91bFA6AwUtor2HIY_-wSOAx0paFwQGjXOlosxTg4X7wSMIYKYxA4r-9XO9b5LIeL5g7OWgYnxizMwkjjJ6OXKGcIkCwYfbDr8PuDro6n87QDD86OOeh7Sf8tvoCbTQNqB1aX6w1hP ',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
