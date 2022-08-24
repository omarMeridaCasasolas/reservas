<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:../index.php");
        exit();
    }
?>
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
        <!-- Brand -->
        <a class="navbar-brand" href="#"><?php echo $_SESSION['usuario'];?></a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav p-2">
                <li class="nav-item active">
                    <a class="nav-link" href="cReserva.php"><i class="fas fa-eye"></i> Reserva</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reportes.php">Reportes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">Clientes</a>
                </li>
                <?php
                if($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico'){
                    echo '<li class="nav-item">
                    <a class="nav-link" href="productos.php"> Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="compras.php">Compras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cursos.php">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="alumnos.php">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="empleado.php">Empleado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="proveedor.php"></i> Proveedor</a>
                </li>';
                }?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-5 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2">Reservas</h1>
        <div class="row">
            <div class="col-sm-8 form-group">
                <input type="date" name="" id="fechaReserva" class="form-control" min="2022-07-29" max="2022-08-29" value=<?php echo date('Y-m-d');?>>
            </div>
            <div class="col-sm-4 form-group" id="cajaIntervalo">
                <h6>Vista en intervalos:</h6>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="radioIntervalo" value="60" checked>60 minutos
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="radioIntervalo" value="30">30 minutos
                    </label>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center" id="myTable">
                <thead>
                    <tr>
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
    <!-- MODAL PARA RESERVAR  -->
    <div class="modal fade" id="modalDisponble" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Reservar cancha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="idReservaActual" class="d-none"></span>
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Fecha: <strong id="detalleFecha"></strong></span>
                        </div>
                        <div class="col-sm-6">
                            <span>Dia: <strong id="detalleDia"></strong></span>
                        </div>
                        <div class="col-sm-6">
                            <span>Hora Inicio: <strong id="detalleHora"></strong></span>
                        </div>
                        <div class="col-sm-6">
                            <span>Precio 30min: <strong id="detallePrecio"></strong></span>
                        </div>
                    </div>
                    <hr>
                    <form action="" id="formReservar">
                        <div class="form-group">
                            <label for="">Tipo de reserva</label>
                            <select name="" id="tipoReserva" class="form-control">
                                <option value="Juego Deportivo">Juego Deportivo</option>
                                <option value="Evento">Evento</option>
                            </select>
                        </div>
                        <select name="" id="nombreCliente" style="width:100%" required></select>
                        <br>
                        <div id="cajaListaEvento" class="d-none">
                            <br>
                            <select name="" id="nombreEventoModelo" style="width:100%" required></select>
                            <br>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Hora limite</label>
                                <select name="hrLimiteReserva" id="hrLimiteReserva" class="form-control"></select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Costo:</label>
                                <input type="text" id="precioCostoReserva" class="form-control" value="170">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Pago digital</label>
                                <input type="number" value="0" id="pagoDigital" class="form-control pagos">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Pago efectivo</label>
                                <input type="number" value="0" id="pagoEfectivo" class="form-control pagos">
                            </div>
                        </div>
                        <div class="text-right">
                            <strong>Total <span id="pagoDepositado">X</span></strong>
                        </div> 
                        <div class="text-center">
                            <input type="submit" value="Reservar" class="btn btn-primary">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/cReserva.js"></script>
</html>