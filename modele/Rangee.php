<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
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
     * Le constructeur de Rangee
     */
    public function __construct() {
        $this->cases = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
        $this->verif = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
    }

    /**
     * Méthode qu initialise les cases de la rangée solution en tirant
     * une couleur au hasard parmi celles du jeu
     * @param $colors array Les couleurs possibles
     */
    public function initSoluce($colors) {
        $soluceCases = array();

        for($i = 0; $i < 4; $i++) array_push($soluceCases, $this->colors[rand(0, 7)]);

        $this->setCases($soluceCases);
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