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

if (!isset($_GET['id_cnt'])) {

 
  $query_rsNextIncrement = "SHOW TABLE STATUS LIKE 'contactos_files'";
  $rsNextIncrement = mysqli_query($inmoconn,$query_rsNextIncrement) or die(mysqli_error());
  $row_rsNextIncrement = mysqli_fetch_assoc($rsNextIncrement);

  $ownerId = $row_rsNextIncrement['Auto_increment'];

} else {

  $ownerId = $_GET['id_cnt'];

}

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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_cnt", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger



//start Trigger_Redirect trigger
//remove this line if you want to edit the code by hand
function Trigger_Redirect(&$tNG) {
  $redObj = new tNG_Redirect($tNG);
  $redObj->setURL("owners-form.php?id_cnt=".$tNG->getPrimaryKeyValue()."&u=ok");
  $redObj->setKeepURLParams(false);
  return $redObj->Execute();
}
//end Trigger_Redirect trigger

//start Trigger_DeleteDetail2 trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail2(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("contactos_files");
  $tblDelObj->setFieldName("owner_fil");
  $tblDelObj->addFile("{file_fil}", "../../media/files/owners/");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail2 trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  global $lang;
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("contactos");
  $tblFldObj->addFieldName("email_cnt");
  $tblFldObj->setErrorMsg($lang['Registro duplicado'] . ": {email_cnt}");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

//start Trigger_AddToNewsletter trigger
//remove this line if you want to edit the code by hand
function Trigger_AddToNewsletter(&$tNG) {

  global $database_inmoconn, $inmoconn, $lang_adm;

  if ($tNG->getColumnValue('email_cnt') != '') {
    
    $query_rsInsert = "
            INSERT INTO newsletter_users (id_usr, nombre_usr, email_usr, lang_usr, date_usr)
            VALUES (NULL, '" . $tNG->getColumnValue('nombre_cnt') . ' ' . $tNG->getColumnValue('apellidos_cnt') . "','" . $tNG->getColumnValue('email_cnt') . "', '".$lang_adm."', '" . date("Y-m-d H:i:s") . "')
    ";

    if (mysqli_query($inmoconn, $query_rsInsert)) {
      
      $query_rsInsert2 = "
      INSERT INTO  `newsletter_usr_cat` ( `id` , `usr`, `cat` ) VALUES
      ( NULL ,  '".mysqli_insert_id($inmoconn)."',  '4' )
      ";
      mysqli_query($inmoconn,$query_rsInsert2);
    }

  }
}
//end Trigger_AddToNewsletter trigger

