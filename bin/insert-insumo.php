<?php
include 'db.php';

$sqlinsert = "INSERT INTO insumo (`insumo_id`, `tipoinsumo_id`, `insumo_nombre`, `insumo_stock`, `insumo_precio`) 
VALUES (NULL, 
'".$_POST['tipoInsumo']."', 
'".$_POST['nombreInsumo']."', 
'".$_POST['stockInsumo']."', 
'".$_POST['precioInsumo']."');";
$conn->query($sqlinsert);

?>