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
                {{-- Formulaire pour le nom --}}
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

                {{-- Fomulaire pour l'image --}}
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

            </div>

            <div class="form-group m-3">

                {{-- Checkbox pour mise en avant en page d'accueil --}}
                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input" @if($categorie->isAccueil == 1) checked = 'true'  @endif value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur l'accueil</label>
                </div>

            </div>


            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
