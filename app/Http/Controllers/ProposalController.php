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
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name', 'proposal.created_at as tanggal','proposal.status_confirm_faculty'
            ])
            ->orderBy('tanggal', 'DESC')
            ->get();

        $indexPengusulanMhs = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id', 'proposal.created_at as tanggal','proposal.status_confirm_faculty'
            ])
            ->orderBy('tanggal', 'DESC')
            ->get();

        $result = array_merge($indexPengusulanPic->toArray(), $indexPengusulanMhs->toArray());
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        usort($result, function ($a, $b) {
            return strcmp($b->tanggal, $a->tanggal);
        });



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
                'proposal.id', 'proposal.created_at as tanggal'
            ])
            ->orderBy('tanggal', 'DESC')
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
                'proposal.admins_id', 'proposal.pic_id', 'proposal.type_id','proposal.status_confirm_faculty'
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
                'proposal.id', 'person_in_charge.pic_name','proposal.status_confirm_faculty'
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
                'proposal.id','proposal.status_confirm_faculty'
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr',
                'request_proposal_asset.status_confirm_faculty'
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
            ->join('asset','asset.id','=','inventory.asset_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.inventory_item_id as item_id',
                'asset.asset_name',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();

        $indexBangunan = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('building', 'building.id', '=', 'request_maintenence_asset.building_id')
            ->join('asset','asset.id','=','building.asset_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.building_id as item_id',
                'asset.asset_name',
                'building.building_name as merk_barang', 'building.building_code as kode_barang',
                'building.id as item_id', 'building.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();


        $result = array_merge($indexReqBarang->toArray(), $indexBangunan->toArray());
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));


        $photos = [];

        foreach ($result as $data) {

            $photoShow = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $data->id)
                ->select([
                    'photos.photo_name', 'photos.req_maintenence_id'
                ])
                ->get();

            array_push($photos, $photoShow);
        }




        return view('pages.pengusulan.showmt', compact('indexReqBarang', 'indexPengusulan', 'photos', 'result'));
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
                'proposal.id', 'person_in_charge.pic_name','proposal.status_confirm_faculty'
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
                'proposal.id','proposal.status_confirm_faculty'
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr',
                'request_proposal_asset.status_confirm_faculty'
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr'
            ])
            ->orderBy('asset_name')
            ->get();


        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status' => 'rejected',
                'admins_id' => $user->id

            ]);

        $update2 = DB::table('request_proposal_asset')
            ->where('request_proposal_asset.proposal_id', '=', $id)
            ->update([
                'status_pr' => 'rejected',
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
                } else {
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

    public function accfakultas(Request $request, $id)
    {

        $user = Auth::guard('web')->user();

        $indexPengusulanPic = DB::table('proposal')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'proposal.pic_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('type_id', '=', 1)
            ->where('proposal.id', '=', $id)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.pic_id',
                'proposal.id', 'person_in_charge.pic_name','proposal.status_confirm_faculty'
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
                'proposal.id','proposal.status_confirm_faculty'
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr',
                'request_proposal_asset.status_confirm_faculty'
            ])
            ->orderBy('asset_name')
            ->get();

        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status_confirm_faculty' => 'accepted'

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
                        'message' => 'Permintaan Pengusulan Barang Diterima Oleh Fakultas',
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
                        'message' => 'Permintaan Pengusulan Barang Diterima Oleh Fakultas',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                }
            }
           
        }

        return redirect()->back()->with('success', compact('result', 'indexReqBarang'));
    }


    public function rejectfakultas(Request $request, $id)
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr'
            ])
            ->orderBy('asset_name')
            ->get();


        $update = DB::table('proposal')
            ->where('proposal.id', '=', $id)
            ->update([
                'status_confirm_faculty' => 'rejected'

            ]);

        $update2 = DB::table('request_proposal_asset')
            ->where('request_proposal_asset.proposal_id', '=', $id)
            ->update([
                'status_confirm_faculty' => 'rejected'
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
                        'message' => 'Permintaan Pengusulan Barang Ditolak Oleh Fakultas',
                        'object_type_id' => $id,
                        'object_type' => 'pengusulan_barang'
                    ]);
                } else {
                    PeminjamanAset::dispatch('Permintaan Pengusulan Barang Ditolak');

                    $create = Notification::create([
                        'sender_id' => $user->id,
                        'sender' => 'admins',
                        'receiver_id' => $result[0]->pic_id,
                        'receiver' => 'person_in_charge',
                        'message' => 'Permintaan Pengusulan Barang Ditolak Oleh Fakultas',
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
                'request_maintenence_asset.inventory_item_id as item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();

        $indexBangunan = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('building', 'building.id', '=', 'request_maintenence_asset.building_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.building_id as item_id',
                'building.building_name as merk_barang', 'building.building_code as kode_barang',
                'building.id as item_id', 'building.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();


        $result = array_merge($indexReqBarang->toArray(), $indexBangunan->toArray());
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        if (count($result) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $result[0]->id)
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
                'request_maintenence_asset.inventory_item_id as item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();

        $indexBangunan = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('building', 'building.id', '=', 'request_maintenence_asset.building_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.building_id as item_id',
                'building.building_name as merk_barang', 'building.building_code as kode_barang',
                'building.id as item_id', 'building.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();


        $result = array_merge($indexReqBarang->toArray(), $indexBangunan->toArray());
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        if (count($result) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $result[0]->id)
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

        $update2 = DB::table('request_maintenence_asset')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->update([
                'status_mt' => 'rejected',
            ]);

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

    public function update(Request $request, $id)
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
                'request_proposal_asset.proposal_id',
                'request_proposal_asset.id',
                'request_proposal_asset.status_pr'
            ])
            ->orderBy('asset_name')
            ->get();


        $update = DB::table('request_proposal_asset')
            ->where('request_proposal_asset.id', '=', $id)
            ->update([
                'status_pr' => $request->status_pr,
                'status_confirm_faculty' =>$request->status_confirm_faculty
            ]);

        return redirect()->back()->with('success', 'Status berhasil dikonfirmasi!');
    }

    public function updatemt(Request $request, $id)
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
                'request_maintenence_asset.inventory_item_id as item_id',
                'inventory.inventory_brand as merk_barang', 'inventory_item.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();

        $indexBangunan = DB::table('request_maintenence_asset')
            ->join('proposal', 'proposal.id', '=', 'request_maintenence_asset.proposal_id')
            ->join('building', 'building.id', '=', 'request_maintenence_asset.building_id')
            ->where('request_maintenence_asset.proposal_id', '=', $id)
            ->select([
                'request_maintenence_asset.problem_description',
                'request_maintenence_asset.proposal_id',
                'request_maintenence_asset.building_id as item_id',
                'building.building_name as merk_barang', 'building.building_code as kode_barang',
                'building.id as item_id', 'building.condition as kondisi',
                'request_maintenence_asset.id as id', 'request_maintenence_asset.status_mt'
            ])->get();


        $result = array_merge($indexReqBarang->toArray(), $indexBangunan->toArray());
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));

        if (count($result) == 1) {
            $photos = DB::table('photos')
                ->join('request_maintenence_asset', 'request_maintenence_asset.id', '=', 'photos.req_maintenence_id')
                ->where('photos.req_maintenence_id', '=', $result[0]->id)
                ->select([
                    'photos.photo_name'
                ])
                ->get();
        }


        $update = DB::table('request_maintenence_asset')
            ->where('request_maintenence_asset.id', '=', $id)
            ->update([
                'status_mt' => $request->status_mt,
            ]);

        return redirect()->back()->with('success', 'Status berhasil dikonfirmasi!');
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
