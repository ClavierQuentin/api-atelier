/**Page de contact du site internet
 * Validation du recaptcha Google via une requête POST vers le back-end de l'application
 * Création du formulaire selon la réponse de la réquête
 */

//Importation du script pour l'envoie des données du formulaire et de l'URI
import { contact } from "../scripts/contactScript.mjs";

export const contactPage = {
    generate: () =>{

        //A l'ouverture de la page, réception du token de google
        grecaptcha.ready(function() {
            grecaptcha.execute('6LepuxohAAAAAChJ_a-bx9KO4nqIfEw8iCt5Jk3y', {action: 'message'}).then(function(token) {

                //récupération des éléments HTML
                let main = document.getElementById('main-conteneur');
                const conteneurName = document.getElementById('conteneurName');

                //On fait apparaitre le formulaire
                main.innerHTML = `
                    <div class="conteneurContact backGroundFleur" >
                        <!--FORMULAIRE-->
                        <form id="contactForm">
                            <h2>Contactez-moi !</h2>
                            <div class="containerForm">

                                <div>
                                    <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" class="firstInput" required>
                
                                    <input type="text" name="nom" id="nom" placeholder="Votre nom" class="firstInput" required>
                                </div>

                                <input type="text" name="sujet" id="sujet" placeholder="Sujet du message" required>
                
                                <input type="email" name="email" placeholder="Votre email" id="email" required>
                                
                                <textarea placeholder = "Indiquez-moi votre message" id="body" name = "body" required rows="5"></textarea>

                                <input type="hidden"   name="recaptcha" id="recaptcha" value="${token}">

                                <input name="pot" class="visually-hidden" tabindex="-1" autocomplete="off" id="pot">

                                <div>
                                    <input type="checkbox" name = "newsletter" id="newsletter" >
                                    <label for="newsletter"> M'inscrire à la newsletter</label>
                                </div>

                                <div class="divRGPD">
                                        <input required type="checkbox" name="rgpd" id="rgpd" >
                                        <label for="rgpd">J'autorise ce site à conserver mes données personnelles transmises via ce formulaire. Aucune exploitation commerciale ne sera faite des données conservées</label>
                                </div>
                                    <button class="background" id="contactBtn" type="submit" >Envoyer</button>
                            </div>
                            <span id="message"></span>
                        </form>
                    </div>
                `
                //Appel de la fonction pour l'evenement au submit
                contact();
                conteneurName.style.position = "relative";
            })
        })
    }
}
// export { contactPage };