<?php

if(isset($_GET['table'])){
    $table = $_GET['table'];

    $mysqli = new Mysqli("localhost", "root", "", "carlend");

    $result = $mysqli->query('SELECT * FROM ' . $table);
    $requete = $result->fetch_assoc();
    if (!$result){
        echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
    }
    else{
        $tableauRequete = array();
        $tableauRequete[] = implode(";", array_keys($requete));
        foreach($result as $requete) {
            $tableauRequete[] = implode(";", $requete);
        }
        $tableauRequete = implode("\r", $tableauRequete);
        $fichier = $table.'_carlend.csv';

        header("Content-Disposition: attachment; filename=$fichier");
        header("Content-Type: application/vnd.ms-excel");

        echo $tableauRequete;
    }
}
?>