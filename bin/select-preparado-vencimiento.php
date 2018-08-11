<?php require_once 'db.php';

$sqlAlertaCritico = "SELECT COUNT(prep_id) AS alerta_vencimiento
    FROM preparado_magistral
    WHERE prep_fecha_venc < NOW()-7
    AND paciente_id='".$_POST['pacienteId']."'";
$resultAlertaCritico = $conn->query($sqlAlertaCritico);
$alertaCritico = $resultAlertaCritico->fetch_assoc();

echo $alertaCritico['alerta_vencimiento'];
?>