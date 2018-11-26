<?php
include 'db.php';
date_default_timezone_set("America/Santiago");
$ahora = date("d/m/Y H:i");
$now = date("Y-m-d H:i:s");

if($_POST['fc']<>'' && $_POST['fr']<>'' && $_POST['so']<>'' && $_POST['temp']<>''){
    $sqlinsert = "INSERT INTO signos_vitales (`sv_id`, `paciente_id`, `user_id`, `sv_fc`, `sv_fr`, `sv_so`, `sv_temp`, `sv_date`) 
    VALUES (NULL, 
    '".$_POST['pacienteId']."', 
    '".$_POST['userId']."', 
    '".$_POST['fc']."', 
    '".$_POST['fr']."', 
    '".$_POST['so']."', 
    '".$_POST['temp']."', 
    '".$now."');";
    $conn->query($sqlinsert);
    $sqlUser = "SELECT user_names FROM usuario WHERE user_id='".$_POST['userId']."';";
    $resultUser = $conn->query($sqlUser);
    $user = $resultUser->fetch_assoc();
    
    
    echo "Última Medición: ".$ahora." (".$user['user_names'].")";
} else {
    echo "error";
}

?>