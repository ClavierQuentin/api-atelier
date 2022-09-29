<?php

use App\Http\Controllers\AuthController;
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
    // Route::get('/private', function(Request $request){
    //     return response()->json('Hello '.$request->user()->name);
    //     // redirect('http://google.com');
    // });
    Route::post('texte-accueil',[TexteAccueilController::class, 'store']);
    Route::put('texte-accueil/{texteAccueil}',[TexteAccueilController::class,'update']);
});

Route::get('texte-accueil/{texteAccueil}',[TexteAccueilController::class, 'show']);
