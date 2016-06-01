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

//if (Input::existe()) {
//    if (Token::check(Input::get('token'))) {
//        $valide = new Validation();
//        $validation = $valide->check($_POST, [
//            'prenomUser'      => [
//                'nom'      => 'Prénom',
//                'required' => true,
//                'min'      => 2,
//                'max'      => 25
//            ],
//            'nomUser'         => [
//                'nom'      => 'Nom',
//                'required' => true,
//                'min'      => 2,
//                'max'      => 25
//            ],
//            'mailUser'        => [
//                'nom'      => 'Adresse E-mail',
//                'required' => true,
//                'min'      => 2,
//                'max'      => 50,
//                'unique'   => 'Utilisateur'
//            ],
//            'pwdUser'         => [
//                'nom'      => 'Mot de passe',
//                'required' => true,
//                'min'      => 6,
//                'max'      => 25
//            ],
//            'confirm-pwdUser' => [
//                'nom'        => 'Confirmation du mot de passe',
//                'required'   => true,
//                'correspond' => 'pwdUser'
//            ]
//        ]);
//    }
//
//    if ($validation->valider()) {
//        echo "ok!";
//    } else {
//        foreach ($validation->erreurs() as $erreur) {
//            echo $erreur . '</br>';
//        }
//    }
//}
$erreurSaisie = Config::get('message/erreurSaisie');
$erreurLogin = Config::get('message/erreurLogin');
$erreur = Config::get('message/erreur');

$utilisateur = new User();
if ($utilisateur->etreLogger() && diffDate($utilisateur->donnees()->timeTokenUser)) {
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

if (Input::existe()) {
    if (Token::check(Input::get('tokenUser'))) {
        $valide = new Validation();
        $validation = $valide->check($_POST, [
            'mailUser' => [
                'nom'      => 'Adresse E-mail',
                'required' => true
            ],
            'pwdUser'  => [
                'nom'      => 'Mot de passe',
                'required' => true
            ],
        ]);

        if (!empty(Input::get('login-submit'))) {
            if ($validation->valider()) {

                $seSouvenir = (Input::get('remember') === 'on') ? true : false;
                $login = $utilisateur->login(Input::get('mailUser'), Hash::creer(Input::get('pwdUser'), $seSouvenir));

                if ($login) {
                    switch ($utilisateur->donnees()->profilUser) {
                        case 1:
                            Redirect::to('accueilEleve.php');
                            break;
                        case 2:
                            Redirect::to('accueilProfesseur.php');
                            break;
                    }
                } else {
                    $erreur = true;
                    $erreurLogin = true;
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
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">S'identifier</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="enregistrer.php" id="register-form-link">S'enregistrer</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- DEBUT FORMULAIRE S'IDENTIFIER -->
                            <form id="login-form" action="" method="post" role="form">
                                <div class="form-group">
                                    <input type="email" name="mailUser" id="mailUser" tabindex="1" class="form-control"
                                           placeholder="Adresse E-mail" value="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pwdUser" id="pwdUser" tabindex="2"
                                           class="form-control" placeholder="Mot de passe">
                                </div>
                                <div class="form-group text-center">
                                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                    <label for="remember">Se Souvenir de moi</label>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="tokenUser" id="tokenUser" tabindex="4"
                                           class="form-control" value="<?php echo Token::generer(); ?>">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="5"
                                                   class="form-control btn btn-login" value="Valider">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <a href="#" tabindex="6"
                                                   class="forgot-password">Mot de passe oublié?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- FIN FORMULAIRE S'IDENTIFIER -->

                        </div>
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
                    foreach ($validation->erreurs() as $erreurSaisie) {
                        echo $erreurSaisie . '</br>';
                    }
                }

                if ($erreurLogin) {
                    echo "Vos identifiants ne correspondent pas!";
                }
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- FIN MESSAGES ERREURS -->

<!-- Latest compiled and minified JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!--<script src="includes/js/scripts.js"></script>-->

</body>
</html>
