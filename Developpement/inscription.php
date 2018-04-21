<?php
require_once("inc/init.inc.php");
// Inscription
$_SESSION = array();  // on détruit les variables de session

session_destroy(); // on détruit la session

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

            header('Location: accueil_carlend.php'); // on redirige l'utilisateur vers la page d'accueil
        }
    }
}

?>

<?php
include ("inc/header.inc.php");
?>

<br>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">

    <label for="identifiant">Identifiant</label>
    <input type="text" id="identifiant" name="identifiant" required="required"/><br><br>

    <label for="mot_de_passe">Mot de passe</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required="required"/><br><br>

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" placeholder="votre nom" required="required"/><br><br>

    <label for="prenom">Prenom</label>
    <input type="text" id="prenom" name="prenom" placeholder="votre prenom" required="required"/><br><br>

    <label for="date_de_naissance">date de naissance</label>
    <input type="date" id="date_de_naissance" name="date_de_naissance" placeholder="votre date de naissance" required="required"/><br><br>

    <label for="civilite">Civilité</label>
    <input type="radio" id="civilite" name="civilite" value="m" checked="checked"/>Homme
    <input type="radio" id="civilite" name="civilite" value="f"/>Femme<br><br>

    <label for="telephone">Téléphone</label>
    <input type="text" id="telephone" name="telephone" placeholder="votre numéro de téléphone" required="required"/><br><br>

    <label for="mail">E-mail</label>
    <input type="email" id="mail" name="mail" placeholder="votre e-mail" required="required"/><br><br>

    <label for="adresse">Adresse</label>
    <input type="text" id="adresse" name="adresse" placeholder="votre adresse" required="required"/><br><br>

    <label for="ville">Ville</label>
    <input type="text" id="ville" name="ville" placeholder="votre ville" required="required"/><br><br>

    <label for="cp">Code postal</label>
    <input type="text" id="cp" name="code_postal" placeholder="votre code postal" required="required"/><br><br>

    <label for="lien_photo">photo identité</label>
    <input type="file" id="lien_photo" name="lien_photo" placeholder="votre photo d'identité" accept=".jpg" required="required"/><br><br>

    <label for="lien_permis">permis</label>
    <input type="file" id="lien_permis" name="lien_permis" placeholder="votre permis de conduire" accept=".jpg" required="required"/><br><br>

    <input type="submit" value="s'inscrire" name="inscription"/>
</form><br>

<?php
include ("inc/footer.inc.php");
?>
