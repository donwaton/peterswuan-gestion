<?php
include 'db.php';

if(isset($_POST['insumoId'])){
    if(isset($_POST['status'])){
        if($_POST['status']==0){
            $sqlUpdate = "UPDATE insumo_pedido SET ip_estado = '".$_POST['status']."' WHERE insumo_pedido.ip_id = ".$_POST['insumoId'].";";
        }
        else { $sqlUpdate = "UPDATE insumo_pedido SET ip_estado = '".$_POST['status']."', ip_entregado = NULL  WHERE insumo_pedido.ip_id = ".$_POST['insumoId'].";";
        }
        $conn->query($sqlUpdate);
    }
    else {
        $sqlUpdate = "UPDATE insumo_pedido SET ip_entregado = '".$_POST['insumoEntregado']."' WHERE insumo_pedido.ip_id = ".$_POST['insumoId'].";";
        $conn->query($sqlUpdate);
    }
}
else {
    echo "Error en la actualización";
} 
?>