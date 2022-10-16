<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
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
    public function indexApi()
    {
        $produits = Produit::all();
        if(isset($produits)){
            return response()->json($produits, 200);
        }
        return response()->json(['status'=>false],404);
    }

    public function index()
    {
        $produits = Produit::all();
        if(isset($produits)){
            return view('produits.index', compact('produits'));
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function productFromSameCategorie(Produit $produit)
    {
        $categorie = Categorie::find($produit->categorie_id);

        $produits = $categorie->getProduits;

        if(isset($produits)){
            return response()->json($produits, 200);
        }
        return response()->json(['status' => false], 500);
    }

    public function create()
    {
        //On récupère les catégories pour les affiches dans le select lors de la création d'un produit
        $categories = Categorie::all();
        if(isset($categories)){
            return view('produits.create', compact('categories'));
        }
        abort(500);
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
        // Regles de validation pour l'image d'illustration
        $validator = Validator::make($request->all(),[
            'image'=>[
                'required',
                File::image()
            ]
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validator->errors()
            ],401);
        };
        $validated = $validator->validated();

        //Upload de l'image sur le cloud
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        //On instancie un nouvel objet Produit avec la requete du formulaire
        $produit = new Produit($request->validated());

        //On récupère la catégorie sélectionnée au formulaire
        $categorie = Categorie::find($produit->categorie_id);

        //Enregistrement du chemin d'acces de l'image
        $produit->url_image_produit = $path;

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Une erreur est survenue',
                    'errors'=>$validatorBool->errors()
                ],401);
            };
            $produit->isAccueil = 1;
        }

        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url_externe']){
            $validatorUrl = Validator::make($request->all(),[
                'url_externe'=>'string'
            ]);
            if($validatorUrl->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Une erreur est survenue',
                    'errors'=>$validatorUrl->errors()
                ],401);
            };
            $validatedUrl = $validatorUrl->validated();
            $produit->url_externe = $validatedUrl('url_externe');
        }

        //Enregistrement en DB
        $response = $categorie->produits()->save($produit);

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
    public function show(Produit $produit)
    {
        return response()->json($produit, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
         $categories = Categorie::all();
         if(isset($categories)){
            return view('produits.edit', compact('produit','categories'));
        }
        abort(500);
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
        //Regle de validation du fichier image
        $validator = Validator::make($request->all(),[
            'image'=>[
                File::image()
            ]
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validator->errors()
            ],401);
        };

        $validated = $validator->validated();

        //Si une image a été fournie au formulaire
        if(isset($validated['image'])){

            //Suppression de l'ancienne image
            $produit->deleteImage();

            //Upload de la nouvelle image
            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            //CHangement de l'url de l'image
            $produit->url_image_produit = $updatedUrl;
        }

        //Cas où la checbox pour affichage à l'accueil est cochée
        if($request['isAccueil']){
            $validatorBool = Validator::make($request->all(),[
                'isAccueil'=>'boolean'
            ]);
            if($validatorBool->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Une erreur est survenue',
                    'errors'=>$validatorBool->errors()
                ],401);
            };
            $produit->isAccueil = 1;
        }



        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url_externe']){
            $validatorUrl = Validator::make($request->all(),[
                'url_externe'=>'string'
            ]);
            if($validatorUrl->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Une erreur est survenue',
                    'errors'=>$validatorUrl->errors()
                ],401);
            };
            $validatedUrl = $validatorUrl->validated();
            $produit->url_externe = $validatedUrl('url_externe');
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
        // //Suppression de l'image sur le cloud
        $produit->deleteImage();

        //Suppression en DB
        $delete = $produit->delete();
        if(!$delete){
            abort(500);
        }
        return view('produits.index');

    }


    //Fonction pour récupérer les produits à afficher sur l'acceuil
    public function indexAccueil()
    {
        $produits = DB::table('produits')
                    ->where('isAccueil', '=', '1')
                    ->get();
        if(isset($produits))
        {
            return response()->json(['status' => true], 200);
        }
        return response()->json(['status' => false], 404);
    }
}
