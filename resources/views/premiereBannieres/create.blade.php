@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire de création --}}
        <form class="custom-form" action="{{ route('premiereBanniere.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">

                {{-- Formulaire titre  --}}
                <label for="titre">
                    Titre
                </label>
                <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}">

                @error('titre')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Editeur de texte --}}
                <label for="editeur">
                    Texte
                </label>
                <textarea class="form-control @error('texte') is-invalid @enderror" name="texte" id="editeur" cols="30" rows="10">{{ old('texte') }}</textarea>

                @error('texte')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

               {{-- Formulaire pour l'image --}}
               <label for="image">
                    Télécharger une nouvelle image
                </label>
                <input type="file" name="imageDL"  class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*">

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
                <div id="containerImage"></div>
                
            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

        @include('modal.index_image')

    </div>

@endsection
