<?php
    echo "<!DOCTYPE html>
<html>
	<head>
		<meta charset=\"utf-8\">
		<title>Accueil</title>
		<link rel=\"stylesheet\" href=\"../inc/css/css_carlend.css\">
		<script src=\"js_carlend.js\" type=\"text/javascript\"></script>
	</head>
	<body>
		<div id=\"conteneur_accueil\">
			<div class=\"header\">
					<div class=\"header_gauche\">
						<div class=\"header_gauche_menu\">
							<a href=\"../views/accueil_carlend.php\">Accueil</a><br>
								<a href=\"../views/location_carlend.php\">Louer mon véhicules</a><br>
						</div>

						<div class=\"header_gauche_logo\">
							<img id=\"CarLend\" src=\"../inc/img/logo.png\" alt=\"logo CarLend\"/>
						</div>

					</div>
					<div class=\"header_droite\">
						<form method=\"POST\" action=\".php\">
						<input id=\"login\" type=\"text\" name=\"login\" placeholder=\"login\"/>
						<input id=\"mdp\" type=\"password\" name=\"mdp\" placeholder=\"password\"/>
						<input type=\"submit\" value=\"se connecter\"/><br>
					</form>
						<input type=\"submit\" value=\"Inscription\"/><br>
					</div>
			</div>";
    ?>