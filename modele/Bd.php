<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace modele;

require_once __DIR__."/../modele/StatistiqueP.php";

use PDO;
use PDOException;

class Bd {
    /** @var PDO La connexion avec la base de données */
    private $connexion;

    /**
     * Le constructeur de Bd
     */
    public function __construct() {
        try {
            /*$chaine="mysql:host=localhost;dbname=E155939Z";
            $this->connexion = new PDO($chaine,"E155939Z","E155939Z");*/

            $chaine="mysql:host=localhost;dbname=sys";
            $this->connexion = new PDO($chaine,"root","");
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Méthode qui vérifie si un couple d'identifiants est valide
     * @param $id String pseudo du joueur
     * @param $password String mot de passe supposément associé
     * @return bool true si le couple (pseudo, mot de passe) est valide, false sinon
     * @throws PDOException s'il y a eu un problème vis-à-vis de la base de données
     */
    public function isPlayerRegistered($id, $password) {
        try {
            $stmt = $this->connexion->prepare("SELECT motDePasse FROM joueurs WHERE pseudo=?;");
            $stmt->bindParam(1, $id);
            $stmt->execute();

            $result = $stmt->fetch();

            if (empty($result)) return false;
            return crypt($password, $result[0]) == $result[0];
        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::isPlayerRegistered() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Méthode qui enregistre le résultat de la dernière partie jouée dans la base de données
     * @param $lastGameStats StatistiqueG Les statistiques de la derniere partie jouée
     */
    public function store($lastGameStats) {
        try {
            $stmt = $this->connexion->prepare("INSERT INTO parties(pseudo, partieGagnee, nombreCoups) VALUES(?, ?, ?);");

            $pseudo = $lastGameStats->getPseudo();
            $resultGame = $lastGameStats->getPartieGagnee();
            $shotNumber = $lastGameStats->getNombreCoups();

            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $resultGame);
            $stmt->bindParam(3, $shotNumber);
            $stmt->execute();
        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::store() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Récupère et construit les statistiques d'un joueur (sur l'ensemble de ses parties)
     * @param $pseudo String Le pseudo du joueur dont on souhaite connaître les statistiques
     * @return StatistiqueP Les statistiques de toutes les parties de ce joueur
     */
    public function getPlayerStats($pseudo) {
        try {
            $stmt = $this->connexion->prepare("SELECT p.pseudo, COUNT(*) AS nbParties, 
                (SELECT COUNT(*) FROM parties pp WHERE pp.partieGagnee = TRUE AND pp.pseudo = ?) AS nbPartiesGagnees, 
                (SELECT AVG(ppp.nombreCoups) FROM parties ppp WHERE ppp.partieGagnee = TRUE AND ppp.pseudo = ?) AS nbCoupsPourGagner 
                FROM parties p WHERE p.pseudo = ?;");
            $stmt->bindParam(1, $pseudo);
            $stmt->bindParam(2, $pseudo);
            $stmt->bindParam(3, $pseudo);
            $stmt->execute();
            $t = $stmt->fetch(PDO::FETCH_ASSOC);

            return new StatistiqueP($t['pseudo'], $t['nbParties'], $t['nbPartiesGagnees'], $t['nbCoupsPourGagner']);
        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::getPlayerStats() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Récupère et construit les statistiques concernant tous les joueurs
     * @return array L'ensemble des statistiques, tous joueurs confondus
     */
    public function getPlayersStats() {
        try {
            $result = array();
            $stmt = $this->connexion->query("SELECT p.pseudo, COUNT(*) AS nbParties, (SELECT COUNT(*) FROM parties pp WHERE pp.partieGagnee = TRUE) AS nbPartiesGagnees, (SELECT AVG(ppp.nombreCoups) FROM parties ppp WHERE ppp.partieGagnee = TRUE) AS nbCoupsPourGagner FROM parties p;");
            while ($t = $stmt->fetch()) array_push($result, new StatistiqueP($t['pseudo'], $t['nbParties'], $t['nbPartiesGagnees'], $t['nbCoupsPourGagner']));
            return $result;
        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::getPlayersStats() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Renvoie les statistiques des 5 meilleurs joueurs
     * @return array Les statistiques relatives aux 5 meilleurs joueurs
     */
    public function getTopFiveSimple() {
        $topFive = array();
        $playersStats = $this->getPlayersStats();

        ksort($playersStats);

        for($i = 0; $i < 5; $i++) $topFive[$i] = $playersStats[$i];

        print_r($playersStats);
        print_r($topFive);

        return $topFive;
    }

    /**
     * Renvoie les statistiques des 5 meilleurs joueurs
     * Sélectionne en fonction de deux critères, de même importance :
     * le taux de victoires et le nombre de coups nécessaires pour y parvenir
     * @return array Les statistiques relatives aux 5 meilleurs joueurs
     */
    public function getTopFive() {
        /*
         * à titre d'explication et de clarté, en langage naturel
         *      1) on récupère le taux de victoire moyen et le nombre de coups néessaires moyens pour gagner
         *      2) on attribue à chaque joueur un indicateur où
         *         indicateur = ((nbPartiesGagnees/nbParties) - tauxDeVictoireMoyen) + (moyNbCoupsPourGagner/10 - nbCoupsPourGagner/10)
         *      3) on sélectionne les 5 joueurs ayant le plus haut indicateur,
         *      4) on renvoie les statistiques de ces 5 joueurs, triés par ordre croissant de l'indice calculé
         *
         * situation d'exemple :
         *      le boss : 0,75 taux de victoire (75 victoires sur 100 parties), 0,1 (1 coup pour gagner)
         *      moyenne : 0,5 taux de victoire, et 0,7
         *      le noob : 0,2 taux de victoire, et 1,0 (toujours en 10 coups)
         * par le calcul énoncé ci-dessus, on obtient les indicateurs suivants :
         *      le boss : 0,85
         *      moyenne : 0
         *      le noob : -0,6
         */

        try {
            $stmt = $this->connexion->query("SELECT ((SELECT COUNT(*) FROM parties p WHERE p.partieGagnee = TRUE)/(SELECT COUNT(*) FROM parties)) AS tauxDeVictoireMoyen, (SELECT AVG(pp.nombreCoups) FROM parties pp) AS moyNbCoupsPourGagner;");
            $t = $stmt->fetch();
            $tauxDeVictoireMoyen = $t['tauxDeVictoireMoyen'];
            $moyNbCoupsPourGagner = $t['moyNbCoupsPourGagner'];

            // on construit un tableau de classement
            $classement = array();
            $players = $this->getPlayersStats();

            foreach ($players as $p) {
                $tab = array($p->getPseudo(), (($p->getNbPartiesGagnees() / $p->getNbParties()) - $tauxDeVictoireMoyen) + ($moyNbCoupsPourGagner / 10 - $p->getNbCoupsPourGagner() / 10));
                array_push($classement, $tab);
            }

            rsort($classement, SORT_NUMERIC); // que l'on trie en fonction des indicateurs

            // puis on récupère les stats complètes des 5 meilleurs, que l'on retourne
            $top = array();

            for ($i = 0; $i <= 4; $i++) {
                array_push($top, $this->getPlayerStats($classement[$i][0]));
            }

            return $top;
        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::getTopFive() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Méthode qui permet de fermer la connexion à la base de données
     */
    public function disconnect() {
        $this->connexion = null;
    }
}