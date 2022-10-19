<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentationController extends Controller
{
    public function index()
    {
        $premiereBannieres = DB::table('premiere_bannieres')
                            ->orderBy('id','desc')
                            ->limit('3')
                            ->get();
        $deuxiemeBannieres = DB::table('deuxieme_bannieres')
                            ->orderBy('id','desc')
                            ->limit('3')
                            ->get();
        $troisiemeBannieres = DB::table('troisieme_bannieres')
                            ->orderBy('id','desc')
                            ->limit('3')
                            ->get();

        if(isset($troisiemeBannieres) && isset($deuxiemeBannieres) && isset($premiereBannieres) && sizeof($premiereBannieres) > 0 && sizeof($troisiemeBannieres) > 0 && sizeof($deuxiemeBannieres) > 0){
            return view('presentation.index',['premiereBannieres'=>$premiereBannieres, 'deuxiemeBannieres'=>$deuxiemeBannieres, 'troisiemeBannieres'=>$troisiemeBannieres]);
        }
    }
}
