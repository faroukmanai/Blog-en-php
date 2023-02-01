<?php
    if(isset($_SESSION['usager'])){
       echo" <nav>
        <a href='index.php?commande=Accueil'>Accueil</a> 
        <a href='index.php?commande=ListeArticles'>Liste des articles</a>
        <a href='index.php?commande=FormRechercheArticle'>Recherche d'articles</a>
        
        <a href='index.php?commande=Logout'>Logout</a>
        </nav> ";
    }
    else{
        echo" <nav>
        <a href='index.php?commande=Accueil'>Accueil</a> 
        <a href='index.php?commande=ListeArticles'>Liste des articles</a>
        <a href='index.php?commande=FormRechercheArticle'>Recherche d'articles</a>
        <a href='index.php?commande=FormLogin'>Login</a>
        </nav> ";
    }
    ?>


<div class="formulaireAjout"> 
    <h1>Ajouter un article </h1>
    <form method="get" action="index.php" class="formulaire-Ajout">
        
        Titre : <input type="text" name="titre" class="champ-recherche"/>
        texte : <textarea name="texte" class="champ-recherche"></textarea>

        <input type="hidden" name="idAuteur" value="<?= $_SESSION['usager']?>" />
        <input type="hidden" name="commande" value="ajoutArticle" />
        <input type="submit" value="Ajouter" class="btn-submit"/>
    </form>
</div>
<p style="text-align:center; color:red">
<?php 
    if(isset($_SESSION['message'])){ 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>
</p>