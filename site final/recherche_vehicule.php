<?php
require_once("inc/header.inc.php");

if(isset($_GET['ville']) && isset($_GET['prix_max'])) {
        if ($_GET['ville'] != '') {
            $ville = strtoupper(replace($_GET['ville']));
        }

        if(($_GET['prix_max']) != ''){
            $prix_max = replace($_GET['prix_max']);
        }
        else{
            $prix_max = "99999";
        }

        $requete_recherche_vehicule = executeRequete("SELECT v.id_vehicule, v.id_utilisateur, v.marque, v.modele, v.prix, v.lien_photo, u.ville FROM vehicule v, utilisateur u WHERE u.ville LIKE '%" . $ville . "%' AND v.prix<=" . $prix_max ."AND u.id_utilisateur=v.id_utilisateur");
        if (!$requete_recherche_vehicule){
            echo '<br>Pas de véhicule correspondant à ces critères<br><br> Voici d\'autres véhicules disponible ailleur<br><br>';
            $requete_recherche_vehicule = executeRequete("SELECT v.id_vehicule, v.id_utilisateur, v.marque, v.modele, v.prix, v.lien_photo, u.ville FROM vehicule v, utilisateur u WHERE u.id_utilisateur=v.id_utilisateur");
        }

    $liste_recherche_vehicule = $requete_recherche_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    foreach ($requete_recherche_vehicule as $liste_recherche_vehicule){
        echo '<div class="vehicule"><a href="recherche_vehicule.php?id_vehicule='.$liste_recherche_vehicule['id_vehicule'].'">' . $liste_recherche_vehicule['marque'] . ' ' . $liste_recherche_vehicule['modele'] . ' ' . $liste_recherche_vehicule['ville'] . ' ' . $liste_recherche_vehicule['prix'] . '€<br><img src="' . $liste_recherche_vehicule['lien_photo'] . '"></a></div>';
    }

}

if(isset($_GET['id_vehicule'])) {
    $id_vehicule = $_GET['id_vehicule'];

    $requete_vehicule = executeRequete("SELECT * FROM vehicule WHERE id_vehicule=" . $id_vehicule);
    $liste_vehicule = $requete_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    $requete_proprietaire = executeRequete("SELECT * FROM utilisateur WHERE id_utilisateur=" . $liste_vehicule['id_utilisateur']);
    $liste_proprietaire = $requete_proprietaire -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

        echo '
        <div class="vehicule">
            <div class="info">
                <h3>Informations relatives au véhicule :</h3>
                <ul>
                    <li>marque : ' . $liste_vehicule['marque'] . '</li>
                    <li>modèle : ' . $liste_vehicule['modele'] . '</li>
                    <li>année : ' . $liste_vehicule['annee'] . '</li>
                    <li><strong>prix : ' . $liste_vehicule['prix'] . '€ par jour</strong></li><br>
                    <li>boite de vitesse : ' . $liste_vehicule['boite_vitesse'] . '</li>
                    <li>puissance fiscale : ' . $liste_vehicule['puissance_fiscale'] . '</li>
                    <li>énergie : ' . $liste_vehicule['energie'] . '</li>
                    <li>nombre de portes : ' . $liste_vehicule['nb_porte'] . '</li>
                    <li>nombre de places : ' . $liste_vehicule['nb_place'] . '</li>
                    <li>date de mise en location : ' . $liste_vehicule['date_mise_en_location'] . '</li>
                </ul>
            </div>
            <div class="info">
                <img src="' . $liste_vehicule['lien_photo'] . '">
            </div>
            <div class="info">
                <h3>Informations relatives au propriétaire :</h3>
                <ul>
                    <li>nom : ' . $liste_proprietaire['nom'] . '</li>
                    <li>prenom : ' . $liste_proprietaire['prenom'] . '</li>
                    <li>code postal : ' . $liste_proprietaire['code_postal'] . '</li>
                    <li>ville : ' . $liste_proprietaire['ville'] . '</li>
                    <li>adresse : ' . $liste_proprietaire['adresse'] . '</li>
                    <li>téléphone : ' . $liste_proprietaire['telephone'] . '</li>
                    <li>adresse email : ' . $liste_proprietaire['mail'] . '</li>
                </ul>
            </div>
            <div class="info">
                <img src="' . $liste_proprietaire['lien_photo'] . '">
            </div>
        </div>';

    if(isset($_SESSION['id_utilisateur'])) {
        echo'
        <div class="duree_location">
            <form method="POST" action="' . $_SERVER["PHP_SELF"] . '"><br>
                <input type="hidden" name="id_vehicule" value="' . $liste_vehicule['id_vehicule'] . '" class="form"/>
                <label for="date_location">Du </label>
                <input type="date" name="date_location" placeholder="date de début" class="form"/>
                <label for="date_retour"> Au </label>
                <input type="date" name="date_retour" placeholder="date de fin" class="form"/>
                <input type="submit" value="louer" name="louer_vehicule" class="form"/>
            </form>
        </div>
        ';
    }
    else{
        echo '<div class="louer">Vous devez être connecté pour louer un véhicule</div>';
    }

}

