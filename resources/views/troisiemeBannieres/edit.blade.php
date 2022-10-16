@extends('layouts.app')

@section('content')

{{-- Formulaire d'édition --}}
    <div class="container">

        <form class="custom-form" action="{{ route('troisiemeBanniere.update',['troisiemeBanniere'=>$troisiemeBanniere]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                <label for="titre">
                    Titre principal
                </label>
                <input type="text" name="titre_principal" id="titre" class="form-control" value="{{ $troisiemeBanniere->titre_principal }}">

            </div>

            <div class="form-group mt-2">

                <label for="titre_1">
                    Premier titre
                </label>
                <input type="text" class="form-control " name="titre_1" id="titre_1" value="{{ $troisiemeBanniere->titre_1 }}">

                <label for="texte_1">
                    Premier texte
                </label>
                <textarea class="form-control" name="texte_1" id="texte_1" cols="10" rows="5">{{ $troisiemeBanniere->texte_1 }}</textarea>

                <label for="image">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->url_image))

                    <img class="mx-3 mb-3" height="200px" src="{{ $troisiemeBanniere->url_image }}" alt="Image d'illustration" title="Image actuelle">

                @endif

                <input type="file" name="image" id="image" class="form-control" accept="image/*">

            </div>

            <div class="form-group mt-2">

                <label for="titre_2">
                    Deuxième titre
                </label>
                <input type="text" class="form-control " name="titre_2" id="titre_2" value="{{ $troisiemeBanniere->titre_2 }}">

                <label for="texte_2">
                    Deuxième texte
                </label>
                <textarea class="form-control" name="texte_2" id="texte_2" cols="10" rows="5">{{ $troisiemeBanniere->texte_2 }}</textarea>

                <label for="image2">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->url_image_2))

                    <img class="mx-3 mb-3" height="200px" src="{{ $troisiemeBanniere->url_image_2 }}" alt="Image d'illustration" title="Image actuelle">

                @endif

                <input type="file" name="image2" id="image2" class="form-control" accept="image/*">

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
