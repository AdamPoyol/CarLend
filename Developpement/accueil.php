<?php

if(!empty($_POST['rechercher_vehicule'])) {
    $ville = $_POST['ville'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];

    $bdd = new mysqli("localhost", "root", "", "carlend");     // on accède à la bdd

    if ($marque =! '' and $modele != ''){
        $requete_recherche_vehicule = $bdd->query("SELECT * FROM vehicule WHERE ville=" . $ville . " AND marque=" . $marque . " AND modele=" . $modele);
        if (!$requete_recherche_vehicule){
            $erreur = 'Pas de véhicule correspondant à ces critères';
        }
    }
    else{
        $requete_recherche_vehicule = $bdd->query("SELECT * FROM vehicule WHERE ville=" . $ville);
        if (!$requete_recherche_vehicule){
            $erreur = 'Pas de véhicule correspondant à ces critères';
        }
    }
    $liste_recherche_vehicule = $requete_recherche_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    foreach ($requete_recherche_vehicule as $liste_recherche_vehicule){
        echo $liste_recherche_vehicule['marque'] . ' ' . $liste_recherche_vehicule['modele'] . ' ' . $liste_recherche_vehicule['ville'] . '<br><img src="' . $liste_recherche_vehicule['lien_photo'] . '">';
    }
}

// afficher la photo d'un propriétaire de véhicule sur sa page
/*
$id_utilisateur = $_GET['proprietaire'];
$requete_utilisateur = $bdd->query("SELECT * FROM utilisateur WHERE id_utilisateur=" . $id_utilisateur);
$lien_photo_utilisateur = '../donnees_utilisateur/photo_utilisateur/utilisateur' . $id_utilisateur . '/' . $requete_utilisateur['lien_photo'];
*/

// Ajout de véhicule

if(!empty($_POST['ajouter_vehicule'])) {

    // on récupère les données envoyées par l'utilisateur

    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $lien_photo = $_POST['lien_photo'];

    $id_utilisateur = $_SESSION['id_utilisateur'];  // on récupère l'id de l'utilisateur

    $bdd = new mysqli("localhost", "root", "", "carlend");     // on accède à la bdd

    $requete_vehicule = $bdd->query("INSERT INTO vehicule(id_utilisateur, immatriculation, marque, modele, lien_photo) VALUES($id_utilisateur, $immatriculation, $marque, $modele, $lien_photo)");     // on ajoute le vehicule

    if (!$requete_vehicule){
        $erreur = TRUE;
    }
    else{
        $requete_id_vehicule = $bdd->query("SELECT id_vehicule FROM vehicule WHERE id_utilisateur=".$id_utilisateur." AND marque=".$marque." AND modele=".$modele." AND lien_photo=".$lien_photo);
        $recuperation_id_vehicule = $requete_id_vehicule->fetch_assoc();
        $id_vehicule = $recuperation_id_vehicule['id_vehicule'];

        // on enregistre la photo du vehicule

        $dossier = '../donnees_utilisateur/photo_vehicule/utilisateur'.$id_utilisateur;
        if (!file_exists($dossier))
        {
            mkdir($dossier);
        }
        if(!empty($_FILES['fichier']['name'])) {

            $fichierTemporaire = $_FILES['fichier']['tmp_name'];
            $nomFichier = $_FILES['fichier']['name'];
            if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                move_uploaded_file($fichierTemporaire, $dossier .'/'. $nomFichier);
                $extension = explode( '.', $nomFichier);
                $extension = '.' . $extension[1];
                rename($dossier . '/' . $nomFichier, $dossier . '/' . $marque . $modele . $id_vehicule . $extension);
                $bdd->query("UPDATE vehicule SET lien_photo=".$dossier . '/' . $marque . $modele . $id_vehicule . $extension." WHERE id_vehicule=".$id_vehicule);

            }
        }
    }

}

// Louer un véhicule

if(!empty($_POST['louer_vehicule'])) {

    // on récupère les données envoyées par l'utilisateur

    $id_vehicule = $_POST['id_vehicule']; // champ type hidden
    $date_debut_location = $_POST['date_debut_location'];
    $date_fin_location = $_POST['date_fin_location'];

    $id_utilisateur = $_SESSION['id_utilisateur'];  // on récupère l'id de l'utilisateur

    $bdd = new mysqli("localhost", "root", "", "carlend");     // on accède à la bdd

    $requete_location = $bdd->query("INSERT INTO location(id_utilisateur, id_vehicule, date_debut_location, date_fin_location) VALUES($id_utilisateur, $id_vehicule, $date_debut_location, $date_fin_location)");     // on ajoute la location

    if (!$requete_location){
        $erreur = TRUE;
    }

}
?>