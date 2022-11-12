/**Fonctions pour différentes requêtes au back */

//On récupère l'URI de l'API
import { url } from "./utils.mjs"; 

//Instance du header de la requète
const headers = new Headers();
headers.append('Content-Type', 'application/json');

const Init = {
    headers: headers,
    method: 'GET',
    mode: 'cors',
    cache: 'default'
}


/**REquêtes page d'accueil */
const requestAccueilProduits = new Request(url + 'produits-accueil', Init);
const requestAccueilCategories = new Request(url + 'categories-accueil', Init);
const requestAccueilTexts = new Request(url + 'texte-accueil', Init);

/**Requêtes page About */
const requestAbout1 = new Request(url + "premiere-banniere", Init);
const requestAbout2 = new Request(url + "deuxieme-banniere", Init);
const requestAbout3 = new Request(url + "troisieme-banniere", Init);

/**Requetes catégories */
const requestCategories = new Request(url + "categories", Init);

//Export 
export { requestAbout1, requestAbout2, requestAbout3, requestCategories, requestAccueilProduits, requestAccueilCategories, requestAccueilTexts, Init};