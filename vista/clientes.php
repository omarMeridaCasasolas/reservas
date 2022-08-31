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
    <title>Clientes</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="clientes.php"><i class="fas fa-eye"></i> Clientes</a>
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
                </li>';
                }?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Lista de Clientes</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#modalAgregarCliente'>Agregar cliente</button>
        </div>
        <!-- <br>
        <button type='button' class='btn btn-success buttons-excel buttons-html5'>Excel</button>
        <button type='button' class='btn btn-danger buttons-pdf buttons-html5' id="btnGeneratePDF">PDF</button>
        <br> -->
        <br>
        <div class="table-responsive">
            <table id="tablaCliente" class="table compact bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Celular</th>
                        <th>Carnet</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>
    <!-- MODAL PARA VENTA -->
    
    <!-- MODAL PARA AGREGAR pRODUCTO-->
    <div class="modal fade" id="modalAgregarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Agregar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddCliente">
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="">Nombre:</label>
                                <input type="text" name="" id="nomCliente" class="form-control">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="">Carnet:</label>
                                <input type="text" name="" id="ciCliente" class="form-control">
                            </div>
                            <br>
                            <div class="col-sm-7 form-group">
                                <label for="">Numero:</label>
                                <input type="text" name="" id="numCliente" class="form-control">
                            </div>  
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Agregar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDITAR CLIENTE  -->
    <div class="modal fade" id="modalEditarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="idEditCliente" class='d-none'></span>
                    <form action="" id="formEditCliente">
                        <div class="row">
                            <div class="col-sm-7 form-group">
                                <label for="">Nombre:</label>
                                <input type="text" id="nomEditCliente" class="form-control">
                            </div>
                            <div class="col-sm-5 form-group">
                                <label for="">Carnet:</label>
                                <input type="text" id="ciEditCliente" class="form-control">
                            </div>
                            <br>
                            <div class="col-sm-7 form-group">
                                <label for="">Numero:</label>
                                <input type="text" id="numEditCliente" class="form-control">
                            </div>  
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Agregar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR CLIENTE  -->
    <div class="modal fade" id="modalEliminarCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="idEliminarCliente" class='d-none'></span>
                    <form action="" id="formEliminarCliente">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" value="" id="checkConfirmacion"> ¿Usted esta de acuerdo con eliminar 
                                al cliente <strong id='nomEliminarCliente'></strong> siempre y cuando no haya ninguna compra?
                            </label>
                        </div>
                        <br>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Eliminar" disabled id="btnEliminarCliente">
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

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js" integrity="sha512-SgWewGM3r8xXm8LNXt4ZHqKVKu/7eKrJ1aBCbMaX44xXXaCcIvCAvD2kj9qnC1lhyjAu04mcPiTzcc/CaACnUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script src="js/clientes.js"></script>
</html>