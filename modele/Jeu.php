<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 21:29
 */

namespace modele;

require_once __DIR__."/../vue/Erreur.php";
use vue\Erreur;

require_once __DIR__."/../vue/VJeu.php";
use vue\VJeu;

require_once __DIR__."/../modele/Plateau.php";

class Jeu {
    /**
     * @var Plateau Le plateau du jeu
     */
    private $board;

    /**
     * @var int Le nombre de coups restants à jouer
     */
    private $remainingShots;

    /**
     * @var int L'indice de la prochaine case à colorer
     */
    private $i;

    /**
     * Jeu constructor.
     */
    public function __construct() {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            $this->board = new Plateau();
            $this->remainingShots = 10;
            $this->i = 0;

            VJeu::displayGame($this->board);
        }
    }

    /**
     * Actualise la vue du jeu
     * @param $color String La couleur à ajouter
     */
    public function updateBoard($color) {
        if($this->i < 4) {
            $this->board->getTries()[10 - $this->remainingShots]->setCase($this->i, $color);
            $this->i++;
        }
        else VJeu::displayMustValidate();

        VJeu::displayGame($this->board);
    }

    /**
     * Getter de plateau
     * @return Plateau Le plateau du jeu
     */
    public function getBoard() { return $this->board; }
}