<?php

namespace App\Http\Controllers\Pj;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class InventoryPJController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('pj')->user();
        $indexBarang = DB::table('inventory')
        ->join('asset', 'asset.id', '=', 'inventory.asset_id')
        ->join('inventory_item','inventory_item.inventory_id','=','inventory.id')
        ->where('inventory_item.pic_id', '=', $user->id)
        ->select([
            'inventory.inventory_brand', 'inventory.photo', 'inventory.id',
            'inventory.asset_id', 'asset.id as id_aset', 'asset.asset_name'
        ])
        ->groupBy('inventory_brand')->get();
      
            

        return view('pages.p_j.barang.barang', compact('indexBarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = DB::table('inventory')
            ->get([
                'inventory.inventory_brand', 'inventory.photo',
                'inventory.asset_id'
            ]);

        $aset = DB::table('asset')
            ->where('asset.type_id', '=', 1)
            ->get(['id', 'asset_name']);

        return view('pages.p_j.barang.create', compact('barang', 'aset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

            $barang = Inventory::create([
                'inventory_brand' => $request->inventory_brand,
                'asset_id'  => $request->asset_id,
                'photo' => $file,
            ]);

         
        } else {

            $file = "https://res.cloudinary.com/nishia/image/upload/v1663485047/default-image_yasmsd.jpg";

            $barang = Inventory::create([
                'inventory_brand' => $request->inventory_brand,
                'asset_id'  => $request->asset_id,
                'photo' => $file,
            ]);
        }
      

     

        return redirect('pj-aset/barang')->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indexBarang = DB::table('inventory')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->get([
                'asset.asset_name', 'asset.id', 'asset.type_id',
                'inventory.inventory_brand', 'inventory.photo', 'inventory.id',
                'inventory.asset_id'
            ]);


        $aset = DB::table('asset')
            ->where('asset.type_id', '=', 1)
            ->get(['id', 'asset_name']);

        return view('pages.p_j.barang.edit', compact('indexBarang', 'aset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $indexBarang = DB::table('inventory')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('inventory.id', '=', $id)
            ->get([
                'asset.asset_name', 'asset.id',
                'inventory.inventory_brand', 'inventory.photo', 'inventory.id',
                'inventory.asset_id'
            ]);

        if ($request->photo) {

            $file = cloudinary()->upload($request->file('photo')->getRealPath())->getSecurePath();

            $update = DB::table('inventory')
                ->where('inventory.id', '=', $id)
                ->update([
                    'inventory_brand' => $request->inventory_brand,
                    'photo' => $file,
                    'asset_id' => $request->asset_id,

                ]);
        } else {

            $update = DB::table('inventory')
                ->where('inventory.id', '=', $id)
                ->update([
                    'inventory_brand' => $request->inventory_brand,
                    'asset_id' => $request->asset_id,

                ]);
        }


        return redirect('pj-aset/barang')->with('success', 'Aset berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Inventory::find($id);
        $barang->delete();

        return redirect('pj-aset/barang')->with('success', 'Aset berhasil dihapus');
    }
}
