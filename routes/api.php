<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DeuxiemeBanniereController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PremiereBanniereController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RecaptchaController;
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



/*-------------------------------Routes pour la page d'accueil----------------------*/

Route::get('texte-accueil',[TexteAccueilController::class, 'indexApi']); //Affiche les textes
Route::get('produits-accueil',[ProduitController::class, 'indexAccueil']); //Affiche les produits à mettre en avant pour la bannière
Route::get('categories-accueil',[CategorieController::class, 'categorieIsAccueil']); //Affiche les catégories à mettre en avant

/*----------------------------------------------------------------------------------*/


/*-------------------------------Routes pour la page About----------------------*/

Route::get('premiere-banniere',[PremiereBanniereController::class, 'indexApi']); //Affiche les textes et images
Route::get('deuxieme-banniere',[DeuxiemeBanniereController::class, 'indexApi']); //Affiche les textes et images
Route::get('troisieme-banniere',[TroisiemeBanniereController::class, 'indexApi']); //Affiche les textes et images

/*----------------------------------------------------------------------------------*/


/*-------------------------------Routes pour les catégories----------------------*/

Route::get('categories',[CategorieController::class, 'indexApi']); //Affiche toutes les catégories

/*----------------------------------------------------------------------------------*/


/*-------------------------------Routes pour les produits----------------------*/

Route::get('categories/{categorie}/produits',[CategorieController::class, 'getAllProducts']); //Affiche tous les produits appartenant à une catégorie
Route::get('produits/{produit}',[ProduitController::class, 'show']); //Affiche les détails d'un produit
Route::get('produits/{produit}/all',[ProduitController::class, 'sameProduct']); //Affiche les autres produits d'une catégorie

/*----------------------------------------------------------------------------------*/


/*----------------------------------Autres routes-------------------------------*/

Route::post('recaptcha/{token}',[RecaptchaController::class, 'googleResponse']); //Route repatcha pour contrôle au formulaire de contact

Route::post('message',[MessageController::class,'store']); //Route pour reception de message et gestion d'envoie de l'email

Route::get('send',[NewsletterController::class,'sendEmails']);
