<?php 
include './bin/select-paciente.php';
while($datosPaciente = $result->fetch_assoc()) { ?>

<script type="text/javascript">
    jQuery( document ).ready( function() {
        var $table1 = jQuery( '#table-1' );

        // Initialize DataTable1
        $table1.DataTable( {
            paging: false
        });

        // Initalize Select Dropdown after DataTables is created
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });

        $('#updateInsumo').click(function(){
            if(document.forms["formUpdateInsumo"]["newStock"].value ==""){
                alert("Debe ingresar el nuevo stock para actualizar");
            } 
            else {
                /*$.ajax({
                    url:"bin/update-insumo-paciente.php",
                    method:"POST",
                    data:$('#formUpdateInsumo').serialize(),
                    success:function(data){ 
                        var obj = JSON.parse(data);
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
                });*/
            } 
        });

    } );
</script>

<!-- Inicio HTML -->
      
<h2>Ficha de <?php echo $datosPaciente['paciente_nombre'];?></h2>
<br />

<ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
    <li class="active">
        <a href="#consumo" data-toggle="tab">
            <span class="visible-xs"><i class="entypo-box"></i></span>
            <span class="hidden-xs">Consumo</span>
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
                    <th><i class="entypo-pencil"></i></th>

                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaInsumos = $resultInsumos->fetch_assoc()) { ?>
                <tr id="listInsumo<?php echo $listaInsumos['pi_id'];?>">
                    <td><?php echo $listaInsumos["insumo_nombre"];?></td>
                    <td class="hidden-xs"><?php echo $listaInsumos["tipoinsumo_nombre"];?></td>
                    <td class="hidden-xs"><?php echo $listaInsumos["pi_consumo"];?></td>
                    <td><?php echo $listaInsumos["pi_stock"];?></td>     
                    <td><button type="button" class="btn btn-info btn-xs" onclick="
                        document.getElementById('insumoId').value = '<?php echo $listaInsumos['pi_id'];?>';
                        document.getElementById('newStock').value = '';
                        $('#modalUpdateInsumo').modal('show');
                    ">
								<i class="entypo-pencil"></i>
						</button>
                    </td>               
                </tr>
            <?php } ?>
            </tbody>			
        </table> 
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
            <input type="number" name="newStock" id="newStock" class="form-control form-control-sm"
            data-validate="required" data-message-required="Debe ingresar el nuevo stock.">
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success">Actualizar</button>
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