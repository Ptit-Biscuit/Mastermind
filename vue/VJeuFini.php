<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace vue;

use modele\StatistiqueP;

class VJeuFini {
    /**
     * Méthode qui affiche le résultat en fin de partie
     */
    public static function gameOver() {
	    ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <title>Fin du jeu</title>
        </head>

        <body>
	    <?php
	    if($_SESSION['jeu']->isVictory()) echo "<h2>Félicitations, vous avez gagné la partie en ".$_SESSION['jeu']->getShotNumber()." coup(s) !</h2>";
	    else echo "<h2>Dommage vous avez perdu la partie : aucun coup restant !</h2>";
	    ?>
	
	
	    <?php
	    if(!$_SESSION['jeu']->isVictory()) {
		    // solution non affichée lorsque le joueur est victorieux
		    ?>
            <h3>La solution était:</h3>
            <table style="width: 60%; border: 2px solid black;"> <!-- Plateau de la soluce -->
			    <?php
			    for($i = 0; $i < 4; $i++) {
				    echo "<td style=\"width: 15%; height: 30px; background-color: ";
				    echo $_SESSION['jeu']->getBoard()->getSoluce()->getCases()[$i] . ";\">";
				    echo "<div></div></td>";
			    }
			    ?>
            </table>
		    <?php
	    }
	    ?>

        <br>

        <table style="width: 80%; border: 2px solid black;"> <!-- Plateau du jeu -->
		    <?php
		    if($_SESSION['jeu']->getShotNumber() == $_SESSION['jeu']->getMaxShotNb()) $fin = $_SESSION['jeu']->getMaxShotNb();
		    else $fin = $_SESSION['jeu']->getShotNumber() - 1;
		    for($i = 0; $i <= $fin; $i++) {
			    echo "<tr> <!-- Une rangee du plateau -->";
			
			    for($j = 0; $j < 4; $j++) {
				    echo "<td style=\"width: 15%; height: 40px; background-color:";
				    echo $_SESSION['jeu']->getBoard()->getTries()[$i]->getCases()[$j] . ";\">"; // itération des cases
				    echo "<div></div>";
				    echo "</td> <!-- Une case de la rangee -->";
			    }
			
			    echo "<td style=\"width: 15%; border: 2px solid black;\">";
			    echo "<table style=\"width: 100%;\">";
			    echo "<tr style=\"height: 49%;\"> <!-- La case des vérif' -->";
			
			    for($k = 0; $k < 4; $k++) {
				    echo "<td style=\"height: 40px; background-color:";
				    echo $_SESSION['jeu']->getBoard()->getTries()[$i]->getVerif()[$k] . ";\">"; // itération des vérif'
				    echo "<a href='index.php'></a>";
				    echo "</td> <!-- Une vérification -->";
			    }
			
			    echo "</tr>";
			    echo "</table>";
			    echo "</tr>";
		    }
		    ?>
        </table>
        </body>
        </html>
	    <?php
    }
    
    /**
     * Méthode permettant d'afficher les différentes statistiques
     * sur le joueur, ainsi que le top 5 des meilleurs joueurs
     * @param $playerStats StatistiqueP Les statistiques sur le joueur
     * @param $topFivePlayers array Le top 5 des meilleurs joueurs
     */
    public static function displayStats($playerStats, $topFivePlayers) {
        VJeu::actionsEndGame();
    }

    /**
     * Méthode permettant de revenir à la page index.php
     * (efface la variable $_SESSION)
     */
    public static function endOfGame() {
        if(!empty($_SESSION)) unset($_SESSION);
        header("Location: index.php");
    }
}