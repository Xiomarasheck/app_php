<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ingreso</title>

        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
        <!--Styles-->
        <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    </head>
    <body>
        <section class="principalBanner">
            <div class="contentLogin" style="background-image: url('public/img/cropped-smiling-students.jpg')">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">App Prueba</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Ingresa</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="center">
                    <form class="formLogin animated bounceInDown fast" action="processActions.php?controller=Login&method=validateLogin" method="post">
                        <div class="loginContent">
                            <h1 class="titleForm">Login</h1>
                            <hr class="line">
                            <div class="form-group">
                                <label for="namePerson">Nombre Persona</label>
                                <input type="text" required="required" class="form-control" name="namePerson" id="namePerson" placeholder="Ingresa tu nombre para ingresar">
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>

    <!-- Bootstrap CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!--Script JS    -->
    <script src="public/js/script.js"></script>
</html>