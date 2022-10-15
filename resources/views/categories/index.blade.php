@extends('layouts.app')

@section('content')

    <div class="container d-flex flex-wrap">

        {{-- Fenetre d'erreur --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Si des cat�gories existent --}}
        @if(sizeof($categories) > 0)

            {{-- On parcours toutes les entr�es --}}
            @foreach ($categories as $categorie)

                <div class="card border-info m-3 p-1" style="width: 18rem;">

                    {{-- Menu d�roulant pour icones update et delete --}}
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown custom-btn">

                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                ...
                            </a>

                            <div style="min-width: 0;" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                {{-- Bouton d'�dition --}}
                                <a href="{{ route('categorie.edit',['categorie'=>$categorie]) }}" class="menu-link-edit">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'�dition" title="Mettre � jour">
                                </a>

                                {{-- Bouton de suppression --}}
                                <form action="{{ route('categorie.delete',['categorie'=>$categorie]) }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>

                            </div>

                        </li>

                    </ul>

                    {{-- Image --}}
                    <img class="card-img-top" src="{{ $categorie->url_image_categorie }}" alt="Image d'illustration" title="Image d'illustration">

                    <div class="card-body">

                        <h5 class="card-title text-info">{{ $categorie->nom_categorie }}</h5>

                    </div>

                    <div class="card-footer">

                        <a href="{{ route('categorie.produits',['categorie'=>$categorie]) }}" class="nav-link">Voir les produits affili�s</a>

                    </div>

                </div>

            @endforeach

        @else

            <div class=" border border-danger text-center m-4">
                Il n'y a aucune cat�gorie � afficher
            </div>

        @endif

    </div>

@endsection
