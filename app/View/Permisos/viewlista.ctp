<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Vista Permiso");
    $this->assign("title-icon", "fa fa-book");
    $vacio = "---------------------------------";
?>
<?php
    $opcion1 = ["titulo" => "Lista Permisos", 
        "url" => ["controller" => "Permisos", "action" => "lista"],
        "icono" => "fa fa-table"
    ];
    $opcion2 = ["titulo" => "Aprobar", 
        "url" => ["controller" => "Permisos", "action" => "aprobar", $permiso["Permiso"]["id"]],
        "icono" => "fa fa-check-circle",
        "tipo" => "postlink"
    ];
    if($permiso["Permiso"]["estado"] == 1) {
        echo $this->element("opciones", [
            "opciones" => [$opcion1, $opcion2]
        ]);
    } else {
        echo $this->element("opciones", [
            "opciones" => [$opcion1]
        ]);
    }
?>
<h5><strong>Código</strong></h5>
<p><?= h($permiso["Permiso"]["id"]) ?></p>

<h5><strong>Nro. Boleta</strong></h5> 
<?php 
    $nroBoleta = $permiso["Permiso"]["nro_boleta"] == null ? $vacio : str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT);
?>           
<p><?= $nroBoleta ?></p>

<h5><strong>Trabajador</strong></h5>
<p><?= h($permiso["Trabajador"]["nombre_completo"]) ?></p>

<h5><strong>Unidad Orgánica</strong></h5>
<p><?= h($permiso["Area"]["Are_Descripcion"]) ?></p>

<h5><strong>Motivo</strong></h5>
<p><?= h($permiso["Motivo"]["descripcion"]) ?></p>

<h5><strong>Destino</strong></h5>
<p><?= h($permiso["Permiso"]["destino"]) ?></p>

<h5><strong>Fecha y Hora de Permiso</strong></h5>
<p><?= h($permiso["Permiso"]["fecha_permiso"] . " " . $permiso["Permiso"]["hora_salida"]) ?></p>

<h5><strong>Hora de Retorno</strong></h5>
<p><?= h($permiso["Permiso"]["hora_retorno"] == null ? $vacio : $permiso["Permiso"]["hora_retorno"]) ?></p>

<?php if($admin) { ?>

<h5><strong>Fecha y Hora de creación</strong></h5>
<p><?= h($permiso["Permiso"]["created"] == null ? $vacio : $permiso["Permiso"]["created"]) ?></p>

<h5><strong>Fecha y Hora de Registro de Aprobación</strong></h5>
<p><?= h($permiso["Permiso"]["hora_registro_aprobacion"] == null ? $vacio : $permiso["Permiso"]["hora_registro_aprobacion"]) ?></p>

<h5><strong>Fecha y Hora de Registro de Retorno</strong></h5>
<p><?= h($permiso["Permiso"]["hora_registro_retorno"] == null ? $vacio : $permiso["Permiso"]["hora_registro_retorno"]) ?></p>

<h5><strong>Usuario que aprueba el permiso</strong></h5>
<p><?= h($permiso["User_aprobacion"]["Usu_Login"] == null ? $vacio : $permiso["User_aprobacion"]["Usu_Login"]) ?></p>

<h5><strong>Usuario que registra la hora de retorno</strong></h5>
<p><?= h(!isset($permiso["User_retorno"]["Usu_Login"]) ? $vacio : $permiso["User_retorno"]["Usu_Login"]) ?></p>

<?php } ?>

<h5><strong>Estado</strong></h5>
<p><?= $permiso["Permiso"]["estado_view"] ?></p>
