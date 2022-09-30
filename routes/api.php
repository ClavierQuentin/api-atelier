<?php

use App\Http\Controllers\AuthController;
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

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum','role:admin')->group(function(){
    Route::post('texte-accueil',[TexteAccueilController::class, 'store']);
    Route::post('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'update']);
    Route::delete('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'destroy']);

    Route::post('premiere-banniere',[PremiereBanniereController::class,'store']);
    Route::post('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'update']);
    Route::delete('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'destroy']);

});

Route::get('texte-accueil/{texteAccueil}',[TexteAccueilController::class, 'show']);
Route::get('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class, 'show']);
