<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    $sqlUpdate = "UPDATE paciente_insumo 
    SET pi_stock = '".$_POST['newStock']."' 
    WHERE paciente_insumo.pi_id = ".$_POST['insumoId'].";";
    $conn->query($sqlUpdate);

    $sql = "SELECT pi_consumo
    FROM paciente_insumo
    WHERE pi_id = ".$_POST['insumoId'].";";
    $result = $conn->query($sql);
    $consumo = $result->fetch_assoc();

    if($consumo['pi_consumo']*0.3>$_POST['newStock']){
        echo "true";
    }
    else {
        echo "false";
    }

    }
else {
    echo "Error en la actualización";
} 
?>