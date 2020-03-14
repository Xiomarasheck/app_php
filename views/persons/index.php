<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/public/css/home.css">
</head>
<body>
<section class="principalBanner">
    <div class="contentLogin"
         style="background-image: url('/public/img/cropped-smiling-students.jpg')">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">App Prueba</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/processActions.php?controller=Cities&method=index">Ciudades <span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/processActions.php?controller=Persons&method=index">Personas</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="center">
            <div class="formRegister animated bounceInDown fast">
                <h1 class="titleForm">Personas</h1>
                <?php if(isset($errors) && count($errors)>=1) {?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $error) {?>
                            <strong>Danger!</strong> <?=$error?>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if(isset($message) && !empty($message)) {?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?=$message?>
                    </div>
                <?php } ?>

                <div class="pull-right">
                    <a class="btn btn-success btn-create" href="/processActions.php?controller=Persons&method=viewCreate">
                        Crear
                    </a>
                </div>
                <hr class="line">
                <div class="table-responsive">
                    <table class="table">
                        <caption>Lista</caption>
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Tipo Documento</th>
                            <th scope="col">Número Documento</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Ciudad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($allPersons) && count($allPersons)>=1) {?>
                            <?php foreach($allPersons as $person) {?>
                                <tr>
                                    <th scope="row"><?php echo $person->id; ?> </th>
                                    <td><?php echo $person->nombre; ?></td>
                                    <td><?php echo $person->apellido; ?></td>
                                    <td><?php echo $person->tipoDocumento; ?></td>
                                    <td><?php echo $person->numeroDocumento; ?></td>
                                    <td><?php echo $person->departamento; ?></td>
                                    <td><?php echo $person->ciudad; ?></td>
                                    <td>
                                        <a href="/processActions.php?controller=Persons&method=destroy&id=<?php echo $person->id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="/public/js/script.js"></script>
</html>