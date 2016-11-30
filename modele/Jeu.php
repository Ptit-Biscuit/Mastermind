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
    private $plateau;

    /**
     * Jeu constructor.
     */
    public function __construct() {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            $this->plateau = new Plateau();

            VJeu::displayGame($this->plateau);
        }
    }

    /**
     * Actualise la vue du jeu
     * @param $color String La couleur à ajouter
     */
    public function updateBoard($color) {
        $this->plateau->getEssais();
    }
}