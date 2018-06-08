<?php
include 'db.php';

if(isset($_POST['pacienteId'])){
    $sqlinsert = "INSERT INTO pedido 
    (pedido_id,
    paciente_id,
    pedido_desc,
    pedido_fecha,
    ep_id) 
    VALUES (
    NULL,
    '".$_POST['pacienteId']."',
    '".$_POST['pedidoDesc']."',
    NOW(),
    1
    )";
    $conn->query($sqlinsert);
    $sql = "SELECT LAST_INSERT_ID() AS id;";
    $ejecutar = $conn->query($sql);
    $result = $ejecutar->fetch_assoc();
    
    $sqlhistoria = "INSERT INTO historia_pedido
    (historia_id, ep_id, pedido_id, historia_fecha,user_id) 
    VALUES (NULL,1,".$result['id'].",NOW(),".$_POST['userId'].");";
    $conn->query($sqlhistoria);
    
    echo $result['id'];
    }
else {
    echo "error";
} 
?>