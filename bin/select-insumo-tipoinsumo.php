<?php require_once 'db.php';

$sqlInsumos = "SELECT * FROM insumo WHERE tipoinsumo_id=".$_POST['tipoinsumo_id'].";";;
$resultInsumos = $conn->query($sqlInsumos);

while($listaInsumos = $resultInsumos->fetch_assoc()) {
    echo '<option value="'.$listaInsumos["insumo_id"].'">'.$listaInsumos["insumo_nombre"].'</option>';
}

$conn->close();

?>