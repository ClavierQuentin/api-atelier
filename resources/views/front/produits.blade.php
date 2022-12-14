@include('front.components.header')
<main id="main-conteneur">

    <div aria-label="breadcrumb" class="backGroundFleur">
        <ol class="breadcrumb">
            <li class="breadcrumb-item " ><a class="" href="{{ route('accueil') }}">Accueil&nbsp;</a></li>
            <li class="breadcrumb-item "><a href="{{ route('categories') }}">Catégories&nbsp;</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $categorie->nom_categorie }}</li>
        </ol>
    </div>

    <div class="sectionProduits backGroundFleur">

        <!--TITRE DE LA CATEGORIE-->
        <div class="titreProduits">
            <h3>{{ $categorie->nom_categorie }} :</h3>
        </div>

        <!--PRODUITS-->
        <div id="cardsProduits" class="cardsProduits">

            @foreach ($produits as $produit)
                <a href="{{ route('produit.front', ['produit'=>$produit]) }}"  class="cardProduit">
                    <div class="conteneurImgProduit">
                        <img class="imgProduit" src="{{ asset('storage/'.$produit->images->first()->url) }}" alt="{{ $produit->nom_produit }}">
                    </div>
                    <label>{{ $produit->nom_produit }}</label>
                    <label>{{ $produit->prix_produit }}€</label>
                </a>
            @endforeach

        </div>
    </div>
</main>
@include('front.components.footer')
