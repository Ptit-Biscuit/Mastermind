<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 20:14
 */

namespace vue;

class Login {
    public static function displayLogin() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Login Mastermind</title>
            </head>

            <body>
                <div>
                    <h1>Authentification</h1>

                    <form action="index.php" method="POST">
                        <input type="text" name="pseudo" placeholder="Identifiant"><br/>
                        <input type="password" name="password" placeholder="Mot de passe"><br/>

                        <input type="submit">
                        <input type="reset">
                    </form>
                </div>
            </body>
        </html>
        <?php
    }
}