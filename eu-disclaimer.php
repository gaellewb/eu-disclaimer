<?php
/**
 * Ce fichier se comporte comme le fichier contenant toutes les fonctions de WordPress.
 * Ces lignes commentaires sont des informations obligatoires pour afficher le module dans le panel administration des extensions. 
 * Pour diffuser le plugin dans le Marketplace, il est impératif de mettre le lien de la licence (du site). 
 */

/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://URL_de_l_exension
 * Description: Plugin sur la législation des produits à base de nicotine.
 * Version: 1.5
 * Author: Gaëlle WALCZYNA
 * Licence: http://levapobar.test/
 */

// Inclusion du fichier DisclaimerGestionTable.php
require_once ('Model/Repository/DisclaimerGestionTable.php');

// Afficher le plugin dans le menu de l'administration -> création de la fonction "ajouterAuMenu" avec "add_menu_page" pour afficher un raccourci vers le plugin
function ajouterAuMenu(){
    $page_title = 'eu-disclaimer'; // Titre de la page
    $menu_title = 'eu-disclaimer'; // Titre affiché dans le menu d'administration
    $capability = 'edit_pages'; // Capacité utilisateurrequise pour voir le menu
    $menu_slug = 'eu-disclaimer'; // Slug (lien) du menu
    $function = 'disclaimerFonction'; // nNom de la fonction qui génère le contenu de la page
    $icon_url = ''; // URL de l'icône à afficher dans le menu(facultatif)
    // $position = 80; // Position dans le menu admin (facultatif, éviter car peut créer des conflits)
    if(is_admin()){
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);
    }
}

// Hook : utilisation de l'action "admin_menu" pour appeler la fonction "ajouterAuMenu" -> ajouter le menu dans l'inerface d'administration 
add_action("admin_menu", "ajouterAuMenu", 10);

// Fonction appelée lorsque l'utilisateur clique sur le menu. Elle a pour objectif de charger une page PHP
function disclaimerFonction(){
    // Inclusion du fichier disclaimer-menu.php
    require_once ('views/disclaimer-menu.php');
}

// Vérification si la classe DisclaimerGestionTable existe
if (class_exists("DisclaimerGestionTable")){
    $gerer_table = new DisclaimerGestionTable(); // Création d'un objet $gererTable
}

// Vérification et enregistrement des hooks pour la création et la suppression de la table lors de l'activation/désactivation du plugin
if (isset($gerer_table)){
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable')); // Hook pour créer la table
    register_deactivation_hook(__FILE__, array($gerer_table, 'supprimerTable')); // Hook pour supprimer la table
}

// Ajout du JS à l'activation du plugin
add_action('init', 'inserer_js_dans_footer');
function inserer_js_dans_footer() {
    if(!is_admin()):
    // La fonction wp_register_script ou style est utilisée pour enregistrer un fichier qui sera utilisé ultérieurement    
        // CDN jQuery js
        wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js', null, null, true);
    //La fonction wp_enqueue_script ou style est utilisée pour ajouter le script /style enregistré avec wp_register_script à la file d'attente des scripts à charger
        wp_enqueue_script('jquery');

        // CDN jQuery Modal js
        wp_register_script('jQuery_modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js', null, null, true);
        wp_enqueue_script('jQuery_modal');

        // Chargement du fichier eu-disclaimer.js
        wp_register_script('jQuery_eu', plugins_url('assets/js/eu-disclaimer.js', __FILE__), array('jquery'), '1.1', true);
        wp_enqueue_script('jQuery_eu');
    endif;
}

// Ajout du CSS à l'activation du plugin
add_action('wp_head', 'ajouter_css', 1);
function ajouter_css(){
    if(!is_admin()):
        // Chargement du fichier eu-disclaimer-css.css
        wp_register_style('eu-disclaimer-css', plugins_url('assets/css/eu-disclaimer-css.css', __FILE__), null, null, false);
        wp_enqueue_style('eu-disclaimer-css');

        // CDN jQuery Modal CSS
        wp_register_style('modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css', null, null, false );
        wp_enqueue_style('modal');
    endif;
}

// Ajout du Modal avec du shortcode
    /*
    // La fonction add_shortcode() permet de lier le "shortcode" à la méthode afficherModal().
    function afficherModal(){
        // J'appelle la méthode afficherDonneModal().
        return DisclaimerGestionTable::AfficherDonneModal();
    }
    */

// Ajout du Modal avec le hook wp_body_open. Hook pour que l'activation se fasse de manière automatique lors de l'installation du plugin. 
add_action('wp_body_open', 'afficherModalDansBody');
function afficherModalDansBody(){
    echo DisclaimerGestionTable::AfficherDonneModal();
}