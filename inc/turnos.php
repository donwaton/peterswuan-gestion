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

<!-- Sidebar -->
<div class="calendar-sidebar">

    <!-- new task form -->
    <div class="calendar-sidebar-row">

        <form role="form" id="add_event_form">

            <div class="input-group minimal">
                <input type="text" class="form-control" placeholder="Add event..."   disabled/>

                <div class="input-group-addon">
                    <i class="entypo-pencil"></i>
                </div>
            </div>

        </form>

    </div>


    <!-- Events List -->
    <ul class="events-list" id="draggable_events">
       <!-- Soon
        <li>
            <p>Drag Events to Calendar Dates</p>
        </li>
        <li>
            <a href="#">Sport Match</a>
        </li>
        <li>
            <a href="#" class="color-blue" data-event-class="color-blue">Meeting</a>
        </li>
        <li>
            <a href="#" class="color-orange" data-event-class="color-orange">Relax</a>
        </li>
        <li>
            <a href="#" class="color-primary" data-event-class="color-primary">Study</a>
        </li>
        <li>
            <a href="#" class="color-green" data-event-class="color-green">Family Time</a>
        </li>
        -->
    </ul>

</div>


<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/fullcalendar-2/fullcalendar.min.css">

<!-- Imported scripts on this page -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar-2/fullcalendar.min.js"></script>
<script src="assets/js/fullcalendar-2/lang/es.js"></script>
<script src="assets/js/neon-calendar-2.js"></script>
<script src="assets/js/neon-chat.js"></script>