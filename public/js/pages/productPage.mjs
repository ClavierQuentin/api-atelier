/**Page d'affichage d'un produit
 * Nécessite deux requetes
 */

//Importations
import { Init } from "../requests.mjs";
import { parseRequestUrl, url } from "../utils.mjs";
import { page404 } from "./404.mjs";

//Je récupère les différents paramètre de l'url
const request = parseRequestUrl();

export const productPage = {
    generate: () =>{
        
        //On récupère les éléments HTML
        let main = document.getElementById('main-conteneur');
        const conteneurName = document.getElementById('conteneurName');

        //Requêtes parallèles
        Promise.all([
            //Requête pour obtenir les détails du produit
            fetch(url + `produits/${request.id}`, Init),
            //Requête pour obtenir les autres produits de la catégorie
            fetch(url + `produits/${request.id}/all`, Init)
        ])
        //Utilisation d'async/await pour valider la suite de la promise lorsque toutes les données sont réceptionnées
        .then(async([res, res2]) => {
            const data = await res.json();
            const data2 = await res2.json();
            return [data, data2];
        })
        //On récupère la réponse en JSON
        .then((data)=>{

            //On stocke la réponse et on affiche le tout
            const produit = data[0];
            const produits = data[1];
            main.innerHTML = `

                <div class="backGroundFleur">

                <!--PREMIER BLOC DE DESCRIPTION-->
                    <div class="sectionPhoto">

                        <!--IMAGE-->
                        <img src="${produit.url_image_produit}" alt="${produit.nom_produit}" class="imgProduitUnique">

                        <div class="description1">

                            <!--NOM ET PRIX-->
                            <h2>${produit.nom_produit}</h2>
                            <div class="prix">
                                <p>
                                    ${produit.prix_produit}€ l'unité
                                </p>
                            </div>

                            <!--DESCRIPTION COURTE-->
                            <div class="descriptionCourte">
                                    ${produit.description_courte_produit} 
                            </div>

                            <div>
                                <button class="background" id="boutonAjouter"><a class="whiteFont"  href="${produit.url_externe}">Voir sur le site marchand</a></button>
                            </div>

                        </div>

                    </div>

                    <hr>

                    <!--DESCRIPTION LONGUE-->
                    <div class="compo">
                        ${produit.description_longue_produit}
                    </div>

                    

                    <div id ="equivalence">
                    <!--BLOC PRODUIT EQUIVALENT-->

                    </div>
                </div>
            `
            let equivalence = document.getElementById('equivalence');
            
            if(produits.length > 0){
                equivalence.innerHTML = `
                <hr>    
                <h3 class="titreProduitEquivalent">Vous pourriez aussi aimer :</h3>
                <div class="produits">
                    ${produits.map(
                        produit=>`
                            <div class="produitEquivalent">
                                <div class="labels">
                                    <label>${produit.nom_produit}</label>
                                    <label>${produit.prix_produit}€</label>
                                </div>

                                <a  href="#/pages/produit/${produit.id}" >
                                    <div class="conteneurImgProduitEquivalent">
                                        <img class="imgProduitEquivalent" src="${produit.url_image_produit}" alt="${produit.nom_produit}">
                                    </div>
                                </a>
                            </div>
                        `
                    ).join('\n')}
                </div>
                `
            }
            conteneurName.style.position = "relative";    
        })
        .catch((err)=>{
            //En cas d'erreur on affiche un message
            console.log(err);
        }) 
    }
}
// export { productPage };