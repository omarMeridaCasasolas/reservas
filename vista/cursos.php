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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Productos</title>
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
        /* #addAlumnosCurso{
            font-size:10px;
        } */
        .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-selection__choice {
            font-size: 12px;
        }

        ul.select2-results__options li{
            font-size:12px;
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
                <li class="nav-item">
                    <a class="nav-link" href="cReserva.php">Reserva</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php"> Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reportes.php">Reportes - Libro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="clientes.php">Clientes</a>
                </li>
                <?php
                if($_SESSION['tipo_empleado'] == 'Administrador' || $_SESSION['tipo_empleado'] == 'Tecnico'){
                    echo '<li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="compras.php">Compras</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="cursos.php"><i class="fas fa-eye"></i>Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pagoCurso.php"></i>Pagos curso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="alumnos.php">Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="empleado.php">Empleado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tipo_eventos.php">Tipo evento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="proveedor.php"></i> Proveedor</a>
                </li>
                <li class="nav-item">
                    <a href="../controlador/formCerrarSession.php" class="btn btn-danger" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
                </li>';
                ;}?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Lista de cursos</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#myModal'>Crear curso</button>
        </div>
        <br>
        <hr>
        <div class="table-responsive">
            <table id="tablaCurso" class="table compact bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Profesor</th>
                        <th>Inicio</th>
                        <th>Horario</th>
                        <th>Alumnos</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL PARA AGREAGAR CURSO-->
    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Nueva Curso - Grupo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="formAddCurso" autocomplete="off">
                        <div id="mensajeProveedor"></div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="">Nombre</label>
                                <input type="text" name="addNombreCurso" id="addNombreCurso" class="form-control">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="">Precio curso</label>
                                <!-- <input type="text" id="addPrecioCurso" class="form-control"> -->
                                <input type="number" min="0.01" value="0.01" max="10000.00" step="0.01" id="addPrecioCurso" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Profesor</label>
                                <input type="text" name="addProfesorCurso" id="addProfesorCurso" class="form-control">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Grupo</label>
                                <input type="text" name="addGrupoCurso" id="addGrupoCurso" class="form-control" placeholder="que tipo de dato">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Horario (Entrada)</label>
                                <input type="time" name="addTurnoEntrada" id="addTurnoEntrada" class="form-control" required step="1800" value="09:00">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Horario (Salida)</label>
                                <input type="time" name="addTurnoSalida" id="addTurnoSalida" class="form-control" required step="1800" value="09:30" min="09:30">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Fecha (Entrada)</label>
                                <input type="date" name="addFechaEntrada" id="addFechaEntrada" class="form-control" value="<?php echo date('Y-m-d');?>" required min="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Fecha (Salida)</label>
                                <input type="date" name="addFechaSalida" id="addFechaSalida" class="form-control" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 day')); ?>" required min="<?php date('Y-m-d');?>">
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-sm-12" id="cajaFechasSemana">
                                <p>Fechas de practica</p>
                                <div class="form-check">
                                    <label class="form-check-label" for="check1">
                                        <input type="checkbox" class="form-check-input" id="check1" name="option1" value="something">Lunes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check2">
                                        <input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">Martes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check3">
                                        <input type="checkbox" class="form-check-input" id="check3" name="option1" value="something">Miercoles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check4">
                                        <input type="checkbox" class="form-check-input" id="check4" name="option2" value="something">Jueves
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check5">
                                        <input type="checkbox" class="form-check-input" id="check5" name="option1" value="something">Viernes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check6">
                                        <input type="checkbox" class="form-check-input" id="check6" name="option2" value="something">Sabado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check7">
                                        <input type="checkbox" class="form-check-input" id="check7" name="option1" value="something">Domingo
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="col-sm-7">
                                <label for="">Alumnos Inscritos</label>
                                <select class="my-2" id="addAlumnosCurso" name='addAlumnosCurso[]' style="width:100%;" multiple="multiple">
                                </select>
                            </div> -->
                        </div>

                        <hr>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" id="subAddPedido" value="Crear">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR CURSO-->
    <div class="modal fade" id="modalEditarCurso" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title">Editar curso</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="formEditCurso" autocomplete="off">
                        <span id="idEditCurso" class="d-none"></span>
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="">Nombre</label>
                                <input type="text" id="editNombreCurso" class="form-control">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="">Precio curso</label>
                                <!-- <input type="text" id="addPrecioCurso" class="form-control"> -->
                                <input type="number" min="0.01" value="0.01" max="10000.00" step="0.01" id="editPrecioCurso" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Profesor</label>
                                <input type="text" id="editProfesorCurso" class="form-control" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Grupo</label>
                                <input type="text" id="editGrupoCurso" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Horario (Entrada)</label>
                                <input type="time" id="editTurnoEntrada" class="form-control" required step="1800" value="09:00">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Horario (Salida)</label>
                                <input type="time" id="editTurnoSalida" class="form-control" required step="1800" value="09:30" min="09:30">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Fecha (Entrada)</label>
                                <input type="date"  id="editFechaEntrada" class="form-control" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Fecha (Salida)</label>
                                <input type="date" id="editFechaSalida" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">       
                            <div class="col-sm-12" id="cajaEditFechasSemana">
                                <p>Fechas de practica</p>
                                <div class="form-check">
                                    <label class="form-check-label" for="check1">
                                        <input type="checkbox" class="form-check-input" id="check1" name="option1" value="something">Lunes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check2">
                                        <input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">Martes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check3">
                                        <input type="checkbox" class="form-check-input" id="check3" name="option1" value="something">Miercoles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check4">
                                        <input type="checkbox" class="form-check-input" id="check4" name="option2" value="something">Jueves
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check5">
                                        <input type="checkbox" class="form-check-input" id="check5" name="option1" value="something">Viernes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check6">
                                        <input type="checkbox" class="form-check-input" id="check6" name="option2" value="something">Sabado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="check7">
                                        <input type="checkbox" class="form-check-input" id="check7" name="option1" value="something">Domingo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR CURSO-->
    <div class="modal fade" id="modalEliminarCurso" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDeletCurso">
                        <span class="d-none" id="idDeletCurso"></span>
                        <p>¿Usted esta seguro que desea eliminar el curso-grupo <strong id="nomDeletCurso"></strong>?</p>
                        <br>
                        <span class="text-danger">* Solo se podra eliminar si no existe ningun alimno registado el grupo-curso</span>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA AGREGAR ELIMINAR ALUMNOS CURSO-->
    <div class="modal fade" id="modalAlumnos" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Alumnos inscrito</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEdicionAlumnos">
                        <select id="listaAlumnosInscritos" name='listaAlumnosInscritos' style="width:100%;" multiple ></select>
                        <br>
                        <br>
                        <span id="editAlumnoCurso" class='d-none'></span>
                        <div class="form-group row p-1">
                            <div class="col-sm-6 form-group" >
                                <label for="" class="text-danger">Alumnos inscritos</label>
                                <div id="cajaAlumnosNuevos" style="font-size: 13px;"></div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="" class="text-danger">Alumnos eliminados</label>
                                <div id="cajaAlumnosEliminados" style="font-size: 13px;"></div>
                            </div>
                        </div>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> -->
<!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/cursos.js"></script>
</html>