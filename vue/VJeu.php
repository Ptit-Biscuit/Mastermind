<?php
/**
 * Created by PhpStorm.
 * User: Ptit-Biscuit
 * Date: 29/11/2016
 * Time: 21:34
 */

namespace vue;

class VJeu {
    /**
     * VJeu constructor.
     */
    public function __construct() {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Mastermind de Vincent</title>
            </head>

            <body>
                <h3>Tableau de jeu</h3>

                <table style="width: 80%; border: 2px solid black;"> <!-- Plateau du jeu -->
                    <?php
                    for($i = 0; $i < 10; $i++) {
                        echo "<tr> <!-- Une rangee du plateau -->";

                        for($j = 0; $j < 4; $j++) {
                            echo "<td style=\"width: 15%; height: 35px;\">";
                            echo "<div></div>";
                            echo "</td> <!-- Une case de la rangee -->";
                        }

                        echo "<td style=\"width: 15%; border: 2px solid black;\"> <!-- La case des vérif' -->";
                        echo "<table style=\"width: 100%;\">";
                        echo "<tr style=\"height: 49%;\">";

                        for($k = 0; $k < 4; $k++) {
                            echo "<td style=\"height: 35px;\">";
                            echo "<div></div>";
                            echo "</td> <!-- Une vérification -->";
                        }

                        echo "</tr>";
                        echo "</table>";
                        echo "</tr>";
                    }
                    ?>
                </table>

                <br>

                <table style="width: 64%; border: 2px solid black;"> <!-- Plateau des couleurs possibles -->
                    <tr>
                        <td style="width: 12%; height: 25px; background-color: yellow"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: orange"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: red"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: fuchsia"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: purple"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: blue"><div></div></td>
                        <td style="width: 12%; height: 25px; background-color: green"><div></div></td>
                    </tr>
                </table>
            </body>
        </html>
        <?php
    }
}