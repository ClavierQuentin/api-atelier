<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeuxiemeBanniereController;
use App\Http\Controllers\PremiereBanniereController;
use App\Http\Controllers\TexteAccueilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Enregistrement et login
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
//Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Route protégées Admin
Route::middleware('auth:sanctum','role:admin')->group(function(){
    Route::post('texte-accueil',[TexteAccueilController::class, 'store']);
    Route::post('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'update']);
    Route::delete('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'destroy']);

    Route::post('premiere-banniere',[PremiereBanniereController::class,'store']);
    Route::post('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'update']);
    Route::delete('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'destroy']);

    Route::post('deuxieme-banniere',[DeuxiemeBanniereController::class,'store']);
    Route::post('deuxieme-banniere/{DeuxiemeBanniere}',[DeuxiemeBanniereController::class,'update']);
    Route::delete('deuxieme-banniere/{DeuxiemeBanniere}',[DeuxiemeBanniereController::class,'destroy']);


});

//Routes show
Route::get('texte-accueil/{texteAccueil}',[TexteAccueilController::class, 'show']);
Route::get('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class, 'show']);
Route::get('deuxieme-banniere/{DeuxiemeBanniere}',[DeuxiemeBanniereController::class, 'show']);

//Routes index
Route::get('deuxieme-banniere',[DeuxiemeBanniereController::class, 'index']);
Route::get('premiere-banniere',[PremiereBanniereController::class, 'index']);
Route::get('texte-accueil',[TexteAccueilController::class, 'index']);


