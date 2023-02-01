<?php 

session_start();

if (isset($_REQUEST["commande"])) {
    $commande = $_REQUEST["commande"];
} else {
    //si'il n'y a pas  de commande on se dirige vers la page d'accueil
    $commande = "Accueil";
}
require_once("modele.php");
switch ($commande) {
    case "Accueil":
        $titre = "Page d'accueil";
        //afficher les vues
        require_once("vues/header.php");
        require("vues/accueil.html");
        require_once("vues/footer.php");
        break;
    case "FormLogin":
        //on va déclarer les variables dont on a besoin pour cette commande 
        $titre = "Formulaire de login";
        //afficher les vues
        require_once("vues/header.php");
        require("vues/form_login.php");
        require_once("vues/footer.php");
        break; 
    case "Login":
        if(isset($_REQUEST["user"], $_REQUEST["pass"])){
            //vérifier que l'usager a entré une BONNE combinaison
            $usager = login($_REQUEST["user"], $_REQUEST["pass"]);
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
        else{
            header("Location: index.php");
            die(); 
        }
            break;
    case "Logout":
        // Unset all of the session variables.
        $_SESSION = array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header("Location: index.php?commande=FormLogin");

    case "ListeArticles":
        $titre = "Liste des articles";
        $articles = obtenir_articles();
        //afficher les vues
        require_once("vues/header.php");
        require("vues/liste_des_articles.php");
        require_once("vues/footer.php");
        break;
    
    case "FormRechercheArticle";
        $titre = "Formulaire de recherche d'article";
        //afficher les vues
        require_once("vues/header.php");
        require("vues/form_recherche_articles.php");
        require_once("vues/footer.php");
        break;

    case "rechercheArticle";
    // si le champ de recherche a reçu un texte de recherche (pas vide!)
        if (isset($_REQUEST["texteRecherche"]) && !empty($_REQUEST["texteRecherche"])) {
            // appelle la fonction "recherche_article" avec le texte de recherche en paramètre et stocke le résultat dans la variable $articles
            $articles = recherche_article($_REQUEST["texteRecherche"]);
            if($articles){
            //afficher les vues
            $titre = "Article recherché";
            require_once("vues/header.php");
            require("vues/article_recherche.php"); 
            require_once("vues/footer.php"); 
            }else
            {
                header("Location: index.php?commande=FormRechercheArticle");
                $message = "Aucun résultat pour cette recherche";
                $_SESSION['message'] = $message;
            } 
        } 
        // Si le champ de recherche est vide  
        else{
            //reseter sur le formulaire et ajouter un message
            header("Location: index.php?commande=FormRechercheArticle");
            $message = "Veuillez remplir le champ de recherche";
            $_SESSION['message'] = $message;
        }
        break;

    case "formAjoutArticle";
        //vérifie s'il y a une session en cours 
        if(isset($_SESSION['usager'])){
            $titre = "Formulaire d'ajout article";
            //afficher les vues
            require_once("vues/header.php");
            require("vues/form_ajout_article.php");
            require_once("vues/footer.php");
        }else{
            // Si l'utilisateur n'est pas connecté, il est redirigé vers la page d'accueil.
            header("Location: index.php?");
        }
        break;

    case "ajoutArticle";
        // vérifie que les champs "titre" et "texte" ont été remplis 
        if(empty($_REQUEST["titre"]) || empty($_REQUEST["texte"])) {
            // Si ces champs sont vides, un message d'erreur est affiché
            $message = "Le titre et le texte sont des champs obligatoires";
            $_SESSION['message'] = $message;
            header("Location: index.php?commande=formAjoutArticle");
            
        } else {
            // Si les champs sont remplis appelle la fonction ajouter_article() du modèle
            $articles = ajouter_article($_REQUEST["idAuteur"], $_REQUEST["titre"], $_REQUEST["texte"]);
            if ($articles) {
                //Redirection vers la liste des articles si c'est un succes
                header("Location: index.php?commande=ListeArticles");
            }
        }
        break;

        case "supprimerArticle":
            // on vérifie si l'identifiant de l'article et de l'auteur ont été envoyés dans la requête et si l'utilisateur connecté est l'auteur de l'article
            if(isset($_REQUEST["id"], $_REQUEST["idAuteur"]) && $_REQUEST["idAuteur"] == $_SESSION["usager"]){
                // appel de la fonction en envoyant l'identifiant de l'auteur
                $resultat = supprimer_article($_REQUEST["id"], $_REQUEST["idAuteur"]);
                if($resultat)
                    header("Location: index.php?commande=ListeArticles");
                else
                    header("Location: index.php?commande=ListeArticles");
            }
            break;
    
    case "FormModificationArticle":
        //vérifie si l'identifiant de l'article et de l'auteur ont été envoyés dans la requête et si l'utilisateur connecté est l'auteur de l'article.
        if(isset($_REQUEST["id"],$_REQUEST["idAuteur"]) && ($_SESSION['usager'] == $_REQUEST["idAuteur"])){
            // appel de la fonction
            $articles = obtenir_article_par_id($_REQUEST["id"]);
            // si l'article existe
            if($articles) {
                $titre = "Modification article";
                require_once("vues/header.php");
                require("vues/form_modification_article.php");
                require_once("vues/footer.php");
            //Sinon, il redirige vers une page d'erreur avec un message 
            } else {
                header("Location: index.php?error=article pas trouvé!");
            }
        }
        //Si l'utilisateur n'est pas l'auteur de l'article, il redirige vers l'index
        else{
            header("Location: index.php?error");
        }
        break;
        
        case "modifierArticle":
            if(isset($_REQUEST["titre"],$_REQUEST["texte"],$_REQUEST["id"],$_REQUEST["idAuteur"]) && !empty($_REQUEST["titre"]) && !empty($_REQUEST["texte"]) && ($_SESSION['usager'] == $_REQUEST["idAuteur"])){
                $article = modifie_article($_REQUEST["titre"], $_REQUEST["texte"],$_REQUEST["id"], $_REQUEST["idAuteur"]);
                if($article){
                    header("Location: index.php?commande=ListeArticles");
                }
                else
                    header("Location: index.php?");
            }else
                {
                header("Location: index.php?FormModificationArticle");
                die();
                }
            break;
    

    default:
        header("Location: index.php");
        die(); 
}

?>