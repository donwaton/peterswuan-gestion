<?php
include './bin/select-edit-pedido.php';

$class1 = $class2 = $class3 = $class4 = $class5 = "hidden-xs";

if($pedido['ep_id']==1){
    $class1="alert-info";
}
if($pedido['ep_id']==2){
    $class1="text-success hidden-xs";
    $class2="alert-info";
}
if($pedido['ep_id']==3){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="alert-info";
}
if($pedido['ep_id']==4){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="text-success hidden-xs";
    $class4="alert-info";
}
if($pedido['ep_id']==5){
    $class1="text-success hidden-xs";
    $class2="text-success hidden-xs";
    $class3="text-success hidden-xs";
    $class4="text-success hidden-xs";
    $class5="alert-info";
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

        $('#updateInsumo').click(function(){
            document.getElementById('updateInsumo').disabled = true;
            var pedido = document.forms["formUpdateInsumo"]["newPedido"].value;
            var idInsumo = document.forms["formUpdateInsumo"]["insumoId"].value;

            if(pedido ==""){
                alert("Debe ingresar una cantidad para actualizar");
            } 
            else {
                                
                $.ajax({
                    url:"bin/update-insumo-pedido.php",
                    method:"POST",
                    data:$('#formUpdateInsumo').serialize(),
                    success:function(response){
                        var opts = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-full-width",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "1000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };                        
                        toastr.success("Se ha actualizado la cantidad del pedido", "Actualización exitosa", opts);
                        document.getElementById('listConsumo'+idInsumo).innerHTML = pedido;
                        document.forms["formUpdateInsumo"]["newPedido"].value = null;
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
    <a href="index.php">Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pedidos-despacho">Lista de pedidos pendientes de despacho</a>
  </li>
  <li class="active">
    <strong>Detalles pedido</strong>
  </li>
</ol>
      
<h2>Estado del pedido</h2> <br>

<div class="row" align="center">
    <div class="col-sm-1 col-xs-4"><p class="visible-xs"><b>Estado Pedido</b></p></div>
    <div class="col-sm-2 col-xs-8 <?php echo $class1;?>" style="border-radius: 25px;"><i class="entypo-clipboard"></i><br class="hidden-xs">Borrador</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class2;?>" style="border-radius: 25px;"><i class="entypo-check"></i><br class="hidden-xs">Pendiente de<br class="hidden-xs">aprobación</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class3;?>" style="border-radius: 25px;"><i class="entypo-box"></i><br class="hidden-xs">En preparación</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class4;?>" style="border-radius: 25px;"><i class="fa fa-truck"></i><br class="hidden-xs">En ruta</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class5;?>" style="border-radius: 25px;"><i class="entypo-home"></i><br class="hidden-xs">Entregado</div>
    <div class="col-sm-1"></div>
</div>
<hr>
      
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
<br />
<?php } ?>

<h2>Lista de Insumos Pedido</h2>

<br />

    <div>
    <table class="table table-bordered datatable" id="table-pedido">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th style="width:80px;">Consumo</th>
                    <th style="width:80px;">Stock</th>
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
                    <td><?php echo $listaInsumosPedido["pi_consumo"];?></td>
                    <td><?php echo $listaInsumosPedido["pi_stock"];?></td>
                    <td id="listConsumo<?php echo $listaInsumosPedido['ip_id'];?>"><?php echo $listaInsumosPedido["ip_cantidad"];?></td>
                   <td width="80px">
                        <button type="button" class="btn btn-info btn-xs" onclick="
                            document.getElementById('insumoId').value = '<?php echo $listaInsumosPedido['ip_id'];?>';
                            document.forms['formUpdateInsumo']['newPedido'].value = '';
                            $('#modalUpdateInsumo').modal('show');
                        "><i class="entypo-pencil"></i>
						</button>
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

<!-- Modal Actualiza Pedido-->
<div class="modal fade" id="modalUpdateInsumo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="exampleModalLabel">Actualizar Pedido</h3>
            </div>
            <div class="modal-body">
                <form id="formUpdateInsumo" name="formUpdateInsumo" onsubmit="false">
                    <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
                    <input type="hidden" name="insumoId" id="insumoId" value="0">

                    <label for="newPedido">Cantidad pedido</label>
                    <input type="number" name="newPedido" id="newPedido" class="form-control form-control-sm noEnterSubmit"
                    data-validate="required" data-message-required="Debe ingresar la cantidad del pedido." required onkeyup="
                        var pedido = document.forms['formUpdateInsumo']['newPedido'].value;
                        if(pedido!=''){
                            document.getElementById('updateInsumo').disabled = false;
                        }
                        if(pedido==''){
                            document.getElementById('updateInsumo').disabled = true;
                        }
                    ">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success" data-dismiss="modal" disabled>Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<style>
.dataTables_info {
    display: none;
}
</style>

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/toastr.js"></script>