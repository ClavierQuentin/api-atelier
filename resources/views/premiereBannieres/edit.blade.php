@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire d'édition --}}
        <form class="custom-form" action="{{ route('premiereBanniere.update',['premiereBanniere'=>$premiereBanniere]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                {{-- Formulaire titre --}}
                <label for="titre">
                    Titre
                </label>
                <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value = "{{ $premiereBanniere->titre }}">

                @error('titre')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Editeur de texte --}}
                <label for="editeur">
                    Texte d'accueil
                </label>
                <textarea class="form-control @error('texte') is-invalid @enderror" name="texte" id="editeur" cols="20" rows="5">{{ $premiereBanniere->texte }}</textarea>

                @error('texte')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                <label for="image">
                    Image
                </label>

                {{-- Si une image est enregistrée en base on l'affiche --}}
                @if(isset($premiereBanniere->image_id))
                <?php
                $image = DB::select('select * from images where id = ?', [$premiereBanniere->image_id]);
                $url = $image[0]->url;
                ?>

                    <div class="d-flex">
                        <div class="border border-info p-1 m-2 ">
                            {{-- Image --}}
                            <img height="200px" src="{{ asset('storage/'.$url) }}" alt="Image d'illustration" title="Image actuelle">
                        </div>
                    </div>
                @endif

                <label for="imageDL">Télécharger une nouvelle image</label>
                {{-- Fomulaire pour l'image --}}
                <input type="file" name="imageDL" class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*">

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
