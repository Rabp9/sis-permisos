<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Mis Permisos");
    $this->assign("title-icon", "fa fa-book");
    
    $this->Html->addCrumb("<i class='fa fa-book'></i> Permisos", '/Permisos', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-list'></i> Mis Permisos", "/Permisos/view", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Nuevo Permiso", 
            "url" => ["controller" => "Permisos", "action" => "register"],
            "icono" => "fa fa-plus"]
    ]
]) ?>
<div class="dataTable_wrapper">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort("id", "Código") ?></th>
                    <th><?= $this->Paginator->sort("nro_boleta", "N° Boleta") ?></th>
                    <th><?= $this->Paginator->sort("fecha_permiso", "Fecha de Permiso") ?></th>
                    <th><?= $this->Paginator->sort("hora_salida", "Hora de Salida") ?></th>
                    <th><?= $this->Paginator->sort("motivo_id", "Motivo") ?></th>
                    <th><?= $this->Paginator->sort("destino", "Destino") ?></th>
                    <th><?= $this->Paginator->sort("estado") ?></th>
                    <th class="actions"><?= __('Acciones') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($permisos as $permiso) {
                $opciones = $this->element("opciones", [
                    "opciones" => [
                        ["titulo" => "Ver Permiso", 
                            "url" => ["controller" => "Permisos", "action" => "view", $permiso["Permiso"]["id"]],
                            "icono" => "fa fa-search"
                        ],
                        ["titulo" => "Imprimir Boleta", 
                            "url" => ["controller" => "Reportes", "action" => "boleta", $permiso["Permiso"]["id"], "imprimir"],
                            "icono" => "fa fa-print",
                            "target" => "_blank"
                        ]
                    ]
                ]);
                if($permiso["Permiso"]["estado"] == 4) {
                    $opciones = $this->element("opciones", [
                        "opciones" => [
                            ["titulo" => "Ver Permiso", 
                                "url" => ["controller" => "Permisos", "action" => "view", $permiso["Permiso"]["id"]],
                                "icono" => "fa fa-search"
                            ],
                            ["titulo" => "Generar Boleta", 
                                "url" => ["controller" => "Reportes", "action" => "boleta", $permiso["Permiso"]["id"], "descarga"],
                                "icono" => "fa fa-download"
                            ],
                            ["titulo" => "Imprimir Boleta", 
                                "url" => ["controller" => "Reportes", "action" => "boleta", $permiso["Permiso"]["id"], "imprimir"],
                                "icono" => "fa fa-print",
                                "target" => "_blank"
                            ]
                        ]
                    ]);
                } elseif ($permiso["Permiso"]["estado"] == 2) {
                    $opciones = $this->element("opciones", [
                        "opciones" => [
                            ["titulo" => "Ver Permiso", 
                                "url" => ["controller" => "Permisos", "action" => "viewlista", $permiso["Permiso"]["id"]],
                                "icono" => "fa fa-search"
                            ]
                        ]
                    ]);
                }
                $nroBoleta = $permiso["Permiso"]["nro_boleta"] == null ? "" : str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT);
                echo $this->Html->tableCells(
                    [
                        $permiso["Permiso"]["id"],
                        $nroBoleta,
                        $permiso["Permiso"]["fecha_permiso"],
                        $permiso["Permiso"]["hora_salida"],
                        $permiso["Motivo"]["descripcion"],
                        $permiso["Permiso"]["destino"],
                        $permiso["Permiso"]["estado_view"],
                        $opciones
                    ], [
                        "class" => "info"
                    ], [
                        "class" => "warning"
                    ]
                );
            } ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination">
    <?php
        echo $this->Paginator->prev(
            "&laquo;", 
            array(
                "tag" => "li",
                "escape" => false,
                "class" => "previous"
            ), 
            null, 
            array('class' => 'previous disabled')
        );
        echo $this->Paginator->numbers(array(
            "tag" => "li",
            "currentClass" => "active",
            "separator" => ""
        ));
        echo $this->Paginator->next(
            "&raquo;", 
            array(
                "tag" => "li",
                "escape" => false,
                "class" => "next"
            ), 
            null, 
            array('class' => 'next disabled')
        );
    ?>
        </ul>
    </nav>
    <p align="right">
        <?php echo $this->Paginator->counter(array(
            'format' => __('{:count} en total.')
        ));?>
    </p>
</div>
<?php
    $this->Js->buffer("$('ul.pagination li.active').wrapInner('<a></a>');");
    $this->Js->buffer("$('ul.pagination li.disabled').wrapInner('<a></a>');");
?>
<?php echo $this->Html->scriptStart(["block" => "script"]); ?>
    $(document).ready(function() {
        $("span.e1").parent().addClass("e1");
        $("span.e2").parent().addClass("e2");
        $("span.e3").parent().addClass("e3");
        $("span.e4").parent().addClass("e4");
    });
<?php echo $this->Html->scriptEnd(); ?>