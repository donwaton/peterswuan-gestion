<?php
include './bin/select-confirmar-pedido.php';
?>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php?sec=lista-pedidos-ruta">Lista de pedidos en ruta</a>
  </li>
  <li class="active">
    <strong>Verificar pedido</strong>
  </li>
</ol>

<h2 class="hidden-xs">Verificar pedido</h2> <br class="hidden-xs">

<h4><?php echo $pedido['paciente_nombre']; ?></h4> <br>
<p><?php echo $pedido['paciente_domicilio']; ?></p>

<table class="table table-bordered datatable" id="table-confirmacion">
    <thead>
        <tr>
            <th>Nombre</th>
            <th style="width:80px;">Pedido</th>
            <th width="60px">Ok</th>
            <th width="80px">Cantidad</th>
        </tr>
    </thead>
    <tbody id="tabla-consumo">
    <?php while ($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) {?>
        <tr id="listInsumo<?php echo $listaInsumosPedido['ip_id']; ?>">
            <td><?php echo $listaInsumosPedido["insumo_nombre"]; ?></td>
            <td><?php echo $listaInsumosPedido["ip_cantidad"]; ?></td>
            <td>
            
                <div class="checkbox checkbox-replace" style="margin-top:7px;" align="center">
                    <input type="checkbox" id="chk-<?php echo $listaInsumosPedido['ip_id'];?>"
                    onclick="
                    var insumoId = <?php echo $listaInsumosPedido['ip_id']; ?>;
                    var x = document.getElementById('cantidad-<?php echo $listaInsumosPedido['ip_id'];?>').disabled;
                    if (x == true) {
                        document.getElementById('cantidad-<?php echo $listaInsumosPedido['ip_id'];?>').disabled = false;
                        var status = false;
                        $.ajax({
                            type:'POST',
                            url:'./bin/update-insumo-status.php',
                            data:{insumoId:<?php echo $listaInsumosPedido['ip_id'];?>,status:+status},
                            success:function(response){
                            }
                        });
                    }
                    else {
                        document.getElementById('cantidad-<?php echo $listaInsumosPedido['ip_id'];?>').value='';
                        document.getElementById('cantidad-<?php echo $listaInsumosPedido['ip_id'];?>').disabled = true;
                        var status = true;
                        $.ajax({
                            type:'POST',
                            url:'./bin/update-insumo-status.php',
                            data:{insumoId:<?php echo $listaInsumosPedido['ip_id'];?>,status:+status},
                            success:function(response){
                            }
                        });
                    }                    
                    " <?php if($listaInsumosPedido['ip_estado']==1){
                        echo "checked";
                    }?>>
                </div>                                
            </td>
            <td>
                <input type="number" name="cantidad" id="cantidad-<?php echo $listaInsumosPedido['ip_id'];?>" 
                min=0
                class="form-control form-control-sm noEnterSubmit" 
                <?php if($listaInsumosPedido['ip_estado']!=0){ echo "disabled"; } ?> onchange="
                    var insumoEntregado = document.getElementById('cantidad-<?php echo $listaInsumosPedido['ip_id'];?>').value;
                    $.ajax({
                            type:'POST',
                            url:'./bin/update-insumo-status.php',
                            data:{insumoId:<?php echo $listaInsumosPedido['ip_id'];?>,insumoEntregado:+insumoEntregado},
                            success:function(response){
                            }
                        });
                "
                autocomplete="off"
                value="<?php echo $listaInsumosPedido["ip_entregado"]; ?>">
            </td>
        <tr>
    <?php }?>
    </tbody>
</table>

<div align="right">
<button type="button" class="btn btn-success btn-icon icon-left" onclick="
    $.ajax({
        type:'POST',
        url:'./bin/confirmar-pedido.php',
        data:{idPedido:<?php echo $_GET['pid']; ?>,userId:<?php echo $_SESSION['userid']; ?>},
        success:function(response){
            window.location.replace('index.php?sec=lista-pedidos-ruta');
        }
    });
    ">
    <i class="entypo-check"></i>Confirmar pedido
</button>
</div>