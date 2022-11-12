//Fonction pour décomposer l'URL et en contrôler la sortie
const parseRequestUrl = () => {
    const url = window.location.hash.toLowerCase();
    const request = url.split("/");
    return{
        page: request[1],
        destination: request[2],
        id: request[3]
    } ;
}

//Déclaration fonction pour test des requêtes
const dataTest = (ban, data) => {
    switch (data.status) {
        case false:
            ban = {
                titre: 'Une erreur est survenue',
                texte: 'Une erreur est survenue',
            }
            break;
    
        case true : 
            ban = data
            break;
            
        default:
            ban = data
            break;
    }

    return ban
}


//URI pour requêtes
const url = "https://api-atelier.herokuapp.com/api/";
// const url ="http://127.0.0.1:8000/api/";

export { parseRequestUrl, url, dataTest };