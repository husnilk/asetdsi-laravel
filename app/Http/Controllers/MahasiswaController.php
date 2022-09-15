<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexMahasiswa = DB::table('mahasiswa')
        ->get([
            'mahasiswa.mahasiswa_id','mahasiswa.nim', 'mahasiswa.name','mahasiswa.email','mahasiswa.username','mahasiswa.password'
        ]);

        return view('pages.user.user', compact('indexMahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mahasiswa = DB::table('mahasiswa')
        ->get([
            'mahasiswa.mahasiswa_id','mahasiswa.nim', 'mahasiswa.name','mahasiswa.email','mahasiswa.username','mahasiswa.password'
        ]);

  
    return view('pages.mahasiswa.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMahasiswaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'name'       => $request->name,
            'email'  => $request->email,
            'username'  => $request->username,
            'password'  =>Hash::make($request->password) 
        ]);

      
        return redirect('user')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($mahasiswa_id)
    {
        $indexMahasiswa = DB::table('mahasiswa')
        ->where('mahasiswa.mahasiswa_id', '=', $mahasiswa_id)
        ->get([
            'mahasiswa.mahasiswa_id','mahasiswa.nim', 'mahasiswa.name','mahasiswa.email','mahasiswa.username','mahasiswa.password'
        ]);
     
     
    return view('pages.mahasiswa.edit', compact('indexMahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMahasiswaRequest  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mahasiswa_id)
    {
        $indexMahasiswa = DB::table('mahasiswa')
        ->where('mahasiswa.mahasiswa_id', '=', $mahasiswa_id)
        ->get([
            'mahasiswa.mahasiswa_id','mahasiswa.nim', 'mahasiswa.name','mahasiswa.email','mahasiswa.username','mahasiswa.password'
        ]);
  
        $update = DB::table('mahasiswa')
        ->where('mahasiswa.mahasiswa_id', '=', $mahasiswa_id)
        ->update([
            'nim' => $request->nim,
            'name'   => $request->name,
            'email'  => $request->email,
            'username'  => $request->username
        ])
        ;
    

    return redirect('user')->with('success', 'Mahasiswa berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($mahasiswa_id)
    {
        $mahasiswa = Mahasiswa::find($mahasiswa_id);
        $mahasiswa->delete();
      
        return redirect('user')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
