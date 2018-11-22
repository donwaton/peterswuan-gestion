<?php
include 'db.php';

if($_POST['fc']<>'' && $_POST['fr']<>'' && $_POST['so']<>'' && $_POST['temp']<>''){
    $sqlinsert = "INSERT INTO signos_vitales (`sv_id`, `paciente_id`, `user_id`, `sv_fc`, `sv_fr`, `sv_so`, `sv_temp`, `sv_date`) 
    VALUES (NULL, 
    '".$_POST['pacienteId']."', 
    '".$_POST['userId']."', 
    '".$_POST['fc']."', 
    '".$_POST['fr']."', 
    '".$_POST['so']."', 
    '".$_POST['temp']."', 
    NOW());";
    //$conn->query($sqlinsert);
    $sqlUser = "SELECT user_names FROM usuario WHERE user_id='".$_POST['userId']."';";
    $resultUser = $conn->query($sqlUser);
    $user = $resultUser->fetch_assoc();

    $now = date("d-m-Y H:i:s");
    
    echo "Última Medición: ".$now." (".$user['user_names'].")";
} else {
    echo "error";
}

?>