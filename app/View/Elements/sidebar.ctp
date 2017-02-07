<?php 
    $controller = $this->request->params['controller'];
    $action = $this->request->params['action'];
    $user = $this->Session->read('Auth.User');
    $group = $user["Group"]["descripcion"];
?>
<aside>
    <div id="sidebar"  class="nav-collapse">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">                
            <li class="<?= $controller == "Pages" && $action == "home" ? "active" : "" ?>">
                <a href="<?= $this->Html->url(["controller" => "Pages", "action" => "home"]) ?>">
                    <i class="icon_house_alt"></i>
                    <span>Home</span>
                </a>
            </li>
            <?php if($group == "Administrador") { ?>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="icon_document_alt"></i>
                    <span>Mantenimiento</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li class="<?= $controller == "Motivos" ? "active" : "" ?>"><a href="<?= $this->Html->url(["controller" => "Motivos", "action" => "index"]) ?>">Motivos</a></li>                          
                    <li class="<?= $controller == "Trabajadores" ? "active" : "" ?>"><a href="<?= $this->Html->url(["controller" => "Trabajadores", "action" => "index"]) ?>">Trabajadores</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if($group != "Administrador") { ?>
            <li class="<?= $controller == "Permisos" && ($action == "index" || $action == "view") ? "active" : "" ?>">                     
                <a class="" href="<?= $this->Html->url(["controller" => "Permisos", "action" => "index"]) ?>">
                    <i class="icon_briefcase"></i>
                    <span>Mis Permisos</span>
                </a>
            </li>
            <?php } ?>
            <?php if($group != "Administrador") { ?>
            <li class="<?= $controller == "Permisos" && $action == "register" ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(["controller" => "Permisos", "action" => "register"]) ?>">
                    <i class="icon_plus"></i>
                    <span>Nuevo Permiso</span>
                </a>
            </li>
            <?php } ?>
            <?php if($group == "Administrador") { ?>
            <li class="<?= $controller == "Permisos" ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(["controller" => "Permisos", "action" => "lista"]) ?>">
                    <i class="icon_table"></i>
                    <span>Lista de Permisos</span>
                </a>
            </li>
            <?php } elseif($group != "Usuario") { ?>
            <li class="<?= $controller == "Permisos" && ($action == "lista" || $action == "viewlista") ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(["controller" => "Permisos", "action" => "lista"]) ?>">
                    <i class="icon_table"></i>
                    <span>Lista de Permisos</span>
                </a>
            </li>
            <?php } ?>
            <?php if($group != "Aprobador" && $group != "Usuario") { ?>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="icon_document_alt"></i>
                    <span>Reportes</span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>
                <ul class="sub">
                    <li class="<?= $controller == "Reportes" && $action == "general" ? "active" : "" ?>"><a href="<?= $this->Html->url(["controller" => "Reportes", "action" => "general"]) ?>">General</a></li>                          
                    <li class="<?= $controller == "Reportes" && $action == "porTrabajador" ? "active" : "" ?>"><a href="<?= $this->Html->url(["controller" => "Reportes", "action" => "porTrabajador"]) ?>">Por Trabajador</a></li>
                </ul>
            </li>
            <?php } ?>
            <?php if($group == "Administrador") { ?>
            <li class="<?= $controller == "Pages" && $action == "config" ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(["controller" => "Pages", "action" => "config"]) ?>">
                    <i class="fa fa-wrench"></i>
                    <span>Configuración</span>
                </a>
            </li>
            <?php } ?>
            <li class="visible-xs <?= $controller == "Users" && $action == "datos" ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(array("controller" => "Users", "action" => "datos")) ?>">
                    <i class="icon_profile"></i>
                    <span>Mi Perfil</span>
                </a>
            </li>
            <li class="visible-xs <?= $controller == "Users" && $action == "logout" ? "active" : "" ?>">
                <a class="" href="<?= $this->Html->url(array("controller" => "Users", "action" => "logout")) ?>">
                    <i class="fa fa-sign-out"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<?php echo $this->Html->scriptStart(["block" => "script"]); ?>
    $(document).ready(function() {
        if($("aside li.active").parent().attr("class") == "sub") {
            $("aside li.active").parent().attr("style", "display: block;");
            $("aside span.menu-arrow").removeClass("arrow_carrot-right")
                .addClass("arrow_carrot-down"); 
        }
    });
<?php echo $this->Html->scriptEnd(); ?>