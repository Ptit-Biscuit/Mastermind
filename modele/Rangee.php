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
     * Le constructeur de Rangee
     */
    public function __construct() {
        $this->cases = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
        $this->verif = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
        $this->colors = array("red", "yellow", "green", "blue", "orange", "white", "purple", "fuchsia");
    }

    /**
     * Méthode qu initialise les cases de la rangée solution en tirant
     * une couleur au hasard parmi celles du jeu
     */
    public function initSoluce() {
        $soluceCases = array();

        for($i = 0; $i < 4; $i++) array_push($soluceCases, $this->colors[rand(0, 7)]);

        $this->setCases($soluceCases);

        echo "Solution - ".$this->cases[0]." ".$this->cases[1]." ".$this->cases[2]." ".$this->cases[3];
    }

    /**
     * Getter des cases de la rangée
     * @return array Les cases de la rangée
     */
    public function getCases() { return $this->cases; }

    /**
     * Setter d'une case de la rangée
     * @param $index int L'indice de la case
     * @param $color String La couleur à mettre pour la case
     */
    public function setCase($index, $color) { $this->cases[$index] = $color; }

    /**
     * Setter des cases de la rangée
     * @param $cases array Les nouvelles cases de la rangée
     */
    public function setCases($cases) { $this->cases = $cases; }

    /**
     * Getter de la vérification de la rangée
     * @return array La vérification de la rangée
     */
    public function getVerif() { return $this->verif; }

    /**
     * Setter de la vérification de la rangée
     * @param $verif array La nouvelle vérification de la rangée
     */
    public function setVerif($verif) { $this->verif = $verif; }
}