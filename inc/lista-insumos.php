<?php include './bin/select-insumos.php'; ?>

<script type="text/javascript">
    jQuery( document ).ready( function( $ ) {
        var $table1 = jQuery( '#table-1' );
        
        // Initialize DataTable
        $table1.DataTable( {
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": true
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
    <strong>Lista de insumos</strong>
  </li>
</ol>
      
<h2>Lista de insumos</h2>
<br />
		
<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Precio</th>
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
            <td><?php echo $listaInsumos["insumo_precio"];?></td>
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


<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>