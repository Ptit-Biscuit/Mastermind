<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 30/11/2016
 * Time: 19:51
 */

namespace vue;

class VJeuTerminer {
    /**
     * Méthode qui affiche le résultat en fin de partie
     * @param $winOrLose bool True si la partie est gagnée, false sinon
     */
    public static function gameOver($winOrLose) {
        ?>

        <?php if($winOrLose) echo "vous avez gagné la partie    BRAVO";
        else echo "Dommage vous avez perdu la partie"; ?>

        <?php
        VJeu::actions();
    }

    public static function endOfGame() {
        if(!empty($_SESSION)) session_destroy();
        header("Location: index.php");
    }
}