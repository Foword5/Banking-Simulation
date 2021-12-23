<?php
    if(!(isset($_POST['ok']))){
        header("Location:index.php"); //Si l'utilisateur est arrivé ici par erreur
    }else if(is_numeric($_POST["c"]) && is_numeric($_POST["t"]) && is_numeric($_POST["n"])){
        foreach($_POST as $k => $v) $$k = htmlspecialchars($v);
        $result = 0;

        if($n >0 && $t>0 && $c >= 0){
            $t=$t/100;
            $result = ($c*($t/12)) / (1-pow((1+($t/12)),-$n));
            $result=round($result);
        }else if($n >0 && $t==0 && $c >= 0){
            $result = $c/$n;
        }else{
            header("Location:index.php?id=wrongdata"); //les données sont invalide (0 mois)
            return;
        }

	$result=floor($result);

        function write_csv($file_name,$text){
            $content="";
            foreach($text as $element)$content .= $element.",";
            $content = substr($content,0,-1);

            $content .= "\n".file_get_contents($file_name);
            file_put_contents($file_name,$content);
        }

        $elements = array($c,$n,$t*100,$result); //on écrit dans le fichier csv sous la forme : C,n,t,M
        write_csv("data/history_user.csv",$elements);

        $ip = $_SERVER['REMOTE_ADDR']; //recuperer l'ip d'utilisateur
        $date = date("j F Y g:i a"); //reprendre la date actuelle

        $elements_admin = array($date, $ip, $c, $n, $t*100, $result);
        write_csv("data/admin.csv",$elements_admin);

        header("Location:index.php?result=".$result); //on renvoie le résultat
        return;
    }else{
        header("Location:index.php?id=nodata"); //Il manque des données
        return;
    }
?>
