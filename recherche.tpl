<div class="span8">
              <!-- notifications -->
{if $count > 0}

<div class="alert-xs alert-success" role="alert">
    <h3> Voici le résultat de la recherche ({$count} Résultat(s) )</h2>
</div>

                {foreach from=$tab_rech item=$value}
                    
                <h2>{$value['titre']}</h2><!-- affichage titre-->
                <img src='img/{$value['id']}.jpg' width='100px'alt="{$value['id']}"/><!-- affichage icone-->
                <!-- contenu -->
                <p style="text-align:justify;"> {$value['texte']}</p>
                <p><em><u> Publié le {$value['date_fr']}</u></em></p>
                <!--affichage date publication-->
                {if $connect==TRUE} 
                <a class="btn btn-mini btn-primary" href="article.php?id={$value['id']}">MODIFIER</a>
                <a class="btn btn-mini btn-primary" href="index.php">Commenter</a>
              {/if}
             
                {/foreach}
               
                <div class="pagination">
                    <ul>
                        <li><a>Page :</a></li> 
            
{for $i=1;$i<=$nb_pgcre;$i++ }        
         <ul>
<li><a href="recherche.php?recherche={$recherche}&p={$i}">{$i}</a></li>
</ul>   
</ul>
 {/for}
                </div>
                {else}
                    <div class="alert alert-error" role="alert">
    <h3>Nous avons trouver aucun résultat</h3>
</div>
                {/if}
          </div>