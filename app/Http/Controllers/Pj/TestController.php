<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\AssetLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pj');
    }


  
    public function index()
    {
        dd(Auth::guard('pj')->check());
        return view('pages.pj-aset.pj-aset');
    }

    
    public function sucessf() {

        return view('pages.pj-aset.success');
    }
}
