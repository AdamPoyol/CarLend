<?php

require_once("inc/init.inc.php");

if(!empty($_POST['connexion'])) {

    // on récupère les données

    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $bdd = new mysqli("localhost", "root", "", "carlend");  // on accède à la bdd

    $requete_verification = $bdd->query("SELECT * FROM connexion");    // on recupere les donnes de connexion
    $liste_verification = $requete_verification -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    foreach ($requete_verification as $liste_verification){    // on compare les donnes de l'utilisateur avec les données de la bdd

        if ($identifiant == $liste_verification['identifiant'] and $mot_de_passe == $liste_verification['mot_de_passe']){  // si les données de l'utilisateur correspondent à celles de la bdd

            session_start();  // on ouvre une session

            $_SESSION['id_utilisateur'] = $liste_verification['id_utilisateur'];    // on récupère l'id de l'utilisateur

            header('Location: index.php');   // on redirige l'utilisateur vers la page d'accueil
        }
    }
}

?>
