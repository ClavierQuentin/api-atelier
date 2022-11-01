<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();

        return view('categories.index',compact('categories'));
    }

    //Fonction pour récupérer tous les produits associés à une catégorie
    public function indexProducts(Categorie $categorie)
    {
        $produits = $categorie->produits;

        return view('produits.index_categorie',compact('produits','categorie'));
    }

    //Fonction pour gérer la route de l'API pour le front
    public function indexApi()
    {
        $categories = Categorie::all();

        //On controle que des données soient présentes
        if(isset($categories) && sizeof($categories) > 0){
            return response()->json($categories, 200);
        }
        return response()->json(['status'=>false], 404);

    }

    //Retourne les catégories a afficher en page d'accueil
    public function categorieIsAccueil()
    {
        //On récupère ici les catégories mise en avant, au nombre de 4 max, dans l'ordre décroissant de date de MAJ
        $categories = DB::table('categories')
                    ->where('isAccueil','=', 1)
                    ->orderByDesc('updated_at')
                    ->limit("4")
                    ->get();

        //On controle que des données soient présentes
        if(isset($categories) && sizeof($categories) > 0){
            return response()->json($categories, 200);
        }
        return response()->json(['status'=>false], 404);
    }

    //Formulaire de création
    public function create()
    {
        return view('categories.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategorieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorieRequest $request)
    {
      //Enregistrement de l'image au cloud et on stock l'url
        $path = cloudinary()->upload($request->validated('image')->getRealPath())->getSecurePath();

        //Création d'un nouvel objet
        $categorie = new Categorie($request->validated());

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            //Règles de validation
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return redirect('categorie/create')
                ->withErrors($validatorBool)
                ->withInput();
            };
            //On passe le booléen à 1
            $categorie->isAccueil = 1;
        }

        //On enregistre l'url pour l'image
        $categorie->url_image_categorie = $path;

        //On enregistre en base
        $response = Auth::user()->categories()->save($categorie);

        if(!$response){
            return redirect('categorie')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorieRequest  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        //Dans le cas où une image a été fournie au formulaire
        if($request->validated('image') != NULL){

            //Suppression de l'ancienne image
            $categorie->deleteImage();

            //Enregistrement de la nouvelle image et on stock l'url
            $updatedUrl = cloudinary()->upload($request->validated('image')->getRealPath())->getSecurePath();

            //On enregistre l'url
            $categorie->url_image_categorie = $updatedUrl;
        }

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return redirect('categorie/edit/'.$categorie->id)
                ->withErrors($validatorBool)
                ->withInput();
            };
            //On passe le booléen à 1
            $categorie->isAccueil = 1;
        }

        //On enregistre les modifs en base
        $update = $categorie->update($request->validated());

        if(!$update){
            return redirect('categorie')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //Suppression de l'image sur le cloud
        $categorie->deleteImage();

        //Suppression en DB
        $delete = $categorie->delete();
        if(!$delete){
            return redirect('categorie')->with('error', 'Une erreur est survenue pendant la suppression');
        }
        return redirect('categorie');
    }

    /**
     * Show all products from same category.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     *
     * Pour affichage en front via API
     */
    public function getAllProducts(Categorie $categorie)
    {
        $produits = $categorie->produits;

        //On contrôle si des données sont présentes
        if(isset($produits) && sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
        return response()->json(['status'=>false], 404);
    }
}
