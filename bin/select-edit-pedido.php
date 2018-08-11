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

$sqlMagistrales = "SELECT * FROM preparado_magistral, prinicipio_activo, forma_farmaceutica
    WHERE preparado_magistral.principio_id=prinicipio_activo.principio_id
    AND preparado_magistral.forma_id=forma_farmaceutica.forma_id
    AND paciente_id='".$_GET['id']."'";
$resultMagistrales = $conn->query($sqlMagistrales);

$sqlMotivo = "SELECT * FROM motivo_pedido";
$resultMotivo = $conn->query($sqlMotivo);

$sqlPedido = "SELECT * FROM pedido, paciente 
    WHERE paciente.paciente_id=pedido.paciente_id
    AND pedido.paciente_id='".$_GET['id']."'
    AND pedido.pedido_id='".$_GET['pid']."';";
$resultPedido = $conn->query($sqlPedido);
$pedido = $resultPedido->fetch_assoc();

$sqlInsumosPedido = "SELECT ip_id, insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, insumo_pedido.ip_cantidad, motivo_pedido.mp_nombre 
    FROM insumo_pedido, insumo, tipo_insumo, motivo_pedido
    WHERE insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
    AND insumo_pedido.mp_id=motivo_pedido.mp_id
    AND insumo_pedido.insumo_id=insumo.insumo_id
    AND insumo_pedido.pedido_id='".$_GET['pid']."';";
$resultInsumosPedido = $conn->query($sqlInsumosPedido);

$conn->close();
?>