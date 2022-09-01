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
    <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        .carousel-inner img {
            width: 100%;
            height: 100%;
        }
        td:nth-child(2) {
            background: #efefef;
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
            <li class="nav-item active border border-top-0 border-left-0 border-right-0">
                <a class="nav-link border border-top-0 border-left-0 border-right-0" href="reserva.php">Reserva</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="snack.php">Snack</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="evento.php">Eventos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="acceso.php">Acceso</a>
            </li>
        </ul>
    </nav>
    <main class="container border">
        <h1 class="text-center p-5">Reservas</h1>
        <div class="form-group">
            <input type="date" name="" id="fechaReserva" class="form-control" value=<?php echo date('Y-m-d');?>>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center" id="myTable">
                <thead>
                    <tr class='bg-dark text-white'>
                        <th>Horario</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sabado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL -->
    <div class="modal fade" id="modalNoDisponble" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">No disponnible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>No se puede reservar la cancha,ya esta fuera del rango de atencion gracias</h6> 
                    <h6>Lunes - Viernes => 9:00 a 23:00</h6> 
                    <h6>Sabado => 9:00 a 20:00</h6> 
                    <h6>Lunes - Viernes => 9:00 a 14:00</h6> 
                    <h3 class="text-center bg-light"><i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDisponble" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="modalDisponble">Disponnible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Posible, para ser la reserva comunicarse a los siguientes contactos, gracias</h6> 
                    <h6><i class="fas fa-mail-bulk"></i>&nbsp Correo electronico: <a href="mailto:gerencia@nexxo.com.bo">gerencia@nexxo.com.bo</a>
                    <h6><i class="fas fa-search-location"></i>&nbsp Direccion: Av. Uyuni 731 Esquina, Cochabamba</h6> 
                    <h6><i class="fab fa-whatsapp"></i>&nbsp Whatsapp 69416450: <a href="https://wa.me/+59169416450?text=Me%20interesa%20reservar%20la%20cancha%20" target="_blank" rel="noopener noreferrer">Enviar mensaje</a></h6> 
                    <h3 class="text-center bg-light"><i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalReservado" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Reservado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Lo sentimos la cancha ya esta reservada, por favor seleciona otra fecha o contactese con:</h6> 
                    <h6><i class="fas fa-mail-bulk"></i>&nbsp Correo electronico: <a href="mailto:gerencia@nexxo.com.bo">gerencia@nexxo.com.bo</a>
                    <h6><i class="fas fa-search-location"></i>&nbsp Direccion: Av. Uyuni 731 Esquina, Cochabamba</h6> 
                    <h6><i class="fab fa-whatsapp"></i>&nbsp Whatsapp 69416450: <a href="https://wa.me/+59169416450?text=Me%20interesa%20reservar%20la%20cancha%20" target="_blank" rel="noopener noreferrer">Enviar mensaje</a></h6> 
                    <h3 class="text-center bg-light"><i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i>&nbsp&nbsp<i class="fas fa-smile"></i></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

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
<script src="js/reserva.js"></script>
</html>