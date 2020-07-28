<?php

session_start();

$db = mysqli_connect("localhost", "root", "", "reservationsalles");

// Set local information fo time according to locale fr_Fr
setlocale(LC_TIME, 'fr_FR.UTF8');

/*REDIRECTIONS SELON SESSION*/

if (in_array($page_selected, ['profil', 'user_reservation', 'reservation', 'form_multiples_creneaux', 'planning']) and !$_SESSION['user']) {
    header('location: connexion.php');
}
if (in_array($page_selected, ['connexion', 'inscription']) and isset($_SESSION['user'])) {
    header('location: index.php');
}

/*FONCTIONS*/

/*ERREURS*/
/**
 * @param $errors
 * @return string
 */
function renderErrors($errors)
{
    if (!empty($errors)) {
        $output = "";
        if (count($errors) > 1) {
            $output .= "<ul>";
            foreach ($errors as $error) {
                $output .= "<li>" . $error . "</li>";
            }
            $output .= "</ul>";
        } else {
            $output = $errors[0];
        }
        return "<div class=\"ErrorMessage margin1\">"
            . $output .
            "</div>";
    } else {
        return "";
    }
}

/* GENERE LE NOM DES JOURS DE LA SEMAINE */
include 'functions/get_week_days.php';

/* GENERE UN AFFICHAGE DE PLAGE HORAIRE */
include 'functions/slot_generator.php';

?>

<nav class="navbar">
        <ul>
            <?php if (!isset($_SESSION['user'])) : ?>
                <li><a href="index.php"><h1>Accueil</h1></a></li>
                <li class="resp_head"><a href="connexion.php"><h1>Connexion</h1></a></li>
                <li class="resp_head"><a href="inscription.php"><h1>Inscription</h1></a></li>
                <li class="liste2">
                    <i class="fad fa-bars"></i>
                    <ul class="sous-liste2">
                        <li><a href="connexion.php"><h1>Connexion</h1></a></li>
                        <li><a href="inscription.php"><h1>Inscription</h1></a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="index.php"><h1>Accueil</h1></a></li>
                <li class="resp_head"><a href="planning.php"><h1>Planning</h1></a></li>
                <li class="liste resp_head">
                    <h1 class="header_autre">Mon compte</h1>
                    <ul class="sous-liste">
                        <li><a href="profil.php">Modifier mes identifiants</a></li>
                        <li><a href="user_reservation.php">Modifier mes réservations</a></li>
                        <li><a href="delete_session.php">Déconnexion</a></li>
                    </ul>
                </li>
                <li class="liste2">
                    <i class="fad fa-bars"></i>
                    <ul class="sous-liste2">
                        <li><a href="planning.php"><h1>Planning</h1></a></li>
                        <li><a href="profil.php">Modifier mes identifiants</a></li>
                        <li><a href="user_reservation.php">Modifier mes réservations</a></li>
                        <li><a href="delete_session.php">Déconnexion</a></li>
                    </ul>
                </li>

            <?php endif; ?>
        </ul>
</nav>
