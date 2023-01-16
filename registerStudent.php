<?php


if (isset($_POST['nom'])) {
    $new_nom = htmlspecialchars($_POST['nom']);
    $new_prenom = htmlspecialchars($_POST['prenom']);
    $new_lvl = htmlspecialchars($_POST['niveau']);
    $new_fil = htmlspecialchars($_POST['filiere']);

    $cnx = new mysqli("localhost", "root", "", "base_ud");
    if ($cnx->connect_error) {
        die("Connexion impossible" . $cnx->connect_error);
    } else {
        // Generation d'un matricule
        $log = $cnx->query("SELECT Nom FROM liste_etudiants");
        $nbr_etu = $log->num_rows;
        $new_matr = "22S" . (string)(10000 + $nbr_etu);
        // Generation d'un mot de passe (pin)
        $temp = str_shuffle("0123456789");
        $new_pin = substr($temp, 0, 5);

        $save = $cnx->prepare("INSERT INTO liste_etudiants (Matricule, Pin, Nom, Prenom, Niveau, Filiere) VALUES (?,?,?,?,?,?)");
        $save->bind_param("sissss", $new_matr, $new_pin, $new_nom, $new_prenom, $new_lvl, $new_fil);
        $save->execute();
        $save->close();

        echo '<html>'
            . '<head>'
            . '<meta charset="UTF-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<meta name="author" content="Harold">'
            . '<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">'
            . '<link href="css/signin.css" rel="stylesheet">'
            . '</head>';

        echo "<body><div class='container p-4'>";
        echo '<div class="card text-center shadow-lg">'
            . '<div class="card-header bg-success text-white">
                Sign up success
            </div>
            <div class="card-body">
                <h5 class="card-title">You have successfully create your account, here are your login informations.<hr>Note it well</h5>
                <p class="card-text p-3 fw-bold">Register: ' . $new_matr . '<br>Password: ' . $new_pin . '</p>
                <a href="index.php" class="btn btn-outline-success">Understood</a>
            </div>
            <div class="card-footer text-muted">
                Now
            </div>
            </div>';
        echo "</div></body>";
        echo '</html>';
    }
}
