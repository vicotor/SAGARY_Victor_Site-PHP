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
                <div class="input"><input type="file" name="image" id="image"><?php if(isset($_GET['id'])){echo $tab_id[0]['image'];}?></div>
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