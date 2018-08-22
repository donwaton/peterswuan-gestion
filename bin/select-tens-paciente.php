<?php require 'db.php';

$sql = "SELECT a.paciente_nombre, b.user_names 
FROM (SELECT paciente.paciente_nombre, usuario_paciente.paciente_id, usuario_paciente.user_id
FROM usuario_paciente, paciente
WHERE usuario_paciente.paciente_id=paciente.paciente_id) a 
RIGHT JOIN (SELECT * FROM usuario WHERE usuario.tipousuario_id=5) b ON a.user_id=b.user_id;";
$result = $conn->query($sql);

$conn->close();
?>