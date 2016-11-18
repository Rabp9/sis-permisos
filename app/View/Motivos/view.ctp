<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Vista Motivo");
    $this->assign("title-icon", "fa fa-archive");
    
    $this->Html->addCrumb("<i class='fa fa-archive'></i> Motivos", '/Motivos', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-search'></i> Vista", "/Motivos/view", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Lista Motivos", 
            "url" => ["controller" => "Motivos", "action" => "index"],
            "icono" => "fa fa-table"
        ],
        ["titulo" => "Editar Motivo", 
            "url" => ["controller" => "Motivos", "action" => "edit", $motivo["Motivo"]["id"]],
            "icono" => "fa fa-edit"
        ],
    ]
]) ?>
<h5><strong>Código</strong></h5>
<p><?= h($motivo["Motivo"]["id"]) ?></p>

<h5><strong>Descripción</strong></h5>
<p><?= h($motivo["Motivo"]["descripcion"]) ?></p>

<h5><strong>Descuento</strong></h5>
<p><?= h($motivo["Motivo"]["descuento_view"]) ?></p>