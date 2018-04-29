<?php
require_once("inc/init.inc.php");
// Inscription

if($_POST){
    debug($_POST);
    // on récupère les données

    $id_utilisateur = $_SESSION['id_utilisateur'];
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $puissance_fiscale = $_POST['puissance_fiscale'];
    $energie = $_POST['energie'];
    $boite_vitesse = $_POST['boite_vitesse'];
    $nb_porte = $_POST['nb_porte'];
    $nb_place = $_POST['nb_place'];
    $lien_photo = $_FILES['lien_photo']['name'];
    $date_mise_en_location = date("Y-m-d");


    $requete_verification = executeRequete("SELECT immatriculation FROM vehicule"); // on recupere les donnes de connexion
    $liste_verification = $requete_verification -> fetch_assoc(); // on stock chaque colonne dans une case de tableau

    $ajout = TRUE;
    $erreur = FALSE;

    foreach ($requete_verification as $liste_verification){ // on compare les donnes de l'utilisateur avec les données de la bdd
        if ($immatriculation == $liste_verification['immatriculation']){
            $ajout = FALSE;
        }
    }

    if ($ajout == TRUE){ // Si l'immatriculation saisi par l'utilisateur n'existe pas

        $requete_vehicule = executeRequete("INSERT INTO vehicule(id_utilisateur, immatriculation, marque, modele,annee, puissance_fiscale, energie, boite_vitesse, nb_porte, nb_place, lien_photo, date_mise_en_location) VALUES('".$id_utilisateur."', '".$immatriculation."', '".$marque."', '".$modele."', '".$annee."', '".$puissance_fiscale."', '".$energie."', '".$boite_vitesse."', '".$nb_porte."', '".$nb_place."', '".$lien_photo."', '".$date_mise_en_location."')"); // on ajoute les données du véhicule dans la bdd
        if (!$requete_vehicule){
            $erreur = TRUE;
        }

        if ($erreur == FALSE){ // si tout c'est bien passé

            $requete_verification = executeRequete("SELECT immatriculation FROM vehicule");    // on recupere les donnes du vehicule
            $liste_verification = $requete_verification -> fetch_assoc();  // on stock chaque colonne dans une case de tableau


            // on enregistre la photo du véhicule

            $dossier = 'photo/vehicule'.$_SESSION['id_utilisateur'].'/';
            if (!file_exists($dossier))
            {
                mkdir($dossier);
            }

            if(!empty($_FILES['lien_photo']['name'])) {
                $fichierTemporaire = $_FILES['lien_photo']['tmp_name'];
                $nomFichier = 'photo.jpg';
                if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                    move_uploaded_file($fichierTemporaire, $dossier . $nomFichier);
                }
            }

            header('Location: accueil.php'); // on redirige l'utilisateur vers la page d'accueil
        }
    }
}

?>

<?php
include ("inc/header.inc.php");
?>

    <div class="conteneur_location">
    <div class="zone1_location">
    </div>
    <div class="clear"></div>
    <section class="row" id="content">
        <?php
        if(isset($_SESSION['id_utilisateur'])) {
            echo '
        
        <form method="post" action="' . $_SERVER["PHP_SELF"] . '" enctype="multipart/form-data" class="inscrip">
            <table class="tableinscrip">
                <tr>
                    <td>
                        <select id="marque" name="marque" onchange="AdaptationModele(this.value);">
                            <option value="default" >Choisir une marque</option>
                            <option value="citroen">Citroën</option>
                            <option value="peugeot">Peugeot</option>
                            <option value="renault">Renault</option>
                            <option value="volkswagen">Volkswagen</option>

                            <optgroup label="Autres marques">
                                <option value="alpharomeo">Alpha Romeo</option>
                                <option value="audi">Audi</option>
                                <option value="bmw">BMW</option>
                                <option value="fiat">Fiat</option>
                                <option value="opel">Opel</option>
                                <option value=""> . . . </option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select id="modele" name="modele">
                            <option >Choisir un modèle</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="annee">Année du véhicule</label>
                    </td>
                    <td>
                        <input type="text" name="annee" placeholder="yyyy" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="immatriculation">Immatriculation</label>
                    </td>
                    <td>
                        <input type="text" name="immatriculation" placeholder="immatriculation" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="puissance_fiscale">Puissance fiscale</label>
                    </td>
                    <td>
                        <input type="text" name="puissance_fiscale" placeholder="Puissance fiscale" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="energie">Energie du moteur</label>
                    </td>
                    <td>
                        <input type="text" name="energie" placeholder="Energie" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="boite_vitesse">Boite de vitesse</label>
                    </td>
                    <td>
                        <input type="radio" name="boite_vitesse" value="m" checked="checked"/>Manuelle
                        <input type="radio" name="boite_vitesse" value="a"/>Automatique<br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nb_porte">Nombre de portes</label>
                    </td>
                    <td>
                        <input type="text" name="nb_porte" placeholder="Nombre de portes" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nb_place">Nombre de places</label>
                    </td>
                    <td>
                        <input type="text" name="nb_place" placeholder="Nombre de places" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lien_photo">Une photo du véhicule</label>
                    </td>
                    <td>
                        <input type="file" name="lien_photo" placeholder="Une photo du véhicule" accept=".jpg" required="required"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Ajouter" name="ajout_vehicule"/>
                    </td>
                </tr>
                <br>
            </table>
        </form><br>
        ';
        }
        else{
            echo '<div class="louer">Vous devez être connecté pour ajouter un véhicule à la location</div>';
        }

        ?>
    </section>
    </div>

<?php
include ("inc/footer.inc.php");
?>