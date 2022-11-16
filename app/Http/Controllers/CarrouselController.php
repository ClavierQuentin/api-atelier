<?php

namespace App\Http\Controllers;

use App\Models\Carrousel;
use App\Http\Requests\StoreCarrouselRequest;
use App\Http\Requests\UpdateCarrouselRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarrouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrousels = Carrousel::paginate(10);
        return view('carrousels.index', compact('carrousels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $images = Image::all();
        return view('carrousels.create', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarrouselRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarrouselRequest $request)
    {

        $carrousel = new Carrousel($request->validated());

        //On enregistre une valeur par défaut
        $carrousel->url = "#";

        if($request['image']){
            $image = Image::find($request['image']);
            $carrousel->image()->associate($image);
        }

        //Si une image est fournie via le formulaire
        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL' => 'image|required',
            ],[
                'required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('carrousel/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $carrousel->image()->associate($image);
        }

        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url']){
            $validatorUrl = Validator::make($request->all(),[
                'url'=>'url'
            ]);
            if($validatorUrl->fails()){
                return redirect('carrousel/create')
                ->withErrors($validatorUrl)
                ->withInput();
            };
            $validatedUrl = $validatorUrl->validated();
            $carrousel->url = $validatedUrl['url'];
        }

        //Enregistrement en DB
        $response = Auth::user()->carrousel()->save($carrousel);


        if($response){
            return redirect('carrousel');
        }
        return redirect('carrousel')->with('error', 'Une erreur est survenue pendant l\'enregistrement');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carrousel  $carrousel
     * @return \Illuminate\Http\Response
     */
    public function edit(Carrousel $carrousel)
    {
        $images = Image::all();
        return view('carrousels.edit', compact('images', 'carrousel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarrouselRequest  $request
     * @param  \App\Models\Carrousel  $carrousel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarrouselRequest $request, Carrousel $carrousel)
    {
        if($request['image'] != NULL){
            //On supprime le lien existant en premier
            $carrousel->image()->dissociate();

            $image = Image::find($request['image']);
            $carrousel->image()->associate($image);
        }

        //Si une image est fournie via le formulaire
        if($request['imageDL'] != NULL){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL' => 'image',
            ],[
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('carrousel/'.$carrousel->id.'/edit')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            //On supprime le lien existant en premier
            $carrousel->image()->dissociate();

            $carrousel->image()->associate($image);
        }


        //Contrôle de la présence d'une url externe remplie au formulaire
        if($request['url']){
            $validatorUrl = Validator::make($request->all(),[
                'url'=>'url'
            ]);
            if($validatorUrl->fails()){
                return redirect('carrousel/'.$carrousel->id.'/edit')
                ->withErrors($validatorUrl)
                ->withInput();
            };
            $validatedUrl = $validatorUrl->validated();
            $carrousel->url = $validatedUrl('url');
        }

        //Enregistrement en base
        $update = $carrousel->update($request->validated());

        //On controle la sortie, si l'update a bien �t� faite.
        if($update){
            return redirect('carrousel');
        }
        return redirect('carrousel')->with('error', 'Une erreur est survenue pendant l\'enregistrement');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carrousel  $carrousel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carrousel $carrousel)
    {
        $delete = $carrousel->delete();
        if($delete){
            return redirect('carrousel');
        }
        abort(500);
    }
}
