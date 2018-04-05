<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Home");
    $this->assign("title-icon", "fa fa-home");
    
    $user = $this->Session->read('Auth.User');
    $group = $user["Group"]["descripcion"];
    $estilos = array("box1-bg", "box2-bg");
?>
<fieldset>
    <legend>Bienvenido</legend>
</fieldset>
<?php
    $abrir = "<div class='row'>";
    $cerrar_abrir = "</div><div class='row'>";
    $cerrar = "</div>";
    $estilo = false;
    
    $mantenimiento_motivos = false;
    $mantenimiento_trabajadores = false;
    $permisos_mis = false;
    $permisos_nuevo = false;
    $permisos_lista = false;
    $permisos_generar = false;
    $reportes_general = false;
    $reportes_por_trabajador = false;
?>
<?php
    if($group == "Administrador") {
        $mantenimiento_motivos = true;
        $mantenimiento_trabajadores = true;
        $permisos_lista = true;
        $permisos_generar = true;
        $reportes_general = true;
        $reportes_por_trabajador = true;
        $final = 6;
    } elseif($group == "Aprobador") {
        $permisos_mis = true;
        $permisos_nuevo = true;
        $permisos_lista = true;
        $final = 3;
    } elseif($group == "RRHH") {
        $permisos_mis = true;
        $permisos_nuevo = true;
        $permisos_lista = true;
        $permisos_generar = true;
        $reportes_general = true;
        $reportes_por_trabajador = true;
        $final = 6;
    } elseif($group == "Usuario") {
        $permisos_mis = true;
        $permisos_nuevo = true;
        $final = 2;
    } elseif($group == "GAFS") {
        $permisos_mis = true;
        $permisos_nuevo = true;
        $permisos_lista = true;
        $reportes_general = true;
        $reportes_por_trabajador = true;
        $final = 5;
    }
    $count = 0;
    if($mantenimiento_motivos) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Motivos")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="fa fa-archive"></i>
                <div class="count">Motivos</div>
                <div class="title">Mantenimiento</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($mantenimiento_trabajadores) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Trabajadores")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="fa fa-user"></i>
                <div class="count">Trabajadores</div>
                <div class="title">Mantenimiento</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($permisos_mis) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Permisos")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="icon_briefcase"></i>
                <div class="count">Mis Permisos</div>
                <div class="title">Permisos</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($permisos_nuevo) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Permisos", "action" => "register")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="icon_plus"></i>
                <div class="count">Nuevo Permiso</div>
                <div class="title">Permisos</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
 <?php  $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($permisos_lista) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Permisos", "action" => "lista")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="icon_table"></i>
                <div class="count">Lista Permisos</div>
                <div class="title">Permisos</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($permisos_generar) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Permisos", "action" => "generar")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="icon_archive"></i>
                <div class="count">Generar Permiso</div>
                <div class="title">Permisos</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($reportes_general) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Reportes", "action" => "general")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="fa fa-map-marker"></i>
                <div class="count">Rep. General</div>
                <div class="title">Reportes</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
    if($reportes_por_trabajador) {
        if($count == 0) {
            echo $abrir;
        } elseif($count % 3 == 0) {
            echo $cerrar_abrir;
            $estilo = !$estilo;
        }
?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <a href="<?= $this->Html->url(array("controller" => "Reportes", "action" => "porTrabajador")) ?>">
            <div class="info-box <?= $estilos[$estilo]?>">
                <i class="fa fa-user"></i>
                <div class="count">Por Trabajador</div>
                <div class="title">Reportes</div>
            </div><!--/.info-box-->		
        </a>	
    </div><!--/.col-->
<?php   $estilo = !$estilo;
        $count++;
        if($count == $final) {
            echo $cerrar;
        }
    }
?>