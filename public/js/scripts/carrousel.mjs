/**Fonction pour créer le carrousel de la page d'accueil 
 * @param {array} data An array of images urls
*/

export const fonctionCarrousel = (data) => {


        //Création d'un tableau vide
        let listeCarrou = [];

        //On boucle la liste des données pour ne récupérer que 2 éléments que l'on sauvegarde dans le tableau vide
        for(let i = 0; i < data.length; i++){
            listeCarrou.push({
                url: data[i].url_image_produit,
                id: data[i].id,
                name: data[i].nom_produit
            });
        }


        //On récupère l'élément carrousel dans html
        let carrousel = document.getElementById('carrousel');

        //On récupère la largeur de l'écran de l'utilisateur
        let largeurEcran = screen.width;

        //Création de la fonction de création des balises HTML
        function generate(){

            //On boucle chaque élément du tableau listeCarrou
            for(let i = 0; i < listeCarrou.length; i++){
        
                //On crée un élément img
                let photo = document.createElement('img');
                //On y modifie l'id et src selon le array
                photo.src = listeCarrou[i].url;
                photo.id = listeCarrou[i].id;
                photo.alt = listeCarrou[i].name;

                //On donne à l'image la largeur de l'écran
                photo.style.minWidth = largeurEcran+"px";
                
                photo.classList.add('tailleImg')
                //On rajoute l'image au carrousel
                carrousel.appendChild(photo);
            }
        }

        //On lance la fonction
        generate();

        //On appelle un compteur pour suivre la position des images
        let compteur = 1;

        //On créer la fonction slide du carrousel
        function slide(){

            //Si est arrivé à la dernière image
            if(compteur == listeCarrou.length){
                //On remet le compteur à 0
                compteur = 0;
            }

            //On translate le carrousel selon la largeur de l'écran et multiplié par le compteur (position de l'image)
            carrousel.style.transform = 'translateX(-' +largeurEcran*compteur+'px)';
            //On incrémente compteur
            compteur++;
        }

        //setInterval nous permet de lancer slide toutes les 6s
        setInterval(slide,6000);

}
