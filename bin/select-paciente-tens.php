<?php require 'db.php';

$sqlPacienteAsignado = "SELECT paciente_id FROM usuario_paciente WHERE user_id=".$_SESSION['userid'].";";
$resultPacienteAsignado = $conn->query($sqlPacienteAsignado);
$pacienteAsignado = $resultPacienteAsignado->fetch_assoc();
?>