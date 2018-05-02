<?php

include ("inc/header.inc.php");

if (isset($_SESSION['id_utilisateur'])){
    $requete_utilisateur = executeRequete("SELECT identifiant, mot_de_passe FROM utilisateur WHERE id_utilisateur=".$_SESSION['id_utilisateur']);
    $liste_utilisateur = $requete_utilisateur -> fetch_assoc();

    if ($liste_utilisateur['identifiant'] == 'administrateur' && $liste_utilisateur['mot_de_passe'] == 'admin1234'){

        echo '<div class="clear"></div><div class="admin">';

        $result = $mysqli->query('SHOW TABLES');
        $listeTables = $result->fetch_assoc();
        if (!$result){
            echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
        }

        echo "<br><table border=\"1\">";
        foreach ($result as $listeTables) {

            $curseur = current($listeTables);

            echo '<td>';
            echo '<a href="'.$_SERVER["PHP_SELF"].'?table=' . $curseur . '"> ' . $curseur . ' </a>';
            echo '</td>';

            $curseur = next($listeTables);
        }
        echo '</table><br>';

        if (isset($_GET['table'])) {
            $table = $_GET['table'];

            $result = $mysqli->query('SELECT * FROM ' . $table);
            $requete = $result->fetch_assoc();
            if (!$result){
                echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
            }

            echo '<a href="telechargement.php?table='.$table.'" target = "_blank" class="lien">Enregistrer la table dans un fichier exel</a><br><br>';

            $form = '';
            $formulaire = '';
            $boutonForm = 'Ajouter';

            $erreur = FALSE;

            $k = 0;

            if (sizeof($requete) != 0){
                foreach ($result as $requete) {
                    $colonne = '';
                    for ($i = 0; $i < sizeof($requete) + 2; $i++) {
                        if ($k < 10) {
                            $w = 0;
                        } elseif ($k >= 10 && $k < 100) {
                            $w = "";
                        }
                        if ($i == sizeof($requete)) {
                            ${'tab' . $k}[$i] = '<a href="'.$_SERVER["PHP_SELF"].'?table=' . $table . '&option=modifier_' . $colonne . $w . $k . '"><img class="bouton" src="inc/img/modifier.jpg" alt="modif"></a>';
                        } elseif ($i == sizeof($requete) + 1) {
                            ${'tab' . $k}[$i] = '<a href="'.$_SERVER["PHP_SELF"].'?table=' . $table . '&option=supprimer_' . $colonne . $w . $k . '"><img class="bouton" src="inc/img/supprimer.jpg" alt="suppr"></a>';
                        } else {
                            $curseur = current($requete);
                            $indice[$i] = key($requete);
                            ${'tab' . $k}[$i] = $curseur;
                            ${'id' . $k} = ${'tab' . $k}[$i];
                            $condition = substr($indice[$i], 0, 3) == 'id_' && substr($indice[$i], 3, strlen($indice[$i]) - 3) == $table;
                            if ($condition) {
                                $colonne = $indice[$i];
                                $indiceId = $i;
                            }
                        }
                        $curseur = next($requete);
                    }
                    $tab[$k] = ${'tab' . $k};

                    $k++;
                }
            }
            else{
                $result = $mysqli->query('DESC ' . $table);
                $requete = $result->fetch_assoc();
                if (!$result){
                    echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
                }

                $i = 0;
                foreach ($result as $requete) {

                    $indice[$i] = $requete['Field'];
                    $i++;
                }
                $tab = array();
            }

            if (isset($_POST['Ajouter'])) {
                $colonne = '';
                $value = '';
                for ($i = 0; $i < sizeof($indice); $i++) {
                    $condition = substr($indice[$i], 0, 3) == 'id_' && substr($indice[$i], 3, strlen($indice[$i]) - 3) == $table;
                    if (!$condition) {
                        if ($_POST[$indice[$i]] == '') {
                            $a = 'NULL';
                        } else {
                            $a = '\'' . $_POST[$indice[$i]] . '\'';
                        }

                        if ($colonne == '') {
                            $value = $a;
                            $colonne = $indice[$i];
                        } else {
                            $value = $value . ',' . $a;
                            $colonne = $colonne . ',' . $indice[$i];
                        }
                    }

                }
                $result = $mysqli->query("INSERT INTO $table($colonne)VALUES($value)");
                if (!$result){
                    echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
                }
                else{
                    header('Location: '.$_SERVER["PHP_SELF"].'?table='.$table);
                }
            }


            if (isset($_GET['option'])) {
                $option = $_GET['option'];
                if (substr($option, -2, 1) == '0') {
                    $id = substr($option, -1, 1);
                } else {
                    $id = substr($option, -2, 2);
                }
                if ($id >= $k) {
                    $erreur = TRUE;
                } else {
                    if (substr($option, 0, 9) == 'supprimer') {
                        $colonne = substr($option, 10, strlen($option) - 12);

                        $result = $mysqli->query('DELETE FROM ' . $table . ' WHERE ' . $colonne . '="' . ${'tab' . $id}[$indiceId] . '"');
                        if (!$result){
                            echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
                        }
                        else {
                            header('Location: '.$_SERVER["PHP_SELF"].'?table=' . $table . '');
                        }
                    } elseif (substr($option, 0, 8) == 'modifier') {
                        $colonne = substr($option, 9, strlen($option) - 11);
                        $form = 'modifier';
                        $boutonForm = 'Modifier';
                    } else {
                        $form = '';
                        $boutonForm = 'Ajouter';
                    }
                    if (isset($_POST['Modifier'])) {
                        $set = '';
                        for ($i = 0; $i < sizeof($indice); $i++) {
                            $condition = substr($indice[$i], 0, 3) == 'id_' && substr($indice[$i], 3, strlen($indice[$i]) - 3) == $table;
                            if (!$condition) {
                                if ($_POST[$indice[$i]] == '') {
                                    $a = 'NULL';
                                } else {
                                    $a = '"' . $_POST[$indice[$i]] . '"';
                                }
                                $colonneModif = $indice[$i];
                                if ($set == '') {
                                    $set = $colonneModif . '=' . $a;
                                } else {
                                    $set = $set . ', ' . $colonneModif . '=' . $a;
                                }
                                $b = $i;
                            }
                        }
                        if (${'tab' . $id}[$b] == '') {
                            $value = 'NULL';
                        } else {
                            $value = '"' . ${'tab' . $id}[$b] . '"';
                        }
                        $result = $mysqli->query('UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $colonne . '="' . ${'tab' . $id}[$indiceId] . '"');
                        if (!$result){
                            echo 'Erreur  : '.mysqli_error($mysqli).'<br>';
                        }
                        else {
                            header('Location: '.$_SERVER["PHP_SELF"].'?table=' . $table . '');
                        }
                    }
                }
            }

            if ($erreur == FALSE) {
                echo "<table border=\"1\">";

                for ($i = 0; $i < sizeof($indice) + 2; $i++) {
                    echo "<th><strong>";
                    if ($i == sizeof($indice)) {
                        echo 'modification';
                    } elseif ($i == sizeof($indice) + 1) {
                        echo 'suppression';
                    } else {
                        echo $indice[$i];
                    }
                    echo "</strong></th>";
                }

                for ($i = 0; $i < sizeof($tab); $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < sizeof($tab[$i]); $j++) {
                        echo "<td>";
                        echo $tab[$i][$j];
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';

                echo '<br><form method="post">';
                $listeIndices = '';

                for ($i = 0; $i < sizeof($indice); $i++) {
                    $condition = substr($indice[$i], 0, 3) == 'id_' && substr($indice[$i], 3, strlen($indice[$i]) - 3) == $table;
                    if (!$condition) {
                        if ($form == 'modifier') {
                            $formulaire = ${'tab' . $id}[$i];
                        }
                        echo '<label for="' . $indice[$i] . '">' . $indice[$i] . ' :</label><br>
            <input name="' . $indice[$i] . '" value="' . $formulaire . '" type="text"><br><br>';
                        $listeIndices = $listeIndices . ',' . $indice[$i];
                    }
                }
                echo '<input type="submit" name="' . $boutonForm . '" value="' . $boutonForm . '"></form><br>';
            } else {
                echo '<strong>ERREUR</strong>';
            }

        }

        echo '</div>';

    }
    else{
        echo "<div class='admin'>Erreur</div>";
    }
}
else{
        echo "<div class='admin'>vous n'avez pas les droits pour accèder à cette page</div>";
    }

include ("inc/footer.inc.php");

?>
