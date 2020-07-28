<?php $page_selected = "reservation"; ?>

<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes"/>
    <link rel="stylesheet" href="styles/css/style.css">
    <script src="https://kit.fontawesome.com/217c9d0a4d.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/all.css">
    <title>Réservation</title>
</head>
<body class="body-reservation">
<header>
    <?php
    include("header.php");
    $errors = [];
    $id_reservation = $_GET['id'];
    $request = "SELECT id, titre, description, cast(debut as time), cast(fin as time), cast(debut as date),id_utilisateur FROM `reservationsalles`.`reservations` WHERE id = '$id_reservation'";
    $query = mysqli_query($db, $request);
    $reservation = mysqli_fetch_array($query);
    if (empty($reservation)) {
        $errors[] = "Cette réservation n'existe pas !";
    } else {
        $reservation['heure_debut'] = $reservation['cast(debut as time)'];
        $reservation['heure_fin'] = $reservation['cast(fin as time)'];
        $reservation['date'] = $reservation['cast(debut as date)'];
        $user_id = $reservation['id_utilisateur'];
        $request2 = "SELECT login FROM `reservationsalles`.`utilisateurs` WHERE id = '$user_id'";
        $query2 = mysqli_query($db, $request2);
        $user_login = mysqli_fetch_array($query2);
    }
    ?>
</header>
<main>
    <?php
    echo renderErrors($errors);
    if (empty($errors)) { ?>
        <div class="content reservation-event">
            <h2><?= $reservation['titre'] ?></h2>
            <h3>Date</h3>
            <p>Le <?= $reservation['date'] ?> de <?= $reservation['heure_debut'] ?>
                à <?= $reservation['heure_fin'] ?></p>
            <h3>Description</h3>
            <p><?= $reservation['description'] ?></p>
            <p><span>Réservé par</span> <?= $user_login[0] ?></p>
        </div>
        <?php
    } ?>
</main>
<footer>
    <?php
    include("footer.php") ?>
</footer>
</body>
</html>
