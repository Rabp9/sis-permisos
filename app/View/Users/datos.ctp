<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Mi Perfil");
    $this->assign("title-icon", "fa fa-user");
    
    $this->Html->addCrumb("<i class='fa fa-user'></i> Mi Perfil", "/Users/datos", array("escape" => false));
?>
<?php if($user["Group"]["descripcion"] == "Administrador") { ?>
<h5><strong>Usuario</strong></h5>
<p><?= h(@$user["User"]["Usu_Login"]) ?></p>

<h5><strong>Grupo</strong></h5>
<p><?= h(@$user["Group"]["descripcion"]) ?></p>

<?php } else { ?>
<h5><strong>Código</strong></h5>
<p><?= h($user["Trabajador"]["Per_DNI"]) ?></p>

<h5><strong>Nombre Completo</strong></h5>
<p><?= h($user["Trabajador"]["nombre_completo"]) ?></p>

<h5><strong>Unidad Orgánica</strong></h5>
<p><?= h($user["Trabajador"]["Historico_Cargo"]["Area"]["Are_Descripcion"]) ?></p>

<?php if(isset($user["User"]["Usu_Login"])) { ?>

<h5><strong>Sus Permisos son aprobados por</strong></h5>
<p><?= h(@$user["Trabajador"]["Trabajadores_Aprobador"]["Aprobador"]["nombre_completo"]) ?></p>

<h5><strong>Usuario</strong></h5>
<p><?= h(@$user["User"]["Usu_Login"]) ?></p>

<h5><strong>Grupo</strong></h5>
<p><?= h(@$user["Group"]["descripcion"]) ?></p>

<?php } else { ?>
<div class="alert alert-danger">
    El trabajador no tiene un usuario asignado. Por favor contáctate con el Administrador del Sistema.
</div>
<?php 
        }
    } 
?>
