<?php
include './bin/select-edit-pedido.php';

$class1 = $class2 = $class3 = $class4 = $class5 = "hidden-xs";

if ($pedido['ep_id'] == 1) {
    $class1 = "alert-info";
}
if ($pedido['ep_id'] == 2) {
    $class1 = "text-success hidden-xs";
    $class2 = "alert-info";
}
if ($pedido['ep_id'] == 3) {
    $class1 = "text-success hidden-xs";
    $class2 = "text-success hidden-xs";
    $class3 = "alert-info";
}
if ($pedido['ep_id'] == 4) {
    $class1 = "text-success hidden-xs";
    $class2 = "text-success hidden-xs";
    $class3 = "text-success hidden-xs";
    $class4 = "alert-info";
}
if ($pedido['ep_id'] == 5) {
    $class1 = "text-success hidden-xs";
    $class2 = "text-success hidden-xs";
    $class3 = "text-success hidden-xs";
    $class4 = "text-success hidden-xs";
    $class5 = "alert-success";
}
if ($pedido['ep_id'] == 6) {
    $class1 = "text-success hidden-xs";
    $class2 = "text-success hidden-xs";
    $class3 = "text-success hidden-xs";
    $class4 = "text-success hidden-xs";
    $class5 = "alert-danger";
}
?>

<script type="text/javascript">
    jQuery( document ).ready( function() {
        var $table1 = jQuery( '#table-1' );
        var $tablePedido = jQuery( '#table-pedido' );

        // Initialize DataTable1
        $tablePedido.DataTable( {
            "sDom": "tip",
            paging: false
        });

        // Initalize Select Dropdown after DataTables is created
        $tablePedido.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });

        // Initialize DataTable1
        $table1.DataTable( {
            "sDom": "tip",
            paging: false
        });
        // Initalize Select Dropdown after DataTables is created
        $table1.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
            minimumResultsForSearch: -1
        });

        $('#newTipoInsumo').on('change',function(){
            var tipoInsumoID = $(this).val();
            if(tipoInsumoID){
                $.ajax({
                    type:'POST',
                    url:'./bin/select-insumo-tipoinsumo.php',
                    data:'tipoinsumo_id='+tipoInsumoID,
                    success:function(html){
                        $('#newInsumo').empty();
                        $('#newInsumo').append(html);
                    }
                });
            }
        });

        $('#addInsumo').click(function(){
            $.ajax({
                url:"bin/insert-insumo-pedido.php",
                method:"POST",
                data:$('#formAddInsumo').serialize(),
                success:function(data){
                    var obj = JSON.parse(data);
                    $('#table-pedido').DataTable().row.add({
                        "DT_RowId": "listInsumo"+obj[0].id,
                        "0": obj[0].nombre,
                        "1": obj[0].tipo,
                        "2": obj[0].motivo,
                        "3": obj[0].cantidad,
                        "4": obj[0].eliminar}).draw();
                    document.getElementById('motivo').value = '';
                    document.getElementById('newTipoInsumo').value = '';
                    document.getElementById('newInsumo').value = '';
                    document.getElementById('newCantidad').value = '';

                    var opts = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-top-full-width",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "500",
                        "timeOut": "2000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success("Se ha agregado exitósamente al pedido", "Ingreso exitóso", opts);

                }
            });
        });
    });
</script>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li class="hidden-xs">
    <a href="index.php">Inicio</a>
  </li>
  <?php if ($_SESSION['perfil'] != 5) {?>
  <li class="hidden-xs">
    <a href="index.php?sec=lista-pacientes">Lista de pacientes</a>
  </li>
  <li>
    <a href="index.php?sec=paciente&id=<?php echo $pedido['paciente_id']; ?>">Ficha <?php echo $pedido['paciente_nombre'] ?></a>
  </li>
  <?php }if ($_SESSION['perfil'] == 5) {?>
  <li>
    <a href="index.php?sec=paciente-tens&id=<?php echo $pedido['paciente_id']; ?>">Ficha <?php echo $pedido['paciente_nombre'] ?></a>
  </li>
  <?php }?>
  <li class="active">
    <strong>Detalles pedido</strong>
  </li>
