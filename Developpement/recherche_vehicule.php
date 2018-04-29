<?php
require_once("inc/header.inc.php");

if(isset($_GET['ville']) && isset($_GET['prix_max'])) {
    $ville = $_GET['ville'];
    $prix_max = $_GET['prix_max'];

    if ($ville != ''){
        $requete_recherche_vehicule = executeRequete("SELECT v.id_vehicule, v.id_utilisateur, v.marque, v.modele, v.prix, v.lien_photo, u.ville FROM vehicule v, utilisateur u WHERE u.ville='" . $ville . "' AND v.prix<=" . $prix_max);
        if (!$requete_recherche_vehicule){
            echo 'Pas de véhicule correspondant à ces critères';
        }

    }
    else{
        $requete_recherche_vehicule = executeRequete("SELECT * FROM vehicule WHERE prix<=" . $prix_max);
        if (!$requete_recherche_vehicule){
            echo 'Pas de véhicule correspondant à ces critères';
        }
    }

    $liste_recherche_vehicule = $requete_recherche_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

    foreach ($requete_recherche_vehicule as $liste_recherche_vehicule){
        echo '<div class="vehicule"><a href="recherche_vehicule.php?id_vehicule='.$liste_recherche_vehicule['id_vehicule'].'">' . $liste_recherche_vehicule['marque'] . ' ' . $liste_recherche_vehicule['modele'] . ' ' . $liste_recherche_vehicule['ville'] . ' ' . $liste_recherche_vehicule['prix'] . '<br><img src="' . $liste_recherche_vehicule['lien_photo'] . '"></a></div>';
    }

}

if(isset($_GET['id_vehicule'])) {
    echo 'Toutes les infos';

}

require_once("inc/footer.inc.php");
?>