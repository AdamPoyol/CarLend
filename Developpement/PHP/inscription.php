<?php

// Inscription

if(!empty($_POST['inscription'])) {

    // on récupère les données

    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $telephone = $_POST['telephone'];
    $mail = $_POST['mail'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postale = $_POST['code_postale'];
    $lien_photo = $_POST['lien_photo'];
    $date_adhesion = date("Y-m-d");

    $bdd = new mysqli("localhost", "root", "", "carlend");  // on accède à la bdd

    $requete_verification = $bdd->query("SELECT * FROM connexion"); // on recupere les donnes de connexion
    $liste_verification = $requete_verification -> fetch_assoc(); // on stock chaque colonne dans une case de tableau

    $inscription = TRUE;

    foreach ($requete_verification as $liste_verification){ // on compare les donnes de l'utilisateur avec les données de la bdd
        if ($identifiant == $liste_verification['identifiant']){
            $inscription = FALSE;
        }
        if ($mot_de_passe == $liste_verification['mot_de_passe']){
            $inscription = FALSE;
        }
    }

    if ($inscription == TRUE){ // Si l'identifiant et le mot de passe saisi par l'utilisateur n'existent pas

        $requete_connexion = $bdd->query("INSERT INTO connexion(identifiant, mot_de_passe)VALUES($identifiant, $mot_de_passe)"); // on ajoute les identifiants de l'utilisateur dans la bdd
        if (!$requete_connexion){
            $erreur = TRUE;
        }
        $requete_utilisateur = $bdd->query("INSERT INTO utilisateur(prenom, nom, date_de_naissance, telephone, mail, adresse, ville, code_postale, lien_photo, date_adhesion) VALUES($prenom, $nom, $date_de_naissance, $telephone, $mail, $adresse, $ville, $code_postale, $lien_photo, $date_adhesion)"); // on ajoute les données de l'utilisateur dans la bdd
        if (!$requete_utilisateur){
            $erreur = TRUE;
        }

        if ($erreur == FALSE){ // si tout c'est bien passé

            $requete_verification = $bdd->query("SELECT * FROM connexion");    // on recupere les donnes de connexion
            $liste_verification = $requete_verification -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

            foreach ($requete_verification as $liste_verification){    // on compare les donnes de l'utilisateur avec les données de la bdd

                if ($identifiant == $liste_verification['identifiant'] and $mot_de_passe == $liste_verification['mot_de_passe']){  // si les données de l'utilisateur correspondent à celles de la bdd

                    //  on connecte l'utilisateur

                    session_start();  // on ouvre une session
                    $_SESSION['id_utilisateur'] = $liste_verification['id_utilisateur'];    // on récupère l'id de l'utilisateur

                }
            }

            // on enregistre la photo de l'utilisateur

            $dossier = '../donnees_utilisateur/photo_utilisateur/utilisateur'.$_SESSION['id_utilisateur'];
            if (!file_exists($dossier))
            {
                mkdir($dossier);
            }
            if(!empty($_FILES['fichier']['name'])) {

                $fichierTemporaire = $_FILES['fichier']['tmp_name'];
                $nomFichier = $_FILES['fichier']['name'];
                if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                    move_uploaded_file($fichierTemporaire, $dossier .'/'. $nomFichier);
                }
            }

            header('Location: index.php'); // on redirige l'utilisateur vers la page d'accueil
        }
    }
}

?>