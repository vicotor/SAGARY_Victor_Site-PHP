<?php
//$verif=FALSE;
unset($_COOKIE['sid']);
session_start();
require_once 'settings/bdd.inc.php'; //permet la connection à la base de données
require_once 'settings/init.inc.php'; //permet l'affichage des erreurs
require_once('libs/Smarty.class.php');



if (isset($_POST['connexion'])) {

    $sth = $bdd->prepare("SELECT * FROM utilisateur WHERE email = :email AND mdp = :mdp");
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
    $sth->execute();
    $count = $sth->rowCount();

    if ($count > 0) {

        $tab_connexion = $sth->fetchAll(PDO::FETCH_ASSOC);
        $email = $tab_connexion[0]['email'];

        $sid = md5($email . time());
        $sth = $bdd->prepare("UPDATE utilisateur SET sid = :sid WHERE email = :email");
        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        $sth->bindValue(':sid', $sid, PDO::PARAM_STR);
        $sth->execute();

        setcookie('sid', $sid, time() + 30);
        $_SESSION['connexion_ok'] = TRUE;
        header("Location: index.php");
    } else {
        $_SESSION['connexion_nok'] = TRUE;
        header("Location: connexion.php");
    }
} else {
    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
    //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
    //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

    if (isset($_SESSION['connexion_nok'])) {
        $smarty->assign('connexion_nok', $_SESSION['connexion_nok']); //Permet le passage de php a smarty
    }

    unset($_SESSION['connexion_nok']);

    //** un-comment the following line to show the debug console
    $smarty->debugging = true;

    include_once 'includes/header.inc.php';
    $smarty->display('connexion.tpl');

    include_once 'includes/menu.inc.php'; //renvoi à la page PHP incluant le menu
    include_once 'includes/footer.inc.php'; //renvoi à la page PHP incluant le footer
     
}
?>