// Louer un véhicule

if(!empty($_POST['louer_vehicule'])) {

    // on récupère les données envoyées par l'utilisateur

    $id_vehicule = $_POST['id_vehicule']; // champ type hidden
    $date_location = $_POST['date_location'];
    $date_retour = $_POST['date_retour'];

    $debut = strtotime($date_location);
    $fin = strtotime($date_retour);
    $diff = abs($fin - $debut); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $duree = $diff / 24 / 60 / 60 + 1;

    $requete_vehicule = executeRequete("SELECT * FROM vehicule WHERE id_vehicule=" . $id_vehicule);
    $liste_vehicule = $requete_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    $prix = $liste_vehicule['prix'] * $duree;

    $requete_proprietaire = executeRequete("SELECT * FROM utilisateur WHERE id_utilisateur=" . $liste_vehicule['id_utilisateur']);
    $liste_proprietaire = $requete_proprietaire -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    if ($liste_proprietaire['civilite'] == 'm'){
        $civilite = 'Mr. ';
    }
    else{
        $civilite = 'Mme. ';
    }

    echo '<h3>Récapitulatif :</h3>
          <p>location du véhicule '.$liste_vehicule['marque']. ' ' . $liste_vehicule['modele'] . ' appartenant à ' .$civilite.$liste_proprietaire['nom']. '<br>
          Pour une durée de '.$duree.' jour(s) au prix de '.$prix.' Euro</p> 
            <form method="POST" action="'.$_SERVER["PHP_SELF"].'"><br>
                <input type="hidden" name="id_vehicule" value="'.$id_vehicule.'" class="form"/>
                <input type="hidden" name="date_location" value="'.$date_location.'" class="form"/>
                <input type="hidden" name="date_retour" value="'.$date_retour.'" class="form"/>
                <input type="submit" value="valider la location" name="valider_location" class="form"/>
            </form>';
}

if(!empty($_POST['valider_location'])) {

    // on récupère les données envoyées par l'utilisateur

    $id_vehicule = $_POST['id_vehicule']; // champ type hidden
    $date_location = $_POST['date_location'];
    $date_retour = $_POST['date_retour'];

    $debut = strtotime($date_location);
    $fin = strtotime($date_retour);
    $diff = abs($fin - $debut); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $duree = $diff / 24 / 60 / 60 + 1;

    $requete_vehicule = executeRequete("SELECT prix FROM vehicule WHERE id_vehicule=" . $id_vehicule);
    $liste_vehicule = $requete_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    $prix = $liste_vehicule['prix'] * $duree;

    $id_utilisateur = $_SESSION['id_utilisateur'];  // on récupère l'id de l'utilisateur

    $requete_facture = executeRequete("INSERT INTO facture(id_utilisateur, id_vehicule, date_location, date_retour, prix) VALUES('".$id_utilisateur."', '".$id_vehicule."', '".$date_location."', '".$date_retour."', '".$prix."')"); // on ajoute les données du véhicule dans la bdd

    echo 'location éffectuée avec succès !';
}


require_once("inc/footer.inc.php");
?>