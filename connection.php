<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <link href="style/all.css" rel="stylesheet"/>
        <link href="style/connection.css" rel="stylesheet"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <div id="connect_title">Connexion</div>
        <main>
            <?php
                session_start();
                if(isset($_SESSION['connected'])){
                    header('Location: backend.php');
                }
                if (isset($_GET['id'])){
                    $id=$_GET['id'];
                    if ($id=='password_error'){
                        echo "<p class='error'> Erreur des identifiants </p>";
                    }else {
                        echo "<p class='error> Erreur Inconnue </p>";
                    }
                }

            ?>

            <a href="index.php">    
                <input type='submit' value='retour'>
            </a>
            <form action='login.php' method='post'>
                <table id="login">
                    <tr>
                        <td>Identifiant :</td>
                        <td><input type='text' name='login'></td>
                    </tr>
                    <tr>
                        <td>Mot de passe :</td>
                        <td><input type='password' name='mdp'></td>
                    </tr>
                    <tr id="submit_login">
                        <td colspan=2>
                            <input type='submit' name='ok' value='valider' id="submit_login_button">
                        </td>
                    </tr>
                </table>
            </form>
        </main>
    </body>
</html>
