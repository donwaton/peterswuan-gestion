<?php require 'db.php';

$sqlInsumos = "SELECT 
    insumo.insumo_id,
    insumo.insumo_nombre, 
    tipo_insumo.tipoinsumo_nombre, 
    insumo.insumo_precio
    FROM insumo, tipo_insumo
    WHERE tipo_insumo.tipoinsumo_id = insumo.tipoinsumo_id
    ORDER BY insumo.insumo_nombre";
$resultInsumos = $conn->query($sqlInsumos);

$conn->close();
?>