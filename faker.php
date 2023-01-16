<?php
require_once 'vendor/autoload.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

$cnx = new mysqli("localhost", "root", "", "base_ud");
if ($cnx->connect_error) {
    die("Connexion impossible" . $cnx->connect_error);
} else {
    // Generate 15 random students
    for ($i = 0; $i < 15; $i++) {
        // $log = $cnx->query("SELECT Nom FROM liste_etudiants");
        // $new_matr = "22S" . (string)(10000 + $log->num_rows);
        // $new_pin = substr(str_shuffle("0123456789"), 0, 5);
        // $name = $faker->firstName();
        // $lname = $faker->lastName();
        // $lvl = "Licence " . rand(1, 3);
        // $ar_fil = ['Informatique', 'Mathematiques', 'Biologie', 'Physique'];
        // $fil = $ar_fil[array_rand($ar_fil)];

        // $save = $cnx->prepare("INSERT INTO liste_etudiants (Matricule, Pin, Nom, Prenom, Niveau, Filiere) VALUES (?,?,?,?,?,?)");
        // $save->bind_param("sissss", $new_matr, $new_pin, $name, $lname, $lvl, $fil);
        // $save->execute();
    }

    //Generate 5 random professors
    for ($i = 0; $i < 5; $i++) {
        // $new_matr = "10DDN" . $i;
        // $new_pin = $faker->password(4, 7);
        // $name = $faker->firstName();
        // $lname = $faker->lastName();
        // $email = $faker->email();
        // $lvl = rand(1, 3);
        // $ar_fil = ['Informatique', 'Mathematiques', 'Biologie', 'Physique'];
        // $fil = $ar_fil[array_rand($ar_fil)];

        // $save = $cnx->prepare("INSERT INTO liste_profs (Identifiant, MotdePasse, Nom, Prenom, Email, Domaine, Niveau) VALUES (?,?,?,?,?,?,?)");
        // $save->bind_param("ssssssi", $new_matr, $new_pin, $name, $lname, $email, $fil, $lvl);
        // $save->execute();
    }

    // Generate 20 random requests
    for ($i = 0; $i < 20; $i++) {
        // $log = $cnx->query("SELECT Matricule, Nom, Prenom, Niveau FROM liste_etudiants");
        // $result = mysqli_fetch_all($log, MYSQLI_ASSOC);
        // $key = array_rand($result);
        // $matr = $result[$key]['Matricule'];
        // $nom = $result[$key]['Nom'];
        // $prenom = $result[$key]['Prenom'];
        // $lvl = $result[$key]['Niveau'];
        // $array = ['Request Transcript', 'TP Note Missing', 'CC Note Missing', 'Request Certificate of Schooling', 'Exam Note Missing', 'Other'];
        // $motif = $array[array_rand($array)];
        // $detatl = $faker->realTextBetween(35, 80);
        // $state = "Untreated";
        // $date = date("Y-m-d H:i:s");

        // $save = $cnx->prepare("INSERT INTO requetes (Matr, Nom, Prenom, Niveau, Motif, Detail, Date, Etat) VALUES (?,?,?,?,?,?,?,?)");
        // $save->bind_param("ssssssss", $matr, $nom, $prenom, $lvl, $motif, $detatl, $date, $state);
        // $save->execute();
    }

    $save->close();

    header("Location: index.php");
}
