<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace vue;

class Login {
    /**
     * Méthode qui affiche la demande du pseudo et du mot de passe
     */
    public static function displayLogin() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Login Mastermind</title>
                <link rel="stylesheet" type="text/css" href="/style/css/login.css">
            </head>

            <body>
                <div class="container">
                    <div class="login">
                        <h1>Authentification</h1>

                        <form action="index.php" method="POST" id="form">
                            <input type="text" name="pseudo" placeholder="Identifiant"><br/>
                            <input type="password" name="password" placeholder="Mot de passe"><br/>

                            <input type="submit">
                            <input type="reset">
                        </form>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}