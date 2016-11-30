<?php
/**
 * Created by PhpStorm.
 * User: E155939Z
 * Date: 30/11/16
 * Time: 11:32
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
     * Plateau constructor.
     */
    public function __construct()
    {
        $this->essais = array(new Rangee(), new Rangee(), new Rangee(),
            new Rangee(), new Rangee(), new Rangee(),
            new Rangee(), new Rangee(), new Rangee(),
            new Rangee());

        $this->soluce = new Rangee();
        $this->soluce->initSoluce();
    }

    /**
     * @return array
     */
    public function getTries()
    {
        return $this->essais;
    }

    /**
     * @return Rangee
     */
    public function getSoluce()
    {
        return $this->soluce;
    }
}