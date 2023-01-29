<?php

namespace App\Http\Controllers;

use App\Models\RejectedProposal;
use App\Http\Requests\StoreRejectedProposalRequest;
use App\Http\Requests\UpdateRejectedProposalRequest;

class RejectedProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreRejectedProposalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRejectedProposalRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RejectedProposal  $rejectedProposal
     * @return \Illuminate\Http\Response
     */
    public function show(RejectedProposal $rejectedProposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RejectedProposal  $rejectedProposal
     * @return \Illuminate\Http\Response
     */
    public function edit(RejectedProposal $rejectedProposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRejectedProposalRequest  $request
     * @param  \App\Models\RejectedProposal  $rejectedProposal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRejectedProposalRequest $request, RejectedProposal $rejectedProposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RejectedProposal  $rejectedProposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(RejectedProposal $rejectedProposal)
    {
        //
    }
}
