<!DOCTYPE html>
<html>
<head>
	<title>inscription</title>
	<link rel="stylesheet" href="pageinscription.css">
</head>
<body>
	<header>
		<div class="header_gauche">
			<img id="CarLend" src="logo.png" alt="logo CarLend"/>
		</div>
		<div class="header_droite">
			<input id="login" type="login" name="login" placeholder="login"/>
			<input id="mdp" type="password" name="mdp" placeholder="password"/>
			<input type="submit" value="se connecter"/>
			<a href="">Inscription</a>
		</div>
				</div>
		<div class="zone1">
			<div class="recherche">
				<input id="marque" type="word" name="marque" placeholder="Marque"/>
				<input id="modele" type="word" name="modele" placeholder="Modèle"/>
				<input id="ville" type="word" name="ville" placeholder="Ville"/>
				<input type="submit" value="Rechercher"/>
			</div>
	</header>

	<div class="formulaire">
		<form method="POST" action="envoi_donnees.php">
			<table>
			<tr>
                 <td>
                        <label >Nom :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="nom"  placeholder=" Votre Nom">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Prénom :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="prenom"  placeholder=" Votre Prénom">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Adresse e-mail :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="email" placeholder=" Votre Adresse e-mail">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Numéro de téléphone :</label>
                    </td>
                    <td>
                        <input type="text" class="case"  name="telephone" placeholder=" Votre numéro de téléphone">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Adresse :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="adresse" placeholder=" Votre Adresse">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >code postale :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="code_postale" placeholder=" Votre code postale">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Ville :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="ville" placeholder=" Votre Ville">
                    </td>
                </tr> 
                <tr>
                    <td>
                        <label >Copie de permis :</label>
                    </td>
                    <td>
                        <input type="text" class="case" name="permis" placeholder=" Votre Copie de permis">
                    </td>
                </tr> 
            </table>
            <input class="envoyer" type="submit" name="envoyer" mailto="romainmesguich@gmail">
		</form>
	</div>
</body>
</html>

