<?php
/**
 * Created by PhpStorm.
 * User: E155939Z
 * Date: 30/11/16
 * Time: 09:56
 */

namespace modele;

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
     * @param $lastGameStats Statistique Les statistiques de la derniere partie joué
     */
    public function store($lastGameStats)
    {
        try {
            $stmt = $this->connexion->prepare("INSERT INTO parties(pseudo, partieGagnee, nombreCoups) VALUES(?, ?, ?);");
            $stmt->bindParam(1, $lastGameStats->getPseudo());
            $stmt->bindParam(2, $lastGameStats->getPartieGagnee());
            $stmt->bindParam(3, $lastGameStats->getNombreCoups());
            $stmt->execute();

        } catch (PDOException $e) {
            $this->disconnect();
            throw new PDOException("BD::store() : problème vis-à-vis de la base de données");
        }
    }

    /**
     * Méthode qui permet de fermer la connexion à la base de données
     */
    public function disconnect() {
        if(!empty($_SESSION)) session_destroy();
        $this->connexion = null;
    }
}