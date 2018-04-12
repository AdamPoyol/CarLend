<?php 

//Connexion a la bade de données

$bdd = 'Carlend';

$host = "localhost" ;

$user = "root" ;

$mdp = "" ;

$connect = mysql_connect($host, $user, $mdp) ;

 ?>

 <?php 


$Nom=$_POST['Nom'];
$Prenom=$_POST['Prenom'];
$telephone=$_POST['telephone'];
$Adresse=$_POST['Adresse'];
$Code_postale=$_POST['Code_postale'];
$mail=$_POST['mail'];
$Ville=$_POST['Ville'];
$password=$_POST['password']



$sql="insert into Locataire (Nom, Prenom, telephone, Adresse, Code_postale, mail, Ville) values ('$Nom','$Prenom', '$telephone', '$Adresse', '$Code_postale', '$mail', '$Ville', '$password')" ;


  ?>