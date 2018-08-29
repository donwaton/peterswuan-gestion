<?php require 'db.php';

$sql = "SELECT * FROM turno, profesional WHERE turno.prof_id=profesional.prof_id";
$result = $conn->query($sql);

$sqlProfesional = "SELECT * FROM profesional";
$resultProfesional = $conn->query($sqlProfesional);

$conn->close();
?>