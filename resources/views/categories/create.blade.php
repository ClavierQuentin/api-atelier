@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <div class="container">

        <form class="custom-form" action="{{ route('categorie.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-goup m-2">

                {{-- Formulaire pour le nom de la catégorie --}}
                <label for="nom_categorie">
                    Nom de la catégorie
                </label>
                <input type="text" name="nom_categorie" id="nom_categorie" class="form-control @error('nom_categorie') is-invalid @enderror" value="{{ old('nom_categorie') }}">

                @error('nom_categorie')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-2">

                {{-- Formulaire pour l'image --}}
                <label for="image">
                    Image d'illustration
                </label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">

                @error('image')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-3">

                {{-- Checkbox pour mettre sur la page d'accueil du site vitrine --}}
                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input @if ($errors->any()) is-invalid @endif"  value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur l'accueil</label>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>

            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
