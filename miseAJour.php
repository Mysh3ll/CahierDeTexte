<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:32
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
            'prenomUser' => [
                'nom'      => 'Prénom',
                'required' => true,
                'min'      => 2,
                'max'      => 25
            ],
            'nomUser'    => [
                'nom'      => 'Nom',
                'required' => true,
                'min'      => 2,
                'max'      => 25
            ]
        ]);
    }
    if (!empty(Input::get('enregistrement-submit'))) {
        if ($validation->valider()) {

            try {
                $utilisateur->miseAJour([
                    'prenomUser' => Input::get('prenomUser'),
                    'nomUser'    => Input::get('nomUser')
                ]);
            } catch (PDOException $e) {
                if (Config::get('env') == 'dev') {
                    die("Échec lors de la connexion : " . $e->getMessage());
                }
            }
            $sessionEnregistrement = true;
            Session::flash('home', 'L\'enregistrement c\'est correctement effectué.');
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
        } else {
            $erreur = true;
            $erreurSaisie = true;
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#" class="active" id="update-form-link">Mise à jour du profil</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- DEBUT FORMULAIRE PROFIL -->
                            <form id="update-form" action="#" method="post" role="form">
                                <div class="form-group">
                                    <input type="text" name="prenomUser" id="prenomUser" tabindex="1"
                                           class="form-control"
                                           placeholder="Prénom"
                                           value="<?php echo protection($utilisateur->donnees()->prenomUser); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nomUser" id="nomUser" tabindex="2" class="form-control"
                                           placeholder="Nom"
                                           value="<?php echo protection($utilisateur->donnees()->nomUser); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenUser" id="tokenUser" tabindex="3"
                                           class="form-control" value="<?php echo Token::generer(); ?>">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="enregistrement-submit" id="enregistrement-submit"
                                                   tabindex="4" class="form-control btn btn-register"
                                                   value="Valider">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- FIN FORMULAIRE PROFIL -->
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
                    <strong>Erreur!</strong> </br>
                    <?php
                    if ($erreurSaisie) {
                        if (isset($validation)) {
                            foreach ($validation->erreurs() as $erreurSaisie) {
                                echo $erreurSaisie . '</br>';
                            }
                        }
                    }
                    if ($erreurInsertion) {
                        Session::flash('enregistrementPasBon', 'Problème lors de l\'insertion des données.');
                        echo Session::flash('enregistrementPasBon');
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- FIN MESSAGES ERREURS -->

    <!-- DEBUT MESSAGE VALIDATION -->
    <?php if ($sessionEnregistrement): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 alert alert-success fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Bravo!</strong> <?php echo Session::flash('enregistrementOk'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- FIN MESSAGE VALIDATION -->

</div>

<?php include 'includes/pages/footer.php'; ?>