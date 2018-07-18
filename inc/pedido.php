<?php
include './bin/select-pedido.php';
?>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3 hidden-print" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pacientes"><i class="fa-home"></i>Lista de pacientes</a>
  </li>
  <li>
    <a href="index.php?sec=paciente&id=<?php echo $pedido['paciente_id']; ?>"><i class="fa-home"></i>Ficha <?php echo $pedido['paciente_nombre'] ?></a>
  </li>
  <li class="active">
    <strong>Detalles pedido</strong>
  </li>
</ol>

<div class="invoice">

    <div class="row">

        <div class="col-sm-6 invoice-left">

            <a href="#">
                <img src="assets/images/logo-peterswuan.png" width="185" alt="" />
            </a>

        </div>

        <div class="col-sm-6 invoice-right">

                <h3>Nº de Pedido: <?php echo $pedido['pedido_id']; ?></h3>
                <?php $fechaPedido = date ( 'd-m-Y' , strtotime ($pedido['pedido_fecha']) );?>
                <span>Fecha: <?php echo $fechaPedido ?></span>
        </div>

    </div>


    <hr class="margin" />


    <div class="row">

        <div class="col-sm-3 invoice-left">

            <h4>Paciente</h4>
            <?php echo $pedido['paciente_nombre'] ?>

        </div>

        <div class="col-sm-3 invoice-left">

            <h4>Telefono</h4>
            <?php echo $pedido['contacto_tel1'] ?>
        </div>

        <div class="col-md-6 invoice-right">

            <h4>Dirección</h4>
            <?php echo $pedido['paciente_domicilio'] ?>

        </div>

    </div>

    <div class="margin"></div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) {?>
            <tr>
                <td><?php echo $listaInsumosPedido["insumo_nombre"]; ?></td>
                <td><?php echo $listaInsumosPedido["tipoinsumo_nombre"]; ?></td>
                <td><?php echo $listaInsumosPedido["ip_cantidad"]; ?></td>
            </tr>
        <?php }?>

        </tbody>
    </table>

    <div class="margin"></div>

        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Observaciones</th>
            </tr>
        </thead>

        <tbody>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
        </tbody>
    </table>

    <div class="margin"></div>

    <div class="row">

        <div class="col-sm-6">

        </div>

        <div class="col-sm-6">

            <div class="invoice-right">

                <a href="javascript:window.print();" class="btn btn-primary btn-icon icon-left hidden-print">
                    Imprimir Pedido
                    <i class="entypo-doc-text"></i>
                </a>
            </div>

        </div>

    </div>

</div>


<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<style>
.dataTables_info {
    display: none;
}
</style>

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>