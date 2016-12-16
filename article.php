<?php

$verif=FALSE;

session_start();

require_once 'settings/bdd.inc.php'; //permet la connection à la base de données
require_once 'settings/init.inc.php'; //permet l'affichage des erreurs

if (isset($_POST['ajouter']) OR isset($_POST['modifier'])){

    print_r($_POST);

    print_r($_FILES);
//exit();

    $date_ajout = date("Y-m-d");

    $_POST['date_ajout'] = $date_ajout;

    if (isset($_POST['publie'])) {
        $_POST['publie'] = 1;
    } else {
        $_POST['publie'] = 0;
    }


    if ($_FILES['image']['error'] == 0) {

        if(isset($_POST['ajouter'])){
            
        $sth = $bdd->prepare("INSERT INTO article (titre, texte, publie, date) VALUES(:titre, :texte, :publie, :date)");
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT);
        $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_STR);

        $sth->execute();

        $id = $bdd->lastInsertId();


        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg"); //afin de transférer l'image

        $_SESSION['ajout_article'] = TRUE;

        header("Location: article.php");
    } 
    
    else if(isset($_POST['modifier'])){
        
        $id_lien = $_POST['id'];
        
        $sth = $bdd->prepare("UPDATE article SET titre = :titre, texte = :texte, publie = :publie, date = :date WHERE id = '$id_lien' ");
        
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT);
        $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_STR);

        $sth->execute();

        $id = $_POST['id'];


        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$id.jpg"); //afin de transférer l'image

        $_SESSION['modif_article'] = TRUE;

        header("Location: article.php");
        
    }
        
        
        
    else {
        echo"Image Error";
    }
    }
//condition ternaire
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;
} else {
    include_once 'includes/header.inc.php';
    if(isset($_GET['id'])){
        $select = $bdd -> prepare ("select * FROM article WHERE id = :id");//preparation de la requete
        $select->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //Sécuriser les variables
        $select->execute(); //executer la requete
        $tab_id = $select->fetchAll(PDO::FETCH_ASSOC); //Pousse le résultat sql dans un tableau php
    }
    ?>

    <div class="span8">
    <?php
    if (isset($_SESSION['ajout_article'])) {
        ?>
            <div class="alert alert-warning alert-dismissible" role="alert">

                <strong>Félicitation! </strong> Votre article a été ajouté.
            </div>
        <?php
        unset($_SESSION['ajout_article']);
    }
    ?>
        
        <?php
    if (isset($_SESSION['modif_article'])) {
        ?>
            <div class="alert alert-warning alert-dismissible" role="alert">

                <strong>Félicitation! </strong> Votre article a été modifié.
            </div>
        <?php
        unset($_SESSION['modif_article']);
    }
    ?>
        <!-- contenu -->

        <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
            <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $tab_id[0]['id'];}?>"/>
            
            <div class="clearfix">
                <label for="titre">Titre</label>
                <div class="input"><input type="text" name="titre" id="titre" value="<?php if(isset($_GET['id'])){echo $tab_id[0]['titre'];}?>"></div>
            </div>

            <div class="clearfix">
                <label for="texte">Texte</label>
                <div class="input"><textarea name="texte" id="texte"><?php if(isset($_GET['id'])){echo $tab_id[0]['texte'];}?></textarea></div>
            </div>

            <div class="clearfix">
                <label for="image">Image</label>
                <div class="input"><input type="file" name="image" id="image"><?php //if(isset($_GET['id'])){echo $tab_id[0]['image'];}?></div>
            </div>

            <div class="clearfix">
                <label for="publie">Publié</label>
                <div class="input"><input type="checkbox" name="publie"<?php if(isset($_GET['id'])){echo 'checked';}else{echo'';}?> id="publie"></div>
            </div>

            <div class="form-actions">
                <input type="submit" name="<?php if(isset($_GET['id'])){echo 'modifier';}else{  echo'ajouter';}?>" value="<?php if(isset($_GET['id'])){echo 'Modifier';}else{  echo'Ajouter';}?>" class="btn btn-large btn-primary">
            </div>

        </form>

    </div>


    <?php
}
include_once 'includes/menu.inc.php'; //renvoi à la page PHP incluant le menu
include_once 'includes/footer.inc.php'; //renvoi à la page PHP incluant le footer
?>


