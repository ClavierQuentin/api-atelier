<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use PDO;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFront()
    {
        $produits = Produit::all();

        //On controle une présence des données
        if(isset($produits) && sizeof($produits) > 0){

        }
        abort(404);
    }

    //Listing de tous les produits
    public function index()
    {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }


    //Formulaire de création
    public function create()
    {
        //On récupère les catégories pour les affiches dans le select lors de la création d'un produit
        $categories = Categorie::all();

        $images = Image::all();

        //On controle que les catégories existent
        if(isset($categories) && sizeof($categories) > 0){
            return view('produits.create', compact('categories','images'));
        }
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request)
    {
        //On instancie un nouvel objet Produit avec la requete du formulaire
        $produit = new Produit($request->validated());

        //On récupère la catégorie sélectionnée au formulaire
        $categorie = Categorie::find($produit->categorie_id);

        //On enregistre une valeur par défaut
        $produit->url_externe = "#";

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return redirect('produit/create')
                ->withErrors($validatorBool)
                ->withInput();
            };
            $produit->isAccueil = 1;
        }

        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url_externe']){
            $validatorUrl = Validator::make($request->all(),[
                'url_externe'=>'url'
            ]);
            if($validatorUrl->fails()){
                return redirect('produit/create')
                ->withErrors($validatorUrl)
                ->withInput();
            };
            $validatedUrl = $validatorUrl->validated();
            $produit->url_externe = $validatedUrl('url_externe');
        }

        //Enregistrement en DB
        $response = $categorie->produits()->save($produit);

        if($request['image']){
            foreach($request['image'] as $file){
                $image = Image::find($file);
                $produit->images()->attach($image);
            }
        }

        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL.*' => 'image',
                'imageDL'=>'required'
            ],[
                'imageDL.required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('produit/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            foreach($validatedData['imageDL'] as $file){
                $path = $file->storeAs('images', $file->getClientOriginalName(), ['disk'=>'public']);
                $image = new Image();
                $image->url = $path;

                Auth::user()->image()->save($image);

                $produit->images()->attach($image);
            }

        }

        //On controle la sortie, si l'update a bien été faite
        if(empty($response)){
            return redirect('categorie/'.$produit->categorie_id.'/produits')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie/'.$produit->categorie_id.'/produits');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function showFront(Produit $produit)
    {
        //On requête les produits de la même catégorie en ommettant le produit actuel, limité à 3 produits, dans l'ordre decroissant de date de création
        // $produits = DB::table('produits')
        // ->where('id', '!=', $produit->id)
        // ->where('categorie_id', '=', $produit->categorie_id)
        // ->limit(3)
        // ->orderByDesc('created_at')
        // ->get();

        $produits = Produit::where('id', '!=', $produit->id)->get();

        return view('front.produit', compact('produit', 'produits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //On récupère les catégories pour les affiches dans le select lors de la création d'un produit
         $categories = Categorie::all();

         $images = Image::all();

         //On controle la présence des données
         if(isset($categories) && sizeof($categories) > 0){
            return view('produits.edit', compact('produit','categories', 'images'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduitRequest  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduitRequest $request, Produit $produit)
    {

        //Si choix d'images déjà existantes
        if($request['image']){
            foreach($request['image'] as $file){
                $image = Image::find($file);
                $produit->images()->attach($image);
            }
        }

        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL.*' => 'image',
            ],[
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                $categories = Categorie::all();
                return redirect('produit/edit/'.$produit->id)
                ->with($categories)
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            foreach($validatedData['imageDL'] as $file){
                $path = $file->storeAs('images', $file->getClientOriginalName(), ['disk'=>'public']);
                $image = new Image();
                $image->url = $path;

                Auth::user()->image()->save($image);

                $produit->images()->attach($image);
            }

        }

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return redirect('produit/edit/'.$produit->id)
                ->withErrors($validatorBool)
                ->withInput();
            };
            $produit->isAccueil = 1;
        }



        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url_externe']){
            $validatorUrl = Validator::make($request->all(),[
                'url_externe'=>'url'
            ]);
            if($validatorUrl->fails()){
                return redirect('produit/edit/'.$produit->id)
                ->withErrors($validatorUrl)
                ->withInput();
            };
            $validatedUrl = $validatorUrl->validated();
            $produit->url_externe = $validatedUrl['url_externe'];
        }

        //Enregistrement des changements en DB
        $update = $produit->update($request->validated());

        //On controle la sortie, si l'update a bien été faite
        if(!$update){
            return redirect('categorie/'.$produit->categorie_id.'/produits')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie/'.$produit->categorie_id.'/produits');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //Suppression en DB
        $delete = $produit->delete();
        if(!$delete){
            abort(404);
        }
        return redirect('produit');

    }

    public function deleteImage(Produit $produit, $image)
    {
        $image = Image::find($image);

        $produit->images()->detach($image);

        //On récupère les catégories pour les affiches dans le select lors de la création d'un produit
        $categories = Categorie::all();

        $images = Image::all();


        return view('produits.edit', compact('produit', 'categories', 'images'));
    }

}
