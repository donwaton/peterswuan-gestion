<?php require 'db.php';

$sqlPedidos = "SELECT pedido.pedido_id, pedido.pedido_desc, paciente.paciente_nombre, usuario.user_names, historia_pedido.historia_fecha, paciente.paciente_id
FROM pedido, paciente, historia_pedido, usuario
WHERE pedido.paciente_id = paciente.paciente_id
AND pedido.pedido_id = historia_pedido.pedido_id
AND historia_pedido.user_id = usuario.user_id
AND pedido.ep_id = historia_pedido.ep_id
AND historia_pedido.ep_id=2";
$resultPedidos = $conn->query($sqlPedidos);

$conn->close();
?>