<?php

namespace App\Http\Controllers\Pj;

use App\Events\PengusulanAset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Notification;
use App\Models\PersonInCharge;
use App\Models\Photos;
use App\Models\RequestMaintenenceAsset;
use App\Models\RequestProposalAsset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProposalPJController extends Controller
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
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')

            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('type_id', '=', 1)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr',
                'proposal.id'
            ])

            ->orderBy('deskripsi')
            ->get();

         
        return view('pages.p_j.pengusulan.pengusulan', compact('indexPengusulan'));
    }

    public function indexmt()
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('type_id', '=', 2)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
            ->get();

        return view('pages.p_j.pengusulan.pengusulanmt', compact('indexPengusulan'));
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

    public function createmt()
    {

        $user = Auth::guard('pj')->user();
        $proposal = DB::table('proposal')
            ->get([
                'proposal.proposal_description', 'proposal.status', 'proposal.id',
                'proposal.admins_id', 'proposal.pic_id', 'proposal.type_id'
            ]);

        $request_maintenence_asset = DB::table('request_maintenence_asset')
            ->get(['id', 'problem_description', 'proposal_id', 'inventory_item_id']);

        $inventory_item = DB::table('inventory_item')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset_location', 'asset_location.id', '=', 'inventory_item.location_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'inventory_item.pic_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory_item.pic_id', '=', $user->id)
            ->where('inventory_item.condition','=','buruk')
            ->where('inventory_item.available','=','not-available')
            ->orderBy('pic_name')
            ->get([
                'inventory.inventory_brand', 'inventory.id', 'inventory.asset_id', 'inventory.photo',
                'inventory_item.item_code', 'inventory_item.condition', 'inventory_item.available', 'inventory_item.id as item_id',
                'inventory_item.location_id', 'inventory_item.pic_id', 'person_in_charge.pic_name',
                'person_in_charge.id', 'asset_location.id', 'asset_location.location_name', 'asset.id', 'asset.asset_name'
            ]);

      
        $photos = DB::table('photos')
            ->get(['id', 'photo_name', 'req_maintenence_id']);

        return view('pages.p_j.pengusulan.createmt', compact('proposal', 'request_maintenence_asset', 'photos','inventory_item'));
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
        // event(new PengusulanAset($user->pic_name ));

        PengusulanAset::dispatch($user->pic_name . ' Melakukan Pengusulan Barang');
        $create = Notification::create([
            'sender_id' => $user->id,
            'sender' => 'person_in_charge',
            'receiver_id' => null,
            'receiver' => 'admins',
            'message' => $user->pic_name . ' Melakukan Pengusulan Barang',
            'object_type_id' =>$proposal->id,
            'object_type' => 'pengusulan_barang'
        ]);
        // $request->session()->flash('notifikasi');
        // notify()->success($user->pic_name . ' Melakukan Pengusulan Barang');
        return redirect('pj-aset/pengusulan')->with('success', 'Pengadaan berhasil ditambahkan');
        
    }

    public function storemt(Request $request)
    {
        // $a = array_map(function ($item) {
        //     return json_decode($item);
        // },$request->imageArray);
        // dd($a);
        
       
        $user = Auth::guard('pj')->user();
        $proposal = Proposal::create([
            'proposal_description' => $request->proposal_description,
            'status'   => "waiting",
            'type_id' => 2,
            'pic_id' => $user->id

        ]);

        $photoNew = $request->photo;
     
        $invItms = array_map(function($itm, $l) use ($request, $photoNew){
            $newArr = [];
            for ($q = 0; $q < $l+1; $q++) {
               

                if (count($photoNew) == intval($request->imageArray[$q])) {
                    $newArr = $photoNew;
                } else {
                    $newArr = array_splice($photoNew, $request->imageArray[$q]);
                    // dd($newArr, $photoNew);
                }
                // dd($newArr,$photoNew);
                $a = $photoNew;
                $photoNew = $newArr;

                //  if($l == 1 && $q == 1) {
                //     dd ($a , intval($request->imageArray[$q]), $photoNew);
                // }
            }

            $nArr = [
                'imgLength' => $request->imageArray[$l],
                'problem_description' => $itm,
                'inventory_item_id' => $request->inventory_item_id[$l],
                'photo' => $a,
            ];



            $l++;
            return $nArr;
        },
        $request->problem_description,
        array_keys($request->problem_description)
    );

    
    
        foreach ($invItms as $data) {
          
            $request_mt = RequestMaintenenceAsset::create(
                [
                    'inventory_item_id' => $data['inventory_item_id'],
                    'problem_description' => $data['problem_description'],
                    'proposal_id' => $proposal->id,
                ]
            );

          
      
            if ($data['photo']) {
            
                foreach ($data['photo'] as $photo) {
                    
                    $file = cloudinary()->upload($photo->getRealPath())->getSecurePath();
    
                Photos::create(
                    [
                        'photo_name' => $file,
                        'req_maintenence_id' => $request_mt->id
                    ]);
    
            }
            }else {
    
                $file = "https://res.cloudinary.com/nishia/image/upload/v1663485047/default-image_yasmsd.jpg";
    
            
                Photos::create(
                    [
                        'photo_name' => $file,
                        'req_maintenence_id' => $request_mt->id
                ]);
            
        }

        }
        
        PengusulanAset::dispatch($user->pic_name . ' Melakukan Pengusulan Maintenence Asset');
        $create = Notification::create([
            'sender_id' => $user->id,
            'sender' => 'person_in_charge',
            'receiver_id' => null,
            'receiver' => 'admins',
            'message' => $user->pic_name . ' Melakukan Pengusulan Maintenence Asset',
            'object_type_id' =>$proposal->id,
            'object_type' => 'pengusulan_maintenence'
        ]);
        return redirect('pj-aset/pengusulan/mt')->with('success', 'Pengadaan berhasil ditambahkan');
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
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('proposal.type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
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

        return view('pages.p_j.pengusulan.show', compact('indexReqBarang', 'indexPengusulan'));
    }

    public function showmt($id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.pic_id', '=', $user->id)
            ->where('proposal.type_id', '=', 2)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id','person_in_charge.pic_name'
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

        foreach($indexReqBarang as $data){
            
                $photoShow = DB::table('photos')
                    ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                    ->where('photos.req_maintenence_id', '=', $data->id)
                    ->select([
                        'photos.photo_name','photos.req_maintenence_id'
                    ])
                    ->get();
           
                    array_push($photos,$photoShow);
        }
      

        return view('pages.p_j.pengusulan.showmt', compact('indexReqBarang', 'indexPengusulan', 'photos'));
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


    public function cancel(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
            // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id'
            ])
            ->orderBy('deskripsi')
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

        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'cancelled',

            ]);

        return redirect()->back()->with('success', compact('indexPengusulan', 'indexReqBarang', 'update'));
    }

    public function cancelmt(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();
        $indexPengusulan = DB::table('proposal')
        // ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
        ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
        ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
        ->where('proposal.id', '=', $id)
        ->select([
            'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
            'proposal.id'
        ])
        ->orderBy('deskripsi')
        ->get();

    // $user_id = $indexPengusulan[0]->mahasiswa_id;

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
            'status' => 'cancelled',

        ]);

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

        $mahasiswa = DB::table('mahasiswa')
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
    "to" : "' . $fcm_token . '",
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
