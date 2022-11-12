<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DeuxiemeBanniereController;
use App\Http\Controllers\ListEmailController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PremiereBanniereController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\TexteAccueilController;
use App\Http\Controllers\TroisiemeBanniereController;
use App\Models\Newsletter;
use App\Models\TexteAccueil;
use App\Models\TroisiemeBanniere;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

// Auth::routes(['register' => false]); //Désactivation de la route d'enregistrement d'un user

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Groupement de routes sécurisées
Route::middleware('auth','role:admin')->group(function(){

    //-----------------------------Routes pour les textes de la page d'accueil-------------------------------------//

    Route::get('texte-accueil',[TexteAccueilController::class, 'index'])->name('texteAccueil.index'); //Route affichage dashboard

    Route::get('texte-accueil/edit/{texteAccueil}',[TexteAccueilController::class, 'edit'])->name('texteAccueil.edit'); //Route affichage d'édition

    Route::get('texte-accueil/create',[TexteAccueilController::class, 'create'])->name('texteAccueil.create'); //Route formulaire création

    Route::post('texte-accueil',[TexteAccueilController::class, 'store'])->name('texteAccueil.store'); //Route d'enregistrement

    Route::put('texte-accueil/{texteAccueil}',[TexteAccueilController::class, 'update'])->name('texteAccueil.update'); //Route d'update

    Route::put('texte-accueil/update-online/{texteAccueil}',[TexteAccueilController::class, 'updateOnline'])->name('texteAccueil.online'); //Update pour préciser les textes à mettre en ligne

    Route::delete('texte-accueil/delete/{texteAccueil}',[TexteAccueilController::class,'destroy'])->name('texteAccueil.delete'); //Route delete



    //----------------------------Route d'affichage pour les bannières de la page de présentation------------------------------//
    Route::get('presentation',[PresentationController::class, 'index'])->name('presentation.index');



    //-----------------------------Routes pour les textes de présentation Premiere Banniere-------------------------------------//

    Route::get('premiere-banniere',[PremiereBanniereController::class, 'index'])->name('premiereBanniere.index'); //Route affichage dashboard

    Route::get('premiere-banniere/edit/{premiereBanniere}',[PremiereBanniereController::class, 'edit'])->name('premiereBanniere.edit'); //Route affichage d'édition

    Route::get('premiere-banniere/create',[PremiereBanniereController::class, 'create'])->name('premiereBanniere.create'); //Route formulaire création

    Route::post('premiere-banniere',[PremiereBanniereController::class, 'store'])->name('premiereBanniere.store'); //Route d'enregistrement

    Route::put('premiere-banniere/{premiereBanniere}',[PremiereBanniereController::class, 'update'])->name('premiereBanniere.update'); //Route d'update

    Route::put('premiere-banniere/update-online/{premiereBanniere}',[PremiereBanniereController::class, 'updateOnline'])->name('premiereBanniere.online'); //Update pour préciser les textes à mettre en ligne

    Route::delete('premiere-banniere/delete/{premiereBanniere}',[PremiereBanniereController::class, 'destroy'])->name('premiereBanniere.delete'); //Route de suppression


    //-----------------------------Routes pour les textes de la page présentation Deuxieme banniere-------------------------------------//

    Route::get('deuxieme-banniere',[DeuxiemeBanniereController::class, 'index'])->name('deuxiemeBanniere.index'); //Route affichage dashboard

    Route::get('deuxieme-banniere/edit/{deuxiemeBanniere}',[DeuxiemeBanniereController::class, 'edit'])->name('deuxiemeBanniere.edit'); //Route affichage d'édition

    Route::get('deuxieme-banniere/create',[DeuxiemeBanniereController::class, 'create'])->name('deuxiemeBanniere.create'); //Route formulaire création

    Route::post('deuxieme-banniere',[DeuxiemeBanniereController::class, 'store'])->name('deuxiemeBanniere.store'); //Route d'enregistrement

    Route::put('deuxieme-banniere/{deuxiemeBanniere}',[DeuxiemeBanniereController::class, 'update'])->name('deuxiemeBanniere.update'); //Route d'update

    Route::put('deuxieme-banniere/update-online/{deuxiemeBanniere}',[DeuxiemeBanniereController::class, 'updateOnline'])->name('deuxiemeBanniere.online'); //Update pour préciser les textes à mettre en ligne

    Route::get('deuxieme-banniere/delete-image/{deuxiemeBanniere}/{image}',[DeuxiemeBanniereController::class, 'deleteImage'])->name('delete.image'); //route pour supprimer une image en particulier

    Route::delete('deuxieme-banniere/delete/{deuxiemeBanniere}',[DeuxiemeBanniereController::class, 'destroy'])->name('deuxiemeBanniere.delete'); //Route de suppression


    //-----------------------------Routes pour les textes de la page présentation Troisieme Banniere-------------------------------------//

    Route::get('troisieme-banniere',[TroisiemeBanniereController::class, 'index'])->name('troisiemeBanniere.index'); //Route affichage dashboard

    Route::get('troisieme-banniere/edit/{troisiemeBanniere}',[TroisiemeBanniereController::class, 'edit'])->name('troisiemeBanniere.edit'); //Route affichage d'édition

    Route::get('troisieme-banniere/create',[TroisiemeBanniereController::class, 'create'])->name('troisiemeBanniere.create'); //Route formulaire création

    Route::post('troisieme-banniere',[TroisiemeBanniereController::class, 'store'])->name('troisiemeBanniere.store'); //Route d'enregistrement

    Route::put('troisieme-banniere/{troisiemeBanniere}',[TroisiemeBanniereController::class, 'update'])->name('troisiemeBanniere.update'); //Route d'update

    Route::put('troisieme-banniere/update-online/{troisiemeBanniere}',[TroisiemeBanniereController::class, 'updateOnline'])->name('troisiemeBanniere.online'); //Update pour préciser les textes à mettre en ligne

    Route::delete('troisieme-banniere/delete/{troisiemeBanniere}',[TroisiemeBanniereController::class, 'destroy'])->name('troisiemeBanniere.delete'); //Route de suppression



    //-------------------------------------------ROUTE CATEGORIES-------------------------------------------------------//

    Route::get('categorie',[CategorieController::class, 'index'])->name('categorie.index'); //Route d'afichage des categories

    Route::get('categorie/create',[CategorieController::class, 'create'])->name('categorie.create'); //Route d'afichage du formulaire de création d'une categorie

    Route::delete('categorie/{categorie}',[CategorieController::class, 'destroy'])->name('categorie.delete'); //Route de suppression d'une categorie

    Route::get('categorie/edit/{categorie}',[CategorieController::class, 'edit'])->name('categorie.edit'); //Route d'affichage du formulaire d'édition d'une categorie

    Route::put('categorie/{categorie}/update',[CategorieController::class, 'update'])->name('categorie.update'); //Route d'enregistrement de l'update

    Route::post('categorie/store',[CategorieController::class, 'store'])->name('categorie.store'); //Route d'enregistrement d'une categorie


        //-------------------------------------------ROUTE PRODUITS-------------------------------------------------------//
    Route::get('categorie/{categorie}/produits',[CategorieController::class, 'indexProducts'])->name('categorie.produits'); //Route pour afficher les produits que possede une categorie

    Route::get('produit/edit/{produit}',[ProduitController::class, 'edit'])->name('produit.edit'); //Route pour afficher le formulaire d'édition d'un produit

    Route::put('produit/update/{produit}',[ProduitController::class, 'update'])->name('produit.update'); //Route pour enregistrer la MAJ

    Route::get('produit/create',[ProduitController::class, 'create'])->name('produit.create'); //Route pour afficher le formulaire de création d'un produit

    Route::post('produit/store',[ProduitController::class, 'store'])->name('produit.store'); //Route d'enregistrement du nouveau produit

    Route::get('produit',[ProduitController::class, 'index'])->name('produit.index'); //Route affichage tous produits

    Route::delete('produit/delete/{produit}',[ProduitController::class, 'destroy'])->name('produit.delete'); //Route de suppression



    Route::get('newsletter/create',[NewsletterController::class, 'create'])->name('newsletter.create');

    Route::post('newsletter/save',[NewsletterController::class, 'sendEmails'])->name('newsletter.store');

    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');

    Route::get('newsletter/{newsletter}',[NewsletterController::class, 'show'])->name('newsletter.show');

    Route::delete('newsletter/delete/{newsletter}',[NewsletterController::class, 'destroy'])->name('newsletter.delete');

}); //Sortie du group middleware

/**---------------------ROUTES SANS AUTH--------------------- */
Route::get('edit-email',[ListEmailController::class, 'edit'])->name('email.edit'); //Route pour le formulaire pour supprimer adresse email

Route::post('delete-email',[ListEmailController::class, 'destroy'])->name('email.delete'); //Route pour suppression email de newsletter
