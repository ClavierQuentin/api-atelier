@extends('layouts.app')

@section('content')

{{-- Formulaire d'édition --}}
    <div class="container">

        <form class="custom-form" action="{{ route('troisiemeBanniere.update',['troisiemeBanniere'=>$troisiemeBanniere]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                {{-- Titre principal --}}
                <label for="titre_principal">
                    Titre principal
                </label>
                <input type="text" name="titre_principal" id="titre_principal" class="form-control @error('titre_principal') is-invalid @enderror" value="{{ $troisiemeBanniere->titre_principal }}">

                @error('titre_principal')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group mt-2">

                {{-- Titre 1 --}}
                <label for="titre_1">
                    Premier titre
                </label>
                <input type="text" class="form-control @error('titre_1') is-invalid @enderror" name="titre_1" id="titre_1" value="{{ $troisiemeBanniere->titre_1 }}">

                @error('titre_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Editeur de texte pour texte 1 --}}
                <label for="editeur">
                    Premier texte
                </label>
                <textarea class="form-control  @error('texte_1') is-invalid @enderror" name="texte_1" id="editeur" cols="10" rows="5">{{ $troisiemeBanniere->texte_1 }}</textarea>

                @error('texte_1')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="image">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->image_id))
                <?php
                $image = DB::select('select * from images where id = ?', [$troisiemeBanniere->image_id]);
                $url = $image[0]->url;
                ?>
                    <div class="d-flex">
                        <div class="border border-info p-1 m-2">
                            <img  height="200px" src="{{ asset('storage/'.$url) }}" alt="Image d'illustration" title="Image actuelle">
                        </div>
                    </div>

                @endif

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
                <input type="text" class="form-control @error('titre_2') is-invalid @enderror" name="titre_2" id="titre_2" value="{{ $troisiemeBanniere->titre_2 }}">

                @error('titre_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                {{-- Editeur de texte pour texte 2 --}}
                <label for="editeur">
                    Deuxième texte
                </label>
                <textarea class="form-control @error('texte_2') is-invalid @enderror" name="texte_2" id="editeur" cols="10" rows="5">{{ $troisiemeBanniere->texte_2 }}</textarea>

                @error('texte_2')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

                <label for="image2">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->image_id_2))
                <?php
                $image2 = DB::select('select * from images where id = ?', [$troisiemeBanniere->image_id_2]);
                $url2 = $image2[0]->url;
                ?>

                    <div class="d-flex">
                        <div class="border border-info m-2 p-1">
                            {{-- Image 2--}}
                            <img height="200px" src="{{ asset('storage/'.$url2) }}" alt="Image d'illustration" title="Image actuelle">
                        </div>
                    </div>

                @endif

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
