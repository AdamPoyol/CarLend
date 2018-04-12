<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Contactez-nous</title>
        <link rel="stylesheet" href="../css/css_carlend.css">
    <body>
        <div class="header">
            <header>
                <div class="header_gauche">
                    <a href="accueil_carlend.php"><img id="CarLend" src="../Images/logo.png" alt="logo CarLend"/></a>
                </div>
                <div class="header_droite">
                    <input id="login" type="text" name="login" placeholder="login"/>
                    <input id="mdp" type="password" name="mdp" placeholder="password"/>
                    <input type="submit" value="Connexion"/>
                    <input type="submit" value="Inscription"/><br>
                </div>
            </header>
        </div>
        <div class = "conteneur">
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
        <div class="clear"></div>
        <footer>
            <div class="footer">
                <div class="footer_gauche">
                    <p>
                        <a href="contact_carlend.php">Nous contacter</a><br>
                        <a href="">Comment ça marche ?</a><br>
                        <a href="">A propos</a>
                    </p>
                </div>
                <div class="footer_droite">
                    <p>
                        <a href="accueil_carlend.html">CarLend © 2018</a>
                </div>
            </div>
        </footer>
    </body>
</html>