<?php
include 'db.php';

if(isset($_POST['idPreparado'])&& $_POST['idPreparado']<>''){
    $sql = "DELETE FROM preparado_magistral
    WHERE prep_id='".$_POST['idPreparado']."';";
    $conn->query($sql);
    echo $sql;
} else {
    echo "Error";
}
?>