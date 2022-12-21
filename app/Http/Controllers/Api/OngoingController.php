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
use App\Models\RequestMaintenenceAsset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LDAP\Result;

class OngoingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = auth('sanctum')->user()->id;

        // $user = Mahasiswa::where('id',$user_id)->first();

        $indexPeminjamanBarang = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->join('asset_loan_detail', 'asset_loan_detail.loan_id', '=', 'loan.id')
            ->where('type_id', '=', 1)
            ->where('loan.status', '=', "waiting")
            ->where('loan.mahasiswa_id', '=', $user_id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id', 'loan.type_id', 'loan.status as status','loan.loan_time_end as waktu_akhir'
            ]);


        $indexPeminjamanBangunan = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->join('building_loan_detail', 'building_loan_detail.loan_id', '=', 'loan.id')
            ->where('type_id', '=', 2)
            ->where('loan.status', '=', "waiting")
            ->where('loan.mahasiswa_id', '=', $user_id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id', 'loan.type_id', 'loan.status as status','loan.loan_time_end as waktu_akhir'
            ])
            ->union($indexPeminjamanBarang)
            ->orderBy('nama_mahasiswa')
            ->get();

        $response = new \stdClass();
        $response->indexPeminjamanBangunan = $indexPeminjamanBangunan;
        return response()->json([
            'data' => $indexPeminjamanBangunan,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function indexPengusulan()
    {

        $user_id = auth('sanctum')->user()->id;

        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('proposal_type', 'proposal_type.id', '=', 'proposal.type_id')
            ->where('proposal.mahasiswa_id', '=', $user_id)
            ->where('proposal.status', '=', "waiting")
            ->where('proposal.status_confirm_faculty','=','waiting')
            ->where('type_id', '=', 1)
            ->select([
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr',
                'proposal.id', 'proposal.type_id','proposal.status_confirm_faculty'
            ])

            ->orderBy('deskripsi')
            ->get();

        $response = new \stdClass();
        $response->indexPengusulanmt = $indexPengusulan;
        return response()->json([
            'data' => $indexPengusulan,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function show($id)
    {
        $loan = Loan::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;

        // $indexPeminjamanBangunan = DB::select(
        //     "SELECT count(building.building_name) as jumlah,
        //     asset.asset_name as nama_aset,
        //     building.building_name as merk_barang,
        //     building.condition as kondisi,
        //     building_loan_detail.loan_id as loan_id,
        //     mahasiswa.name as nama_mahasiswa,
        //     loan.loan_date as tanggal, 
        //     loan.loan_description as deskripsi, 
        //     loan.loan_time as waktu,
        //     loan.mahasiswa_id,
        //     loan.status as statuspj,
        //     loan.type_id as type_id,
        //     loan.id from loan
        //     join mahasiswa on mahasiswa.id=loan.mahasiswa_id 
        //     join person_in_charge on person_in_charge.id=loan.pic_id
        //     join loan_type on loan_type.id=loan.type_id
        //     join building_loan_detail on building_loan_detail.loan_id=loan.id
        //     join building on building.id=building_loan_detail.building_id
        //     join asset on asset.id=building.asset_id
        //     where loan.id=$id and loan.mahasiswa_id=$user_id and  loan.type_id=2
        //     UNION
        //     SELECT count(inventory.inventory_brand) as jumlah,
        //     asset.asset_name as nama_aset,
        //     inventory.inventory_brand as merk_barang,
        //     inventory_item.condition as kondisi,
        //     asset_loan_detail.loan_id as loan_id,
        //     mahasiswa.name as nama_mahasiswa,
        //     loan.loan_date as tanggal, 
        //     loan.loan_description as deskripsi, 
        //     loan.loan_time as waktu,
        //     loan.mahasiswa_id,
        //     loan.status as statuspj,
        //     loan.type_id as type_id,
        //     loan.id from loan
        //     join mahasiswa on mahasiswa.id=loan.mahasiswa_id 
        //     join person_in_charge on person_in_charge.id=loan.pic_id
        //     join loan_type on loan_type.id=loan.type_id
        //     join asset_loan_detail on asset_loan_detail.loan_id=loan.id
        //     join inventory_item on inventory_item.id=asset_loan_detail.inventory_item_id
        //     join inventory on inventory.id=inventory_item.inventory_id
        //     join asset on asset.id=inventory.asset_id
        //     where loan.id=$id and loan.mahasiswa_id=$user_id and loan.type_id=1"
        // );

        $indexPeminjaman = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->where('loan.id', '=', $id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id', 'loan.status as statuspj','loan.loan_time_end as waktu_akhir'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->where('loan.type_id', '=', 1)
            ->where('loan.mahasiswa_id', '=', $user_id)
            ->selectRaw(
                'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            inventory_item.available,
            asset_loan_detail.loan_id as loan_id,
            asset.asset_name as nama_aset,
            loan.loan_date as tanggal, loan.loan_description as deskripsi, loan.loan_time as waktu, loan.mahasiswa_id,
            loan.id, loan.status as statuspj,loan.loan_time_end as waktu_akhir'

            )->orderBy('nama_aset')
            ->groupBy('merk_barang', 'kondisi', 'loan_id');

            
        $indexPeminjamanBangunan = DB::table('building_loan_detail')
            ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
            ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
            ->join('asset', 'asset.id', '=', 'building.asset_id')
            ->where('building_loan_detail.loan_id', '=', $id)
            ->where('loan.type_id', '=', 2)
            ->where('loan.mahasiswa_id', '=', $user_id)

            ->selectRaw(

                'count(building.building_name) as jumlah,
            building.building_name as merk_barang,
            building.condition as kondisi,
            building.available,
            building_loan_detail.loan_id as loan_id,
            asset.asset_name as nama_aset,
            loan.loan_date as tanggal, loan.loan_description as deskripsi, loan.loan_time as waktu, loan.mahasiswa_id,
            loan.id, loan.status as statuspj,loan.loan_time_end as waktu_akhir'
            )
            ->orderBy('nama_aset')
            ->groupBy('merk_barang', 'kondisi', 'loan_id')
            ->union($detailpj)
            ->get();

        $indexPeminjamanBangunan = collect($indexPeminjamanBangunan)->filter(function ($item) {
            return $item->jumlah > 0;
        });

        $response = new \stdClass();
        // $response->indexPeminjamanBangunan = $indexPeminjamanBangunan;
        $pem = (array_values($indexPeminjamanBangunan->toArray()));
        return response()->json([
            'data' => $pem,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function showpengusulan($id)
    {
        $proposal = Proposal::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;

        $indexPengusulan = DB::select(
            "SELECT DISTINCT  mahasiswa.name as nama_mahasiswa,proposal.proposal_description as deskripsi, 
        proposal.status as statuspr, proposal.mahasiswa_id,proposal.id,request_proposal_asset.asset_name, 
        request_proposal_asset.spesification_detail, request_proposal_asset.amount, request_proposal_asset.unit_price, 
        request_proposal_asset.source_shop, request_proposal_asset.proposal_id ,request_proposal_asset.status_pr,
        request_proposal_asset.status_confirm_faculty
        from proposal 
        join mahasiswa on mahasiswa.id = proposal.mahasiswa_id 
        JOIN proposal_type on proposal_type.id = proposal.type_id 
        JOIN request_proposal_asset on request_proposal_asset.proposal_id = proposal.id 
        WHERE type_id=1 and proposal.id=$id and proposal.mahasiswa_id=$user_id and proposal.status='waiting'"

        );

        $response = new \stdClass();
        $response->indexPengusulan = $indexPengusulan;
        return response()->json([
            'data' => $indexPengusulan,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function showpengusulanmt($id)
    {
        $proposal = Proposal::where('id', $id)->get();
        $user_id = auth('sanctum')->user()->id;



        $indexProposalMaintenence = DB::select(
            "SELECT DISTINCT  mahasiswa.name as nama_mahasiswa,proposal.proposal_description as deskripsi, proposal.status as statuspr, 
                    proposal.mahasiswa_id,proposal.id,request_maintenence_asset.problem_description, request_maintenence_asset.proposal_id, 
                    request_maintenence_asset.inventory_item_id,inventory_item.condition,
                    inventory_item.item_code,inventory.inventory_brand,request_maintenence_asset.id as id_req_maintenence
                    from proposal join mahasiswa on mahasiswa.id = proposal.mahasiswa_id 
                    JOIN person_in_charge on person_in_charge.id = proposal.pic_id 
                    JOIN proposal_type on proposal_type.id = proposal.type_id 
                    JOIN request_maintenence_asset on request_maintenence_asset.proposal_id = proposal.id 
                    join inventory_item on inventory_item.id=request_maintenence_asset.inventory_item_id 
                    JOIN inventory on inventory.id=inventory_item.inventory_id
                    WHERE type_id=2 and proposal.id=$id and proposal.mahasiswa_id=$user_id and proposal.status='waiting'"
        );


        // if(count($indexProposalMaintenence) > 0){
        //     $proposalmap = collect($indexProposalMaintenence)->map(function($item){
        //         $photos = DB::select("SELECT photos.photo_name, photos.req_maintenence_id from photos
        //         where photos.req_maintenence_id = $item->id_req_maintenence");

        //         $item->photos = $photos;
        //         return $item;
        //     });

        //     $indexProposalMaintenence =  $proposalmap;
        // }


        $response = new \stdClass();
        $response->indexProposalMaintenence = $indexProposalMaintenence;

        return response()->json([
            'data' => $indexProposalMaintenence,
            'success' => true,
            'message' => 'Success',
        ]);
    }

    public function showbukti($id)
    {
        $request_maintenence_asset = RequestMaintenenceAsset::where('id', $id)->get();
        // $user_id = auth('sanctum')->user()->id;

        $indexProposalMaintenence = DB::select(
            "SELECT photos.photo_name, photos.req_maintenence_id
                    from photos 
                    JOIN request_maintenence_asset on request_maintenence_asset.id = photos.req_maintenence_id 
                    WHERE photos.req_maintenence_id=$id"
        );

        $response = new \stdClass();
        $response->indexProposalMaintenence = $indexProposalMaintenence;
        return response()->json([
            'data' => $indexProposalMaintenence,
            'success' => true,
            'message' => 'Success',
        ]);
    }
}
