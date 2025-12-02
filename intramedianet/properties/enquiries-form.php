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


$query_rsClientes = "
SELECT properties_client.id_cli,
  properties_client.nombre_cli,
  properties_client.apellidos_cli
FROM properties_client
ORDER BY properties_client.nombre_cli ASC, properties_client.apellidos_cli ASC
";
$rsClientes = mysqli_query($inmoconn,$query_rsClientes) or die(mysqli_error());
$row_rsClientes = mysqli_fetch_assoc($rsClientes);
$totalRows_rsClientes = mysqli_num_rows($rsClientes);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombre_usr", true, "text", "", "", "", "");
$formValidation->addField("email_usr", true, "text", "email", "", "", "");
$formValidation->addField("password_usr", true, "text", "", "", "", "");
$formValidation->addField("nivel_usr", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

// Make an insert transaction instance
$ins_properties_enquiries = new tNG_insert($conn_inmoconn);
$tNGs->addTransaction($ins_properties_enquiries);
// Register triggers
$ins_properties_enquiries->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_properties_enquiries->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_properties_enquiries->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_properties_enquiries->setTable("properties_enquiries");
$ins_properties_enquiries->addColumn("nombre_usr", "STRING_TYPE", "POST", "nombre_usr");
$ins_properties_enquiries->addColumn("email_usr", "STRING_TYPE", "POST", "email_usr");
$ins_properties_enquiries->addColumn("password_usr", "STRING_TYPE", "POST", "password_usr");
$ins_properties_enquiries->addColumn("nivel_usr", "NUMERIC_TYPE", "POST", "nivel_usr");
$ins_properties_enquiries->addColumn("read_cons", "CHECKBOX_1_0_TYPE", "POST", "read_cons", "1");
$ins_properties_enquiries->setPrimaryKey("id_cons", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_properties_enquiries = new tNG_update($conn_inmoconn);
$tNGs->addTransaction($upd_properties_enquiries);
// Register triggers
$upd_properties_enquiries->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_properties_enquiries->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_properties_enquiries->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_properties_enquiries->setTable("properties_enquiries");
$upd_properties_enquiries->addColumn("motivo_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("nombre_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("telefono_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("email_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("comentario_consas",  "STRING_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("respuesta_cons",  "STRING_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("fecha_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("idioma_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("inmueble_cons",  "NUMERIC_TYPE", "CURRVAL", "");
$upd_properties_enquiries->addColumn("client_cons",  "NUMERIC_TYPE", "POST", "client_cons");
$upd_properties_enquiries->addColumn("read_cons", "CHECKBOX_1_0_TYPE", "POST", "read_cons");
$upd_properties_enquiries->setPrimaryKey("id_cons", "NUMERIC_TYPE", "GET", "id_cons");

// Make an instance of the transaction object
$del_properties_enquiries = new tNG_delete($conn_inmoconn);
$tNGs->addTransaction($del_properties_enquiries);
// Register triggers
$del_properties_enquiries->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_properties_enquiries->registerTrigger("STARTER", "Trigger_Default_Starter", 2, "GET", "KT_Delete1");
$del_properties_enquiries->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_properties_enquiries->setTable("properties_enquiries");
$del_properties_enquiries->setPrimaryKey("id_cons", "NUMERIC_TYPE", "GET", "id_cons");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproperties_enquiries = $tNGs->getRecordset("properties_enquiries");
$row_rsproperties_enquiries = mysqli_fetch_assoc($rsproperties_enquiries);
$totalRows_rsproperties_enquiries = mysqli_num_rows($rsproperties_enquiries);


$query_rsCliente = "
SELECT id_cli,
    nombre_cli,
    apellidos_cli,
    email_cli
FROM properties_client
WHERE  email_cli = '".simpleSanitize(($row_rsproperties_enquiries['email_cons']))."'
";
$rsCliente = mysqli_query($inmoconn,$query_rsCliente) or die(mysqli_error());
$row_rsCliente = mysqli_fetch_assoc($rsCliente);
$totalRows_rsCliente = mysqli_num_rows($rsCliente);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate enctype="multipart/form-data">

        <input type="hidden" name="kt_pk_properties_enquiries" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproperties_enquiries['kt_pk_properties_enquiries']); ?>" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-comment-question"></i> <?php echo __('Consultas'); ?></h4>
                        <div class="flex-shrink-0">
                            <?php if (@$_GET['id_cons'] == "") { ?>
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
                                    <h4 class="card-title mb-0 flex-grow-1"><?php __('Consulta'); ?></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="" class="btn btn-success btn-sm flaot-end showInfo"><i class="fa-regular fa-reply me-1"></i> <?php __('Respnder'); ?></a>
                                    <a href="add_client_from_enquiry.php?c=<?php echo $row_rsproperties_enquiries['id_cons'] ?>" onclick="return (confirm('<?php __('¿Seguro que desea convertirlo en cliente?') ?>'))?true:false;" class="btn btn-info btn-sm flaot-end"><i class="fa-regular fa-arrows-repeat me-1"></i> <?php __('Convertir en cliente'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if ($row_rsCliente['id_cli'] != ''): ?>
                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show clearfix mt-3" role="alert">
                                    <i class="fa-regular fa-circle-exclamation label-icon"></i> <?php __('Este cliente ya existe en nuestra base de datos'); ?>
                                    <a href="/intramedianet/properties/clients-form.php?id_cli=<?php echo $row_rsCliente['id_cli'] ?>" class="btn btn-success btn-sm float-md-end d-block d-md-inline-block mt-2 mt-md-0" target="_blank" style="margin-top: -7px;"><?php __('Ver cliente'); ?></a>
                                </div>
                                <?php endif ?>

                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="">
                                            <div class="form-check form-switch form-switch-lg pt-2" dir="ltr">
                                                <input type="checkbox" name="read_cons" id="read_cons" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_enquiries['read_cons']),"1"))) {echo "checked";} ?>>
                                                <label class="form-check-label" for="read_cons"><?php __('Respondido'); ?></label>
                                                <?php echo $tNGs->displayFieldError("properties_enquiries", "read_cons"); ?>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-group <?php if($tNGs->displayFieldError("properties_enquiries", "client_cons") != '') { ?>error<?php } ?>">
                                            <label for="client_cons" class="form-label"><?php __('Asignar a cliente'); ?>:</label>
                                            <input type="text" class="select2clientes" id="client_cons" name="client_cons" value="" tabindex="-1">
                                            <?php echo $tNGs->displayFieldError("properties_enquiries", "client_cons"); ?>
                                        </div>

                                        <hr>

                                        <b class="form-label d-block ms-0"><?php __('Inmueble'); ?>:</b>

                                        <a href="/intramedianet/properties/properties-form.php?id_prop=<?php echo $row_rsproperties_enquiries['inmueble_cons']  ?>&KT_back=1" class="btn btn-soft-primary btn-sm"><i class="fa fa-building-o"></i> <?php

                                        
                                        $query_rsMenu = "SELECT referencia_prop FROM properties_properties WHERE id_prop = '".$row_rsproperties_enquiries['inmueble_cons']."'";
                                        $rsMenu = mysqli_query($inmoconn,$query_rsMenu) or die(mysqli_error());
                                        $row_rsMenu = mysqli_fetch_assoc($rsMenu);
                                        $totalRows_rsMenu = mysqli_num_rows($rsMenu);

                                        
                                        $query_rsInfoProp = "
                                        SELECT
                                          site_xml,
                                          tipo_xml,
                                          properties_properties.ref_xml_prop,
                                          properties_properties.inserted_xml_prop,
                                          properties_properties.updated_prop
                                        FROM properties_properties
                                        LEFT JOIN xml ON properties_properties.xml_xml_prop = id_xml
                                        WHERE properties_properties.id_prop = '" . $row_rsproperties_enquiries['inmueble_cons'] . "'
                                        ";
                                        $rsInfoProp = mysqli_query($inmoconn,$query_rsInfoProp) or die(mysqli_error());
                                        $row_rsInfoProp = mysqli_fetch_assoc($rsInfoProp);
                                        $totalRows_rsInfoProp = mysqli_num_rows($rsInfoProp);

                                        echo $row_rsMenu['referencia_prop'];

                                        ?></a>
                                        <?php if($row_rsInfoProp['site_xml'] != '' && $row_rsInfoProp['ref_xml_prop'] != '') { ?>
                                        <?php __('Importado desde'); ?> <b><?php echo $row_rsInfoProp['site_xml']; ?></b> <?php __('con referencia'); ?> <b><?php echo $row_rsInfoProp['ref_xml_prop']; ?></b>
                                        <?php } ?>
                                        <hr>
                                        <b class="form-label d-block ms-0"><?php __('Nombre'); ?>:</b> <?php echo $row_rsproperties_enquiries['nombre_cons'] ?>
                                        <hr>
                                        <b class="form-label d-block ms-0"><?php __('Teléfono'); ?>:</b> <?php echo $row_rsproperties_enquiries['telefono_cons'] ?>
                                        <hr>
                                        <b class="form-label d-block ms-0"><?php __('Email'); ?>:</b> <?php echo $row_rsproperties_enquiries['email_cons'] ?>
                                        <hr>
                                        <b class="form-label d-block ms-0"><?php __('Enviado'); ?>:</b> <?php echo date("d-m-Y H:i", strtotime($row_rsproperties_enquiries['fecha_cons'])); ?>
                                        <hr>
                                        <b class="form-label d-block ms-0"><?php __('Idioma'); ?>:</b>
                                        <?php
                                        switch ($row_rsproperties_enquiries['idioma_cons'] ) {
                                          case '1':
                                            echo '<img src="/intramedianet/includes/assets/img/flags-langs/en.png" alt="">';
                                            break;
                                          case '2':
                                            echo '<img src="/intramedianet/includes/assets/img/flags-langs/fr.png" alt="">';
                                            break;
                                          case '3':
                                            echo '<img src="/intramedianet/includes/assets/img/flags-langs/no.png" alt="">';
                                            break;
                                          default:
                                            echo '<img src="/intramedianet/includes/assets/imgs/flags/'.$row_rsproperties_enquiries['idioma_cons'].'.svg" alt="" style="height: 30px;">';
                                            break;
                                        }
                                        ?>

                                    </div>
                                    <div class="col-lg-6">

                                        <b class="form-label d-block ms-0"><?php __('Consulta'); ?>:</b>

                                        <?php echo nl2br($row_rsproperties_enquiries['comentario_consas']); ?>

                                        <?php if($row_rsproperties_enquiries['respuesta_cons'] != '') { ?>

                                        <hr>

                                        <b class="form-label d-block ms-0"><?php __('Respuesta'); ?>:</b>

                                        <?php echo nl2br($row_rsproperties_enquiries['respuesta_cons']); ?>

                                        <?php }  ?>

                                    </div>
                                </div>

                            </div><!-- end card-body -->
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

    <script src="_js/enquiries-form.js?id=<?php echo time(); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $('.select2clientes').select2({
          ajax: {
            url: function (params) {
                return '/intramedianet/properties/properties-buyers-select.php?q=' + params;
            },
            dataType: 'json',
            delay: 250,
            results: function (data, params) {
                return {
                    results: data.results
                };
            },
            cache: true,
            },
            placeholder: '',
            minimumInputLength: 3,
        });
        <?php if ($row_rsproperties_enquiries['client_cons'] != ''): ?>
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/intramedianet/properties/properties-buyers-select-single.php?q=<?php echo $row_rsproperties_enquiries['client_cons'] ?>'
        }).done(function (data) {
            $(".select2clientes").select2('data', data);
        });
        <?php endif ?>
    </script>

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="sendFriendForm">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-reply me-2 fs-4"></i> <?php __('Respnder'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">
                    <textarea cols="40" rows="8" name="comment" id="comment" placeholder="" class="form-control required" required></textarea>
                    <input type="hidden" name="lang" value="<?php echo $row_rsproperties_enquiries['idioma_cons']; ?>">
                    <input type="hidden" name="id" value="<?php echo $row_rsproperties_enquiries['inmueble_cons'] ?>">
                    <input type="hidden" name="cons" value="<?php echo $row_rsproperties_enquiries['id_cons'] ?>">
                    <input type="hidden" name="nombre" value="<?php echo $row_rsproperties_enquiries['nombre_cons'] ?>">
                    <input type="hidden" name="email" value="<?php echo $row_rsproperties_enquiries['email_cons'] ?>">
                    <input type="hidden" name="fecha" value="<?php echo $row_rsproperties_enquiries['fecha_cons'] ?>">
                    <input type="hidden" name="comentario" value="<?php echo nl2br($row_rsproperties_enquiries['comentario_consas']) ?>">
                </div>
                <div class="modal-footer bg-soft-primary">
                    <button type="submit" class="btn btn-success btn-sm mt-4"><?php __('Respnder'); ?></button>
                    <a href="#" class="btn btn-danger btn-sm mt-4 close-reveal-modal" data-bs-dismiss="modal"><?php __('Cerrar'); ?></a>
                </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</body>
</html>
