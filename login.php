<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:31
 */
require_once 'config/init.php';
$user = new User();
if ($user->etreLogger()) { ?>
    <p>Bonjour <a href="#"><?php echo protection($user->donnees()->prenomUser) . " " . protection($user->donnees()->nomUser); ?></a>!</p>
    <ul>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
<?php
} else {
    echo "<p>Vous devez vous <a href='index.php'>connecter</a> ou <a href='enregistrer.php'>vous enregistrer.</a>";
}
