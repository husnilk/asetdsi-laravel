<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\AssetLoanDetail;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Mahasiswa;
use App\Models\Returns;
use Error;
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
                'loan.id', 'loan.status as statuspj', 'loan.created_at','loan.loan_time_end as waktu_akhir'
            ])
            ->orderBy('created_at')
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
                'loan.id', 'loan.status as statuspj', 'loan.created_at',
                'loan.loan_time_end as waktu_akhir'
            ])
            ->orderBy('created_at')

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
                'loan.id', 'loan.status as statuspj'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();



        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('asset_loan_detail.loan_id', '=', $id)

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
            asset.asset_name'

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
                'loan.id', 'loan.status as statuspj'
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
            building.available,
            building_loan_detail.loan_id as loan_id,
            building_loan_detail.status_pj,
            building_loan_detail.id,
            loan.loan_date,
            building.id as building_id'
            )
            ->groupBy('merk_barang', 'kondisi', 'loan_id')
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
                'loan.id', 'loan.status as statuspj'
            ])
            ->orderBy('nama_mahasiswa')
            ->get();

        $user_id = $indexPeminjaman[0]->mahasiswa_id;



        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('asset_loan_detail.loan_id', '=', $id)

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
            asset.asset_name'

            )

            ->groupBy('merk_barang', 'kondisi', 'loan_id')
            ->get();



        $updateAvailable = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->where('status_pj','=','accepted')
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
                asset.asset_name'
            )
            ->update([
                'inventory_item.available' => 'not-available',

            ]);

        $update = DB::table('loan')
            ->where('loan.id', '=', $id)
            ->update([
                'status' => 'accepted',

            ]);


        if ($update) {
            //berhasil login, kirim notifikasi
            $this->sendNotification($user_id);
        }

        
        $returns = Returns::create([
            'status'       => 'sedang-dipinjam',
            'loan_id'  => $id
        ]);

        return redirect()->back()->with('success', compact('indexPeminjaman', 'detailpj', 'update', 'returns', 'updateAvailable'));
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

        $user_id = $indexPeminjaman[0]->mahasiswa_id;

        $detailpj = DB::table('asset_loan_detail')
            ->join('inventory_item', 'inventory_item.id', '=', 'asset_loan_detail.inventory_item_id')
            ->join('loan', 'loan.id', '=', 'asset_loan_detail.loan_id')
            ->join('inventory', 'inventory.id', '=', 'inventory_item.inventory_id')
            ->join('asset', 'asset.id', '=', 'inventory.asset_id')
            ->where('asset_loan_detail.loan_id', '=', $id)

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
            asset.asset_name'

            )
            ->groupBy('merk_barang', 'kondisi', 'loan_id')
            ->get();

        $update = DB::table('loan')
            ->where('loan.id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

        $update2 = DB::table('asset_loan_detail')
            ->where('asset_loan_detail.loan_id', '=', $id)
            ->update([
                'status_pj' => 'rejected',

            ]);

        if ($update) {
            //berhasil login, kirim notifikasi
            $this->sendNotification($user_id);
        }

        return redirect()->back()->with('success', compact('indexPeminjaman', 'detailpj', 'update'));
    }

    public function accbg(Request $request, $id)
    {
        try {
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


            $user_id = $indexPeminjaman[0]->mahasiswa_id;

            $indexPeminjamanBangunan = DB::table('building_loan_detail')
                ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
                ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
                ->where('building_loan_detail.loan_id', '=', $id)
                ->selectRaw(
                    'count(building.building_name) as jumlah,
                building.building_name as merk_barang,
                building.condition as kondisi,
                building.available,
                building_loan_detail.loan_id as loan_id,
            building_loan_detail.status_pj,
            building_loan_detail.id,
                loan.loan_date,
                loan.loan_time,
                loan.loan_time_end,
                building.id as building_id'

                )
                ->groupBy('merk_barang', 'kondisi', 'loan_id')
                ->get();

            // s | e
           // 9 = 12
           // ? 10- 15

            // 9s > 7s = boleh
            // 9s > 8e = boleh
            // 12e > 10s =
            // ------------------------------- 
            // s > e = b
           // e < s = b

           // 9s > 15e \\ s
           //12e < 10s  \\ s
           
           // --------------------------

           // 9s > 10s || s
           // 9s < 15e || b
           // 9s < 10s || b
           // 9s > 10e || s

           // 9s = 10s - 15e || b
           // 12e = 10s - 15e || b

           //8 - 11
         
         // 9s = 8s - 11e || b
        // 12e = 8s - 11e || s     = b
      
     // s + s = false

        // 9s = 11s - 1e || s
        // 12e = 11s -1e || b


            if (count($indexPeminjamanBangunan) == 0) throw new Error('tidak ada bangunan');
             // 9:30 || 12:00
             // 10 - 11
            // $loan_time = '10:00:00';
            // $loan_time_end = '11:00:00';
            $listAvailablePeminjaman = DB::table('building_loan_detail')
                ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
                ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
                ->where('building_loan_detail.building_id', '=', $indexPeminjamanBangunan[0]->building_id)
                ->where('loan_date', '=', $indexPeminjamanBangunan[0]->loan_date)
                ->where('loan.status', '=', 'accepted')
                ->where(function ($query) use ($indexPeminjamanBangunan) {
                    $query->orWhere(function ($query) use ($indexPeminjamanBangunan) {
                        $query->where('loan_time','<=',$indexPeminjamanBangunan[0]->loan_time); 
                        $query->where('loan_time','<=',$indexPeminjamanBangunan[0]->loan_time_end); 
                        $query->where('loan_time_end','>=',$indexPeminjamanBangunan[0]->loan_time_end); 
                        $query->where('loan_time_end','>=',$indexPeminjamanBangunan[0]->loan_time);
                    });
                    // 9:3 > 8 = true
                    $query->orWhereBetween('loan_time', [$indexPeminjamanBangunan[0]->loan_time,$indexPeminjamanBangunan[0]->loan_time_end]);
                    $query->orWhereBetween('loan_time_end', [$indexPeminjamanBangunan[0]->loan_time,$indexPeminjamanBangunan[0]->loan_time_end]);
                })
                // ->orWhereBetween('loan_time', [$indexPeminjamanBangunan[0]->loan_time,$indexPeminjamanBangunan[0]->loan_time_end])
                // ->orWhereBetween('loan_time_end', [$indexPeminjamanBangunan[0]->loan_time,$indexPeminjamanBangunan[0]->loan_time_end])
                ->selectRaw(
                    'count(building.building_name) as jumlah,
                building.building_name as merk_barang,
                building.condition as kondisi,
                building.available,
                building_loan_detail.loan_id as loan_id,
                building_loan_detail.status_pj,
                building_loan_detail.id,
                loan.loan_date,
                loan.loan_time,
                loan.loan_time_end,
                building.id as building_id'
                )
                ->groupBy('merk_barang', 'kondisi', 'loan_id')
                ->get();

            //  dd($listAvailablePeminjaman);
            if (count($listAvailablePeminjaman) > 0) return back()->withError('Bangunan Tidak Bisa Dipinjam Pada Tanggal Tersebut');


            $update = DB::table('loan')
                ->where('loan.id', '=', $id)
                ->update([
                    'status' => 'accepted',

                ]);

            $update2 = DB::table('building_loan_detail')
                ->where('building_loan_detail.loan_id', '=', $id)
                ->update([
                    'status_pj' => 'accepted',

                ]);

            if ($update) {
                //berhasil login, kirim notifikasi
                $this->sendNotification($user_id);
            }


            return redirect()->back()->with('success', compact('indexPeminjaman', 'indexPeminjamanBangunan', 'update'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());

            // return back()->withError($e->getMessage())->withInput();
            // abort(404, $e->getMessage());
            // return redirect()->back()->with('error')->$e->getMessage();

        }
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

        $user_id = $indexPeminjaman[0]->mahasiswa_id;

        $indexPeminjamanBangunan = DB::table('building_loan_detail')
            ->join('building', 'building.id', '=', 'building_loan_detail.building_id')
            ->join('loan', 'loan.id', '=', 'building_loan_detail.loan_id')
            ->where('building_loan_detail.loan_id', '=', $id)
            ->selectRaw(

                'count(building.building_name) as jumlah,
                building.building_name as merk_barang,
                building.condition as kondisi,
                building.available,
                building_loan_detail.loan_id as loan_id,
            building_loan_detail.status_pj,
            building_loan_detail.id,
                loan.loan_date,
                building.id as building_id'

            )
            ->groupBy('merk_barang', 'kondisi', 'loan_id')
            ->get();

        $update = DB::table('loan')
            ->where('loan.id', '=', $id)
            ->update([
                'status' => 'rejected',

            ]);

        $update2 = DB::table('building_loan_detail')
            ->where('building_loan_detail.loan_id', '=', $id)
            ->update([
                'status_pj' => 'rejected',

            ]);

        if ($update) {
            //berhasil login, kirim notifikasi
            $this->sendNotification($user_id);
        }

        return redirect()->back()->with('success', compact('indexPeminjaman', 'indexPeminjamanBangunan', 'update'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanRequest  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $update = DB::table('asset_loan_detail')
            ->where('asset_loan_detail.id', '=', $id)
            ->update([
                'status_pj' => $request->status_pj,

            ]);


        return redirect()->back()->with('success', 'Status berhasil dikonfirmasi!');
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

    //     public function sendNotification()
    //     {
    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => '{
    //     "to" : "/topics/history_permintaan",
    //     "notification":{
    //         "title" : "Permintaan Aset",
    //         "body" : "Permintaanmu Sudah DiKonfirmasi, Silahkan Lihat History"
    //     }
    // }',
    //             CURLOPT_HTTPHEADER => array(
    //                 'Authorization: key=AAAAM1IGgOM:APA91bFA6AwUtor2HIY_-wSOAx0paFwQGjXOlosxTg4X7wSMIYKYxA4r-9XO9b5LIeL5g7OWgYnxizMwkjjJ6OXKGcIkCwYfbDr8PuDro6n87QDD86OOeh7Sf8tvoCbTQNqB1aX6w1hP ',
    //                 'Content-Type: application/json'
    //             ),
    //         ));

    //         $response = curl_exec($curl);

    //         curl_close($curl);
    //         echo $response;
    //     }

    public function logout(Request $request)
    {
        $user = auth('sanctum')->user();

        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Tokens Delete'
        ];
    }

    //Notifikasi
    public function sendNotification($user_id)
    {

        $mahasiswa = DB::table('mahasiswa')
            ->where('id', '=', $user_id)
            ->get(
                'mahasiswa.remember_token'
            );

        $fcm_token = $mahasiswa[0]->remember_token;
        // dd($fcm_token);

        // dd($mahasiswa);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "to" : "' . $fcm_token . '",
    "notification":{
        "title" : "Permintaan Aset",
        "body" : "Permintaanmu Sudah Di Proses"
    }
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=AAAAM1IGgOM:APA91bFA6AwUtor2HIY_-wSOAx0paFwQGjXOlosxTg4X7wSMIYKYxA4r-9XO9b5LIeL5g7OWgYnxizMwkjjJ6OXKGcIkCwYfbDr8PuDro6n87QDD86OOeh7Sf8tvoCbTQNqB1aX6w1hP ',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
