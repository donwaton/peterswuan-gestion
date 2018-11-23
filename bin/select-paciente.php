<?php require_once 'db.php';

date_default_timezone_set("America/Santiago");
$ayer = date('Y-m-d h:i:s', strtotime("-1 day"));
$hoy = date('Y-m-d h:i:s');

$sqlInsumos = "SELECT paciente_insumo.pi_id,insumo.insumo_nombre, tipo_insumo.tipoinsumo_nombre, paciente_insumo.pi_consumo, paciente_insumo.pi_stock 
FROM insumo, paciente_insumo, tipo_insumo
WHERE insumo.insumo_id=paciente_insumo.insumo_id
AND insumo.tipoinsumo_id = tipo_insumo.tipoinsumo_id
AND paciente_id='" . $_GET['id'] . "'
ORDER BY insumo.insumo_nombre;";
$resultInsumos = $conn->query($sqlInsumos);

$sqlPaciente = "SELECT * FROM paciente WHERE paciente_id='".$_GET['id']."';";
$resultPaciente = $conn->query($sqlPaciente);
$datosPaciente = $resultPaciente->fetch_assoc();

$sqlTipoInsumo = "SELECT * FROM tipo_insumo";
$resultTipoInsumo = $conn->query($sqlTipoInsumo);

$sqlPrincipioActivo = "SELECT * FROM prinicipio_activo";
$resultPrincipioActivo = $conn->query($sqlPrincipioActivo);

$sqlFormaFarmaceutica = "SELECT * FROM forma_farmaceutica";
$resultFormaFarmaceutica = $conn->query($sqlFormaFarmaceutica);

$sqlPedidos = "SELECT * FROM pedido, estado_pedido 
    WHERE estado_pedido.ep_id=pedido.ep_id
    AND paciente_id='".$_GET['id']."'";
$resultPedidos = $conn->query($sqlPedidos);

$sqlMagistrales = "SELECT * FROM preparado_magistral, prinicipio_activo, forma_farmaceutica
    WHERE preparado_magistral.principio_id=prinicipio_activo.principio_id
    AND preparado_magistral.forma_id=forma_farmaceutica.forma_id
    AND paciente_id='".$_GET['id']."'";
$resultMagistrales = $conn->query($sqlMagistrales);

$sqlLastSignos = "SELECT * FROM signos_vitales, usuario 
    WHERE usuario.user_id=signos_vitales.user_id 
    AND paciente_id='".$_GET['id']."'  ORDER BY sv_date DESC LIMIT 1;";
$resultLastSignos = $conn->query($sqlLastSignos);
$lastVS = $resultLastSignos->fetch_assoc();

$sqlSignos = "SELECT * FROM signos_vitales, usuario 
    WHERE usuario.user_id=signos_vitales.user_id 
    AND paciente_id='".$_GET['id']."' 
    AND sv_date > '".$ayer."' 
    ORDER BY sv_date DESC;";
$resultSignos = $conn->query($sqlSignos);

$conn->close();
?>