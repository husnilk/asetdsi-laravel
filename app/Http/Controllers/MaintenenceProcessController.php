<?php

namespace App\Http\Controllers;

use App\Models\MaintenenceProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenenceProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::guard('pj')->user();
        // $indexReturn = DB::table('Returns')
        //     ->join('loan', 'loan.id', '=', 'returns.loan_id')
        //     ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
        //     ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        //     ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
        //     ->where('loan.pic_id', '=', $user->id)
        //     ->where('type_id', '=', 1)
        //     ->where('loan.status', '=', "accepted")
        //     ->select([
        //         'mahasiswa.name as nama_mahasiswa',
        //         'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
        //         'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
        //         ,'returns.id'
        //     ])
        //     ->orderBy('nama_mahasiswa')
        //     ->get();

        // return view('pages.returnaset.returnaset', compact('indexReturn'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaintenenceProcess  $MaintenenceProcess
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenenceProcess $MaintenenceProcess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaintenenceProcess  $MaintenenceProcess
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenenceProcess $MaintenenceProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaintenenceProcess  $MaintenenceProcess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenenceProcess $MaintenenceProcess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaintenenceProcess  $MaintenenceProcess
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenenceProcess $MaintenenceProcess)
    {
        //
    }
}
