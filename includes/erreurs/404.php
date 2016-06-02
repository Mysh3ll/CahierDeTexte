<?php
/**
 * Created by PhpStorm.
 * User: Michel
 * Date: 22/05/2016
 * Time: 14:31
 */
require_once 'config/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>404 Caveman</title>
    <meta name="author" content="name"/>
    <meta name="keywords" content="404, css3, html5, template"/>
    <meta name="description" content="404template"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template CSS -->
    <link type="text/css" media="all" href="includes/css/style404.css" rel="stylesheet"/>
    <!-- Responsive CSS -->
    <link type="text/css" media="all" href="includes/css/responsive404.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link
        href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,800italic,800,700italic,700,600italic,600,400italic,300'
        rel='stylesheet' type='text/css'/>
</head>
<body>
<!-- Header -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>404</h1>
                <h2>Page non trouvée</h2>
                <p>Nous sommes délosé, mais il y a eu une erreur.</p>
            </div>
        </div>
    </div>
</section>
<!-- end Header -->

<!-- Illustration -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="illustration">
                    <div class="laptop"></div>
                    <div class="hand"></div>
                    <div class="caveman"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Illustration -->

<!-- Button -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <a href="index.php">
                    <div class="btn btn-action">Sortir d'ici !</div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- end Button -->

<!-- Footer -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>CAHIER 2 TXT ® -Toute reproduction interdite sans l'autorisation de l'auteur-</p>
            </div>
        </div>
    </div>
</section>
<!-- end Footer -->

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>
<?php //echo Redirect::getMessage() ?>
