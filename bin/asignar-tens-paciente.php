<?php
include 'db.php';

if(isset($_POST['pacienteId'])){

    $sqlCheck = "SELECT up_id FROM usuario_paciente WHERE user_id='".$_POST['userId']."';";
    $resultCheck = $conn->query($sqlCheck);
    $pacienteAsignado = $resultCheck->fetch_assoc();

    $up_id = $pacienteAsignado['up_id'];

    if($up_id!=""){
        $sqlupdate = "UPDATE `usuario_paciente` SET `paciente_id` = '".$_POST['pacienteId']."' WHERE `usuario_paciente`.`up_id` = ".$up_id."";
        $conn->query($sqlupdate);
    }
    else {
        $sqlinsert = "INSERT INTO `usuario_paciente` (`up_id`, `paciente_id`, `user_id`) VALUES (NULL, '".$_POST['pacienteId']."', '".$_POST['userId']."')";
        $conn->query($sqlinsert);
    }

    $sql1 = "SELECT paciente_nombre FROM paciente WHERE paciente_id= '".$_POST['pacienteId']."'";
    $ejecutar1 = $conn->query($sql1);
    $result1 = $ejecutar1->fetch_assoc();
    
    echo $result1['paciente_nombre'];
    }
else {
    echo "error";
} 
?>