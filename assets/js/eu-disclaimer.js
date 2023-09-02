// console.log ("connecté !!");

// Modal qui demande à l'utilisateur s'il est majeur
// $("#monModal").modal({
//     escapeClose: false,
//     clickClose: false,
//     showClose: false
// });

// Attente que le DOM soit prêt pour exécuter le code
jQuery(document).ready(function($){
    // Si le cookie n'a pas la bonne valeur, afficher le modal
    if(lireUnCookie('eu-disclaimer-vapobar') != "ejD86j7ZXF3x"){
        // Modal qui demande à l'utilisateur s'il est majeur
        // console.log("test: ok modal");
        $("#monModal").modal({
            escapeClose: false,
            clickClose: false,
            showClose: false
        });
    }
});

// Fonction pour créer un cookie
function creerUnCookie(nomCookie, valeurCookie, dureeJours){
    // Si la durée en jours est spécifié
    if(dureeJours){
        let date = new Date();
        // Converti le nombre de jours spécifiés en millisecondes
        date.setTime(date.getTime()+(dureeJours * 24*60*60*1000));
        var expire = "; expire="+date.toGMTString();
        // console.log("test: Date:", date); // Test de la date
    }
    // Si aucune valeur de jour n'est spécifié, le cookie expire à la fin de la session
    else {
        var expire ="";
    }
    // Création du cookie en définissant son nom, sa valeur, sa date d'expiration et son chemin
    document.cookie = nomCookie + "=" + valeurCookie + expire + "; path=/";
}

// Fonction pour lire un cookie
function lireUnCookie(nomCookie){
    // Ajoute le signe égale et un point virgule au nom pour la recherche dans le tableau contenant tous les cookies
    var nomFormate = nomCookie + "=";
    // tableau contenant tous les cookies séparés par un ;
    var tableauCookies = document.cookie.split(';');
    //Recherche dans le tableau le cookie en question
    for(var i=0; i < tableauCookies.length; i++){
        var cookieTrouve = tableauCookies[i];
        // Tant que l'on trouve un espace on le supprime
        // console.log("test: Cookie trouvé:", cookieTrouve); // Test : est-ce que le cookie est bien trouvé
        while (cookieTrouve.charAt(0) == ' ') {
            cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length);
        }
        // Si le cookie recherché est trouvé, on retourne sa valeur
        if(cookieTrouve.indexOf(nomFormate) == 0){
            return cookieTrouve.substring(nomFormate.length, cookieTrouve.length);
        }
    }
    // On retourne une valeur null dans le cas où aucun cookie n'est trouvé
    return null;
}

// Lie la fonction accepterLeDisclaimer au clic sur le bouton "Oui" du modal
document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);

// Fonction pour lier au bouton Oui du modal : au clic sur le bouton la fonction accepterLeDisclaimer appelle la fonction creerUnCookie
function accepterLeDisclaimer(){
    creerUnCookie('eu-disclaimer-vapobar', "ejD86j7ZXF3x", 1);
    var cookie = lireUnCookie('eu-disclaimer-vapobar');
    // console.log("test: Cookie créé:", cookie); // Test : est-ce que le cookie est correctement défini et lu
    alert(cookie);
}

