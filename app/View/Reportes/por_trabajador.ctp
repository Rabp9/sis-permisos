<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Reporte por Trabajador");
    $this->assign("title-icon", "icon_book");
    
    $this->Html->addCrumb("<i class='icon_document_alt'></i> Reportes", '/Reportes/porTrabajador', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-user'></i> Por Trabajador", "/Reportes/por_trabajador", array("escape" => false));
    
    $this->Html->css("/assets/calendar/jquery-ui.min", ["block" => "css"]);
    $this->Html->css("/assets/calendar/jquery-ui.structure.min", ["block" => "css"]);
    $this->Html->css("/assets/calendar/jquery-ui.theme.min", ["block" => "css"]);
    
    $this->Html->script("/assets/calendar/jquery-ui.min", ["block" => "script"]);
    $this->Html->script("/assets/calendar/datepicker-es", ["block" => "script"]);
?>
<?php
    echo $this->Form->create("Reporte", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10", "label" => false));
?>
<fieldset>
    <legend>Especifica el intervalo de fechas</legend>
        <div class="form-group">
            <?= $this->Form->label("fecha_inicio", "Fecha Inicio",
                ["class" => "col-sm-2 control-label"]
            ); ?>
            <?= $this->Form->input("fecha_inicio", [
                "type" => "text",
                "required" => true,
                "pattern" => "(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))"
            
            ]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->label("fecha_cierre", "Fecha Cierre",
                ["class" => "col-sm-2 control-label"]
            ); ?>
            <?= $this->Form->input("fecha_cierre", [
                "type" => "text",
                "required" => true,
                "pattern" => "(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))"
            
            ]); ?>
        </div>    
        <div class="form-group">
            <?= $this->Form->label("Per_DNI", "Trabajador",
                ["class" => "col-sm-2 control-label"]
            ); ?>
            <?= $this->Form->input("Per_DNI", [
                "label" => false,
                "empty" => "Selecciona un Trabajador",
                "options" => $trabajadores,
                "required" => true
            ]); ?>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tipo de Reporte</label>
            
            <div class="col-sm-10">
                <div class="radio">
                    <label>
                        <input type="radio" name="data[Reporte][tipo]" id="ReporteTipoDetallado" value="detallado" checked>
                        Reporte Detallado
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="data[Reporte][tipo]" id="ReporteTipoGenerico" value="generico">
                        Reporte Genérico
                    </label>
                </div>
            </div>
        </div>
        <?= $this->Form->button("Generar Reporte", ["class" => "btn btn-primary"]); ?>
    </fieldset>
<?= $this->Form->end(); ?>

<?php echo $this->Html->scriptStart(["block" => "script"]); ?>
    $(document).ready(function() {
        $("#ReporteFechaInicio").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $("#ReporteFechaCierre").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $("#ReportePorTrabajadorForm").submit(function() {
            var fecha_inicio = $("#ReporteFechaInicio").val();
            var fecha_cierre = $("#ReporteFechaCierre").val();
            if(fecha_inicio > fecha_cierre) {
                alert("La fecha de cierre debe ser posterior a la fecha de inicio");
                return false;
            }
        })
        
        $('#ReporteFechaInicio, #ReporteFechaCierre').on('change', function() {
            $("#ReporteFechaCierre").datepicker( "option", "minDate", $("#ReporteFechaInicio").val());
            $("#ReporteFechaInicio").datepicker( "option", "maxDate", $("#ReporteFechaCierre").val());
        });
    });
<?php echo $this->Html->scriptEnd(); ?>