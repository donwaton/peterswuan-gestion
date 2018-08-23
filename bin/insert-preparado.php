<?php
include 'db.php';

if(isset($_POST['pacienteId'])){

    $dias_duracion = round(($_POST['dosis']*$_POST['cantidad'])/($_POST['posDosis']*(24/$_POST['posHoras'])));
    $nuevafecha = strtotime ( '+'.$dias_duracion.' day' , strtotime ( $_POST['fechaReceta'] ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

    $sqlinsert = "INSERT INTO `preparado_magistral` 
    (`prep_id`, 
    `paciente_id`, 
    `principio_id`, 
    `forma_id`, 
    `prep_nombre_med`, 
    `prep_rut_med`, 
    `prep_fecha`, 
    `prep_dosis`, 
    `prep_unidad`, 
    `prep_cantidad`, 
    `prep_pos_dosis`, 
    `prep_pos_horas`,
    `prep_fecha_venc`) VALUES 
    (NULL, 
    '".$_POST['pacienteId']."', 
    '".$_POST['principioId']."', 
    '".$_POST['formaId']."', 
    '".$_POST['nombreMedico']."', 
    '".$_POST['rutMedico']."', 
    '".$_POST['fechaReceta']."', 
    '".$_POST['dosis']."', 
    '".$_POST['unidadMedida']."', 
    '".$_POST['cantidad']."', 
    '".$_POST['posDosis']."', 
    '".$_POST['posHoras']."',
    '".$nuevafecha."')";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();

    $sqlNewPedido = "SELECT * FROM preparado_magistral, prinicipio_activo, forma_farmaceutica
    WHERE preparado_magistral.principio_id=prinicipio_activo.principio_id
    AND preparado_magistral.forma_id=forma_farmaceutica.forma_id
    AND prep_id='".$result['id']."'";
    $ejecutarNewPedido = $conn->query($sqlNewPedido);
    $resultNewPedido = $ejecutarNewPedido->fetch_assoc();

    $funcionAjax = "var confirmDelete = confirm('¿Está seguro que desea eliminar el preparado magistral?');
    if(confirmDelete == true){
        $.ajax({
        type:'POST',
            url:'./bin/delete-preparado.php',
            data:'idPreparado=".$resultNewPedido['prep_id']."',
        success:function(response){
            $('#table-3').DataTable().row($('#listPreparado".$resultNewPedido['prep_id']."')).remove().draw();
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
            toastr.info('Se ha eliminado el Preparado Magistral del paciente', 'Eliminación exitosa', opts);
            confirmDelete = false;
        }
    });
    } ";

    $detalles = '<a href="index.php?sec=magistral&id='.$resultNewPedido['prep_id'].'" class="btn btn-info btn-xs">
    <i class="entypo-doc-text"></i>
    </a>
    <button type="button" class="btn btn-danger btn-xs" onclick="'.$funcionAjax.'">
    <i class="entypo-trash"></i>
</button>';

    $return_arr = array();  

    $row_array['prep_id'] = $resultNewPedido['prep_id'];
    $row_array['principio_nombre'] = $resultNewPedido['principio_nombre'];
    $row_array['forma_nombre'] = $resultNewPedido['forma_nombre'];
    $row_array['prep_nombre_med'] = $resultNewPedido['prep_nombre_med'];
    $row_array['prep_rut_med'] = $resultNewPedido['prep_rut_med'];
    $row_array['prep_fecha'] = $resultNewPedido['prep_fecha'];
    $row_array['prep_dosis'] = $resultNewPedido['prep_dosis'];
    $row_array['prep_unidad'] = $resultNewPedido['prep_unidad'];
    $row_array['prep_cantidad'] = $resultNewPedido['prep_cantidad'];
    $row_array['prep_pos_dosis'] = $resultNewPedido['prep_pos_dosis'];
    $row_array['prep_pos_horas'] = $resultNewPedido['prep_pos_horas'];
    $row_array['prep_fecha_venc'] = $resultNewPedido['prep_fecha_venc'];
    $row_array['detalles'] = $detalles;
    
    array_push($return_arr,$row_array);
    
    echo json_encode($return_arr);
    }
else {
    echo "error";
} 
?>