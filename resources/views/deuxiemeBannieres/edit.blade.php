@extends('layouts.app')

@section('content')

    {{-- Formulaire d'édition de l'entrée --}}
    <div class="container">

        <form class="custom-form" action="{{ route('deuxiemeBanniere.update',['deuxiemeBanniere'=>$deuxiemeBanniere]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mt-2">

                <label for="titre">
                    Titre principal
                </label>
                <input type="text" name="titre" id="titre" class="form-control" value = "{{ $deuxiemeBanniere->titre }}">

            </div>

            <div class="form-group mt-2">

                <label for="editeur">
                    Texte d'accueil
                </label>
                <textarea class="form-control" name="texte" id="editeur" cols="20" rows="5">{{ $deuxiemeBanniere->texte }}</textarea>

            </div>

            <div class="form-group mt-2">

                <label for="image">
                    Images
                </label>

                {{-- Si des images sont enregistrées en base --}}
                @if(isset($deuxiemeBanniere->url_image) && sizeof($deuxiemeBanniere->getArrayFromUrlsImages()) > 0)

                    <div class="d-flex flex-wrap">

                        {{-- Parcours du tableau d'urls --}}
                        @foreach ($deuxiemeBanniere->getArrayFromUrlsImages() as $url)


                            <div class="border border-info p-1 m-2 " style="position: relative;">

                                <img height="200px" src="{{ $url }}" alt="Image d'illustration" title="Image actuelle">

                                {{-- Bouton de suppression d'une image --}}
                                {{-- <form action="{{ route('delete.image',['image'=>$deuxiemeBanniere->getNameFromUrl($url),'deuxiemeBanniere'=>$deuxiemeBanniere]) }}" method='POST'> --}}
                                    {{-- @csrf
                                    @method('put') --}}

                                    <a href="{{ url('deuxieme-banniere/delete-image/') }}/{{ $deuxiemeBanniere->id }}/{{ $deuxiemeBanniere->getNameFromUrl($url) }} " class="trash custom-btn"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></a>
                                {{-- </form> --}}

                            </div>

                        @endforeach

                    </div>

                @endif

                <input type="file" name="image[]" id="image" class="form-control" accept="image/*" multiple>

                <div class="form-check">

                    <input type="checkbox" name="deleteAllImages" id="deleteAllImages" class="form-check-input"  value="true">
                    <label for="deleteAllImages" class="form-check-label">
                        Supprimer toutes les images actuelles?
                    </label>

                </div>

            </div>

            <button class="btn btn-info mt-2">Valider</button>

        </form>

    </div>

@endsection
