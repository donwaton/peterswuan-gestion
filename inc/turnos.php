<?php
include './bin/select-turnos.php';

$listaEnfermeras = '';
$listaKTR = '';

while($listaProfesional1 = $resultProfesional1->fetch_assoc()) { 
    $listaEnfermeras .= "<option value='".$listaProfesional1["prof_id"]."'>".$listaProfesional1["prof_nombre"]."</option>";
} 
while($listaProfesional2 = $resultProfesional2->fetch_assoc()) { 
    $listaKTR .= "<option value='".$listaProfesional2["prof_id"]."'>".$listaProfesional2["prof_nombre"]."</option>";
}

?>

<script>
$(document).ready(function() {
// page is now ready, initialize the calendar...
    $('#calendar').fullCalendar({
        locale: 'es',
        // put your options and callbacks here
        events: [
        <?php while ($listaturnos = $result->fetch_assoc()) {
        $color = "#ee4749";
        if ($listaturnos['tipo_turno_id'] == 1) {
            $color = "#378006";
        }
        echo '{ id:"' . $listaturnos['turno_id'] . '",';
        echo 'profId:"' . $listaturnos['prof_id'] . '",';
        echo 'tipoId:"' . $listaturnos['tipo_turno_id'] . '",';
        echo 'title:"' . $listaturnos['prof_nombre'] . '",color:"' . $color . '",';
        echo 'start:"' . $listaturnos['turno_fecha_inicio'] . '",';
        echo 'end:"' . $listaturnos['turno_fecha_fin'] . '"},';
    }?>
        ],
        eventClick: function(calEvent) {
            $('#profesionalTurno').empty();
            if(calEvent.tipoId==2){
                $('#profesionalTurno').append("<?php echo $listaKTR;?>");
            }
            if(calEvent.tipoId==1){
                $('#profesionalTurno').append("<?php echo $listaEnfermeras;?>");
            }
            document.getElementById('turnoId').value = calEvent.id;
            document.getElementById('profesionalTurno').value = calEvent.profId;
            $('#modalTurnoUpdate').modal('show');
        }
    });

    $('#updateTurno').click(function(){
            document.getElementById('updateTurno').disabled = true;                                
            $.ajax({
                url:"bin/update-turno.php",
                method:"POST",
                data:$('#formTurnoUpdate').serialize(),
                success:function(response){
                    document.getElementById('updateTurno').disabled = false;
                    window.location = 'index.php?sec=turnos';
                    }
            });    
        });

});
</script>
<style>
.fc-unthemed .fc-today{
    background:#285182 !important;
    color:#ffffff;
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

<!-- Calendar Body -->
<div id="calendar"></div>

<!-- Modal turno-->
<div class="modal fade" id="modalTurnoUpdate" tabindex="-1" role="dialog" aria-labelledby="modalTurnoUpdate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="modalTurnoUpdate">Modificar turno</h3>
        </div>
        <div class="modal-body">
            <form id="formTurnoUpdate" name="formTurnoUpdate">
                <input type="hidden" name="turnoId" id="turnoId" value="0">

                <label for="profesionalTurno">Tipo</label>
                    <select class="form-control form-control-sm" name="profesionalTurno" id="profesionalTurno" required>
                        <option value="0"></option>
                    </select>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" name="updateTurno" id="updateTurno" class="btn btn-success">Reemplazar</button>
        </div>
        </div>
    </div>
</div>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/fullcalendar-2/fullcalendar.min.css">

<!-- Imported scripts on this page -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar-2/fullcalendar.min.js"></script>
<script src="assets/js/fullcalendar-2/lang/es.js"></script>
<script src="assets/js/neon-calendar-2.js"></script>
<script src="assets/js/neon-chat.js"></script>