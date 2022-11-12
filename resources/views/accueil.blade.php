<!DOCTYPE html>
<html lang="fr">
<head>
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
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" type="text/css">    <!--PAGE CSS GLOBALE-->
    <link rel="stylesheet" href="{{ asset('css/produits.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/accueil.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}" type="text/css">

    <!-- Scripts externes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">

    <!-- Script JS principal -->
    <script type="module" src="{{ asset(js/main.mjs) }}"></script>

    <!-- Script google pour recaptcha -->
   <script src="https://www.google.com/recaptcha/api.js?render=6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y"></script>


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
        <a href="#"><h1 id="name" class="name whiteFont">Atelier Ginette</h1></a>
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
                <a href="#" class="whiteFont links">ACCUEIL</a>
                <a href="#/pages/about" class="whiteFont links">A PROPOS</a>
                <a href="#/pages/categories" class="whiteFont links">NOS PRODUITS</a>
                <a href="https://www.etsy.com/fr/shop/AtelierGinette?ref=shop_sugg" target="_blank" class="whiteFont">POINTS DE VENTE</a>
                <a href="#/contact" class="whiteFont links">CONTACT</a>
            </p>
    </nav>
    <!--------------------------------------CONTENEUR PRINCIPAL---------------------------------->
    <main id="main-conteneur">
    </main>
    <!----------------------------------------------------FOOTER--------------------------------------------------->
    <footer>
        <!------------------------------INSCRIPTION NEWSLETTER----------------------------------------------->
        <div class="banniereReseaux whiteFont">
            <div class="emailContainer">
                <form id="newsletterForm">
                    <input name="pot" class="visually-hidden" tabindex="-1" autocomplete="off" id="pot">
                    <input type="email" name="email" id="email" placeholder="Votre adresse email">
                    <button id="newsletterBtn">S'inscrire à la newsletter</button>
                </form>
                <span id="msg"></span>
            </div>

            <!------------------------------PARTIE RESEAU SOCIAUX----------------------------------------------->
            <h4>Suivez-nous</h4>
            <a class="liens whiteFont" href="https://www.facebook.com/atelierginette" target="_blank">Facebook</a>
            <a class="liens whiteFont" href="https://www.instagram.com/atelier_ginette/" target="_blank">Instagram</a>
            <a class="liens whiteFont" href="#/contact">Ecrivez-nous</a>
        </div>
        <!-------------------------PARTIE CGV---------------------------------------->
        <!-- Partie mise en place pour une futur vente en ligne -->
        <div class="banniereCGV">
          <!--  <a href="#">Livraisons et retours</a>-->
           <!-- <a href="#">Mentions légales</a>-->
           <!-- <a href="#">Conditions générales de vente</a>-->
        </div>
    </footer>
    <!--PROGRAMME POUR LE MENU ET BOUTON PANIER-->
   <script src="scripts/script.js" defer></script>


</body>
</html>
