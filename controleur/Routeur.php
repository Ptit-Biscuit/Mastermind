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

require_once __DIR__."/../modele/Jeu.php";
use modele\Jeu;

class Routeur {
    /**
     * Routeur constructor.
     */
    public function __construct()
    {
        //if(!isset($_SESSION['userLogged'])) Login::displayLogin();
        session_start();
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
            $_SESSION['userLogged'] = true;

            $this->startGame();
        }
        else Erreur::displayAuthFail();
    }

    public function startGame() {
        $jeu = new Jeu();
    }
}