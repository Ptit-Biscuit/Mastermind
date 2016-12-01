<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace controleur;

require_once __DIR__."/../vue/Login.php";
use vue\Login;

require_once __DIR__."/../vue/Erreur.php";
use vue\Erreur;

require_once __DIR__."/../modele/Bd.php";
use modele\Bd;

require_once __DIR__."/../controleur/CJeu.php";

class Routeur {
    /**
     * @var Bd La base de données utilisée
     */
    private $bd;

    /**
     * Le constructeur de Routeur
     */
    public function __construct() {
        if(empty($_SESSION)) session_start();
        $this->bd = new Bd();
        $this->routeRequest();
    }

    /**
     * Méthode routant toutes les requêtes entrantes de la page index.php
     */
    public function routeRequest() {
        if(!isset($_SESSION['userLogged'])) { // si pas enregistré
            if(isset($_POST['pseudo']) && isset($_POST['password'])) // si le pseudo et mdp dispo
                $this->authentification($_POST['pseudo'], $_POST['password']); // authentification
            else Login::displayLogin(); // sinon afficher page de log
        }
        else {
            if(isset($_POST['validate'])) $_SESSION['jeu']->validate(); // si on veut valider notre coup
            else if(isset($_POST['erase'])) $_SESSION['jeu']->eraseLine(); // si on veut effacer notre ligne
            else if(isset($_POST['retry'])) CJeu::startGame(); // si on veut recommencer le jeu
            else if(isset($_POST['quit'])) CJeu::quitGame(); // si on veut quitter le jeu
            else CJeu::contGame(); // sinon on continue le jeu
        }
    }

    /**
     * Méthode qui authentifie un utilisateur par son pseudo et son mot de passe
     * On utilise la base de données pour l'authentifier
     * @param $pseudo String Le pseudo du joueur
     * @param $password String Le mot de passe du joueur
     */
    public function authentification($pseudo, $password) {
        if($this->bd->isPlayerRegistered($pseudo, $password)) {
            $_SESSION['userLogged'] = true;
            $_SESSION['pseudo'] = $pseudo;

            CJeu::startGame();
        }
        else Erreur::displayAuthFail();
    }
}