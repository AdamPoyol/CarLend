<?php
require_once("inc/init.inc.php");
// Inscription

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
    $lien_photo = $_FILES['lien_photo']['name'];
    $lien_permis = $_FILES['lien_permis']['name'];
    $date_adhesion = date("Y-m-d");

    $requete_verification = executeRequete("SELECT identifiant, mot_de_passe FROM utilisateur"); // on recupere les donnes de connexion
    $liste_verification = $requete_verification -> fetch_assoc(); // on stock chaque colonne dans une case de tableau

    $inscription = TRUE;
    $erreur = FALSE;

    foreach ($requete_verification as $liste_verification){ // on compare les donnes de l'utilisateur avec les données de la bdd
        if ($identifiant == $liste_verification['identifiant']){
            $inscription = FALSE;
        }
    }

    if ($inscription == TRUE){ // Si l'identifiant saisi par l'utilisateur n'existe pas

        $requete_utilisateur = executeRequete("INSERT INTO utilisateur(identifiant, mot_de_passe, nom, prenom, date_de_naissance, civilite, telephone, mail, adresse, ville, code_postal, lien_photo, lien_permis, date_adhesion) VALUES('".$identifiant."', '".$mot_de_passe."', '".$nom."', '".$prenom."', '".$date_de_naissance."', '".$civilite."', '".$telephone."', '".$mail."', '".$adresse."', '".$ville."', '".$code_postal."', '".$lien_photo."', '".$lien_permis."', '".$date_adhesion."')"); // on ajoute les données de l'utilisateur dans la bdd
        if (!$requete_utilisateur){
            $erreur = TRUE;
        }

        if ($erreur == FALSE){ // si tout c'est bien passé

            $requete_verification = executeRequete("SELECT identifiant, mot_de_passe, id_utilisateur FROM utilisateur");    // on recupere les donnes de connexion
            $liste_verification = $requete_verification -> fetch_assoc();  // on stock chaque colonne dans une case de tableau

            foreach ($requete_verification as $liste_verification){    // on compare les donnes de l'utilisateur avec les données de la bdd

                if ($identifiant == $liste_verification['identifiant'] and $mot_de_passe == $liste_verification['mot_de_passe']){  // si les données de l'utilisateur correspondent à celles de la bdd

                    //  on connecte l'utilisateur

                    session_start();  // on ouvre une session
                    $_SESSION['id_utilisateur'] = $liste_verification['id_utilisateur'];    // on récupère l'id de l'utilisateur
                }
            }

            // on enregistre la photo de l'utilisateur

            $dossier = 'photo/utilisateur'.$_SESSION['id_utilisateur'].'/';
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
            if(!empty($_FILES['lien_permis']['name'])) {

                $fichierTemporaire = $_FILES['lien_permis']['tmp_name'];
                $nomFichier = 'permis.jpg';
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

<br>


<section class="row" id="content">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" class="inscrip">
        <table class="tableinscrip">
            <tr>
                <td>
                    <label for="identifiant">Identifiant</label>
                </td>
                <td>
                    <input type="text" id="identifiant" name="identifiant" required="required" placeholder="Votre identifiant"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mot_de_passe">Mot de passe</label>
                </td>
                <td>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required="required" placeholder="************"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="nom">Nom</label>
                </td>
                <td>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="prenom">Prenom</label>
                </td>
                <td>
                    <input type="text" id="prenom" name="prenom" placeholder="Votre prenom" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="date_de_naissance">Date de naissance</label>
                </td>
                <td>
                    <input type="date" id="date_de_naissance" name="date_de_naissance" placeholder="Votre date de naissance" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="civilite">Civilité</label>
                </td>
                <td>
                    <input type="radio" id="civilite" name="civilite" value="m" checked="checked"/>Homme
                    <input type="radio" id="civilite" name="civilite" value="f"/>Femme<br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="telephone">Téléphone</label>
                </td>
                <td>
                    <input type="text" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mail">E-mail</label>
                </td>
                <td>
                    <input type="email" id="mail" name="mail" placeholder="Votre e-mail" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adresse">Adresse</label>
                </td>
                <td>
                    <input type="text" id="adresse" name="adresse" placeholder="Votre adresse" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="ville">Ville</label>
                </td>
                <td>
                    <input type="text" id="ville" name="ville" placeholder="Votre ville" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="cp">Code postal</label>
                </td>
                <td>
                    <input type="text" id="cp" name="code_postal" placeholder="Votre code postal" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="lien_photo">Photo d'identité</label>
                </td>

                <td>
                    <input type="file" id="lien_photo" name="lien_photo" placeholder="Votre photo d'identité" accept=".jpg" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="lien_permis">Permis de conduire</label>
                </td>
                <td>
                    <input type="file" id="lien_permis" name="lien_permis" placeholder="Votre permis de conduire" accept=".jpg" required="required"/><br><br>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>
                    <input type="submit" value="S'inscrire" name="inscription"/>
                </td>
            </tr><br>
        </table>
    </form><br>
</section>

<?php
include ("inc/footer.inc.php");
?>
