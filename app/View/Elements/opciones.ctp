<?php 
    if(!empty($opciones)) {
        if(sizeof($opciones) == 1) {
            $opcion = $opciones[0];
                if(isset($opcion["tipo"]) && $opcion["tipo"] == "modal") {
                    $atributos = "";
                    foreach($opcion["metadatos"] as $k_metadato => $metadato) {
                        $atributos .= $k_metadato . "='" . $metadato . "'";
                    }
                    echo "<a class='a-modal btn btn-primary' href='#' " . $atributos . "><span class='" . $opcion["icono"] . "'></span> " . $opcion["titulo"] . "</a>";
                } else {
?>
<a class="btn btn-primary" href="<?= $this->Html->url($opcion["url"]) ?>" target="<?= @$opcion["target"] ?>">
    <span class="<?= $opcion["icono"] ?>"></span> <?= $opcion["titulo"] ?>
</a>
<?php
                }
        } else {
?>
<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button"><span class="fa fa-list"></span> Opciones <span class="caret"></span> </button>
    <ul class="dropdown-menu">
<?php foreach($opciones as $opcion) { ?>
        <li>
            <?php
                if(isset($opcion["tipo"])) {
                    if($opcion["tipo"] == "postlink") 
                        echo $this->Form->postLink("<span class='" . $opcion["icono"] . "'></span> " . $opcion["titulo"],
                            $opcion["url"],
                            array("confirm" => "¿Estás seguro?", "escape" => false)
                        );
                    elseif($opcion["tipo"] == "modal") {
                        $atributos = "";
                        foreach($opcion["metadatos"] as $k_metadato => $metadato) {
                            $atributos .= $k_metadato . "='" . $metadato . "'";
                        }
                        echo "<a class='a-modal' href='#' " . $atributos . "><span class='" . $opcion["icono"] . "'></span> " . $opcion["titulo"] . "</a>";
                    }   
                } else {
                    echo $this->Html->link("<span class='" . $opcion["icono"] . "'></span> " . $opcion["titulo"], $opcion["url"], array("escape" => false, "target" => @$opcion["target"]));
                }
            ?>
        </li>
<?php } ?>
    </ul>
</div>
<?php
        }
    } 
?>