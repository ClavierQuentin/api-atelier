/**Page du listing des catégories
 * 1 requête nécessaire, récupérée lors de l'importation du fichier JS
 */
import { requestCategories } from "../requests.mjs";
import { page404 } from "./404.mjs";

export const categories = {
    generate: () => {
        //On récupère les éléments HTML
        let main = document.getElementById('main-conteneur');
        const conteneurName = document.getElementById('conteneurName');

        //Requête
        fetch(requestCategories)
        .then((res) => {
            //Si la requête passe, on retourne les données sous format JSON
            if(res.ok){
                return res.json();
            }
            //Sinon, on retourne la page 404
            else{
                main.innerHTML = page404;
            }
        })
        //On récupère la réponse en JSON
        .then((data) => {

            const listeCategories = data;

            //On transforme le contenu HTML du conteneur
            main.innerHTML = `
                <div class="sectionProduits backGroundFleur">
                    <!--TITRE DE LA PAGE-->
                    <div class="titreProduits">
                        <h3>Toutes les catégories :</h3>
                    </div>
                    <!--LISTING CATEGORIES-->
                    <div id="cardsProduits" class="cardsProduits"> 
                        ${listeCategories.map( 
                            listeCategories =>`
                                <!--CARD CATEGORIE-->
                                <a href="#/pages/categories/${listeCategories.id}" onclick="" class="card">
                                    <!--IMAGE-->
                                    <div class="conteneurImgCard">
                                        <img class="imgCardProduit" src="${listeCategories.url_image_categorie}" alt="${listeCategories.nom_categorie}">
                                    </div>
                                    <!--NOM CATEGORIE-->
                                    <label>${listeCategories.nom_categorie}</label>
                                </a>
                            `
                        ).join('\n')}
                    </div>
                </div>
            `

            //On change la position du titre
            conteneurName.style.position = "relative";

        })
        .catch((err) => {
            //En cas d'erreur on affiche un message
            console.log(err);          
        })
    }
}

// export  { categories };