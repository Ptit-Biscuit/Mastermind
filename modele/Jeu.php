<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

require_once __DIR__."/../vue/Erreur.php";
use vue\Erreur;

require_once __DIR__."/../vue/VJeu.php";
use vue\VJeu;

require_once __DIR__."/../vue/VJeuFini.php";
use vue\VJeuFini;

require_once __DIR__."/../modele/Plateau.php";

class Jeu {
    /**
     * @var Plateau Le plateau du jeu
     */
    private $board;

    /**
     * @var int Le nombre de coups restants à jouer
     */
    private $remainingShots;

    /**
     * @var int L'indice de la prochaine case à colorer
     */
    private $idNextCase;

    /**
     * Le constructeur de Jeu
     */
    public function __construct() {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            $this->board = new Plateau();
            $this->remainingShots = 10;
            $this->idNextCase = 0;
        }
    }

    /**
     * Méthode qui actualise la vue du jeu
     * @param $color String La couleur à ajouter
     * @return bool True si l'update c'est bien déroulée, false sinon
     */
    public function updateBoard($color) {
        if($this->idNextCase < 4) {
            $this->board->getTries()[10 - $this->remainingShots]->setCase($this->idNextCase, $color);
            $this->idNextCase++;

            return true;
        }
        else return false;
    }

    /**
     * Méthode qui valide une rangée du plateau en fonction de la solution
     * @return bool True si la rangée a bien été validée, false sinon
     */
    public function validate() {
        $valide = true;

        if($this->remainingShots > 1) {
            $row = $this->board->getTries()[10 - $this->remainingShots]->getCases();

            if(!in_array("darkgrey", $row)) {
                $soluce = $this->board->getSoluce()->getCases();
                $verif = array();

                for($i = 0; $i < count($soluce); $i++) {
                    // TODO gérer la validation de plusieurs fois la même couleur
                    if(in_array($row[$i], $soluce)) {
                        if($row[$i] != $soluce[$i]) $verif[$i] = "white";
                        else $verif[$i] = "black";
                    }
                    else $verif[$i] = "darkgrey";

                    $soluce[$i] = "darkgrey";
                }

                if(($verif[0] == "black") && ($verif[1] == "black")
                    && ($verif[2] == "black") && ($verif[3] == "black")) {
                    setcookie('endGame', true);
                }
                else {
                    sort($verif);
                    $this->board->getTries()[10 - $this->remainingShots]->setVerif($verif);
                    $this->idNextCase = 0;
                    $this->remainingShots--;
                }
            }
        } else $valide = false;

        return $valide;
    }

    /**
     * Méthode qui efface la ligne en cours
     */
    public function eraseLine() {
        $line = $this->board->getTries()[10 - $this->remainingShots];
        $lineCases = $line->getVerif();

        if(!in_array("black", $lineCases) or !in_array("white", $lineCases)) {
            $reset = array("darkgrey", "darkgrey", "darkgrey", "darkgrey");
            $line->setCases($reset);
            $this->idNextCase = 0;
        }
    }

    /**
     * Getter de plateau
     * @return Plateau Le plateau du jeu
     */
    public function getBoard() { return $this->board; }
}