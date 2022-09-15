<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\PersonInCharge;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreadminRequest;
use App\Http\Requests\UpdateadminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $indexAdmin = DB::table('admins')
        ->get([
            'admins.id','admins.nip','admins.name','admins.email','admins.phone_number','admins.username','admins.password'
        ]);

        $indexPJ = DB::table('person_in_charge')
        ->get([
            'person_in_charge.pic_id', 'person_in_charge.pic_name','person_in_charge.email', 'person_in_charge.username', 'person_in_charge.password'
        ]);

        $indexMahasiswa = DB::table('mahasiswa')
        ->get([
            'mahasiswa.mahasiswa_id','mahasiswa.nim', 'mahasiswa.name','mahasiswa.email','mahasiswa.username','mahasiswa.password'
        ]);


    return view('pages.user.user', compact('indexAdmin','indexPJ','indexMahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = DB::table('admins')
        ->get(['admins.id','admins.nip','admins.name','admins.email','admins.phone_number','admins.username','admins.password']);

  
    return view('pages.user.create', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreadminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = admin::create([
            'nip' => $request->nip,
            'name'       => $request->name,
            'email'  => $request->email,
            'phone_number'  => $request->phone_number,
            'username'  => $request->username,
            'password'  =>Hash::make($request->password) 
        ]);

      
        return redirect('user')->with('success', 'Admin berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indexAdmin = DB::table('admins')
        ->where('admins.id', '=', $id)
        ->get([
            'admins.id','admins.nip','admins.name','admins.email','admins.phone_number','admins.username','admins.password'
        ]);
     
    return view('pages.user.edit', compact('indexAdmin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateadminRequest  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $indexAdmin = DB::table('admins')
        ->where('admins.id', '=', $id)
        ->get([
            'admins.id','admins.nip','admins.name','admins.email','admins.phone_number','admins.username','admins.password'
        ]);

        
        $update = DB::table('admins')
        ->where('admins.id', '=', $id)
        ->update([
            'nip' => $request->nip,
            'name'       => $request->name,
            'email'  => $request->email,
            'phone_number'  => $request->phone_number,
            'username'  => $request->username,
        ])
        ;
    

    return redirect('user')->with('success', 'Admin berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = admin::find($id);
        $admin->delete();
      
        return redirect('user')->with('success', 'Admin berhasil dihapus');
    }




}
