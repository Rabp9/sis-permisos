<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Vista Trabajador");
    $this->assign("title-icon", "fa fa-user");
    
    $this->Html->addCrumb("<i class='fa fa-user'></i> Trabajadores", '/Trabajadores', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-search'></i> Vista", "/Trabajadores/view", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Lista Trabajadores", 
            "url" => ["controller" => "Trabajadores", "action" => "index"],
            "icono" => "fa fa-table"
        ],
        ["titulo" => "Editar Trabajador", 
            "url" => ["controller" => "Trabajadores", "action" => "edit", $trabajador["Trabajador"]["Per_DNI"]],
            "icono" => "fa fa-edit"
        ],
    ]
]) ?>
<h5><strong>Código</strong></h5>
<p><?= h($trabajador["Trabajador"]["Per_DNI"]) ?></p>

<h5><strong>Nombre Completo</strong></h5>
<p><?= h($trabajador["Trabajador"]["nombre_completo"]) ?></p>

<h5><strong>Unidad Orgánica</strong></h5>
<p><?= h($trabajador["Historico_Cargo"]["Area"]["Are_Descripcion"]) ?></p>

<?php if(isset($trabajador["User"]["Usu_Login"])) { ?>

<h5><strong>Sus Permisos son aprobados por</strong></h5>
<p><?= h($trabajador["Trabajadores_Aprobador"]["Aprobador"]["nombre_completo"]) ?></p>

<h5><strong>Usuario</strong></h5>
<p><?= h($trabajador["User"]["Usu_Login"]) ?></p>

<h5><strong>Grupo</strong></h5>
<p><?= h(@$trabajador["User"]["Group"]["descripcion"]) ?></p>

<?php } else { ?>
<div class="alert alert-danger">
    El trabajador no tiene un usuario asignado. Por favor contáctate con el Administrador del Sistema.
</div>
<?php } ?>