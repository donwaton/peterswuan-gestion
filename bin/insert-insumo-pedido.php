<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    $sqlinsert = "INSERT INTO insumo_pedido(ip_id, insumo_id, pedido_id, ip_cantidad, mp_id) 
    VALUES ( NULL, '".$_POST['insumoId']."', '".$_POST['pedidoId']."', '".$_POST['newCantidad']."', '".$_POST['motivo']."');";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();

    $sqlPacienteId = "SELECT paciente_id FROM pedido, insumo_pedido WHERE pedido.pedido_id=insumo_pedido.pedido_id AND ip_id=".$result['id'].";";
    $ejecutarPacienteId = $conn->query($sqlPacienteId);
    $resultPacienteId = $ejecutarPacienteId->fetch_assoc();

    $sqlNewPedido = "SELECT * FROM 
        (SELECT insumo_pedido.ip_id,insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, insumo_pedido.ip_cantidad,mp_nombre, insumo_pedido.insumo_id 
        FROM insumo, insumo_pedido, tipo_insumo, motivo_pedido 
        WHERE insumo.insumo_id=insumo_pedido.insumo_id 
        AND motivo_pedido.mp_id=insumo_pedido.mp_id 
        AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id 
        AND ip_id=".$result['id'].") a 
        LEFT JOIN 
        (SELECT * FROM paciente_insumo WHERE paciente_insumo.paciente_id=".$resultPacienteId['paciente_id'].") b ON b.insumo_id=a.insumo_id;";
    $ejecutarNewPedido = $conn->query($sqlNewPedido);
    $resultNewPedido = $ejecutarNewPedido->fetch_assoc();

    $funcionAjax = "var r =  confirm('Esta seguro que desea eliminar el insumo?');
    if(r==true){
    $.ajax({
        type:'POST',
        url:'./bin/delete-insumo-pedido.php',
        data:'idInsumo=".$result['id']."',
        success:function(response){
            $('#table-pedido').DataTable().row($('#listInsumo".$result['id']."')).remove().draw();
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
    });}";
    
    $btneliminar = '<button type="button" class="btn btn-danger btn-xs" onclick="'.$funcionAjax.'"><i class="entypo-trash"></i></button>';
    $return_arr = array();  

    $row_array['id'] = $resultNewPedido['ip_id'];
    $row_array['nombre'] = $resultNewPedido['insumo_nombre'];
    $row_array['tipo'] = $resultNewPedido['tipoinsumo_nombre'];
    $row_array['cantidad'] = $resultNewPedido['ip_cantidad'];
    $row_array['motivo'] = $resultNewPedido['mp_nombre'];
    $row_array['stock'] = $resultNewPedido['pi_stock'];
    $row_array['consumo'] = $resultNewPedido['pi_consumo'];
    $row_array['eliminar'] = $btneliminar;
    
    array_push($return_arr,$row_array);
    
    echo json_encode($return_arr);
    }
else {
    echo "error";
} 
?>