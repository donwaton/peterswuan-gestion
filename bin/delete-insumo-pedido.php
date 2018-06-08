<?php
include 'db.php';

if(isset($_POST['idInsumo'])&& $_POST['idInsumo']<>''){
    $sql = "DELETE FROM insumo_pedido
    WHERE ip_id='".$_POST['idInsumo']."';";
    $conn->query($sql);
    echo $sql;
} else {
    echo "Error";
}
?>