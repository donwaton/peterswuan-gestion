<?php
include 'db.php';

if(isset($_POST['idPedido'])){
    $sqlinsert = "UPDATE pedido SET ep_id=3 WHERE pedido_id = ".$_POST['idPedido'].";";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();
    
    $sqlhistoria = "INSERT INTO historia_pedido
    (historia_id, ep_id, pedido_id, historia_fecha, user_id) 
    VALUES (NULL,3,".$_POST['idPedido'].",NOW(),".$_POST['userId'].");";
    $conn->query($sqlhistoria);

    echo "ok -".$sqlhistoria;
    }
else {
    echo "error";
} 
?>