<?php
include './bin/select-confirmar-pedido.php';
?>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li class="hidden-xs">
    <a href="index.php">Inicio</a>
  </li>
  <?php if ($_SESSION['perfil'] != 5) {?>
  <li class="hidden-xs">
    <a href="index.php?sec=lista-pacientes">Lista de pacientes</a>
  </li>
  <li>
    <a href="index.php?sec=paciente&id=<?php echo $pedido['paciente_id']; ?>">Ficha <?php echo $pedido['paciente_nombre'] ?></a>
  </li>
  <?php }if ($_SESSION['perfil'] == 5) {?>
  <li class="hidden-xs">
    <a href="index.php?sec=paciente-tens&id=<?php echo $pedido['paciente_id']; ?>">Ficha <?php echo $pedido['paciente_nombre'] ?></a>
  </li>
  <?php }?>
  <li class="hidden-xs">
    <a href="index.php?sec=edit-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid'];?>">Detalles pedido</a>
  </li>
  <li class="active">
    <strong>Verificar pedido</strong>
  </li>
</ol>

<h2 class="hidden-xs">Confirmar pedido</h2> <br>

<button type="button" class="btn btn-success btn-icon icon-left" onclick="
    $.ajax({
        type:'POST',
        url:'./bin/confirmar-pedido.php',
        data:{idPedido:<?php echo $_GET['pid']; ?>,userId:<?php echo $_SESSION['userid']; ?>},
        success:function(response){
            <?php if ($_SESSION['perfil'] == 5) {?>
            window.location.replace('index.php?sec=paciente-tens&id=<?php echo $_GET['id']; ?>');
            <?php }?>
            <?php if ($_SESSION['perfil'] <> 5) {?>
            window.location.replace('index.php?sec=paciente&id=<?php echo $_GET['id']; ?>');
            <?php }?>
        }
    });
    ">
    <i class="entypo-check"></i>Solicitar aprobación
</button>
<br /><br />

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