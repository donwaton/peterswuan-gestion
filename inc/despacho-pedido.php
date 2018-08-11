<?php
include './bin/select-edit-pedido.php';

$class1 = $class2 = $class3 = $class4 = $class5 = "hidden-xs";

if($pedido['ep_id']==1){
    $class1="text-info";
}
if($pedido['ep_id']==2){
    $class1="text-success hidden-xs";
    $class2="text-info";
}
if($pedido['ep_id']==3){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="text-info";
}
if($pedido['ep_id']==4){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="text-success hidden-xs";
    $class4="text-info";
}
if($pedido['ep_id']==5){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="text-success hidden-xs";
    $class4="text-success hidden-xs";
    $class5="text-info";
}
?>

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        var $table1 = jQuery( '#table-1' );
        var $tablePedido = jQuery( '#table-pedido' );

        // Initialize DataTable1
        $tablePedido.DataTable( {
            "sDom": "tip",
            paging: false
        });
        // Initalize Select Dropdown after DataTables is created
        $tablePedido.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });

        // Initialize DataTable1
        $table1.DataTable( {
            "sDom": "tip",
            paging: false
        });
        // Initalize Select Dropdown after DataTables is created
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });

         document.getElementById("ingresoExitoso").style.visibility = "hidden";

         $('#newTipoInsumo').on('change',function(){
            var tipoInsumoID = $(this).val();
            if(tipoInsumoID){
                $.ajax({
                    type:'POST',
                    url:'./bin/select-insumo-tipoinsumo.php',
                    data:'tipoinsumo_id='+tipoInsumoID,
                    success:function(html){
                        $('#newInsumo').empty();
                        $('#newInsumo').append(html);
                        document.getElementById("ingresoExitoso").style.visibility = "hidden";
                    }
                });
            }
        });

        $('#addInsumo').click(function(){
            $.ajax({
                url:"bin/insert-insumo-pedido.php",
                method:"POST",
                data:$('#formAddInsumo').serialize(),
                success:function(data){
                  document.getElementById('newTipoInsumo').value = '';
                  document.getElementById('newInsumo').value = '';
                  document.getElementById('newCantidad').value = '';
                  document.getElementById("ingresoExitoso").style.visibility = "visible";
                }
            });
        });

        $('#refreshInsumos').click(function(){
           window.location.replace('index.php?sec=aprobar-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid'];?>');
        });
    });

</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pedidos-despacho"><i class="fa-home"></i> Lista de pedidos pendientes de despacho</a>
  </li>
  <li class="active">
    <strong>Detalles pedido</strong>
  </li>
</ol>
      
<h2>Estado del pedido</h2> <br>

<div class="row">
    <div class="col-md-2 <?php echo $class1;?>"><i class="entypo-clipboard"></i><br class="hidden-xs">Borrador</div>
    <div class="col-md-2 <?php echo $class2;?>"><i class="entypo-check"></i><br class="hidden-xs">Pendiente de aprobación</div>
    <div class="col-md-2 <?php echo $class3;?>"><i class="entypo-box"></i><br class="hidden-xs">Pendiente de despacho</div>
    <div class="col-md-2 <?php echo $class4;?>"><i class="entypo-map"></i><br class="hidden-xs">Camino al domicilio</div>
    <div class="col-md-2 <?php echo $class5;?>"><i class="entypo-home"></i><br class="hidden-xs">Despachado</div>
</div>
<br>
      
<?php if($pedido['ep_id']==3){?>
<button type="button" class="btn btn-success btn-icon icon-left"onclick="
    $.ajax({
        type:'POST',
        url:'./bin/despachar-pedido.php',
        data:{idPedido:<?php echo $_GET['pid'];?>,userId:<?php echo $_SESSION['userid'];?>},
        success:function(response){
            window.location.replace('index.php?sec=lista-pedidos-despacho');
        }
    });
    ">
    <i class="entypo-check"></i>Despachar pedido
</button>

<a href="index.php?sec=pedido&id=<?php echo $_GET['pid'];?>"  class="btn btn-success btn-icon icon-left" target="_blank">
    <i class="entypo-doc"></i>Guía de despacho
</a>

<?php } ?>
<br />

<h2>Lista de Insumos Pedido</h2>

<br />

    <div>
    <table class="table table-bordered datatable" id="table-pedido">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th style="width:80px;">Pedido</th>
                    <th style="width:80px;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $listaInsumosPedido["insumo_nombre"];?></td>
                    <td><?php echo $listaInsumosPedido["tipoinsumo_nombre"];?></td>
                    <td><?php echo $listaInsumosPedido["mp_nombre"];?></td>
                    <td><?php echo $listaInsumosPedido["ip_cantidad"];?></td>
                   <td width="80px">
                        <button type="button" class="btn btn-danger btn-xs" onclick="
                        $.ajax({
                            type:'POST',
                            url:'./bin/delete-insumo-pedido.php',
                            data:'idInsumo=<?php echo $listaInsumosPedido['ip_id'];?>',
                            success:function(response){
                                window.location.replace('index.php?sec=aprobar-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid'];?>');
                            }
                        });
                        ">
                            <i class="entypo-trash"></i>
                        </button>
                        <!--
                        <button type="button" class="btn btn-info btn-xs">
                            <i class="entypo-pencil"></i>
                        </button>
                        -->
                    </td>
                </tr>
            <?php } ?>
            </tbody>			
        </table> 
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