@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire d'édition --}}
        <form class="custom-form" action="{{ route('premiereBanniere.update',['premiereBanniere'=>$premiereBanniere]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                {{-- Formulaire titre --}}
                <label for="titre">
                    Titre
                </label>
                <input type="text" name="titre" id="titre" class="form-control" value = "{{ $premiereBanniere->titre }}">

            </div>

            <div class="form-group mt-2">

                {{-- Editeur de texte --}}
                <label for="editeur">
                    Texte d'accueil
                </label>
                <textarea class="form-control" name="texte" id="editeur" cols="20" rows="5">{{ $premiereBanniere->texte }}</textarea>

            </div>

            <div class="form-group mt-2">

                <label for="image">
                    Image
                </label>

                {{-- Si une image est enregistrée en base on l'affiche --}}
                @if(isset($premiereBanniere->url_image))
                    <div>
                        {{-- Image --}}
                        <img class="mx-3 mb-3" height="200px" src="{{ $premiereBanniere->url_image }}" alt="Image d'illustration" title="Image actuelle">
                    </div>
                @endif

                {{-- Formulaire image --}}
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
