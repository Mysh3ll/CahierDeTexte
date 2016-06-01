<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 23/05/2016
 * Time: 21:16
 */

require_once 'config/init.php';
include 'includes/pages/header.php';
include 'includes/pages/navbar.php';
if (Session::existe('home')) {
    echo '<p>' . Session::flash('home') . '</p>';
}
$utilisateur = new User();
if ($utilisateur->etreLogger() && $utilisateur->donnees()->profilUser == 1 && diffDate($utilisateur->donnees()->timeTokenUser)) { ?>
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
?>

<div class="container-fluid">

    <div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a
            mostly barebones HTML document.</p>
    </div>

</div><!-- /.container -->
<?php
include 'includes/pages/footer.php';


