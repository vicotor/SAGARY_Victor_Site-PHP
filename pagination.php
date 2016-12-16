<?php
require_once 'settings/bdd.inc.php';        //permet la connection à la base de données
require_once 'settings/init.inc.php';       //permet l'affichage des erreurs
include_once 'includes/header.inc.php';     //renvoi à la page PHP incluant le header


$nb_article_par_page = 2;
        
//Variable qui contient la page courante :
$page_courante = isset($_GET['p'])? $_GET['p'] : 1; 

function returnIndex($nb_article_par_page, $page_courante){
//calcul des éléments
    $debut=($page_courante - 1) * $nb_article_par_page;
    return $debut;
}


//$resultat = ($page_courante -1 ) * $nb_article_par_page;
$indexdepart = returnIndex($nb_article_par_page, $page_courante);
//Calculer l'index de départ de la requete
//echo  '<br/><h2><b>Page : ' . $page_courante . ' - Index de départ : <u>' . $resultat . '</u></b></h2>';

$sth = $bdd->prepare ("SELECT COUNT(*) as nbArticles FROM article WHERE publie = :publie "); //préparation de la requete//
$sth->bindValue(':publie', 1, PDO::PARAM_INT); //Sécuriser les variables    
$sth->execute(); //executer la requete
$tab_article = $sth->fetchAll(PDO::FETCH_ASSOC); //Pousse le résultat sql dans un tableau php
//print_r($tab_article);
$nbArticles = $tab_article[0]['nbArticles'];

echo "Nombre d'Article : " . $nbArticles;

//Calculer le nombre d'article publiés dans la table
$nbpages = ceil($nbArticles / $nb_article_par_page);

echo "<br> Nombre de page(s) : " . $nbpages . "</br>";
//$nb_total_page = ceil ($total / message par page)

echo 'Index de départ par fonction : ' . $indexdepart; 



?>

