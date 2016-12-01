<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

class StatistiqueG {

    private $pseudo;
    private $partieGagnee;
    private $nombreCoups;

    /**
     * Le constructeur de StatistiqueG (stats des parties)
     * @param $pseudo String le pseudo du joueur
     * @param $partieGagnee int 1 si la partie a été gagnée, 0 sinon
     * @param $nombreCoups int nombre de coups joués lors de cette partie
     */
    public function __construct($pseudo, $partieGagnee, $nombreCoups) {
        $this->pseudo = $pseudo;
        $this->partieGagnee = $partieGagnee;
        $this->nombreCoups = $nombreCoups;
    }

    /**
     * @return String
     */
    public function getPseudo() { return $this->pseudo; }

    /**
     * @return boolean
     */
    public function getPartieGagnee() { return $this->partieGagnee; }

    /**
     * @return int
     */
    public function getNombreCoups() { return $this->nombreCoups; }
}