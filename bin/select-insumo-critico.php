<?php require_once 'db.php';

$sqlAlertaCritico = "SELECT COUNT(paciente_insumo.pi_id) AS alerta_critico
    FROM insumo, paciente_insumo, tipo_insumo
    WHERE insumo.insumo_id=paciente_insumo.insumo_id
    AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
    AND paciente_insumo.pi_consumo*0.3 > paciente_insumo.pi_stock
    AND paciente_id='".$_POST['pacienteId']."'";
$resultAlertaCritico = $conn->query($sqlAlertaCritico);
$alertaCritico = $resultAlertaCritico->fetch_assoc();

echo $alertaCritico['alerta_critico'];
?>