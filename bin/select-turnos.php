<?php require 'db.php';

$sql = "SELECT * FROM turno, profesional WHERE turno.prof_id=profesional.prof_id";
$result = $conn->query($sql);

$conn->close();
?>