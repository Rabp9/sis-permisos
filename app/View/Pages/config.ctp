<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Configuración");
    $this->assign("title-icon", "fa fa-wrench");
     
    $this->Html->addCrumb("<i class='fa fa-wrench'></i> Configuración", '/Pages/config', array("escape" => false));
?>
<?php 
    echo $this->Form->create("Config", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10")); 
?>
<fieldset>
    <legend>Configura el Sistema de Permisos</legend>
    
    <div class="form-group">
        <?= $this->Form->label("0.Config.valor", "Hora de Entrada",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("0.Config.clave", [
            "type" => "hidden",
            "value" => "hora_entrada"
        ]); ?>
        <?= $this->Form->input("0.Config.valor", [
            "label" => false,
            "autofocus" => true,
            "pattern" => "(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){1}",
            "after" => "<p class='help-block'>Formato 00:00 - 23:59</p>",
        ]); ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label("1.Config.valor", "Hora de Salida",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("1.Config.clave", [
            "type" => "hidden",
            "value" => "hora_salida"
        ]); ?>
        <?= $this->Form->input("1.Config.valor", [
            "label" => false,
            "pattern" => "(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){1}",
            "after" => "<p class='help-block'>Formato 00:00 - 23:59</p>",
        ]); ?>
    </div>
    
    <?= $this->Form->button("Guardar", ["class" => "btn btn-primary"]); ?>
</fieldset>
<?= $this->Form->end(); ?>