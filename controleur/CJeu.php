<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace controleur;

require_once __DIR__."/../vue/VJeu.php";
use PDOException;
use vue\VJeu;

require_once __DIR__."/../modele/StatistiqueG.php";
use modele\StatistiqueG;

require_once __DIR__."/../vue/VJeuFini.php";
use vue\VJeuFini;

require_once __DIR__."/../modele/Jeu.php";
use modele\Jeu;

require_once __DIR__."/../modele/Bd.php";
use modele\Bd;

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
        //if(!$_SESSION['jeu']->isFinished()) { // on continue le jeu
	        $_SESSION['jeu']->validate();
	        if(!$_SESSION['jeu']->isFinished()) VJeu::displayGame($_SESSION['jeu']->getBoard());
	        else { // la partie est terminée !
		        self::genStats();
		        VJeuFini::gameOver();
	        }
        //} else { // la partie est terminée !
        //	self::genStats();
        //    VJeuFini::gameOver();
        //}
    }
	
	/**
	 * Génère les statistiques en fin de partie
	 */
	public static function genStats() {
		$bd = new Bd();
		$gameResult = (int)$_SESSION['jeu']->isVictory();
		$statsG = new StatistiqueG($_SESSION['pseudo'], $gameResult, $_SESSION['jeu']->getShotNumber());

		try {
			$bd->store($statsG);
		} catch(PDOException $e) {}
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
    public static function quitGame() { VJeuFini::gameOver(); }

    /**
     * Méthode pour se déconnecter de la partie
     */
    public static function disconnect() { VJeuFini::endOfGame(); }
}