// Make an insert transaction instance
$ins_contactos = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_contactos);
// Register triggers
$ins_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert2");
$ins_contactos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_contactos->setTable("contactos");
$ins_contactos->addColumn("nombre_cnt", "STRING_TYPE", "POST", "nombre_cnt");
$ins_contactos->addColumn("apellidos_cnt", "STRING_TYPE", "POST", "apellidos_cnt");
$ins_contactos->addColumn("cif_cnt", "STRING_TYPE", "POST", "cif_cnt");
$ins_contactos->addColumn("email1_cnt", "STRING_TYPE", "POST", "email1_cnt");
$ins_contactos->addColumn("email2_cnt", "STRING_TYPE", "POST", "email2_cnt");
$ins_contactos->addColumn("email3_cnt", "STRING_TYPE", "POST", "email3_cnt");
$ins_contactos->addColumn("direccion_cnt", "STRING_TYPE", "POST", "direccion_cnt");
$ins_contactos->addColumn("referencia_cnt", "STRING_TYPE", "POST", "referencia_cnt");
$ins_contactos->addColumn("telefono1_cnt", "STRING_TYPE", "POST", "telefono1_cnt");
$ins_contactos->addColumn("telefono2_cnt", "STRING_TYPE", "POST", "telefono2_cnt");
$ins_contactos->addColumn("telefono3_cnt", "STRING_TYPE", "POST", "telefono3_cnt");
$ins_contactos->addColumn("web_cnt", "STRING_TYPE", "POST", "web_cnt");
$ins_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contactos = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_contactos);
// Register triggers
$upd_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update2");
$upd_contactos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_contactos->setTable("contactos");
$upd_contactos->addColumn("nombre_cnt", "STRING_TYPE", "POST", "nombre_cnt");
$upd_contactos->addColumn("apellidos_cnt", "STRING_TYPE", "POST", "apellidos_cnt");
$upd_contactos->addColumn("cif_cnt", "STRING_TYPE", "POST", "cif_cnt");
$upd_contactos->addColumn("email1_cnt", "STRING_TYPE", "POST", "email1_cnt");
$upd_contactos->addColumn("email2_cnt", "STRING_TYPE", "POST", "email2_cnt");
$upd_contactos->addColumn("email3_cnt", "STRING_TYPE", "POST", "email3_cnt");
$upd_contactos->addColumn("direccion_cnt", "STRING_TYPE", "POST", "direccion_cnt");
$upd_contactos->addColumn("referencia_cnt", "STRING_TYPE", "POST", "referencia_cnt");
$upd_contactos->addColumn("telefono1_cnt", "STRING_TYPE", "POST", "telefono1_cnt");
$upd_contactos->addColumn("telefono2_cnt", "STRING_TYPE", "POST", "telefono2_cnt");
$upd_contactos->addColumn("telefono3_cnt", "STRING_TYPE", "POST", "telefono3_cnt");
$upd_contactos->addColumn("web_cnt", "STRING_TYPE", "POST", "web_cnt");
$upd_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE", "GET", "id_cnt");

