<?php
/**
 * @author Rémi Taunay
 * @author Vincent Brebion
 */

namespace vue;

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
                if($_SESSION['jeu']->getIsWin()) echo "<h2>Bravo vous avez gagné la partie</h2>";
                else echo "<h2>Dommage vous avez perdu la partie</h2>";
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

                <br>

                <table style="width: 80%; border: 2px solid black;"> <!-- Plateau du jeu -->
                    <?php
                    for($i = 0; $i < $_SESSION['jeu']->getRemainingShots(); $i++) {
                        echo "<tr> <!-- Une rangee du plateau -->";

                        for($j = 0; $j < 4; $j++) {
                            echo "<td style=\"width: 15%; height: 40px; background-color:";
                            echo $_SESSION['jeu']->getBoard()->getTries()[$i]->getCases()[$j].";\">"; // itération des cases
                            echo "<div></div>";
                            echo "</td> <!-- Une case de la rangee -->";
                        }

                        echo "<td style=\"width: 15%; border: 2px solid black;\">";
                        echo "<table style=\"width: 100%;\">";
                        echo "<tr style=\"height: 49%;\"> <!-- La case des vérif' -->";

                        for($k = 0; $k < 4; $k++) {
                            echo "<td style=\"height: 40px; background-color:";
                            echo $_SESSION['jeu']->getBoard()->getTries()[$i]->getVerif()[$k].";\">"; // itération des vérif'
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

        if(!empty($_COOKIE)) unset($_COOKIE);

        VJeu::actionsEndGame();
    }

    public static function endOfGame() {
        if(!empty($_SESSION)) {
            session_reset();
            session_destroy();
        }
        header("Location: index.php");
    }
}