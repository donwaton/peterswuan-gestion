<?php require 'db.php';

$sql = "SELECT paciente.paciente_id, paciente.paciente_nombre, ultimos.ultima_fecha, ultimos.ep_nombre 
FROM
(SELECT 
pedido.paciente_id, 
pedido.pedido_id, 
estado_pedido.ep_nombre, 
MAX(historia_pedido.historia_fecha) AS ultima_fecha 
FROM pedido, historia_pedido, estado_pedido
WHERE pedido.ep_id=estado_pedido.ep_id
AND historia_pedido.pedido_id=pedido.pedido_id
GROUP BY pedido.paciente_id) ultimos 
RIGHT JOIN paciente ON paciente.paciente_id=ultimos.paciente_id;";
$result = $conn->query($sql);

$conn->close();
?>