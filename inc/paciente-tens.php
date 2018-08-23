<?php 
if($_GET['id']==""){
    echo "<h2>No tiene paciente asignado</h2>";
}
else {
include './bin/select-paciente.php';
?>

<script type="text/javascript">
    jQuery( document ).ready( function() {
   
    // Propiedades de la tablas
        var $table1 = jQuery( '#table-1' );
        var $table2 = jQuery( '#table-2' );
        var $table3 = jQuery( '#table-3' );
        $table1.DataTable( { paging: false });        
        $table2.DataTable( { paging: false });        
        $table3.DataTable( { paging: false });

    // Alerta de quiebre de stock de insumos
        function alertaQuiebreStock(){
            $.ajax({
                url:"bin/select-insumo-critico.php",
                method:"POST",
                data:'pacienteId=<?php echo $_GET['id'];?>',
                success:function(response){
                    if(response>0){
                        document.getElementById('alertaInsumo').innerHTML = response;
                    }
                    else {
                        document.getElementById('alertaInsumo').innerHTML = '';
                    }
                }
            });
        }
        alertaQuiebreStock();

        // Alerta de próximos vencimientos de preparados magistrales
        function alertaPreparadoVencimiento(){
            $.ajax({
                url:"bin/select-preparado-vencimiento.php",
                method:"POST",
                data:'pacienteId=<?php echo $_GET['id'];?>',
                success:function(response){
                    if(response>0){
                        document.getElementById('alertaPreparado').innerHTML = response;
                    }
                    else {
                        document.getElementById('alertaPreparado').innerHTML = '';
                    }
                }
            });
        }
        alertaPreparadoVencimiento();

        $('.noEnterSubmit').keypress(function(e){
            if ( e.which == 13 ) return false;
            //or...
            if ( e.which == 13 ) e.preventDefault();
        });

        $('#updateInsumo').click(function(){
            var stock = document.forms["formUpdateInsumo"]["newStock"].value;
            var idInsumo = document.forms["formUpdateInsumo"]["insumoId"].value;

            if(stock ==""){
                alert("Debe ingresar el nuevo stock para actualizar");
            } 
            else {
                                
                $.ajax({
                    url:"bin/update-insumo-paciente.php",
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
                        toastr.success("Se ha actualizado el stock del insumo", "Actualización exitosa", opts);
                        $('#modalUpdateInsumo').modal('hide');
                        if(response == "false"){
                            document.getElementById('listInsumo'+idInsumo).innerHTML = stock;
                        }
                        if(response == "true"){
                            document.getElementById('listInsumo'+idInsumo).innerHTML = stock+" <i class='entypo-attention' style='color:#ff3300;'></i>";
                        }
                        alertaQuiebreStock();
                        }
                });
            } 
        });

        $('#addPedido').click(function(){
            $.ajax({
                url:"bin/insert-pedido.php",
                method:"POST",
                data:$('#formAddPedido').serialize(),
                success:function(data){
                    window.location.replace('index.php?sec=edit-pedido&id=<?php echo $_GET['id'];?>&pid='+data);
                }
            });
        });  

    } );
</script>

<!-- Inicio HTML -->
      
<h2>Ficha de <?php echo $datosPaciente['paciente_nombre'];?></h2>
<br />

<ul class="nav nav-tabs bordered">
    <li class="active">
        <a href="#consumo" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-box"></i></span>
            <span class="hidden-xs">Consumo</span>
            <span class="badge badge-danger" id="alertaInsumo"></span>
        </a>
    </li>
    <li>
        <a href="#magistrales" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-newspaper"></i></span>
            <span class="hidden-xs">Preparados magistrales</span>
            <span class="badge badge-danger" id="alertaPreparado"></span>
        </a>
    </li>
    <li>
        <a href="#pedidos" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-clipboard"></i></span>
            <span class="hidden-xs">Pedidos</span>
        </a>
    </li>
    <li>
        <a href="#contacto" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-user"></i></span>
            <span class="hidden-xs">Contacto</span>
        </a>
    </li>
</ul>
				
<div class="tab-content">

<!-- Datos de contacto -->
    <div class="tab-pane" id="contacto"> 
        <h4>Telefonos de contacto</h4>
        <?php if($datosPaciente['contacto_nombre1']==""){?>   
            <div class="alert alert-warning"><strong>Alerta!</strong> Paciente no tiene datos de contacto ingresados.</div>
        <?php } else {?>
        <p><?php echo $datosPaciente['contacto_nombre1'];?> : <?php echo $datosPaciente['contacto_tel1'];?></p>
        <p><?php echo $datosPaciente['contacto_nombre2'];?> : <?php echo $datosPaciente['contacto_tel2'];?></p>   
        <?php } ?>   
        <h4>Domicilio</h4>   
        <p><?php echo $datosPaciente['paciente_domicilio'];?></p>
    </div>

