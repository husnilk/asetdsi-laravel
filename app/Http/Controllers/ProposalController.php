<?php

namespace App\Http\Controllers;

use App\Events\PeminjamanAset;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Notification;
use App\Models\PersonInCharge;
use App\Models\RequestProposalAsset;
use Error;
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
        $indexPengusulanPic = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
            ->get();

        $indexPengusulanMhs = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
            ->get();

        $result = array_merge($indexPengusulanPic->toArray(), $indexPengusulanMhs->toArray());

        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        return view('pages.pengusulan.pengusulan', compact('result'));
    }

    public function indexmt()
    {
        $user = Auth::guard('web')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 2)
            ->select([
                'person_in_charge.pic_name',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('pic_name')
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

        $proposal = DB::table('proposal')
            ->get([
                'proposal.proposal_description', 'proposal.status', 'proposal.id',
                'proposal.admins_id', 'proposal.pic_id', 'proposal.type_id'
            ]);

        // $mahasiswa = DB::table('mahasiswa')
        //     ->get(['id_mahasiswa', 'nama', 'username', 'password']);

        $request_proposal_asset = DB::table('request_proposal_asset')
            ->get(['id', 'asset_name', 'spesification_detail', 'amount', 'unit_price', 'source_shop', 'proposal_id']);

        return view('pages.p_j.pengusulan.create', compact('proposal', 'request_proposal_asset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProposalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::guard('pj')->user();


        $proposal = Proposal::create([
            'proposal_description' => $request->proposal_description,
            'status'   => "waiting",
            'type_id' => 1,
            'pic_id' => $user->id

        ]);


        $i = 0;
        foreach ($request->asset_name as $data) {

            $request_aset = RequestProposalAsset::create(
                [
                    'asset_name' => $request->asset_name[$i],
                    'spesification_detail' => $request->spesification_detail[$i],
                    'amount'   => $request->amount[$i],
                    'unit_price' => $request->unit_price[$i],
                    'source_shop' => $request->source_shop[$i],
                    'proposal_id' => $proposal->id,
                ]
            );

            $i++;
        }
        return redirect('pj-aset/pengusulan')->with('success', 'Pengadaan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $indexPengusulanPic = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
            ->get();

        $indexPengusulanMhs = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
            ->get();

        $result = array_merge($indexPengusulanPic->toArray(), $indexPengusulanMhs->toArray());

        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

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


        return view('pages.pengusulan.show', compact('result', 'indexReqBarang'));
    }

    public function showmt($id)
    {

        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')

            ->where('proposal.type_id', '=', 2)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
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


        $photos = [];

        foreach ($indexReqBarang as $data) {

            $photoShow = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $data->id)
                ->select([
                    'photos.photo_name', 'photos.req_maintenence_id'
                ])
                ->get();

            array_push($photos, $photoShow);
        }




        return view('pages.pengusulan.showmt', compact('indexReqBarang', 'indexPengusulan', 'photos'));
    }

    public function acc(Request $request, $id)
    {

        $user = Auth::guard('web')->user();

        $indexPengusulanPic = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
            ->get();

        $indexPengusulanMhs = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
            ->get();

        $result = array_merge($indexPengusulanPic->toArray(), $indexPengusulanMhs->toArray());

        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));


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
                'admins_id' => $user->id

            ]);



        if ($update) {
            if (count($result) > 0) {
                $check_mhs_id = isset($result[0]->mahasiswa_id);
                if ($check_mhs_id) {
                    $mhs_id = $result[0]->mahasiswa_id;
                    $this->sendNotification($mhs_id);

                    $create = Notification::create([
                        'sender_id' => $user->id,
                        'sender' => 'admins',
                        'receiver_id' => $result[0]->mahasiswa_id,
                        'receiver' => 'mahasiswa',
                        'message' => 'Permintaan Pengusulan Barang Diterima',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                } else {
                    PeminjamanAset::dispatch('Permintaan Pengusulan Barang Diterima');

                    $create = Notification::create([
                        'sender_id' => $user->id,
                        'sender' => 'admins',
                        'receiver_id' => $result[0]->pic_id,
                        'receiver' => 'person_in_charge',
                        'message' => 'Permintaan Pengusulan Barang Diterima',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                }
            }
            //berhasil login, kirim notifikasi
        }

        return redirect()->back()->with('success', compact('result', 'indexReqBarang'));
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::guard('web')->user();

        $indexPengusulanPic = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
            ->get();

        $indexPengusulanMhs = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
            ->get();

        $result = array_merge($indexPengusulanPic->toArray(), $indexPengusulanMhs->toArray());

        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        // $mhs_id = $result[0]->mahasiswa_id;

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
                'admins_id' => $user->id

            ]);

        if ($update) {
            if (count($result) > 0) {
                $check_mhs_id = isset($result[0]->mahasiswa_id);
                if ($check_mhs_id) {
                    $mhs_id = $result[0]->mahasiswa_id;
                    $this->sendNotification($mhs_id);


                    $create = Notification::create([
                        'sender_id' => $user->id,
                        'sender' => 'admins',
                        'receiver_id' => $result[0]->mahasiswa_id,
                        'receiver' => 'mahasiswa',
                        'message' => 'Permintaan Pengusulan Barang Ditolak',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                } else{
                    PeminjamanAset::dispatch('Permintaan Pengusulan Barang Ditolak');

                    $create = Notification::create([
                        'sender_id' => $user->id,
                        'sender' => 'admins',
                        'receiver_id' => $result[0]->pic_id,
                        'receiver' => 'person_in_charge',
                        'message' => 'Permintaan Pengusulan Barang Ditolak',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                }
            }
        }


        return redirect()->back()->with('success', compact('result', 'indexReqBarang'));
    }

    public function accmt(Request $request, $id)
    {

        $user = Auth::guard('web')->user();

        $indexPengusulan = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 2)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
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
                'admins_id' => $user->id

            ]);

        PeminjamanAset::dispatch('Permintaan Pengusulan Maintenence Asset Diterima');

        $create = Notification::create([
            'sender_id' => $user->id,
            'sender' => 'admins',
            'receiver_id' => $indexPengusulan[0]->pic_id,
            'receiver' => 'person_in_charge',
            'message' => 'Permintaan Pengusulan Maintenence Asset Diterima',
            'object_type_id' => $id,
            'object_type' => 'pengusulan_maintenence'
        ]);

        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang'));
    }

    public function rejectmt(Request $request, $id)
    {
        $user = Auth::guard('web')->user();
        $indexPengusulan = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 2)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id', 'person_in_charge.pic_name'
            ])
            ->orderBy('deskripsi')
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
                'admins_id' => $user->id

            ]);

        // if ($update) {
        //     //berhasil login, kirim notifikasi
        //     $this->sendNotification($user_id);
        //     PeminjamanAset::dispatch('Permintaan Pengusulan Maintenence Asset Ditolak');
        // }

        PeminjamanAset::dispatch('Permintaan Pengusulan Maintenence Asset Ditolak');

        $create = Notification::create([
            'sender_id' => $user->id,
            'sender' => 'admins',
            'receiver_id' => $indexPengusulan[0]->pic_id,
            'receiver' => 'person_in_charge',
            'message' => 'Permintaan Pengusulan Maintenence Asset Ditolak',
            'object_type_id' => $id,
            'object_type' => 'pengusulan_maintenence'
        ]);


        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang'));
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

        $mahasiswa = DB::table('mahasiswa')
            ->where('id', '=', $user_id)
            ->get(
                'mahasiswa.remember_token'
            );

        if (count($mahasiswa) == 0) throw new Error('Mahasiswa Tidak Ada');
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
    "to" : "' . $fcm_token . '",
    "notification":{
        "title" : "Pengusulan Aset",
        "body" : "Pengusulan Asetmu Sudah Di Proses"
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
