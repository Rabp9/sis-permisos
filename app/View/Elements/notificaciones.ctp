<?php 
    $user = $this->Session->read('Auth.User');
    if($user["Group"]["descripcion"] != "Administrador") {
        $username = $user["Trabajador"]["nombre_completo"];
    } else {
        $username = $user["Usu_Login"];
    }
    $permisos_pendientes = $this->requestAction("/Permisos/permisosPendientes");
    $size = sizeof($permisos_pendientes);
    if($size == 0) {
        $mensaje = "No tienes permisos para aprobar";
    } elseif($size == 1) {
        $mensaje = $size . " permiso sin aprobar. (Click para aprobar)";
    } else {
        $mensaje = $size . " permisos sin aprobar. (Click para aprobar)";
    }
     
?>
<div class="top-nav notification-row">                
    <!-- notificatoin dropdown start-->
    <ul class="nav pull-right top-menu">
        <!-- inbox notificatoin end -->
        <!-- alert notification start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="cursor: default;">
                <span class="username"><?= "Trujillo, " . $this->Time->format(date("Y-m-d"), "%e de %B del %Y")  ?></span>
            </a>
        </li>
        <li id="permisos_pendientes" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-bell-l"></i>
                <span class="badge bg-important"><?= $size ?></span>
            </a>
            <ul class="dropdown-menu extended notification">
                <div class="notify-arrow notify-arrow-blue"></div>
                <li>
                    <p class="blue"><?= $mensaje; ?></p>
                </li>
                <?php for($count = 0; $count < ($size < 4 ? $size : 4)  ; $count++) {
                    $permiso = $permisos_pendientes[$count];
                ?>
                <li> 
                    <?php
                        $link = "<span class='label label-warning'><i class='fa fa-book'></i></span>" . 
                            $permiso["Trabajador"]["nombre_completo"] .
                        "<span class='small italic pull-right'>" . $permiso["Permiso"]["fecha_permiso"] . " " . $permiso["Permiso"]["hora_salida"] . "</span>";
                       
                        echo $this->Form->postLink($link,
                            array("controller" => "Permisos", "action" => "aprobar", $permiso["Permiso"]["id"]),
                            array("confirm" => "¿Estás seguro?", "escape" => false)
                        );
                    ?>
                </li>
                <?php } ?>
                <?php if($size > 4) { ?>
                <li>
                    <a href="<?= $this->Html->url(array("controller" => "Permisos", "action" => "lista")); ?>">Ver todos los permisos</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <!-- alert notification end-->
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="username"><?= $username; ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <div class="log-arrow-up"></div>
                <li class="eborder-top">
                    <a href="<?= $this->Html->url(array("controller" => "Users", "action" => "datos")) ?>"><i class="icon_profile"></i> Mi Perfil</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-book"></i> Manual</a>
                </li>
                <li>
                    <a href="<?= $this->Html->url(array("controller" => "Users", "action" => "logout")) ?>"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                </li>
            </ul>
        </li>
        <!-- user login dropdown end -->
    </ul>
    <!-- notificatoin dropdown end-->
</div>