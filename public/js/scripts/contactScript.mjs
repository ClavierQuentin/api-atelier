/**Script pour l'envoie du formulaire */

//On récupère l'URI
import { url } from "../utils.mjs";

const Regex = /^(?!\s*$).+/


export const contact = () => {
   
    //On récupère l'élément FORM au submit
    document.getElementById('contactForm').addEventListener('submit', (e) => {   
        
        //On récupère l'élément HTML 
        let message = document.getElementById('message'); 
        let checkboxNewsletter = document.getElementById('newsletter');
        let newsletter = 0;
        if(checkboxNewsletter.checked){
            newsletter = 1;
        } 

        //On empêche le refresh de la page
        e.preventDefault(); 

        //On stocke les valeurs de chaque input
        let data = {
                prenom: document.getElementById('prenom').value,
                nom: document.getElementById('nom').value,
                sujet: document.getElementById('sujet').value,
                email: document.getElementById('email').value,
                message: document.getElementById('body').value,
                token: document.getElementById('recaptcha').value,
                pot:document.getElementById('pot').value ,
                newsletter: newsletter    
        }

        /**Test avec expression régulière pour éviter les champs d'espaces */
        if(!data.prenom.match(Regex) || !data.nom.match(Regex) || !data.sujet.match(Regex) || !data.message.match(Regex)){
            return message.innerHTML = 'Une erreur est survenue'
        }
    
        //Création de la requête Fetch

        //Instance de l'entête
        const headers = new Headers();
        headers.append('Content-Type', 'application/json');
        fetch(url + 'message', {
            method: "POST",
            mode:"cors",
            headers: headers,
            cache:"default",
            body: JSON.stringify(data)
        })
        .then((res)=>{
            return res.json();
        })
        .then((res) => {
            //On retourne le message fourni par le serveur
            message.innerHTML = res.message;
        })
        .catch((err) => {
            console.log(err);
            message.innerHTML = "Une erreur est survenue";
        })

    });
}


// export { contact };