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
                            <a class="nav-link" href="/processActions.php?controller=Cities&method=index">Ciudades <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/processActions.php?controller=Persons&method=index">Personas</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="center">
                <form class="formRegister animated bounceInDown fast" action="/processActions.php?controller=cities&method=edit" method="post">
                    <h3 class="titleForm">Editar Ciudad</h3>
                    <hr class="line">
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

                    <div class="form-group">
                        <label>Departamento</label>
                        <select id="id_departamento" class="form-control m-b" required="required" name="id_departamento" disabled>
                            <?php if(isset($department)) {?>
                                <option value="<?php echo $department->id; ?>"><?php echo $department->descripcion; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Ciudad</label>
                        <input type="text" required="required" value="<?=$city->descripcion?>" class="form-control" name="descripcion" id="descripcion" placeholder="Nombre Ciudad">
                    </div>

                    <div class="form-group">
                        <input type="hidden"  value="<?=$city->id?>" class="form-control" name="id" id="id" required="required">
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