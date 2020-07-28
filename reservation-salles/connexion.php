<?php

$page_selected = "connexion";

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/css/style.css">
    <script src="https://kit.fontawesome.com/217c9d0a4d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/all.css">
    <title>Connexion</title>
</head>
<body class="body-inscription">
<header>
    <?php
    include("header.php");
    $errors = [];

    if (isset($_POST["signin"])) {
        // Form login variables
        $login = htmlentities(trim($_POST["login"]));
        $password = htmlentities(trim($_POST["password"]));

        if ($login && $password) {
            $db = new mysqli("localhost", "root", "", "reservationsalles");

            // User Info Select Query
            $userExistCheckQry = "select `id`, `login`, `password` from `reservationsalles`.`utilisateurs` where `login`='$login'";
            $userExistCheckQryExec = $db->query($userExistCheckQry);

            $userPwdCheckQryExec = $db->query($userExistCheckQry);
            $password_bdd = $userPwdCheckQryExec->fetch_assoc();

            if (password_verify($password, $password_bdd['password'])) {
                if ($userExistCheckQryExec->num_rows == 0) {
                    $errors[] = "L'utilisateur et/ou le mot de passe est erroné";
                } elseif ($userExistCheckQryExec->num_rows == 1) {
                    $userExistFetchQryExec = $userExistCheckQryExec->fetch_assoc();
                    $_SESSION['user'] = $userExistFetchQryExec;
                    $db->close();
                }
            } else {
                $errors[] = "L'utilisateur et/ou le mot de passe est erroné";
            }
        } elseif (!$login || !$password) {
            echo "Tous les champs n'ont pas été renseignés";
        }
    }

    if (!empty($_SESSION['user'])) {
        header('Location: planning.php');
        exit();
    }

    ?>
</header>
<main class="main_connexion">
    <div class="content">
        <?= renderErrors($errors) ?>
        <form class="form-inscription" action="connexion.php" method="POST">
            <h1> CONNEXION </h1>
            <label for="login">Identifiant</label>
            <input class="no-border" id="login" name="login" type="text" placeholder="Insérez votre login" required>
            <br>
            <label for="password">Mot de Passe</label>
            <input class="no-border" id="password" name="password" type="password" placeholder="Insérez votre mot de passe" required>
            <br>
            <div class="inscription-button" >
                <input type="submit" name="signin" value="Se connecter">
            </div>
            <p>Vous n'êtes pas inscris ?<br><a href="inscription.php">Inscrivez-vous</a></p>
        </form>
    </div>
</main>
<footer>
    <?php
    include("footer.php") ?>
</footer>
</body>
</html>
