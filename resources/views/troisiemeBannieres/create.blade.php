@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <div class="container">

        <form class="custom-form" action="{{ route('troisiemeBanniere.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">

                <label for="titre">
                    Titre principal
                </label>
                <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}">

                @error('titre')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                <label for="titre_1">
                    Premier titre
                </label>
                <input type="text" class="form-control @error('titre_1') is-invalid @enderror" name="titre_1" id="titre_1" value="{{ old('titre_1') }}">

                @error('titre_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="texte_1">
                    Premier texte
                </label>
                <textarea class="form-control @error('texte_1') is-invalid @enderror" name="texte_1" id="texte_1" cols="10" rows="5">{{ old('texte_1') }}</textarea>

                @error('texte_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="image">
                    Image
                </label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

            </div>

            <div class="form-group mt-2">

                <label for="titre_2">
                    Deuxième titre
                </label>
                <input type="text" class="form-control @error('titre_2') is-invalid @enderror" name="titre_2" id="titre_2" value="{{ old('titre_2') }}">

                @error('titre_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="texte_2">
                    Deuxième texte
                </label>
                <textarea class="form-control @error('texte_2') is-invalid @enderror" name="texte_2" id="texte_2" cols="10" rows="5">{{ old('texte_2') }}</textarea>

                @error('texte_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="image2">
                    Image
                </label>
                <input type="file" name="image2" id="image2" class="form-control" accept="image/*">

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
