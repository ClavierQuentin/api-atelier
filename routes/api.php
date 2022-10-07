<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DeuxiemeBanniereController;
use App\Http\Controllers\PremiereBanniereController;
use App\Http\Controllers\TexteAccueilController;
use App\Http\Controllers\TroisiemeBanniereController;
use App\Models\Categorie;
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
    Route::put('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'update']);
    Route::delete('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'destroy']);
    Route::get('texte-accueil/{texteAccueil}/edit',[TexteAccueilController::class,'edit']);


    Route::post('premiere-banniere',[PremiereBanniereController::class,'store']);
    Route::put('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'update']);
    Route::delete('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class,'destroy']);
    Route::get('premiere-banniere/{premiereBanniere}/edit',[PremiereBanniereController::class,'edit']);


    Route::post('deuxieme-banniere',[DeuxiemeBanniereController::class,'store']);
    Route::put('deuxieme-banniere/{deuxiemeBanniere}',[DeuxiemeBanniereController::class,'update']);
    Route::delete('deuxieme-banniere/{deuxiemeBanniere}',[DeuxiemeBanniereController::class,'destroy']);
    Route::get('deuxieme-banniere/{deuxiemeBanniere}/edit',[DeuxiemeBanniereController::class,'edit']);


    Route::post('troisieme-banniere',[TroisiemeBanniereController::class,'store']);
    Route::put('troisieme-banniere/{troisiemeBanniere}',[TroisiemeBanniereController::class,'update']);
    Route::delete('troisieme-banniere/{troisiemeBanniere}',[TroisiemeBanniereController::class,'destroy']);
    Route::get('troisieme-banniere/{troisiemeBanniere}/edit',[TroisiemeBanniereController::class,'edit']);

    Route::post('categories',[CategorieController::class, 'store']);
    Route::post('categories/{categorie}',[CategorieController::class, 'update']);
    Route::delete('categories/{categorie}',[CategorieController::class, 'delete']);
    Route::get('categories/{categorie}/edit',[CategorieController::class, 'edit']);

});

//Routes show
Route::get('texte-accueil/{texteAccueil}',[TexteAccueilController::class, 'show']);
Route::get('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class, 'show']);
Route::get('deuxieme-banniere/{deuxiemeBanniere}',[DeuxiemeBanniereController::class, 'show']);
Route::get('troisieme-banniere/{troisiemeBanniere}',[TroisiemeBanniereController::class, 'show']);
Route::get('categories/{categorie}',[CategorieController::class, 'show']);


//Routes index
Route::get('deuxieme-banniere',[DeuxiemeBanniereController::class, 'index']);
Route::get('premiere-banniere',[PremiereBanniereController::class, 'index']);
Route::get('texte-accueil',[TexteAccueilController::class, 'index']);
Route::get('troisieme-banniere',[TroisiemeBanniereController::class, 'index']);
Route::get('categories',[CategorieController::class, 'index']);