// Make an instance of the transaction object
$del_contactos = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_contactos);
// Register triggers
$del_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contactos->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_contactos->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_contactos->setTable("contactos");
$del_contactos->setPrimaryKey("id_cnt", "NUMERIC_TYPE", "GET", "id_cnt");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontactos = $tNGs->getRecordset("contactos");
$row_rscontactos = mysqli_fetch_assoc($rscontactos);
$totalRows_rscontactos = mysqli_num_rows($rscontactos);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-id-card-clip"></i> <?php if (@$_GET['id_cnt'] == "") { ?><?php echo NXT_getResource("Insert_FH"); ?><?php } else { ?><?php echo NXT_getResource("Update_FH"); ?><?php } ?> <?php echo __('Contact'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_cnt'] == "") { ?>
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
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "nombre_cnt") != '') { ?>error<?php } ?>">
                                            <label for="nombre_cnt" class="form-label"><?php __('Nombre'); ?>:</label>
                                            <input type="text" name="nombre_cnt" id="nombre_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['nombre_cnt']); ?>" size="32" maxlength="255" class="form-control required" required>
                                            <div class="invalid-feedback">
                                                <?php __('Este campo es obligatorio.'); ?>
                                            </div>
                                            <?php echo $tNGs->displayFieldError("contactos", "nombre_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "apellidos_cnt") != '') { ?>error<?php } ?>">
                                            <label for="apellidos_cnt" class="form-label"><?php __('Apellidos'); ?>:</label>
                                            <input type="text" name="apellidos_cnt" id="apellidos_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['apellidos_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "apellidos_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "cif_cnt") != '') { ?>error<?php } ?>">
                                            <label for="cif_cnt" class="form-label"><?php __('CIF'); ?>:</label>
                                            <input type="text" name="cif_cnt" id="cif_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['cif_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "cif_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "telefono1_cnt") != '') { ?>error<?php } ?>">
                                            <label for="telefono1_cnt" class="form-label"><?php __('Teléfono'); ?>:</label>
                                            <input type="tel" name="telefono1_cnt" id="telefono1_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['telefono1_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "telefono1_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "telefono2_cnt") != '') { ?>error<?php } ?>">
                                            <label for="telefono2_cnt" class="form-label"><?php __('Móvil'); ?>:</label>
                                            <input type="tel" name="telefono2_cnt" id="telefono2_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['telefono2_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "telefono2_cnt"); ?>
                                        </div>

                                        <div class="form-group <?php if($tNGs->displayFieldError("contactos", "telefono3_cnt") != '') { ?>error<?php } ?>">
                                            <label for="telefono3_cnt" class="form-label"><?php __('Teléfono'); ?> 3:</label>
                                            <input type="tel" name="telefono3_cnt" id="telefono3_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['telefono3_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "telefono3_cnt"); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "email1_cnt") != '') { ?>error<?php } ?>">
                                          <label for="email1_cnt" class="form-label"><?php __('Email'); ?>:</label>
                                              <input type="email" name="email1_cnt" id="email1_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['email1_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("contactos", "email1_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "email2_cnt") != '') { ?>error<?php } ?>">
                                          <label for="email2_cnt" class="form-label"><?php __('Email'); ?> 2:</label>
                                              <input type="email" name="email2_cnt" id="email2_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['email2_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("contactos", "email2_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "email3_cnt") != '') { ?>error<?php } ?>">
                                          <label for="email3_cnt" class="form-label"><?php __('Email'); ?> 3:</label>
                                              <input type="email" name="email3_cnt" id="email3_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['email3_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("contactos", "email3_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "referencia_cnt") != '') { ?>error<?php } ?>">
                                            <label for="referencia_cnt" class="form-label"><?php __('Referencia'); ?> <?php __('Empresa'); ?>:</label>
                                            <input type="text" name="referencia_cnt" id="referencia_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['referencia_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                            <?php echo $tNGs->displayFieldError("contactos", "referencia_cnt"); ?>
                                        </div>

                                        <div class="mb-4 <?php if($tNGs->displayFieldError("contactos", "direccion_cnt") != '') { ?>error<?php } ?>">
                                          <label for="direccion_cnt" class="form-label"><?php __('Dirección'); ?>:</label>
                                              <input type="text" name="direccion_cnt" id="direccion_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['direccion_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("contactos", "direccion_cnt"); ?>
                                        </div>

                                        <div class="form-group <?php if($tNGs->displayFieldError("contactos", "web_cnt") != '') { ?>error<?php } ?>">
                                          <label for="web_cnt" class="form-label"><?php __('Web'); ?>:</label>
                                              <input type="text" name="web_cnt" id="web_cnt" value="<?php echo KT_escapeAttribute($row_rscontactos['web_cnt']); ?>" size="32" maxlength="255" class="form-control">
                                              <?php echo $tNGs->displayFieldError("contactos", "web_cnt"); ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="kt_pk_contactos" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontactos['kt_pk_contactos']); ?>" />

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script>
    var idOwner = '<?php echo $ownerId; ?>';
    var oTable;
    var selected =  new Array();
    </script>

    <script src="_js/owners-form.js" type="text/javascript"></script>



<div id="myModal2" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4><?php __('Editar nombres'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="loadingfrm"></div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" data-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
      </div>
    </div>
  </div>
</div>

<div id="myModal5" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4><?php __('Añadir Estatus'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="category_en_sts"><?php __('Estatus'); ?>:</label>
            <div class="input-group">
              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/en.png" alt=""></span>
              <input type="text" name="category_en_sts" id="category_en_sts" value="" size="32" maxlength="255" class="form-control required">
            </div>
        </div>
        <div class="form-group">
            <label for="category_es_sts"><?php __('Estatus'); ?>:</label>
            <div class="input-group">
              <span class="input-group-addon"><img src="../includes/assets/img/flags-langs/es.png" alt=""></span>
              <input type="text" name="category_es_sts" id="category_es_sts" value="" size="32" maxlength="255" class="form-control required">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success" data-dismiss="modal"><?php __('Cerrar y guardar'); ?></a>
      </div>
    </div>
  </div>
</div>





</body>
</html>
