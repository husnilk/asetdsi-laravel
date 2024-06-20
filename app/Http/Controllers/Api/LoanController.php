<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::guard('pj')->user();
        $indexPeminjaman = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge','person_in_charge.id','=','loan.pic_id')
            ->where('loan.pic_id','=',$user->id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        return view('pages.peminjaman.peminjaman', compact('indexPeminjaman'));
    }

    public function indexBangunan()
    {

        $user = Auth::guard('pj')->user();

        $indexPeminjamanBangunan = DB::table('building_loan_detail')
            ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
            ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->where('person_in_charge.id', '=', $user->id)
            ->select(
                [
                    'mahasiswa.name as nama_mahasiswa',
                    'building.building_name as merk_barang',
                    'building.condition as kondisi', 'building.id as id_bangunan',
                    'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id as lm_id',
                    'building_loan_detail.loan_id as dp_id', 'building_loan_detail.status as statuspj'
                ]
            )
            ->orderBy('nama_mahasiswa')

            ->get();



        return view('pages.peminjaman.peminjamanbangunan', compact('indexPeminjamanBangunan'));
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
     * @param  \App\Http\Requests\StoreLoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::guard('pj')->user();

        $indexPeminjaman = DB::table('loan')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->join('person_in_charge','person_in_charge.id','=','loan.pic_id')
        ->where('loan.id', '=', $id)
        ->where('loan.pic_id','=',$user->id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();

        $indexPeminjamanBangunan = DB::table('building_loan_detail')
        ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
        ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
    
        ->where('building_loan_detail.loan_id', '=', $id)
      
        ->selectRaw(
    
            'count(building.building_name) as jumlah,
            building.building_name as merk_barang,
            building.condition as kondisi,
            building_loan_detail.status as statuspj,
            building_loan_detail.loan_id as loan_id'
        );

        $detailpj = DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id','=','asset_loan_detail.inventory_item_id')
        ->join('loan','loan.id','=','asset_loan_detail.loan_id')
        ->join('inventory','inventory.id','=','inventory_item.inventory_id')
       
        ->where('asset_loan_detail.loan_id', '=', $id)
       
        ->selectRaw(
            'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id as loan_id'
        )
        ->union($indexPeminjamanBangunan)
        ->groupBy('merk_barang','kondisi','statuspj','loan_id')
        ->get();

        $detailpj = collect($detailpj)->filter(function($item) {
            return $item->jumlah > 0;
        });
      
      
        return view('pages.peminjaman.show', compact('indexPeminjaman','detailpj'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {

        //
        
    }

    public function acc(Request $request, $id)
    {
        $indexPeminjaman = DB::table('loan')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->where('loan.id', '=', $id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();

  
        $detailpj = DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id','=','asset_loan_detail.inventory_item_id')
        ->join('loan','loan.id','=','asset_loan_detail.loan_id')
        ->join('inventory','inventory.id','=','inventory_item.inventory_id')
        ->where('asset_loan_detail.loan_id', '=', $id)
        ->selectRaw(
            'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id'
        )
        ->groupBy('merk_barang','kondisi','statuspj','loan_id')
        ->get();

        $update = DB::table('asset_loan_detail')
        ->where('asset_loan_detail.loan_id', '=', $id)
        ->update([
            'status' => 'accepted',
            
        ]);

        return redirect()->back()->with('success',compact('indexPeminjaman','detailpj','update'));
    }

    public function reject(Request $request, $id)
    {
        $indexPeminjaman = DB::table('loan')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->where('loan.id', '=', $id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();

  
        $detailpj = DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id','=','asset_loan_detail.inventory_item_id')
        ->join('loan','loan.id','=','asset_loan_detail.loan_id')
        ->join('inventory','inventory.id','=','inventory_item.inventory_id')
        ->where('asset_loan_detail.loan_id', '=', $id)
        ->selectRaw(
            'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id'
        )
        ->groupBy('merk_barang','kondisi','statuspj','loan_id')
        ->get();

        $update = DB::table('asset_loan_detail')
        ->where('asset_loan_detail.loan_id', '=', $id)
        ->update([
            'status' => 'rejected',
            
        ]);

        return redirect()->back()->with('success',compact('indexPeminjaman','detailpj','update'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanRequest  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
