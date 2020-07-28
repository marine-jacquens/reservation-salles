<?php $page_selected = "inscription"; ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=yes"/>
        <link rel="stylesheet" href="styles/css/style.css">
        <script src="https://kit.fontawesome.com/217c9d0a4d.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="fontawesome/all.css">
    </head>
    <body class="body-inscription">
        <header>
          <?php include 'header.php';
            $errors = [];
            if (isset($_POST['submit'])) {
                $login = htmlentities(trim($_POST['login']));
                $password = htmlentities(trim($_POST['password']));
                $mdpcheck = htmlentities(trim($_POST['mdp_check']));
                $password_modified =  password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

                if ($login && $password && $mdpcheck) {
                    /*LOGIN*/
                    $login_required = preg_match("/^(?=.*[A-Za-z0-9]$)[A-Za-z\d\-\_]{3,19}$/", $login);
                    if (!$login_required) {
                        $errors[] = "<span>Le login doit :<br>- Contenir entre 4 et 20 caractères.<br>- Commencer par une lettre<br>- Finir par une lettre ou nombre.<br>- Ne contenir aucun caractère spécial (sauf - et _).</span>";
                    }
                    $request = "SELECT login FROM `reservationsalles`.`utilisateurs` WHERE login = '$login';";
                    $query = mysqli_query($db, $request);
                    $login_check = mysqli_fetch_array($query);
                    if (!empty($login_check)) {
                        $errors[] = "<span>Ce login existe déjà !</span>";
                    }
                    /*PASSWORD*/
                    if ($password != $mdpcheck) {
                        $errors[] = "<span>Les mots de passe ne sont pas identiques.</span>";
                    }
                    $password_required = preg_match("/^(?=.*?[A-Z]{1,})(?=.*?[a-z]{1,})(?=.*?[0-9]{1,})(?=.*?[\W]{1,}).{8,20}$/", $password);
                    if (!$password_required) {
                        $errors[] = "<span>Le mot de passe doit :<br>- Contenir entre 8 et 20 caractères.<br>- Contenir au moins 1 caractère spécial, 1 nombre, 1 majuscule et 1 minuscule.</span>";
                    }
                    /*ENVOI BDD*/
                    if (empty($errors)) {
                        $connexion = mysqli_connect('localhost', 'root', '', 'reservationsalles');
                        $requete = "INSERT INTO `reservationsalles`.`utilisateurs` (login,password) VALUES ('$login','$password_modified')";
                        $query = mysqli_query($connexion, $requete);
                        header('location:connexion.php');
                    }
                } else {
                    $errors[] = "<br><span>Veuillez saisir tous les champs</span>";
                }
            }

            ?>

        </header>
        <main class="main-inscription">
            <div class="content">
             <?= renderErrors($errors)?>
            <form class="form-inscription" action="inscription.php" method="post">
                <h1> INSCRIPTION </h1><br/>

                <label for="login">Identifiant</label>
                <input type="text" id="login" name="login" placeholder="Créez votre pseudo" required> <br/>
                <br>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required> <br />
                <br>
                <label for="mdp-check">Confirmation mot de passe</label>
                <input type="password" id="mdp_check" name="mdp_check" placeholder="Confirmez votre mot de passe" required> <br/>
                <br>
                <div class="inscription-button" >
                    <input type="submit" value="VALIDER" name="submit">
                </div>

                <br><p>Vous avez déjà un compte ?<br><a href="connexion.php">Se connecter</a></p><br>

             </form>
            </div>
        </main>
        <footer>
          <?php include("footer.php")?>
        </footer>
    </body>
</html>
