<?php require_once 'db.php';

$sqlMagistrales = "SELECT * FROM preparado_magistral, prinicipio_activo, forma_farmaceutica, paciente
    WHERE preparado_magistral.principio_id=prinicipio_activo.principio_id
    AND preparado_magistral.forma_id=forma_farmaceutica.forma_id
    AND paciente.paciente_id=preparado_magistral.paciente_id
    AND prep_id='".$_GET['id']."'";
$resultMagistrales = $conn->query($sqlMagistrales);
$magistral = $resultMagistrales->fetch_assoc();

$conn->close();
?>