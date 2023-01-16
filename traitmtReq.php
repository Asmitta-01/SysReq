<?php
session_start();

$cnx = mysqli_connect("localhost", "root", "", "base_ud");

if (isset($_GET['obj'])) {
    $req = explode("|", htmlspecialchars($_GET['obj']));

    if (!$cnx) {
        $_SESSION['ERROR'] = 'CONNEXION_FAILED';
        header("Location: coteEnseignant.php");
    } else {
        $requete = mysqli_query($cnx, "UPDATE requetes SET Etat='Resolved' WHERE Matr='$req[0]' AND Date='$req[1]' ");

        if (!$requete) {
            // die("Une erreur s'est produite lors de de l'operation.");
            $_SESSION['ERROR'] = 'REQUEST_UPDATE_FAILED';
            header("Location: coteEnseignant.php");
        } else {
            header("Location: coteEnseignant.php");
        }
    }
} else if (isset($_POST['requete'])) {
    $req = explode("|", htmlspecialchars($_POST['requete']));
    $obs = htmlspecialchars($_POST['choixR']);

    if (!$cnx) {
        die("Connexion impossible. " . mysqli_error($cnx));
    } else {
        $requete = mysqli_query($cnx, "UPDATE requetes SET Etat='Rejected',Observations='$obs' WHERE Matr='$req[0]' AND Date='$req[1]' ");

        if (!$requete) {
            die("Une erreur s'est produite.");
        } else {
            header("Location: coteEnseignant.php");
        }
    }
}

mysqli_close($cnx);
