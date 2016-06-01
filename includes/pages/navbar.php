<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 31/05/2016
 * Time: 17:10
 */
?>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Cahier de texte</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-center">
                <li class="active "><a href="accueilEleve.php"><span class="glyphicon glyphicon-home"></span> Accueil</a></li>
                <li><a href="miseAJour.php"><span class="glyphicon glyphicon-user"></span> Modifier son profil</a></li>
                <li><a href="changerPassword.php"><span class=" glyphicon glyphicon-cog"></span> Modifier mot de passe</a></li>
            </ul>
            <!-- BEGIN # DECONNECT -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Se Déconnecter</a></li>
            </ul>
            <!-- END # DECONNECT -->
        </div><!--/.nav-collapse -->
    </div>
</nav>
