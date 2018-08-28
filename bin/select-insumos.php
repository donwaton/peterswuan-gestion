<?php require 'db.php';

$sqlInsumos = "SELECT 
    insumo.insumo_id,
    insumo.insumo_nombre, 
    tipo_insumo.tipoinsumo_nombre, 
    insumo.insumo_precio,
    insumo.insumo_stock,
    insumo.tipoinsumo_id
    FROM insumo, tipo_insumo
    WHERE tipo_insumo.tipoinsumo_id = insumo.tipoinsumo_id
    ORDER BY insumo.insumo_nombre";
$resultInsumos = $conn->query($sqlInsumos);

$sqlTipoInsumo = "SELECT * FROM tipo_insumo";
$resultTipoInsumo = $conn->query($sqlTipoInsumo);

$sqlTipoInsumo2 = "SELECT * FROM tipo_insumo";
$resultTipoInsumo2 = $conn->query($sqlTipoInsumo2);

$conn->close();
?>