<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
                        <a class="nav-link" href="/processActions.php?controller=Cities&method=index">Ciudades <span
                                    class="sr-only"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/processActions.php?controller=Persons&method=index">Personas</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="center">
            <form class="formRegister animated bounceInDown fast"
                  action="/processActions.php?controller=persons&method=create" method="post">
                <h3 class="titleForm">Crear Ciudad</h3>
                <hr class="line">
                <?php if (isset($errors) && count($errors) >= 1) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) { ?>
                            <strong>Danger!</strong> <?= $error ?>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if (isset($message) && !empty($message)) { ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?= $message ?>
                    </div>
                <?php } ?>


                <div class="form-group">
                    <label for="descripcion">Nombre</label>
                    <input type="text" required="required" class="form-control" name="name" id="name"
                           aria-describedby="emailHelp" placeholder="Nombre">
                </div>

                <div class="form-group">
                    <label for="descripcion">Apellido</label>
                    <input type="text" required="required" class="form-control" name="last_name" id="last_name"
                           aria-describedby="emailHelp" placeholder="Apellido">
                </div>

                <div class="form-group">
                    <label>Tipo Documento</label>
                    <select id="type_document" class="form-control m-b" required="required" name="type_document">
                        <option value="" selected="selected">Tipo...</option>
                        <?php if (isset($allTypes) && count($allTypes) >= 1) { ?>
                            <?php foreach ($allTypes as $type) { ?>
                                <option value="<?php echo $type->id; ?>"><?php echo $type->descripcion; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion">Número Documento</label>
                    <input type="number" required="required" class="form-control" name="num_document" id="num_document"
                           aria-describedby="emailHelp" placeholder="Número Documento">
                </div>

                <div class="form-group">
                    <label>Ciudad</label>
                    <select id="city" class="form-control m-b" required="required" name="id_city">
                        <option value="" selected="selected">Ciudad...</option>
                        <?php if (isset($allCities) && count($allCities) >= 1) { ?>
                            <?php foreach ($allCities as $city) { ?>
                                <option value="<?php echo $city->id; ?>"><?php echo $city->descripcion; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
</section>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="/public/js/script.js"></script>
</html>