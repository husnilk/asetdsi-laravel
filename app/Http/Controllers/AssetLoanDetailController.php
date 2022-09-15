<?php

namespace App\Http\Controllers;

use App\Models\AssetLoanDetail;
use App\Http\Requests\StoreAssetLoanDetailRequest;
use App\Http\Requests\UpdateAssetLoanDetailRequest;

class AssetLoanDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreAssetLoanDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetLoanDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetLoanDetail  $assetLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AssetLoanDetail $assetLoanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetLoanDetail  $assetLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetLoanDetail $assetLoanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssetLoanDetailRequest  $request
     * @param  \App\Models\AssetLoanDetail  $assetLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetLoanDetailRequest $request, AssetLoanDetail $assetLoanDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetLoanDetail  $assetLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetLoanDetail $assetLoanDetail)
    {
        //
    }
}
