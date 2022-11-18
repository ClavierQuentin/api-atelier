<style>
    .conteneurName{
        position: absolute;
    }
</style>

@include('front.components.header')
<main id="main-conteneur">
    <header class="whiteFont">

        <div id="conteneur" class="conteneur">
            <div id="carrousel" class="carrouselAccueil">
                @foreach ($carrousels as $carrousel)
                    <div class="conteneurNew" style="background-image: url({{ asset('storage/'.$carrousel->image->url) }})">
                        <div class="contenu">
                            {!! $carrousel->texte !!}
                        </div>
                        <button class="background" id="boutonNouveaute" onclick='window.location = "{{ $carrousel->url }}"'>{{ $carrousel->bouton }}</button>
                    </div>
                @endforeach
            </div>
        </div>

    </header>
<!---------------------------------BANNIERE PRESENTATION------------------------>

    <div class="prez ">
                <!--TITRE-->
        <h2 class="whiteFont">{{ $texteAccueil->titre_accueil }}</h2>
    </div>

    <!--TEXTE-->
    <div class="banniereCitation whiteFont">
        {!! $texteAccueil->texte_accueil !!}
    </div>

    <!-------------------------------------BANNIERE CATEGORIES---------------------------------------->

<div class="backGroundFleur">

    <div class="decouvrir">
        <!--TITRE-->
        <h2>{{ $texteAccueil->titre_categories }}</h2>
    </div>

    <div class="categories">
        @foreach ($categories as $categorie)
        <?php
        $image = DB::select('select * from images where id = ?', [$categorie->image_id]);
        $url = $image[0]->url;
        ?>
                <!--CATEGORIE-->
                <a href="{{ route('produits',['categorie'=>$categorie->id]) }}" >
                    <div>
                        <div class="divImg">
                            <img class="imgCategorie" src="{{asset('storage/'.$url)}}" alt="{{ $categorie->nom_categorie }}">
                        </div>
                        <label>{{ $categorie->nom_categorie }}</label>
                    </div>
                </a>
                <!---->
        @endforeach
    </div>
</div>

<!----------------------------------BANNIERE PICTOS---------------------------------------->

<div class="bannierePicto">

    <div>
        <img src="{{ asset('assets/hand-made.png') }}" alt="Icone fait main">
        <label class="whiteFont">Fait maison</label>
    </div>

    <div>
        <img src="{{ asset('assets/icons8-machine-à-coudre-80.png') }}" alt="Icone machie a coudre">
        <label class="whiteFont">Produits artisanaux</label>
    </div>

    <div>
        <img src="{{ asset('assets/ecologique.png') }}" alt="icone écologie">
        <label class="whiteFont">Eco-responsable</label>
    </div>

</div>

</main>

<script>



let array = document.getElementsByClassName('conteneurNew');


//On récupère l'élément carrousel dans html
let carrousel = document.getElementById('carrousel');

//On récupère la largeur de l'écran de l'utilisateur
let largeurEcran = screen.width;



//On appelle un compteur pour suivre la position des images
let compteur = 1;

//On créer la fonction slide du carrousel
function slide(){

    //Si est arrivé à la dernière image
    if(compteur == array.length){
        //On remet le compteur à 0
        compteur = 0;
    }

    //On translate le carrousel selon la largeur de l'écran et multiplié par le compteur (position de l'image)
    carrousel.style.transform = 'translateX(-' +largeurEcran*compteur+'px)';
    //On incrémente compteur
    compteur++;
}

//setInterval nous permet de lancer slide toutes les 6s
setInterval(slide,6000);

</script>
@include('front.components.footer')
