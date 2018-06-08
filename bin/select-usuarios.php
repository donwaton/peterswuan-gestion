<?php require 'db.php';

$sql = "SELECT * FROM usuario, tipo_usuario WHERE usuario.tipousuario_id=tipo_usuario.tipousuario_id;";
$result = $conn->query($sql);

$conn->close();
?>