<?php 
include './bin/select-paciente.php';
while($datosPaciente = $result->fetch_assoc()) { ?>

<script type="text/javascript">
    jQuery( document ).ready( function() {
        var $table1 = jQuery( '#table-1' );
        var $table2 = jQuery( '#table-2' );

        // Initialize DataTable1
        $table1.DataTable( {
            paging: false
        });
        
        $table2.DataTable( {
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
                    }
                });
            }
        });

        $('#addInsumo').click(function(){       
            $.ajax({
                url:"bin/insert-insumo-paciente.php",
                method:"POST",
                data:$('#formAddInsumo').serialize(),
                success:function(data){ 
                    var obj = JSON.parse(data);
                    $('#table-1').DataTable().row.add({
                        "DT_RowId": "listInsumo"+obj[0].id,
                        "0": obj[0].nombre,
                        "1": obj[0].tipo,
                        "2": obj[0].consumo,
                        "3": obj[0].stock,
                        "4": obj[0].eliminar}).draw();
                    document.getElementById('newTipoInsumo').value = '';
                    document.getElementById('newInsumo').value = '';
                    document.getElementById('newStock').value = '';
                    document.getElementById('newConsumo').value = '';
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
                    
                    toastr.success("Se ha agregado "+obj[0].nombre+" al consumo del paciente", "Ingreso exitoso", opts);
                            
                    }
            });
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

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pacientes"><i class="fa-home"></i>Lista de pacientes</a>
  </li>
  <li class="active">
    <strong>Ficha de <?php echo $datosPaciente['paciente_nombre'];?></strong>
  </li>
</ol>
      
<h2>Ficha de <?php echo $datosPaciente['paciente_nombre'];?></h2>
<br />

<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
    <li>
        <a href="#contacto" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-user"></i></span>
            <span class="hidden-xs">Contacto</span>
        </a>
    </li>
    <li class="active">
        <a href="#consumo" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-box"></i></span>
            <span class="hidden-xs">Consumo</span>
        </a>
    </li>
    <li>
        <a href="#pedidos" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-clipboard"></i></span>
            <span class="hidden-xs">Pedidos</span>
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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#exampleModal">
            <i class="entypo-plus"></i>Agregar
        </button>
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Consumo</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaInsumos = $resultInsumos->fetch_assoc()) { ?>
                <tr id="listInsumo<?php echo $listaInsumos['pi_id'];?>">
                    <td><?php echo $listaInsumos["insumo_nombre"];?></td>
                    <td><?php echo $listaInsumos["tipoinsumo_nombre"];?></td>
                    <td><?php echo $listaInsumos["pi_consumo"];?></td>
                    <td><?php echo $listaInsumos["pi_stock"];?></td>
                    <td width="80px">
                        <button type="button" class="btn btn-danger btn-xs" onclick="                        
                        $.ajax({
                            type:'POST',
                            url:'./bin/delete-consumo.php',
                            data:'idInsumo=<?php echo $listaInsumos['pi_id'];?>',
                            success:function(response){
                                $('#table-1').DataTable().row($('#listInsumo<?php echo $listaInsumos['pi_id'];?>')).remove().draw();
                                var opts = {
                                    'closeButton': true,
                                    'debug': false,
                                    'positionClass': 'toast-top-full-width',
                                    'onclick': null,
                                    'showDuration': '300',
                                    'hideDuration': '1000',
                                    'timeOut': '3000',
                                    'extendedTimeOut': '1000',
                                    'showEasing': 'swing',
                                    'hideEasing': 'linear',
                                    'showMethod': 'fadeIn',
                                    'hideMethod': 'fadeOut'
                                };
                    
                                toastr.info('Se ha eliminado el insumo del consumo del paciente', 'Eliminación exitosa', opts);
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


<!-- Modal Agregar Insumo-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Insumo Nuevo</h3>
            </div>
            <div class="modal-body">
            <form id="formAddInsumo" name="formAddInsumo">

            <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">

            <label for="tipoinsumo">Tipo</label>
            <select class="form-control form-control-sm" name="tipoinsumoId" id="newTipoInsumo" required>
            <option value="0"></option>
            <?php 
            while($listaTipoInsumo = $resultTipoInsumo->fetch_assoc()) { ?>
            <option value="<?php echo $listaTipoInsumo["tipoinsumo_id"];?>"><?php echo $listaTipoInsumo["tipoinsumo_nombre"];?></option>
            <?php } ?>
            </select>

            <label for="newInsumo">Nombre</label>
            <select class="form-control form-control-sm" name="insumoId" id="newInsumo" required>
            <option value=""></option>
            </select>

            <label for="newConsumo">Consumo</label>
            <input type="number" name="newConsumo" id="newConsumo" class="form-control form-control-sm">

            <label for="newStock">Stock</label>
            <input type="number" name="newStock" id="newStock" class="form-control form-control-sm">
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="refreshInsumos" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="addInsumo" id="addInsumo" class="btn btn-success" data-dismiss="modal">Agregar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Insumo-->
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
            <input type="text" name="pedidoDesc" id="pedidoDesc" class="form-control form-control-sm">
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" name="addPedido" id="addPedido" class="btn btn-success">Agregar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal eliminación exitósa-->
<div class="modal" tabindex="-1" role="dialog" id="okDelete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p class=" alert alert-success">Insumo eliminado correctamente</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
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