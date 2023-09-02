<?php
// Définition du chemin d'accès à la classe DisclaimerOptions
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
include( MY_PLUGIN_PATH . '../Entity\DisclaimerOptions.php'); // Inclusion de la classe DisclaimerOptions

class DisclaimerGestionTable {
    // Méthode pour créer la table dans la base de données
    public function creerTable(){
        // instanciation de la classe DisclaimerOptions
        // $message = new DisclaimerOptions('id_disclaimer', 'message_disclaimer', 'redirection_ko');
        $message = new DisclaimerOptions();

        // Alimentation de l'objet $message avec les valeurs par défaut grâce aux setters (mutateurs)
        $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez confirmer que vous avez plus de 18 ans pour visiter ce site");
        $message->setRedirectionKo("https://www.google.com/");

        // Utilisation de la variable glogale $wpdb : une classe pour intéragir avec la base de données de WordPress
        global $wpdb;
        // Nom de la table à créer
        $tableDisclaimer = $wpdb->prefix.'disclaimer_options';

        // Vérification si la table existe déjà
        if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) {
            // La table n'existe pas encore, on crée la structure de la table
            $sql = "CREATE TABLE $tableDisclaimer (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,      
                    message_disclaimer TEXT NOT NULL,
                    redirection_ko TEXT NOT NULL )
                    ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
            // Tentative de création de la table, avec gestion d'erreur en cas d'échec
            if (!$wpdb->query($sql)){
                die("Une erreur est survenue, contactez le développeur du plugin");
            }

            // Insertion du message par défaut dans la table
            $wpdb->insert($wpdb->prefix . 'disclaimer_options', array(
                'message_disclaimer' => $message->getMessageDisclaimer(),
                'redirection_ko' => $message->getRedirectionKo(),
            ), array ('%s', '%s'));
            $wpdb->query($sql);
        }
    }

    // Méthode pour supprimer la table de la base de données
    public function supprimerTable() {
        // $wpdb sert à récupérer l'objet contenant les informations relatives à la base de données.
        global $wpdb;
        $table_disclaimer = $wpdb->prefix."disclaimer_options";
        $sql = "DROP TABLE $table_disclaimer";
        $wpdb->query($sql);
    }

    // Méthode pour mettre à jour les données dans la table. 
    static function insererDansTable(DisclaimerOptions $option) {
        $message_inserer_valeur = ''; // Initialisation du message de résultat
        global $wpdb;
        try {
            $table_disclaimer = $wpdb->prefix . 'disclaimer_options';
            // Requête préparée pour mettre à jour les données dans la table
            // '%s' est un marqueur de substitution. Cela signifie qu'une chaîne de caractères doit être insérée à cet endroit dans la requête. La valeur fournie sera échappée pour éviter toute altération malveillante de la requête.
            $sql = $wpdb->prepare(
                "UPDATE $table_disclaimer
                SET message_disclaimer = '%s', redirection_ko = '%s'
                WHERE id_disclaimer = '%s'", 
                $option->getMessageDisclaimer(), 
                $option->getRedirectionKo(),
                1
            );
            $wpdb->query($sql);
            return $message_inserer_valeur = '<span style="color:green; font-size:16px;">Mise à jour réalisée avec succès</span>';
        } catch (Exception $e) {
            return $message_inserer_valeur = '<span style="color:red; font-size:16px;">Echec de la mise à jour, une erreur est survenue</span>';
        }
    }

    // Méthode pour afficher le contenu du modal
    static function AfficherDonneModal() {
        global $wpdb;
        $query = "SELECT * fROM wp_disclaimer_options"; // Requête qui récupère les données de la table
        $row = $wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        $lien_redirection = $row->redirection_ko;
        // Création du contenu HTML pour le modal
        return '<div id="monModal" class="modal">
                    <p>'. $message_disclaimer .'</p>
                    <a href="" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui, j\'ai plus de 18 ans</a>
                    <a href="'.$lien_redirection.'" type="button" class="btn-red">Non, je suis mineur</a>
                </div>';
    }
}