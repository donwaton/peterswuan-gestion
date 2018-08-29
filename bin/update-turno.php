<?php
include 'db.php';

if(isset($_POST['turnoId'])){
        $sqlUpdate = "UPDATE `turno` SET `prof_id` = '".$_POST['profesionalTurno']."' WHERE `turno`.`turno_id` = ".$_POST['turnoId']."";
        $conn->query($sqlUpdate);
    }
else {
    echo "Error en la actualización";
} 
?>