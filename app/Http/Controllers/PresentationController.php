<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentationController extends Controller
{
    //Affichage des 3 premieres entrées de chaque bannières
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

        return view('presentation.index',['premiereBannieres'=>$premiereBannieres, 'deuxiemeBannieres'=>$deuxiemeBannieres, 'troisiemeBannieres'=>$troisiemeBannieres]);
    }
}
