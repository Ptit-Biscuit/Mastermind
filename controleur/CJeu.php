<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace controleur;

require_once __DIR__."/../vue/VJeu.php";
use vue\VJeu;

require_once __DIR__."/../vue/VJeuFini.php";
use vue\VJeuFini;

require_once __DIR__."/../modele/Jeu.php";
use modele\Jeu;

class CJeu {
    /**
     * Méthode qui commence une nouvelle partie
     */
    public static function startGame() {
        $_SESSION['jeu'] = new Jeu();
        VJeu::displayGame($_SESSION['jeu']->getBoard());
    }

    /**
     * Méthode qui continue la partie en cours
     */
    public static function contGame() {
        if(isset($_SESSION['jeu']) && isset($_GET['color'])) {
            $colors = array("white", "yellow", "orange", "red", "fuchsia", "purple", "green", "blue");
            if(in_array($_GET['color'], $colors) && ($_SESSION['jeu']->updateBoard($_GET['color'])))
                VJeu::displayGame($_SESSION['jeu']->getBoard());
            else {
                VJeu::displayGame($_SESSION['jeu']->getBoard());
                VJeu::displayMustValidate();
            }
        }
    }

    /**
     * Méthode qui valide une ligne du plateau
     */
    public static function validate() {
        $resultValidation = $_SESSION['jeu']->validate();

        if($resultValidation && isset($_COOKIE['endGame'])) VJeuFini::gameOver(true);
        else if($resultValidation) VJeu::displayGame($_SESSION['jeu']->getBoard());
        else VJeuFini::gameOver(false);
    }

    /**
     * Méthode qui efface une ligne du plateau
     */
    public static function eraseLine() {
        $_SESSION['jeu']->eraseLine();
        VJeu::displayGame($_SESSION['jeu']->getBoard());
    }

    /**
     * Méthode pour quitter la partie
     */
    public static function quitGame() { VJeuFini::gameOver(false); }

    /**
     * Méthode pour se déconnecter de la partie
     */
    public static function disconnect() { VJeuFini::endOfGame(); }
}