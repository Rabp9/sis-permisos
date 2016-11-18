<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Lista de Motivos");
    $this->assign("title-icon", "fa fa-archive");
    
    $this->Html->addCrumb("<i class='fa fa-archive'></i> Motivos", '/Motivos', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-list'></i> Lista", "/Motivos/index", array("escape" => false));
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Nuevo Motivo", 
            "url" => ["controller" => "Motivos", "action" => "add"],
            "icono" => "fa fa-plus"]
    ]
]) ?>
<div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort("id", "Código") ?></th>
                <th><?= $this->Paginator->sort("descripcion", "Descripción") ?></th>
                <th><?= $this->Paginator->sort('descuento') ?></th>
                <th class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($motivos as $motivo) {
            echo $this->Html->tableCells(
                [
                    $motivo["Motivo"]["id"],
                    $motivo["Motivo"]["descripcion"],
                    $motivo["Motivo"]["descuento_view"],
                    $this->Html->link(__('Ver'), ['action' => 'view', $motivo["Motivo"]["id"]]) . " | " .
                    $this->Html->link(__('Editar'), ['action' => 'edit', $motivo["Motivo"]["id"]]) . " | " .
                    $this->Form->postLink("Deshabilitar",
                        array("controller" => "Motivos", "action" => "delete", $motivo["Motivo"]["id"]),
                        array("confirm" => "¿Estás seguro?", "escape" => false)
                    )
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