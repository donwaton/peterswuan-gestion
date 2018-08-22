<?php 
include './bin/select-tens-paciente.php'; 
?>

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

        $('#updateInsumo').click(function(){
            var pacienteId = document.forms["formAsignarPaciente"]["pacienteId"].value;
            var userId = document.forms["formAsignarPaciente"]["userId"].value;
            if(pacienteId =="0"){
                alert("Debe seleccionar un paciente");
            } 
            else {
                $.ajax({
                    url:"bin/asignar-tens-paciente.php",
                    method:"POST",
                    data:$('#formAsignarPaciente').serialize(),
                    success:function(response){
                        console.log(response);
                        document.forms["formAsignarPaciente"]["pacienteId"].value = "";
                        document.getElementById('listUsuario'+userId).innerHTML = response;
                        }
                });
            } 
        });

    } );
</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li class="active">
    <strong>Lista de usuarios</strong>
  </li>
</ol>
      
<h2>Lista de usuarios</h2>
<br />
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>TENS</th>
            <th>Paciente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while($listaUsuarios = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $listaUsuarios["user_names"];?></td>
            <td id="listUsuario<?php echo $listaUsuarios['user_id'];?>"><?php if($listaUsuarios["paciente_nombre"]==""){
                echo '<div class="alert-warning">Sin paciente asignado</div>';
            } else {
                echo $listaUsuarios["paciente_nombre"];
            } ?></td>
            <td>
            <button type="button" class="btn btn-info btn-xs" onclick="
                document.getElementById('userId').value = '<?php echo $listaUsuarios['user_id'];?>';
                $('#modalAsignarPaciente').modal('show');">
                    <i class="entypo-user-add"></i><span class="hidden-xs">Asignar Paciente</span>
            </button>
            </td>
        </tr>
    <?php } ?>
    </tbody>			
</table>

<!-- Modal Asignar TENS-->
<div class="modal fade" id="modalAsignarPaciente" tabindex="-1" role="dialog" aria-labelledby="modalAsignarPaciente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Asignar Paciente</h3>
            </div>
            <div class="modal-body">
            <form id="formAsignarPaciente" name="formAsignarPaciente">
            <input type="hidden" name="userId" id="userId" value="0">

            <label for="pacienteId">Paciente</label>
            <select class="form-control form-control-sm" name="pacienteId" id="pacienteId" required>
                <option value="0"></option>
            <?php while($listaPacientes = $resultPacientes->fetch_assoc()) { ?>
                <option value="<?php echo $listaPacientes["paciente_id"];?>"><?php echo $listaPacientes["paciente_nombre"];?></option>
            <?php } ?>
            </select>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success" data-dismiss="modal">Asignar</button>
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