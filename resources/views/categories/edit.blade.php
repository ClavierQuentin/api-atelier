@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire d'édition --}}
        <form class="custom-form" action="{{ route('categorie.update',['categorie'=>$categorie]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-goup m-2">

                <label for="nom_categorie">
                    Nom de la catégorie
                </label>
                <input type="text" name="nom_categorie" id="nom_categorie" class="form-control" value="{{ $categorie->nom_categorie }}">

            </div>

            <div class="form-group m-2">

                <label for="image">
                    Image d'illustration
                </label>

                {{-- Si une image est stockée en base, on l'affiche --}}
                @if(isset($categorie->url_image_categorie))
                    <img src="{{ $categorie->url_image_categorie }}" alt="Image d'illustration" height="200" class=" border-info">
                @endif

                <input type="file" name="image" id="image" class="form-control" accept="image/*">

            </div>

            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
