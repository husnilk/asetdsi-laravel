<?php

namespace App\Http\Controllers;

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
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->where('loan.pic_id', '=', $user->id)
            ->where('type_id', '=', 1)
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

        $indexPeminjamanBangunan = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->where('loan.pic_id', '=', $user->id)
            ->where('type_id', '=', 2)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id'
            ])
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
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->where('loan.id', '=', $id)
            ->where('loan.pic_id', '=', $user->id)
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')

            ->where('asset_loan_detail.loan_id', '=', $id)

            ->selectRaw(
                'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory.id as inventory_id,
            inventory_item.condition as kondisi,
            inventory_item.item_code as kode,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id as loan_id'
            )
            ->orderBy('merk_barang')
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id','kode')
            ->get();

        // $detailpj = collect($detailpj)->filter(function ($item) {
        //     return $item->jumlah > 0;
        // });

        $newItems = collect($detailpj);

        $indexItem = $newItems->map(function ($item, $index)  use ($newItems) {
            $filterItem = $newItems->filter(function ($itemFIlter) use ($item) {
                return $itemFIlter->inventory_id ===  $item->inventory_id;
            });
            // dd($newItems[0]->nama_aset);
            $item->jumlah = count($filterItem);
            if ($index == 0) {
                $item->indexPosition = 'start';
            } else if ($newItems[$index - 1]->merk_barang != $item->merk_barang) {
                $item->indexPosition = 'start';
            }
            // else if ($newItems[$index - 1]->merk_barang == $item->merk_barang) {
            //     $item->indexPosition = 'middle';
            // }
             else if (count($newItems) - 1 === $index) {
                $item->indexPosition = 'end';
            } else if ($newItems[$index + 1]->merk_barang != $item->merk_barang) {
                $item->indexPosition = 'end';
            } else {
                $item->indexPosition = 'middle';
            }
            // $item->indexPosition = 
            return $item;
        });

        // dd($indexItem);

        return view('pages.peminjaman.show', compact('indexPeminjaman', 'indexItem'));
    }

    public function showbg($id)
    {
        $user = Auth::guard('pj')->user();

        $indexPeminjaman = DB::table('loan')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->where('loan.id', '=', $id)
            ->where('loan.pic_id', '=', $user->id)
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
            )
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id')
            ->get();




        $indexPeminjamanBangunan = collect($indexPeminjamanBangunan)->filter(function ($item) {
            return $item->jumlah > 0;
        });


        return view('pages.peminjaman.showbg', compact('indexPeminjaman', 'indexPeminjamanBangunan'));
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
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->selectRaw(
                'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id'
            )
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id')
            ->get();

        $update = DB::table('asset_loan_detail')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->update([
                'status' => 'accepted',

            ]);

        return redirect()->back()->with('success', compact('indexPeminjaman', 'detailpj', 'update'));
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
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->selectRaw(
                'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory_item.condition as kondisi,
            asset_loan_detail.status as statuspj,
            asset_loan_detail.loan_id'
            )
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id')
            ->get();

        $update = DB::table('asset_loan_detail')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

        return redirect()->back()->with('success', compact('indexPeminjaman', 'detailpj', 'update'));
    }

    public function accbg(Request $request, $id)
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
            )
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id')
            ->get();


        $update = DB::table('building_loan_detail')
            ->where('building_loan_detail.loan_id', '=', $id)
            ->update([
                'status' => 'accepted',

            ]);

        return redirect()->back()->with('success', compact('indexPeminjaman', 'indexPeminjamanBangunan', 'update'));
    }

    public function rejectbg(Request $request, $id)
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
            )
            ->groupBy('merk_barang', 'kondisi', 'statuspj', 'loan_id')
            ->get();

        $update = DB::table('building_loan_detail')
            ->where('building_loan_detail.loan_id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

        return redirect()->back()->with('success', compact('indexPeminjaman', 'indexPeminjamanBangunan', 'update'));
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
