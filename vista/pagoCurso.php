<?php
    session_start();
    date_default_timezone_set('America/La_Paz');
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
            font-family: '-apple-system','BlinkMacSystemFont','Poppins', sans-serif; 
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
                    <a class="nav-link" href="cReserva.php"> Reserva</a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="pagoCurso.php"><i class="fas fa-eye"></i>Pagos curso</a>
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
    <main class="container border shadow p-2 mb-4 mx-auto my-2 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Pago por curso</h1>
        <div class="row mx-auto">
            <div class="mx-auto">
                <select name="" id="selectGrupo"></select>
            </div>
        </div>
        <br>
        <hr>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#modalAgregarAlumnoCurso'>Inscribir alumno</button>
        </div>
        <br>
        <div class="table-responsive" id="contTabla">
            <table class="table table-sm table-bordered text-center" id="myTable">
                <thead>
                    <tr class="bg-dark text-white">
                        <!-- <th>Nombre</th>
                        <th>1er mes</th>
                        <th>2do mes</th>
                        <th>3er Mes</th>
                        <th>4to mes</th>
                        <th>opciones</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL PARA AGREGAR ALUMNO CURSO  -->
    <div class="modal fade" id="modalAgregarAlumnoCurso" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Inscribir alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddAlumnoGrupo">
                        <div>
                            <label for="">Selecione alumno</label>
                            <select name="" id="listasAddAlumno" style="width:100%;" required></select>
                        </div>
                        <br>
                        <div class='row'>
                            <div class="form-group col-sm-7">
                                <label for="">Grupo</label>
                                <select name="" id="listasAddGrupo" required class='form-control'></select>
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="">Inscripcion</label>
                                <input type="date" name="" required id="fechaAddInscripcion" class='form-control' disabled value="<?php echo date('Y-m-d');?>">
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-6 form-group">
                                <label for="">Pago efectivo</label>
                                <input type="number" name="" id="pagoAddEfectico" class="form-control pagoAdd" value='0.00' required >
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Pago digital</label>
                                <input type="number" name="" id="pagoAddDigital" class="form-control pagoAdd" value='0.00' required >
                            </div>
                        </div>
                        <strong>Pago Total: <span id="totalPagadoInscripcion"></span></strong>
                        <br>
                        <div class="text-center">
                            <input type="submit" value="Agreagr" class="btn btn-primary">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR RESERVA  -->
    <div class="modal fade" id="modalPagoEstudiante" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info" id="headerEditar">
                    <h5 class="modal-title">Pago estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="idCursoAlumno" class="d-none"></span>
                    <div class="row">
                        <div class="col-sm-8">
                            <span>Nombre: <strong id="detalleNombre"></strong></span>
                        </div>
                        <div class="col-sm-4">
                            <span>Precio: <strong id="precioCursoMes"></strong></span>
                        </div>
                        <div class="col-sm-8">
                            <span>Fecha Inscripcion: <strong id="fechaInscripcionGrupo"></strong></span>
                        </div>
                        <div class="col-sm-4">
                            <span>Pago: <strong id="detallePagoTotal"></strong></span>
                        </div>
                    </div>
                    <br>
                    <h6 class='text-danger text-center'>Pagos realizados</h6>
                    <div class="cajaRegistroPagos" class='table-responsive'>
                        <table class='table compact bordered' id='tablaPagosAlumno'>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Digital</th>
                                    <th>Efectivo</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <form id="formReservarEdit">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label for="">Pago Efectivo</label>
                                <input type="number" name="" id="pagoAlumnoEfectivo" class='form-control pagoAlumno' required>
                            </div>
                            <div class="col-6 form-group">
                                <label for="">Pago digital(qr) </label>
                                <input type="number" name="" id="pagoAlumnoDigital" class='form-control pagoAlumno' required>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Actualizar" class="btn btn-primary">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>          

    <!-- MODAL PARA ELIMINAR ALUMNO -->
    <div class="modal fade" id="modalEliminarAlumnoGrupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar alumno del curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="idDeletGestion" class="d-none"></span> 
                    <!-- <span id="idDeletAlumno" class="d-none"></span> -->
                    <form id="formDeleteAlumnoGrupo">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="" id="msjConfirmacion"> ¿Usted esta seguro de querer eliminar al alumno
                                <strong id='delNombreAlumno'></strong> del grupo-curso de <strong id='delNombreGrupo'></strong>? 
                            </label>
                        </div>
                        <br>
                        <!-- <p>¿Usted esta deacuerdo con disponer este horario para una futura reserva? </p> -->
                        <div class="text-center">
                            <input type="submit" value="Eliminar" class="btn btn-primary">
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

<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/pagoCurso.js"></script>
</html>