<?php

session_start();
require_once 'settings/bdd.inc.php'; //permet la connection à la base de données
require_once 'settings/init.inc.php'; //permet l'affichage des erreurs
include_once 'includes/header.inc.php'; //renvoi à la page PHP incluant le header
include_once 'settings/connexion.inc.php';
//include_once 'commentaire.php';

$nb_article_par_page = 2;

//Variable qui contient la page courante :
$page_courante = isset($_GET['p']) ? $_GET['p'] : 1;

function returnIndex($nb_article_par_page, $page_courante) {
//calcul des éléments
    $debut = ($page_courante - 1) * $nb_article_par_page;
    return $debut;
}

//$resultat = ($page_courante - 1 ) * $nb_article_par_page;
//Calculer l'index de départ de la requete
//echo  '<br/><h2><b>Page : ' . $page_courante . ' - Index de départ : <u>' . $resultat . '</u></b></h2>';
$indexdepart = returnIndex($nb_article_par_page, $page_courante);
$idx = $bdd->prepare("SELECT COUNT(*) as nbArticles FROM article WHERE publie = :publie"); //préparation de la requete//
$idx->bindValue(':publie', 1, PDO::PARAM_INT); //Sécuriser les variables    
$idx->execute(); //executer la requete
$tab_article = $idx->fetchAll(PDO::FETCH_ASSOC); //Pousse le résultat sql dans un tableau php
//print_r($tab_article);
$nbArticles = $tab_article[0]['nbArticles'];

//echo "Nombre d'Article : " . $nbArticles;
//Calculer le nombre d'article publiés dans la table
$nbpages = ceil($nbArticles / $nb_article_par_page);

//echo "<br> Nombre de page(s) : " . $nbpages . "</br>";
//$nb_total_page = ceil ($total / message par page)




//echo 'Index de départ par fonction : ' . $indexdepart;

$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y')as date_fr FROM article WHERE publie = :publie LIMIT $indexdepart, $nb_article_par_page"); //préparation de la requête

$sth->bindValue(':publie', 1, PDO::PARAM_INT); //sécuriser les variables

$sth->execute();



$tab_article = $sth->fetchAll(PDO::FETCH_ASSOC);

//print_r($tab_article);
?>
<div class="span8">
    <!-- notifications -->
    <?php
    if (isset($_SESSION['connexion_ok'])) {
        ?>
            <div class="alert alert-success" role='alert'>

                <strong>Bienvenue! </strong> Vous êtes connecté.
            </div>
        <?php
        unset($_SESSION['connexion_ok']);
    }
    ?>
    <!-- contenu -->

    <?php
    foreach ($tab_article as $value) {
        ?>
        <h2><?php echo $value['titre'] ?></h2>

        <img src="img/<?php echo $value['id'] ?>.jpg" width="100px" alt="<?php echo $value['titre'] ?>"/>
        <p style="text-align: justify;"><?php echo $value['texte'] ?></p>
        <p><em><u> Publié le : <?php echo $value['date_fr'] ?></u></em></p>
        <?php if($verif==TRUE){ //if (isset($SESSION) && $SESSION=TRUE) { ?>
            <li><a href = "article.php?id=<?= $value['id'] ?>"><?php echo"Modifier" ?></a></li>
        <?php } ?>
        
        
        <?php
    
        }
        //}
    ?>
    <div class="pagination">
        <ul>
            <li><a>Page : </a></li>
            <?php for ($i = 1; $i <= $nbpages; $i++) { ?>

            <li<?php if($page_courante == $i){?> class="active" <?php }?>><a href = "index.php?p=<?= $i ?>"><?= $i ?></a></li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
<?php
include_once 'includes/menu.inc.php'; //renvoi à la page PHP incluant le menu
include_once 'includes/footer.inc.php'; //renvoi à la page PHP incluant le footer
?>