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

require_once __DIR__."/../modele/Bd.php";
use modele\Bd;

require_once __DIR__."/../modele/StatistiqueG.php";
use modele\StatistiqueG;

require_once __DIR__."/../controleur/Routeur.php";

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
        $_SESSION['jeu']->validate(); // on valide le coup ou non

        if(!$_SESSION['jeu']->isFinished()) // la partie n'est pas finie, on affiche le plateau
            VJeu::displayGame($_SESSION['jeu']->getBoard());
        else { // la partie est terminée !
            self::genStats(); // on créé les statistiques de la partie
        }
    }

    /**
     * Génère les statistiques en fin de partie
     */
    public static function genStats() {
        $bd = new Bd();

        if($_SESSION['jeu']->isVictory()) $gameResult = 1;
        else $gameResult = 0;

        $statsG = new StatistiqueG($_SESSION['pseudo'], $gameResult, $_SESSION['jeu']->getShotNumber());

        $bd->store($statsG);

        VJeuFini::gameOver(); // on affiche la vue de fin de partie
        VJeuFini::displayStats($bd->getPlayerStats($_SESSION['pseudo']), $bd->getTopFiveSimple());
    }

    /**
     * Méthode qui efface une ligne du plateau
     */
    public static function eraseLine() {
        $_SESSION['jeu']->eraseLine();
        VJeu::displayGame($_SESSION['jeu']->getBoard());
    }

    /**
     * Méthode pour se déconnecter de la partie
     */
    public static function disconnect() { VJeuFini::endOfGame(); }
}