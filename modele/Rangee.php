<?php
/**
 * Created by PhpStorm.
 * User: E155939Z
 * Date: 30/11/16
 * Time: 11:33
 */

namespace modele;


class Rangee {
    /**
     * @var array Les cases
     */
    private $cases;

    /**
     * @var array Les vérifications
     */
    private $verif;

    /**
     * @var array Les couleurs possibles
     */
    private $colors;

    /**
     * Rangee constructor.
     */
    public function __construct() {
        $this->cases = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
        $this->verif = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
        $this->colors = array("red", "yellow", "green", "blue", "orange", "white", "purple", "fuchsia");
    }

    /**
     * Initialise les cases de la rangée solution en tirant
     * une couleur au hasard parmi celles du jeu
     */
    public function initSoluce() {
        $casesSoluce = array();

        for($i = 0; $i < 4; $i++) array_push($casesSoluce, $this->colors[rand(0, 7)]);

        $this->setCases($casesSoluce);

        echo "Solution - ".$this->cases[0]." ".$this->cases[1]." ".$this->cases[2]." ".$this->cases[3];
    }

    /**
     * @return array
     */
    public function getCases() { return $this->cases; }

    /**
     * @param $indice int L'indice de la case
     * @param $color La couleur à mettre pour la case
     */
    public function setCase($indice, $color) { $this->cases[$indice] = $color; }

    /**
     * @return array
     */
    public function getVerif() { return $this->verif; }

    /**
     * @param array
     */
    public function setVerif($verif) { $this->verif = $verif; }
}