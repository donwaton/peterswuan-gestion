<?php include './bin/select-pacientes.php'; ?>

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        var $table1 = jQuery( '#table-1' );
        
        // Initialize DataTable
        $table1.DataTable( {
            paging: false
        });
        
        // Initalize Select Dropdown after DataTables is created
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });
    } );
</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li class="active">
    <strong>Lista de paciente</strong>
  </li>
</ol>
      
<h2>Lista de pacientes</h2>
<br />

 <!-- Crear paciente -->
 <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==3) { ?>
 <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#newPaciente">
    <i class="entypo-user-add"></i>Paciente nuevo
</button>
 <br /> <br />
 <?php } ?>

<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Último pedido</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while($listaPacientes = $result->fetch_assoc()) { ?>
        <tr class="odd gradeX">
            <td><?php echo $listaPacientes["paciente_nombre"];?></td>
            <td><?php echo $listaPacientes["ultima_fecha"];?></td>
            <td><?php echo $listaPacientes["ep_nombre"];?></td>
            <td width="100px">
                <a href="index.php?sec=paciente&id=<?php echo $listaPacientes["paciente_id"];?>" class="btn btn-info btn-sm btn-icon icon-left">
                    <i class="entypo-vcard"></i>Ver ficha
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>			
</table>

<!-- Modal Agregar Paciente-->
<div class="modal fade" id="newPaciente" tabindex="-1" role="dialog" aria-labelledby="newPaciente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Nuevo Paciente</h3>
            </div>
            <div class="modal-body">
            <form id="formAddPaciente" name="formAddPaciente">
            <label for="pacienteNombre">Nombre</label>
            <input type="text" name="pacienteNombre" id="pacienteNombre" class="form-control form-control-sm">
            <label for="pacienteDomicilio">Domicilio</label>
            <input type="text" name="pacienteDomicilio" id="pacienteDomicilio" class="form-control form-control-sm">
            <br/>
            <p><b>Datos de Contacto</b></p> 
            <div class="row">
                <div class="col-sm-6">
                    <label for="contactoNombre1">Nombre</label>
                    <input type="text" name="contactoNombre1" id="contactoNombre1" class="form-control form-control-sm">
                </div>
                <div class="col-sm-6">
                    <label for="contactoFono1">Teléfono</label>
                    <input type="text" name="contactoFono1" id="contactoFono1" class="form-control form-control-sm">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label for="posDosis">Nombre</label>
                    <input type="text" name="posDosis" id="posDosis" class="form-control form-control-sm">
                </div>
                <div class="col-sm-6">
                    <label for="contactoFono2">Teléfono</label>
                    <input type="text" name="contactoFono2" id="contactoFono2" class="form-control form-control-sm">
                </div>
            </div>
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

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>