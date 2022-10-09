<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;



class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function indexFromCategorie(Categorie $categorie)
    {
        $produits = $categorie->getProduits->all();

        // $produits = DB::table('produits')
        // ->where('categorie_id','=',$categorie->id)
        // ->get();

        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request, Categorie $categorie)
    {
        // $categorie = Categorie::find($categorie);
        // return response()->json($categorie);

        // $validator = Validator::make($request->all(),[
        //     'image'=>[
        //         'required',
        //         File::image()
        //     ]
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'Une erreur est survenue',
        //         'errors'=>$validator->errors()
        //     ],401);
        // };

        // $validated = $validator->validated();
        // $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        $produit = new Produit([
            'nom_produit'=>$request->validated('nom_produit'),
            'description_courte_produit'=>$request->validated('description_courte_produit'),
            'description_longue_produit'=>$request->validated('description_longue_produit'),
            "url_image_produit"=>$request->validated('url_image_produit'),
            'prix_produit'=>$request->validated('prix_produit')
        ]);

        $response = $categorie->produits()->save($produit);

        if(!empty($response) && !empty($path)){
            return response()->json([
                'status'=>'success',
                'message'=>'New entry added successfully.'
            ],201);
        }
        return response()->json(array('status'=>false), 500);
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
        return response()->json($produit, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }
}
