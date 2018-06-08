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

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>