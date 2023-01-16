<?php
session_start();

// On recupere les variables envoyees par le formulaire
$nom = $_POST['Nom'] ?? '';
$prenom = $_POST['Prenom'] ?? '';
$matricule = $_POST['Matricule'] ?? '';
$details = $_POST['Description'] ?? '';
$niveau = $_POST['Niveau'] ?? '';
$motif = $_POST['motif'] ?? '';

$target_dir = "images/uploads/";
$uploadOk = true;
$imageFileType = strtolower(pathinfo(basename($target_dir . $_FILES["PJ"]["name"]), PATHINFO_EXTENSION));
$target_file = $target_dir . uniqid() . strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', basename($_FILES["PJ"]["name"]))));
// Check if image file is a actual image or fake image
$piecejointe = NULL;
if ($_FILES["PJ"]['name'] != null) {
    $check = getimagesize($_FILES["PJ"]["tmp_name"]);
    if ($check !== false) {
        // File is an image
        if ($_FILES["PJ"]["size"] <= 500000) {
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["PJ"]["tmp_name"], $target_file)) {
                    // Deplacement reussi
                    $piecejointe = $target_file;
                } else {
                    $_SESSION['FILE_NOT_UPLOADED'] = true;
                }
            } else {
                // Sorry, only JPG, JPEG & PNG files are allowed
                $uploadOk = false;
            }
        } else {
            // File is too large
            $uploadOk = false;
        }
    } else {
        // File is not an image
        $uploadOk = false;
    }

    if (!$uploadOk) {
        $_SESSION['FILE_NOT_IMAGE'] = true;
    }
}


// Enregistrement dans une base de donnees
$servername = "localhost";
$dbname = "base_ud";
$username = "root";
$password = "";

if ($uploadOk) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $conn->prepare("INSERT INTO requetes (Matr, Nom, Prenom, Niveau, Motif, Detail, Piece_jointe, Date, Etat) VALUES (?, ?, ?, ?, ?, ? , ?, NOW(), 'Untreated')");
        $sql->execute([
            $matricule,
            $nom,
            $prenom,
            $niveau,
            $motif,
            $details,
            $piecejointe
        ]);

        $_SESSION['QUERY_SUCCESS'] = true;
    } catch (PDOException $e) {
        // echo "Erreur : " . $e->getMessage();
        $_SESSION['QUERY_SUCCESS'] = false;
    }
    $conn = null;
}
header("Location: coteEtudiant.php");
