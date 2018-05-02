<?php
$mysqli = new Mysqli("mysql-carlend.alwaysdata.net", "carlend", "Romain83", "carlend_bdd");

if($mysqli->connect_error) die("Un problème est survenu lors de la tentativer de connexion à la BDD : ".$mysqli->connect_error);

// if(!$mysqli->set_charset('utf8')) die("Erreur lors du chargement du jeu utf8 ".$mysqli->error);

//SESSION
session_start();

// CHEMIN
define("RACINE_SITE","/site/");

$contenu = '';

require_once("fonction.inc.php");
