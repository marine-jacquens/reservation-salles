<section class="footer">
    <div class="logo">
        <h1>Roomy</h1>
    </div>
    <div class="menu">
        <?php
                if(isset($_SESSION['user'])){
                $user = $_SESSION['user']['login'];
                echo"
                    <ul>
                        <a href='index.php'><li class=\"after\">Accueil</li></a>
                        <a href='planning.php'><li class=\"after\">Planning</li></a>
                        <a href='profil.php'><li>Profil</li></a>
                    </ul>
                ";
                }else{
                    echo"
                    <ul>
                        <a href='index.php'><li class='after'>Accueil</li></a>
                        <a href='connexion.php'><li class='after'>Connexion</li></a>
                        <a href='inscription.php'><li>Inscription</li></a>
                    </ul>
                    ";
                }
            ?>
    </div>
    <div class="RS">
        <ul>
            <li><a href="https://www.facebook.com"><i class="fab fa-facebook-square"></i></a></li>
            <li><a href="https://www.instagram.com"><i class="fab fa-instagram-square"></i></a></li>
            <li> <a href="https://www.twitter.com"><i class="fab fa-twitter-square"></i></a></li>
            <li><a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a></li>
        </ul>
    </div>
</section>


<?php

mysqli_close($db);

?>

