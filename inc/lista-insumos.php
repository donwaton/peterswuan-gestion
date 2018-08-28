<?php include './bin/select-insumos.php'; ?>

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        var $table1 = jQuery( '#table-1' );
        $table1.DataTable( {
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": true
        });
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });
        //Update Insumo
        $('#updateInsumo').click(function(){
            document.getElementById('updateInsumo').disabled = true;                                
            $.ajax({
                url:"bin/update-insumo.php",
                method:"POST",
                data:$('#formUpdateInsumo').serialize(),
                success:function(response){
                    document.getElementById('updateInsumo').disabled = false;
                    window.location = 'index.php?sec=lista-insumos';
                    }
            });    
        });
        //Update Insumo
        $('#insertInsumo').click(function(){
            document.getElementById('insertInsumo').disabled = true;                                
            $.ajax({
                url:"bin/insert-insumo.php",
                method:"POST",
                data:$('#formInsertInsumo').serialize(),
                success:function(response){
                    document.getElementById('insertInsumo').disabled = false;
                    window.location = 'index.php?sec=lista-insumos';
                    }
            });    
        });
    });
</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li class="active">
    <strong>Lista de insumos</strong>
  </li>
</ol>
      
<h2>Lista de insumos</h2>
<br />

<?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2) { ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#modalInsertInsumo">
    <i class="entypo-plus"></i>Nuevo insumo
</button>

<!-- Modal Nuevo Insumo-->
<div class="modal fade" id="modalInsertInsumo" tabindex="-1" role="dialog" aria-labelledby="modalInsertInsumo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="modalInsertInsumo">Actualizar Pedido</h3>
            </div>
            <div class="modal-body">
                <form id="formInsertInsumo" name="formInsertInsumo" onsubmit="false">
                    <input type="hidden" name="insumoId" id="insumoId" value="0">

                    <label for="nombreInsumo">Nombre insumo</label>
                    <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control form-control-sm noEnterSubmit"
                    data-validate="required" data-message-required="Debe ingresar el nombre del insumo." required>

                    <label for="tipoInsumo">Tipo</label>
                    <select class="form-control form-control-sm" name="tipoInsumo" id="tipoInsumo" required>
                        <option value="0"></option>
                    <?php while($listaTipoInsumo2 = $resultTipoInsumo2->fetch_assoc()) { ?>
                        <option value="<?php echo $listaTipoInsumo2["tipoinsumo_id"];?>"><?php echo $listaTipoInsumo2["tipoinsumo_nombre"];?></option>
                    <?php } ?>
                    </select>

                    <label for="stockInsumo">Stock</label>
                    <input type="number" name="stockInsumo" id="stockInsumo" class="form-control form-control-sm noEnterSubmit">

                    <label for="precioInsumo">Precio</label>
                    <input type="number" name="precioInsumo" id="precioInsumo" class="form-control form-control-sm noEnterSubmit">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" name="insertInsumo" id="insertInsumo" class="btn btn-success" data-dismiss="modal">Crear Insumo</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2) { ?>
            <th>Precio</th>
            <th>Acciones</th>
            <?php } ?>
            <!-- Proxima versión
            <th>Stock</th>
            <th>Demanda</th>
            <th>Estado</th>
            -->
        </tr>
    </thead>
    <tbody>
    <?php while($listaInsumos = $resultInsumos->fetch_assoc()) { ?>
        <tr class="odd gradeX">
            <td><?php echo $listaInsumos["insumo_nombre"];?></td>
            <td><?php echo $listaInsumos["tipoinsumo_nombre"];?></td>
            <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2) { ?>
            <td><?php echo $listaInsumos["insumo_precio"];?></td>
            <td>
            <button type="button" class="btn btn-info btn-xs" onclick="
                document.getElementById('insumoId').value = '<?php echo $listaInsumos['insumo_id'];?>';
                document.getElementById('nombreInsumo').value = '<?php echo $listaInsumos['insumo_nombre'];?>';
                document.getElementById('tipoInsumo').value = '<?php echo $listaInsumos['tipoinsumo_id'];?>';
                document.getElementById('stockInsumo').value = '<?php echo $listaInsumos['insumo_stock'];?>';
                document.getElementById('precioInsumo').value = '<?php echo $listaInsumos['insumo_precio'];?>';
                $('#modalUpdateInsumo').modal('show');">
                <i class="entypo-pencil"></i>
            </button>
            </td>
            <?php } ?>
            <!-- Proxima version no noob
            <td><?php /* echo $listaInsumos["insumo_stock"];?></td>
            <td><?php echo $listaInsumos["demanda"];?></td>
            <td> 
            <?php 
                if($listaInsumos["insumo_stock"] && ""||$listaInsumos["demanda"]<>""){
                    if($listaInsumos["insumo_stock"]<=$listaInsumos["demanda"]){ 
                        $estadoDemanda = '<div class="label label-danger">Quiebre de Stock</div>'; 
                    } if($listaInsumos["insumo_stock"]>$listaInsumos["demanda"]){
                        if(($listaInsumos["insumo_stock"])<$listaInsumos["demanda"]*1.5){
                            $estadoDemanda = '<div class="label label-warning">Stock ajustado</div>';
                        } else { 
                            $estadoDemanda = '<div class="label label-success">Stock Suficiente</div>';
                        } 
                    }
                } else {
                    $estadoDemanda = '<div class="label label-info">Sin información</div>';  
                }
                echo $estadoDemanda;    */                
            ?>                        
            </td> -->
        </tr>
    <?php } ?>
    </tbody>			
</table>

<!-- Modal Actualiza Insumo-->
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
                    <input type="hidden" name="insumoId" id="insumoId" value="0">

                    <label for="nombreInsumo">Nombre insumo</label>
                    <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control form-control-sm noEnterSubmit"
                    data-validate="required" data-message-required="Debe ingresar el nombre del insumo." required>

                    <label for="tipoInsumo">Tipo</label>
                    <select class="form-control form-control-sm" name="tipoInsumo" id="tipoInsumo" required>
                        <option value="0"></option>
                    <?php while($listaTipoInsumo = $resultTipoInsumo->fetch_assoc()) { ?>
                        <option value="<?php echo $listaTipoInsumo["tipoinsumo_id"];?>"><?php echo $listaTipoInsumo["tipoinsumo_nombre"];?></option>
                    <?php } ?>
                    </select>

                    <label for="stockInsumo">Stock</label>
                    <input type="number" name="stockInsumo" id="stockInsumo" class="form-control form-control-sm noEnterSubmit">

                    <label for="precioInsumo">Precio</label>
                    <input type="number" name="precioInsumo" id="precioInsumo" class="form-control form-control-sm noEnterSubmit">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success" data-dismiss="modal">Actualizar</button>
            </div>
        </div>
    </div>
</div>


<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>