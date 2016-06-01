<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:31
 */
require_once 'config/init.php';
$erreurSaisie = Config::get('message/erreurSaisie');
$erreurInsertion = Config::get('message/erreurInsertion');
$erreur = Config::get('message/erreur');

$utilisateur = new User();
if (!$utilisateur->etreLogger() && !diffDate($utilisateur->donnees()->timeTokenUser)) {
    Redirect::to('index.php');
} else {
    include 'includes/pages/header.php';
    include 'includes/pages/navbar.php';
}

if (Input::existe()) {
    if (Token::check(Input::get('tokenUser'))) {
        $valide = new Validation();
        $validation = $valide->check($_POST, [
            'pwdUserActuel'          => [
                'nom'      => 'Mot de passe actuel',
                'required' => true,
                'min'      => 6
            ],
            'pwdUserNouveau'         => [
                'nom'      => 'Nouveau mot de passe',
                'required' => true,
                'min'      => 6
            ],
            'confirm-pwdUserNouveau' => [
                'nom'        => 'Confirmation du mot de passe',
                'required'   => true,
                'min'        => 6,
                'correspond' => 'pwdUserNouveau'
            ]
        ]);
        if (!empty(Input::get('enregistrement-submit'))) {
            if ($validation->valider()) {
                if (Hash::creer(Input::get('pwdUserActuel')) !== $utilisateur->donnees()->pwdUser) {
                    $erreur = true;
                    $erreurPassword = true;
                } else {
                    try {
                        $utilisateur->miseAJour([
                            'pwdUser' => Hash::creer(Input::get('pwdUserNouveau'))
                        ]);
                    } catch (Exception $e) {
                        if (Config::get('env') == 'dev') {
                            die("Échec lors de la connexion : " . $e->getMessage());
                        }
                        Session::flash('home', 'Votre mot de passe a été changé !');
                        switch ($utilisateur->donnees()->profilUser) {
                            case 1:
                                Redirect::to('accueilEleve.php');
                                break;
                            case 2:
                                Redirect::to('accueilProfesseur.php');
                                break;
                            default:
                                Redirect::to('index.php');
                                break;
                        }
                    }
                }
            } else {
                $erreur = true;
                $erreurSaisie = true;
            }
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">

    <title>Cahier de texte</title>
    <meta name="description" content="Cahier de texte">
    <meta name="author" content="Michel Pompas">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/styles.css">

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="index.php" id="password-form-link">Mise à jour mot de passe</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- DEBUT FORMULAIRE S'ENREGISTRER -->
                            <form id="password-form" action="#" method="post" role="form">
                                <div class="form-group">
                                    <input type="password" name="pwdUserActuel" id="pwdUserActuel" tabindex="1"
                                           class="form-control" placeholder="Mot de passe actuel">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pwdUserNouveau" id="pwdUserNouveau" tabindex="2"
                                           class="form-control" placeholder="Nouveau mot de passe">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm-pwdUserNouveau" id="confirm-pwdUserNouveau"
                                           tabindex="3"
                                           class="form-control" placeholder="Confirmation du nouveau mot de passe">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenUser" id="tokenUser" tabindex="4"
                                           class="form-control" value="<?php echo Token::generer(); ?>">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="enregistrement-submit" id="enregistrement-submit"
                                                   tabindex="6" class="form-control btn btn-register"
                                                   value="Modifier">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- FIN FORMULAIRE S'ENREGISTRER -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DEBUT MESSAGES ERREURS -->
    <?php if ($erreur): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Erreur!</strong></br>
                    <?php
                    if ($erreurSaisie) {
                        foreach ($validation->erreurs() as $erreurSaisie) {
                            echo $erreurSaisie . '</br>';
                        }
                    }
                    if ($erreurInsertion) {
                        Session::flash('enregistrementPasBon', 'Problème lors de l\'insertion des données.');
                        echo Session::flash('enregistrementPasBon');
                    }
                    if ($erreurPassword) {
                        Session::flash('motDePassePasBon', 'Mot de passe incorrect !');
                        echo Session::flash('motDePassePasBon');
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- FIN MESSAGES ERREURS -->

</div>

<!-- Latest compiled and minified JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!--<script src="includes/js/scripts.js"></script>-->

</body>
</html>
