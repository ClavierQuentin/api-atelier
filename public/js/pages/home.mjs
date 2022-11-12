/**Page d'accueil du site
 * Trois requêtes nécessaires, en utilisant le constructeur des Promise
 */

//Importation du script pour le carrousel et de la variable pour l'URI et des requêtes
import { fonctionCarrousel } from "../scripts/carrousel.mjs";
import { requestAccueilCategories, requestAccueilProduits, requestAccueilTexts } from "../requests.mjs";
import { page404 } from "./404.mjs";

export const homePage = {
    generate : () => {

        //Récupération des éléments HTML
        let main = document.getElementById('main-conteneur');
        const conteneurName = document.getElementById('conteneurName');
     
        //Requete fetch en parallèle
        Promise.all([
            fetch(requestAccueilProduits),
            fetch(requestAccueilCategories),
            fetch(requestAccueilTexts)
        ])
        //Utilisation d'async/await pour valider la suite de la promise lorsque toutes les données sont réceptionnées
        .then(async([res1, res2, res3]) => {
            const data = await res1.json();
            const data2 = await res2.json();
            const data3 = await res3.json();
            return [data, data2, data3]
        })
        //On décompose la réponse en différentes variables pour les utiliser indépendamment
        .then((data) =>{
            //liste des produits à mettre sur la banniere/carrousel
            const listImg = data[0];
            //Liste des catégories mises en avant
            const listeCategories = data[1];
            //Textes de l'accueil
            const texte = data[2];
            
            //On affiche
            main.innerHTML = `
                <header class="whiteFont">

                    <div class="conteneurNew">
                        <h2>Ouverture du site !</h2>
                        <button class="background" id="boutonNouveaute" onclick='window.location = "#/pages/produits"'>Découvrir</button>
                    </div>

                    <div id="conteneur" class="conteneur">
                        <div id="carrousel" class="carrousel">
                        </div>
                    </div>

                </header>
            <!---------------------------------BANNIERE PRESENTATION------------------------>

                <div class="prez">
                            <!--TITRE-->
                    <h2 class="whiteFont">${texte.titre_accueil}</h2>
                </div>

                <!--TEXTE-->
                <div class="banniereCitation">
                    <p class="whiteFont">${texte.texte_accueil}</p>
                </div>

                <!-------------------------------------BANNIERE CATEGORIES---------------------------------------->

            <div class="backGroundFleur">

                <div class="decouvrir">
                    <!--TITRE-->
                    <h2>${texte.titre_categories}</h2>
                </div>

                <div class="categories">
                    ${listeCategories.map(
                        listeCategories=>`
                            <!--CATEGORIE-->
                            <a href="#/pages/categories/${listeCategories.id}" >
                                <div>
                                    <div class="divImg">
                                        <img class="imgCategorie" src="${listeCategories.url_image_categorie}" alt="${listeCategories.nom_categorie}">
                                    </div
                                    <label>${listeCategories.nom_categorie}</label>
                                </div>
                            </a>
                            <!---->
                    `
                    ).join('\n')}
                </div>

            </div>

            <!----------------------------------BANNIERE PICTOS---------------------------------------->

            <div class="bannierePicto">

                <div>
                    <img src="./img/hand-made.png" alt="Icone fait main">
                    <label class="whiteFont">Fait maison</label>
                </div>

                <div>
                    <img src="./img/icons8-machine-à-coudre-80.png" alt="Icone machie a coudre">
                    <label class="whiteFont">Produits artisanaux</label>
                </div>

                <div>
                    <img src="./img/ecologique.png" alt="icone écologie">
                    <label class="whiteFont">Eco-responsable</label>
                </div>

            </div>
            `
        //On appelle le carrousel avec la liste des URLs d'images en paramètres
        fonctionCarrousel(listImg);
        conteneurName.style.position = "absolute";
        })
        
        .catch(function(err){
            //En cas d'erreur on affiche un message
            console.log(err);
            main.innerHTML = page404;
            conteneurName.style.position = "relative";
        })
    }    
}

// export { homePage };