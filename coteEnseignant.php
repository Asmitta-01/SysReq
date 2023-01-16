<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['Nom']) && isset($_SESSION['Prenom'])) {
    $nom_utls = htmlspecialchars($_SESSION['Nom']);
    $prn_utls = htmlspecialchars($_SESSION['Prenom']);
    $niv_utls = htmlspecialchars($_SESSION['Niveau']);
    $dom_utls = htmlspecialchars($_SESSION['Domaine']);
} else {
    header("Location: index.php");
}
?>

<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/styleEt.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <script src='js/jquery.js'></script>
    <title>Professor - Query Manager</title>
</head>

<body>
    <div>
        <div class="row text-white rounded bg-dark">
            <div class="col-md-7 p-4 p-md-5 px-0 mb-4">
                <h1 class="display-4">Query<br>Manager</h1>
                <hr class="mb-2">
                <p class="lead my-3">Welcome M. <?php echo $nom_utls . " " . $prn_utls . "<span class='fs-6'>, In charge of " . $dom_utls . " Level " . $niv_utls . "</span>"; ?></p>
                <p class="lead mb-0 fst-italic">Do your best in this work and treat the best way these requests</p>
            </div>
            <div class="col-md-5 py-5 px-4 d-flex flex-row-reverse">
                <img src="images/logo_UD-removebg-preview.png" alt="Douala University" height="250px">
            </div>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
            <button class="nav-link active" id="new-query-tab" data-bs-toggle="tab" data-bs-target="#new-query" type="button" role="tab" aria-controls="new-query" aria-selected="true">Unchecked queries</button>
            <button class="nav-link" id="old-queries-tab" data-bs-toggle="tab" data-bs-target="#old-queries" type="button" role="tab" aria-controls="old-queries" aria-selected="false">View old queries</button>

            <button class="btn btn-dark my-2 ms-auto mx-2" onclick="window.location='index.php'">Log out</button>
        </div>
    </nav>
    <div class="tab-content pb-4" id="nav-tabContent">
        <div class="tab-pane fade show active" id="new-query" role="tabpanel" aria-labelledby="new-query-tab">
            <div class="container-fluid">
                <?php
                $i = 0;

                $servername = "localhost";
                $dbname = "base_ud";
                $username = "root";
                $password = "";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = $conn->prepare("SELECT * FROM requetes WHERE Etat='Untreated' AND Niveau='Licence $niv_utls' ");
                    $sql->execute();

                    $ligne = array_reverse($sql->fetchAll());
                    if ($ligne != null) {
                        echo '<table class="table caption-top table-hover table-striped">'
                            . '<caption>List of untreated requests</caption>'
                            . '<thead class="table-dark">'
                            . '<tr>'
                            . '<th>Requests</th>'
                            . '<th>State</th>'
                            . '<th>Actions</th>'
                            . '</tr>'
                            . '</thead>'
                            . '<tbody>';

                        foreach ($ligne as $elts) {
                            $id = $elts[0];
                            $d = $elts[7];
                            echo "<tr>";
                            echo "<td><a href='#mod$i' class='link-dark fw-bold text-decoration-none' data-bs-toggle='modal' data-bs-target='#mod$i'>Request of $d</a></td>" .
                                '<div class="modal fade" id="mod' . $i . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Request No ' . $id . ' on ' . $d . '</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <label>Register :</label><span class="fw-bold mx-2">' . $elts[0] . '</span><br>
                                                            <label>First & Last names :</label><span class="fw-bold mx-2">' . $elts[1] . ' ' . $elts[2] . '</span><br>
                                                            <label>Level :</label><span class="fw-bold mx-2">' . $elts[3] . '</span>
                                                        </p>
                                                        <hr class="my-2">
                                                        <label>Object :</label><span>' . $elts[4] . '</span><br>
                                                        <label class="fw-bold">Query details :</label>
                                                        <p class="mb-2">' . $elts[5] . '</p>';
                            if ($elts[6] != '') {
                                echo '<div class="text-center">' .
                                    '<span>Joined picture</span>' .
                                    '<img src=' . $elts[6] . ' class="rounded w-100" alt="...">' .
                                    '</div>';
                            }
                            echo '</div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>';
                            echo "<td style=\"color: red\">$elts[8]</td>";
                            echo "<td>"
                                . "<div class='input-group d-grip gap-2'>"
                                . "<button class='btn btn-sm btn-success w-auto' onclick='window.location = \"traitmtReq.php?obj=$elts[0]+|+$d\";'>Resolve</button>"
                                . '<button class="btn btn-sm btn-outline-danger w-25 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Reject</button>'
                                . "<div class='dropdown-menu dropdown-menu-form p-2 display-6 w-50' aria-labelledby='drop$i'>"
                                . "<form action='traitmtReq.php' method='post'>"
                                . "<div class='form-text'><p>For which reason do you reject this request ?</p>"
                                . "<div class='col-sm' data-toggle='buttons'>"
                                . '<input type="radio" class="btn-check" name="choixR" id="danger-outlined1' . $i . '" autocomplete="off" value="Incomplete">'
                                . '<label class="btn btn-sm w-100 btn-outline-danger mb-2" for="danger-outlined1' . $i . '">Missing proofs</label>'
                                . '<input type="radio" class="btn-check" name="choixR" id="danger-outlined2' . $i . '" autocomplete="off" value="Unfounded">'
                                . '<label class="btn btn-sm w-100 btn-outline-danger mb-2" for="danger-outlined2' . $i . '">Query not funded</label>'
                                . '<input type="radio" class="btn-check" name="choixR" id="danger-outlined3' . $i . '" autocomplete="off" value="Irrecevable">'
                                . '<label class="btn btn-sm w-100 btn-outline-danger mb-2" for="danger-outlined3' . $i . '">Unreceivable</label>'
                                . "</div>"
                                . "<input type='hidden' name='requete' value=\"$elts[0]|$d\"/>"
                                . "<input class='btn btn-sm w-100 btn-dark' type='submit' value='Confirm reject' class='close'/>"
                                . "</div>"
                                . "</form>"
                                . "</td>";
                            echo "</tr>";

                            $i++;
                        }
                        echo '</tbody>'
                            . '</table>';
                    } else {
                        echo
                        '<div class="alert alert-secondary my-4">
                            There is not new sent request to you section now.
                        </div>';
                    }
                } catch (PDOException $e) {
                    die("Erreur : " . $e->getMessage());
                }
                $conn = null;
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="old-queries" role="tabpanel" aria-labelledby="old-queries-tab">
            <div class="px-5">
                <script type="text/javascript">
                    document.vlinkColor = "black";
                </script>
                <table class="table table-hover caption-top table-secondary">
                    <caption>List of Olds treated requests</caption>
                    <thead>
                        <tr>
                            <th scope="col">Request</th>
                            <th scope="col">State</th>
                            <th scope="col">Observations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cnx2 = mysqli_connect("localhost", "root", "", "base_ud");
                        if (!$cnx2) {
                            echo "<div class='alert alert-danger'>Connexion impossible. " . mysqli_error($cnx) . '</div>';
                        } else {
                            $ligne = mysqli_query($cnx2, "SELECT * FROM requetes WHERE Etat!='Untreated' AND Niveau='Licence $niv_utls' ");

                            while ($elts = mysqli_fetch_array($ligne)) {
                                $d = $elts['Date'];
                                echo "<tr>";
                                echo "<td><a href='#req$i' class='link-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#req$i'>Requete du $d</a></td>";
                                echo '<div class="modal fade" id="req' . $i . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Requete du ' . $d . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <label>Matricule :</label><span class="fw-bold mx-2">' . $elts[0] . '</span><br>
                                            <label>Nom & Prenom :</label><span class="fw-bold mx-2">' . $elts[1] . ' ' . $elts[2] . '</span><br>
                                            <label>Niveau :</label><span class="fw-bold mx-2">' . $elts[3] . '</span>
                                        </p>
                                        <hr class="my-2">
                                        <label>Object :</label><span>' . $elts[4] . '</span><br>
                                        <label class="fw-bold">Query details :</label>
                                        <p class="mb-2">' . $elts[5] . '</p>';
                                if ($elts[6] != '') {
                                    echo '<div class="text-center">' .
                                        '<span>Piece jointe</span>' .
                                        '<img src=' . $elts[6] . ' class="rounded w-100" alt="...">' .
                                        '</div>';
                                }
                                echo '</div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-outline-primary">Understood</button>
                                    </div>
                                </div>
                                </div>
                            </div>';
                                echo "<td>" . $elts['Etat'] . "</td>";
                                echo "<td>" . $elts['Observations'] . "</td>";
                                echo "</tr>";
                                $i++;
                            }
                        }
                        ?>
                </table>
            </div>
        </div>
    </div>
    <div class="form-text px-4 row bg-dark">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top border-secondary">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <image src="images/logo_UD-removebg-preview.png" width="30" />
                </a>
                <span class="text-muted">&copy; 2022 Faculty of Sciences, Douala University</span>
            </div>
        </footer>
    </div>

    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        $('.dropdown-menu').on('click', function(e) {
            if ($(this).hasClass('dropdown-menu-form')) {
                e.stopPropagation();
            }
        });
        <?php
        if (
            isset($_SESSION['ERROR'])
            &&
            ($_SESSION['ERROR'] == 'REQUEST_UPDATE_FAILED' || $_SESSION['ERROR'] == 'CONNEXION_FAILED')
        ) {
            echo "document.alert('An error occurs while treating the request, please retry later.')";
            unset($_SESSION['ERROR']);
        }
        ?>
    </script>
</body>

</html>