<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Back End</title>
        <link href="style/all.css" rel="stylesheet"/>
        <link href="style/backend.css" rel="stylesheet"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <?php
            session_start();
            if(!(isset($_SESSION['connected']))){
                header('Location: index.php');
                exit(0);
            }
        ?>
        <div id="back_title">Back End</div>
        <main>
            <div id="admin_hist">Historique</div>
            <table id="admin_hist_table">
                <tr class="row1">
                    <th>Date</th>
                    <th>Adresse ip</th>
                    <th>Capital</th>
                    <th>Mois</th>
                    <th>Taux</th>
                    <th>Résultat</th>
                </tr>
                <?php
                $f = fopen("data/admin.csv", "a+");
                $i=0;
                while (($row = fgetcsv($f,1000,","))) {
                    echo "<tr class='row".($i%2)."'>";
                    $j=0;
                    foreach ($row as $cell) {
                        if($j!=0 and $j!=1){
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
                        }
                        echo "<td>" . $cell . "</td>";
                        $j++;
                    }
                    echo "</tr>";
                    $i++;
                }
                fclose($f);
                ?>
            </table>
            <table id="options">
                <tr>
                    <td class="options_left">
                        <form method="post" action="archive.php">
                            <input type="submit" name="archive" value="Archiver">
                        </form>
                    </td>
                    <td class="options_right">
                        <form action='index.php'>
                            <input type='submit' value="Retour à l'index">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="options_left">
                        <form method="post" action="archive.php">
                            <input type="submit" name="suppression" value="Supprimer">
                        </form>
                    </td>
                    <td  class="options_right">
                        <form action='logout.php' method='post'>
                            <input type='submit' name='disconnection' value='Déconnexion'>
                        </form>
                    </td>
                </tr>
            </table>
            <div id="archives">
                <div id="arch_title">Archives</div>
                <table class="archives">
                    <?php
                        $archives = scandir("data/archives");
                        unset($archives[0]);
                        unset($archives[1]);
                        $i=0;
                        $archives = array_reverse($archives);//on inverse pour afficher les dernieres archive en premier
                        foreach($archives as $file){
                            $file = substr($file,0,strlen($file)-4);
                            echo "<tr class='row".($i%2)."'>";
                            echo "<td class='name'>".$file."</td>";
                            echo "<td>
                                    <form action='archive.php?id=".$i."' method='POST'>
                                        <input type='submit' name='sup_arch' value='❌' title='Supprimer'>
                                    </form>
                                </td>";
                            echo "<td>
                                    <a href='data/archives/".$file.".csv'>
                                        <input type=submit value='💾'  title='Télécharger'>
                                    </a>
                                </td>";
                            if(isset($_GET['vis']) && $_GET['vis'] == $i){
                                echo "<td>
                                    <a href='backend.php'>
                                        <button type='submit'  title='Fermer'>
                                            <img class='crossed_eye' src='style/crossed_eye.png'>
                                        </button>
                                    </a>
                                </td>
                                </tr>";
                                $files = scandir("data/archives");
                                
                                $files = array_reverse($files);
                                $file = $files[$_GET["vis"]];
    
                                echo "</table>
                                    <table class='visu_table'>
                                        <tr class='row1'>
                                            <th>Date</th>
                                            <th>Adresse ip</th>
                                            <th>Capital</th>
                                            <th>Mois</th>
                                            <th>Taux</th>
                                            <th>Résultat</th>
                                        </tr>";
                                $j=0;
                                $f = fopen("data/archives/".$file, "a+");
                                while (($row = fgetcsv($f,1000,","))) {
                                    echo "<tr class='row".($j%2)."'>";
                                    $j=0;
                                    foreach ($row as $cell) {
                                        if($j!=0 and $j!=1){
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
                                        }
                                        echo "<td>" . $cell . "</td>";
                                        $j++;
                                    }
                                    echo "</tr>";
                                    $j++;
                                }
                                echo "</table>";
                                echo "<table class='archives'>";
                                fclose($f);
                            }else{
                                echo "<td>
                                    <form action='backend.php' method='GET'>
                                        <input type='hidden' value='".$i."' name='vis'>
                                        <input type='submit' value='👁️'  title='Visualiser'>
                                    </form>
                                </td>
                                </tr>";
                            }
                            $i++;
                        }
                    ?>
                </table>
            </div>
        </main>
    </body>
</html>