<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace vue;

class VJeuFini {
    /**
     * Méthode qui affiche le résultat en fin de partie
     * @param $winOrLose bool True si la partie est gagnée, false sinon
     */
    public static function gameOver($winOrLose) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <title>Fin du jeu</title>
            </head>

            <body>
                <?php if($winOrLose) echo "vous avez gagné la partie    BRAVO";
                else echo "Dommage vous avez perdu la partie"; ?>
            </body>
        </html>
        <?php

        if(!empty($_COOKIE)) unset($_COOKIE);

        VJeu::actionsEndGame();
    }

    public static function endOfGame() {
        if(!empty($_SESSION)) {
            session_destroy();
            session_abort();
        }
        header("Location: index.php");
    }
}