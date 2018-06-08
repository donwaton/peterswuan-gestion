<?php require_once 'db.php';

$sqlPedido = "SELECT * 
FROM pedido, paciente 
WHERE pedido.paciente_id=paciente.paciente_id
AND pedido.pedido_id=".$_GET['id'].";";
$resultPedido = $conn->query($sqlPedido);
$pedido = $resultPedido->fetch_assoc();

$sqlInsumosPedido = "SELECT * 
FROM insumo, tipo_insumo, insumo_pedido, pedido
WHERE pedido.pedido_id=insumo_pedido.pedido_id
AND insumo_pedido.insumo_id=insumo.insumo_id 
AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
AND pedido.pedido_id='" . $_GET['id'] . "'
ORDER BY insumo.insumo_nombre;";
$resultInsumosPedido = $conn->query($sqlInsumosPedido);

$conn->close();
?>