<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <style>
        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
    </style>
    <title>Reserva de cancha</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <ul class="navbar-nav p-2">
            <li class="nav-item">
                <a class="nav-link " href="../index.php">Bienvenido</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reserva.php">Reserva</a>
            </li>
            <li class="nav-item active border border-top-0 border-left-0 border-right-0">
                <a class="nav-link border border-top-0 border-left-0 border-right-0" href="snack.php">Snack</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="evento.php">Eventos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="acceso.php">Acceso</a>
            </li>
        </ul>
    </nav>
    <main class="container border shadow p-4 mb-4 bg-light">
        <h1 class="text-center p-2 text-danger">Snack</h1>
        <div class="col-xl-7 col-lg-9 col-md-10 mx-auto">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="">Nombre producto</label>
                    <input type="text" name="buscadorSnack" id="buscadorSnack" class="form-control" placeholder='Escribe nombre del producto'>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center" id="cajaSnack">
            <!-- <div class="col-sm-4 mb-3 d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body p-2">
                        <h6 class="my-1">Nombre: <strong id="stockNombre"></strong></h6>
                        <h6 class="my-1">Descripcion: <strong id="stockDescripcion"></strong></h6>
                        <h6 class="my-1">Precio: <strong id="stockPrecio"></strong></h6>
                        <h6 class="my-1">Cantidad: <strong id="stockCantidad"></strong></h6>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-sm-4 mb-3 d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3 d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="src/prueba.svg" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div> -->
        </div>
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
                    <br>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12807.713804295758!2d-66.14294054297238!3d-17.37546562191324!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xeec53f8cbc955985!2sSoccer%20Club!5e0!3m2!1sen!2sbo!4v1659403541154!5m2!1sen!2sbo" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <!-- Grid column -->
                <hr class="clearfix w-100 d-md-none pb-2">
                <!-- Grid column -->
                <div class="col-md-6 mb-md-0 mb-3 p-3">
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
<script src="js/snack.js"></script>
</html>