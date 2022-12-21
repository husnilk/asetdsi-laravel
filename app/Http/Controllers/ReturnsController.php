<?php

namespace App\Http\Controllers;

use App\Models\Returns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('pj')->user();
        $indexReturn = DB::table('Returns')
            ->join('loan', 'loan.id', '=', 'returns.loan_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->where('loan.pic_id', '=', $user->id)
            ->where('type_id', '=', 1)
            ->where('loan.status', '=', "accepted")
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
                ,'returns.id','loan.loan_time_end as waktu_akhir','returns.created_at'
            ])
            ->orderBy('created_at','DESC')
            ->get();

        return view('pages.returnaset.returnaset', compact('indexReturn'));
    }

    public function indexBangunan()
    {
        $user = Auth::guard('pj')->user();
        $indexReturn = DB::table('Returns')
            ->join('loan', 'loan.id', '=', 'returns.loan_id')
            ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
            ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
            ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
            ->where('loan.pic_id', '=', $user->id)
            ->where('type_id', '=', 2)
            ->where('loan.status', '=', "accepted")
            ->select([
                'mahasiswa.name as nama_mahasiswa',
                'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
                'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
                ,'returns.id'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        return view('pages.returnaset.returnasetBangunan', compact('indexReturn'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Returns  $returns
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::guard('pj')->user();


        $indexReturn = DB::table('Returns')
        ->join('loan', 'loan.id', '=', 'returns.loan_id')
        ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
        ->where('returns.id', '=', $id)
        ->where('loan.pic_id', '=', $user->id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
            ,'returns.id','loan.loan_time_end as waktu_akhir'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();

        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->join('return_asset_detail','return_asset_detail.asset_loan_detail_id','=','asset_loan_detail.id')
            ->where('returns.id', '=', $id)
            ->where('asset_loan_detail.status_pj','=','accepted')
            ->selectRaw(
                'count(inventory.inventory_brand) as jumlah,
            inventory.inventory_brand as merk_barang,
            inventory.id as inventory_id,
            inventory_item.condition as kondisi,
            inventory_item.available,
            inventory_item.item_code as kode,
            asset_loan_detail.loan_id as loan_id,
            asset_loan_detail.status_pj,
            asset_loan_detail.id,
            asset.asset_name,
            returns.id as returns_id,
            return_asset_detail.status as status_detail'

            )
            ->orderBy('merk_barang')
            ->groupBy('merk_barang', 'kondisi', 'loan_id', 'kode')
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

    

        return view('pages.returnaset.show',compact('indexReturn', 'indexItem'));
    }

    
    public function back(Request $request, $id)
    {

        $user = Auth::guard('pj')->user();

        $indexReturn = DB::table('Returns')
        ->join('loan', 'loan.id', '=', 'returns.loan_id')
        ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
        ->where('returns.id', '=', $id)
        ->where('loan.pic_id', '=', $user->id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
            ,'returns.id'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();


        $detailpj = DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->where('returns.id', '=', $id)

        ->selectRaw(
            'count(inventory.inventory_brand) as jumlah,
        inventory.inventory_brand as merk_barang,
        inventory.id as inventory_id,
        inventory_item.condition as kondisi,
        inventory_item.available,
        inventory_item.item_code as kode,
        asset_loan_detail.loan_id as loan_id,
        asset.asset_name,
        returns.id as returns_id'

        )
        ->orderBy('merk_barang')
        ->groupBy('merk_barang', 'kondisi', 'loan_id', 'kode')
        ->get();
         
        
            // $updateAvailable =  DB::table('asset_loan_detail')
            // ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            // ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            // ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
            // ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            // ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            // ->where('returns.id', '=', $id)
            // ->where('asset_loan_detail.status_pj','=','accepted')
    
            // ->selectRaw(
            //     'count(inventory.inventory_brand) as jumlah,
            // inventory.inventory_brand as merk_barang,
            // inventory.id as inventory_id,
            // inventory_item.condition as kondisi,
            // inventory_item.available,
            // inventory_item.item_code as kode,
            // asset_loan_detail.loan_id as loan_id,
            // asset.asset_name'
    
            // )
            // ->update([
            //     'inventory_item.available' => 'available',

            // ]);


        $update = DB::table('returns')
            ->where('returns.id', '=', $id)
            ->update([
                'status' => 'dikembalikan',

            ]);

        return redirect()->back()->with('success', compact('indexReturn', 'detailpj', 'update'));
    }

    public function lost(Request $request, $id)
    {

        $user = Auth::guard('pj')->user();

        $indexReturn = DB::table('Returns')
        ->join('loan', 'loan.id', '=', 'returns.loan_id')
        ->join('person_in_charge', 'person_in_charge.id', '=', 'loan.pic_id')
        ->join('mahasiswa', 'mahasiswa.id', '=', 'loan.mahasiswa_id')
        ->join('loan_type', 'loan_type.id', '=', 'loan.type_id')
        ->where('returns.id', '=', $id)
        ->where('loan.pic_id', '=', $user->id)
        ->select([
            'mahasiswa.name as nama_mahasiswa',
            'loan.loan_date as tanggal', 'loan.loan_description as deskripsi', 'loan.loan_time as waktu', 'loan.mahasiswa_id',
            'loan.id as loan_id', 'loan.status as statuspj','loan_type.type_name','loan_type.type_name','returns.status as status_return'
            ,'returns.id'
        ])
        ->orderBy('nama_mahasiswa')
        ->get();


        $detailpj = DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->where('returns.id', '=', $id)

        ->selectRaw(
            'count(inventory.inventory_brand) as jumlah,
        inventory.inventory_brand as merk_barang,
        inventory.id as inventory_id,
        inventory_item.condition as kondisi,
        inventory_item.available,
        inventory_item.item_code as kode,
        asset_loan_detail.loan_id as loan_id,
        asset.asset_name,
        returns.id as returns_id'

        )
        ->orderBy('merk_barang')
        ->groupBy('merk_barang', 'kondisi', 'loan_id', 'kode')
        ->get();
   

        $update = DB::table('returns')
            ->where('returns.id', '=', $id)
            ->update([
                'status' => 'tidak-dikembalikan',

            ]);

            $update2 = DB::table('return_asset_detail')
            ->where('return_asset_detail.returns_id', '=', $id)
            ->update([
                'status' => 'tidak-dikembalikan',

            ]);

            $update =DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->where('asset_loan_detail.id', '=', $id)
        ->update([
            'inventory_item.available' => 'not-available',

        ]);

        return redirect()->back()->with('success', compact('indexReturn', 'detailpj', 'update'));
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
    public function update(Request $request, $id)
    {

       

        $update2 = DB::table('return_asset_detail')
        ->where('return_asset_detail.asset_loan_detail_id', '=', $id)
        ->update([
            'status' => $request->status,

        ]);

        $update =DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->join('return_asset_detail','return_asset_detail.asset_loan_detail_id','=', 'asset_loan_detail.id')
        ->where('asset_loan_detail.id', '=', $id)
        ->where('return_asset_detail.status','=','dikembalikan-baik')
        ->update([
            'inventory_item.available' => 'available',

        ]);

        $update =DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->join('return_asset_detail','return_asset_detail.asset_loan_detail_id','=', 'asset_loan_detail.id')
        ->where('asset_loan_detail.id', '=', $id)
        ->where('return_asset_detail.status','=','dikembalikan-rusak')
        ->update([
            'inventory_item.condition' => 'buruk',
        ]);

        $update =DB::table('asset_loan_detail')
        ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
        ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
        ->join('returns','returns.loan_id','=','asset_loan_detail.loan_id')
        ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->join('return_asset_detail','return_asset_detail.asset_loan_detail_id','=', 'asset_loan_detail.id')
        ->where('asset_loan_detail.id', '=', $id)
        ->where('return_asset_detail.status','=','tidak-dikembalikan')
        ->update([
            'inventory_item.condition' => 'hilang',
        ]);




    return redirect()->back()->with('success', 'Status berhasil dikonfirmasi!');
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
