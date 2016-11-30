<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 19:50
 */

namespace controleur;

require_once __DIR__."/../vue/Login.php";
use vue\Login;

require_once __DIR__."/../vue/Erreur.php";
use vue\Erreur;

require_once __DIR__."/../modele/Bd.php";
use modele\Bd;

require_once __DIR__."/../modele/Jeu.php";
use modele\Jeu;
use vue\VJeu;

class Routeur {
    /**
     * @var Bd La base de données utilisée
     */
    private $bd;

    /**
     * Routeur constructor.
     */
    public function __construct()
    {
        session_start();
        $this->bd = new Bd();
        $this->routeRequest();
    }

    public function routeRequest() {
        if(!isset($_SESSION['userLogged'])) { // si on n'est pas enregistré
            if(isset($_POST['pseudo']) && isset($_POST['password'])) // si on a le pseudo et mdp
                $this->authentification($_POST['pseudo'], $_POST['password']); // authentification
            else if(isset($_POST['retry'])) $this->startGame();
            else Login::displayLogin(); // sinon afficher page de log
        }
        else $this->contGame(); // sinon on continue le jeu
    }

    public function authentification($pseudo, $password) {
        if($this->bd->isPlayerRegistered($pseudo, $password)) {
            $_SESSION['userLogged'] = true;
            $_SESSION['pseudo'] = $pseudo;

            $this->startGame();
        }
        else Erreur::displayAuthFail();
    }

    public function startGame() { $_SESSION['jeu'] = new Jeu(); }

    public function contGame() {
        if(isset($_SESSION['jeu']) && isset($_GET['color'])) {
            $colors = array("white", "yellow", "orange", "red", "fuchsia", "purple", "green", "blue");
            if(in_array($_GET['color'], $colors)) $_SESSION['jeu']->updateBoard($_GET['color']);
            else VJeu::displayGame($_SESSION['jeu']->getBoard());
        }
    }
}