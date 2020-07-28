<?php

$page_selected = "form_multiples_creneaux";
$h1 = $h_to_int_debut;
$h2 = $h_to_int_debut + 1;
?>
<div class="reserve_box">
    <p>Certains créneaux sont déjà réservés, veuillez en sélectionner parmi les suivants:</p>
    <form class="form_multiples_creneaux" action="planning.php" method="post">
        <?php

        foreach ($is_creneaux_av as $key => $value) {
            if ($value == null) {
                ?>
                <div>
                    <label class="container" for="choice<?= $key; ?>"><?= "De " . $h1, "h à " . $h2, "h"; ?>
                        <input type="checkbox" id="choice<?= $key; ?>" name="choice<?= $key; ?>" value="<?= $h1; ?>">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <?php
            }
            $h1++;
            $h2++;
        }
        ?>
        <button class="form-reservation_button" type="submit" name="fill_creneaux" value="Confirmer">Confimer</button>
    </form>
</div>
