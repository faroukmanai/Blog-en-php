<nav> 
    <a href="index.php?commande=Accueil">Accueil</a>
    <a href="index.php?commande=ListeArticles">Liste des articles</a>
    <a href="index.php?commande=FormRechercheArticle">Recherche d'articles</a>
</nav>

<div class="formulaireRecherche">
    <h1>Recherche des articles</h1>
    <form method="GET" action="index.php" class="formulaire-recherche">
        Recherche des articles : <input type="text" name="texteRecherche"  class="champ-recherche"/><br>
        <input type="hidden" name="commande" value="rechercheArticle" /><br>
        <input type="submit" value="Rechercher" class="btn-submit"/>
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