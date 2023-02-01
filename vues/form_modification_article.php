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
   
while($rangee = mysqli_fetch_assoc($articles)){
    if(isset($_SESSION['usager'])) { 
?> 

<div class="formulaireAjout"> 
    <h1>Modifier un article </h1>
    <form method="POST" action="index.php" class="formulaire-Ajout">
        
        Titre : <input type="text" name="titre"  required class="champ-recherche" value="<?= $rangee["titre"]?>"/>
        texte : <textarea name="texte" requiredclass="champ-recherche" ><?= $rangee["texte"]?></textarea>

        <input type="hidden" name="id" value="<?= $rangee["id"]?>" />
        <input type="hidden" name="idAuteur" value="<?= $_SESSION['usager']?>" />
        <input type="hidden" name="commande" value="modifierArticle" />
        <input type="submit" name="btnSubmit" value="Modifier" class="btn-submit"/>
    </form>
</div>
<?php
    } 
} 
if (isset($message))
    echo "<p>" . $message . "</p>";
    
?>