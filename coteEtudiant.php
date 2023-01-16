<?php
session_start();

if (isset($_SESSION['Matricule']) && isset($_SESSION['Nom']) && isset($_SESSION['Prenom'])) {
    $matr_utls = htmlspecialchars($_SESSION['Matricule']);
    $nom_utls = htmlspecialchars($_SESSION['Nom']);
    $prn_utls = htmlspecialchars($_SESSION['Prenom']);
    $niv_utls = htmlspecialchars($_SESSION['Niveau']);
    $fil_utls = htmlspecialchars($_SESSION['Filiere']);
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Query Manager - Logged as student</title>
    <link rel="stylesheet" href="css/styleEt.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <script src='js/jquery.js'></script>
</head>

<body>
    <div>
        <div class="row text-white rounded bg-dark">
            <div class="col-md-6 p-4 p-md-5 px-0 mb-4">
                <h1 class="display-4">Query<br>Manager</h1>
                <hr class="mb-2">
                <p class="lead my-3">Welcome student <?php echo $nom_utls . " " . $prn_utls; ?></p>
            </div>
            <div class="col-md-6 pt-4 px-4 d-flex flex-row-reverse">
                <img src="images/logo_UD-removebg-preview.png" alt="Douala University" height="250px">
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
                <button class="nav-link active" id="new-query-tab" data-bs-toggle="tab" data-bs-target="#new-query" type="button" role="tab" aria-controls="new-query" aria-selected="true">Create query</button>
                <button class="nav-link" id="old-queries-tab" data-bs-toggle="tab" data-bs-target="#old-queries" type="button" role="tab" aria-controls="old-queries" aria-selected="false">View old queries</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Inbox</button>
                <button class="btn btn-dark my-2 ms-auto mx-2" onclick="window.location='index.php'">Log out</button>
            </div>
        </nav>
        <div class="tab-content pb-4" id="nav-tabContent">
            <div class="tab-pane fade show active" id="new-query" role="tabpanel" aria-labelledby="new-query-tab">
                <div class="px-auto">
                    <div class="py-5 text-center">
                        <h2>Query Form</h2>
                        <p class="lead">Fill in this form to report any problem you have</p>
                        <?php
                        if (isset($_SESSION['QUERY_SUCCESS'])) {
                            if ($_SESSION['QUERY_SUCCESS']) {
                                echo '<div class="alert alert-success">You query has been successfully sent.</div>';
                            } else {
                                echo '<div class="alert alert-danger">Query not sent, an error occurs. Please try again later.</div>';
                            }
                            unset($_SESSION['QUERY_SUCCESS']);
                        }
                        ?>
                    </div>
                    <div class="px-4">
                        <form method="post" action="sauverReq.php" class="container row g-3 needs-validation" novalidate enctype="multipart/form-data">
                            <div class="col-md-4">
                                <label for="fname" class="form-label">First name: </label>
                                <input type="text" class="form-control" name="Prenom" readonly id="fname" <?php echo "value='" . $prn_utls . "'"; ?> />
                            </div>
                            <div class="col-md-4">
                                <label for="lname" class="form-label">Last name: </label>
                                <input type="text" class="form-control" name="Nom" readonly id="lname" <?php echo "value='" . $nom_utls . "'"; ?> />
                            </div>
                            <div class="col-md-4">
                                <label for="mtrl" class="form-label">Identifier: </label>
                                <input type="text" class="form-control" name="Matricule" readonly id="mtrl" <?php echo "value='" . $matr_utls . "'"; ?> />
                            </div>
                            <div class="col-md-6">
                                <label for="level" class="form-label">Level:</label>
                                <input type="text" class="form-control" name="Niveau" readonly id="level" <?php echo "value='" . $niv_utls . "'"; ?> />
                            </div>
                            <div class="col-md-6">
                                <label for="option" class="form-label">Option:</label>
                                <input type="text" class="form-control" name="option" readonly id="option" <?php echo "value='" . $fil_utls . "'"; ?> />
                            </div>
                            <div class="col-auto">
                                <label for="motif" class="form-label">Reason for the request</label>
                                <select name="motif" id="motif" class="form-select" required>
                                    <option value="" selected disabled>Choose ...</option>
                                    <option value="CC Note Missing">CC Note Missing</option>
                                    <option value="Exam Note Missing">Exam Note Missing</option>
                                    <option value="TP Note Missing">TP Note Missing</option>
                                    <option value="Request Transcript">Request Transcript</option>
                                    <option value="Request Certificate of Schooling">Request Certificate of Schooling</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid reason.
                                </div>
                                <div class="form-text">If you choose 'Other' you will have to clearly explain it in the description</div>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="Description" id="description" rows="5" cols="max" class="form-control" minlength="25" required></textarea>
                                <div class="invalid-feedback">
                                    You need to explain your problem clearly, at least 25 characters.
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label for="pj" class="form-label">Piece jointe</label>
                                <input type="file" name="PJ" id="pj" class="form-control" />
                                <?php
                                if (isset($_SESSION['FILE_NOT_UPLOADED'])) {
                                    echo '<div class="form-text text-danger">The file could not be upoloaded, an error occurs.</div>';
                                    unset($_SESSION['FILE_NOT_UPLOADED']);
                                } else if (isset($_SESSION['FILE_NOT_IMAGE'])) {
                                    echo '<div class="form-text text-danger">You can only send png, jpg or jpeg file.</div>';
                                    unset($_SESSION['FILE_NOT_IMAGE']);
                                } else {
                                    echo '<div class="form-text">If the resolution of your problem requires a proof, add it here</div>';
                                }
                                ?>

                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="old-queries" role="tabpanel" aria-labelledby="old-queries-tab">
                <div class="px-5">
                    <script type="text/javascript">
                        document.vlinkColor = "black";
                    </script>
                    <table class="table table-hover caption-top">
                        <caption>List of sent request</caption>
                        <thead>
                            <tr>
                                <th scope="col">Request</th>
                                <th scope="col">State</th>
                                <th scope="col">Observations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $cnx = new mysqli("localhost", "root", "", "base_ud");
                            if (!$cnx) {
                                die("Connexion impossible. " . mysqli_error($cnx));
                            } else {
                                $ligne = mysqli_query($cnx, "SELECT * FROM requetes WHERE Matr='$matr_utls' ORDER BY Date DESC");

                                while ($elts = mysqli_fetch_array($ligne)) {
                                    $d = $elts[7];
                                    if ($elts[8] == 'Untreated') {
                                        $couleur = 'table-warning';
                                    } else if ($elts[8] == 'Resolved') {
                                        $couleur = 'table-success fst-italic';
                                    } else if ($elts[8] == 'Rejected') {
                                        $couleur = 'table-danger';
                                    }


                                    echo "<tr class='$couleur'>";
                                    echo "<td>" .
                                        "<a class='text-decoration-none link-dark' href='' data-bs-toggle='modal' data-bs-target='#mod$i'>Request of $d</a>" .
                                        '<div class="modal fade" id="mod' . $i . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Request of ' . $d . '</h5>
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
                                            '<span>Joined document</span>' .
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
                                        </div>' .
                                        "</td>";
                                    echo "<td>$elts[8]</td>";
                                    echo "<td>$elts[9]</td>";

                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
        </div>
    </div>
    <div class="form-text px-4 row bg-dark">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top border-secondary">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <image src="images/logo_UD-removebg-preview.png" width="30" />
                </a>
                <span class="text-muted">&copy; 2021 Faculty of Sciences, Douala University</span>
            </div>

            <div class="nav col-md-4 justify-content-end d-flex">
                <div class="col-3">Contacts:</div>
                <div class="col-7">info@univ-douala.cm<br>facsciences@univ-douala.com </div>
            </div>
        </footer>
    </div>
    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>