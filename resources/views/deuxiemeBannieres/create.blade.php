@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <div class="container">

        <form class="custom-form" action="{{ route('deuxiemeBanniere.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">

                <label for="titre">
                    Titre
                </label>
                {{-- Formulaire pour le titre  de la banniere --}}
                <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}">

                @error('titre')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                <label for="editeur">
                    Texte
                </label>
                {{-- Editeur de texte --}}
                <textarea class="form-control @error('texte') is-invalid @enderror" name="texte" id="editeur" cols="10" rows="5">{{ old('texte') }}</textarea>

                @error('texte')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                <label for="image">
                    Télécharger des nouvelles images
                </label>
                {{-- Formulaire pour l'image --}}
                <input type="file" name="imageDL[]" class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*" multiple>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <p>Ou</p>

                {{-- Choix image existante --}}
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalImage">Choisir une image existante</a>
                <div id="containerImage" class="d-flex flex-wrap"></div>
                @include('modal.index_array')

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
