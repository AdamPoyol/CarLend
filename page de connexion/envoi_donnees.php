<?php 

//Connexion a la bade de données

private $bdd = 'Carlend';

private $host = "localhost" ;

private $user = "root" ;

private $mdp = "" ;

private $connect = mysql_connect($host, $user, $mdp) ;


$Nom=$_POST['Nom'];
$Prenom=$_POST['Prenom'];
$telephone=$_POST['telephone'];
$Adresse=$_POST['Adresse'];
$Code_postale=$_POST['Code_postale'];
$mail=$_POST['mail'];
$Ville=$_POST['Ville'];
$password=$_POST['password']
$copie_permis=$_POST['copie_permis'];



$sql="insert into Locataire (Nom, Prenom, telephone, Adresse, Code_postale, mail, Ville) values ('$Nom','$Prenom', '$telephone', '$Adresse', '$Code_postale', '$mail', '$Ville', '$password')";

 mysql_query('$sql');

//On ferme la connexion

mysql_close();

  ?>