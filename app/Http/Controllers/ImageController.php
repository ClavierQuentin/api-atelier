<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();

        return view('images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Règles de validation
        $validator = Validator::make($request->all(), [
            'image.*' => 'image',
            'image'=>'required'
        ],[
            'image.required' => 'Une image est requise',
            'image' =>'Le fichier doit être une image'
        ]);

        if($validator->fails()){
            return redirect('image/create')
            ->withErrors($validator);
        }

        //On recupère les données validées
        $validatedData = $validator->validated();

        foreach($validatedData['image'] as $file){
            // $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $path = $file->storeAs('images', $file->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);
        }

        return redirect('image/all');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //On décompose l'url
        $url = explode("/", $image->url);

        //On récupère le nom du ficher
        $fileName = $url[count($url)-1];

        if(isset($fileName)){
            Storage::delete($fileName);

            $delete = $image->delete();
        }

        if($delete){
            return redirect('image/all');
        }

        abort(500);

    }
}
