<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 30/11/2016
 * Time: 19:51
 */

namespace vue;


class VJeuTerminer {
    public static function gameOver() {
        echo "c'est fini boulet";

        VJeu::actions();
    }
}