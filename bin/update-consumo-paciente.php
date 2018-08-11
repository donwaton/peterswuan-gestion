<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    $sqlUpdate = "UPDATE paciente_insumo 
    SET pi_consumo = '".$_POST['newConsumo']."' 
    WHERE paciente_insumo.pi_id = ".$_POST['insumoId'].";";
    $conn->query($sqlUpdate);

    $sql = "SELECT pi_stock
    FROM paciente_insumo
    WHERE pi_id = ".$_POST['insumoId'].";";
    $result = $conn->query($sql);
    $consumo = $result->fetch_assoc();

    if($_POST['newConsumo']*0.3>$consumo['pi_stock']){
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