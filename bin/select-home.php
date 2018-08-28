<?php require 'db.php';

$sqlQuiebreStock =  "SELECT COUNT(insumo_nombre) AS quiebrestock FROM (	
        SELECT 
        insumo.insumo_nombre,
        insumo.insumo_stock,
        (SUM(paciente_insumo.pi_consumo)-SUM(paciente_insumo.pi_stock)) AS demanda
        FROM insumo, paciente_insumo, tipo_insumo
        WHERE insumo.insumo_id = paciente_insumo.insumo_id
        AND tipo_insumo.tipoinsumo_id = insumo.tipoinsumo_id
        GROUP BY insumo.insumo_nombre, 
        insumo.insumo_stock) AS DEMANDAINSUMOS
    WHERE demanda>=insumo_stock";
$resultQuiebreStock = $conn->query($sqlQuiebreStock);

$sqlStockAjustado =  "SELECT COUNT(insumo_nombre) AS stockajustado FROM (	
    SELECT 
    insumo.insumo_nombre,
    insumo.insumo_stock,
    (SUM(paciente_insumo.pi_consumo)-SUM(paciente_insumo.pi_stock)) AS demanda
    FROM insumo, paciente_insumo, tipo_insumo
    WHERE insumo.insumo_id = paciente_insumo.insumo_id
    AND tipo_insumo.tipoinsumo_id = insumo.tipoinsumo_id
    GROUP BY insumo.insumo_nombre, 
    insumo.insumo_stock) AS DEMANDAINSUMOS
WHERE demanda<insumo_stock
AND (demanda*1.5)>insumo_stock";
$resultStockAjustado = $conn->query($sqlStockAjustado);

$sqlPendAprob="SELECT COUNT(pedido_id) AS pendiente_aprobacion
    FROM pedido
    WHERE ep_id=2";
$resultPendAprob = $conn->query($sqlPendAprob);

$sqlDespacho="SELECT COUNT(pedido_id) AS pendiente_despacho
    FROM pedido
    WHERE ep_id=3";
$resultDespacho = $conn->query($sqlDespacho);

$sqlRuta="SELECT COUNT(pedido_id) AS en_ruta
    FROM pedido
    WHERE ep_id=4";
$resultRuta = $conn->query($sqlRuta);

$conn->close();
?>