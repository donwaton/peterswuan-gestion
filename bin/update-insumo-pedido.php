<?php
include 'db.php';

if(isset($_POST['insumoId'])){
        $sqlUpdate = "UPDATE insumo_pedido SET ip_cantidad = '".$_POST['newPedido']."' WHERE insumo_pedido.ip_id = ".$_POST['insumoId'].";";
        $conn->query($sqlUpdate);
    }
else {
    echo "Error en la actualización";
} 
?>