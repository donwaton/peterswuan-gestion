<?php include './bin/select-pedidos-ruta.php'; ?>

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
    <strong>Lista de pedidos en ruta</strong>
  </li>
</ol>
      
<h2>Lista de pedidos en ruta</h2>
<br />
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php while($listaPedidos = $resultPedidos->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $listaPedidos["paciente_nombre"];?></td>
            <?php if($listaPedidos["paciente_dom_map"]!=''){?>
                <td><a href="<?php echo $listaPedidos['paciente_dom_map'];?>" target="_blank"><?php echo $listaPedidos["paciente_domicilio"];?></a></td>
            <?php } else { echo "<td>".$listaPedidos["paciente_domicilio"]."</td>"; }?>
            <td width="100px">
                <a href="index.php?sec=confirmar-pedido&id=<?php echo $listaPedidos["paciente_id"];?>&pid=<?php echo $listaPedidos['pedido_id'];?>" 
                    class="btn btn-info btn-sm btn-icon icon-left">
                    <i class="entypo-doc-text"></i>Ver
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