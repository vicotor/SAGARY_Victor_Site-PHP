<div class="span8">
    <!-- notifications -->
 
       {if isset($connexion_nok)}
    <div class="alert alert-error" role='alert'>

        <strong>Attention! </strong> Identifiants incorrects.
    </div>
    {/if}
    

    <!-- contenu -->
 
        <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">

            <div class="clearfix">
                <label for="email">Login</label>
                <div class="input"><input type="text" name="email" id="login" value=""></div>
            </div>

            <div class="clearfix">
                <label for="mdp">Mot de passe</label>
                <div class="input"><input type="password" name="mdp" id="mdp" value=""></div>
            </div>

            <div class="form-actions">
                <input type="submit" name="connexion" value="Connexion" class="btn btn-large btn-primary">
            </div>

        </form>

    </div>