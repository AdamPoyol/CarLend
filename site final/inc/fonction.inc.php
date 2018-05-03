<?php

function executeRequete($req,$en_ligne=true){
    $mysqli = new mysqli("mysql-carlend.alwaysdata.net", "carlend", "Romain83", "carlend_bdd");  // on accède à la bdd
    $resultat = $mysqli->query($req);
    if (!$resultat){
        if ($en_ligne == false) {
            die("erreur sur la requete sql.<br>Message :" . $mysqli->error . "<br>Code :" . $req);
        }
        else{
            echo '<div style="color: #c43b3c;margin: 1% 40% 0 40%;border: 1px solid #c43b3c;text-align: center">
                <h5>Erreur de saisi</h5>
              </div>';
        }
    }
    return $resultat;
}

function debug($var,$mode=1,$en_ligne=true){
    if ($en_ligne == false){
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
}

function replace($var){
    $result = str_replace("'", " ", $var);
    $result = str_replace('"', ' ', $result);
    $result = str_replace('\\', ' ', $result);
    return $result;
}

?>