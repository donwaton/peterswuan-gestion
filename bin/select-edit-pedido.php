<?php require_once 'db.php';

$sqlSugeridos = "SELECT 
    sugerido.pi_id,
    sugerido.insumo_id,
    sugerido.insumo_nombre,
    sugerido.tipoinsumo_nombre,
    sugerido.pi_consumo,
    sugerido.pi_stock,
    sugerido.pedido_sugerido,
    pedidos.ip_cantidad
 FROM (
    SELECT paciente_insumo.pi_id,
        insumo.insumo_id,
        insumo.insumo_nombre, 
        tipo_insumo.tipoinsumo_nombre, 
        paciente_insumo.pi_consumo, 
        paciente_insumo.pi_stock,
        (paciente_insumo.pi_consumo-paciente_insumo.pi_stock) AS pedido_sugerido
        FROM insumo, paciente_insumo, tipo_insumo
        WHERE insumo.insumo_id=paciente_insumo.insumo_id
        AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
        AND paciente_insumo.pi_consumo > paciente_insumo.pi_stock
        AND paciente_id='".$_GET['id']."'
        ) sugerido 
    LEFT JOIN (
        SELECT * FROM insumo_pedido WHERE insumo_pedido.pedido_id='".$_GET['pid']."'
    ) pedidos ON pedidos.insumo_id = sugerido.insumo_id;";
$resultSugeridos = $conn->query($sqlSugeridos);

$sqlTipoInsumo = "SELECT * FROM tipo_insumo";
$resultTipoInsumo = $conn->query($sqlTipoInsumo);

$sqlMotivo = "SELECT * FROM motivo_pedido";
$resultMotivo = $conn->query($sqlMotivo);

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
pedido_insumo.pi_consumo
FROM 
(SELECT ip_id, insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, insumo_pedido.ip_cantidad, motivo_pedido.mp_nombre, insumo.insumo_id, insumo_pedido.pedido_id
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