<?php

try {
    $bdd = new PDO ('mysql:host=mysql.hostinger.fr;dbname=u225238200_saga;charset=utf8', 'u225238200_saga', 'Victor590');
    $bdd->exec("set names utf8");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : '. $e->getMessage());
}
?>