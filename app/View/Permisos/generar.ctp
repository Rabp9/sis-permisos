<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Generar Permiso");
    $this->assign("title-icon", "fa fa-book");
    
    $this->Html->addCrumb("<i class='fa fa-book'></i> Permisos", '/Permisos', array("escape" => false));
    $this->Html->addCrumb("<i class='icon_plus'></i> Generar Permiso", "/Permisos/generar", array("escape" => false));
    
    $this->Html->css("/assets/calendar/jquery-ui.min", ["block" => "css"]);
    $this->Html->css("/assets/calendar/jquery-ui.structure.min", ["block" => "css"]);
    $this->Html->css("/assets/calendar/jquery-ui.theme.min", ["block" => "css"]);
    
    $this->Html->script("/assets/calendar/jquery-ui.min", ["block" => "script"]);
    $this->Html->script("/assets/calendar/datepicker-es", ["block" => "script"]);
?>
<?php
    echo $this->Form->create("Permiso", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10", "label" => false));
?>
<fieldset>
    <legend>Genera una nueva Solicitud de Permiso</legend>
    <div class="form-group">
        <?= $this->Form->label("Per_DNI", "Trabajador", [
            "class" => "col-sm-2 control-label"
        ]); ?>
        <?= $this->Form->input("Per_DNI", [
            "label" => false,
            "autofocus" => true,
            "empty" => "Selecciona un Trabajador",
            "options" => $trabajadores
        ]); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label("destino", "Destino",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("destino", [
            "autofocus" => true
        ]); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label("fecha_permiso", "Fecha de Permiso",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("fecha_permiso", [
            "type" => "text",
            "div" => "col-sm-4",
            "value" => date("Y-m-d")
        ]); ?>
        <?= $this->Form->label("hora_salida", "Hora de Salida",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("hora_salida", [
            "type" => "text",
            "div" => "col-sm-4",
            "pattern" => "(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){1}",
            "after" => "<p class='help-block'>Formato 00:00 - 23:59</p>",
            "value" => date("H:i")
        ]); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label("motivo", "Motivo",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("motivo_id", [
            "empty" => "Selecciona un Motivo"
        ]); ?>
    </div>
    <?= $this->Form->button("Guardar", [
        "id" => "btnGuardar",
        "class" => "btn btn-primary"
    ]); ?>
</fieldset>
<?= $this->Form->end(); ?>

<?php echo $this->Html->scriptStart(["block" => "script"]); ?>
    $(document).ready(function() {
        $("#PermisoFechaPermiso").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        
        $("#PermisoRegisterForm").submit(function() {
            var hora_ingresada = $("#PermisoHoraSalida").val();
            var hora_entrada = "<?= $hora_entrada["Config"]["valor"] ?>";
            var hora_salida = "<?= $hora_salida["Config"]["valor"] ?>";
            if(hora_ingresada < hora_entrada || hora_ingresada > hora_salida) {
                alert("La hora ingresada debe estar en el intervalo de " + hora_entrada + " a " + hora_salida);
                return false;
            } else {
                $("#btnGuardar").text("Cargando...");
                $("#btnGuardar").attr("disabled", "disabled");
                return true;
            }
        });
        
        $("#btnGuardar").click(function() {
        });
    });
<?php echo $this->Html->scriptEnd(); ?>