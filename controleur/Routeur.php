<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 19:50
 */

namespace controleur;

//if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();

require_once __DIR__."/../vue/Login.php";
use modele\Jeu;
use vue\Erreur;
use vue\Login;

require_once __DIR__."/../vue/Erreur.php";

require_once __DIR__."/../modele/Jeu.php";

class Routeur {
    /**
     * Routeur constructor.
     */
    public function __construct()
    {
        $this->routeRequest();
    }

    public function routeRequest() {
        if(isset($_POST['pseudo']) && isset($_POST['password'])) {
            $pseudo = $_POST['pseudo'];
            $password = $_POST['password'];

            $this->authentification($pseudo, $password);
        }
        else Login::displayLogin();
    }

    public function authentification($pseudo, $password) {
        if(($pseudo == "a") && ($password == "a")) {
            $userLogged = true;
            session_start($userLogged);

            $this->startGame();
        }
        else Erreur::displayAuthFail();
    }

    public function startGame() {
        $jeu = new Jeu();
    }
}