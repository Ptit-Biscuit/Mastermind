<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

class StatistiqueP {

	private $pseudo;
	private $nbParties;
	private $nbPartiesGagnees;
	private $nbCoupsPourGagner;

	/**
	 * StatistiqueP constructor.
	 * @param $pseudo String le pseudo du joueur
	 * @param $nbParties int nombre de parties jouées, au total
	 * @param $nbPartiesGagnees int nombre de parties gagnées, au total
	 * @param $nbCoupsPourGagner double nombre moyens de coups nécessaires pour gagner
	 */
	public function __construct($pseudo, $nbParties, $nbPartiesGagnees, $nbCoupsPourGagner) {
		$this->pseudo = $pseudo;
		$this->nbParties = $nbParties;
		$this->nbPartiesGagnees = $nbPartiesGagnees;
		$this->nbCoupsPourGagner = $nbCoupsPourGagner;
	}

	/**
	 * @return int
	 */
	public function getNbParties() {
		return $this->nbParties;
	}

	/**
	 * @return int
	 */
	public function getNbPartiesGagnees() {
		return $this->nbPartiesGagnees;
	}

	/**
	 * @return int
	 */
	public function getNbCoupsPourGagner() {
		return $this->nbCoupsPourGagner;
	}

	/**
	 * @return String
	 */
	public function getPseudo() {
		return $this->pseudo;
	}
}