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
            <a class="navbar-brand" href="./"><img style="max-width:200px;" src="<?php echo IMAGES ?>/logo.jpg" alt="Logo"></a>
            <!--<a class="navbar-brand hidden" href="./"><img src="<?php echo IMAGES ?>/logo2.png" alt="Logo"></a>-->
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#portada-index" @click="changeview('portada-index')"> <i class="menu-icon fa fa-dashboard"></i>Pantalla Principal </a>
                </li>
             <!--     <h3 class="menu-title">INABIF</h3>/.menu-title -->

<style>
  .leve-0 {
    padding-left: 15px;
  }
  .level-1 {
    padding-left: 30px;
  }
  .level-2 {
    padding-left: 45px;
  }
  .level-3 {
    padding-left: 60px;
  }
  .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
        <?php
        $nivelusu = $_SESSION["usuario"][0]["NIVEL"];
        if ($nivelusu==ADMIN_CENTRAL) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">Rub</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <!-- si tiene reportes -->
            <h3 class="menu-title">PERFILES</h3>
            <a href="#registro-perfiles" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Usuario</a>
            <a href="#registro-locales" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Locales</a>
            <?php
        }else if ($nivelusu==SUPERVISOR) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">Rub</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <h3 class="menu-title">PERFILES</h3>

            <?php
        }else if ($nivelusu==USER_SEDE_GESTION) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">RUB</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <h3 class="menu-title">PERFILES</h3>
            <?php
            /* puede bloquear la matriz de un centro*/
        }else if ($nivelusu==USER_SEDE) {
            ?>
             <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">Rub</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <h3 class="menu-title">PERFILES</h3>
            <?php
        }else if ($nivelusu==RESPONSABLE_INFORMACION) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">Rub</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <h3 class="menu-title">PERFILES</h3>
            <?php
        }else if ($nivelusu==REGISTRADOR) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
           <modulos :changeviewevent="changeview"></modulos>
           <a href="#cargar-archivos" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Subir documentos al servidor</a>

            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <h3 class="menu-title">PERFILES</h3>
            <?php
        }else if ($nivelusu==USER_CENTRO) {
            ?>
            <h3 class="menu-title">REGISTRO</h3>
            <h3 class="menu-title">SEGUIMIENTO</h3>
            <a href="#seguimiento-lista-1" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matrices en los Centros</a>
            <h3 class="menu-title">REPORTES</h3>
            <a href="#reporte-matriz-general" class="list-group-item level-0" aria-expanded="true" id="Perfiles" style="width:100%;">Matriz General</a>
            <a href="#reporte-rub" class="list-group-item level-0" aria-expanded="true" id="reporterub" style="width:100%;">Rub</a>
            <a href="#reporte-nominal" class="list-group-item level-0" aria-expanded="true" id="reportenominal" style="width:100%;">Nominal</a>
            <h3 class="menu-title">PERFILES</h3>
            <?php
        }

        ?>

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
                        <span id="cabecera-centro-nombre">
                        <p><?php echo $_SESSION["usuario"][0]["NOM_CA"]." (".$_SESSION["usuario"][0]["TIPO_CENTRO_NOMBRE"].")"; ?></p>
                        </span>
                </div>
            </div>

        </div>

        <div class="col-sm-4">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Perfil: <?php $_SESSION["usuario"][0]["NIVEL"] ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
