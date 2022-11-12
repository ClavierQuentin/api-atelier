/**Différentes fonctions */


//On récupère la div cliquable
let divMenu = document.getElementById('divMenu');

//On récupère les éléments nav et main de l'html
let nav = document.querySelector('nav');
let main = document.getElementById('main-conteneur');

//On récupère les liens
let links = document.getElementsByClassName('links');


//On récupère le titre principale
let nom = document.getElementById('name');

//On récupère conteneur-name
let conteneurName = document.getElementById('conteneurName');


//On déclare un booléen faux pour valider une condition
let isOuvert = false;
const gestionMenu = () => {

    //Si le booléen est faux
    if(!isOuvert){
        //On rajoute la class css pour effectuer les mouvements
        divMenu.classList.add('ouverture');
        
        //On initialise setTimeOut pour une apparition dans 0.3s
        setTimeout(function(){
            //On fait apparaître nav et passe en flex
            conteneurName.style.display = "none";
            nav.style.display = 'block';
            nav.style.display = 'flex';
            //On fait disparaitre le reste de la page
            main.style.display = 'none';
            //On rajoute une classe pour corriger le décalage du titre
            nom.classList.add('marginRight10');
        },300)
        //On passe le booléen à vrai
        isOuvert = true;
    }
    else{//Si le booléen est vrai
        //On retire la classe
        divMenu.classList.remove('ouverture');
        //On retire nav et on remets le reste de la page
        setTimeout(function(){
            conteneurName.style.display = "flex";
            nav.style.display = 'none';
            main.style.display = 'block';
            //On replace le titre
            nom.classList.remove('marginRight10');
        },300)
        isOuvert = false;
    }
}
//Au click du menu on effectue les changements
divMenu.addEventListener('click', gestionMenu);

//A chaque clicque sur les liens du menu on appelle gestionMenu()
Array.from(links).forEach(link =>{
    link.addEventListener('click', gestionMenu)
})


/**
 * 
 * Script au submit pour l'inscription à la newsletter 
 * 
 * */
document.getElementById('newsletterForm').addEventListener('submit', (e) => {

    //On récupère l'élément pour le message de retour
    let msg = document.getElementById('msg')

    //On empêche le refresh de la page
    e.preventDefault(); 

    //Google recaptcha
    grecaptcha.ready(function() {
        grecaptcha.execute('6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y', {action: 'message'}).then(function(token) {

            //On stocke les valeurs de chaque input
            let data = {
                'email': document.getElementById('email').value,
                'pot':document.getElementById('pot').value,
                'token': token     
            }

            //Création de la requête Fetch
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');

            fetch('https://api-atelier.herokuapp.com/api/add-email', {
                method: "POST",
                mode:"cors",
                caches: "default",
                headers: headers,
                body: JSON.stringify(data)
            })
            .then((res) => {
                return res.json();   
            })
            .then((res)=>{
                msg.innerHTML = res.message;
            })
            .catch((err) => {
                console.log(err);
                msg.innerHTML = "Une erreur est survenue";
            })

        })

    })

})

/**Création d'un bouton et d'un encadré panier pour plus tard 
 * 
 * 
*/

// let blocPanier = document.getElementById('blocPanier')
// let panier = document.getElementById('panier')
// let panierClique = false
// blocPanier.addEventListener('click', () => {
//     if(!panierClique){
//         panier.classList.add('affichagePanier')
//         panierClique = true;
    
//     }
//     else{
//         panier.classList.remove('affichagePanier')
//         panierClique = false
//     }
// })

// let divPanier = document.getElementById('emptyBasket');
// let panierItems =JSON.parse(localStorage.getItem('panierItems'));
// function genererPanier(){
//     if(panierItems.length > 0){
//         for(let y= 0; y< panierItems.length; y++){
//             let divProduit = document.createElement('div');
//             divProduit.classList.add('divProduit')
//             divPanier.appendChild(divProduit)

//             let img = document.createElement('img');
//             img.src = panierItems[y].image;
//             img.classList.add('imgProduitPanierDefilant')
//             divProduit.appendChild(img)

//             let divDescription = document.createElement('div');
//             divDescription.classList.add('divDescription')
//             divProduit.appendChild(divDescription)

//             let para = document.createElement('p');
//             para.textContent = panierItems[y].nom;
//             divDescription.appendChild(para)
            
//             let prix = document.createElement('p')
//             prix.textContent = panierItems[y].prix + "€" ;
//             divDescription.appendChild(prix)
            
//             let quantite = document.createElement('p')
//             quantite.textContent = "Qté :" + panierItems[y].qte
//             divDescription.appendChild(quantite)
//         }
//         /*let button = document.createElement("button");
//         button.textContent = "Acceder au panier"
//         button.onclick = "document.location.hash = '/pages/panier'"
//         divPanier.appendChild(button)*/
//     }
//     else{
//         divPanier.innerHTML = "Votre panier est vide"
//     }
// }
// genererPanier();