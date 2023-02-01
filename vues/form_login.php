
   <?php 

   //si j'arrive du formulaire
   if(isset($_POST["btnSubmit"]))
   {
       //vérifier que l'usager a entré une BONNE combinaison
       $usager = login($_POST["user"], $_POST["pass"]);

       //si l'usager retourné n'est pas false, c'est un usager valide
       if($usager !== false)
       {
           //nous sommes authentifiés, stocker le nom d'usager authentifié dans $_SESSION
           $_SESSION["usager"] = $usager;
           header("Location: index.php?commande=ListeArticles");
           die();
       }
       else 
       {
           $message = "Mauvaise combinaison username / password.";
       }
   }
?> 
<nav> 
    <a href="index.php?commande=Accueil">Accueil</a>
    <a href="index.php?commande=ListeArticles">Liste des articles</a>
    <a href="index.php?commande=FormRechercheArticle">Recherche d'articles</a>
    <a href="index.php?commande=FormLogin">Login</a>
</nav>
<div class="formulaireRecherche"> 
<h1>Formulaire d'authentification</h1>
<form method="POST" class="formulaire-recherche">
    Nom d'usager : <input type="text" name="user" class="champ-recherche"/><br>
    Mot de passe : <input type="password" name="pass" class="champ-recherche"/><br>
    <input type="submit" name="btnSubmit" value="Login" class="btn-submit"/>
</form>
</div> 

<p style="text-align:center; color:red"><?php if(isset($message)) echo $message; ?></p>
