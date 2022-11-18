@include('front.components.header')
<main id="main-conteneur">

    <div aria-label="breadcrumb" class="backGroundFleur">
        <ol class="breadcrumb">
            <li class="breadcrumb-item " ><a class="" href="{{ route('accueil') }}">Accueil&nbsp;</a></li>
            <li class="breadcrumb-item "><a href="{{ route('categories') }}">Catégories&nbsp;</a></li>
            <li class="breadcrumb-item "><a href="{{ route('produits',['categorie'=>$produit->categorie_id]) }}">{{ $produit->categorie->nom_categorie }}&nbsp;</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produit->nom_produit }}</li>
        </ol>
    </div>
    <div class="backGroundFleur">

            <div class="sectionPhoto">
                <div>
                    <section id="main-carousel" class="splide" aria-label="My Awesome Gallery">
                        <div class="splide__track">
                        <ul class="splide__list">
                                @foreach ($produit->images as $image)
                                    <li class="splide__slide">
                                        <img src="{{ asset('storage/'.$image->url) }}" alt="">
                                    </li>
                                @endforeach
                        </ul>
                        </div>
                    </section>


                    <ul id="thumbnails" class="thumbnails">
                        @foreach ($produit->images as $image)
                        <li class="thumbnail">
                            <img src="{{ asset('storage/'.$image->url) }}" alt="">
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="description1">

                    <!--NOM ET PRIX-->
                    <h2>{{ $produit->nom_produit }}</h2>
                    <div class="prix">
                        <p>
                            {{ $produit->prix_produit }}€ l'unité
                        </p>
                    </div>

                    <!--DESCRIPTION COURTE-->
                    <div class="descriptionCourte">
                        {!! $produit->description_courte_produit !!}
                    </div>

                    <div>
                        @if($produit->url_externe != "#")
                            <button class="background" id="boutonAjouter"><a class="whiteFont"  href="{{ $produit->url_externe }}">Voir sur le site marchand</a></button>
                        @endif
                    </div>

                </div>

            </div>

            <hr>

            <!--DESCRIPTION LONGUE-->
            <div class="compo">
                {!! $produit->description_longue_produit !!}
            </div>

            <div id ="equivalence">
            <!--BLOC PRODUIT EQUIVALENT-->
                @if(sizeof($produits) > 0)
                    <hr>
                    <h3 class="titreProduitEquivalent">Vous pourriez aussi aimer :</h3>
                    <div class="produits">
                        @foreach ($produits as $produit)
                            <div class="produitEquivalent">
                                <div class="labels">
                                    <label>{{ $produit->nom_produit }}</label>
                                    <label>{{ $produit->prix_produit }}€</label>
                                </div>

                                <a  href="{{ route('produit.front', ['produit'=>$produit]) }}" >
                                    <div class="conteneurImgProduitEquivalent">
                                        <img class="imgProduitEquivalent" src="{{ asset('storage/'.$produit->images->first()->url) }}" alt="{{ $produit->nom_produit }}">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
</main>

<script>

var splide = new Splide( '#main-carousel', {
  pagination: false,
  width: '40vw',
  height: '50vh',
  speed: 900,
  rewind: true
} );


var thumbnails = document.getElementsByClassName( 'thumbnail' );
var current;


for ( var i = 0; i < thumbnails.length; i++ ) {
  initThumbnail( thumbnails[ i ], i );
}


function initThumbnail( thumbnail, index ) {
  thumbnail.addEventListener( 'click', function () {
    splide.go( index );
  } );
}


splide.on( 'mounted move', function () {
  var thumbnail = thumbnails[ splide.index ];


  if ( thumbnail ) {
    if ( current ) {
      current.classList.remove( 'is-active' );
    }


    thumbnail.classList.add( 'is-active' );
    current = thumbnail;
  }
} );


splide.mount();
</script>
@include('front.components.footer')
