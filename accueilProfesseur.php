<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 23/05/2016
 * Time: 21:15
 */

require_once 'config/init.php';
if (Session::existe('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}
$utilisateur = new User();
if ($utilisateur->etreLogger() && $utilisateur->donnees()->profilUser == 2 && diffDate($utilisateur->donnees()->timeTokenUser)) { ?>
    <p>Bonjour <a
            href="#"><?php echo protection($utilisateur->donnees()->prenomUser) . " " . protection($utilisateur->donnees()->nomUser); ?></a>!
    </p>
    <ul>
        <li><a href="logout.php">Se déconnecter</a></li>
        <li><a href="miseAJour.php">Modifier son profil</a></li>
        <li><a href="changerPassword.php">Modifier mot de passe</a></li>
    </ul>
    <?php
} else {
    echo "<p>Vous devez vous <a href='index.php'>connecter</a> ou <a href='enregistrer.php'>vous enregistrer.</a>";
}