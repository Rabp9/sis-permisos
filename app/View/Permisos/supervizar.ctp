<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Lista de Permisos");
    $this->assign("title-icon", "fa fa-book");
?>

<div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort("id", "Código") ?></th>
                <th><?= $this->Paginator->sort("nro_boleta", "N° Boleta") ?></th>
                <th><?= $this->Paginator->sort("Per_DNI", "Trabajador") ?></th>
                <th><?= $this->Paginator->sort("fecha_permiso", "Fecha de Permiso") ?></th>
                <th><?= $this->Paginator->sort("hora_salida", "Hora de Salida") ?></th>
                <th><?= $this->Paginator->sort("motivo_id", "Motivo") ?></th>
                <th><?= $this->Paginator->sort("destino", "Destino") ?></th>
                <th><?= $this->Paginator->sort("estado") ?></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($permisos as $permiso) {
            $opciones = "";
            if($permiso["Permiso"]["estado"] == 2) {
                $opciones = $this->element("opciones", [
                    "opciones" => [
                        ["titulo" => "Registrar Retorno", 
                            "url" => ["controller" => "Permisos", "action" => "retorno", $permiso["Permiso"]["id"]],
                            "icono" => "fa fa-pencil",
                            "tipo" => "modal",
                            "metadatos" => array(
                                "data-toggle" => "modal",
                                "data-target" => "#mdlRegistrarRetorno",
                                "data-id" => $permiso["Permiso"]["id"],
                                "data-hora-min" => $permiso["Permiso"]["hora_salida"]
                            )
                        ],
                    ]
                ]);
            } elseif($permiso["Permiso"]["estado"] == 4) {
                $opciones = $this->element("opciones", [
                    "opciones" => [
                        ["titulo" => "Imprimir Boleta", 
                            "url" => ["controller" => "Reportes", "action" => "boleta", $permiso["Permiso"]["id"], "imprimir"],
                            "icono" => "fa fa-print",
                            "target" => "_blank"
                        ]
                    ]
                ]);
            }
            $nroBoleta = $permiso["Permiso"]["nro_boleta"] == null ? "" : str_pad($permiso["Permiso"]["nro_boleta"], 4, "0", STR_PAD_LEFT);
            echo $this->Html->tableCells(
                [
                    $permiso["Permiso"]["id"],
                    $nroBoleta,
                    $permiso["Trabajador"]["nombre_completo"],
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

<!-- Modal -->
<div class="modal fade" id="mdlRegistrarRetorno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <?php
            echo $this->Form->create("Permiso", array("class" => "form-horizontal", "action" => "retorno"));
            $this->Form->inputDefaults(array("class" => "form-control", "div" => "col-sm-10", "label" => false));
        ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                <h4 class="modal-title">Registrar Hora de Retorno</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $this->Form->input("id", [
                        "type" => "hidden"
                    ]); ?>
                    <?= $this->Form->input("modo", [
                        "type" => "hidden",
                        "value" => "supervizar"
                    ]); ?>
                    <?= $this->Form->label("hora_min", "Hora de Salida",
                        ["class" => "col-sm-2 control-label"]
                    ); ?>
                    <?= $this->Form->input("hora_min", [
                        "type" => "text",
                        "readonly" => true,
                    ]); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->label("hora_retorno", "Hora de Retorno",
                        ["class" => "col-sm-2 control-label"]
                    ); ?>
                    <?= $this->Form->input("hora_retorno", [
                        "type" => "text",
                        "pattern" => "(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){1}",
                        "after" => "<p class='help-block'>Formato 00:00 - 23:59</p>",
                        "value" => date("H:i")
                    ]); ?>
                </div>
            </div>
            <div class="modal-footer">
                <?= $this->Form->button("Registrar", ["class" => "btn btn-primary"]); ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<?php echo $this->Html->scriptStart(["block" => "script"]); ?>
    $(document).ready(function() {
        $("span.e1").parent().addClass("e1");
        $("span.e2").parent().addClass("e2");
        $("span.e3").parent().addClass("e3");
        $("span.e4").parent().addClass("e4");
        $("a.a-modal").click(function() {
            var id = $(this).attr("data-id");
            var hora_min = $(this).attr("data-hora-min");
            $("#PermisoId").val(id);
            $("#PermisoHoraMin").val(hora_min);
        });
        
        $("#PermisoRetornoForm").submit(function() {
            var hora_ingresada = $("#PermisoHoraRetorno").val();
            var hora_min = $("#PermisoHoraMin").val();
            if(hora_ingresada <= hora_min) {
                alert("La hora de retorno debe ser mayor a la hora de salida");
                return false;
            }
            
            var hora_ingresada = $("#PermisoHoraRetorno").val();
            var hora_entrada = "<?= $hora_entrada["Config"]["valor"] ?>";
            var hora_salida = "<?= $hora_salida["Config"]["valor"] ?>";
            if(hora_ingresada < hora_entrada || hora_ingresada > hora_salida) {
                alert("La hora ingresada debe estar en el intervalo de " + hora_min + " a " + hora_salida);
                return false;
            }
        });
    });
<?php echo $this->Html->scriptEnd(); ?>
