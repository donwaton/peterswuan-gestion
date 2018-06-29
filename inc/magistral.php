<?php
include './bin/select-magistral.php';
?>


<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li>
    <a href="index.php?sec=lista-pacientes"><i class="fa-home"></i>Lista de pacientes</a>
  </li>
  <li>
    <a href="index.php?sec=paciente&id=<?php echo $magistral['paciente_id'];?>"><i class="fa-home"></i>Ficha <?php echo $magistral['paciente_nombre']?></a>
  </li>
  <li class="active">
    <strong>Detalles Preparado Magistral</strong>
  </li>
</ol>
      
<h2>Detalles Preparado Magistral</h2>
<br />

    <div>
    <?php echo $magistral['prep_nombre_med'];?><br>
    RUT: <?php echo $magistral['prep_rut_med'];?><br>
    Fecha Receta: <?php echo $magistral['prep_fecha'];?><br><br>

    Principio Activo: <?php echo $magistral["principio_nombre"];?><br>
    Dosis: <?php echo $magistral["prep_dosis"]." ".$magistral["prep_unidad"];?><br>
    Forma Farmaceutica: <?php echo $magistral["prep_cantidad"]." ".$magistral["forma_nombre"];?><br>
    Posificación: <?php echo $magistral["prep_pos_dosis"]." ".$magistral["prep_unidad"]." cada ".$magistral["prep_pos_horas"]." horas";?><br>
    Duración estimada:
    <?php
        $dias_duracion = round(($magistral["prep_dosis"]*$magistral["prep_cantidad"])/($magistral["prep_pos_dosis"]*(24/$magistral["prep_pos_horas"])));

        $nuevafecha = strtotime ( '+'.$dias_duracion.' day' , strtotime ( $magistral['prep_fecha'] ) ) ;
        $nuevafecha = date ( 'j-m-Y' , $nuevafecha );
        
        echo $dias_duracion."dias, <br>Fecha estimada de término: ". $nuevafecha;
    ?> 

    </div>

</div>