<!-- Consumo -->
    <div class="tab-pane active" id="consumo">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="hidden-xs">Tipo</th>
                    <th class="hidden-xs">Consumo</th>
                    <th>Stock</th>
                    <th></th>

                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaInsumos = $resultInsumos->fetch_assoc()) { 
                    $classDanger = '';
                if($listaInsumos["pi_consumo"]*0.3>$listaInsumos["pi_stock"]){
                    $classDanger = "<i class='entypo-attention' style='color:#ff3300;'></i>";
                }
                ?>
                <tr>
                    <td><?php echo $listaInsumos["insumo_nombre"];?></td>
                    <td class="hidden-xs"><?php echo $listaInsumos["tipoinsumo_nombre"];?></td>
                    <td class="hidden-xs"><?php echo $listaInsumos["pi_consumo"];?></td>
                    <td id="listInsumo<?php echo $listaInsumos['pi_id'];?>"><?php echo $listaInsumos["pi_stock"]." ".$classDanger;?></td>     
                    <td>
                        <button type="button" class="btn btn-info btn-xs" onclick="
                            document.getElementById('insumoId').value = '<?php echo $listaInsumos['pi_id'];?>';
                            document.getElementById('newStock').value = '';
                            $('#modalUpdateInsumo').modal('show');
                        ">
								<i class="entypo-pencil"></i><span class="hidden-xs">Actualizar Stock</span>
						</button>
                    </td>               
                </tr>
            <?php } ?>
            </tbody>			
        </table> 
    </div>
    <!-- Preparados Magistrales -->
    <div class="tab-pane" id="magistrales"> 
     <!-- Button trigger modal -->
    <table class="table table-bordered datatable" id="table-3">
        <thead>
            <tr>
                <th>Principio Actico</th>
                <th>Dosis</th>
                <th>Cantidad</th>
                <th>Posología</th>
                <th>Duración estimada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-consumo">
        <?php while($listaMagistrales = $resultMagistrales->fetch_assoc()) { 
            $week=strtotime("-6 day");
            $classDangerPrep = '';
            if($listaMagistrales["prep_fecha_venc"]<date("Y-m-d", $week)){
                $classDangerPrep = "<i class='entypo-attention' style='color:#ff3300;'></i>";
            }
            ?>
            <tr>
                <td><?php echo $listaMagistrales["principio_nombre"];?></td>
                <td><?php echo $listaMagistrales["prep_dosis"]." ".$listaMagistrales["prep_unidad"];?></td>
                <td><?php echo $listaMagistrales["prep_cantidad"]." ".$listaMagistrales["forma_nombre"];?></td>
                <td><?php echo $listaMagistrales["prep_pos_dosis"]." ".$listaMagistrales["prep_unidad"]." cada ".$listaMagistrales["prep_pos_horas"]." horas";?></td>
                <td><?php echo $listaMagistrales["prep_fecha_venc"]." ".$classDangerPrep;?></td>
                <td width="100px">
                    <a href="index.php?sec=magistral&id=<?php echo $listaMagistrales['prep_id'];?>" class="btn btn-info btn-sm btn-icon icon-left">
                        <i class="entypo-doc-text"></i>Ver detalles
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>			
    </table> 
    </div>

    <!-- Pedidos -->
    <div class="tab-pane" id="pedidos">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#newPedidoModal">
            <i class="entypo-plus"></i>Nuevo pedido
        </button>
        <table class="table table-bordered datatable" id="table-2">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha pedido</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaPedidos = $resultPedidos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $listaPedidos["pedido_desc"];?></td>
                    <td><?php echo $listaPedidos["pedido_fecha"];?></td>
                    <td><?php echo $listaPedidos["ep_nombre"];?></td>
                    <td width="100px">
                        <a href="index.php?sec=edit-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $listaPedidos['pedido_id'];?>" class="btn btn-info btn-sm btn-icon icon-left">
                            <i class="entypo-doc-text"></i>Ver detalles
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>			
        </table> 
        </div>
    </div>
</div>

<!-- Modal Actualiza Stock-->
<div class="modal fade" id="modalUpdateInsumo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Actualizar Stock</h3>
            </div>
            <div class="modal-body">
            <form id="formUpdateInsumo" name="formUpdateInsumo">

            <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
            <input type="hidden" name="insumoId" id="insumoId" value="0">

            <label for="newStock">Stock</label>
            <input type="number" name="newStock" id="newStock" class="form-control form-control-sm noEnterSubmit"
            data-validate="required" data-message-required="Debe ingresar el nuevo stock." required>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success">Actualizar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Pedido-->
<div class="modal fade" id="newPedidoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Nuevo Pedido</h3>
            </div>
            <div class="modal-body">
            <form id="formAddPedido" name="formAddPedido">

            <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
            <input type="hidden" name="userId" value="<?php echo $_SESSION['userid'];?>">

            <label for="pedidoDesc">Descripción</label>
            <input type="text" name="pedidoDesc" id="pedidoDesc" class="form-control form-control-sm noEnterSubmit" required>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" name="addPedido" id="addPedido" class="btn btn-success">Agregar</button>
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
<script src="assets/js/toastr.js"></script>

<?php } ?>