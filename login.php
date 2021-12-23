<?php
    if(isset($_POST['login'],$_POST['mdp'])){
        foreach ($_POST as $k => $v) $$k = htmlspecialchars($v);
        $file = fopen("data/connect.csv","r");
        $identifiant = fgetcsv($file,1000,",");
        $login_a = $identifiant[0];
        $mdp_a = $identifiant[1];

        $login = md5($login);
        $mdp = md5($mdp);

        session_start();
        if ($login==$login_a & $mdp==$mdp_a){
            $_SESSION['connected'] = 'admin';
            header('Location: backend.php');
            exit(0);
        }
        else header('Location: connection.php?id=password_error');
    }else header('Location: connection.php');
?>
