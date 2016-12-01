<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 01/12/2016
 * Time: 15:02
 */

namespace modele;

require_once __DIR__."/../modele/Jeu.php";

class Statistique {
    /**
     * @var String Le pseudo du joueur
     */
    private $pseudoPlayer;

    /**
     * @var bool Le résultat de la dernière partie
     */
    private $gameResult;

    /**
     * @var int Le nombre de coups joués
     */
    private $shotsNumber;

    /**
     * Le constructeur de Statistique
     */
    public function __construct($pseudoPlayer) {
        if(isset($_SESSION['pseudo'])) $this->pseudoPlayer = $_SESSION['pseudo'];
        else;
    }
}