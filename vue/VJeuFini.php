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

        <?php if($winOrLose) echo "vous avez gagné la partie    BRAVO";
        else echo "Dommage vous avez perdu la partie"; ?>

        <?php
        VJeu::actionsEndGame();
    }

    public static function endOfGame() {
        if(!empty($_SESSION)) session_destroy();
        header("Location: index.php");
    }
}