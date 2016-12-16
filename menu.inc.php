<?php
require_once 'settings/connexion.inc.php';
?>

<nav class="span4">
    <h3>Menu</h3>

    <form action="recherche.php" method="get" enctype="multipart/form-data" id="form_recherche">

        <div class="clearfix">
            <div class="input"><input type="text" name="recherche" id="recherche" placeholder="Votre recherche ..."></div>
        </div>

        <div class="form-inline">
            <input type="submit" name="" value="rechercher" class="btn btn-mini btn-primary">
        </div>

    </form>

    <ul>
        <li><a href="index.php">Accueil</a></li>

        <?php if ($verif == true) { ?>
            <li><a href="article.php">Rédiger un article</a></li>
        <?php } ?>
        <li><a href="connexion.php"><?php
                // Ces lignes de commande php permettent le réglage de l'affichage en fonction de la connexion
                if ($verif == true) {
                    echo'Déconnexion';
                    unset($_SESSION['connexion_ok']);
                    unset($verif);
                } else {
                    echo'Connexion';
                    $incript = true; // Variable pour l'affichage de l'option inscription
                    unset($_SESSION['connexion_ok']);
                    //unset($verif);
                }
                ?></a></li>
        

        <!--
        <?php //if ($SESSION == TRUE) {  ?>
        <li><a href="article.php">Rédiger un article</a></li>
        <li><a href="index.php">Déconnexion</a></li>
<?php // } 
//else { 
?>
        <li><a href="connexion.php">Connexion</a></li>
        <?php // }  ?> -->
    </ul>

</nav>
</div>

