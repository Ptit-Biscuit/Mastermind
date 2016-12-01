<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

require_once __DIR__."/../vue/Erreur.php";
use vue\Erreur;

require_once __DIR__."/../modele/Plateau.php";

class Jeu {
	
    /**
     * @var Plateau Le plateau du jeu
     */
    private $board;

    /**
     * @var int Le coup actuel
     */
    private $shotNumber;

    /**
     * @var int L'indice de la prochaine case à colorer
     */
    private $idNextCase;

    /**
     * @var int le nombre maximal autorisé de coups dans la partie, moins un
     */
    private $maxShotNb;
	
	/**
	 * @var bool true si la partie est terminée, false sinon
	 */
    private $finished;
	
	/**
	 * @var bool true si la partie est gagnée, false sinon
	 */
    private $victory;
    
    /**
     * Le constructeur de Jeu
     */
    public function __construct() {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            $this->board = new Plateau();
            $this->shotNumber = 0;
            $this->idNextCase = 0;
            $this->maxShotNb = 9;
            $this->finished = false;
            $this->victory = false;
        }
    }

    /**
     * Méthode qui actualise la vue du jeu
     * @param $color String La couleur à ajouter
     * @return bool True si la rangée n'est pas pleine, false sinon
     */
    public function updateBoard($color) {
        if($this->idNextCase < 4) {
            $this->board->getTries()[$this->shotNumber]->setCase($this->idNextCase, $color);
            $this->idNextCase++;
            return true;
        }

        return false;
    }

    /**
     * Méthode qui met à jour la correspondance essai du joueur / soluce (à condition que le coup joué soit valide)
     * Un coup est valide si quatre couleurs sont données (aucun case non colorée)
     */
    public function validate() {
	    
	    $shot = $this->board->getTries()[$this->shotNumber]->getCases(); // récupère ce qui a été joué
	
	    // si la rangée soumise n'est pas pleine, elle ne peut pas être valide (pas de "mode expert" où l'on peut jouer avec des trous, cf. règles du MM)
	    // on ne prend donc en compte le coup que si la rangée soumise est valide
	    if(!in_array('darkgrey', $shot)) {
		    
		    $answer = $this->board->getSoluce()->getCases(); // récupère la rangée secrète (aka la solution)
			$match = ['', '', '', '']; // construction des vérifications
		    
		    // on commence par vérifier les pions de bonne couleur et bien placés (noir)
		    for($i = 0; $i <= 3; $i++)
		        if($shot[$i] == $answer[$i]) {
		            $answer[$i] = 'darkgrey';
		            $match[$i] = 'black';
                }
		    
		    // puis on s'intéresse aux pions de bonne couleur mais mal placés
		    for($i = 0; $i <= 3; $i++) {
		    	// si la case n'est pas correcte d'emblée
			    if($match[$i] != 'black') {
			    	// on place un marqueur 'darkgrey' (gris) par couleur non présente
				    if(!in_array($shot[$i], $answer)) $match[$i] = 'darkgrey';
				    // à ce stade peu importe les couleurs restantes, elles sont présentes mais mal placées
				    // il ne reste juste donc qu'à ajouter un marqueur 'white' (blanc)
				    else $match[$i] = 'white';
			    }
		    }
		    
		    // s'il s'avère que toutes les pastilles de vérification sont noires,
		    // alors on actualise le statut de la partie : c'est gagné !
		    for($i = 0; $i <= 3; $i++) {
		        if($match[$i] == 'black') {
		            $this->victory = true;
		            $this->finished = true;
                }
                else {
		            $this->victory = false;
		            break;
		        }
            };

		    sort($match); // on "brasse"
		    $this->board->getTries()[$this->shotNumber]->setVerif($match); // on actualise les vérifications

            $this->shotNumber++; // une tentative a été effectuée, donc on passe au coup suivant
            $this->idNextCase = 0;
            if($this->shotNumber == $this->maxShotNb) $this->finished = true; // si il ne reste plus de coups, alors le jeu est terminé
        }
    }

    /**
     * Méthode qui efface la ligne en cours
     */
    public function eraseLine() {
        $line = $this->board->getTries()[$this->shotNumber];
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
	
	/**
	 * @return int l'indice du coup actuel dans la grille
	 */
	public function getShotNumber() {
		return $this->shotNumber;
	}
	
	/**
	 * @return int le nombre maximal de coups, moins un
	 */
	public function getMaxShotNb() {
		return $this->maxShotNb;
	}
	
	/**
	 * @return boolean true si la partie est terminée, false sinon
	 */
	public function isFinished() {
		return $this->finished;
	}
	
	/**
	 * @return boolean true si victoire, false si défaite
	 */
	public function isVictory() {
		return $this->victory;
	}
	
}