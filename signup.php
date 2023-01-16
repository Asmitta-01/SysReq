<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Harold">
    <title>Create new account - Query Manager</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link href="css/signin.css" rel="stylesheet">
    <style>
        .offset-md-3 {
            margin-left: 25%;
        }
    </style>
    <script src='js/jquery.js'></script>
</head>

<body>
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="images/logo_UD-removebg-preview.png" height="120">
                <h2>Signing Up</h2>
                <p class="lead">Create your account to be able to send queries.</p>
            </div>
            <form action="registerStudent.php" method="post">
                <div class="col-md-6 offset-md-3">
                    <div class="row gx-5">
                        <div class="col">
                            <label for="nom" class="form-label">Last name: </label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>
                        <div class="col">
                            <label for="nom" class="form-label">First name: </label>
                            <input type="text" name="prenom" id="prenom" class="form-control">
                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col">
                            <label for="level" class="form-label">Level:</label>
                            <select name="niveau" id="level" class="form-select">
                                <option value="None" selected>Choose your level</option>
                                <option value="Licence 1">Licence 1</option>
                                <option value="Licence 2">Licence 2</option>
                                <option value="Licence 3">Licence 3</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="option" class="form-label">Option:</label>
                            <select name="filiere" id="option" class="form-select">
                                <option value="Informatique">Informatique</option>
                                <option value="Mathematiques">Mathematiques</option>
                                <option value="Biologie">Biologie</option>
                                <option value="Physique">Physique</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gx-5 px-4">
                        <input type="submit" value="Create" class="btn btn-primary btn-lg mt-3">
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>

</html>