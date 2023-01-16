<!DOCTYPE html>
<?php

use Symfony\Component\Yaml\Yaml;

if (session_status() == PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}

// $document = Yaml::parseFile('/lang/index.fr.yml');
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Harold">
    <title>Log in - Query Manager</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link href="css/signin.css" rel="stylesheet">
    <script src='js/jquery.js'></script>
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="post" action="verificationId.php" class="needs-validation" novalidate>
            <img class="mb-4" src="images/logo_UD.jpg" alt="" height="100">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="d-block">
                <div class="form-floating">
                    <input class="form-control" id="floatingInput" type="text" name="Matricule" required maxlength="8" minlength="8" pattern="^[0-9][0-9][A-Z]+[0-9]{5,}$">
                    <label for="floatingInput">Register</label>
                    <div class="invalid-feedback fst-italic">It must be 08 characters.</div>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="PIN" required maxlength="5" pattern="[0-9][0-9][0-9][0-9][0-9]">
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback fst-italic">It must be 05 digits.</div>
                </div>
                <?php
                if (isset($_GET['type']) && htmlspecialchars($_GET['type'] == 'etu')) {
                    echo "<div class=\"alert alert-danger form-text fw-light\">"
                        . "Matricule ou Pin erroné.\n Veuillez entrer des valeurs enregistrées."
                        . "</div>";
                }
                ?>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in as student</button>
                <button class="w-100 mt-2 btn btn-lg btn-outline-dark" type="button">I'm a professor</button>
                <div class="form-text mt-4">New student? Create your account <a href="signup.php" class="text-danger">here</a></div>
            </div>
            <div class="d-none">
                <div class="form-floating">
                    <input class="form-control" id="floatingInput" type="text" name="ID" maxlength="6">
                    <label for="floatingInput">Identifier</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" name="Mdp">
                    <label for="floatingPassword">Password</label>
                </div>
                <?php
                if (isset($_GET['type']) && htmlspecialchars($_GET['type'] == 'etu')) {
                    echo "<div class=\"alert alert-danger form-text fw-light\">"
                        . "Identifier or password incorrect. Retry with good parameters."
                        . "</div>";
                }
                ?>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in as professor</button>
                <a href="index.php"><button class="w-100 mt-2 btn btn-lg btn-outline-dark" type="button">I'm a student</button></a>
            </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>

    <script>
        $('.d-block > .btn-outline-dark').click(function() {
            $(this).parent().siblings('.d-none > input').attr('required', 'required');
            $(this).parent().siblings('.d-none').addClass('d-block');
            $(this).parent().siblings('.d-none').removeClass('d-none');

            $(this).parent().remove();

        });

        window.addEventListener('load', function() {
            const url = window.location;
            const url_new = url.href.split('?')[0]

            history.pushState({}, '', url_new)
        })

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