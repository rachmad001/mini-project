<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientApi extends Controller
{
    //
    public function index(){
        $hasil = DB::select('select * from tb_m_client');
        return json_encode($hasil, JSON_PRETTY_PRINT);
    }
}
