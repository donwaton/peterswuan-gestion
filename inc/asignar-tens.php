<?php include './bin/select-tens-paciente.php'; ?>

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
            <td><?php if($listaUsuarios["paciente_nombre"]==""){
                echo '<div class="alert-warning">Sin paciente asignado</div>';
            } else {
                echo $listaUsuarios["paciente_nombre"];
            } ?></td>
            <td></td>
        </tr>
    <?php } ?>
    </tbody>			
</table>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>