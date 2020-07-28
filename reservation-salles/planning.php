<?php

$page_selected = "planning";
?>

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
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet"></head>
    <link rel="stylesheet" href="fontawesome/all.css">
<body class="planning-form">
<header>
    <?php
    include("header.php");
    $errors = [];
    date_default_timezone_set('Europe/Paris');

    /* RECUP ID FROM SESSION */

    $login = $_SESSION['user']['login'];
    $request_id = "SELECT id from `reservationsalles`.`utilisateurs` WHERE login = '$login';";
    $query_id = mysqli_query($db, $request_id);
    $user_id = mysqli_fetch_array($query_id);

    /* SI FORM MULTIPLES CRENEAUX EXISTE */

    if (isset($_POST['fill_creneaux'])) {
        $titre = $_SESSION['titre'];
        $description = $_SESSION['description'];
        $date = $_SESSION['date'];
        for ($i = 0; $i < 11; $i++) {
            if (isset($_POST["choice$i"])) {
                $h1 = $_POST["choice$i"];
                $h2 = $_POST["choice$i"] + 1;
                $debut = $date . " " . $h1;
                $fin = $date . " " . $h2;
                $request = "INSERT INTO `reservationsalles`.`reservations`(titre, description, debut, fin, id_utilisateur) VALUES ('" . $titre . "', '" . $description . "', '" . $debut . "', '" . $fin . "', '" . $user_id['id'] . "');";
                $query = mysqli_query($db, $request);
                unset($_SESSION['titre']);
                unset($_SESSION['description']);
                unset($_SESSION['date']);
            }
        }
    }

    /*CONDITIONS INPUT*/

    if (!empty($_POST['titre']) and !empty($_POST['description']) and !empty($_POST['date']) and !empty($_POST['heure_debut'])) {
        $titre = htmlentities(trim($_POST['titre']));
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
        $date = $_POST['date'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        $_SESSION['titre'] = $titre;
        $_SESSION['description'] = $description;
        $_SESSION['date'] = $date;

        /*TITRE*/
        $titre_required = preg_match("/^[A-Za-z]{1,}.{0,29}$/", $titre);
        if (!$titre_required) {
            $errors[] = "Votre titre doit:<br>- Commencer par une lettre.<br>- Contenir 30 caractères maximum.";
        }

        /*DESCRIPTION*/
        $description_required = preg_match("/^[A-Za-z]{1,}.{0,29}$/", $description);
        if (!$description_required) {
            $errors[] = "Votre description doit: <br>- Commencer par une lettre.<br>- Contenir 30 caractères maximum.";
        }

        /*DATE*/

        // JOURS DE LA SEMAINE
        $days = strtotime($date);
        $dayOfWeek = date("l", $days);
        if ($dayOfWeek == "Saturday" or $dayOfWeek == "Sunday") {
            $errors[] = "Les réservations ne sont possibles que du lundi au vendredi.";
        }

        // EMPECHER POST RESERVATION

        $today_s_date = date('Y-m-d');
        if ($date <= $today_s_date) {
            if ($date == $today_s_date) {
                $today_s_hour = date('H:i');
                if ($heure_debut <= $today_s_hour) {
                    $errors[] = "Vous ne pouvez pas réserver un créneaux sur une heure antérieure.";
                }
            } else {
                $errors[] = "La réservation ne peux pas se faire sur une date antérieure.";
            }
        }

        /*HEURE*/
        $heure_pile = preg_match("/^.*[0][0]$/", $heure_debut);
        if (!$heure_pile) {
            $errors[] = "L'heure doit commencer à pile !";
        }
        $heure_pile2 = preg_match("/^.*[0][0]$/", $heure_fin);
        if (!$heure_pile2) {
            $errors[] = "L'heure doit finir à pile !";
        }
        if ($heure_debut >= $heure_fin) {
            $errors[] = "L'heure de début doit être inférieur à l'heure de fin.";
        }

        //VERIFICATION CRENAUX HORAIRE

        if ($heure_debut < 8 or $heure_debut > 18) {
            $errors[] = "L'heure de début doit être comprise entre 08:00 et 18:00.";
        }
        if ($heure_fin < 9 or $heure_fin > 19) {
            $errors[] = "L'heure de fin doit être comprise entre 09:00 et 19:00.";
        }

        /*VERIFICATION EXISTANTS*/

        if (empty($errors)) {
            include 'functions/hour_to_integer.php';
            $h_to_int_debut = heure_recup($heure_debut);
            $h_to_int_fin = heure_recup($heure_fin);

            //CRENEAU UNIQUE
            if (($h_to_int_fin - $h_to_int_debut) == 1) {
                $debut = $date . " " . $heure_debut;
                $fin = $date . " " . $heure_fin;
                $request = "SELECT debut, fin FROM `reservationsalles`.`reservations` WHERE debut = '" . $debut . "' AND fin = '" . $fin . "';";
                $query = mysqli_query($db, $request);
                $is_creneaux_av = mysqli_fetch_array($query);
                if (!empty($is_creneaux_av)) {
                    $errors[] = "Ce créneaux est déjà réservé !";
                }
            }
            //CRENEAUX MULTIPLES
            if (($h_to_int_fin - $h_to_int_debut) > 1) {
                $creneaux = $h_to_int_fin - $h_to_int_debut;
                for ($i = 0; $i < $creneaux; $i++) {
                    $h1 = $h_to_int_debut + $i;
                    $debut = $date . " " . $h1;
                    $h2 = $h_to_int_debut + $i + 1;
                    $fin = $date . " " . $h2;
                    $request = "SELECT debut, fin FROM `reservationsalles`.`reservations` WHERE debut = '" . $debut . "' AND fin = '" . $fin . "';";
                    $query = mysqli_query($db, $request);
                    $is_creneaux_av[$i] = mysqli_fetch_row($query);
                    if (isset($is_creneaux_av[$i][0])) {
                        $not_all_null = 1;
                    }
                }
                if (isset($not_all_null)) {
                    foreach ($is_creneaux_av as $key => $value) {
                        if ($value == null) {
                            include 'form_multiples_creneaux.php';
                            $tester = 1;
                            break;
                        }
                    }
                    if (!isset($tester)) {
                        $errors[] = "Aucun créneau dans les horaires choisis n'est disponible.";
                    }
                }
            }
            if (empty($errors) and !isset($not_all_null)) {
                if (($h_to_int_fin - $h_to_int_debut) > 1) {
                    $creneaux = $h_to_int_fin - $h_to_int_debut;
                    for ($i = 0; $i < $creneaux; $i++) {
                        $h1 = $h_to_int_debut + $i;
                        $debut = $date . " " . $h1;
                        $h2 = $h_to_int_debut + $i + 1;
                        $fin = $date . " " . $h2;
                        $request = "INSERT INTO `reservationsalles`.`reservations`(titre, description, debut, fin, id_utilisateur) VALUES ('" . $titre . "', '" . $description . "', '" . $debut . "', '" . $fin . "', '" . $user_id['id'] . "');";
                        $query = mysqli_query($db, $request);
                    }
                } else {
                    $request = "INSERT INTO `reservationsalles`.`reservations`(titre, description, debut, fin, id_utilisateur) VALUES ('" . $titre . "', '" . $description . "', '" . $debut . "', '" . $fin . "', '" . $user_id['id'] . "');";
                    $query = mysqli_query($db, $request);
                }
            }
        }
    } elseif (isset($_POST['reservation_button']) and !empty($_POST)) {
        $errors[] = "Tous les champs doivent être remplis.";
    }
    ?>

</header>
<main>
    <div class="content reservation-form">
        <?= renderErrors($errors) ?>
        <h2>Réservez un créneau *</h2>
        <?php
        include 'reservation-form.php'; ?>
        <p><em> * Les réservations se font du lundi au vendredi et de 8h à 19h.<br>Les créneaux ont une durée fixe
                d’une heure.</em></p>
    </div>
    <div class="week-container-group">
        <table class="week-calendar">
            <thead>
            <tr>
                <th class="heure-titre">Heure</th>
                <?php
                $weekDays = getWeekDays();
                foreach ($weekDays as $weekDay) : ?>
                    <th><?= $weekDay; ?></th>
                    <?php
                endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $slots = slot_genrator(8, 19);
            foreach ($slots as $slot) :
                ?>
                <tr>
                    <td class="heure">
                        <?= $slot; ?>
                    </td>
                    <?php
                    $weekDays = getWeekDays();
                    foreach ($weekDays as $weekDay) : ?>
                        <?php
                        $userEventsQry = "select * from `reservationsalles`.`reservations`";
                        $userEventsQryExec = $db->query($userEventsQry);
                        $userEventsFetchExec = $userEventsQryExec->fetch_all(1); ?>
                        <?php
                        $v = 0;
                        foreach ($userEventsFetchExec as $events) : ?>
                            <?php
                            if ((date('G', strtotime($events['debut'])) . "h00") == $slot && (strftime('%A', (date(strtotime($events['debut']))))) == $weekDay) :
                                $v = 1;
                                ?>
                                <td class="reservation">
                                    <?= $_SESSION['user']['login']; ?>
                                    <br>
                                    <a href="reservation.php?id=<?= $events['id'] ?>">
                                    <?= $events['titre']; ?>
                                    </a>
                                </td>
                                <?php
                            endif; ?>
                            <?php
                        endforeach; ?>
                        <?php
                        if ($v == 0) : ?>
                            <td>Disponible</td>
                            <?php
                        endif; ?>
                        <?php
                    endforeach; ?>
                </tr>
                <?php
            endforeach; ?>
            <tr>
            </tr>
            </tbody>
        </table>
    </div>
</main>
<footer>
    <?php
    include("footer.php") ?>
</footer>
</body>
</html>
