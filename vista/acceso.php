<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>Reserva de cancha</title>
    <style>
        body{
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            line-height: 24px;
            font-weight: 400;
            color: #212112;
            background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat-back.svg');
            background-position: center;
            background-repeat: repeat;
            background-size: 7%;
            /* background-size: 17%; */
            background-color: #fff;
            overflow-x: hidden;
            transition: all 200ms linear;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <ul class="navbar-nav p-2">
            <li class="nav-item">
                <a class="nav-link" href="#">Bienvenido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vista/reserva.php">Reserva</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vista/snack.php">Snack</a>
            </li>
            <li class="nav-item active border border-top-0 border-left-0 border-right-0">
                <a class="nav-link border border-top-0 border-left-0 border-right-0" href="vista/acceso.php">Acceso</a>
            </li>
        </ul>
    </nav>
    <main class="col-xl-4 col-lg-7 col-md-8 col-sm-12 border shadow p-4 mb-4 mx-auto my-5 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2">Acceso al sistema</h1>
        <div class="row">
            <div class="col-xl-8 col-lg-10 col-xs-6 text-center my-2 mx-auto px-5">
                <img src="src/logo.png" alt="logo de la empresa" srcset="logo de la empresa" width="80%">
            </div>
        </div>
        
        <form id="signForm" class="was-validated">
            <div class="mb-3">
                <label for="validationUsuario">Usuario</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-dark" id="inputGroupPrepend3"><i class="fas fa-mail-bulk"></i></span>
                    </div>
                    <input type="email" class="form-control" id="validationUsuario" name="validationUsuario" placeholder="Usuario" aria-describedby="inputGroupPrepend3" pattern="{7,25}" required>
                    <div class="valid-feedback">Valido</div>
                    <div class="invalid-feedback">Por favor escriba su correo electronico.</div>
                </div>
            </div>
            <div class="mb-3">
                <label for="validarPass">Contraseña</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-dark" id="inputGroupPrepend4"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" class="form-control" id="validarPass" name="validarPass" placeholder="Contraseña" aria-describedby="inputGroupPrepend4" pattern="[a-zA-Z0-9Ñn]{4,15}" required>
                    <div class="valid-feedback">Valido</div>
                    <div class="invalid-feedback">Por favor escriba su contraseña.</div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
                </div>

                <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-block mb-4" value="Ingreso">
            <!-- <button type="button" class="btn btn-success btn-block mb-4">Ingreso</button> -->
        </form>
    </main>
    <!-- Footer -->
    <footer class="page-footer font-small teal pt-4">
        <!-- Footer Text -->
        <div class="container-fluid text-center text-md-left">
        <!-- Grid row -->
            <div class="row bg-primary text-white">
                <!-- Grid column -->
                <div class="col-md-6 mt-md-0 mt-3 p-5">
                    <!-- Content -->
                    <h5 class="text-uppercase font-weight-bold">Contactos</h5>
                    <div class="row">
                        Ubicacion: Juan de la rosa y america #14521
                    </div>
                    <div class="row">
                        Telefono: +591 78221414
                    </div>
                    <div class="row">
                        Correo: micancha@gamilc.om
                    </div>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none pb-3">
                <!-- Grid column -->
                <div class="col-md-6 mb-md-0 mb-3 p-5">
                    <!-- Content -->
                    <h5 class="text-uppercase font-weight-bold">¿Quienes Somos?</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio deserunt fuga perferendis modi earum
                        commodi aperiam temporibus quod nulla nesciunt aliquid debitis ullam omnis quos ipsam, aspernatur id
                        excepturi hic.
                    </p>
                </div>
                <!-- Grid column -->
            </div>
        <!-- Grid row -->
        </div>
        <!-- Footer Text -->
    </footer>
    <!-- Footer -->
</body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/acceso.js"></script>
</html>