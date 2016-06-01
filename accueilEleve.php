<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 23/05/2016
 * Time: 21:16
 */

require_once 'config/init.php';
include 'includes/pages/header.php';

if (Session::existe('home')) { ?>
    <div class="container">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <?php echo Session::flash('home') ?>
        </div>
    </div>
    <?php
}
$utilisateur = new User();
if ($utilisateur->etreLogger() && $utilisateur->donnees()->profilUser == 1 && diffDate($utilisateur->donnees()->timeTokenUser)) {
    include 'includes/pages/navbar.php';
    ?>

    <div class="container">
        <div class="jumbotron">
            <div class="page-header">
                <h1>Bonjour
                    <span
                        class="text-capitalize text-primary"><?php echo protection($utilisateur->donnees()->prenomUser) . " " . protection($utilisateur->donnees()->nomUser); ?></a></span>
                    !
                </h1>
            </div>
        </div>
    </div><!-- /.container -->

    <div class="container-fluid">

        <div class="starter-template">
            <h1>Bootstrap starter template</h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text
                and a
                mostly barebones HTML document.</p>
        </div>

    </div><!-- /.container -->

    <?php
} else { ?>
    <div class="bs-callout bs-callout-danger">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            Vous devez vous <strong><a href='index.php'>connecter</a></strong> ou <strong><a href='enregistrer.php'>vous
                    enregistrer.</a></strong>
        </div>
    </div>
<?php }

include 'includes/pages/footer.php';
?>


