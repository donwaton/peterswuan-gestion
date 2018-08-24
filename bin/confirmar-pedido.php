<?php
include 'db.php';

if(isset($_POST['idPedido'])){

    $sqlCheck = "SELECT COUNT(ip_id) AS nok FROM insumo_pedido WHERE pedido_id=".$_POST['idPedido']." AND ip_estado=0";
    $ejecutarCheck = $conn->query($sqlCheck);
    $resultCheck = $ejecutarCheck->fetch_assoc();

    if($resultCheck['nok']>0){
        $estado = 6;
    } else {
        $estado = 5;
    }
    $sqlinsert = "UPDATE pedido SET ep_id=".$estado." WHERE pedido_id = ".$_POST['idPedido'].";";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();
    
    $sqlhistoria = "INSERT INTO historia_pedido
    (historia_id, ep_id, pedido_id, historia_fecha, user_id) 
    VALUES (NULL,".$estado.",".$_POST['idPedido'].",NOW(),".$_POST['userId'].");";
    $conn->query($sqlhistoria);

    echo "ok -".$sqlhistoria;
    }
else {
    echo "error";
} 
?>