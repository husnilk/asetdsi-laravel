<?php

namespace App\Http\Controllers;

use App\Models\BuildingLoanDetail;
use App\Http\Requests\StoreBuildingLoanDetailRequest;
use App\Http\Requests\UpdateBuildingLoanDetailRequest;

class BuildingLoanDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreBuildingLoanDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuildingLoanDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuildingLoanDetail  $buildingLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingLoanDetail $buildingLoanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildingLoanDetail  $buildingLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingLoanDetail $buildingLoanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBuildingLoanDetailRequest  $request
     * @param  \App\Models\BuildingLoanDetail  $buildingLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBuildingLoanDetailRequest $request, BuildingLoanDetail $buildingLoanDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildingLoanDetail  $buildingLoanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildingLoanDetail $buildingLoanDetail)
    {
        //
    }
}
