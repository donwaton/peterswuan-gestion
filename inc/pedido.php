<?php
include './bin/select-pedido.php';
?>

<!-- Inicio HTML -->
<div class="invoice">

    <div class="row">

        <div class="col-sm-6 invoice-left">

            <a href="#">
                <img src="assets/images/logo-peterswuan.png" width="185" alt="" />
            </a>

        </div>

        <div class="col-sm-6 invoice-right">

                <h3>Nº de Pedido: <?php echo $pedido['pedido_id']; ?></h3>
                <?php $fechaPedido = date('d-m-Y');?>
                <span>Fecha: <?php echo $fechaPedido ?></span>
        </div>

    </div>


    <hr class="margin" />


    <div class="row">

        <div class="col-sm-3 invoice-left">

            <h4>Paciente</h4>
            <?php echo $pedido['paciente_nombre'] ?>

        </div>

        <div class="col-sm-2 invoice-left">

            <h4>Contacto</h4>
            <?php echo $pedido['contacto_nombre1'] ?>
        </div>

        <div class="col-sm-2 invoice-left">

            <h4>Telefono</h4>
            <?php echo $pedido['contacto_tel1'] ?>
        </div>

        <div class="col-md-5 invoice-right">

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
                <th>Check</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) {?>
            <tr>
                <td><?php echo $listaInsumosPedido["insumo_nombre"]; ?></td>
                <td><?php echo $listaInsumosPedido["tipoinsumo_nombre"]; ?></td>
                <td><?php echo $listaInsumosPedido["ip_cantidad"]; ?></td>
                <td></td>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="checkbox checkbox-replace" style="margin-left:20px;">
                <input type="checkbox" id="chk-1" >
                <label>Conforme</label>
            </div>
            <div class="checkbox checkbox-replace" style="margin-left:20px;">
                <input type="checkbox" id="chk-1" >
                <label>Disconforme</label>
            </div>
            <div class="checkbox checkbox-replace" style="margin-left:40px;">
                <input type="checkbox" id="chk-1" >
                <label>Producto en mal estado</label>
            </div>
            <div class="checkbox checkbox-replace" style="margin-left:40px;">
                <input type="checkbox" id="chk-1" >
                <label>Falta de insumo y/o medicamentos</label>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <table style="margin: 0 auto 0 auto;">
            <tr>
                <td style="padding-right: 30px;">_________________________________________</td>
                <td>_________________________________________</td>
            </tr>
            <tr>
                <td align="center">Nombre</td>
                <td align="center">Firma</td>
            </tr>
        </table>
    </div>


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