<?php require_once 'db.php';

$sqlPedido = "SELECT * FROM pedido, paciente 
    WHERE paciente.paciente_id=pedido.paciente_id
    AND pedido.paciente_id='".$_GET['id']."'
    AND pedido.pedido_id='".$_GET['pid']."';";
$resultPedido = $conn->query($sqlPedido);
$pedido = $resultPedido->fetch_assoc();

$sqlInsumosPedido = "SELECT 
    pedido_paciente.pedido_id,
    pedido_paciente.ip_id,
    pedido_paciente.insumo_id,
    pedido_paciente.insumo_nombre,
    pedido_paciente.tipoinsumo_nombre,
    pedido_paciente.mp_nombre,
    pedido_paciente.ip_cantidad,
    pedido_insumo.pi_stock,
    pedido_insumo.pi_consumo,
    pedido_paciente.ip_entregado,
    pedido_paciente.ip_estado
    FROM 
    (SELECT ip_id, insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, insumo_pedido.ip_cantidad, 
    motivo_pedido.mp_nombre, insumo.insumo_id, insumo_pedido.pedido_id, insumo_pedido.ip_entregado, insumo_pedido.ip_estado
    FROM insumo_pedido, insumo, tipo_insumo, motivo_pedido
    WHERE insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
    AND insumo_pedido.mp_id=motivo_pedido.mp_id
    AND insumo_pedido.insumo_id=insumo.insumo_id
    AND insumo_pedido.pedido_id=".$_GET['pid'].") pedido_paciente
    LEFT JOIN (SELECT * FROM paciente_insumo WHERE paciente_insumo.paciente_id=".$_GET['id']."
    ) pedido_insumo ON pedido_insumo.insumo_id=pedido_paciente.insumo_id;";
$resultInsumosPedido = $conn->query($sqlInsumosPedido);

$conn->close();
?>