<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Lista de Grupos");
?>
<?= $this->element("opciones", [
    "opciones" => [
        ["titulo" => "Nuevo Grupo", 
            "url" => ["controller" => "Groups", "action" => "add"],
            "icono" => "fa fa-plus"]
    ]
]) ?>
<div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort("id", "Código") ?></th>
                <th><?= $this->Paginator->sort("descripcion", "Descripción") ?></th>
                <th class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($groups as $group) {
            echo $this->Html->tableCells(
                [
                    $group["Group"]["id"],
                    $group["Group"]["descripcion"],
                    $this->Html->link(__('Ver'), ['action' => 'view', $group["Group"]["id"]]) . " | " .
                    $this->Html->link(__('Editar'), ['action' => 'edit', $group["Group"]["id"]]) . " | " .
                    $this->Form->postLink("Deshabilitar",
                        array("controller" => "Groups", "action" => "delete", $group["Group"]["id"]),
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