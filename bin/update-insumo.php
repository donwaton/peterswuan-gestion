<?php
include 'db.php';

if(isset($_POST['insumoId'])){
        $sqlUpdate = "UPDATE insumo 
        SET tipoinsumo_id = '".$_POST['tipoInsumo']."', 
            insumo_nombre = '".$_POST['nombreInsumo']."', 
            insumo_stock = '".$_POST['stockInsumo']."', 
            insumo_precio = '".$_POST['precioInsumo']."'
        WHERE insumo_id = ".$_POST['insumoId'].";";
        $conn->query($sqlUpdate);
    }
else {
    echo "Error en la actualización";
} 
?>