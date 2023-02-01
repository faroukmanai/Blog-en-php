<nav> 
        <a href="index.php?commande=Accueil">Accueil</a>
        <a href="index.php?commande=ListeArticles">Liste des articles</a>
        <a href="index.php?commande=FormRechercheArticle">Recherche d'articles</a>
        <a href="index.php?commande=formLogin">Login</a>
    </nav>
<?php 
echo"<section class='liste-article'>";
    if(mysqli_num_rows($articles) > 0){
        while($rangee = mysqli_fetch_assoc($articles)){
            echo "<div class='article'><h3>" . $rangee["titre"] . "</h3><p>" . $rangee["texte"] . "</p><p class='auteur'>" . $rangee["idAuteur"] . "</div>";
        }   
    } 
    if(isset($_SESSION['message'])){ 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
?>


