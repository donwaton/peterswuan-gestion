<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    $sqlUpdate = "UPDATE paciente_insumo 
    SET pi_stock = '".$_POST['newStock']."' 
    WHERE paciente_insumo.pi_id = ".$_POST['insumoId'].";";
    $conn->query($sqlUpdate);

    echo $_POST['insumoId'].",".$_POST['newStock'];
    }
else {
    echo "Error en la actualización";
} 
?>