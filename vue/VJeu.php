<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 21:34
 */

namespace vue;

require_once __DIR__."/../vue/Erreur.php";

class VJeu {
    /**
     * VJeu constructor.
     */
    public function __construct() {
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
                    <h3>Tableau de jeu</h3>

                    <table style="width: 80%; border: 2px solid black;"> <!-- Plateau du jeu -->
                        <?php
                        for ($i = 0; $i < 10; $i++) {
                            echo "<tr> <!-- Une rangee du plateau -->";

                            for ($j = 0; $j < 4; $j++) {
                                echo "<td style=\"width: 15%; height: 40px; background-color: darkgrey;\">";
                                echo "<div id=\"div".$i.$j."\"></div>";
                                echo "</td> <!-- Une case de la rangee -->";
                            }

                            echo "<td style=\"width: 15%; border: 2px solid black;\">";
                            echo "<table style=\"width: 100%;\">";
                            echo "<tr style=\"height: 49%;\"> <!-- La case des vérif' -->";

                            for ($k = 0; $k < 4; $k++) {
                                echo "<td style=\"height: 40px; background-color: darkgrey;\">";
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

                    <form action="index.php" method="post">
                        <table style="width: 70%; border: 2px solid black;"> <!-- Plateau des couleurs possibles -->
                            <tr>
                                <?php
                                    $colors = array("blue", "fuchsia", "green", "purple", "orange", "red", "yellow");

                                    foreach($colors as $color) {
                                        echo "<td style = \"width: 10%; height: 30px; background-color: ".$color."\">";
                                        echo "<a href='index.php'></a>";
                                        echo "</td>";
                                    }
                                ?>
                            </tr>
                        </table>

                        <input type="submit" value="Valider le coup">
                    </form>
                </body>
            </html>
            <?php
        }
    }
}