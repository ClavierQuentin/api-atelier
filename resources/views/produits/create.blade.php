@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="" method="POST" style="width: 50%;" class="m-auto" enctype="multipart/form-data">

            @csrf

            <div class="form-group m-3">
                <label for="nom_produit">Nom du produit</label>
                <input type="text" name="nom_produit" id="nom_produit" value="{{ old('nom_produit') }}" class="form-control @error('nom_produit') is-invalid @enderror">
                @error('nom_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group m-3">
                <label for="description_courte_produit">Courte description</label>
                <textarea class="form-control @error('description_courte_produit') is-invalid @enderror" name="description_courte_produit" id="description_courte_produit" cols="10" rows="5">{{ old('description_courte_produit') }}</textarea>
                @error('description_courte_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group m-3">
                <label for="description_longue_produit">Description longue</label>
                <textarea class="form-control @error('description_longue_produit') is-invalid @enderror" name="description_longue_produit" id="description_longue_produit" cols="10" rows="10">{{ old('description_longue_produit') }}</textarea>
                @error('description_longue_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group m-3">
                <label for="prix_produit">Prix du produit</label>
                <input type="number" min = "1" step="0.01" name="prix_produit" id="prix_produit" value="{{ old('prix_produit') }}" class="form-control @error('prix_produit') is-invalid @enderror">
                @error('prix_produit')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group m-3">
                <label for="url_image_produit">Image d'illustration</label>
                <input type="file" name="url_image_produit" id="url_image_produit"  class="form-control" accept="image/*">
            </div>

            <div class="form-group m-3">
                <label for="categorie_id">Cat�gorie du produit</label>
                <select name="categorie_id" id="categorie_id" class="form-select @error('categorie_id') is-invalid @enderror">
                    @foreach ($categories as $categorie)
                        <option @if(isset($_GET['categorie']) && $_GET['categorie'] == $categorie->id) selected @endif  value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>
                    @endforeach
                </select>
                @error('categorie_id')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                 @enderror

            </div>

            <div class="form-group m-3">
                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input"  value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur la banni�re de l'accueil</label>
                </div>
            </div>

            <button class="btn btn-info m-2">Valider</button>
        </form>
    </div>

@endsection
