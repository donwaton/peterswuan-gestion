<?php require 'db.php';

$sql = "SELECT * FROM turno, profesional WHERE turno.prof_id=profesional.prof_id";
$result = $conn->query($sql);

$sqlProfesional1 = "SELECT * FROM profesional WHERE tipo_turno_id=1";
$resultProfesional1 = $conn->query($sqlProfesional1);

$sqlProfesional2 = "SELECT * FROM profesional WHERE tipo_turno_id=2";
$resultProfesional2 = $conn->query($sqlProfesional2);

$conn->close();
?>