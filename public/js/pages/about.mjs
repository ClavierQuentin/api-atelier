/**Page About du site internet
 * 3 requêtes nécessaires pour avoir toutes les informations pour la page
 * Utilisation du constructeur des Promises et de l'asyncronicité de JS pour effectuer les requêtes fetch en parallèles
 */
import { requestAbout1, requestAbout2, requestAbout3 } from "../requests.mjs";

//Importation du script pour le mini carrousel
import { carrouselAbout } from "../scripts/carrouselAbout.mjs";

//Importation des différentes variables nécessaires
 
import { page404 } from "./404.mjs";

import { dataTest } from "../utils.mjs";

export const aboutPage = {
    generate : () => {
        //On récupère les différents éléments HTML
        let main = document.getElementById('main-conteneur');
        const conteneurName = document.getElementById('conteneurName');

        //Requêtes parallèles
        Promise.all([
            fetch(requestAbout1),
            fetch(requestAbout2),
            fetch(requestAbout3),
        ])
        //Utilisation d'async/await pour valider la suite de la promise lorsque toutes les données sont réceptionnées
        .then(async([res1, res2, res3]) => {
            const data1 = await res1.json();
            const data2 = await res2.json();
            const data3 = await res3.json();
            return [data1, data2, data3];
        })
        //On récupère les réponses sous format Json
        .then((data) => {

            //Déclaration des variables
            let ban1;
            let ban2;
            let ban3;

            //Test si requête aboutie
            ban1 = dataTest(ban1, data[0])
            ban2 = dataTest(ban2, data[1])
            ban3 = dataTest(ban3, data[2])

            //On transforme le contenu HTML du conteneur
            main.innerHTML = `
            <!-----------------BANNIERE QUI JE SUIS--------------------->
            <div class="banniere quiJeSuis backGroundFleur">
                <div class="divTexte">
                    <!--TITRE-->
                    <h2>${ban1.titre}</h2>
                    <!--TEXTE-->
                    ${ban1.texte}
                </div>
                <!--IMAGE-->
                <div class="portrait">
                    <img src="${ban1.url_image}" alt="${ban1.titre}">
                </div>
            </div>
            <!---------------------------------BANNIERE LIEU-------------------------------->
            <div class="lieu whiteFont banniere">
                <!--CARROUSEL-->
                <div class="conteneurCarrousel" id="conteneurCarrousel">
                    <div id="carrouselPrez" class="carrousel">
                    </div>
                </div>
                <!--TEXTE-->
                <div class="divTexte">
                    <h2>${ban2.data.titre}</h2>
                    ${ban2.data.texte}
                </div>
            </div>
            <!------------------------------------BANNIERE VALEURS----------------------------------->
            <div class="backGroundFleur">
                <div>
                    <!--TITRE-->
                    <h2 class="titreValeurs" >${ban3.titre_principal}</h2>
                    <div class="banniere " style="padding-top: 20px; padding-bottom: 10%">
                        <div class="divTexte">
                            <!--TITRE-->
                            <h2>${ban3.titre_1}</h2>
                            <!--TEXTE-->
                            ${ban3.texte_1}
                        </div>
                        <!--IMAGE-->
                        <div>
                            <img class="paysage" src="${ban3.url_image}" alt="${ban3.titre_1}">
                        </div>
                    </div>
                </div>
                <div class="banniere wrapReverse" style="padding-bottom: 80px;">
                    <!--IMAGE-->
                    <div>
                        <img class="imgDeuxBanDeux" style=" height:500px;" src="${ban3.url_image_2}" alt="${ban3.titre_2}">
                    </div>
                    <div class="divTexte">
                        <!--TITRE-->
                        <h2>${ban3.titre_2}</h2>
                        <!--TEXTE-->
                        ${ban3.texte_2}
                    </div>
                </div>
            </div>
    
            `
            //On appelle la fonction du carrousel en passant les urls des images en paramètre
            carrouselAbout(ban2);
            //Changement de la position du titre
            conteneurName.style.position = "relative"
        })
        .catch((error) => {
            //Si une erreur se produit, on passe sur la page 404
            console.log(error)
            main.innerHTML = page404;
            conteneurName.style.position = "relative"
        })
    }
}

// export { aboutPage };