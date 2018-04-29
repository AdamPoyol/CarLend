<?php
require_once("inc/header.inc.php");


if(!empty($_POST['rechercher_vehicule'])) {
    $ville = $_POST['ville'];
    $prix_max = $_POST['prix_max'];

    header('Location: recherche_vehicule.php?ville='.$ville.'&prix_max='.$prix_max); // on redirige l'utilisateur vers la page d'accueil

}

// afficher la photo d'un propriétaire de véhicule sur sa page
/*
$id_utilisateur = $_GET['proprietaire'];
$requete_utilisateur = $bdd->query("SELECT * FROM utilisateur WHERE id_utilisateur=" . $id_utilisateur);
$lien_photo_utilisateur = '../donnees_utilisateur/photo_utilisateur/utilisateur' . $id_utilisateur . '/' . $requete_utilisateur['lien_photo'];
*/

// Louer un véhicule

if(!empty($_POST['louer_vehicule'])) {

    // on récupère les données envoyées par l'utilisateur

    $id_vehicule = $_POST['id_vehicule']; // champ type hidden
    $date_debut_location = $_POST['date_debut_location'];
    $date_fin_location = $_POST['date_fin_location'];

    $id_utilisateur = $_SESSION['id_utilisateur'];  // on récupère l'id de l'utilisateur

    $requete_location = $bdd->query("INSERT INTO location(id_utilisateur, id_vehicule, date_debut_location, date_fin_location) VALUES($id_utilisateur, $id_vehicule, $date_debut_location, $date_fin_location)");     // on ajoute la location

    if (!$requete_location){
        $erreur = TRUE;
    }

}

?>

<div id="conteneur_accueil">
    <div class="zone1_accueil">
        <div class="recherche">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>"><br>
                <input id="modele" type="text" name="prix_max" placeholder="Prix maximum" class="form"/>
                <input id="ville" type="text" name="ville" placeholder="Ville" class="form"/>
                <input type="submit" value="Rechercher" name="rechercher_vehicule" class="form"/>
            </form>
        </div>
    </div>
    <div class="zone2_accueil">

        <br>
        <h1>Chercher un véhicule :</h1>

        <p>1.Pour chercher un véhicule il vous suffit de remplir les filtres suivant "Marque", "Modèle" et la "Ville".</p>

        <p>2.Notre algorithme va vous chercher tous les véhicules réportorier dans notre base de donnée.</p>

        <p>3.Il vous restera plus qu'a choisir un véhicule.</p>

        <p>4.Une fois votre véhicule choisi vous cliquerer sur contacter le propriétaire pour pouvoir lui envoyer une requête.</p>

    </div>
</div>
<?php
require_once("inc/footer.inc.php");
?>