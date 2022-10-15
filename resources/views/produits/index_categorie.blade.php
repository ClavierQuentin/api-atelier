@extends('layouts.app')

<style>
    .custom-btn{
        position: absolute;
        right: 0;
        margin: 0.25rem;
    }
</style>

@section('content')

<div class="container">
    <a href="{{ route('produit.create',['categorie'=>$categorie]) }}" class="btn btn-success  m-3">Ajouter un nouveau produit</a>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex flew-wrap">
        @if(sizeof($produits) > 0)
            @foreach ($produits as $produit)
                <div class="card border-info m-3 p-1" style="width: 18rem;">
                    <form action="" method="POST">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger custom-btn" data-toggle="modal" data-target="#deleteModal{{ $produit->id }}">X</button>
                    </form>
                    <img class="card-img-top" src="{{ $produit->url_image_produit }}" alt="Image de produit">
                    <div class="card-body">
                    <h5 class="card-title text-info">{{ $produit->nom_produit }}</h5>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('produit.edit',['produit'=>$produit]) }}" class="btn btn-light">Editer</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="border border-danger text-center m-4">
                <p>Il n'y a aucun produit à afficher</p>
                <a href="{{ url('/categorie') }}" class="nav-item">Revenir en arrière</a>
            </div>
        @endif
    </div>
</div>
@endsection
