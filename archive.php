<?php
    if(isset($_POST["archive"])){
        if(!(filesize("data/admin.csv") == 0)){
            $date = date("Y_m_d-H_i_s");
            rename("data/admin.csv","data/archives/".$date.".csv");
            file_put_contents("data/admin.csv","");
    
            unlink("data/history_user.csv");
            file_put_contents("data/history_user.csv","");
        }
        header("Location:backend.php");
    }else if (isset($_POST["suppression"])){
        unlink("data/admin.csv");
        file_put_contents("data/admin.csv","");

        unlink("data/history_user.csv");
        file_put_contents("data/history_user.csv","");

        header("Location:backend.php");
    }if(isset($_POST["sup_arch"])){
        $files = scandir("data/archives");
        
        $files = array_reverse($files);
        $file = $files[$_GET["id"]];

        unlink("data/archives/".$file);
        header("Location:backend.php");
    }else{
        header("Location:backend.php");
    }
    #efef   
?>