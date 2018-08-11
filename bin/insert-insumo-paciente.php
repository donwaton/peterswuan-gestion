<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    $sqlinsert = "INSERT 
    INTO paciente_insumo (paciente_id, insumo_id, pi_consumo, pi_stock) 
    VALUES ('".$_POST['pacienteId']."', '".$_POST['insumoId']."', '".$_POST['newConsumo']."', '".$_POST['newStock']."');";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();

    $sqlNewPedido = "SELECT paciente_insumo.pi_id,insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, paciente_insumo.pi_consumo, paciente_insumo.pi_stock 
    FROM insumo, paciente_insumo, tipo_insumo
    WHERE insumo.insumo_id=paciente_insumo.insumo_id
    AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
    AND pi_id=".$result['id'].";";
    $ejecutarNewPedido = $conn->query($sqlNewPedido);
    $resultNewPedido = $ejecutarNewPedido->fetch_assoc();

    $funcionEditar = "document.getElementById('insumoId').value = '".$resultNewPedido['pi_id']."';
    document.forms['formUpdateInsumo']['newConsumo'].value = '';
    $('#modalUpdateInsumo').modal('show');";

    $funcionAjax = "$.ajax({
        type:'POST',
        url:'./bin/delete-consumo.php',
        data:'idInsumo=".$result['id']."',
        success:function(response){
            $('#table-1').DataTable().row($('#listInsumo".$result['id']."')).remove().draw();
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

            toastr.info('Se ha eliminado el insumo del consumo del paciente', 'Eliminación exitosa', opts);
        }
    });";
    $btneliminar = '<button type="button" class="btn btn-info btn-xs" onclick="'.$funcionEditar.'"><i class="entypo-pencil"></i></button>
    <button type="button" class="btn btn-danger btn-xs" onclick="'.$funcionAjax.'"><i class="entypo-trash"></i></button>';
    $return_arr = array();  

    $row_array['id'] = $resultNewPedido['pi_id'];
    $row_array['nombre'] = $resultNewPedido['insumo_nombre'];
    $row_array['tipo'] = $resultNewPedido['tipoinsumo_nombre'];
    $row_array['consumo'] = $resultNewPedido['pi_consumo'];
    $row_array['stock'] = $resultNewPedido['pi_stock'];
    $row_array['eliminar'] = $btneliminar;
    
    array_push($return_arr,$row_array);
    
    echo json_encode($return_arr);

    }
else {
    echo "error";
} 
?>