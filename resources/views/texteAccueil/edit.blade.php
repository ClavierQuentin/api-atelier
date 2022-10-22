@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire d'édition --}}
        <form class="custom-form" action="{{ route('texteAccueil.update',['texteAccueil'=>$texteAccueil]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                {{-- Titre --}}
                <label for="titre_accueil">Titre </label>
                <input type="text" name="titre_accueil" id="titre_accueil" class="form-control @error('titre_accueil') is-invalid @enderror" value = "{{ $texteAccueil->titre_accueil }}">

                @error('titre_accueil')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Editeur de texte --}}
                <label for="editeur">Texte d'accueil</label>
                <textarea class="form-control @error('texte_accueil') is-invalid @enderror" name="texte_accueil" id="editeur" cols="30" rows="10">{{ $texteAccueil->texte_accueil }}</textarea>

                @error('texte_accueil')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Titre bannière catégorie --}}
                <label for="titre_categories">Titre champs Catégories</label>
                <input type="text" name="titre_categories" id="titre_categories" class="form-control @error('titre_categories') is-invalid @enderror" value = "{{ $texteAccueil->titre_categories }}">

                @error('titre_categories')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
