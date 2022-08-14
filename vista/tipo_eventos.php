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
                <li class="nav-item active">
                    <a class="nav-link" href="compras.php"><i class="fas fa-eye"></i>Compras</a>
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
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Tipo de eventos</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#myModal'>Crear evento</button>
        </div>
        <br>
        <hr>
        <div class="table-respon">
            <table id="tablaTipoEventos" class="table compact bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de evento</th>
                        <th>Duracion</th>
                        <th>Precio</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <hr>
        <h1 class="text-center p-2 text-primary">Tipo de tareas</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#modalAgregarTarea'>Crear tarea</button>
        </div>
        <br>
        <div class="table-responsive">
            <table id="tablaTareas" class="table table-sm bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tarea</th>
                        <th>Precio</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL PARA CREAR TIPO EVENTO -->
    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Nueva tipo evento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="formAddTipoEvento" autocomplete="off">
                        <div class="row">
                            <div class="col-7 form-group">
                                <label for="">Nombre evento</label>
                                <input type="text" id="addNomTipoEvento" class="form-control" required>
                            </div>
                            <div class="col-5 form-group">
                                <label for="">Precio evento</label>
                                <input type="text" id="addPrecioTipoEvento" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="">Cantidad da horas</label>
                                <input type="time" id="addTiempoTipoEvento" class="form-control" required>
                            </div>
                        </div>
                        <div class="border bg-light p-2" id="conTareas"></div>
                        <hr>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Crear">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR TIPO EVENTO -->
    <div class="modal fade" id="modalEliminarTipoEvento" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar tipo de evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDeletTipoEvento">
                        <span class="d-none" id="idDeletTipoEvento"></span>
                        <p>¿Usted esta seguro que desea eliminar el tipo de evento <strong id="nomDeletTipoEvento"></strong>?</p>
                        <br>
                        <span class="text-danger">* Solo se podra eliminar si no existe ningun registro de reserva asignada al tipo de evento</span>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR TIPO DE VENTO -->
    <div class="modal fade" id="modalEditarTipoEvento" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar tipo evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEditTipoEvento">
                        <span class="d-none" id="idEditTipoEvento"></span>
                        <div class="row">
                            <div class="col-7 form-group">
                                <label for="">Nombre evento</label>
                                <input type="text" id="editNomTipoEvento" class="form-control" required>
                            </div>
                            <div class="col-5 form-group">
                                <label for="">Precio evento</label>
                                <input type="text" id="editPrecioTipoEvento" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                <label for="">Cantidad da horas</label>
                                <input type="time" id="editTiempoTipoEvento" class="form-control" required>
                            </div>
                        </div>
                        <div class="border bg-light p-2" id="conEditTareas"></div>
                        <hr>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA AGREGAR TAREA-->
    <div class="modal fade" id="modalAgregarTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Agregar tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddTarea">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Tarea</label>
                                <input type="text" id="addNomTarea" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label for="">Precio</label>
                                <input type="text" id="addPrecioTarea" class="form-control">
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Agregar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR TAREA -->
    <div class="modal fade" id="modalEliminarTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDeletTarea">
                        <span class="d-none" id="idDeletTarea"></span>
                        <p>¿Usted esta seguro que desea eliminar la tarea <strong id="nomDeletTarea"></strong>?</p>
                        <br>
                        <span class="text-danger">* Solo se podra eliminar si no existe ningun evento con la respectiva tarea</span>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR TAREA -->
    <div class="modal fade" id="modalEditTarea" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEditTarea">
                    <span class="d-none" id="idEditTarea"></span>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Tarea</label>
                                <input type="text" id="editNomTarea" class="form-control" required>
                            </div>
                            <div class="form-group col-4">
                                <label for="">Precio</label>
                                <input type="text" id="editPrecioTarea" class="form-control" required>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/tipo_eventos.js"></script>
</html>