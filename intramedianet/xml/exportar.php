<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex card-header-fix">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-export"></i> <?php echo __('Exportar XML'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="exportar-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="display table table-bordered align-middle" id="records-tables" width="100%">
                            <thead class="table-light">
                                <tr>
                                    <th><?php __('Nombre'); ?></th>
                                    <th><?php __('URL'); ?></th>
                                    <th id="actions"></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="<?php echo 'feature_en_feat'; ?>" id="<?php echo 'feature_en_feat'; ?>" class="form-control form-control-sm"></td>
                                    <th><input type="text" name="uid_exp" id="uid_exp" class="form-control form-control-sm"></td>
                                    <th class="actions"><a href="javascript:void(0);" class="btn btn-primary btn-sm btn-block search-clear"> <?php __('Limpiar'); ?> </a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="dataTables_empty"><?php __('Cargando datos del servidor'); ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="card mt-4  bg-light p-3">
                            
                            <p class="mb-1">
                                <small><i class="fa-regular fa-asterisk text-danger fa-fw"></i><?php __('Disclaimer XML mediaelx Export'); ?></small>
                            </p>
                            <p class="mb-0 ps-lg-3"> 
                                <small><?php __('Disclaimer XML mediaelx Export 2'); ?></small> 
                            </p>
            
                        </div>

                        <div class="card">
                            <?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1 || $expYaencontre == 1 || $expMimove == 1 || $expAPITS == 1 || $expCostadelHome == 1 || $expSpainHouses == 1 || $expMediaelx == 1): ?>
                                <div class="card-header align-items-center d-flex card-header-fix bg-primary mt-4">
                                    <h4 class="card-title mb-0 flex-grow-1 text-white"><?php echo __('XLMs de exportación a portales'); ?></h4>
                                </div>
                                <div class="card-body bg-light">
                            <?php endif ?>
                            <?php if ($expMediaelx == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/mediaelx.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/mediaelx.php</a></p>
                            <?php endif ?>
                            <?php if ($expFacilisimo == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/facilisimo.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/facilisimo.php</a></p>
                            <?php endif ?>
                            <?php if ($expPrian == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/prian.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/prian.php</a></p>
                            <?php endif ?>
                            <?php if ($expPisos == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/pisos.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/pisos.php</a></p>
                            <?php endif ?>
                            <?php if ($expGreenAcres == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/greenacres.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/greenacres.php</a></p>
                            <?php endif ?>
                            <?php if ($expThinkSpain == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/thinkspain.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/thinkspain.php</a></p>
                            <?php endif ?>
                            <?php if ($expHabitaclia == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/habitaclia.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/habitaclia.php</a></p>
                            <?php endif ?>
                            <?php if ($expHemnet == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/hemnet.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/hemnet.php</a></p>
                            <?php endif ?>
                            <?php if ($expTodoPisoAlicante == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/todopisoalicante.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/todopisoalicante.php</a></p>
                            <?php endif ?>
                            <?php if ($expYaencontre == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/yaencontre.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/yaencontre.php</a></p>
                            <?php endif ?>
                            <?php if ($expMimove == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/mimove.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/mimove.php</a></p>
                            <?php endif ?>
                            <?php if ($expAPITS == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/sun.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/sun.php</a></p>
                            <?php endif ?>
                            <?php if ($expCostadelHome == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/costadelhome.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/costadelhome.php</a></p>
                            <?php endif ?>
                            <?php if ($expSpainHouses == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/spainhome.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/spainhome.php</a></p>
                            <?php endif ?>
                            <?php if ($expInmoco == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/inmoco.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/inmoco.php</a></p>
                            <?php endif ?>
                            <?php if ($expFacebook == 1): ?>
                                <?php foreach ($languages as $language): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/facebook.php?lang=<?php echo $language ?>" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/facebook.php?lang=<?php echo $language ?></a></p>
                                <?php endforeach ?>
                            <?php endif ?>
                            <?php if ($expMLSMediaelx == 1): ?>
                                <p><a href="https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/kyero_mls.php" target="_blank" class="btn btn-soft-primary btn-sm">https://<?php echo $_SERVER['HTTP_HOST'] ?>/xml/kyero_mls.php</a></p>
                            <?php endif ?>
                            <?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1 || $expYaencontre == 1 || $expMimove == 1 || $expAPITS == 1 || $expCostadelHome == 1 || $expSpainHouses == 1 || $expMediaelx == 1): ?>
                                </div>
                            <?php endif ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var httpHost = '<?php echo $_SERVER['HTTP_HOST'] ?>';
    </script>

    <script src="_js/export-list.js?id=<?php echo time(); ?>" type="text/javascript"></script>

</body>
</html>
