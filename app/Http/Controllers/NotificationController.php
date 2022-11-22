<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        if (Auth::guard('pj')->check()) {
            $pic_id = Auth::guard('pj')->user()->id;
            $pic_name = Auth::guard('pj')->user()->pic_name;
            $indexnotif = DB::table('notifications')
                ->where('receiver_id', '=', $pic_id)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at','id'
                ]);
                
                $unread = DB::table('notifications')
                ->where('receiver_id', '=', $pic_id)
                ->where('read_at','=',null)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at','id'
                ]);
        } else {
            $indexnotif = DB::table('notifications')
                ->where('receiver_id', '=', null)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at','id'
                ]);

                $unread = DB::table('notifications')
                ->where('receiver_id', '=', null)
                ->where('read_at','=',null)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at','id'
                ]);
        }
        $response = new \stdClass();

        $data = [
            'list'=> $indexnotif,
            'unread' => count($unread),
        ];

        return response()->json([
            'data' => $data,
            'success' => true,
            'message' => 'Success'

        ]);

        // return view('pages.aset.aset', compact('indexAset'));
    }

    public function update()
    {
        
        $now = Carbon::today();

        if (Auth::guard('pj')->check()) {
            $pic_id = Auth::guard('pj')->user()->id;
            $pic_name = Auth::guard('pj')->user()->pic_name;

            $indexnotif = DB::table('notifications')
                ->where('receiver_id', '=', $pic_id)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at'
                ]);

            $update = DB::table('notifications')
                ->update([
                    'read_at' => $now

                ]);
        } else {
            $indexnotif = DB::table('notifications')
                ->where('receiver_id', '=', null)
                ->get([
                    'sender_id', 'sender', 'receiver_id', 'receiver', 'message', 'object_type_id', 'object_type', 'read_at'
                ]);

            $update = DB::table('notifications')
                ->update([
                    'read_at' => $now
                ]);
        }

        // dd($indexnotif);
        $response = new \stdClass();
        return response()->json([
            // 'data' => $indexnotif,
            'success' => true,
            'message' => 'Success'

        ]);





        // return view('pages.aset.aset', compact('indexAset'));
    }
}
