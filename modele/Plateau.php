<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

require_once __DIR__."/../modele/Rangee.php";

class Plateau {
    /**
     * @var array Les essais
     */
    private $essais;

    /**
     * @var Rangee La solution pour ce plateau
     */
    private $soluce;

    /**
     * Le construcyeur de Plateau
     */
    public function __construct() {
        $this->essais = array(new Rangee(), new Rangee(), new Rangee(),
            new Rangee(), new Rangee(), new Rangee(),
            new Rangee(), new Rangee(), new Rangee(),
            new Rangee());

        $this->soluce = new Rangee();
        $this->soluce->initSoluce();
    }

    /**
     * Getter des essais du plateau
     * @return array Les essais
     */
    public function getTries() { return $this->essais; }

    /**
     * Getter de la solution du plateau
     * @return Rangee La solution
     */
    public function getSoluce() { return $this->soluce; }
}