<?php

ini_set('display_errors', 0);
 error_reporting(E_ALL);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Load the KT_back class
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php' );

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page


$mensaHTML = '';
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/swift/lib/swift_required.php');

if (isset($_POST['email']) && $_POST['email'] != '') {

  $mensaHTML .= "<p>Fecha: " . date("d-m-Y H:i") . "</p>";
  $mensaHTML .= "<p>Nombre: " . $_POST['nombre'] . "</p>";
  $mensaHTML .= "<p>Email: " . $_POST['email'] . "</p>";
  $mensaHTML .= "<p>Comentario:\n" . "</p>";
  $mensaHTML .= "<p>" . nl2br($_POST['comentario']) . "</p>";

  $subject = "Nueva solicitud de asistencia desde" . ' ' . $_SERVER['HTTP_HOST'];

  if (sendAppEmail($asistenciaMail, '', '', '', $subject, $mensaHTML)) {

    header("Location: index.php?s=ok");

  } else {

    header("Location: index.php?s=no");

  }

}

 ?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-comments-question-check"></i> <?php echo __('Solicitud asistencia'); ?></h4>
                    </div>
                    <div class="card-body">

                        <?php if(@$_GET['s'] == 'ok') { ?>
                        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="fa-regular fa-check label-icon"></i> <?php __('La solicitud se ha enviado correctamente'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <?php if(@$_GET['s'] == 'no') { ?>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="fa-regular fa-close label-icon"></i> <?php __('La solicitud no se ha enviado, por favor intentelo de nuevo'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <div class="mb-4">
                          <div class="controls">
                              <label for="nombre_cli" class="form-label"><?php __('Nombre'); ?>:</label>
                              <input type="text" name="nombre" id="nombre" value="" size="32" maxlength="255" class="form-control required" required>
                              <div class="invalid-feedback">
                                  <?php __('Este campo es obligatorio.'); ?>
                              </div>
                          </div>
                        </div>

                        <div class="mb-4">
                          <div class="controls">
                              <label for="email" class="form-label"><?php __('Email'); ?>:</label>
                              <input type="email" name="email" id="email" value="" size="32" maxlength="255" class="form-control required email" required>
                              <div class="invalid-feedback">
                                  <?php __('Este campo es obligatorio.'); ?>
                              </div>
                          </div>
                        </div>

                        <div class="mb-4">
                          <div class="controls">
                              <label for="comentario" class="form-label"><?php __('Comentario'); ?>:</label>
                              <textarea name="comentario" id="comentario" cols="30" rows="10" class="form-control required" required></textarea>
                              <div class="invalid-feedback">
                                  <?php __('Este campo es obligatorio.'); ?>
                              </div>
                          </div>

                        </div>

                        <div class="form-group">
                          <div class="controls">
                            <button type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-success me-2"><i class="fa-regular fa-paper-plane"></i> <?php __('Enviar'); ?></button>
                          </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>

    <?php /* ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-comments"></i> <span><?php __('Solicitud asistencia'); ?></span></h1>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Solicitud asistencia'); ?></h3>
                </div>

                <div class="panel-body">

                    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="validate">

                    <?php if($_GET['s'] == 'ok') { ?>
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php __('La solicitud se ha enviado correctamente'); ?>.
                        </div>
                    <?php } ?>

                    <?php if($_GET['s'] == 'no') { ?>
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php __('La solicitud no se ha enviado, por favor intentelo de nuevo'); ?>.
                        </div>
                    <?php } ?>

                        <div class="form-group">
                          <label for="nombre_cli"><?php __('Nombre'); ?>:</label>
                          <div class="controls">
                              <input type="text" name="nombre" id="nombre" value="" size="32" maxlength="255" class="form-control required">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="email"><?php __('Email'); ?>:</label>
                          <div class="controls">
                              <input type="text" name="email" id="email" value="" size="32" maxlength="255" class="form-control required email">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="comentario"><?php __('Comentario'); ?>:</label>
                          <div class="controls">
                          <textarea name="comentario" id="comentario" cols="30" rows="10" class="form-control required"></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="controls">
                              <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php __('Enviar'); ?>" class="btn btn-success" />
                          </div>
                        </div>

                        </form>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php */ ?>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
