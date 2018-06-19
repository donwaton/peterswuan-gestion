<?php include './bin/select-usuarios.php'; ?>

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
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Perfil</th>
        </tr>
    </thead>
    <tbody>
    <?php while($listaUsuarios = $result->fetch_assoc()) { ?>
        <tr class="odd gradeX">
            <td><?php echo $listaUsuarios["user_name"];?></td>
            <td><?php echo $listaUsuarios["user_names"];?></td>
            <td><?php echo $listaUsuarios["user_email"];?></td>
            <td><?php echo $listaUsuarios["tipousuario_nombre"];?></td>
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