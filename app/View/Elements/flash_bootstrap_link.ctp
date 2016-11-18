<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php
        echo h($message) . " "; 
        echo $this->Html->link($link_text, $link_url, array("escape" => false));
    ?>
</div>