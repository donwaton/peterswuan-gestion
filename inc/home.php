<?php include './bin/select-home.php'; 

if($_SESSION['perfil']==5){
    echo "<script>window.location = 'index.php?sec=paciente-tens&id=1';</script>";
}

?>

<!-- Inicio HTML -->
      
<h2>Panel de Gestión de Farmacia</h2>
<br />

<div class="row">
<?php while($QuiebreStock = $resultQuiebreStock->fetch_assoc()) { 
    if($QuiebreStock['quiebrestock']==""){ } if(1==2) { ?>

<div class="col-sm-3">
    <a href="index.php?sec=lista-insumos">
    <div class="tile-stats tile-green">
        <div class="icon"><i class="entypo-clipboard"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $QuiebreStock['quiebrestock'];?>" data-postfix=" Insumos" data-duration="1500" data-delay="0">0 Insumos</div>
        <h3>Quiebre de Stock</h3>
        <p>Debe solicitar reabastecimiento</p>
    </div>
    </a>
</div>

<?php } } ?>

<?php while($StockAjustado = $resultStockAjustado->fetch_assoc()) { 
    if($StockAjustado['stockajustado']==""){ } if(1==2) { ?>

<div class="col-sm-3">
    <a href="index.php?sec=lista-insumos">
    <div class="tile-stats tile-green">
        <div class="icon"><i class="entypo-clipboard"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $StockAjustado['stockajustado'];?>" data-postfix=" Insumos" data-duration="1500" data-delay="0">0 Insumos</div>
        <h3>Stock Ajustado</h3>
        <p>Debe planificar reabastecimiento</p>
    </div>
    </a>
</div>

<?php } } ?>

<?php while($PendAprob = $resultPendAprob->fetch_assoc()) { 
    if($PendAprob['pendiente_aprobacion']==""){ } if($_SESSION['perfil']==1 || $_SESSION['perfil']==3) { ?>

<div class="col-sm-3">
    <a href="index.php?sec=lista-pedidos-pendientes">
    <div class="tile-stats tile-orange">
        <div class="icon"><i class="entypo-check"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $PendAprob['pendiente_aprobacion'];?>" data-postfix=" Pedidos" data-duration="1500" data-delay="0">0 Pedidos</div>
        <h3>Pendiente Aprobación</h3>
        <p>Debe aprobar los pedidos</p>
    </div>
    </a>
</div>

<?php } } ?>

<?php while($Despacho = $resultDespacho->fetch_assoc()) { 
    if($Despacho['pendiente_despacho']==""){ } if($_SESSION['perfil']==1 || $_SESSION['perfil']==2) { ?>

<div class="col-sm-3">
    <a href="index.php?sec=lista-pedidos-despacho">
    <div class="tile-stats tile-orange">
        <div class="icon"><i class="entypo-basket"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $Despacho['pendiente_despacho'];?>" data-postfix=" Pedidos" data-duration="1500" data-delay="0">0 Pedidos</div>
        <h3>Pendiente Despacho</h3>
        <p>Debe despachar los pedidos</p>
    </div>
    </a>
</div>

<?php } } ?>

</div>
