<?php

session_start();
$connect = false;
require_once 'settings/bdd.inc.php'; //inclure le fichier bdd
require_once 'settings/init.inc.php'; //inclure le fichier initialisation 
include_once'includes/header.inc.php'; //inclure le fichier header
require_once('libs/Smarty.class.php'); //inclure le fichier lib smarty

if (isset($_GET['recherche'])) {
    $nb_artpg = 2; //declaration variable nbr par page
    $pgco = isset($_GET['p']) ? $_GET['p'] : 1; //dÈclaration de la variable qui contient la page courant  
    $debut = ($pgco - 1 ) * $nb_artpg; //calculer nb message publie dans la table & index de dÈpart
    $recherche = $_GET['recherche']; //affectation de la valeur de recherche
 $sth = $bdd->prepare("SELECT id,titre,texte,DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM article WHERE texte LIKE :recherche OR titre LIKE :recherche "); //prÈparation de la rÍquete
    $sth->bindvalue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
    $sth->execute(); //execute la requete
    $count = $sth->rowCount(); //compte resultat
    $sth = $bdd->prepare("SELECT id,titre,texte,DATE_FORMAT(date,'%d/%m/%Y') as date_fr FROM article WHERE texte LIKE :recherche OR titre LIKE :recherche LIMIT $debut,$nb_artpg "); //prÈparation de la rÍquete
    $sth->bindvalue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
    $sth->execute(); //execute la requete
    
    $tab_rech = $sth->fetchAll(PDO::FETCH_ASSOC);
     if ($count>0) {
        $nb_pgcre = ceil($count / $nb_artpg); // calcule de page a creer 
    }
//echo $count;
//print_r($tab_rech);
    
    
    $smarty = new Smarty();
    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
    if (isset($connect)) {
        $smarty->assign('connect', $connect);
    }
    if (isset($nb_pgcre)) {
        $smarty->assign('nb_pgcre', $nb_pgcre);
    }
    if (isset($count)) {
        $smarty->assign('count', $count);
    }
    if (isset($recherche)) {
        $smarty->assign('recherche', $recherche);
    }
    if (isset($tab_rech)) {
        $smarty->assign('tab_rech', $tab_rech);
    }
    $smarty->debugging = true;
    $smarty->display('recherche.tpl');
}

include_once'includes/menu.inc.php'; //inclusion menu
include_once'includes/footer.inc.php'; //inclusion footer