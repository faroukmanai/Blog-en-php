<?php 
define("SERVER", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
define("DBNAME", "Articles");

//Connexion à la BD:
function connectDB()
    {
        //se connecter à la base de données
        $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

        if(!$c)
        {
            die("Erreur de connexion. MySQLI : " . mysqli_connect_error());
        }

        //s'assurer que la connexion traite le utf8
        mysqli_query($c, "SET NAMES 'utf8'");

        return $c;
    }
    $connexion = connectDB();

//Fonction pour obtenir la liste des articles:
function obtenir_articles(){
    global $connexion;
    $requete = "SELECT id,titre, texte, idAuteur FROM article JOIN usager ON usager.username = article.idAuteur ";
    //exécuter la requête avec mysqli
    $resultats = mysqli_query($connexion, $requete);
    //retourner le résultat
    return $resultats;
}

//Fonction pour recherche d'article
function recherche_article($texte){
    global $connexion;
    $requete = "SELECT titre, texte, idAuteur,id FROM article WHERE titre LIKE ? OR texte LIKE ? OR idAuteur LIKE ? ";
    //2. préparer la requête
    $reqPrep = mysqli_prepare($connexion, $requete);
    if($reqPrep){
        $texte = "%$texte%";
        //3.faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
        mysqli_stmt_bind_param($reqPrep, "sss", $texte, $texte, $texte);
        //4.exécuter la requête préparée et retourner le résultat...
        mysqli_stmt_execute($reqPrep);
        $resultats = mysqli_stmt_get_result($reqPrep);
        return $resultats;
    }
    else
        die("Erreur de requête..");
}
//Fonction pour ajouter un article
function ajouter_article($id, $titre, $texte){
        global $connexion;
         $requete = "INSERT INTO article (idAuteur, titre , texte) VALUES (?, ?, ?)";
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);
        if($reqPrep)
        {
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "sss", $id, $titre, $texte);
            //4. exécuter la requête préparée et retourner le résultat...
            return mysqli_stmt_execute($reqPrep);
        }
        else
            die("Erreur de requête préparée...");
    }
    function login($user, $pass)
    {
        //obtenir la connexion définie plus haut (à l'extérieur de la fonction)
        global $connexion;

        //1. déclarer la requête SQL à exécuter avec des ? pour tout ce qui est paramétré et provient de l'usager
        $requete = "SELECT * FROM usager WHERE username = ?";
        //2. préparer la requête 
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            //3. Faire le lien entre les paramètres envoyés par l'usager ET les ? contenus dans la requête
            mysqli_stmt_bind_param($reqPrep, "s", $user);
            //4. exécuter la requête préparée
            mysqli_stmt_execute($reqPrep);
            //5. comme c'est un select j'ai besoin des résultats
            $resultats = mysqli_stmt_get_result($reqPrep);
        
            //il y a un usager dont le username est celui envoyé en paramètres
            if(mysqli_num_rows($resultats) > 0)
            {
                //est-ce que le mot de passe encrypté dans la BD peut être obtenu en encryptant celui envoyé par l'usager
                $usager = mysqli_fetch_assoc($resultats);
                $passwordHash = $usager["motDePasse"];

                $verification = password_verify($pass, $passwordHash);

                if($verification)
                    return $usager["username"];
                else 
                    return false;
                
            }
            else 
                return false;
        }
    }

    function supprimer_article($id, $idAuteur) {
        global $connexion;
        $requete = "DELETE FROM article WHERE article.id = ? and article.idAuteur = ?";
        $reqPrep = mysqli_prepare($connexion, $requete);
        if($reqPrep) {
            mysqli_stmt_bind_param($reqPrep, "is", $id, $idAuteur);
            mysqli_stmt_execute($reqPrep);
            if(mysqli_affected_rows($connexion)>0)
                return true;
            else    
                return false;
        } else {
            die("Erreur de requête...");
        }
    }
    
    
    function obtenir_article_par_id($id){
        global $connexion;
        $requete = "SELECT titre, texte, idAuteur,id FROM article WHERE id=?";
        // préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);
        if($reqPrep)
        {
            // lier les paramètres à la requête
            mysqli_stmt_bind_param($reqPrep, "i", $id);
            // exécuter la requête
            mysqli_stmt_execute($reqPrep);
            // récupérer les résultats de la requête
            $resultats = mysqli_stmt_get_result($reqPrep);
            return $resultats;
        }
        else
            die("Erreur de requête...");
    }
    
    function modifie_article($titre, $texte, $id, $idAuteur) {
        global $connexion;
        $requete = "UPDATE article SET titre=?, texte = ? WHERE id = ? AND idAuteur = ?";
        // préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);
        if($reqPrep) {
            // lier les paramètres à la requête
            mysqli_stmt_bind_param($reqPrep, "ssis", $titre, $texte, $id, $idAuteur);
            return mysqli_stmt_execute($reqPrep);
        } else {
            die("Erreur de requête...");
        }
    }
    
    

?>