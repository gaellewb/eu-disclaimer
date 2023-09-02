<?php
// Je m'assure que le formulaire n'est pas vide avant de le valider
if(!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])){
    // Création d'une instance de la classe DisclaimerOptions pour gérer les options 
    $text = new DisclaimerOptions();
    // La fonction htmlspecialchars permet de protéger le formulaire contre les attaques XSS. Elle convertit les caractères spéciaux en html
    $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
    $text->setRedirectionKo(htmlspecialchars($_POST['url_redirection']));

    // Insérer les données dans la table à l'aide de la méthode insererDansTable de DisclaimerGestionTable
    $message = DisclaimerGestionTable::insererDansTable($text);
}
?>

<h1 style="text-align:center">EU DISCLAIMER</h1>
<br>
<h2>Configuration</h2>
<!-- Afficher le message de mise à jour -->
<p><?php if (isset($message)) echo $message; ?></p>
<form method="post" action="" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="blogname">Message du disclaimer</label></th>
            <td><input name="message_disclaimer" type="text" id="message_disclaimer" value="" class="regular-text" placeholder=""
            required="required"></td>
        </tr>
        <tr>
            <th scope="row"><label for="blogname">Url de redirection</label></th>
            <td><input name="url_redirection" type="text" id="url_redirection" value="" class="regular-text" placeholder="" required="required"></td>
        </tr>
    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modifications"></p>
</form>
<br>
<p>Exemple : La législation nous impose de vous informer sur la nocivité des produits à base de nicoltine, vous devez avoir plus de 18 ans pour consulter ce site.</p>
<br>
<h3>Gaelle Walczyna</h3>
<!-- Affichage de l'image avec le chemin absolu -->
<img class="text-center" src="<?php echo plugin_dir_url( dirname(__FILE__)) . 'assets/img/logoGAELLE.png'; ?>" width="5%">