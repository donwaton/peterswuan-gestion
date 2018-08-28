<?php include './bin/select-home.php'; 

if($_SESSION['perfil']==5){
    include './bin/select-paciente-tens.php';
    echo "<script>window.location = 'index.php?sec=paciente-tens&id=".$pacienteAsignado['paciente_id']."';</script>";
}

if($_SESSION['perfil']==6){
    include './bin/select-paciente-tens.php';
    echo "<script>window.location = 'index.php?sec=lista-pedidos-ruta';</script>";
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
    if($PendAprob['pendiente_aprobacion']==""){ } if($_SESSION['perfil']==1 || $_SESSION['perfil']==3 || $_SESSION['perfil']==4) { ?>

<div class="col-sm-3">
    <a href="index.php?sec=lista-pedidos-pendientes">
    <?php if($PendAprob['pendiente_aprobacion']==0){
        $colorTilePA="green";
    } else {
        $colorTilePA="orange";
    }?>
    <div class="tile-stats tile-<?php echo $colorTilePA;?>">
        <div class="icon"><i class="entypo-check"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $PendAprob['pendiente_aprobacion'];?>" data-postfix=" Pedidos" data-duration="700" data-delay="0">0 Pedidos</div>
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
    <?php if($Despacho['pendiente_despacho']==0){
        $colorTilePD="green";
    } else {
        $colorTilePD="orange";
    }?>
    <div class="tile-stats tile-<?php echo $colorTilePD;?>">
        <div class="icon"><i class="entypo-box"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $Despacho['pendiente_despacho'];?>" data-postfix=" Pedidos" data-duration="700" data-delay="0">0 Pedidos</div>
        <h3>Pendiente preparación</h3>
        <p>Debe despachar los pedidos</p>
    </div>
    </a>
</div>

<?php } } ?>

<?php while($Ruta = $resultRuta->fetch_assoc()) { 
    if($Ruta['en_ruta']==""){ } if($_SESSION['perfil']==1 || $_SESSION['perfil']==6) { ?>

<div class="col-sm-3">
   <a href="index.php?sec=lista-pedidos-ruta">
    <?php if($Ruta['en_ruta']==0){
        $colorTilePD="green";
    } else {
        $colorTilePD="orange";
    }?>
    <div class="tile-stats tile-<?php echo $colorTilePD;?>">
        <div class="icon"><i class="entypo-basket"></i></div>
        <div class="num" data-start="0" data-end="<?php echo $Ruta['en_ruta'];?>" data-postfix=" Pedidos" data-duration="700" data-delay="0">0 Pedidos</div>
        <h3>En ruta</h3>
        <p>Debe confirmar los pedidos</p>
    </div>
   </a>
</div>

<?php } } ?>


</div>

