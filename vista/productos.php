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
                    echo '<li class="nav-item active">
                    <a class="nav-link" href="productos.php"><i class="fas fa-eye"></i> Productos</a>
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
                    <a class="nav-link" href="proveedor.php">Proveedor</a>
                </li>
                <li class="nav-item">
                    <a href="../controlador/formCerrarSession.php" class="btn btn-danger" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
                </li>';
                }?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <h1 class="text-center p-2 text-primary">Lista de productos</h1>
        <div>
            <button class="btn btn-success" data-toggle='modal' data-target='#modalAgregarProducto'>Agregar producto</button>
        </div>
        <br>
        <div class="table-responsive">
            <table id="tablaProducto" class="table compact table-sm bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Venta</th>
                        <th>Stock</th>
                        <th>Opc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>

    <!-- MODAL INFO PRODUCTO -->
    <div class="modal fade" id="modalInfoProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class='fas fa-info-circle'></i> Informacion de productos - Compras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Nombre:<strong id="nombDetalleProducto"></strong></span>
                        </div>
                        <div class="col-sm-6">
                            <span>Descripcion:<strong id="descDetalleProducto"></strong></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Precio venta:<strong id="ventDetalleProducto"></strong></span>
                        </div>
                        <div class="col-sm-6">
                            <span>Stock: <strong id="stockDetalleProducto"></strong></span>
                        </div>
                    </div>
                    <div id="contInfo" class="bg-light border p-2 mt-3">

                    </div>
                    <div class="text-center my-3">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR PRODUCTO -->
    <div class="modal fade" id="modalEliminarProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Eliminar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDeletProducto">
                        <span class="d-none" id="idDeletProducto"></span>
                        <p>¿Usted esta seguro que desea eliminar el producto <strong id="nomDeletProducto"></strong>?</p>
                        <br>
                        <span class="text-danger">* Solo se podra eliminar si no existe ningun registro de compra o venta del producto</span>
                        <div class="text-center my-3">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL PARA AGREGAR PRODUCTO-->
    <div class="modal fade" id="modalAgregarProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Agregar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddProducto">
                        <div class="row">
                            <div class="col-8 form-group">
                                <label for="">Nombre del producto</label>
                                <input type="text" name="addNomProducto" id="addNomProducto" class="form-control" required>
                            </div>
                            <div class="col-4 form-group">
                                <label for="">Precio de venta</label>
                                <input type="number" step="0.1" value="1" name="addVentaProducto" id="addVentaProducto" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="">Descripcion del producto</label>
                                <input type="text" name="addDescProducto" id="addDescProducto" class="form-control">
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

    <!--MODAL EDITAR PRODUCTO  -->
    <div class="modal fade" id="modalEditarProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEditProducto">
                        <input type="text" class='d-none' id="editIDProducto">
                        <div class="row">
                            <div class="col-8 form-group">
                                <label for="">Nombre del producto</label>
                                <input type="text" id="editNomProducto" class="form-control" required>
                            </div>
                            <div class="col-4 form-group">
                                <label for="">Precio de venta</label>
                                <input type="number" step="0.1" value="1" id="editVentaProducto" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="">Descripcion del producto</label>
                                <input type="text" id="editDescProducto" class="form-control">
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
<script src="js/productos.js"></script>
</html>