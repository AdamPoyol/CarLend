<?php
require_once("inc/header.inc.php");
?>
    <div class="zone1_location">
        <div class="louer">
            <a href="">Proposer mon véhicule à la location</a>
        </div>
    </div>
    <div class="clear"></div>
    <div class="zone2_location">
        <div class="recherche_location">
            <br>
            <select id="marque" name="marque" onchange="AdaptationModele(this.value);">
                <option value="default" >Choisir une marque</option>
                <option value="citroen">Citroën</option>
                <option value="peugeot">Peugeot</option>
                <option value="renault">Renault</option>
                <option value="volkswagen">Volkswagen</option>

                <optgroup label="Autres marques">
                    <option value="alpharomeo">Alpha Romeo</option>
                    <option value="audi">Audi</option>
                    <option value="bmw">BMW</option>
                    <option value="fiat">Fiat</option>
                    <option value="opel">Opel</option>
                    <option value=""> . . . </option>
                </optgroup>
            </select>

            <select id="modele" name="modele">
                <option >Choisir un modèle</option>
            </select>

            <input type="text" name="annee" placeholder="année"/>

            <input type="submit" value="Etape suivante"/>
        </div>
    </div>
    <div class="clear"></div>
    <div class="zone3_location">
        <h2>Comment faire ?</h2>
    </div>
<?php
require_once("inc/footer.inc.php");
?>