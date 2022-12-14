@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ route('produit.create') }}" class="btn btn-success  m-3">Ajouter un nouveau produit</a>

        {{-- Fenetre de message d'erreur --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex flex-wrap">

            {{-- Controle du nombre d'entrées --}}
            @if(isset($produits) && sizeof($produits) > 0)

            {{-- On parcours les entrées --}}
                @foreach ($produits as $produit)

                    <div class="card border-info m-3 p-1" style="width: 400px !important;">

                        {{-- Menu déroulant pour icones update et delete --}}
                        <ul class="navbar-nav">

                            <li class="nav-item dropdown custom-btn">

                                <a id="navbarDropdown" class="" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('assets/menu.svg') }}" alt="icone menu" height="35px">
                                </a>

                                <div style="min-width: 0;" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    {{-- Bouton d'édition --}}
                                    <a href="{{ route('produit.edit',['produit'=>$produit]) }}" class="menu-link-edit">
                                        <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                    </a>

                                    {{-- Bouton de suppression --}}
                                    <form action="{{ route('produit.delete',['produit'=>$produit]) }}" method="POST">
                                        @csrf
                                        @method('delete')

                                        <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                    </form>

                                </div>

                            </li>

                        </ul>

                        {{-- Image --}}
                        <img class="card-img-top" src="{{ asset('storage/'.$produit->images->first()->url) }}" alt="Image de produit">

                        <div class="card-body overflow-auto" style="height: 250px !important;">
                            <h5 class="card-title text-center text-info">{{ $produit->nom_produit }}</h5>

                            <p>
                                <h6 class="text-center">Description courte :</h6>
                                {{ $produit->description_courte_produit }}
                            </p>

                        </div>

                        {{-- Tarif --}}
                        <div class="card-footer">
                            <p>
                                Tarif indiqué : {{ $produit->prix_produit }}€
                            </p>
                        </div>

                    </div>

                @endforeach

            @else

                <div class="border border-danger text-center m-4 p-1">
                    <p>Il n'y a aucun produit à afficher</p>
                </div>

            @endif

        </div>

    </div>

@endsection
