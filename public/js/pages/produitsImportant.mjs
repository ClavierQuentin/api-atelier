/**Page des produits mis en avant */

//Importation de fonctions et variables
import { page404 } from "./404.mjs";
import { requestAccueilProduits } from "../requests.mjs";

export const produitsImportant = {
    generate: () => {
        
        //On récupère les éléments HTML
        let main = document.getElementById('main-conteneur');
        const conteneurName = document.getElementById('conteneurName');

        //Requête
        fetch(requestAccueilProduits)
        .then( (res) => {
            //Si la requête passe, on retourne les données sous format JSON
            if(res.ok){
                return res.json();
            } 
            //Sinon, on retourne la page 404
            else{
                main.innerHTML = page404;
            }
        })
        .then((data)=>{
            
            //On stocke la réponse et on l'affiche
            const produits = data;
            main.innerHTML = `
                <div class="sectionProduits backGroundFleur">

                    <!--TITRE DE LA CATEGORIE-->
                    <div class="titreProduits">
                        <h3>Produits mis en vedette :</h3>
                    </div>

                    <!--PRODUITS-->
                    <div id="cardsProduits" class="cardsProduits">
                        ${produits.map( 
                            produit =>`
                                    <a href="#/pages/produit/${produit.id}" onclick="" class="cardProduit">
                                        <div class="conteneurImgProduit">
                                            <img class="imgProduit" src="${produit.url_image_produit}" alt="">
                                        </div>
                                        <label>${produit.nom_produit}</label>
                                        <label>${produit.prix_produit}€</label>
                                    </a>
                                    `
                            ).join('\n')}
                    </div>
                </div>
            `
            conteneurName.style.position = "relative";

            
                
        })
        .catch((err) => {
            //En cas d'erreur on affiche un message
            console.log(err);
        })
    }
}

// export { produitsImportant };
