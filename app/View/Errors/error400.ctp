<?php 
    $this->layout = "error";
    $this->extend("/Common/vista");
    $this->assign("title", "Error - Dirección no encontrada");
    $this->assign("title-icon", "fa fa-warning");
    
    $this->Html->addCrumb("<i class='fa fa-warning'></i> Error", '/Error', array("escape" => false));
?>
<fieldset>
    <legend><?= __('La dirección %s no existe.', "<strong>'{$url}'</strong>") ?></legend>

    <?php echo $this->element('exception_stack_trace'); ?>
</fieldset>