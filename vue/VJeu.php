<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 21:34
 */

namespace vue;

require_once __DIR__."/../vue/Erreur.php";

require_once __DIR__."/../modele/Plateau.php";
use modele\Plateau;

class VJeu {
    /**
     * Méthode qui affiche le plateau passé en paramètre
     * @param $plateau Plateau Le plateau à afficher
     */
    public static function displayGame($plateau) {
        if(!isset($_SESSION['userLogged'])) Erreur::displayUnauth();
        else {
            ?>
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <title>Mastermind de Vincent</title>

                    <script type="text/javascript"></script>
                </head>

                <body>
                    <h2>Bienvenue <?php if(isset($_SESSION['pseudo'])) echo $_SESSION['pseudo']; ?></h2>

                    <table style="width: 80%; border: 2px solid black;"> <!-- Plateau du jeu -->
                        <?php
                        for($i = 0; $i < 10; $i++) {
                            echo "<tr> <!-- Une rangee du plateau -->";

                            for($j = 0; $j < 4; $j++) {
                                echo "<td style=\"width: 15%; height: 40px; background-color:";
                                echo $plateau->getTries()[$i]->getCases()[$j].";\">"; // itération des cases
                                echo "<div id=\"div".$i.$j."\"></div>";
                                echo "</td> <!-- Une case de la rangee -->";
                            }

                            echo "<td style=\"width: 15%; border: 2px solid black;\">";
                            echo "<table style=\"width: 100%;\">";
                            echo "<tr style=\"height: 49%;\"> <!-- La case des vérif' -->";

                            for($k = 0; $k < 4; $k++) {
                                echo "<td style=\"height: 40px; background-color:";
                                echo $plateau->getTries()[$i]->getVerif()[$k].";\">"; // itération des vérif'
                                echo "<a href='index.php'></a>";
                                echo "</td> <!-- Une vérification -->";
                            }

                            echo "</tr>";
                            echo "</table>";
                            echo "</tr>";
                        }
                        ?>
                    </table>

                    <br>

                    <table style="width: 70%; border: 2px solid black;"> <!-- Plateau des couleurs possibles -->
                        <tr>
                            <?php
                                $colors = array("white", "yellow", "orange", "red", "fuchsia", "purple", "green", "blue");

                                foreach($colors as $color) {
                                    echo "<td style=\"width: 10%; height: 30px; background-color:".$color."\">";
                                    echo "<a style=\"display: block; width: 100%; height: 100%;\" href=\"index.php?color=".$color."\"></a>";
                                    echo "</td>";
                                }
                            ?>
                        </tr>
                    </table>

                    <br>

                    <?php
                        self::actions();
                    ?>
                </body>
            </html>
            <?php
        }
    }

    public static function actions() {
        echo "<form action=\"index.php\" method=\"post\">";
        echo "<input type=\"submit\" name=\"validate\" value=\"Valider\">";
        echo "<input type=\"submit\" name=\"retry\" value=\"Recommencer\">";
        echo "<input type=\"submit\" name=\"quit\" value=\"Quitter\">";
        echo "</form>";
    }

    /**
     * Méthode qui affiche un message à l'utilisateur suite à une manipulation
     * incorrecte lors de la partie (utilise du javascript)
     */
    public static function displayMustValidate() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <script type="text/javascript">
                function warning() { alert("Vous devez absolument valider avant de continuer"); }
            </script>

            <body onload="warning()"></body>
        </html>
        <?php
    }
}