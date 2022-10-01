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
            ->join('person_in_charge','person_in_charge.id','=','proposal.pic_id')
            ->where('proposal.pic_id','=',$user->id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'proposal.proposal_description as deskripsi', 'proposal.status as statuspr', 'proposal.mahasiswa_id',
                'proposal.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        return view('pages.pengusulan.pengusulan', compact('indexPengusulan'));
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
    public function show(Request $request, $id)
    {
        $user = Auth::guard('pj')->user();

        $indexPengusulan = DB::table('proposal')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'proposal.mahasiswa_id')
            ->join('person_in_charge','person_in_charge.id','=','proposal.pic_id')
            ->where('proposal.pic_id','=',$user->id)
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

      
        return view('pages.pengusulan.show', compact('indexReqBarang','indexPengusulan'));
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
}
