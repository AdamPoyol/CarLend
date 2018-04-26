<?php
require_once("inc/header.inc.php");


if(!empty($_POST['rechercher_vehicule'])) {
    $ville = $_POST['ville'];
    $prix_max = $_POST['prix_max'];

    $bdd = new mysqli("localhost", "root", "", "carlend");     // on accède à la bdd

    if ($ville =! ''){
        $requete_recherche_vehicule = $bdd->query("SELECT * FROM vehicule WHERE ville=" . $ville . " AND prix<=" . $prix_max);
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
        echo $liste_recherche_vehicule['marque'] . ' ' . $liste_recherche_vehicule['modele'] . ' ' . $liste_recherche_vehicule['ville'] . ' ' . $liste_recherche_vehicule['prix'] . '<br><img src="' . $liste_recherche_vehicule['lien_photo'] . '">';
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
        <p><br>
            1.Présentation du projet

            1.      Contexte du projet

            Nous devons créer un site de e-commerce et/ou de location. Ce site doit être créé de A à Z par notre groupe, en utilisant nos connaissances en développement Web.

            2.      Buts et objectifs du projet

            L’objectif du projet est de mettre à disposition une plateforme permettant aux clients de rechercher un véhicule, et leur permettre soit le louer un véhicule ou d'être locataire d'un véhicule.

            3. Notre proposition

            Nous souhaitons mettre en place un site de location de véhicules de particuliers à particuliers.

            4. Notre intervention

            Nous allons mettre en œuvre les moyens à notre disposition pour créer le site de A à Z.

            2. Détails de la prestation demandée

            1. Arborescence / Menu

            Voici les rubriques principales (estimée) qui composeront le site. Chacune d'entres elles sont susceptibles de posséder des sous rubriques :

            Accueil

            Des questions ?

            Comment ça marche ?

            Aide

            Nous contacter

            Louer mon véhicule

            Chercher un véhicule

            Inscription / Connexion

            En bas de la page (footer) nous pourrons trouver une rubrique "à propos", pour en savoir plus avec des liens nommés "comment ça marche", "aide" et "nous contacter", ainsi que les liens vers nos différents réseaux.

            2. Design

            Nous allons faire un design épuré et aéré, quelque chose d'intuitif. Pratique et facile d'utilisation.

            3.Intégration de la page

            4. Prédisposition au référencement

            5. Espace membre

            Chaque membre du site devra se créer un compte pour pouvoir profiter des services du site, sous-entendu: louer un véhicule et mettre en location son véhicule, ainsi que visiter les différentes offres.

            6. Droits

            Administrateurs: les Administrateur seront les personnes qui auront tous les droits sur le site: ajouter/modifier le contenu, gérer des paramètres privés des comptes tel que les changements de mot de passe (avec l'approbation des utilisateurs seulement). Ils auront le plein pouvoir sur le back office et seront autorisés à supprimer les comptes des utilisateur "indésirable".

            Les Utilisateur: ce seront les personnes qui feront vivre le site, ceux qui loueront des voitures et ceux qui mettront en location leur véhicule.

            Les visiteurs: ils auront accès au site et aux offres mis en place sans pour autant pouvoir rentrer en contact avec le propriétaire, car pour cela ils devront se créer un compte.

            7. Formulaires

            Pour pouvoir se créer un compte, les visiteurs devront remplir un formulaire: ils devront donner leurs nom, prénom, date de naissance, adresse, type de véhicule, modèle du véhicule, immatriculation, copie du permis de conduire et de la pièce d'identité.

            Saut de page


            8. Galerie produits

            Le site aura plusieurs propositions de produit en fonction des demandes: de la voiture électrique jusqu'aux véhicules utilitaires.

            3. Réponse fonctionnelle et technique

            1. Outils

            Nous allons utiliser des serveurs de Ynov Aix-en-Provence, et des machines nous appartenant.



            2. Principes

            Le principe du site est que les personnes qui n'utilise pas beaucoup leur voiture par exemple peuvent, au lieu de la revendre, la mettre en location et en faire profiter les autres utilisateur qui ne voit pas d'utilité a acheter une voiture.



            3. Technologie utilisée

            Nous utiliserons pour faire le site de l'HTML, du CSS3, du PHP, MySQL et si besoin du JavaScript.

            4. Organisation du projet

            1. Déroulement du projet

            Non défini


            2. Délais de réalisation

            1 année scolaire


            5. Responsabilités

            Les développeurs et le chef de projet auront la responsabilité de développer et gérer le site de A à Z et de gérer le backup durant tout le développement. Ils auront aussi la devoir de donner au client une interface simple a utiliser
        <p>
    </div>
</div>
<?php
require_once("inc/footer.inc.php");
?>