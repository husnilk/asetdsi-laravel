<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\PersonInCharge;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StorePersonInChargeRequest;
use App\Http\Requests\UpdatePersonInChargeRequest;

class PersonInChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     $indexPJ = DB::table('person_in_charge')
    //     ->get([
    //         'person_in_charge.pic_id', 'person_in_charge.pic_name', 'person_in_charge.username', 'person_in_charge.password'
    //     ]);

        
    // return view('pages.user.user', compact('indexPJ'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pj = DB::table('person_in_charge')
        ->get(['person_in_charge.pic_id','person_in_charge.pic_name','person_in_charge.email','person_in_charge.username','person_in_charge.password']);

  
    return view('pages.pj.create', compact('pj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePersonInChargeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pj = PersonInCharge::create([
            'pic_name'       => $request->pic_name,
            'email' => $request->email,
            'username'  => $request->username,
            'password'  =>Hash::make($request->password) 
        ]);

      
        return redirect('user')->with('success', 'Penanggung Jawab berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonInCharge  $personInCharge
     * @return \Illuminate\Http\Response
     */
    public function show(PersonInCharge $personInCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PersonInCharge  $personInCharge
     * @return \Illuminate\Http\Response
     */
    public function edit($pic_id)
    {
        $indexPJ = DB::table('person_in_charge')
        ->where('person_in_charge.pic_id', '=', $pic_id)
        ->get(['person_in_charge.pic_id','person_in_charge.pic_name','person_in_charge.email','person_in_charge.username','person_in_charge.password']);
     
    return view('pages.pj.edit', compact('indexPJ'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonInChargeRequest  $request
     * @param  \App\Models\PersonInCharge  $personInCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pic_id)
    {
        $indexPJ = DB::table('person_in_charge')
        ->where('person_in_charge.pic_id', '=', $pic_id)
        ->get(['person_in_charge.pic_id','person_in_charge.pic_name','person_in_charge.email','person_in_charge.username','person_in_charge.password']);
        
        $update = DB::table('person_in_charge')
        ->where('person_in_charge.pic_id', '=', $pic_id)
        ->update([
            'pic_name'       => $request->pic_name,
            'email' => $request->email,
            'username'  => $request->username,
            'password'  =>Hash::make($request->password) 
        ])
        ;
    

    return redirect('user')->with('success', 'PJ berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonInCharge  $personInCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonInCharge $personInCharge)
    {
        //
    }
}
