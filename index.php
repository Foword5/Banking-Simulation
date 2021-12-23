<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Projet Web -  Groupe 2</title>
        <link href="style/all.css" rel="stylesheet"/>
        <link href="style/index.css" rel="stylesheet"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <div id="title">Simulateur de prêt banquaire</div>
        <main>
            <div  id="simulation">
                <div id="res">
                    <?php
                        if(isset($_GET["result"])){//Lors que le calcul est fait par "simulation.php", le résultat est dans le "?result="
                            echo "Il faudrait rendre <div id='price'>".  $_GET["result"]. "€</div> par mois."; 
                        }else if(isset($_GET["id"])){
                            if($_GET["id"] == "nodata"){//si on était sur la page simuler.php sans avoir entré de donnée
                                echo "<div class='error'>Veuillez entrer toutes les données</div>";
                            }else if($_GET["id"] == "wrongdata"){//si on était sur la page simuler.php sans avoir entré de donnée
                                echo "<div class='error'>Les données entrées sont mauvaises, veuillez réessayer</div>";
                            }
                        }
                    ?>
                </div>
                <form action="simulation.php" method="POST" >
                    <table id="sim_table"> <!-- Tableau des éléments du formulaire -->
                        <tr>
                            <td>Capital emprunté (en €) : </td> <!-- C -->
                            <td><input type="number" name="c" id="field_c" step=1 min=0 class="input"></td>
                        </tr>
                        <tr><!-- La jauge pour le C -->
                            <td colspan="2"><input type="range" id="range_c" step=500 min=500 max=100000 class="jauge"></td>
                        </tr>
                        <tr>
                            <td>Nombre de mois souhaité : </td> <!-- n -->
                            <td><input type="number" name="n" id="field_n" step=1 min=1 class="input"></td>
                        </tr>
                        <tr><!-- La jauge pour le n -->
                            <td colspan="2"><input type="range" id="range_n" step=1 min=1 max=360 class="jauge"></td>
                        </tr>
                        <tr>
                            <td>Taux de l'emprunt (en %) : </td> <!-- t -->
                            <td><input type="number" name="t" id="field_t" step=0.001 min=0 class="input"></td>
                        </tr>
                        <tr><!-- La jauge pour le t -->
                            <td colspan="2"><input type="range" id="range_t" step=0.001 min=0 max=5 class="jauge""></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id="simuler_td"><input type="submit" name="ok" value="Simuler" id="simuler"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="historique">Historique</div>
            <table id="user_hist">
                <tr class="row1">
                    <th>Capital</th>
                    <th>Mois</th>
                    <th>Taux</th>
                    <th>Résultat</th>
                </tr>
                <?php
                $f = fopen("data/history_user.csv", "a+");
                $i=0;
                while (($row = fgetcsv($f,1000,",")) && $i<10) {
                    echo "<tr class='row".($i%2)."'>";
                    foreach ($row as $cell) {
                        if(strlen($cell) >= 10){
                            if(substr($cell,strlen($cell)-4,1)=="E"){
                                $cell1=substr($cell,0,3);
                                $cell2=substr($cell,strlen($cell)-4,4);
                                $cell=$cell1.$cell2;
                            }else{
                                $cell=substr($cell,0,7);
                                $cell.="...";
                            }
                        }
                        echo "<td>" . $cell . "</td>";
                    }
                    echo "</tr>";
                    $i++;
                }
                for(;$i<10;$i++){
                    echo "<tr class='row".($i%2)."'><td colspan='4'></td></tr>";
                }
                fclose($f);
                ?>
            </table>
            <table id="bottom">
                <tr>
                    <td>
                        <a href="readme.html">
                            <input type="submit" value="Read me">
                        </a>
                    </td>
                    <td id="right_bottom">
                        <a href="connection.php">
                            <input type="submit" value="BackEnd" id="backend">
                        </a>
                    </td>
                </tr>
            </table>

            <script>//Permet de synchroniser les jauges et les input number
                var range_c = document.getElementById('range_c');
                var field_c = document.getElementById('field_c');
                range_c.addEventListener('input', function (e) {field_c.value = e.target.value;});
                field_c.addEventListener('input', function (e) {range_c.value = e.target.value;});
                
                var range_n = document.getElementById('range_n');
                var field_n = document.getElementById('field_n');
                range_n.addEventListener('input', function (e) {field_n.value = e.target.value;});
                field_n.addEventListener('input', function (e) {range_n.value = e.target.value;});
                
                var range_t = document.getElementById('range_t');
                var field_t = document.getElementById('field_t');
                range_t.addEventListener('input', function (e) {field_t.value = e.target.value;});
                field_t.addEventListener('input', function (e) {range_t.value = e.target.value;});
            </script>
        </main>
    </body>
</html>