<?php
include './bin/select-pedido.php';
?>

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        var $table1 = jQuery( '#table-1' );

        // Initialize DataTable1
        $table1.DataTable( {
            "sDom": "tip",
            paging: false
        });
        
        // Initalize Select Dropdown after DataTables is created
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });
    });

</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pacientes"><i class="fa-home"></i>Lista de pacientes</a>
  </li>
  <li>
    <a href="index.php?sec=paciente&id=<?php echo $pedido['paciente_id'];?>"><i class="fa-home"></i>Ficha <?php echo $pedido['paciente_nombre']?></a>
  </li>
  <li class="active">
    <strong>Detalles pedido</strong>
  </li>
</ol>
      
<h2>Detalles Pedido</h2>
<br />

    <div>

    </div>

    <div>
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Pedido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $listaInsumosPedido["insumo_nombre"];?></td>
                    <td><?php echo $listaInsumosPedido["tipoinsumo_nombre"];?></td>
                    <td><?php echo $listaInsumosPedido["ip_cantidad"];?></td>
                    <td width="100px">
                    <!--
                        <a href="index.php?sec=pedido&id=<?php echo $listaPedidos['pedido_id'];?>" class="btn btn-info btn-sm btn-icon icon-left">
                            <i class="entypo-doc-text"></i>Ver detalles
                        </a>
                        -->
                    </td>
                </tr>
            <?php } ?>
            </tbody>			
        </table> 
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