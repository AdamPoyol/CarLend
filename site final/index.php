<?php
require_once("inc/header.inc.php");


if(!empty($_POST['rechercher_vehicule'])) {
    $ville = strtoupper(replace($_POST['ville']));
    $prix_max = replace($_POST['prix_max']);

    header('Location: recherche_vehicule.php?ville='.$ville.'&prix_max='.$prix_max); // on redirige l'utilisateur vers la page d'accueil

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

        <p>1.Pour chercher un véhicule il vous suffit de remplir les filtres "Prix maximum" et "Ville".</p>

        <p>2.Notre algorithme va vous chercher tous les véhicules réportorier dans notre base de donnée.</p>

        <p>3.Il ne vous restera plus qu'a choisir un véhicule.</p>

        <p>4.Une fois votre véhicule choisi vous pourez le reserver.</p>

    </div>
</div>
<?php
require_once("inc/footer.inc.php");
?>