@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>Médiathèque</h2>

        <a href="{{ route('image.create') }}" class="btn btn-success  m-3">Ajouter une nouvelle image</a>

        <div class="d-flex flex-wrap">

            {{-- Parcours du tableau d'urls --}}
            @foreach ($images as $image)


                <div class="border border-info p-1 m-2 " style="position: relative;">

                    {{-- Image --}}
                    <img height="200px" src="{{ asset('storage/'.$image->url) }}" alt="Image d'illustration" title="Image actuelle">

                        {{-- Lien + icone pour suppression de l'image séléctionnée --}}
                        <a href="{{ route('image.delete',['image'=>$image]) }}" class="trash custom-btn"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></a>

                </div>

            @endforeach

        </div>

    </div>

@endsection
