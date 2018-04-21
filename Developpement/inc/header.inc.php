<?php
require_once("inc/init.inc.php");
echo "<!DOCTYPE html>
<html>
	<head>
		<meta charset=\"utf-8\">
		<title>Accueil</title>
		<link rel=\"stylesheet\" href=\"inc/css/css_carlend.css\">
		<script src=\"inc/js/js_carlend.js\" type=\"text/javascript\"></script>
	</head>
	<body>
		<div id=\"conteneur_accueil\">
			<div class=\"header\">
					<div class=\"header_gauche\">
						<div class=\"header_gauche_menu\">
							<a href=\"accueil_carlend.php\">Accueil</a><br><br>
								<a href=\"location_carlend.php\">Louer mon véhicules</a><br>
						</div>
						<div class=\"header_gauche_logo\">
							<a href='accueil_carlend.php'><img id=\"CarLend\" src=\"inc/img/logo.png\" alt=\"logo CarLend\"/></a>
						</div>
					</div>
					<div class=\"header_droite\">
					";

if(!isset($_SESSION['id_utilisateur'])){
    echo "
						<form method=\"POST\" action=\"connexion.php\">
						<input id=\"login\" type=\"text\" name=\"identifiant\" placeholder=\"identifiant\"/>
						<input id=\"mdp\" type=\"password\" name=\"mot_de_passe\" placeholder=\"mot de passe\"/>
						<input type=\"submit\" value=\"Connexion\" name='connexion'/>
                        </form><br>
                        <a href=\"inscription.php\">Inscription</a>";
}
else {
    $requete_utilisateur = executeRequete("SELECT nom, prenom FROM utilisateur WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
    $liste_utilisateur = $requete_utilisateur -> fetch_assoc();

    echo "nom : ".$liste_utilisateur['nom']."<br>prenom : ".$liste_utilisateur['prenom']."<br>
           <form method=\"POST\" action=\"".$_SERVER["PHP_SELF"]."\">
           <input type=\"submit\" value=\"Se déconnecter\" name='deconnexion'/>
           </form><br>";
}
echo "</div>
		</div>";


// Déconnexion

if(!empty($_POST['deconnexion'])) {

    $_SESSION = array();  // on détruit les variables de session

    session_destroy(); // on détruit la session

    header('Location: accueil_carlend.php');  // on redirige l'utilisateur vers la page d'accueil
}

?>