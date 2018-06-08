<?php require 'db.php';

$sqlPedidos = "SELECT ultimos.pedido_id, paciente.paciente_id, paciente.paciente_nombre, 
ultimos.ultima_fecha, ultimos.ep_nombre, ultimos.pedido_desc, ultimos.user_names
FROM
(SELECT  pedido.pedido_desc,pedido.paciente_id, pedido.pedido_id, 
estado_pedido.ep_nombre, usuario.user_names,
MAX(historia_pedido.historia_fecha) AS ultima_fecha 
FROM pedido, historia_pedido, estado_pedido, usuario
WHERE pedido.ep_id=estado_pedido.ep_id
AND historia_pedido.pedido_id=pedido.pedido_id
AND pedido.ep_id=3
AND historia_pedido.user_id=usuario.user_id
GROUP BY pedido.paciente_id, 
pedido.pedido_id, 
estado_pedido.ep_nombre) ultimos 
LEFT JOIN paciente ON paciente.paciente_id=ultimos.paciente_id";
$resultPedidos = $conn->query($sqlPedidos);

$conn->close();
?>