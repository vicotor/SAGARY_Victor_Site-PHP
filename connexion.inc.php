<?php


//Vérification de la présence du cookie et qu'il soit conforme
if (isset($_COOKIE['sid'])&& !empty($_COOKIE['sid'])){
    $sid = $_COOKIE['sid'];
    $sth = $bdd->prepare("select * from utilisateur where sid = :sid");
    $sth->bindValue(':sid',$sid, PDO::PARAM_STR);
    $sth->execute();
    
    $verif=TRUE;
} 
else{
    $verif=FALSE;
}
?>

