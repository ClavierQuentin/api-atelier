@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('categorie.create') }}" class="btn btn-success  m-3">Ajouter une nouvelle catégorie</a>

        {{-- Fenetre d'erreur --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    </div>

    <div class="container d-flex flex-wrap">



        {{-- Si des catégories existent --}}
        @if(isset($categories) && sizeof($categories) > 0)

            {{-- On parcours toutes les entrées --}}
            @foreach ($categories as $categorie)

                <div class="card border-info m-3 p-1" style="width: 18rem;">

                    {{-- Menu déroulant pour icones update et delete --}}
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown custom-btn">

                            <a id="navbarDropdown" class="" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ asset('assets/menu.svg') }}" alt="icone menu" height="35px">
                            </a>

                            <div style="min-width: 0;" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                {{-- Bouton d'édition --}}
                                <a href="{{ route('categorie.edit',['categorie'=>$categorie]) }}" class="menu-link-edit">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
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

                        {{-- Lien pour afficher les produits de la catégorie (categorie_id en paramètre d'url) --}}
                        <a href="{{ route('categorie.produits',['categorie'=>$categorie]) }}" class="nav-link">Voir les produits affiliés</a>

                    </div>

                </div>

            @endforeach

        @else

            <div class=" border border-danger text-center m-4 p-1">
                Il n'y a aucune catégorie à afficher
            </div>

            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a href="{{ route('categorie.create') }}" class="nav-link border d-inline m-2 p-1">Créer des nouvelles entrées</a>
                </li>
            </ul>


        @endif

    </div>

@endsection

