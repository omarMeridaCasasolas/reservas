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
    <title>Empleado</title>
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
                    <a class="nav-link" href="ventas.php">Ventas</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="compras.php">Compras</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="alumnos.php"><i class="fas fa-eye"></i> Alumnos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="empleado.php"> Empleado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="proveedor.php">Proveedor</a>
                </li>';
                }?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Lista de alumnos</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#modalAgregarProveedor'>Crear alumno</button>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="tablaAlumno" class="table compact bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Carnet</th>
                        <th>Responsable</th>
                        <th>Celular</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL PARA ELIMINAR PROVEEDOR -->
    <div class="modal fade" id="modalEliminarProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDeletProveedor">
                        <span class="d-none" id="idDeletAlumno"></span>
                        <p>¿Usted esta seguro que desea eliminar al alumno <strong id="nomDeletAlumno"></strong>?</p>
                        <br>
                        <span class="text-danger">* Solo se podra eliminar si no existe ningun registro de compra relacionado al proveedor</span>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA EDITAR PROVEEDORES -->
    <div class="modal fade" id="modalEditarProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEditProveedor">
                        <span class="d-none" id="idEditProveedor"></span>
                        <div class="row">
                            <div class="col-sm-7">
                                <label for="">Nombre:</label>
                                <input type="text" name="nomEditProveedor" id="nomEditProveedor" class="form-control" required>
                            </div>
                            <div class="col-sm-5">
                                <label for="">Telefono:</label>
                                <input type="text" name="telEditProveedor" id="telEditProveedor" class="form-control" required>
                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Detalle:</label>
                            <input type="text" name="detalleEditProveedor" id="detalleEditProveedor" class="form-control">
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
    
    <!-- MODAL PARA AGREGAR PROVEEDOR-->
    <div class="modal fade" id="modalAgregarProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Agregar empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddProveedor">
                        <div class="row">
                            <div class="col-sm-7">
                                <label for="">Nombre:</label>
                                <input type="text" name="nomAddProveedor" id="nomAddProveedor" class="form-control" required>
                            </div>
                            <div class="col-sm-5">
                                <label for="">Telefono:</label>
                                <input type="text" name="telAddProveedor" id="telAddProveedor" class="form-control" required>
                            </div>
                            <br>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="">Detalle:</label>
                            <input type="text" name="detalleAddProveedor" id="detalleAddProveedor" class="form-control">
                        </div>
                        <!-- <div class="row">
                            
                        </div> -->
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Agregar">
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/alumnos.js"></script>
</html>