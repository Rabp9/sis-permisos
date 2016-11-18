<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Editar Trabajador");
    $this->assign("title-icon", "fa fa-user");
    
    $this->Html->addCrumb("<i class='fa fa-user'></i> Trabajadores", '/Trabajadores', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-pencil'></i> Editar", "/Trabajadores/edit", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Lista Trabajadores", 
            "url" => ["controller" => "Trabajadores", "action" => "index"],
            "icono" => "fa fa-table"
        ]
    ]
]) ?>

<?php 
    echo $this->Form->create("Trabajador", array("class" => "form-horizontal"));
    $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10")); 
?>
<fieldset>
    <legend>Modificar la Información del Trabajador</legend>
    
    <h5><strong>Código</strong></h5>
    <p><?= h($trabajador["Trabajador"]["Per_DNI"]) ?></p>

    <h5><strong>Nombre Completo</strong></h5>
    <p><?= h($trabajador["Trabajador"]["nombre_completo"]) ?></p>

    <h5><strong>Unidad Orgánica</strong></h5>
    <p><?= h($trabajador["Historico_Cargo"]["Area"]["Are_Descripcion"]) ?></p>
   
    <?php if(isset($trabajador["User"]["Usu_Login"])) { ?>
    <h5><strong>Usuario</strong></h5>
    <p><?= h($trabajador["User"]["Usu_Login"]) ?></p>

    <h5><strong>Grupo</strong></h5>
    <p><?= h(@$trabajador["User"]["Group"]["descripcion"]) ?></p>

    <div class="form-group">
        <?= $this->Form->label("group_id", "Asignar Nuevo Grupo",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("User.group_id", [
            "label" => false,
            "autofocus" => true,
            "empty" => "Selecciona un Grupo",
            "value" => $trabajador["User"]["group_id"]
        ]); ?>
        <?= $this->Form->input("User.Usu_Codigo", [
            "type" => "hidden",
            "value" => $trabajador["User"]["Usu_Codigo"]
        ]) ?>
    </div>
    
    <div class="form-group">
        <?= $this->Form->label("Trabajadores_Aprobador.aprobador_Per_DNI", "Sus Permisos son aprobados por",
            ["class" => "col-sm-2 control-label"]
        ); ?>
        <?= $this->Form->input("Trabajadores_Aprobador.aprobador_Per_DNI", [
            "label" => false,
            "autofocus" => true,
            "empty" => "Selecciona un Trabajador",
            "options" => $trabajadores,
            "value" => @$trabajador["Trabajadores_Aprobador"]["aprobador_Per_DNI"]
        ]); ?>
        <?= $this->Form->input("Trabajadores_Aprobador.trabajador_Per_DNI", [
            "type" => "hidden",
            "value" => @$trabajador["Trabajador"]["Per_DNI"]
        ]) ?>
        <?= $this->Form->input("Trabajadores_Aprobador.id", [
            "type" => "hidden",
            "value" => @$trabajador["Trabajadores_Aprobador"]["id"]
        ]) ?>
    </div>
    
    <?= $this->Form->button("Guardar", ["class" => "btn btn-primary"]); ?>
    <?php } else { ?>
    <div class="alert alert-danger">
        El trabajador no tiene un usuario asignado. Por favor contáctate con el Administrador del Sistema.
    </div>
    <?php } ?>
</fieldset>
<?= $this->Form->end(); ?>