</ol>

<h2 class="hidden-xs">Estado del pedido</h2> <br>

<div class="row" align="center">
    <div class="col-sm-1 col-xs-4"><p class="visible-xs"><b>Estado Pedido</b></p></div>
    <div class="col-sm-2 col-xs-8 <?php echo $class1; ?>" style="border-radius: 25px;"><i class="entypo-clipboard"></i><br class="hidden-xs">Borrador</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class2; ?>" style="border-radius: 25px;"><i class="entypo-check"></i><br class="hidden-xs">Pendiente de<br class="hidden-xs">aprobación</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class3; ?>" style="border-radius: 25px;"><i class="entypo-box"></i><br class="hidden-xs">En preparación</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class4; ?>" style="border-radius: 25px;"><i class="fa fa-truck"></i><br class="hidden-xs">En ruta</div>
    <div class="col-sm-2 col-xs-8 <?php echo $class5; ?>" style="border-radius: 25px;"><i class="entypo-home"></i><br class="hidden-xs">Entregado</div>
    <div class="col-sm-1"></div>
</div>
<hr>

<!-- Solicitar borrador -->
<?php if ($pedido['ep_id'] == 1 && $_SESSION['perfil'] == 5) {?>
<button type="button" class="btn btn-success btn-icon icon-left" onclick="
    $.ajax({
        type:'POST',
        url:'./bin/solicitar-aprobacion.php',
        data:{idPedido:<?php echo $_GET['pid']; ?>,userId:<?php echo $_SESSION['userid']; ?>},
        success:function(response){
            <?php if ($_SESSION['perfil'] == 5) {?>
            window.location.replace('index.php?sec=paciente-tens&id=<?php echo $_GET['id']; ?>');
            <?php }?>
        }
    });
    ">
    <i class="entypo-check"></i>Solicitar aprobación
</button>
<br />
<?php }?>

<!-- Aprobar pedido -->
<?php if ($pedido['ep_id'] == 1 && $_SESSION['perfil'] != 5) {?>
<button type="button" class="btn btn-success btn-icon icon-left" onclick="
    $.ajax({
        type:'POST',
        url:'./bin/aprobar-pedido.php',
        data:{idPedido:<?php echo $_GET['pid']; ?>,userId:<?php echo $_SESSION['userid']; ?>},
        success:function(response){
            window.location.replace('index.php?sec=paciente&id=<?php echo $_GET['id']; ?>');
        }
    });
    ">
    <i class="entypo-check"></i>Aprobar pedido
</button>
<br />
<?php }?>

<!-- Cerrar pedido -->
<?php /* if ($pedido['ep_id'] == 4) {?>
<a href="index.php?sec=confirmar-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $_GET['pid'];?>" class="btn btn-success btn-icon icon-left">
    <i class="entypo-search"></i>Verificar Recepción
</a>
<br />
<?php } */?>

<h2>Lista de Insumos Pedido</h2>

