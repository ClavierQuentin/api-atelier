@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <div class="container">

        <form class="custom-form" action="{{ route('categorie.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-goup m-2">

                <label for="nom_categorie">
                    Nom de la catégorie
                </label>
                <input type="text" name="nom_categorie" id="nom_categorie" class="form-control @error('nom_categorie') is-invalid @enderror" value="{{ old('nom_categorie') }}">

                @error('nom_categorie')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-2">

                <label for="image">
                    Image d'illustration
                </label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            </div>

            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
