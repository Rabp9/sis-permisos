<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->fetch('meta') ?>
    <!-- <link rel="shortcut icon" href="img/favicon.png"> -->
    
    <title><?= $this->fetch('title') ?> | SISTEMA DE PERMISOS</title>

    <!-- Bootstrap CSS -->    
    <?= $this->Html->css("bootstrap.min.css") ?>
    <!-- bootstrap theme -->
    <?= $this->Html->css("bootstrap-theme.css") ?>
    <!--external css-->
    <!-- font icon -->
    <?= $this->Html->css("elegant-icons-style.css") ?>
    <?= $this->Html->css("font-awesome.min.css") ?>
    <!-- Custom styles -->
    <?= $this->Html->css("style.css") ?>
    <?= $this->Html->css("core.css") ?>
    <?= $this->Html->css("style-responsive.css") ?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
        <?= $this->Html->script("html5shiv"); ?>
        <?= $this->Html->script("respond.min"); ?>
        <?= $this->Html->script("lte-ie7"); ?>
    <![endif]-->
    <?= $this->Html->meta(
            'icon-permisos.ico',
            '/img/icons/icon-permisos.ico',
            array('type' => 'icon')
    ); ?>
    <?= $this->fetch('css') ?>
    
</head>
<body>
    <!-- container section start -->
    <section id="container" class="">
        <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom">
                    <i class="icon_menu icon-inverted"></i>
                </div>
            </div>

            <!--logo start-->
            <a href="<?= $this->Html->url(array("controller" => "Pages", "action" => "home")) ?>" class="logo"><?= $this->Html->image("logo.jpg") ?> <span class="lite"><b>Sistema de Permisos</b></span></a>
            <!--logo end-->

            <?= $this->element("notificaciones"); ?>
        </header>      
        <!--header end-->

        <!--sidebar start-->
        <?= $this->element("sidebar"); ?>
        <!--sidebar end-->
      
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="<?= $this->fetch('title-icon') ?>"></i> <?= $this->fetch('title') ?></h3>
                        <?= $this->Session->flash("auth", array("element" => "flash_bootstrap")); ?>
                        <?= $this->Session->flash(); ?>
                        <div id="breadcrumbs">
                            <?php echo $this->Html->getCrumbList(
                                array(
                                    "class" => "breadcrumbs breadcrumb",
                                    "firstClass" => false,
                                    "lastClass" => "active",
                                    "escape" => false
                                ),
                                array(
                                    "text" => "<i class='fa fa-home'></i> Home",
                                    "url" => array("controller" => "Pages", "action" => "home")
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
                
                <?= $this->fetch('content') ?>
               
                <!-- project team & activity end -->
            </section>
        </section>
        <!--main content end-->
    </section>
    
    
     <!-- javascripts -->
    <?= $this->Html->script("jquery"); ?>
    <?= $this->Html->script("bootstrap.min"); ?>
    <!-- nice scroll -->
    <?= $this->Html->script("jquery.scrollTo.min"); ?>
    <?= $this->Html->script("jquery.nicescroll"); ?>

    <!-- jquery ui -->
    <?= $this->Html->script("jquery-ui-1.9.2.custom.min"); ?>

    <!--custom checkbox & radio-->
    <?= $this->Html->script("ga"); ?>
    <!--custom switch-->
    <?= $this->Html->script("bootstrap-switch"); ?>
    <!--custom tagsinput-->
    <?= $this->Html->script("jquery.tagsinput"); ?>
    
    <!-- colorpicker -->
   
    <!-- bootstrap-wysiwyg -->
    <?= $this->Html->script("jquery.hotkeys"); ?>
    <?= $this->Html->script("bootstrap-wysiwyg"); ?>
    <?= $this->Html->script("bootstrap-wysiwyg-custom"); ?>
    <!-- ck editor -->
    <?= $this->Html->script("/assets/ckeditor/ckeditor"); ?>
    <!-- custom form component script for this page-->
    <?= $this->Html->script("form-component"); ?>
    <!-- custome script for all page -->
    <?= $this->Html->script("scripts"); ?>
    <?= $this->Html->script("default"); ?>

    <?php
        if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
        // Writes cached scripts
    ?>
    <?= $this->fetch('script') ?>
</body>
</html>
