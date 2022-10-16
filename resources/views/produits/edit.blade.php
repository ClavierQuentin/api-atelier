@extends('layouts.app')

@section('content')

    <div class="container">

        <form action="{{ route('produit.update',['produit'=>$produit]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
            @csrf
            @method('put')

            <div class="form-group m-3">

                <label for="nom_produit">
                    Nom du produit
                </label>
                <input type="text" name="nom_produit" id="nom_produit" value="{{ $produit->nom_produit }}" class="form-control @error('nom_produit') is-invalid @enderror">

                @error('nom_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                <label for="description_courte_produit">
                    Courte description
                </label>
                <textarea class="form-control @error('description_courte_produit') is-invalid @enderror" name="description_courte_produit" id="description_courte_produit" cols="10" rows="5">{{ $produit->description_courte_produit }}</textarea>

                @error('description_courte_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                <label for="description_longue_produit">
                    Description longue
                </label>
                <textarea class="form-control @error('description_longue_produit') is-invalid @enderror" name="description_longue_produit" id="description_longue_produit" cols="10" rows="10">{{ $produit->description_longue_produit }}</textarea>

                @error('description_longue_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                <label for="prix_produit">
                    Prix du produit
                </label>
                <input type="number" min = "1" step="0.01" name="prix_produit" id="prix_produit" value="{{ $produit->prix_produit }}" class="form-control @error('prix_produit') is-invalid @enderror">

                @error('prix_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group m-3">

                <label for="url_image_produit">
                    Image d'illustration
                </label>

                {{-- Si une image est enregistrée en base, on l'affiche --}}
                @if(isset($produit->url_image_produit))
                    <img src="{{ $produit->url_image_produit }}" alt="Image d'illustration" height="200" class=" border-info">
                @endif

                <input type="file" name="url_image_produit" id="url_image_produit"  class="form-control" accept="image/*">

            </div>

            <div class="form-group m-3">

                <label for="categorie_id">
                    Catégorie du produit
                </label>
                <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror">

                    @foreach ($categories as $categorie)
                        <option @if($categorie->id == $produit->categorie_id) selected @endif  value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>
                    @endforeach

                </select>

                @error('categorie_id')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                 @enderror

            </div>

            <div class="form-group m-3">

                <label for="url_externe">
                    URL menant au site marchand s'il existe
                </label>
                <input type="url" pattern="https://.*" name="url_externe" id="url_externe" value="@if(isset($produit->url_externe)) {{ $produit->url_externe }} @endif" class="form-control @error('url_externe') is-invalid @enderror">

                @error('url_externe')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input" @if($produit->isAccueil == 1) checked = 'true'  @endif value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur la bannière de l'accueil</label>

                </div>
            </div>

            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
