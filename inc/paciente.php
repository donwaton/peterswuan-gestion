<?php 
include './bin/select-paciente.php';
include './bin/select-turnos.php';
?>
<script type="text/javascript">
    jQuery( document ).ready( function() {
        // Propiedades de la tablas
        var $table1 = jQuery( '#table-1' );
        var $table2 = jQuery( '#table-2' );
        var $table3 = jQuery( '#table-3' );
        $table1.DataTable( { paging: false });        
        $table2.DataTable( { paging: false });        
        $table3.DataTable( { paging: false });

        // Alerta de quiebre de stock de insumos
        function alertaQuiebreStock(){
            $.ajax({
                url:"bin/select-insumo-critico.php",
                method:"POST",
                data:'pacienteId=<?php echo $_GET['id'];?>',
                success:function(response){
                    if(response>0){
                        document.getElementById('alertaInsumo').innerHTML = response;
                    }
                    else {
                        document.getElementById('alertaInsumo').innerHTML = '';
                    }
                }
            });
        }
        alertaQuiebreStock();
        
        /* Pendiente de definición de proceso de pedidos para preparados magistrales
        // Alerta de próximos vencimientos de preparados magistrales
        function alertaPreparadoVencimiento(){
            $.ajax({
                url:"bin/select-preparado-vencimiento.php",
                method:"POST",
                data:'pacienteId=<?php echo $_GET['id'];?>',
                success:function(response){
                    if(response>0){
                        document.getElementById('alertaPreparado').innerHTML = response;
                    }
                    else {
                        document.getElementById('alertaPreparado').innerHTML = '';
                    }
                }
            });
        }
        alertaPreparadoVencimiento();
        */

        $('#newTipoInsumo').on('change',function(){
            var tipoInsumoID = $(this).val();
            if(tipoInsumoID){
                $.ajax({
                    type:'POST',
                    url:'./bin/select-insumo-tipoinsumo.php',
                    data:'tipoinsumo_id='+tipoInsumoID,
                    success:function(html){
                        $('#newInsumo').empty();
                        $('#newInsumo').append(html);
                    }
                });
            }
        });

        $('.noEnterSubmit').keypress(function(e){
            if ( e.which == 13 ) return false;
            //or...
            if ( e.which == 13 ) e.preventDefault();
        });

        $('#updateInsumo').click(function(){
            var consumo = document.forms["formUpdateInsumo"]["newConsumo"].value;
            var idInsumo = document.forms["formUpdateInsumo"]["insumoId"].value;

            if(consumo ==""){
                alert("Debe ingresar el nuevo consumo para actualizar");
            } 
            else {
                                
                $.ajax({
                    url:"bin/update-consumo-paciente.php",
                    method:"POST",
                    data:$('#formUpdateInsumo').serialize(),
                    success:function(response){
                        var opts = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-full-width",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "1000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };                        
                        toastr.success("Se ha actualizado el consumo del insumo", "Actualización exitosa", opts);
                        $('#modalUpdateInsumo').modal('hide');
                        document.getElementById('listConsumo'+idInsumo).innerHTML = consumo;
                        document.forms["formUpdateInsumo"]["newConsumo"].value = "";
                        alertaQuiebreStock();
                        }
                });
            } 
        });

        $('#addInsumo').click(function(){       
            $.ajax({
                url:"bin/insert-insumo-paciente.php",
                method:"POST",
                data:$('#formAddInsumo').serialize(),
                success:function(data){ 
                    var obj = JSON.parse(data);
                    $('#table-1').DataTable().row.add({
                        "DT_RowId": "listInsumo"+obj[0].id,
                        "0": obj[0].nombre,
                        "1": obj[0].tipo,
                        "2": obj[0].consumo,
                        "3": obj[0].stock,
                        "4": obj[0].eliminar}).draw();
                    document.getElementById('newTipoInsumo').value = '';
                    document.getElementById('newInsumo').value = '';
                    document.getElementById('newStock').value = '';
                    document.getElementById('newConsumo').value = '';
                    var opts = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-top-full-width",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    
                    toastr.success("Se ha agregado "+obj[0].nombre+" al consumo del paciente", "Ingreso exitoso", opts);
                            
                    }
            });
        });

        $('#addPreparado').click(function(){       
            $.ajax({
                url:"bin/insert-preparado.php",
                method:"POST",
                data:$('#formAddPreparado').serialize(),
                success:function(data){ 
                    var obj = JSON.parse(data);
                    $('#table-3').DataTable().row.add({
                        "DT_RowId": "listPreparado"+obj[0].prep_id,
                        "0": obj[0].principio_nombre,
                        "1": obj[0].prep_dosis+' '+obj[0].prep_unidad,
                        "2": obj[0].prep_cantidad+' '+obj[0].forma_nombre,
                        "3": obj[0].prep_pos_dosis+' '+obj[0].prep_unidad+' cada '+obj[0].prep_pos_horas+' horas',
                        "4": obj[0].detalles}).draw();
                    document.getElementById('formaId').value = '';
                    document.getElementById('nombreMedico').value = '';
                    document.getElementById('rutMedico').value = '';
                    document.getElementById('fechaReceta').value = '';
                    document.getElementById('dosis').value = '';
                    document.getElementById('unidadMedida').value = '';
                    document.getElementById('cantidad').value = '';
                    document.getElementById('posDosis').value = '';
                    document.getElementById('posHoras').value = '';
                    var opts = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-top-full-width",
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    
                    toastr.success("Se ha agregado el preparado magistral a la ficha del paciente", "Ingreso exitoso", opts);
                            
                    }
            });
        });

        $('#addPedido').click(function(){
            $.ajax({
                url:"bin/insert-pedido.php",
                method:"POST",
                data:$('#formAddPedido').serialize(),
                success:function(data){
                    window.location.replace('index.php?sec=edit-pedido&id=<?php echo $_GET['id'];?>&pid='+data);
                }
            });
        }); 

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
            ]
        });
    });
