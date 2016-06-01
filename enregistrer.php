<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:31
 */

require_once 'config/init.php';

//echo Config::get('mysql/host');
//$user = DB::getInstance()->query("SELECT * FROM Utilisateur WHERE prenomUser = ? AND nomUser = ?", ['michel', 'pompas']);
//$user = DB::getInstance()->get('Utilisateur', ['prenomUser', '=', 'michel']);
//$user = DB::getInstance()->query("SELECT * FROM Utilisateur");
//$userInsert = DB::getInstance()->insertion('Utilisateur', [
//    'prenomUser' => 'toto',
//    'nomUser' => 'tata',
//    'pwdUser' => '123456'
//]);
//$userUpdate = DB::getInstance()->miseAJour('Utilisateur', 5, [
//    'pwdUser' => '1234567',
//    'nomUser' => 'lol'
//]);

//if (!$user->count()) {
//    echo "no user";
//}else{
//    echo "ok!";
//    echo $user->premierResultat()->prenomUser;
//    foreach ($user->resultats() as $user) {
//        echo $user->nomUser . " " . $user->prenomUser, '</br>';
//    }
//}

//if ($userInsert) {
//    echo "Succes!";
//}

//var_dump(Token::check(Input::get('token')));

$erreurSaisie = Config::get('message/erreurSaisie');
$erreurInsertion = Config::get('message/erreurInsertion');
$erreur = Config::get('message/erreur');

if (Input::existe()) {
    if (Token::check(Input::get('tokenUser'))) {
        $valide = new Validation();
        $validation = $valide->check($_POST, [
            'prenomUser'      => [
                'nom'      => 'Prénom',
                'required' => true,
                'min'      => 2,
                'max'      => 25
            ],
            'nomUser'         => [
                'nom'      => 'Nom',
                'required' => true,
                'min'      => 2,
                'max'      => 25
            ],
            'mailUser'        => [
                'nom'      => 'Adresse E-mail',
                'required' => true,
                'min'      => 2,
                'max'      => 50,
                'unique'   => 'Utilisateur'
            ],
            'pwdUser'         => [
                'nom'      => 'Mot de passe',
                'required' => true,
                'min'      => 6,
                'max'      => 25
            ],
            'confirm-pwdUser' => [
                'nom'        => 'Confirmation du mot de passe',
                'required'   => true,
                'correspond' => 'pwdUser'
            ]
        ]);
    }

    if (!empty(Input::get('enregistrement-submit'))) {
        if (isset($validation)) {
            if ($validation->valider()) {
                //echo "ok!";
                $utilisateur = DB::getInstance();
    
                try {
                    $utilisateur->insertion('Utilisateur', [
                        'prenomUser'    => Input::get('prenomUser'),
                        'nomUser'       => Input::get('nomUser'),
                        'mailUser'      => Input::get('mailUser'),
                        'pwdUser'       => Hash::creer(Input::get('pwdUser')),
                        'tokenUser'     => Input::get('tokenUser'),
                        'timeTokenUser' => date('Y-m-d H:i:s'),
                        'profilUser'    => 1,
                        'idStatut'      => 1
    
                    ]);
                } catch (PDOException $e) {
                    if (Config::get('env') == 'dev') {
                        $erreurPdo = "Échec lors de l'insertion des données : " . $e->getMessage();
                        Redirect::setMessage($erreurPdo);
                        Redirect::to(404);
                        die();
                    } else {
                        die();
                    }
                }
                if (!$utilisateur->erreur()) {
                    $sessionEnregistrement = true;
                    Session::flash('enregistrementOk', 'L\'enregistrement c\'est correctement effectué.');
                } else {
                    $erreur = true;
                    $erreurInsertion = true;
                }
    
            } else {
                $erreur = true;
                $erreurSaisie = true;
    //        foreach ($validation->erreurs() as $erreur) {
    //            echo $erreur . '</br>';
    //        }
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
                        <div class="col-xs-6">
                            <a href="index.php" id="login-form-link">S'identifier</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" class="active" id="register-form-link">S'enregistrer</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- DEBUT FORMULAIRE S'ENREGISTRER -->
                            <form id="register-form" action="#" method="post" role="form">
                                <div class="form-group">
                                    <input type="text" name="prenomUser" id="prenomUser" tabindex="1"
                                           class="form-control"
                                           placeholder="Prénom"
                                           value="<?php echo protection(Input::get('prenomUser')) ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nomUser" id="nomUser" tabindex="2" class="form-control"
                                           placeholder="Nom" value="<?php echo protection(Input::get('nomUser')) ?>">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="mailUser" id="mailUser" tabindex="3" class="form-control"
                                           placeholder="Adresse E-mail"
                                           value="<?php echo protection(Input::get('mailUser')) ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pwdUser" id="pwdUser" tabindex="4"
                                           class="form-control" placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm-pwdUser" id="confirm-pwdUser" tabindex="4"
                                           class="form-control" placeholder="Confirmation du mot de passe">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenUser" id="tokenUser" tabindex="5"
                                           class="form-control" value="<?php echo Token::generer(); ?>">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="enregistrement-submit" id="enregistrement-submit"
                                                   tabindex="6" class="form-control btn btn-register"
                                                   value="S'enregistrer">
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
                    <strong>Bravo!</strong> <?php echo Session::flash('enregistrementOk') ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- FIN MESSAGE VALIDATION -->

</div>

<!-- Latest compiled and minified JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!--<script src="includes/js/scripts.js"></script>-->

</body>
</html>
