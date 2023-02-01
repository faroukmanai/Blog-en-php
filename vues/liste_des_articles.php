
    <?php
    if(isset($_SESSION['usager'])){
       echo" <nav>
        <a href='index.php?commande=Accueil'>Accueil</a> 
        <a href='index.php?commande=ListeArticles'>Liste des articles</a>
        <a href='index.php?commande=FormRechercheArticle'>Recherche d'articles</a>
        <a href='index.php?commande=formAjoutArticle'>Ajouter un article</a>
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
    
<h1>Liste des articles</h1> 
<section class="liste-article"> 
<?php
while ($rangee = mysqli_fetch_assoc($articles)){
   if(isset($_SESSION['usager'])) { 
        if($rangee['idAuteur'] == $_SESSION['usager'])
        { 
            echo "<div class='article'><h3>" . htmlspecialchars($rangee["titre"]) . "</h3><p>" . htmlspecialchars($rangee["texte"]) . "</p><p class='auteur'>" . htmlspecialchars($rangee["idAuteur"]) ."<br>". "<a href='index.php?commande=FormModificationArticle&id=" . $rangee['id']. "&idAuteur=" . htmlspecialchars($rangee['idAuteur']) . "'> Modifier l'artcile</a><br><a href='index.php?commande=supprimerArticle&id=" . $rangee['id']. "&idAuteur=" . htmlspecialchars($rangee['idAuteur']) . "'> Supprimer l'article</a><br><a href='index.php?commande=formAjoutArticle&idAuteur=" . htmlspecialchars($rangee['idAuteur']). "'>Ajouter un article</a></div>";

        }
        else{
            echo "<div class='article'><h3>" . htmlspecialchars($rangee["titre"]) . "</h3><p>" . htmlspecialchars($rangee["texte"]) . "</p><p class='auteur'>" . htmlspecialchars($rangee["idAuteur"]) . "</div>";
        }
    }
    else
    {
        echo "<div class='article'><h3>" . htmlspecialchars($rangee["titre"]) . "</h3><p>" . htmlspecialchars($rangee["texte"]) . "</p><p class='auteur'>" . htmlspecialchars($rangee["idAuteur"]) . "</div>";
    }
}

?>
</section>