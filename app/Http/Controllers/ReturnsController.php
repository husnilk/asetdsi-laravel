<?php

namespace App\Http\Controllers;

use App\Models\Returns;
use App\Http\Requests\StoreReturnsRequest;
use App\Http\Requests\UpdateReturnsRequest;

class ReturnsController extends Controller
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
     * @param  \App\Http\Requests\StoreReturnsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReturnsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Returns  $returns
     * @return \Illuminate\Http\Response
     */
    public function show(Returns $returns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Returns  $returns
     * @return \Illuminate\Http\Response
     */
    public function edit(Returns $returns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReturnsRequest  $request
     * @param  \App\Models\Returns  $returns
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReturnsRequest $request, Returns $returns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Returns  $returns
     * @return \Illuminate\Http\Response
     */
    public function destroy(Returns $returns)
    {
        //
    }
}
