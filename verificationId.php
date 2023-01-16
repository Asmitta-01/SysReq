<?php
session_start();


$servername = "localhost";
$dbname = "base_ud";
$username = "root";
$password = "";

if (isset($_POST['Matricule']) && isset($_POST['PIN'])) {
    $matr_Recu = htmlspecialchars($_POST['Matricule']);
    $pin_Recu = htmlspecialchars($_POST['PIN']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $conn->prepare("SELECT * FROM liste_etudiants WHERE Matricule='$matr_Recu' AND PIN=$pin_Recu");
        $sql->execute();
        $result = $sql->fetch();

        if ($result['Matricule'] == NULL) {
            header("Location: index.php?type=etu");
        } else {
            $_SESSION['Matricule'] = $result['Matricule'];
            $_SESSION['Nom'] = $result['Nom'];
            $_SESSION['Prenom'] = $result['Prenom'];
            $_SESSION['Niveau'] = $result['Niveau'];
            $_SESSION['Filiere'] = $result['Filiere'];

            header("Location: coteEtudiant.php");
        }
    } catch (PDOException $e) {
        // echo "Erreur : " . $e->getMessage();
        header("Location: index.php?type=etu");
    }
    $conn = null;
} else  if (isset($_POST['ID']) && isset($_POST['Mdp'])) {
    $id_Recu = htmlspecialchars($_POST['ID']);
    $mdp_Recu = htmlspecialchars($_POST['Mdp']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $conn->prepare("SELECT * FROM liste_profs WHERE Identifiant='$id_Recu' AND MotdePasse='$mdp_Recu' ");
        $sql->execute();
        $result = $sql->fetch();

        if ($result['Identifiant'] == NULL) {
            header("Location: index.php?type=ens");
        } else {
            $_SESSION['Nom'] = $result['Nom'];
            $_SESSION['Prenom'] = $result['Prenom'];
            $_SESSION['Niveau'] = $result['Niveau'];
            $_SESSION['Domaine'] = $result['Domaine'];

            header("Location: coteEnseignant.php");
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    $conn = null;
} else {
    header("Location: index.php");
}
