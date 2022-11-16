<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8: text/javascript">
    <meta http-equiv="Content-Language" content="fr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Création des accessoires en tissus, pour les femmes ou bien pour la maison. 100% Bocage, 100% Normand.">

    <!-- Open Graph meta (Facebook, Linkedin) -->
    <meta property="og:title" content="Atelier Ginette, création textiles" />
    <meta property="og:type" content="article" />
    <meta property="og:description" content="Création des accessoires en tissus, pour les femmes ou bien pour la maison. 100% Bocage, 100% Normand." />
    <meta property="author" content="atelierginette" />
    <meta property="og:image" content="img/prez/Atelier ginette artisanat couture fait main.jpg" />

    <!-- Pages CSS -->
    <link rel="stylesheet" href="{{ asset('css/mainFront.css') }}"> <!--PAGE CSS GLOBALE-->
    <link rel="stylesheet" href="{{ asset('css/produits.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">

    <link rel="stylesheet" href="{{ asset('css/splide-skyblue.min.css') }}">

    <!-- Scripts externes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <script src="{{ asset('js/splide.min.js') }}"></script>


    <!-- Script google pour recaptcha -->
   <script src="https://www.google.com/recaptcha/api.js?render=6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y"></script>
   {{-- <script src="https://www.google.com/recaptcha/api.js"></script> --}}



    <title>Atelier Ginette</title>
</head>

<body>
    <!-- Elements HTML pour une futur vente en ligne -->
    <!-- Bloc panier -->
    <!--<div id="panier" class="panier">
        <h3>Panier</h3>
        <hr>
        <div id="emptyBasket" class="divPanier"></div>
        <button class='background' onclick="document.location.hash = '/pages/panier'">Accéder au panier</button>
    </div>-->
    <!-------------------------------------------------TITRE ET MENU----------------------------------------->
    <!--BLOC TITRE-->
    <div id="conteneurName" class="conteneurName">
        <a href="{{ route('accueil') }}"><h1 id="name" class="name whiteFont">Atelier Ginette</h1></a>
    </div>
    <!--BLOC MENU-->
    <div class="divMenu" id="divMenu">
        <div class="menu" id="menu">
        </div>
    </div>
    <!-- Icone panier -->
    <!--<div id="blocPanier" class="blocPanier whiteFont">
        <img width="40px" src="./img/icons8-shopping-trolley-64.png" alt="">
    </div>-->
    <!----------------------------------------------PAGE DE NAVIGATION------------------------------------------------------------------>
    <nav>
            <p>
                <a href="{{ route('accueil') }}" class="whiteFont links">ACCUEIL</a>
                <a href="{{ route('about') }}" class="whiteFont links">A PROPOS</a>
                <a href="{{ route('categories') }}" class="whiteFont links">NOS PRODUITS</a>
                <a href="https://www.etsy.com/fr/shop/AtelierGinette?ref=shop_sugg" target="_blank" class="whiteFont">POINTS DE VENTE</a>
                <a href="{{ route('contact') }}" class="whiteFont links">CONTACT</a>
            </p>
    </nav>
