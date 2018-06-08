<?php include './bin/select-pedidos-despacho.php'; ?>

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
    <strong>Lista de pedidos pendientes de despacho</strong>
  </li>
</ol>
      
<h2>Lista de pedidos pendientes de despacho</h2>
<br />
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Paciente</th>
            <th>Profesional</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while($listaPedidos = $resultPedidos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $listaPedidos["pedido_desc"];?></td>
            <td><?php echo $listaPedidos["paciente_nombre"];?></td>
            <td><?php echo $listaPedidos["user_names"];?></td>
            <td><?php echo $listaPedidos["ultima_fecha"];?></td>
            <td width="100px">
                <a href="index.php?sec=despacho-pedido&id=<?php echo $listaPedidos["paciente_id"];?>&pid=<?php echo $listaPedidos['pedido_id'];?>" 
                    class="btn btn-info btn-sm btn-icon icon-left">
                    <i class="entypo-doc-text"></i>Ver detalles
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