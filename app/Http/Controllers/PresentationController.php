<?php

namespace App\Http\Controllers;

use App\Models\DeuxiemeBanniere;
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

    public function indexFront()
    {
        $premiereBanniere = DB::table('premiere_bannieres')
        ->where('online', '=', '1')
        ->first();

        $deuxiemeBanniere = DB::table('deuxieme_bannieres')
                ->where('online', '=', '1')
                ->first();
        $deuxiemeBanniere = DeuxiemeBanniere::find($deuxiemeBanniere->id);
        
        $troisiemeBanniere = DB::table('troisieme_bannieres')
                ->where('online', '=', '1')
                ->first();

        if(isset($premiereBanniere) && isset($deuxiemeBanniere) && isset($troisiemeBanniere)){
            return view('front.about',['premiereBanniere'=>$premiereBanniere, 'deuxiemeBanniere'=>$deuxiemeBanniere, 'troisiemeBanniere'=>$troisiemeBanniere]);
        }
        abort(404);

    }
}
