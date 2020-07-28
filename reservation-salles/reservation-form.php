<?php

?>

<form class="form-reservation-input" action="planning.php" method="post">
    <div class="form_element">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="" required placeholder="Titre" maxlength="30"><br>
    </div>
    <div class="form_element">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" value="" required placeholder="Description" maxlength="30"><br>
    </div>
    <div class="form_element">
        <div class="ligne-form-resa">
            <label for="date_debut">Le</label>
            <input type="date" name="date" id="date_debut" value="" required>
            <label for="heure_debut">de </label>
            <input type="time" name="heure_debut" id="heure_debut" value="" step="3600" min="08:00:00" max="18:00:00" required>
            <label for="heure_fin">à </label>
            <input type="time" name="heure_fin" id="heure_fin" value="" step="3600" min="09:00:00" max="19:00:00" required><br><br>
        </div>
        <button type="submit" name="reservation_button" class="form-reservation_button">Réserver</button>
      
    </div>
</form>
