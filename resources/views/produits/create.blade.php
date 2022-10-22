@extends('layouts.app')
@section('content')

    <div class="container">

        {{-- Formulaire de création --}}
        <form class="custom-form" action="{{ route('produit.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group m-3">

                {{-- Formulaire pour le nom --}}
                <label for="nom_produit">
                    Nom du produit
                </label>
                <input type="text" name="nom_produit" id="nom_produit" value="{{ old('nom_produit') }}" class="form-control @error('nom_produit') is-invalid @enderror">

                @error('nom_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                {{-- Editeur de texte pour description courte --}}
                <label for="editeur">
                    Courte description
                </label>
                <textarea class="form-control @error('description_courte_produit') is-invalid @enderror" name="description_courte_produit" id="editeur" cols="10" rows="5">{{ old('description_courte_produit') }}</textarea>

                @error('description_courte_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                <label for="editeur">
                    Description longue
                </label>

                {{-- Editeur de texte description longue --}}
                <textarea id="editeur" class="form-control @error('description_longue_produit') is-invalid @enderror" name="description_longue_produit"  cols="10" rows="10">{{ old('description_longue_produit') }}</textarea>

                @error('description_longue_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                {{-- Formulaire tarif --}}
                <label for="prix_produit">
                    Prix du produit
                </label>
                <input type="number" min = "1" step="0.01" name="prix_produit" id="prix_produit" value="{{ old('prix_produit') }}" class="form-control @error('prix_produit') is-invalid @enderror">

                @error('prix_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                {{-- Formulaire image --}}
                <label for="image">
                    Image d'illustration
                </label>
                <input type="file" name="image" id="image"  class="form-control" accept="image/*">

            </div>

            <div class="form-group m-3">

                {{-- Select pour catégorie --}}
                <label for="categorie_id">
                    Catégorie du produit
                </label>
                <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror">

                    <option value="0">Choisir une catégorie</option>

                    {{-- On boucle les catégories --}}
                    @foreach ($categories as $categorie)

                        {{-- Si l'id de la catégorie est dans l'url, on passe l'option en selected lorsque qu'on égalité sur la liste --}}
                        <option @if(isset($_GET['categorie']) && $_GET['categorie'] == $categorie->id) selected @endif  value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>

                        @endforeach
                </select>

                @error('categorie_id')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                 @enderror

            </div>

            <div class="form-group m-3">

                {{-- Formulaire pour URL --}}
                <label for="url_externe">
                    URL menant au site marchand s'il existe
                </label>
                <input type="url" pattern="https://.*" name="url_externe" id="url_externe" value="{{ old('url_externe') }}" class="form-control @error('url_externe') is-invalid @enderror">

                @error('url_externe')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                {{-- Checkbox pour mise en avant sur carrousel page d'accueil site vitrine --}}
                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input"  value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur la bannière de l'accueil</label>
                </div>

            </div>

            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
