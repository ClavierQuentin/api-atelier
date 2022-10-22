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
                <input type="text" name="titre_principal" id="titre_principal" class="form-control" value="{{ $troisiemeBanniere->titre_principal }}">

            </div>

            <div class="form-group mt-2">

                {{-- Titre 1 --}}
                <label for="titre_1">
                    Premier titre
                </label>
                <input type="text" class="form-control " name="titre_1" id="titre_1" value="{{ $troisiemeBanniere->titre_1 }}">

                {{-- Editeur de texte pour texte 1 --}}
                <label for="editeur">
                    Premier texte
                </label>
                <textarea class="form-control" name="texte_1" id="editeur" cols="10" rows="5">{{ $troisiemeBanniere->texte_1 }}</textarea>

                <label for="image">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->url_image))
                    <div class="d-flex">
                        <div class="border border-info p-1 m-2">
                            <img  height="200px" src="{{ $troisiemeBanniere->url_image }}" alt="Image d'illustration" title="Image actuelle">
                        </div>
                    </div>

                @endif

                {{-- Formulaire File --}}
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

            </div>

            <div class="form-group mt-2">

                {{-- Titre 2 --}}
                <label for="titre_2">
                    Deuxième titre
                </label>
                <input type="text" class="form-control " name="titre_2" id="titre_2" value="{{ $troisiemeBanniere->titre_2 }}">

                {{-- Editeur de texte pour texte 2 --}}
                <label for="editeur">
                    Deuxième texte
                </label>
                <textarea class="form-control" name="texte_2" id="editeur" cols="10" rows="5">{{ $troisiemeBanniere->texte_2 }}</textarea>

                <label for="image2">
                    Image
                </label>

                {{-- Si une image existe en base, on l'affiche --}}
                @if(isset($troisiemeBanniere->url_image_2))

                    <div class="d-flex">
                        <div class="border border-info m-2 p-1">
                            {{-- Image 2--}}
                            <img height="200px" src="{{ $troisiemeBanniere->url_image_2 }}" alt="Image d'illustration" title="Image actuelle">
                        </div>
                    </div>

                @endif

                {{-- Formulaire FILE --}}
                <input type="file" name="image2" id="image2" class="form-control" accept="image/*">

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
