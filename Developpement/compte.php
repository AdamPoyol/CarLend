<?php

include ("inc/header.inc.php");

if (isset($_SESSION['id_utilisateur'])){
    $requete_utilisateur = executeRequete("SELECT * FROM utilisateur WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
    $liste_utilisateur = $requete_utilisateur -> fetch_assoc();

    echo '<div class="clear"></div><div class="compte">';

    $result = $mysqli->query('SHOW TABLES');
    $listeTables = $result->fetch_assoc();
    if (!$result){
        echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
    }

    echo '
          <a href="'.$_SERVER["PHP_SELF"].'?info=utilisateur"> Mon profil </a>
          <a href="'.$_SERVER["PHP_SELF"].'?info=vehicule"> Mes véhicules </a>
          <a href="'.$_SERVER["PHP_SELF"].'?info=facture"> Mes factures </a>
    ';

    if(isset($_GET['info'])){
        if($_GET['info'] == 'utilisateur'){

            if($_POST){
                debug($_POST);
                // on récupère les données

                $identifiant = $_POST['identifiant'];
                $mot_de_passe = $_POST['mot_de_passe'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $date_de_naissance = $_POST['date_de_naissance'];
                $civilite = $_POST['civilite'];
                $telephone = $_POST['telephone'];
                $mail = $_POST['mail'];
                $adresse = $_POST['adresse'];
                $ville = $_POST['ville'];
                $code_postal = $_POST['code_postal'];
                $photo = false;
                if(isset($_FILES['lien_photo']['name'])){
                    if($_FILES['lien_photo']['name'] != ''){
                        $photo = true;
                        $lien_photo = $_FILES['lien_photo']['name'];
                    }
                }
                $permis = false;
                if(isset($_FILES['lien_permis']['name'])){
                    if($_FILES['lien_permis']['name'] != ''){
                        $permis = true;
                        $lien_permis = $_FILES['lien_permis']['name'];
                    }
                }

                $requete_verification = executeRequete("SELECT id_utilisateur, identifiant, mot_de_passe FROM utilisateur"); // on recupere les donnes de connexion
                $liste_verification = $requete_verification -> fetch_assoc(); // on stock chaque colonne dans une case de tableau

                $inscription = TRUE;
                $erreur = FALSE;

                foreach ($requete_verification as $liste_verification){ // on compare les donnes de l'utilisateur avec les données de la bdd
                    if ($identifiant == $liste_verification['identifiant']){
                        if ($liste_verification['id_utilisateur']!= $_SESSION['id_utilisateur']){
                            $inscription = FALSE;
                        }
                    }
                }

                if ($inscription == TRUE){ // Si l'identifiant saisi par l'utilisateur n'existe pas

                    if($photo == true && $permis == true) {
                        $requete_utilisateur = executeRequete("UPDATE utilisateur SET  identifiant='" . $identifiant . "', mot_de_passe='" . $mot_de_passe . "', nom='" . $nom . "', prenom='" . $prenom . "', date_de_naissance='" . $date_de_naissance . "', civilite='" . $civilite . "', telephone='" . $telephone . "', mail='" . $mail . "', adresse='" . $adresse . "', ville='" . $ville . "', code_postal='" . $code_postal . "', lien_photo='" . $lien_photo . "', lien_permis='" . $lien_permis . "' WHERE id_utilisateur='" . $_SESSION['id_utilisateur'] . "'");
                    }
                    elseif ($photo == true && $permis == false){
                        $requete_utilisateur = executeRequete("UPDATE utilisateur SET  identifiant='" . $identifiant . "', mot_de_passe='" . $mot_de_passe . "', nom='" . $nom . "', prenom='" . $prenom . "', date_de_naissance='" . $date_de_naissance . "', civilite='" . $civilite . "', telephone='" . $telephone . "', mail='" . $mail . "', adresse='" . $adresse . "', ville='" . $ville . "', code_postal='" . $code_postal . "', lien_photo='" . $lien_photo . "' WHERE id_utilisateur='" . $_SESSION['id_utilisateur'] . "'");
                    }
                    elseif ($photo == false && $permis == true){
                        $requete_utilisateur = executeRequete("UPDATE utilisateur SET  identifiant='" . $identifiant . "', mot_de_passe='" . $mot_de_passe . "', nom='" . $nom . "', prenom='" . $prenom . "', date_de_naissance='" . $date_de_naissance . "', civilite='" . $civilite . "', telephone='" . $telephone . "', mail='" . $mail . "', adresse='" . $adresse . "', ville='" . $ville . "', code_postal='" . $code_postal . "', lien_permis='" . $lien_permis . "' WHERE id_utilisateur='" . $_SESSION['id_utilisateur'] . "'");
                    }
                    else{
                        $requete_utilisateur = executeRequete("UPDATE utilisateur SET  identifiant='" . $identifiant . "', mot_de_passe='" . $mot_de_passe . "', nom='" . $nom . "', prenom='" . $prenom . "', date_de_naissance='" . $date_de_naissance . "', civilite='" . $civilite . "', telephone='" . $telephone . "', mail='" . $mail . "', adresse='" . $adresse . "', ville='" . $ville . "', code_postal='" . $code_postal . "' WHERE id_utilisateur='" . $_SESSION['id_utilisateur'] . "'");
                    }
                    if (!$requete_utilisateur){
                        $erreur = TRUE;
                    }

                    if ($erreur == FALSE){ // si tout c'est bien passé

                        // on enregistre la photo de l'utilisateur

                        $dossier = 'photo/utilisateur'.$_SESSION['id_utilisateur'].'/';
                        if (!file_exists($dossier))
                        {
                            mkdir($dossier);
                        }

                        if($photo == true) {
                            unlink($dossier . 'photo.jpg');
                            $fichierTemporaire = $_FILES['lien_photo']['tmp_name'];
                            $nomFichier = 'photo.jpg';
                            if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                                move_uploaded_file($fichierTemporaire, $dossier . $nomFichier);
                                $requete_renommage = executeRequete("UPDATE utilisateur SET lien_photo='".$dossier . $nomFichier ."' WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
                            }
                        }
                        if($permis == true) {
                            unlink($dossier . 'permis.jpg');
                            $fichierTemporaire = $_FILES['lien_permis']['tmp_name'];
                            $nomFichier = 'permis.jpg';
                            if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                                move_uploaded_file($fichierTemporaire, $dossier . $nomFichier);
                                $requete_renommage = executeRequete("UPDATE utilisateur SET lien_permis='".$dossier . $nomFichier ."' WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
                            }
                        }

                        header('Location: compte.php?info=utilisateur'); // on redirige l'utilisateur
                    }
                }
            }

            echo '
            
                <section class="row" id="content">
                    <form method="post" action="'.$_SERVER["PHP_SELF"].'?info=utilisateur" enctype="multipart/form-data" class="inscrip">
                        <table class="tableinscrip">
                            <tr>
                                <td>
                                    <label for="identifiant">Identifiant</label>
                                </td>
                                <td>
                                    <input type="text" id="identifiant" name="identifiant" required="required" value="'.$liste_utilisateur['identifiant'].'"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="mot_de_passe">Mot de passe</label>
                                </td>
                                <td>
                                    <input type="password" id="mot_de_passe" name="mot_de_passe" required="required" value="'.$liste_utilisateur['mot_de_passe'].'"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nom">Nom</label>
                                </td>
                                <td>
                                    <input type="text" id="nom" name="nom" value="'.$liste_utilisateur['nom'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="prenom">Prenom</label>
                                </td>
                                <td>
                                    <input type="text" id="prenom" name="prenom" value="'.$liste_utilisateur['prenom'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="date_de_naissance">Date de naissance</label>
                                </td>
                                <td>
                                    <input type="date" id="date_de_naissance" name="date_de_naissance" value="'.$liste_utilisateur['date_de_naissance'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="civilite">Civilité</label>
                                </td>
                                <td>
                            ';

                            if($liste_utilisateur['civilite']== 'm'){
                                echo ' <input type="radio" id="civilite" name="civilite" value="m" checked="checked"/>Homme
                                    <input type="radio" id="civilite" name="civilite" value="f"/>Femme<br><br>';
                            }
                            else{
                                echo ' <input type="radio" id="civilite" name="civilite" value="m"/>Homme
                                    <input type="radio" id="civilite" name="civilite" value="f" checked="checked"/>Femme<br><br>';
                            }

                            echo '
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telephone">Téléphone</label>
                                </td>
                                <td>
                                    <input type="text" id="telephone" name="telephone" value="'.$liste_utilisateur['telephone'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="mail">E-mail</label>
                                </td>
                                <td>
                                    <input type="email" id="mail" name="mail" value="'.$liste_utilisateur['mail'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="adresse">Adresse</label>
                                </td>
                                <td>
                                    <input type="text" id="adresse" name="adresse" value="'.$liste_utilisateur['adresse'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="ville">Ville</label>
                                </td>
                                <td>
                                    <input type="text" id="ville" name="ville" value="'.$liste_utilisateur['ville'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="cp">Code postal</label>
                                </td>
                                <td>
                                    <input type="text" id="cp" name="code_postal" value="'.$liste_utilisateur['code_postal'].'" required="required"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="lien_photo">Photo d\'identité</label>
                                </td>
                
                                <td>
                                    <img src="' . $liste_utilisateur['lien_photo'] . '" height="100px"><br>
                                    <input type="file" id="lien_photo" name="lien_photo" placeholder="Votre photo d\'identité" accept=".jpg"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="lien_permis">Permis de conduire</label>
                                </td>
                                <td>
                                    <img src="' . $liste_utilisateur['lien_permis'] . '" height="100px"><br>
                                    <input type="file" id="lien_permis" name="lien_permis" placeholder="Votre permis de conduire" accept=".jpg"/><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                
                                </td>
                                <td>
                                    <input type="submit" value="Modifier" name="modifier"/>
                                </td>
                            </tr>
                        </table>
                    </form><br>
                </section>
            ';
        }
        if($_GET['info'] == 'vehicule'){
            $requete_vehicule = executeRequete("SELECT * FROM vehicule WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
            $liste_vehicule = $requete_vehicule -> fetch_assoc();

            if(isset($_POST['vehicule'])){
                if ($_POST['vehicule'] == 'Modifier'){
                    debug($_POST);
                    // on récupère les données

                    $id_vehicule = $_POST['id_vehicule'];
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
                    $photo = false;
                    if(isset($_FILES['lien_photo']['name'])){
                        if($_FILES['lien_photo']['name'] != ''){
                            $photo = true;
                            $lien_photo = $_FILES['lien_photo']['name'];
                        }
                    }
                    $prix = $_POST['prix'];

                    $requete_verification_hidden = executeRequete("SELECT immatriculation, id_utilisateur FROM vehicule WHERE id_vehicule=".$id_vehicule);
                    $liste_verification_hidden = $requete_verification_hidden -> fetch_assoc();

                    if ($liste_verification_hidden['id_utilisateur'] == $_SESSION['id_utilisateur']){ // on vérifie que l'utilisateur n'ait pas changé le champ hidden

                        $requete_verification = executeRequete("SELECT id_utilisateur, immatriculation FROM vehicule");
                        $liste_verification = $requete_verification -> fetch_assoc(); // on stock chaque colonne dans une case de tableau

                        $ajout = TRUE;
                        $erreur = FALSE;

                        foreach ($requete_verification as $liste_verification){ // on compare les donnes de l'utilisateur avec les données de la bdd
                            if ($immatriculation == $liste_verification['immatriculation']){
                                if ($liste_verification['id_utilisateur']!= $_SESSION['id_utilisateur']){
                                    $ajout = FALSE;
                                }
                            }
                        }

                        if ($ajout == TRUE){ // Si l'immatriculation saisi par l'utilisateur n'existe pas

                            if($photo == true) {
                                $requete_vehicule = executeRequete("UPDATE vehicule SET immatriculation='" . $immatriculation . "', marque='" . $marque . "', modele='" . $modele . "', annee='" . $annee . "', puissance_fiscale='" . $puissance_fiscale . "', energie='" . $energie . "', boite_vitesse='" . $boite_vitesse . "', nb_porte='" . $nb_porte . "', nb_place='" . $nb_place . "', lien_photo='" . $lien_photo . "', prix='" . $prix . "' WHERE id_vehicule='" . $id_vehicule . "'"); // on ajoute les données du véhicule dans la bdd
                            }
                            elseif($photo == false) {
                                $requete_vehicule = executeRequete("UPDATE vehicule SET immatriculation='" . $immatriculation . "', marque='" . $marque . "', modele='" . $modele . "', annee='" . $annee . "', puissance_fiscale='" . $puissance_fiscale . "', energie='" . $energie . "', boite_vitesse='" . $boite_vitesse . "', nb_porte='" . $nb_porte . "', nb_place='" . $nb_place . "', prix='" . $prix . "' WHERE id_vehicule='" . $id_vehicule . "'"); // on ajoute les données du véhicule dans la bdd
                            }

                            if (!$requete_vehicule){
                                $erreur = TRUE;
                            }

                            if ($erreur == FALSE){ // si tout c'est bien passé

                                $requete_verification = executeRequete("SELECT immatriculation FROM vehicule WHERE id_vehicule=".$id_vehicule);    // on recupere les donnes du vehicule
                                $liste_verification = $requete_verification -> fetch_assoc();  // on stock chaque colonne dans une case de tableau


                                // on enregistre la photo du véhicule

                                $dossier = 'photo/vehicule'.$_SESSION['id_utilisateur'].'/';
                                if (!file_exists($dossier))
                                {
                                    mkdir($dossier);
                                }

                                if($photo == true) {
                                    unlink($dossier .$liste_verification_hidden['immatriculation']. '.jpg'); // on efface la photo qui avait le nom de l'ancienne immatriculation
                                    $fichierTemporaire = $_FILES['lien_photo']['tmp_name'];
                                    $nomFichier = $immatriculation.'.jpg';
                                    if (!empty($fichierTemporaire) && is_uploaded_file($fichierTemporaire)) {
                                        move_uploaded_file($fichierTemporaire, $dossier . $nomFichier);
                                        $requete_renommage = executeRequete("UPDATE vehicule SET lien_photo='".$dossier . $nomFichier ."' WHERE immatriculation='".$liste_verification['immatriculation']."'");
                                    }
                                }

                                header('Location: compte.php?info=vehicule'); // on redirige l'utilisateur vers la page de compte
                            }
                        }
                    }
                }
                elseif ($_POST['vehicule'] == 'Supprimer'){
                    $id_vehicule = $_POST['id_vehicule'];

                    $requete_verification_hidden = executeRequete("SELECT id_utilisateur FROM vehicule WHERE id_vehicule=".$id_vehicule);
                    $liste_verification_hidden = $requete_verification_hidden -> fetch_assoc();

                    if ($liste_verification_hidden['id_utilisateur'] == $_SESSION['id_utilisateur']) { // on vérifie que l'utilisateur n'ait pas changé le champ hidden
                        $requete_verification = executeRequete("DELETE FROM vehicule WHERE id_vehicule='" . $id_vehicule . "'");
                    }
                    header('Location: compte.php?info=vehicule'); // on redirige l'utilisateur vers la page de compte
                }
            }


            if (sizeof($liste_vehicule) != 0) {
                foreach ($requete_vehicule as $liste_vehicule) {


                    echo '
                        <form method="post" action="' . $_SERVER["PHP_SELF"] . '?info=vehicule" enctype="multipart/form-data" class="inscrip">
                            <input type="hidden" name="id_vehicule" value="'.$liste_vehicule['id_vehicule'].'"/>
                            <table class="tableinscrip">
                                <tr>
                                    <td>
                                        <label for="marque">Marque</label>
                                    </td>
                                    <td>
                                        <input type="text" name="marque" value="'.$liste_vehicule['marque'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="modele">Modèle</label>
                                    </td>
                                    <td>
                                        <input type="text" name="modele" value="'.$liste_vehicule['modele'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="annee">Année du véhicule</label>
                                    </td>
                                    <td>
                                        <input type="text" name="annee" value="'.$liste_vehicule['annee'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="immatriculation">Immatriculation</label>
                                    </td>
                                    <td>
                                        <input type="text" name="immatriculation" value="'.$liste_vehicule['immatriculation'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="puissance_fiscale">Puissance fiscale</label>
                                    </td>
                                    <td>
                                        <input type="text" name="puissance_fiscale" value="'.$liste_vehicule['puissance_fiscale'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="energie">Energie du moteur</label>
                                    </td>
                                    <td>
                                        <input type="text" name="energie" value="'.$liste_vehicule['energie'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="boite_vitesse">Boite de vitesse</label>
                                    </td>
                                    <td>
                            ';

                            if($liste_vehicule['boite_vitesse'] == 'manuelle'){
                                echo '<input type="radio" name="boite_vitesse" value="manuelle" checked="checked"/>Manuelle
                                        <input type="radio" name="boite_vitesse" value="automatique"/>Automatique<br><br>';
                            }
                            else{
                                echo '<input type="radio" name="boite_vitesse" value="manuelle"/>Manuelle
                                        <input type="radio" name="boite_vitesse" value="automatique" checked="checked"/>Automatique<br><br>';
                            }

                            echo '
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nb_porte">Nombre de portes</label>
                                    </td>
                                    <td>
                                        <input type="text" name="nb_porte" value="'.$liste_vehicule['nb_porte'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="nb_place">Nombre de places</label>
                                    </td>
                                    <td>
                                        <input type="text" name="nb_place" value="'.$liste_vehicule['nb_place'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="lien_photo">Photo véhicule</label>
                                    </td>
                                    <td>
                                        <img src="' . $liste_vehicule['lien_photo'] . '" height="100px"><br>
                                        <input type="file" name="lien_photo" placeholder="Photo du véhicule" accept=".jpg"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="prix">Prix par jour</label>
                                    </td>
                                    <td>
                                        <input type="text" name="prix" value="'.$liste_vehicule['prix'].'" required="required"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="Modifier" name="vehicule"/>
                                        <input type="submit" value="Supprimer" name="vehicule"/>
                                    </td>
                                </tr>
                                <br>
                            </table>
                        </form>
                    ';
                }
            }
        }
    }
    if($_GET['info'] == 'facture'){
        $requete_facture = executeRequete("SELECT * FROM facture WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
        $liste_facture = $requete_facture -> fetch_assoc();

        echo '<div class="clear"></div><div class="facture"><table cellspacing="20"><tr>';
        if (sizeof($liste_facture) != 0) {
            echo '<td valign="top" class="achat"><h3>Achats</h3>';
            foreach ($requete_facture as $liste_facture) {

                $requete_vehicule = executeRequete("SELECT * FROM vehicule WHERE id_vehicule=" . $liste_facture['id_vehicule']);
                $liste_vehicule = $requete_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

                $requete_proprietaire = executeRequete("SELECT * FROM utilisateur WHERE id_utilisateur=" . $liste_vehicule['id_utilisateur']);
                $liste_proprietaire = $requete_proprietaire -> fetch_assoc();  // on stock chaque colonne dans une case de tableau


                $debut = strtotime($liste_facture['date_location']);
                $fin = strtotime($liste_facture['date_retour']);
                $diff = abs($fin - $debut); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
                $duree = $diff / 24 / 60 / 60 + 1;


                $prix = $liste_vehicule['prix'] * $duree;

                if ($liste_proprietaire['civilite'] == 'm'){
                    $civilite = 'Mr. ';
                }
                else{
                    $civilite = 'Mme. ';
                }

                echo '<br><br><p>location du véhicule '.$liste_vehicule['marque']. ' ' . $liste_vehicule['modele'] . ' appartenant à ' .$civilite.$liste_proprietaire['nom']. '<br>
          Pour une durée de '.$duree.' jour(s) au prix de '.$prix.' Euro</p>';
            }
            echo '</td>';
        }

        $requete_facture = executeRequete("SELECT * FROM facture WHERE id_vehicule=(SELECT id_vehicule FROM vehicule WHERE id_utilisateur='".$_SESSION['id_utilisateur']."')");
        $liste_facture = $requete_facture -> fetch_assoc();

        if (sizeof($liste_facture) != 0) {
            echo '<td valign="top" class="vente"><h3>Ventes</h3>';
            foreach ($requete_facture as $liste_facture) {

                $requete_vehicule = executeRequete("SELECT * FROM vehicule WHERE id_vehicule=" . $liste_facture['id_vehicule']);
                $liste_vehicule = $requete_vehicule -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

                $requete_client = executeRequete("SELECT * FROM utilisateur WHERE id_utilisateur=" . $liste_facture['id_utilisateur']);
                $liste_client = $requete_client -> fetch_assoc();  // on stock chaque colonne dans une case de tableau


                $debut = strtotime($liste_facture['date_location']);
                $fin = strtotime($liste_facture['date_retour']);
                $diff = abs($fin - $debut); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
                $duree = $diff / 24 / 60 / 60 + 1;


                $prix = $liste_vehicule['prix'] * $duree;

                if ($liste_client['civilite'] == 'm'){
                    $civilite = 'Mr. ';
                }
                else{
                    $civilite = 'Mme. ';
                }

                echo '<br><br><p>location de votre véhicule '.$liste_vehicule['marque']. ' ' . $liste_vehicule['modele'] . ' à ' .$civilite.$liste_client['nom']. '<br>
          Pour une durée de '.$duree.' jour(s) au prix de '.$prix.' Euro</p>';
            }

            echo '</td>';
        }
        echo '</tr></table></div>';
    }

    echo '</div>';
}

include ("inc/footer.inc.php");

?>
