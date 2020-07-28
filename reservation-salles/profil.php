<?php $page_selected = "profil"; ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Profil - Réservation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
<!--    <link rel="stylesheet" href="styles/css/main.css">-->
    <link rel="stylesheet" type="text/css" href="styles/css/style.css">
    <script src="https://kit.fontawesome.com/217c9d0a4d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/all.css">
</head>
<body body-profil>
<header>
    <?php
    include 'header.php';
    $errors = [];

    /* INFO UTILISATEUR */

    $login = $_SESSION['user']['login'];
    $request = "SELECT * FROM `reservationsalles`.`utilisateurs` WHERE login = '$login';";
    $query = mysqli_query($db, $request);
    $user_info = mysqli_fetch_array($query);

    /*LOGIN*/

    if (!empty($_POST['new_login']) and !empty($_POST['new_login_conf']) and isset($_POST['password_button'])) {
        $new_login = htmlentities(trim($_POST['new_login']));
        $new_login_conf = htmlentitites(trim($_POST['new_login_conf']));
        $login_required = preg_match("/^(?=.*[A-Za-z0-9]$)[A-Za-z\d\-\_]{3,19}$/", $_POST['new_login']);
        if (!$login_required) {
            $errors[] = "Le login doit :<br>- Contenir entre 4 et 20 caractères.<br>- Commencer par une lettre<br>- Finir par une lettre ou nombre.<br>- Ne contenir aucun caractère spécial (sauf - et _).";
        }
        $request = "SELECT login FROM `reservationsalles`.`utilisateurs` WHERE login = '" . $new_login . "';";
        $query = mysqli_query($db, $request);
        $login_check = mysqli_fetch_array($query);
        if (!empty($login_check)) {
            $errors[] = "Ce login existe déjà !";
        }
        if ($new_login != $new_login_conf) {
            $errors[] = "Les logins doivent être identiques.";
        }
        if ($new_login = $login) {
            $errors[] = "Le login n'a pas été modifié !";
        }
        if (empty($errors)) {
            $request_new_login = "UPDATE `reservationsalles`.`utilisateurs` SET login = '" . $new_login . "';";
            mysqli_query($db, $request_new_login);
            echo "Le login a bien été modifié !";
        }
    } elseif (isset($_POST['login_button']) and (empty($_POST['new_login']) or empty($_POST['new_login_conf']))) {
        $errors[] = "Les deux champs de login doivent être remplis";
    }

    /*MOT DE PASSE*/

    if (!empty($_POST['old_pass']) and !empty($_POST['new_pass']) and !empty($_POST['new_pass_conf']) and isset($_POST['password_button'])) {
        $old_pass = htmlentities(trim($_POST['old_pass']));
        $new_pass = htmlentities(trim($_POST['new_pass']));
        $new_pass_conf = htmlentities(trim($_POST['new_pass_conf']));
        if (!password_verify($old_pass, $user_info['password'])) {
            $errors[] = "Votre ancien mot de passe est incorrect.";
        } elseif (password_verify($new_pass, $user_info['password'])) {
            $errors[] = "Votre nouveau mot de passe doit être différent de l'ancien.";
        }
        if ($new_pass != $new_pass_conf) {
            $errors[] = "Les mots de passe ne sont pas identiques.";
        }
        $password_required = preg_match("/^(?=.*?[A-Z]{1,})(?=.*?[a-z]{1,})(?=.*?[0-9]{1,})(?=.*?[\W]{1,}).{8,20}$/", $_POST['new_pass']);
        if (!$password_required) {
            $errors[] = "Le mot de passe doit :<br>- Contenir entre 8 et 20 caractères.<br>- Contenir au moins 1 caractère spécial, 1 nombre, 1 majuscule et 1 minuscule.";
        }
        if (empty($errors)) {
            $password_modified = password_hash($newpass, PASSWORD_BCRYPT, array('cost' => 10));
            $request_new_pass = "UPDATE `reservationsalles`.`utilisateurs` SET password = '" . $password_modified . "' WHERE login = '" . $_SESSION['id'] . "';";
            $query = mysqli_query($db, $request_new_pass);
            echo "Le mot de passe a bien été modifié !";
        }
    } elseif (isset($_POST['password_button']) and (empty($_POST['old_pass']) or empty($_POST['new_pass']) or empty($_POST['new_pass_conf']))) {
        $errors[] = "Tous les champs du mot de passe doivent être remplis.";
    }

    ?>
</header>
<main class="main-profil">
    <div class="content contour-profil">
        <?= renderErrors($errors) ?>
        <p>Bonjour <?= $login ?></p>
        <form class="form-profil" action="profil.php" method="post">
            <h2>Modifier pseudo</h2><br>
            <div class="form_element">
                <label for="new_login">Nouveau pseudo</label>
                <input type="text" name="new_login" value="" required placeholder="Nouveau pseudo"><br><br>
            </div>
            <div class="form_element">
                <label for="new_login_conf">Confirmation pseudo</label>
                <input type="text" name="new_login_conf" value="" required placeholder="Confirmer pseudo"><br><br>
            </div>
            <button type="submit" name="login_button" class="profil-button">Modifier</button>
        </form>
        <form class="form-profil" action="profil.php" method="post">
            <h2>Modifier mot de passe</h2><br>
            <div class="form_element">
                <label for="old_pass">Ancien mot de passe</label>
                <input type="password" name="old_pass" value="" required placeholder="Ancien mdp"><br><br>
            </div>
            <div class="form_element">
                <label for="new_pass">Nouveau mot de passe</label>
                <input type="password" name="new_pass" value="" required placeholder="Nouveau mdp">
            </div><br><br>
            <div class="form_element">
                <label for="new_pass_conf">Confirmation nouveau mot de passe</label>
                <input type="password" name="new_pass_conf" value="" required placeholder="Confirmer nouveau mdp">
            </div><br><br>
            <button type="submit" name="password_button" class="profil-button">Modifier</button>
        </form>
    </div>
</main>
<footer>
    <?php include("footer.php") ?>
</footer>
</body>
</html>
