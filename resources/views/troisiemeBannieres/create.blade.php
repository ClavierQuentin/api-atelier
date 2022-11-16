@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <div class="container">

        <form class="custom-form" action="{{ route('troisiemeBanniere.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">

                {{-- Titre principal --}}
                <label for="titre_principal">
                    Titre principal
                </label>
                <input type="text" name="titre_principal" id="titre_principal" class="form-control @error('titre_principal') is-invalid @enderror" value="{{ old('titre_principal') }}">

                @error('titre_principal')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Titre 1 --}}
                <label for="titre_1">
                    Premier titre
                </label>
                <input type="text" class="form-control @error('titre_1') is-invalid @enderror" name="titre_1" id="titre_1" value="{{ old('titre_1') }}">

                @error('titre_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Editeur de texte pour texte 1 --}}
                <label for="editeur">
                    Premier texte
                </label>
                <textarea class="form-control @error('texte_1') is-invalid @enderror" name="texte_1" id="editeur" cols="10" rows="5">{{ old('texte_1') }}</textarea>

                @error('texte_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Image 1 --}}
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

                @include('modal.index_image')

            </div>

            <div class="form-group mt-2">

                {{-- Titre 2 --}}
                <label for="titre_2">
                    Deuxième titre
                </label>
                <input type="text" class="form-control @error('titre_2') is-invalid @enderror" name="titre_2" id="titre_2" value="{{ old('titre_2') }}">

                @error('titre_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Editeur de texte pour texte 2 --}}
                <label for="editeur">
                    Deuxième texte
                </label>
                <textarea class="form-control @error('texte_2') is-invalid @enderror" name="texte_2" id="editeur" cols="10" rows="5">{{ old('texte_2') }}</textarea>

                @error('texte_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Image 2 --}}
               {{-- Formulaire pour l'image --}}
               <label for="image">
                Télécharger une nouvelle image
                </label>
                <input type="file" name="imageDL2"  class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif


                <p>Ou</p>

                {{-- Choix image existante --}}
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalImage2">Choisir une image existante</a>
                <div id="containerImage2"></div>
                @include('troisiemeBannieres.modal.index')
                
            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
