<?php

function executeRequete($req){
    $mysqli = new mysqli("localhost", "root", "", "carlend");  // on accède à la bdd
    $resultat = $mysqli->query($req);
    if(!$resultat) die("erreur sur la requete sql.<br>Message :".$mysqli->error."<br>Code :".$req);
    return $resultat;
}

function debug($var,$mode=1){
    echo '<div style="background: orange; padding: 5px; float: left; clear: both;">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo 'Debug demandé dans le fichier : '.$trace["file"].' à la ligne'.$trace["line"].'<hr>';
    if($mode===1){
        echo '<pre>'.print_r($var).'</pre>';
    }
    else{
        echo '<pre>'.var_dump($var).'</pre>';
    }
    echo '</div>';
}

?>