/**Fonction pour le mini carrousel sur la page About */

export const carrouselAbout = (data) => {

    //On récupère le tableau d'urls stocké dans data
    const listeImages = data.urls ;

    //On récupère l'élément HTML
    let carrouselPrez = document.getElementById('carrouselPrez');
    
    //On initialise une largeur du carrousel de 333px
    let largeurCarrouselPrez = 333;

    //Fonction de génération des images
    function generate(){
    //Pour la taille du tableau, on implémente le src et la classe aux images
        for(let i = 0; i < listeImages.length; i++){
            let photoPrez = document.createElement('img');
            photoPrez.src = listeImages[i];
            photoPrez.classList.add('tailleImg');
            carrouselPrez.appendChild(photoPrez);
        }
    }
    generate();

    //Initialisation d'un compteur pour suivre les positions des images
    let compteurPrez = 1;
    //Fonction pour le slide du carrousel
    function slide(){
        //Si on arrive sur la dernière image
        if(compteurPrez == listeImages.length){
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
}

// export {carrouselAbout};