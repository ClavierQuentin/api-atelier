@include('front.components.header')
<main id="main-conteneur">
    <div aria-label="breadcrumb" class="backGroundFleur">
        <ol class="breadcrumb">
            <li class="breadcrumb-item " ><a class="" href="{{ route('accueil') }}">Accueil&nbsp;</a></li>
            <li class="breadcrumb-item active" aria-current="page">A propos</li>
        </ol>
    </div>
    <!-----------------BANNIERE QUI JE SUIS--------------------->
    <div class="banniere quiJeSuis backGroundFleur">
        <div class="divTexte">
            <!--TITRE-->
            <h2>{{ $premiereBanniere->titre }}</h2>
            <!--TEXTE-->
            {!! $premiereBanniere->texte !!}
        </div>
        <!--IMAGE-->
        <div class="portrait">
            <?php
            $image = DB::select('select * from images where id = ?', [$premiereBanniere->image_id]);
            $url = $image[0]->url;
            ?>
            <img src="{{asset('storage/'.$url)}}" alt="{{ $premiereBanniere->titre }}">
        </div>
    </div>
    <!---------------------------------BANNIERE LIEU-------------------------------->
    <div class="lieu whiteFont banniere">
        <!--CARROUSEL-->
        <div class="conteneurCarrousel" id="conteneurCarrousel">
            <div id="carrouselPrez" class="carrousel">
                @foreach ($deuxiemeBanniere->images as $image)
                    <img src="{{ asset('storage/'.$image->url) }}" alt="" class="tailleImg">
                @endforeach
            </div>
        </div>
        <!--TEXTE-->
        <div class="divTexte">
            <h2>{{ $deuxiemeBanniere->titre }}</h2>
            {!! $deuxiemeBanniere->texte !!}
        </div>
    </div>
    <!------------------------------------BANNIERE VALEURS----------------------------------->
    <div class="backGroundFleur">
        <div>
            <!--TITRE-->
            <h2 class="titreValeurs" >{{ $troisiemeBanniere->titre_principal }}</h2>
            <div class="banniere " style="padding-top: 20px; padding-bottom: 10%">
                <div class="divTexte">
                    <!--TITRE-->
                    <h2>{{ $troisiemeBanniere->titre_1 }}</h2>
                    <!--TEXTE-->
                    {!! $troisiemeBanniere->texte_1 !!}
                </div>
                <!--IMAGE-->
                <div>
                    <?php
                    $image = DB::select('select * from images where id = ?', [$troisiemeBanniere->image_id]);
                    $url = $image[0]->url;
                    ?>
                    <img class="paysage" src="{{ asset('storage/'.$url) }}" alt="{{ $troisiemeBanniere->titre_1 }}">
                </div>
            </div>
        </div>
        <div class="banniere wrapReverse" style="padding-bottom: 80px;">
            <!--IMAGE-->
            <div>
                <?php
                $image2 = DB::select('select * from images where id = ?', [$troisiemeBanniere->image_id_2]);
                $url2 = $image2[0]->url;
                ?>

                <img class="imgDeuxBanDeux" style=" height:500px;" src="{{ asset('storage/'.$url2) }}" alt="{{ $troisiemeBanniere->titre_2 }}">
            </div>
            <div class="divTexte">
                <!--TITRE-->
                <h2>{{ $troisiemeBanniere->titre_2 }}</h2>
                <!--TEXTE-->
                {!! $troisiemeBanniere->texte_2 !!}
            </div>
        </div>
    </div>
<script>
    let imgs = document.getElementsByClassName('tailleImg');
    let largeurCarrouselPrez = 333;
    let carrouselPrez = document.getElementById('carrouselPrez');
    //Initialisation d'un compteur pour suivre les positions des images
    let compteurPrez = 1;
    //Fonction pour le slide du carrousel
    function slide(){
        //Si on arrive sur la dernière image
        if(compteurPrez == imgs.length){
            //On met le compteur à 0
            compteurPrez = 0;
        }
        //On translate de la largeur du carrou multipplié par la position de l'image
        carrouselPrez.style.transform = 'translateX(-' + largeurCarrouselPrez * compteurPrez + 'px)';
        //Incrémentation de compteur
        compteurPrez++;
    }
    //setInterval pour lancer la fonction toutes les 6s
    setInterval(slide,6000);
</script>
</main>
@include('front.components.footer')
