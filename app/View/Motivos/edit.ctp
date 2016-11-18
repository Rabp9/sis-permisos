<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Editar Motivo");
    $this->assign("title-icon", "fa fa-archive");
    
    $this->Html->addCrumb("<i class='fa fa-archive'></i> Motivos", '/Motivos', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-pencil'></i> Editar", "/Motivos/view", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Lista Motivos", 
            "url" => ["controller" => "Motivos", "action" => "index"],
            "icono" => "fa fa-table"
        ],
        ["titulo" => "Nuevo Motivo", 
            "url" => ["controller" => "Motivos", "action" => "add"],
            "icono" => "fa fa-plus"
        ]
    ]
]) ?>

<?php 
    echo $this->Form->create("Motivo", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10")); 
?>
<fieldset>
    <legend>Modificiar el Motivo</legend>
    
    <div class="form-group">
        <?= $this->Form->label("descripcion", "Descripción",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("descripcion", [
            "label" => false,
            "autofocus" => true
        ]); ?>
    </div>   
    <div class="form-group">
        <?= $this->Form->label("descuento", "Descuento",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("descuento", [
            "label" => false,
            "type" => "checkbox",
            "class" => false
        ]); ?>
    </div>
    <?= $this->Form->button("Guardar", ["class" => "btn btn-primary"]); ?>
</fieldset>
<?= $this->Form->end(); ?>