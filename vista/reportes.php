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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Reportes</title>
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
                    <a class="nav-link" href="#">Reserva</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">Ventas</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="reportes.php"> <i class="fas fa-eye"></i> Reportes</a>
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
                </li>
                <li class="nav-item">
                    <a href="../controlador/formCerrarSession.php" class="btn btn-danger" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
                </li>';
                }?>
            </ul>
        </div>
    </nav>
    <main class="container border shadow p-4 mb-4 mx-auto my-1 bg-white" style="min-height: 650px;">
        <div class="col-xl-8 col-lg-10 col-sm-11 border mx-auto bg-light p-3">
            <h1 class="text-center p-2 text-primary">Reportes</h1>
            <div class="form-group">
                <h6>Registros por </h6>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" id="checkReserva" checked>Reserva de Cancha
                    </label>
                </div>
                <!-- <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" id="checkVenta" checked>Venta de productos
                    </label>
                </div> -->
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" id="checkInscripcion" checked>Cobro Alumno Grupo
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" id="checkCompra" checked>Compra de productos
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" id="checkVenta" checked>Venta de productos
                    </label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="">Fecha inicio (00:00)</label>
                    <input type="date" name="fechaInicioReporte" id="fechaInicioReporte" class="form-control" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>">
                </div>
                <div class="form-group col-sm-6">
                    <label for="">Fecha Final (23:59)</label>
                    <input type="date" name="fechaFinalReporte" id="fechaFinalReporte" class="form-control" value="<?php echo date("Y-m-d");?>" max="<?php echo date("Y-m-d");?>">
                </div>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-dark btn-block" id="btnSolicitarReporte">Solicitar reporte</button>
            </div>
            <hr>
            <!-- <div class="form-group">
                <label for="">Tipo de grafico</label>
                <select name="" id="" class="form-control">
                    <option value="">Pie</option>
                    <option value="">Barras</option>
                    <option value="">Etc</option>
                </select>
            </div> -->
        </div>

        <div class="col-xl-8 col-lg-10 col-sm-11 border mx-auto bg-light p-3">
            <h2 class="text-center p-2 text-primary">Libro</h2>
            
            <div id="cajaPagosReserva" >
                <h5 class='text-danger'>Pagos por reserva</h4>
                <table class="table compact responsive" style="width:100%" id="tablaPagosReserva">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Inicio</th>
                            <th>Final</th>
                            <th>Tiempo</th>
                            <th>Efectivo</th>
                            <th>Digital</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="text-right">
                    <span>Total: <strong id="totalPagoReserva"></strong></span>
                </div>
                <!-- <div class="mx-auto text-center">
                    <canvas id="myChart2" width="400" height="400" class="myChart"></canvas>
                </div> -->
            </div>
            <hr>
            
            <div id="cajaVenta" >
                <h5 class='text-danger'>Dinero por venta</h4>
                <table class="table compact" style="width:100%" id="tablaVentas">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="text-right">
                    <span>Total: <strong id="totalVentas"></strong></span>
                </div>
                <!-- <div class="mx-auto text-center">
                    <canvas id="myChart2" width="400" height="400" class="myChart"></canvas>
                </div> -->
            </div>
            <hr>

            <div id="cajaCompras" >
                <h5 class='text-danger'>Dinero por compras</h4>
                <table class="table compact" style="width:100%" id="tablaCompras">
                    <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="text-right">
                    <span>Total: <strong id="totalCompras"></strong></span>
                </div>
                <!-- <div class="mx-auto text-center">
                    <canvas id="myChart2" width="400" height="400" class="myChart"></canvas>
                </div> -->
            </div>

            <div id="cajaPagosGrupo" >
                <h5 class='text-danger'>Dinero por grupos</h4>
                <table class="table compact" style="width:100%" id="tablaPagosGrupo">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Fecha</th>
                            <th>Efectivo</th>
                            <th>Digital</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="text-right">
                    <span>Total: <strong id="totalPagosGrupo"></strong></span>
                </div>
                <!-- <div class="mx-auto text-center">
                    <canvas id="myChart2" width="400" height="400" class="myChart"></canvas>
                </div> -->
            </div>
        </div>
    </main>
    <!-- MODAL PARA VENTA -->
    
    <!-- MODAL PARA AGREGAR pRODUCTO-->
    <div class="modal fade" id="modalAgregarProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Agregar producto al inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddProducto">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="">Nombre del producto</label>
                                <input type="text" name="addNomProducto" id="addNomProducto" class="form-control" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="">Descripcion del producto</label>
                                <input type="text" name="addDescProducto" id="addDescProducto" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 form-group">
                                <label for="">Precio de venta en Bs</label>
                                <input type="number" step="0.1" value="1" name="addVentaProducto" id="addVentaProducto" class="form-control">
                            </div>
                            <div class="col-sm-7 form-group">
                            <label for="">Seleccione el tipo de compra:</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio" value="compraPorUnidad" required>Compra por unidad
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio" value="compraPorPaquete">Compra por paquete
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="compraPaquete" class="d-none">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="">Precio compra paquete</label>
                                    <input  type="number" step="0.1" value="1" name="addCompraPaqueteProducto" id="addCompraPaqueteProducto" class="form-control" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="">Cant. unidades por paquete</label>
                                    <input type="number" value="1" min="1" name="addCantPaqueteProducto" id="addCantPaqueteProducto" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="">Paquetes comprados</label>
                                    <input type="number" value="1" min="1" name="addCantPaqueteComprados" id="addCantPaqueteComprados" class="form-control">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="">Precio unitario compra</label>
                                    <input type="text" name="calPrecioUnit" id="calPrecioUnit" class="form-control" disabled required>
                                </div>
                            </div>
                        </div>
                        <div id="compraUnidad" class="d-none">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="">Precio unitario compra</label>
                                    <input type="number" value="1" step="0.1" name="addPrecioCompraUnit" id="addPrecioCompraUnit" class="form-control">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="">Unidades compradas</label>
                                    <input type="number" value="1" min="1" name="addUnidadesCompra" id="addUnidadesCompra" class="form-control">
                                </div>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script src="js/reportes.js"></script>
</html>