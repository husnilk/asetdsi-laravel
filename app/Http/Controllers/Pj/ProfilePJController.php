<?php

namespace App\Http\Controllers\PJ;

use App\Http\Controllers\Controller;
use App\Models\PersonInCharge;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreadminRequest;
use App\Http\Requests\UpdateadminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfilePJController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('pj')->user();
        $indexPJ = DB::table('person_in_charge')
        ->where('person_in_charge.id','=', $user->id)
        ->get([
            'person_in_charge.id', 'person_in_charge.pic_name', 'person_in_charge.email', 'person_in_charge.username', 'person_in_charge.password'
        ]);

      
    return view('pages.p_j.profile.profile', compact('indexPJ'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //     $admin = DB::table('admins')
    //     ->get(['admins.id','admins.nip','admins.name','admins.email','admins.phone_number','admins.username','admins.password']);

  
    // return view('pages.user.create', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreadminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $admin = admin::create([
        //     'nip' => $request->nip,
        //     'name'       => $request->name,
        //     'email'  => $request->email,
        //     'phone_number'  => $request->phone_number,
        //     'username'  => $request->username,
        //     'password'  =>Hash::make($request->password) 
        // ]);

      
        // return redirect('user')->with('success', 'Admin berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(PersonInCharge $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

        $user = Auth::guard('pj')->user();
        $indexPJ = DB::table('person_in_charge')
        ->where('person_in_charge.id','=', $user->id)
        ->get([
            'person_in_charge.id', 'person_in_charge.pic_name', 'person_in_charge.email', 'person_in_charge.username', 'person_in_charge.password'
        ]);
     
    return view('pages.p_j.profile.edit', compact('indexPJ'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateadminRequest  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::guard('pj')->user();
        $indexPJ = DB::table('person_in_charge')
        ->where('person_in_charge.id','=', $user->id)
        ->get([
            'person_in_charge.id', 'person_in_charge.pic_name', 'person_in_charge.email', 'person_in_charge.username', 'person_in_charge.password'
        ]);

        
        $update = DB::table('person_in_charge')
        ->where('person_in_charge.id','=', $user->id)
        ->update([
            'pic_name'       => $request->pic_name,
            'email'  => $request->email,
            'username'  => $request->username,
        ])
        ;
    

    return redirect('pj-aset/profile')->with('success', 'PJ berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    
}
