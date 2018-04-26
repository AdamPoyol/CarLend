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

          <select class="annee" name="annee">
            <option >Choisir une année</option>
            <optgroup label="">
              <option >2018</option>
              <option >2017</option>
              <option >2016</option>
              <option >2015</option>
              <option >2014</option>
              <option >2013</option>
              <option >2012</option>
              <option >2011</option>
              <option >2010</option>
              <option >2009</option>
              <option >2008</option>
              <option >2007</option>
              <option >2006</option>
              <option >2005</option>
              <option >2004</option>
              <option > . . . </option>
            </optgroup>
          </select>

          <input type="submit" value="Etape suivante"/>
        </div>
			</div>

			<div class="clear"></div>

      <div class="zone3_location">
        <h1>Comment faire ?</h1>

          <h2>Propriétaire déposer un véhicule</h2>

          <p>Etape 1: Pour déposer son véhicule il suffit de cliquer sur "Déposer mon véhicule".</p>

          <p>Etape 2: Vous tomberer sur un formulaire à remplir puis vous cliquer sur "Envoyer".</p>

          <p>Etape 3: Votre véhicule sera à présent sur notre site.</p>
      </div>
      <?php
    require_once("inc/footer.inc.php");
?>