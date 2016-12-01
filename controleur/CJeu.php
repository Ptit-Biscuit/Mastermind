<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace controleur;

require_once __DIR__."/../vue/VJeu.php";
use vue\VJeu;

require_once __DIR__."/../vue/VJeuTerminer.php";
use vue\VJeuTerminer;

require_once __DIR__."/../modele/Jeu.php";
use modele\Jeu;

class CJeu {
    /**
     * Méthode qui commence une nouvelle partie
     */
    public static function startGame() { $_SESSION['jeu'] = new Jeu(); }

    /**
     * Méthode qui continue la partie en cours
     */
    public static function contGame() {
        if(isset($_SESSION['jeu']) && isset($_GET['color'])) {
            $colors = array("white", "yellow", "orange", "red", "fuchsia", "purple", "green", "blue");
            if(in_array($_GET['color'], $colors)) $_SESSION['jeu']->updateBoard($_GET['color']);
            else VJeu::displayGame($_SESSION['jeu']->getBoard());
        }
    }

    /**
     * Méthode pour quitter la partie
     */
    public static function quitGame() { VJeuTerminer::endOfGame(); }
}