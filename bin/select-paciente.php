<?php require_once 'db.php';

$sqlInsumos = "SELECT paciente_insumo.pi_id,insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, paciente_insumo.pi_consumo, paciente_insumo.pi_stock 
FROM insumo, paciente_insumo, tipo_insumo
WHERE insumo.insumo_id=paciente_insumo.insumo_id
AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
AND paciente_id='" . $_GET['id'] . "'
ORDER BY insumo.insumo_nombre;";
$resultInsumos = $conn->query($sqlInsumos);

$sql = "SELECT * FROM paciente WHERE paciente_id='".$_GET['id']."'";
$result = $conn->query($sql);

$sqlTipoInsumo = "SELECT * FROM tipo_insumo";
$resultTipoInsumo = $conn->query($sqlTipoInsumo);

$sqlPedidos = "SELECT * FROM pedido, estado_pedido 
    WHERE estado_pedido.ep_id=pedido.ep_id
    AND paciente_id='".$_GET['id']."'";
$resultPedidos = $conn->query($sqlPedidos);

$sqlMagistrales = "SELECT * FROM preparado_magistral, prinicipio_activo, forma_farmaceutica
    WHERE preparado_magistral.principio_id=prinicipio_activo.principio_id
    AND preparado_magistral.forma_id=forma_farmaceutica.forma_id
    AND paciente_id='".$_GET['id']."'";
$resultMagistrales = $conn->query($sqlMagistrales);

$conn->close();
?>