</script>

<div class="row" style="margin-top:-20px;">
    <div class="col-sm-4 patientContainer">
        <!-- Titulos Tabs Datos Paciente-->
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#datosPaciente" data-toggle="tab">
                    <span>Datos del Paciente</span>
                </a>
            </li>
            <li>
                <a href="#datosAdministrativos" data-toggle="tab">
                    <span>Datos Administrativos</span>
                </a>
            </li>
        </ul>

        <!-- Contenedor de Tabs Datos Paciente-->
        <div class="tab-content">
            <!-- Datos del Paciente -->
            <div class="tab-pane active" id="datosPaciente">
                <div>
                    <img src="./assets/images/lockscreen-user.png" alt="Foto Paciente" class="patientAvatar">
                </div>
                <div class="patientInfo">
                    <p class="patientTitle"><?php echo $datosPaciente['paciente_nombre'];?></p>
                    <p>Ficha Nº: <?php echo $datosPaciente['paciente_id'];?></p>
                    <p>RUT: <?php echo $datosPaciente['paciente_rut'];?></p>
                    <p>Edad: 
                    <?php 
                    //funcion de calculo de dedad del paciente
                        function calcular_edad($fecha){
                            $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
                            $fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
                            $edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
                            return $edad;
                        }
                        $edad = calcular_edad($datosPaciente['paciente_fecha_nac']);
                        echo "{$edad->format('%y')} años y {$edad->format('%m')} meses"; // Aplicamos un formato al objeto resultante de la funcion                        
                    ?>
                    </p>
                    <p>Sexo: <?php echo $datosPaciente['paciente_sexo'];?></p>
                    <p>Medico Tratante: <?php echo $datosPaciente['medico_nombre'];?></p>
                    <p>Diagnóstico: <?php echo $datosPaciente['paciente_diagnostico'];?></p>
                </div>                   
            </div>
            <!-- Datos Administrativos -->
            <div class="tab-pane" id="datosAdministrativos"> 
                <p>Nombre Tutor: <?php echo $datosPaciente['contacto_nombre1'];?></p>
                <p>Teléfono de contacto: <?php echo $datosPaciente['contacto_tel1'];?></p>
                <p>Dirección: <?php echo $datosPaciente['paciente_domicilio'];?></p>
                <p>Previsión: <?php echo $datosPaciente['paciente_prevision'];?></p>
                <p>Fecha de ingreso: <?php echo $datosPaciente['paciente_fecha_ingreso'];?></p>
                <p>Unidad de traslado móvil: <?php echo $datosPaciente['paciente_utm'];?></p>
                <p>Teléfono de unidad de traslado móvil: <?php echo $datosPaciente['paciente_utm_fono'];?></p>
                <p>N° de socio de unidad de traslado móvil: <?php echo $datosPaciente['paciente_utm_num'];?></p>
            </div>
        </div>
        <div class="alert alert-danger">Alertas</div>
        <div class="row" style="margin-left:0px; margin-top:10px;">
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/heart-rate.png" alt="FC" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Frecuencia Cardíaca">
                <b>90</b> bpm
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/temperature.png" alt="C°" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Temperatura">
                <b>36</b> °C 
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/respiratory.png" alt="FR" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Frecuencia Respiratoria">
                <b>12</b> rpm  
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/oxygen-sat.png" alt="SAT" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Saturación de Óxigeno">
                <b>98</b> %     
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/preasure.png" alt="P°" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Presión Arterial">
                <b>120/80</b>
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/weight.png" alt="KG" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Peso">
                <b>35</b> Kg 
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/height.png" alt="P°" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Talla">
                <b>80</b> cm
            </div>
            <div class="col-sm-4 vital-sign">
                <img src="./assets/images/farma-icons/head.png" alt="KG" class="farma-icon tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Circunferencia craneal">
                <b>50</b> cm 
            </div>
        </div>

        <!-- Calendar Body -->
        <div id="calendar" style="margin-top:40px;"></div>
    </div>

    <!-- Farmacia -->
    <div class="col-sm-8">
        <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
            <li class="active">
                <a href="#consumo" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-box"></i></span>
                    <span class="hidden-xs">Insumos y Medicamentos</span>
                    <span class="badge badge-danger" id="alertaInsumo"></span>
                </a>
            </li>
            <li>
                <a href="#magistrales" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-newspaper"></i></span>
                    <span class="hidden-xs">Preparados magistrales</span>

                    <span class="badge badge-danger" id="alertaPreparado"></span>
                </a>
            </li>
            <li>
                <a href="#pedidos" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-clipboard"></i></span>
                    <span class="hidden-xs">Nuevas Solicitudes</span>
                </a>
            </li>
        </ul>				
        <div class="tab-content">
        <!-- Consumo -->
            <div class="tab-pane active" id="consumo">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#exampleModal">
                    <i class="entypo-plus"></i>Agregar insumo
                </button>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Consumo</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-consumo">
                    <?php while($listaInsumos = $resultInsumos->fetch_assoc()) { 
                        $classDanger = '';
                        if($listaInsumos["pi_consumo"]*0.3>$listaInsumos["pi_stock"]){
                            $classDanger = "<i class='entypo-attention' style='color:#ff3300;'></i>";
                        }
                        ?>
                        <tr id="listInsumo<?php echo $listaInsumos['pi_id'];?>">
                            <td><?php echo $listaInsumos["insumo_nombre"];?></td>
                            <td><?php echo $listaInsumos["tipoinsumo_nombre"];?></td>
                            <td id="listConsumo<?php echo $listaInsumos['pi_id'];?>"><?php echo $listaInsumos["pi_consumo"];?></td>
                            <td><?php echo $listaInsumos["pi_stock"]." ".$classDanger;?></td>
                            <td width="80px">
                                <button type="button" class="btn btn-info btn-xs" onclick="
                                    document.getElementById('insumoId').value = '<?php echo $listaInsumos['pi_id'];?>';
                                    document.forms['formUpdateInsumo']['newConsumo'].value = '';
                                    $('#modalUpdateInsumo').modal('show');
                                ">
                                    <i class="entypo-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-xs" onclick="
                                var confirmDelete = confirm('¿Está seguro que desea eliminar el insumo?');
                                if(confirmDelete == true){
                                    $.ajax({
                                        type:'POST',
                                        url:'./bin/delete-consumo.php',
                                        data:'idInsumo=<?php echo $listaInsumos['pi_id'];?>',
                                        success:function(response){
                                            $('#table-1').DataTable().row($('#listInsumo<?php echo $listaInsumos['pi_id'];?>')).remove().draw();
                                            var opts = {
                                                'closeButton': true,
                                                'debug': false,
                                                'positionClass': 'toast-top-full-width',
                                                'onclick': null,
                                                'showDuration': '300',
                                                'hideDuration': '1000',
                                                'timeOut': '3000',
                                                'extendedTimeOut': '1000',
                                                'showEasing': 'swing',
                                                'hideEasing': 'linear',
                                                'showMethod': 'fadeIn',
                                                'hideMethod': 'fadeOut'
                                            };
                                
                                            toastr.info('Se ha eliminado el insumo del consumo del paciente', 'Eliminación exitosa', opts);
                                            confirmDelete = false;
                                        }
                                    });
                                } ">
                                    <i class="entypo-trash"></i>
                                </button>
                                <!--
                                <button type="button" class="btn btn-info btn-xs">
                                        
                                    <i class="entypo-pencil"></i>
                                </button>
                                -->
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>			
                </table> 
            </div>

        <!-- Preparados Magistrales -->
            <div class="tab-pane" id="magistrales"> 
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#newPreparadoModal">
                <i class="entypo-plus"></i>Nuevo preparado magistral
            </button>
            <table class="table table-bordered datatable" id="table-3">
                <thead>
                    <tr>
                        <th>Principio Actico</th>
                        <th>Dosis</th>
                        <th>Cantidad</th>
                        <th>Posología</th>
                        <!--<th>Duración estimada</th>-->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-consumo">
                <?php while($listaMagistrales = $resultMagistrales->fetch_assoc()) { 
                    $week=strtotime("-6 day");
                    $classDangerPrep = '';
                    if($listaMagistrales["prep_fecha_venc"]<date("Y-m-d", $week)){
                        $classDangerPrep = "<i class='entypo-attention' style='color:#ff3300;'></i>";
                    }
                ?>
                    <tr id="listPreparado<?php echo $listaInsumos['pi_id'];?>">
                        <td><?php echo $listaMagistrales["principio_nombre"];?></td>
                        <td><?php echo $listaMagistrales["prep_dosis"]." ".$listaMagistrales["prep_unidad"];?></td>
                        <td><?php echo $listaMagistrales["prep_cantidad"]." ".$listaMagistrales["forma_nombre"];?></td>
                        <td><?php echo $listaMagistrales["prep_pos_dosis"]." ".$listaMagistrales["prep_unidad"]." cada ".$listaMagistrales["prep_pos_horas"]." horas";?></td>
                    <?php /* <td><?php echo $listaMagistrales["prep_fecha_venc"]." ".$classDangerPrep;?></td> */?>
                        <td width="80px">
                            <a href="index.php?sec=magistral&id=<?php echo $listaMagistrales['prep_id'];?>" class="btn btn-info btn-xs">
                                <i class="entypo-doc-text"></i>
                            </a>
                            <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2){?>
                            <button type="button" class="btn btn-danger btn-xs" onclick="
                                var confirmDelete = confirm('¿Está seguro que desea eliminar el preparado magistral?');
                                if(confirmDelete == true){
                                    $.ajax({
                                        type:'POST',
                                        url:'./bin/delete-preparado.php',
                                        data:'idPreparado=<?php echo $listaMagistrales['prep_id'];?>',
                                        success:function(response){
                                            $('#table-3').DataTable().row($('#listPreparado<?php echo $listaInsumos['pi_id'];?>')).remove().draw();
                                            var opts = {
                                                'closeButton': true,
                                                'debug': false,
                                                'positionClass': 'toast-top-full-width',
                                                'onclick': null,
                                                'showDuration': '300',
                                                'hideDuration': '1000',
                                                'timeOut': '3000',
                                                'extendedTimeOut': '1000',
                                                'showEasing': 'swing',
                                                'hideEasing': 'linear',
                                                'showMethod': 'fadeIn',
                                                'hideMethod': 'fadeOut'
                                            };
                                
                                            toastr.info('Se ha eliminado el Preparado Magistral del paciente', 'Eliminación exitosa', opts);
                                            confirmDelete = false;
                                        }
                                    });
                                } ">
                                    <i class="entypo-trash"></i>
                                </button>
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>			
            </table> 
            </div>

        <!-- Pedidos -->
            <div class="tab-pane" id="pedidos">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-blue btn-sm btn-icon icon-left" data-toggle="modal" data-target="#newPedidoModal">
                <i class="entypo-plus"></i>Nuevo pedido
            </button>
            <table class="table table-bordered datatable" id="table-2">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Fecha pedido</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-consumo">
                <?php while($listaPedidos = $resultPedidos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $listaPedidos["pedido_desc"];?></td>
                        <td><?php echo $listaPedidos["pedido_fecha"];?></td>
                        <td><?php echo $listaPedidos["ep_nombre"];?></td>
                        <td width="100px">
                            <a href="index.php?sec=edit-pedido&id=<?php echo $_GET['id'];?>&pid=<?php echo $listaPedidos['pedido_id'];?>" class="btn btn-info btn-sm btn-icon icon-left">
                                <i class="entypo-doc-text"></i>Ver detalles
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>			
            </table> 
            </div>
        </div>
    </div>
</div>


<!-- Pop ups -->
<!-- Modal Agregar Insumo-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Insumo Nuevo</h3>
        </div>
        <div class="modal-body">
            <form id="formAddInsumo" name="formAddInsumo">
                <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">

                <label for="tipoinsumo">Tipo</label>
                <select class="form-control form-control-sm" name="tipoinsumoId" id="newTipoInsumo" required>
                    <option value="0"></option>
                <?php while($listaTipoInsumo = $resultTipoInsumo->fetch_assoc()) { ?>
                    <option value="<?php echo $listaTipoInsumo["tipoinsumo_id"];?>"><?php echo $listaTipoInsumo["tipoinsumo_nombre"];?></option>
                <?php } ?>
                </select>

                <label for="newInsumo">Nombre</label>
                <select class="form-control form-control-sm" name="insumoId" id="newInsumo" required>
                <option value=""></option>
                </select>

                <label for="newConsumo">Consumo</label>
                <input type="number" name="newConsumo" id="newConsumo" class="form-control form-control-sm">

                <label for="newStock">Stock</label>
                <input type="number" name="newStock" id="newStock" class="form-control form-control-sm">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="refreshInsumos" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            <button type="button" name="addInsumo" id="addInsumo" class="btn btn-success" data-dismiss="modal">Agregar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Pedido-->
<div class="modal fade" id="newPedidoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Nuevo Pedido</h3>
        </div>
        <div class="modal-body">
            <form id="formAddPedido" name="formAddPedido">
                <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="userId" value="<?php echo $_SESSION['userid'];?>">

                <label for="pedidoDesc">Descripción</label>
                <input type="text" name="pedidoDesc" id="pedidoDesc" class="form-control form-control-sm noEnterSubmit">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" name="addPedido" id="addPedido" class="btn btn-success">Agregar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Preparado Magistral-->
<div class="modal fade" id="newPreparadoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Nuevo Preparado Magistral</h3>
            </div>
            <div class="modal-body">
            <form id="formAddPreparado" name="formAddPreparado">
                <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="userId" value="<?php echo $_SESSION['userid'];?>">

            <label for="fechaReceta">Fecha de Receta</label>
            <input type="date" name="fechaReceta" id="fechaReceta" class="form-control form-control-sm">
            
            <div class="row">
                <div class="col-sm-6">
                    <label for="rutMedico">RUT Médico</label>
                    <input type="text" name="rutMedico" id="rutMedico" class="form-control form-control-sm">   
                </div>
                <div class="col-sm-6">
                    <label for="nombreMedico">Nombre Médico</label>
                    <input type="text" name="nombreMedico" id="nombreMedico" class="form-control form-control-sm">
                </div>
            </div>           

            <label for="principioId">Principio Activo</label>
            <select class="form-control form-control-sm" name="principioId" id="principioId" required>
            <option value="0"></option>
            <?php 
            while($listaPrincipioActivo = $resultPrincipioActivo->fetch_assoc()) { ?>
            <option value="<?php echo $listaPrincipioActivo["principio_id"];?>"><?php echo $listaPrincipioActivo["principio_nombre"];?></option>
            <?php } ?>
            </select>

            <div class="row">
                <div class="col-sm-6">
                    <label for="dosis">Dosis</label>
                    <input type="number" name="dosis" id="dosis" class="form-control form-control-sm">
                </div>
                <div class="col-sm-6">
                    <label for="unidadMedida">Unidad de medida</label>
                    <input type="text" name="unidadMedida" id="unidadMedida" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label for="formaId">Forma Farmaceutica</label>
                    <select class="form-control form-control-sm" name="formaId" id="formaId" required>
                    <option value="0"></option>
                    <?php 
                    while($listaFormaFarmaceutica = $resultFormaFarmaceutica->fetch_assoc()) { ?>
                    <option value="<?php echo $listaFormaFarmaceutica["forma_id"];?>"><?php echo $listaFormaFarmaceutica["forma_nombre"];?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control form-control-sm">
                </div>
            </div>
            
            <br>
            <p><b>Posología</b></p>            
            
            <div class="row">
                <div class="col-sm-6">
                    <label for="posDosis">Dosis (misma unidad de medida)</label>
                    <input type="text" name="posDosis" id="posDosis" class="form-control form-control-sm">
                </div>
                <div class="col-sm-6">
                    <label for="posHoras">Frecuencia (horas)</label>
                    <input type="text" name="posHoras" id="posHoras" class="form-control form-control-sm">
                </div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="button" name="addPreparado" id="addPreparado" class="btn btn-success" data-dismiss="modal">Agregar</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Actualiza Consumo-->
<div class="modal fade" id="modalUpdateInsumo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="exampleModalLabel">Actualizar Consumo</h3>
            </div>
            <div class="modal-body">
                <form id="formUpdateInsumo" name="formUpdateInsumo" onsubmit="false">
                    <input type="hidden" name="pacienteId" value="<?php echo $_GET['id'];?>">
                    <input type="hidden" name="insumoId" id="insumoId" value="0">

                    <label for="newConsumo">Consumo</label>
                    <input type="number" name="newConsumo" id="newConsumo" class="form-control form-control-sm noEnterSubmit"
                    data-validate="required" data-message-required="Debe ingresar el nuevo consumo." required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" name="updateInsumo" id="updateInsumo" class="btn btn-success">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/datatables/datatables.css">
<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
<link rel="stylesheet" href="assets/js/select2/select2.css">
<style>
.dataTables_info {
    display: none;
}
</style>

<!-- Imported scripts on this page -->
<script src="assets/js/datatables/datatables.js"></script>
<script src="assets/js/select2/select2.min.js"></script>
<script src="assets/js/toastr.js"></script>

<!-- Imported styles on this page -->
<link rel="stylesheet" href="assets/js/fullcalendar-2/fullcalendar.min.css">

<!-- Imported scripts on this page -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/fullcalendar-2/fullcalendar.min.js"></script>
<script src="assets/js/fullcalendar-2/lang/es.js"></script>
<script src="assets/js/neon-calendar-2.js"></script>