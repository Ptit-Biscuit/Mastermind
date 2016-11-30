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

require_once __DIR__."/../vue/VJeuTerminer.php";
use vue\VJeuTerminer;

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
    private $idNextCase;

    /**
     * Le constructeur de Jeu
     */
    public function __construct() {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            $this->board = new Plateau();
            $this->remainingShots = 10;
            $this->idNextCase = 0;

            VJeu::displayGame($this->board);
        }
    }

    /**
     * Méthode qui actualise la vue du jeu
     * @param $color String La couleur à ajouter
     */
    public function updateBoard($color) {
        if($this->idNextCase < 4) {
            $this->board->getTries()[10 - $this->remainingShots]->setCase($this->idNextCase, $color);
            $this->idNextCase++;
        }
        else VJeu::displayMustValidate();

        VJeu::displayGame($this->board);
    }

    /**
     * Méthode qui valide une rangée du plateau en fonction de la solution
     */
    public function validate() {
        if($this->remainingShots > 0) {
            $row = $this->board->getTries()[10 - $this->remainingShots]->getCases();

            if(!in_array("darkgrey", $row)) {
                $soluce = $this->board->getSoluce()->getCases();
                $verif = array();
                $index = 0;

                for($i = 0; $i < 4; $i++) {
                    if(in_array($row[$i], $soluce) && ($row[$i] == $soluce[$i])) $verif[$index] = "black";
                    else if(in_array($row[$i], $soluce)) $verif[$index] = "white";
                    else $verif[$index] = "darkgrey";

                    $index++;
                }

                if($verif == "black") VJeuTerminer::gameOver(true);
                else {
                    $this->board->getTries()[10 - $this->remainingShots]->setVerif($verif);
                    $this->remainingShots--;
                }
            }

            VJeu::displayGame($this->board);
        }
        else VJeuTerminer::gameOver(false);
    }

    /**
     * Getter de plateau
     * @return Plateau Le plateau du jeu
     */
    public function getBoard() { return $this->board; }
}