
<?php
    require_once("../inc/header.inc.php");
?>
        <div class = "conteneur_contact">
            <h2> Envoyer une demande </h2>
            <p> Aidez-nous à vous répondre plus rapidement.

                Précisez vos problèmes en renseignant les champs ci-dessous ce qui nous permettra
                d'orienter votre question vers le département adéquat.
                Soyez précis et si besoin, n'hésitez pas à associer à votre message des photocopies de documents.</p>

            <form method="post" action=".php">
                <label><br>
                    <label>Adresse e-mail</label>
                    <input class="contact" id="email" type="email" name="mail" placeholder="Adresse e-mail"/><br><br>

                    <label>Sujet</label>
                    <input class="contact" id="text" type="text" name="subject" placeholder="Sujet" /><br><br>

                    <label>Descriptif</label>
                    <textarea  class="contact2" name="ameliorer" id="ameliorer" placeholder="Descriptif" ></textarea><br><br>

                    <label>Pièces jointes</label>
                    <input class="contact2" type="file" multiple="true" id="request-attachments" data-fileupload="true" data-dropzone="upload-dropzone" ><br><br><br>

                    <input class="contact" type="submit" name ="commit" value="Envoyer">
                    <br><br><br>
                </label>
            </form>
        </div>
<?php
require_once("../inc/footer.inc.php");
?>
