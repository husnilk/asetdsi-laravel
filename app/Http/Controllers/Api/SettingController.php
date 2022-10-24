<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user_id =auth('sanctum')->user()->id; 

        $user = Mahasiswa::where('id',$user_id)->first();
    

    if ($user) {
        return response()->json([
            'data'=>$user,
            'success' => true,
            'message' => 'Success',]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Post Tidak Ditemukan!',
        ], 404);
    }
    
    }

    public function editprofile(Request $request)
    {
        //tampilkan data / get data duls
        
            // $input= $request->all();
            $user_id =auth('sanctum')->user()->id; 
            $user = Mahasiswa::where('id',$user_id)->first();


            if ($user) {
                $user->nim = $request->nim ? $request->nim : $user->nim  ;
                $user->name = $request->name ? $request->name: $user->name  ;
                $user->email = $request->email ? $request->email: $user->email  ;
                $user->username = $request->username ? $request->username : $user->username  ;

                $user->save();
        
                return response()->json([
                    'data'=>$user,
                    'success' => true,
                    'message' => 'Success',]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Tidak Ditemukan!',
                ], 404);
            }
    
    }

    public function changepassword(Request $request)
    {

  
        $user_id =auth('sanctum')->user()->id; 

        $user = Mahasiswa::where('id',$user_id)->first();

            if ($user) {

            $isValidPassword = Hash::check($request->passwordlama, $user->password);
            
                if (!$isValidPassword) {
                    return response()->json(['message' => 'Password Lama Salah'], 401);
                }else{
                    if($request->passwordbaru1==$request->passwordbaru2){
                        $user->password = Hash::make($request->passwordbaru1) ;
                    }else{
                        return response()->json(['message' => 'Password Tidak Sama'], 401);

                    }
                    
                }

                $user->save();
        
        
                return response()->json([
                    'data'=>$user,
                    'success' => true,
                    'message' => 'Success',]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Tidak Ditemukan!',
                ], 404);
            }
    
    }

   
}
