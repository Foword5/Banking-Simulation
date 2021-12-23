<?php
    session_start();
    if (isset($_POST['disconnection'])){
        session_destroy();
        unset($_SESSION['connected']);
        $_SESSION['connected']= NULL;
        header('Location: index.php?id=logout');
    }
    else {
        header('Location: index.php');
    }
?>

