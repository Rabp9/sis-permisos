<?php
    $this->extend("/Common/vista");
    $this->assign("title", "Lista de Trabajadores");
    $this->assign("title-icon", "fa fa-user");
    
    $this->Html->addCrumb("<i class='fa fa-user'></i> Trabajadores", '/Trabajadores', array("escape" => false));
    $this->Html->addCrumb("<i class='fa fa-list'></i> Lista", "/Trabajadores/index", array("escape" => false));
?>
<div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort("id", "Código") ?></th>
                <th><?= $this->Paginator->sort("Per_ApePaterno", "Nombre Completo") ?></th>
                <th>Unidad Orgánica</th>
                <th class="actions"><?= __('Acciones') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($trabajadores as $trabajador) {
            echo $this->Html->tableCells(
                [
                    $trabajador["Trabajador"]["Per_DNI"],
                    $trabajador["Trabajador"]["nombre_completo"],
                    $trabajador["Historico_Cargo"]["Area"]["Are_Descripcion"],
                    $this->Html->link(__('Ver'), ['action' => 'view', $trabajador["Trabajador"]["Per_DNI"]]) . " | " .
                    $this->Html->link(__('Editar'), ['action' => 'edit', $trabajador["Trabajador"]["Per_DNI"]])
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