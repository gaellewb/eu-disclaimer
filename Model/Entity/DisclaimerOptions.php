<?php

class DisclaimerOptions {

    // Propriétés de la classe :
    // identifiant du disclaimer
    private $id_disclaimer;
    // contenu du message à afficher dans le disclaimer
    private $message_disclaimer;
    // l'url de redirection en cas de réponse négative par le visiteur
    private $redirection_ko;

    // Constructeur de la classe. Nc veut dire Non communiqué
    function __construct($id_disclaimer = "Nc", $message_disclaimer = "Nc", $redirection_ko = "Nc") {
        // Initialisation des propriétés avec les valeurs fournies ou des valeurs par défaut "Nc"
        $this->id_disclaimer = $id_disclaimer;
        $this->message_disclaimer = $message_disclaimer;
        $this->redirection_ko = $redirection_ko;
    }

// Téléchargement de l'extension PHP Getters & Setters qui fait les get et set automatiquement
    /**
     * Get the value of id_disclaimer
     */ 
    public function getIdDisclaimer()
    {
        return $this->id_disclaimer;
    }

    /**
     * Get the value of message_disclaimer
     */ 
    public function getMessageDisclaimer()
    {
        return $this->message_disclaimer;
    }

    /**
     * Set the value of message_disclaimer
     * @return  self
     */ 
    public function setMessageDisclaimer($message_disclaimer)
    {
        $this->message_disclaimer = $message_disclaimer;
        return $this;
    }

    /**
     * Get the value of redirection_ko
     */ 
    public function getRedirectionKo()
    {
        return $this->redirection_ko;
    }

    /**
     * Set the value of redirection_ko
     * @return  self
     */ 
    public function setRedirectionKo($redirection_ko)
    {
        $this->redirection_ko = $redirection_ko;
        return $this;
    }
}