<br />

    <div>
    <?php if ($_SESSION['perfil'] == 1 || ($_SESSION['perfil'] == 5 && $pedido['ep_id'] == 1) || ($_SESSION['perfil'] == 4 && $pedido['ep_id'] < 3)) {?>
    <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#exampleModal">
        <i class="entypo-plus"></i>Agregar insumo
    </button>
    <?php }?>
    <table class="table table-bordered datatable" id="table-pedido">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="hidden-xs">Tipo</th>
                    <th class="hidden-xs">Motivo</th>
                    <th style="width:80px;">Pedido</th>
                    <?php if($pedido['ep_id'] > 4){?>
                    <th style="width:80px;">Entregado</th>
                    <?php } ?>
                    <?php if ($_SESSION['perfil'] == 1 || ($_SESSION['perfil'] == 5 && $pedido['ep_id'] == 1) || ($_SESSION['perfil'] == 4 && $pedido['ep_id'] < 3)) {?>
                    <th style="width:80px;">Acciones</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while ($listaInsumosPedido = $resultInsumosPedido->fetch_assoc()) {?>
                <tr id="listInsumo<?php echo $listaInsumosPedido['ip_id']; ?>">
                    <td><?php echo $listaInsumosPedido["insumo_nombre"]; ?></td>
                    <td class="hidden-xs"><?php echo $listaInsumosPedido["tipoinsumo_nombre"]; ?></td>
                    <td class="hidden-xs"><?php echo $listaInsumosPedido["mp_nombre"]; ?></td>
                    <td><?php echo $listaInsumosPedido["ip_cantidad"]; ?></td>
                    <?php if($pedido['ep_id'] > 4){
                        if($listaInsumosPedido["ip_estado"]==1){
                            $estadoPedido = $listaInsumosPedido["ip_cantidad"];
                            $classEstado = "alert-success";
                        } else {
                            $estadoPedido = $listaInsumosPedido["ip_entregado"];
                            $classEstado = "alert-danger";
                        }
                    ?>
                    <td class="<?php echo $classEstado;?>"><?php echo $estadoPedido; ?></td>
                    <?php }?>
                    <?php if ($_SESSION['perfil'] == 1 || ($_SESSION['perfil'] == 5 && $pedido['ep_id'] == 1) || ($_SESSION['perfil'] == 4 && $pedido['ep_id'] < 3)) {?>
                   <td width="80px">
                        <button type="button" class="btn btn-danger btn-xs" onclick="
                        var r =  confirm('Esta seguro que desea eliminar el insumo?');
                        if(r==true){
                        $.ajax({
                            type:'POST',
                            url:'./bin/delete-insumo-pedido.php',
                            data:'idInsumo=<?php echo $listaInsumosPedido['ip_id']; ?>',
                            success:function(response){
                                $('#table-pedido').DataTable().row($('#listInsumo<?php echo $listaInsumosPedido['ip_id']; ?>')).remove().draw();
                                var opts = {
                                    'closeButton': true,
                                    'debug': false,
                                    'positionClass': 'toast-top-full-width',
                                    'onclick': null,
                                    'showDuration': '300',
                                    'hideDuration': '1000',
                                    'timeOut': '3000',
                                    'extendedTimeOut': '1000',
                                    'showEasing': 'swing',
                                    'hideEasing': 'linear',
                                    'showMethod': 'fadeIn',
                                    'hideMethod': 'fadeOut'
                                };
                                toastr.info('Se ha eliminado el insumo del pedido', 'Eliminación exitosa', opts);
                            }
                        })};
                        ">
                            <i class="entypo-trash"></i>
                        </button>
                        <!--
                        <button type="button" class="btn btn-info btn-xs">
                            <i class="entypo-pencil"></i>
                        </button>
                        -->
                    </td>
                    <?php }?>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
    <?php if ($pedido['ep_id'] == 1) {?>
    <div>
    <h3>Pedido Sugerido</h3>
    <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th style="width:80px;">Consumo</th>
                    <th style="width:80px;">Stock</th>
                    <th style="width:80px;">Pedido</th>
                    <th style="width:80px;">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-consumo">
            <?php while ($listaSugeridos = $resultSugeridos->fetch_assoc()) {
    if ($listaSugeridos["pedido_sugerido"] > $listaSugeridos["ip_cantidad"]) {?>
                <tr id="listSugerido<?php echo $listaSugeridos["pi_id"]; ?>">
                    <td><?php echo $listaSugeridos["insumo_nombre"]; ?></td>
                    <td><?php echo $listaSugeridos["tipoinsumo_nombre"]; ?></td>
                    <td><?php echo $listaSugeridos["pi_consumo"]; ?></td>
                    <td><?php echo $listaSugeridos["pi_stock"]; ?></td>
                    <td><input name="<?php echo $listaSugeridos["pi_id"]; ?>"
                        id="<?php echo $listaSugeridos["pi_id"]; ?>"
                        style="width:80px;" type="number" class="form-control input-sm col-md-2"
                        value="<?php echo $listaSugeridos["pedido_sugerido"]; ?>"></td>
                    <td width="80px">
                        <button id="btnAgregar<?php echo $listaSugeridos["pi_id"]; ?>" type="button" class="btn btn-blue btn-sm btn-icon icon-left" onclick="
                            document.getElementById('btnAgregar<?php echo $listaSugeridos['pi_id']; ?>').disabled = true;
                            var cantidad = ($('#<?php echo $listaSugeridos["pi_id"]; ?>').val());
                            $.ajax({
                                type:'POST',
                                url:'./bin/insert-insumo-pedido.php',
                                data: { pedidoId: <?php echo $_GET['pid']; ?>, insumoId: <?php echo $listaSugeridos["insumo_id"]; ?>, newCantidad: cantidad, motivo: 1 },
                                success:function(data){
                                    var obj = JSON.parse(data);
                                $('#table-pedido').DataTable().row.add({
                                    'DT_RowId': 'listInsumo'+obj[0].id,
                                    '0': obj[0].nombre,
                                    '1': obj[0].tipo,
                                    '2': obj[0].motivo,
                                    '3': obj[0].cantidad,
                                    '4': obj[0].eliminar}).draw();
                                    $('#table-1').DataTable().row($('#listSugerido<?php echo $listaSugeridos["pi_id"]; ?>')).remove().draw();
                                    var opts = {
                                        'closeButton': true,
                                        'debug': false,
                                        'positionClass': 'toast-top-full-width',
                                        'onclick': null,
                                        'showDuration': '300',
                                        'hideDuration': '500',
                                        'timeOut': '2000',
                                        'extendedTimeOut': '1000',
                                        'showEasing': 'swing',
                                        'hideEasing': 'linear',
                                        'showMethod': 'fadeIn',
                                        'hideMethod': 'fadeOut'
                                    };

                                    toastr.success('Se ha agregado exitósamente al pedido', 'Ingreso exitóso', opts);
                                }
                            });
                        ">
                            <i class="entypo-plus"></i>Agregar
                        </button>
                        <!--
                        <button type="button" class="btn btn-info btn-xs">
                            <i class="entypo-pencil"></i>
                        </button>
                        -->
                    </td>
                </tr>
            <?php }}?>
            </tbody>
        </table>
    </div>
    <?php }?>

</div>

<!-- Modal Agregar Insumo-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Insumo Nuevo</h3>
            </div>
            <div class="modal-body">
            <form id="formAddInsumo" name="formAddInsumo">

            <input type="hidden" name="pedidoId" value="<?php echo $_GET['pid']; ?>">

            <label for="motivo">Motivo</label>
            <select class="form-control form-control-sm" name="motivo" id="motivo" required>
            <option value="0"></option>
            <?php
while ($listaMotivos = $resultMotivo->fetch_assoc()) {?>
            <option value="<?php echo $listaMotivos["mp_id"]; ?>"><?php echo $listaMotivos["mp_nombre"]; ?></option>
            <?php }?>
            </select>

            <label for="tipoinsumo">Tipo</label>
            <select class="form-control form-control-sm" name="tipoinsumoId" id="newTipoInsumo" required>
            <option value="0"></option>
            <?php
while ($listaTipoInsumo = $resultTipoInsumo->fetch_assoc()) {?>
            <option value="<?php echo $listaTipoInsumo["tipoinsumo_id"]; ?>"><?php echo $listaTipoInsumo["tipoinsumo_nombre"]; ?></option>
            <?php }?>
            </select>

            <label for="newInsumo">Nombre</label>
            <select class="form-control form-control-sm" name="insumoId" id="newInsumo" required>
            <option value=""></option>
            </select>

            <label for="newCantidad">Cantidad</label>
            <input type="number" name="newCantidad" id="newCantidad" class="form-control form-control-sm">
        </form>
        <div class="modal-footer">
            <button type="button" id="refreshInsumos" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="addInsumo" id="addInsumo" class="btn btn-success" data-dismiss="modal">Agregar al pedido</button>
        </div>
        </div>
    </div>
</div>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<style>
.dataTables_info {
    display: none;
}
</style>

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/toastr.js"></script>