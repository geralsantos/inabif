<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="<?php echo IMG ?>/icon/icon_page.png">
    <title><?php echo $this->getTitleHead() ?></title>
    <link rel="stylesheet" href="<?php echo CSS ?>/vue/iconfont/material-icons.css">
    <link rel="stylesheet" href="<?php echo CSS ?>/global.css">
    <!--link rel="stylesheet" href="<?php echo CSS ?>/materializecss.min.css"-->
    <link href="<?php echo CSS ?>/datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/css/kpi.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>/scss/style.css">
    <link href="<?php echo ASSETS ?>/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <?php echo $this->getReferencia(); ?>
    </head>
<body class="">
  <!-- Left Panel -->
<div class="" id="vue_app">

  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img style="max-width:200px;" src="<?php echo IMAGES ?>/logo.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="<?php echo IMAGES ?>/logo2.png" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#portada-index" @click="changeview('portada-index')"> <i class="menu-icon fa fa-dashboard"></i>Pantalla Principal </a>
                </li>
                <h3 class="menu-title">INABIF</h3><!-- /.menu-title -->
                <modulos :changeviewevent="changeview">

                </modulos>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
  </aside><!-- /#left-panel -->

  <!-- Left Panel -->

  <!-- Right Panel -->

  <div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header">

        <div class="header-menu">

            <div class="col-sm-7">
                <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                <div class="header-left">

                </div>
            </div>

            <div class="col-sm-5">
                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="user-avatar rounded-circle" src="<?php echo IMAGES ?>/admin.png" alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                            <a class="nav-link" @click="changeview('usuario_perfil')" href="#usuario_perfil"><i class="fa fa- user"></i>Mi Perfil</a>

                            <a class="nav-link" href="<?php $this->url("cerrar", "acceso"); ?>"><i class="fa fa-power -off"></i>Cerrar Sesión</a>
                    </div>
                </div>

                <div class="language-select dropdown" id="language-select">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                        <i class="fa-fa-user-circle"><?php echo $_SESSION["usuario"][0]["APELLIDO"]." ".$_SESSION["usuario"][0]["NOMBRE"]; ?> </i>
                    </a>

                </div>

            </div>
        </div>

    </header><!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-8">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>INABIF</h1>
                    <p><?php /*echo $_SESSION["usuario"][0]["nombre_sede"] */?></p>

                </div>
            </div>

        </div>

        <div class="col-sm-4">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
