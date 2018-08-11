<?php
include './bin/select-turnos.php';
?>

<script>
$(document).ready(function() {

// page is now ready, initialize the calendar...

$('#calendar').fullCalendar({
    locale: 'es',
    // put your options and callbacks here
    events: [
    <?php  while($listaturnos = $result->fetch_assoc()) { 
        $color = "#ee4749";
        if($listaturnos['tipo_turno_id']==1){
            $color = "#378006";
        }
        echo '{ id:"'.$listaturnos['prof_id'].'",';
        echo 'title:"'.$listaturnos['prof_nombre'].'",color:"'.$color.'",';
        echo 'start:"'.$listaturnos['turno_fecha_inicio'].'",';
        echo 'end:"'.$listaturnos['turno_fecha_fin'].'"},';
        } ?>
    ]
})

});
</script>
<style>
.calendar-env .fc .fc-view-container .fc-view table tbody .fc-day.fc-state-highlight {
    background:#285182;
}
</style>

<!-- Inicio HTML -->

<ol class="breadcrumb bc-3" >
  <li>
    <a href="index.php"><i class="fa-home"></i>Inicio</a>
  </li>
  <li class="active">
    <strong>Turnos de emergencia</strong>
  </li>
</ol>
      
<h2>Turnos de emergencia</h2>
<br />

<div class="calendar-env">
		
<!-- Calendar Body -->
<div class="calendar-body">

    <div id="calendar"></div>

</div>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/fullcalendar-2/fullcalendar.min.css">

<!-- Imported scripts on this page -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar-2/fullcalendar.min.js"></script>
<script src="assets/js/fullcalendar-2/lang/es.js"></script>
<script src="assets/js/neon-calendar-2.js"></script>
<script src="assets/js/neon-chat.js"></script>