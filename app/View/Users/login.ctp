<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login | SISTEMA DE PERMISOS</title>

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
</head>

  <body class="login-img3-body">

    <div class="container">
<?php echo $this->Form->create('User', array("action" => "login", "class" => "login-form")); ?>
    <div class="login-wrap">
	<h2 style="text-align: center">SISTEMA DE PERMISOS</h2>
        <p class="login-img"><?= $this->Html->image("logo.jpg") ?></p>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_profile"></i></span>
            <?= $this->Form->input('Usu_Login', array(
                "label" => false,
                "div" => false,
                "autofocus" => true,
                "class" => "form-control",
                "placeholder" => "Nombre de Usuario"
            )); ?>
        </div>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
            <?= $this->Form->input('Usu_Password', array(
                "label" => false,
                "div" => false,
                "type" => "password",
                "class" => "form-control",
                "placeholder" => "Nombre de Usuario"
            )); ?>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
        <?= $this->Session->flash(); ?>
    </div>
<?php echo $this->Form->end(); ?>
    </div>
  </body>
</html>