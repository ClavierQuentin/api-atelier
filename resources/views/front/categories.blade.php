@include('front.components.header')
<main id="main-conteneur">
    <div class="sectionProduits backGroundFleur">
        <!--TITRE DE LA PAGE-->
        <div class="titreProduits">
            <h3>Toutes les catégories :</h3>
        </div>
        <!--LISTING CATEGORIES-->
        <div id="cardsProduits" class="cardsProduits">
            @foreach ($categories as $categorie)
                <!--CARD CATEGORIE-->
                <a href="{{ route('produits',['categorie'=>$categorie]) }}" onclick="" class="card">
                    <!--IMAGE-->
                    <div class="conteneurImgCard">
                        <?php
                        $image = DB::select('select * from images where id = ?', [$categorie->image_id]);
                        $url = $image[0]->url;
                        ?>
                        <img class="imgCardProduit" src="{{ asset('storage/'.$url) }}" alt="{{ $categorie->nom_categorie }}">
                    </div>
                    <!--NOM CATEGORIE-->
                    <label>{{ $categorie->nom_categorie }}</label>
                </a>
            @endforeach
        </div>
    </div>

</main>
@include('front.components.footer')
