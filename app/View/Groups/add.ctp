<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Nuevo Grupo");
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Lista Grupos", 
            "url" => ["controller" => "Groups", "action" => "index"],
            "icono" => "fa fa-table"
        ]
    ]
]) ?>
<?php 
    echo $this->Form->create("Group", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10")); 
?>
<fieldset>
    <legend>Registra un nuevo Grupo</legend>
    
    <div class="form-group">
        <?= $this->Form->label("descripcion", "Descripción",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("descripcion", [
            "label" => false,
            "autofocus" => true
        ]); ?>
    </div>
    
    <?= $this->Form->button("Guardar", ["class" => "btn btn-primary"]); ?>
</fieldset>
<?= $this->Form->end(); ?>