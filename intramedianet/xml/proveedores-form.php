<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

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

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_properties");
  $tblDelObj->setFieldName("xml_xml_propiedades");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

//start Trigger_DeleteDetail1 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail1(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_images");
  $tblDelObj->setFieldName("xml_img");
  $tblDelObj->addFile("{image_img}", "../../media/images/properties/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail1 trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("properties_property_feature");
  $tblDelObj->setFieldName("xml");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("site_xml", true, "text", "", "", "", "");
$formValidation->addField("xml_url_xml", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckDetail(&$tNG) {
  $tblFldObj = new tNG_CheckDetailRecord($tNG);
  $tblFldObj->setTable("properties_properties");
  $tblFldObj->setFieldName("xml_xml_prop");
  $tblFldObj->setErrorMsg(__('No se puede borrar, hay inmuebles que usan este registro', true));
  return $tblFldObj->Execute();
}
//end Trigger_CheckDetail trigger

// Make an insert transaction instance
$ins_xml = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_xml);
// Register triggers
$ins_xml->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_xml->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_xml->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_xml->setTable("xml");
$ins_xml->addColumn("site_xml", "STRING_TYPE", "POST", "site_xml");
$ins_xml->addColumn("xml_url_xml", "STRING_TYPE", "POST", "xml_url_xml");
$ins_xml->addColumn("ref_prefix_xml", "STRING_TYPE", "POST", "ref_prefix_xml");
$ins_xml->addColumn("tipo_xml", "NUMERIC_TYPE", "POST", "tipo_xml");
$ins_xml->addColumn("up_tipo_xml", "CHECKBOX_1_0_TYPE", "POST", "up_tipo_xml", "1");
$ins_xml->addColumn("up_operacion_xml", "CHECKBOX_1_0_TYPE", "POST", "up_operacion_xml", "1");
$ins_xml->addColumn("up_ciudad_xml", "CHECKBOX_1_0_TYPE", "POST", "up_ciudad_xml", "1");
$ins_xml->addColumn("up_m2_xml", "CHECKBOX_1_0_TYPE", "POST", "up_m2_xml", "1");
$ins_xml->addColumn("up_habitaciones_xml", "CHECKBOX_1_0_TYPE", "POST", "up_habitaciones_xml", "1");
$ins_xml->addColumn("up_aseos_xml", "CHECKBOX_1_0_TYPE", "POST", "up_aseos_xml", "1");
$ins_xml->addColumn("up_descripcion_xml", "CHECKBOX_1_0_TYPE", "POST", "up_descripcion_xml", "1");
$ins_xml->addColumn("up_precio_xml", "CHECKBOX_1_0_TYPE", "POST", "up_precio_xml", "1");
$ins_xml->addColumn("up_imagenes_xml", "CHECKBOX_1_0_TYPE", "POST", "up_imagenes_xml", "1");
$ins_xml->addColumn("up_caracteristicas_xml", "CHECKBOX_1_0_TYPE", "POST", "up_caracteristicas_xml", "1");
$ins_xml->addColumn("up_m2_t_xml", "CHECKBOX_1_0_TYPE", "POST", "up_m2_t_xml", "1");
$ins_xml->addColumn("up_pool_t_xml", "CHECKBOX_1_0_TYPE", "POST", "up_pool_t_xml", "1");
$ins_xml->addColumn("activate_xml", "CHECKBOX_1_0_TYPE", "POST", "activate_xml", "1");
$ins_xml->setPrimaryKey("id_xml", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_xml = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_xml);
// Register triggers
$upd_xml->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_xml->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_xml->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_xml->setTable("xml");
$upd_xml->addColumn("site_xml", "STRING_TYPE", "POST", "site_xml");
$upd_xml->addColumn("xml_url_xml", "STRING_TYPE", "POST", "xml_url_xml");
$upd_xml->addColumn("ref_prefix_xml", "STRING_TYPE", "POST", "ref_prefix_xml");
$upd_xml->addColumn("tipo_xml", "NUMERIC_TYPE", "POST", "tipo_xml");
$upd_xml->addColumn("up_tipo_xml", "CHECKBOX_1_0_TYPE", "POST", "up_tipo_xml");
$upd_xml->addColumn("up_operacion_xml", "CHECKBOX_1_0_TYPE", "POST", "up_operacion_xml");
$upd_xml->addColumn("up_ciudad_xml", "CHECKBOX_1_0_TYPE", "POST", "up_ciudad_xml");
$upd_xml->addColumn("up_m2_xml", "CHECKBOX_1_0_TYPE", "POST", "up_m2_xml");
$upd_xml->addColumn("up_habitaciones_xml", "CHECKBOX_1_0_TYPE", "POST", "up_habitaciones_xml");
$upd_xml->addColumn("up_aseos_xml", "CHECKBOX_1_0_TYPE", "POST", "up_aseos_xml");
$upd_xml->addColumn("up_descripcion_xml", "CHECKBOX_1_0_TYPE", "POST", "up_descripcion_xml");
$upd_xml->addColumn("up_precio_xml", "CHECKBOX_1_0_TYPE", "POST", "up_precio_xml");
$upd_xml->addColumn("up_imagenes_xml", "CHECKBOX_1_0_TYPE", "POST", "up_imagenes_xml");
$upd_xml->addColumn("up_caracteristicas_xml", "CHECKBOX_1_0_TYPE", "POST", "up_caracteristicas_xml");
$upd_xml->addColumn("up_m2_t_xml", "CHECKBOX_1_0_TYPE", "POST", "up_m2_t_xml");
$upd_xml->addColumn("up_pool_t_xml", "CHECKBOX_1_0_TYPE", "POST", "up_pool_t_xml");
$upd_xml->addColumn("activate_xml", "CHECKBOX_1_0_TYPE", "POST", "activate_xml");
$upd_xml->setPrimaryKey("id_xml", "NUMERIC_TYPE", "GET", "id_xml");



// Make an instance of the transaction object
$del_xml = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_xml);
// Register triggers
$del_xml->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_xml->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_xml->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$del_xml->registerTrigger("BEFORE", "Trigger_CheckDetail", 40);
// $del_xml->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
// $del_xml->registerTrigger("BEFORE", "Trigger_DeleteDetail1", 99);
// $del_xml->registerTrigger("BEFORE", "Trigger_DeleteDetail2", 99);
// Add columns
$del_xml->setTable("xml");
$del_xml->setPrimaryKey("id_xml", "NUMERIC_TYPE", "GET", "id_xml");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsxml = $tNGs->getRecordset("xml");
$row_rsxml = mysqli_fetch_assoc($rsxml);
$totalRows_rsxml = mysqli_num_rows($rsxml);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_xml" class="id_field" value="<?php if(isset($row_rsxml['kt_pk_xml'])) echo KT_escapeAttribute($row_rsxml['kt_pk_xml']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-file-code"></i> <?php if (@$_GET['id_xml'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Proveedor'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_xml'] == "") { ?>
                                <button type="submit" name="KT_Insert1" id="KT_Insert1" class="btn btn-success btn-sm" value="<?php echo NXT_getResource("Insert_FB"); ?>"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Insert_FB"); ?></span></button>
                            <?php } else { ?>
                                <button type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                                <button type="submit" name="KT_Delete1" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" class="delrow2 btn btn-danger btn-sm"><i class="fa-regular fa-trash-can fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Delete_FB"); ?></span></button>
                            <?php } ?>
                            <button type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="window.location='../../includes/nxt/back.php'" class="btn btn-soft-primary btn-sm"><i class="fa-regular fa-chevron-left fa-fw me-1"></i><span class="d-none d-lg-inline-block"> <?php echo NXT_getResource("Cancel_FB"); ?></span></button>
                        </div>
                    </div>
                </div>

                <?php echo $tNGs->getErrorMsg(); ?>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Proveedor'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-ld-12">

                                        <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                            <input type="checkbox" name="activate_xml" id="activate_xml" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsxml['activate_xml']),"1"))) {echo "checked";} ?>>
                                            <label class="form-check-label" for="activate_xml"><?php __('Activar la cuenta'); ?></label>
                                            <?php echo $tNGs->displayFieldError("news", "activate_xml"); ?>
                                        </div>

                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                  <div class="col-lg-4">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("xml", "site_xml") != '') { ?>has-error<?php } ?>">
                                          <label for="site_xml" class="form-label"><?php __('Proveedor'); ?>:</label>
                                          <input type="text" name="site_xml" id="site_xml" value="<?php echo KT_escapeAttribute($row_rsxml['site_xml']); ?>" size="32" maxlength="255" class="form-control required" required>
                                          <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                          <?php echo $tNGs->displayFieldError("xml", "site_xml"); ?>
                                      </div>

                                  </div>
                                  <div class="col-lg-4">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("xml", "ref_prefix_xml") != '') { ?>has-error<?php } ?>">
                                          <label for="ref_prefix_xml" class="form-label"><?php __('Prefijo'); ?>:</label>
                                          <input type="text" name="ref_prefix_xml" id="ref_prefix_xml" value="<?php echo KT_escapeAttribute($row_rsxml['ref_prefix_xml']); ?>" size="32" maxlength="255" class="form-control">
                                          <?php echo $tNGs->displayFieldError("xml", "ref_prefix_xml"); ?>
                                      </div>

                                  </div>
                                  <div class="col-lg-4">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("xml", "tipo_xml") != '') { ?>has-error<?php } ?>">
                                          <label for="tipo_xml" class="form-label"><?php __('Tipo de XML'); ?>:</label>
                                          <select name="tipo_xml" id="tipo_xml" class="form-select">
                                              <option value="1" <?php if (!(strcmp(1, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>Kyero</option>
                                              <option value="2" <?php if (!(strcmp(2, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>XML-Mediaelx</option>
                                              <option value="3" <?php if (!(strcmp(3, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>Inmovilla</option>
                                              <option value="5" <?php if (!(strcmp(5, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>Resales-online</option>
                                              <option value="6" <?php if (!(strcmp(6, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>REDSP</option>
                                              <option value="7" <?php if (!(strcmp(7, $row_rsxml['tipo_xml']))) {echo "SELECTED";} ?>>Habihub</option>
                                          </select>
                                          <?php echo $tNGs->displayFieldError("xml", "tipo_xml"); ?>
                                      </div>

                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-ld-12">

                                      <div class="mb-4 <?php if($tNGs->displayFieldError("xml", "xml_url_xml") != '') { ?>has-error<?php } ?>">
                                          <label for="xml_url_xml" class="form-label"><?php __('URL'); ?>:</label>
                                          <input type="url" name="xml_url_xml" id="xml_url_xml" value="<?php echo KT_escapeAttribute($row_rsxml['xml_url_xml']); ?>" size="32" maxlength="255" class="form-control required url" required>
                                          <div class="invalid-feedback">
                                              <?php __('Este campo es obligatorio.'); ?>
                                          </div>
                                          <?php echo $tNGs->displayFieldError("xml", "xml_url_xml"); ?>
                                      </div>

                                  </div>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card position-relative">
                            <div class="card-header align-items-center d-flex">
                                <div class="flex-grow-1 oveflow-hidden">
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Al Actualizar los inmuebles actulizar los siguientes campos'); ?></h4>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php
                                $campos = array("up_descripcion_xml", "up_precio_xml", "up_tipo_xml", "up_operacion_xml", "up_ciudad_xml", "up_m2_xml", "up_m2_t_xml", "up_habitaciones_xml", "up_aseos_xml", "up_imagenes_xml", "up_pool_t_xml", "up_caracteristicas_xml");
                                $textos = array(__('Descripciones', true), __('Precio', true), __('Tipos', true), __('Operación', true), __('Ciudades', true), __('M2', true), __('M2 Parcela', true), __('Habitaciones', true), __('Aseos', true), __('Imágenes', true), __('Piscina', true), __('Características', true));
                                ?>

                                <div class="row">

                                <?php
                                $i =0;
                                foreach ($campos as $value) {
                                ?>
                                <div class="col-lg-3">

                                    <div class="form-check form-switch form-switch-lg pt-2 mb-4" dir="ltr">
                                        <input type="checkbox" name="<?php echo $value ?>" id="<?php echo $value ?>" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsxml[$value]),"1"))) {echo "checked";} ?>>
                                        <label class="form-check-label" for="<?php echo $value ?>"><?php echo $textos[$i++]; ?></label>
                                        <?php echo $tNGs->displayFieldError("news", "activate_xml"); ?>
                                    </div>

                                </div>
                                <?php echo @$i%4==0 ? "</div><div class=\"row\">" : ""; ?>
                                <?php
                                }
                                ?>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>
