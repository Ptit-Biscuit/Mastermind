<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 21:29
 */

namespace modele;

require_once __DIR__."/../vue/VJeu.php";
use vue\VJeu;

class Jeu {
    /**
     * Jeu constructor.
     */
    public function __construct() {
        $this->initBoard();
    }

    public function initBoard() {
        $vueJeu = new VJeu();
    }
}