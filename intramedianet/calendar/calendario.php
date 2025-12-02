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

$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = mysqli_query($inmoconn,$query_rscategorias) or die(mysqli_error());
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);

if($_SESSION['kt_login_level'] == 9) {
    $query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 7 OR nivel_usr  = 10 ORDER BY nombre_usr";
    $rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
    $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
    $totalRows_rsusuarios = mysqli_num_rows($rsusuarios);
} else {
    $query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE id_usr = '".$_SESSION['kt_login_id']."' ORDER BY nombre_usr";
    $rsusuarios = mysqli_query($inmoconn,$query_rsusuarios) or die(mysqli_error());
    $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
    $totalRows_rsusuarios = mysqli_num_rows($rsusuarios);
}

$query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client ORDER BY nombre_cli, apellidos_cli";
$rsclientes = mysqli_query($inmoconn,$query_rsclientes) or die(mysqli_error());
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rsvendor = "SELECT nombre_pro, apellidos_pro, id_pro FROM properties_owner ORDER BY nombre_pro, apellidos_pro";
$rsvendor = mysqli_query($inmoconn,$query_rsvendor) or die(mysqli_error());
$row_rsvendor = mysqli_fetch_assoc($rsvendor);
$totalRows_rsvendor = mysqli_num_rows($rsvendor);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = mysqli_query($inmoconn,$query_rspropiedad) or die(mysqli_error());
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);


$query_rsUsuariosCal = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr = 9 OR nivel_usr = 8 OR nivel_usr = 7 OR nivel_usr = 10 ORDER BY nombre_usr";
$rsUsuariosCal = mysqli_query($inmoconn,$query_rsUsuariosCal) or die(mysqli_error());
$row_rsUsuariosCal = mysqli_fetch_assoc($rsUsuariosCal);
$totalRows_rsUsuariosCal = mysqli_num_rows($rsUsuariosCal);

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
                    <h4 class="card-title mb-0 flex-grow-1 d-none d-md-block"><i class="fa-regular fa-calendar"></i> <?php echo __('Calendario'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-success btn-sm add-cita"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                        <?php if ($_SESSION['kt_login_level'] == '9'): ?>
                        <a href="#myModal2" class="btn btn-primary btn-sm pull-right" data-bs-toggle="modal"><?php __('Añadir a tu programa de correo'); ?></a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">

                    <?php if($_SESSION['kt_login_level'] == 9){ ?>
                        <div class="row d-none d-md-flex">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="comercial_cal" class="form-label"><?php __('Filtrar por usuarios'); ?></label>
                                    <select name="comercial_cal" id="comercial_cal" class="select2" multiple>
                                        <?php
                                        do {
                                        ?>
                                        <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {echo " SELECTED";} ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                        <?php
                                        } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                          $rows = mysqli_num_rows($rsusuarios);
                                          if($rows > 0) {
                                              mysqli_data_seek($rsusuarios, 0);
                                            $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                          }
                                        ?>
                                    </select>
                                    <span class="btn btn-soft-primary btn-sm rounded-0 rounded-bottom select-all ms-2"><?php __('Seleccionar todos'); ?></span>
                                    <span class="btn btn-soft-primary btn-sm rounded-0 rounded-bottom deselect-all"><?php __('Deseleccionar todos'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="campotexto" class="form-label"><?php __('Filtrar por texto'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="campotexto" id="campotexto">
                                        <button class="btn btn-danger resetText" type="button"><?php __('Limpiar'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                    <?php } ?>

                    <div id="calendario"></div>

                    <?php if($_SESSION['kt_login_level'] == 9){ ?>
                        <div class="row d-md-none mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="comercial_cal" class="form-label"><?php __('Filtrar por usuarios'); ?></label>
                                    <select name="comercial_cal" id="comercial_cal" class="select2" multiple>
                                        <?php 
                                        do {
                                        ?>
                                        <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {echo " SELECTED";} ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                        <?php
                                        } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                          $rows = mysqli_num_rows($rsusuarios);
                                          if($rows > 0) {
                                              mysqli_data_seek($rsusuarios, 0);
                                            $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                          }
                                        ?>
                                    </select>
                                    <span class="btn btn-soft-primary btn-sm rounded-0 rounded-bottom select-all ms-2"><?php __('Seleccionar todos'); ?></span>
                                    <span class="btn btn-soft-primary btn-sm rounded-0 rounded-bottom deselect-all"><?php __('Deseleccionar todos'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <label for="campotexto" class="form-label"><?php __('Filtrar por texto'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="campotexto" id="campotexto">
                                        <button class="btn btn-danger resetText" type="button"><?php __('Limpiar'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var AppLang = '<?php echo $lang_adm ?>';
    var next31 = '<?php __('Próximos 31 días'); ?>';
    var Allevents = '<?php __('Todos'); ?>';
    var $eventBgColor = '<?php echo $eventBgColor; ?>';

    var rxhtmlTag = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi;
    jQuery.htmlPrefilter = function( html ) {
        return html.replace( rxhtmlTag, "<$1></$2>" );
    };

    </script>

    <script src="_js/calendar-view.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <?php if( (isset($_GET['cit'])) && ($_GET['cit'] != '') ) { ?>

    <script>
    jQuery(document).ready(function($) {
        console.log('sdsdsd');
        $.getJSON( "disp-json.php?lang=" + AppLang, function( data ) {
            console.log(data);
            $.each( data, function( key, val ) {
                if (val.id == '<?php echo $_GET['cit'] ?>') {


                    var content = '';
                    content += '<div class="modal-header" style="background: '+val.backgroundColor+' !important;">';
                    content += '<h5 class="modal-title text-white pb-3"><b>';
                                        content += val.titulo;
                                        content += '</b><br>';
                                        content += '<small>'+val.category+' // '+val.user+'</small>';
                                        content += '</h5>';
                    content += '<button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>';
                    content += '</div>';
                    content += '<div class="modal-body">';
                    content += '<ul class="list-unstyled">';
                    if (val.inicio != val.final) {
                      content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-calendar-arrow-down"></i> ' + calFechaInicio + ':</b> '+val.inicio+'</li>';
                    }
                    content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-calendar-arrow-up"></i> ' + calFechaFinal + ':</b> '+val.final+'</li>';
                    if ((val.usern != null && val.usern != '') || (val.usera != null && val.usera != '')) {
                      content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-user"></i> ' + calClientex + ':</b> <a href="/intramedianet/properties/clients-form.php?id_cli='+val.idn+'" target="_blank" class="btn btn-soft-primary btn-sm">';
                      if (val.usern != null) {
                          content += val.usern + ' ';
                      }
                      if (val.usera != null) {
                          content += val.usera + ' ';
                      }
                      content += '</a></li>';
                    }
                    if ((val.userv != null && val.userv != '') || (val.userva != null && val.userva != '')) {
                      content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-user-tie-hair"></i> ' + calPropx + ':</b> <a href="/intramedianet/properties/owners-form.php?id_pro='+val.idv+'" target="_blank" class="btn btn-soft-primary btn-sm">';
                      if (val.userv != null) {
                          content += val.userv + ' ';
                      }
                      if (val.userva != null) {
                          content += val.userva + ' ';
                      }
                      content += '</a></li>';
                    }
                    if (val.property != 'null' && val.property != '') {
                      var refsLP = val.property.split(",");
                      var idesLP = val.ids.split(",");
                      content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-building"></i> ' + calPropiedad + ':</b> ';
                      for (var i = 0; i < refsLP.length; i++) {
                          content += '<a href="/intramedianet/properties/properties-form.php?id_prop='+idesLP[i]+'" target="_blank" class="btn btn-soft-primary btn-sm">'+refsLP[i]+'</a> ';
                      }
                      // +val.ref+' '+val.ids+
                      content +='</li>';
                    }
                    if (val.lugar != null && val.lugar != '') {
                      content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-location-dot"></i> ' + calLugar + ':</b> '+val.lugar+'</li>';
                    }
                    content += '</ul>';
                    if (val.notas != null) {
                      content += '<div style="height: 100px; overflow: scroll; margin: 5px;">';
                      content += ''+val.notas+'';
                      content += '</div>';
                    }
                    content += '</div>';
                    if (val.backgroundColor != $eventBgColor) {
                        content += '<div class="modal-footer  bg-soft-primary">';
                        content += '<a href="" class="btn btn-success btn-sm edit-event mt-4" data-id="'+val.id+'"><i class="fa-regular fa-pencil "></i> '+dtEditar+'</a>';
                        content += '<a href="" class="btn btn-danger btn-sm delete-event mt-4" data-id="'+val.id+'"><i class="fa-regular fa-trash-can "></i> '+dtEliminar+'</a>';
                        content += '</div>';
                    }



                  // var content = '';
                  //   content += '<div class="modal-header" style="background: '+val.backgroundColor+' !important;">';
                  //   content += '<h5 class="modal-title text-white pb-3"><b>';
                  //                       content += val.titulo;
                  //                       content += '</b><br>';
                  //                       content += '<small>'+val.category+' // '+val.user+'</small>';
                  //                       content += '</h5>';
                  //   content += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                  //   content += '</div>';
                  //   content += '<div class="modal-body">';
                  //   content += '<ul class="list-unstyled">';
                  //   content += '<li><b><i class="fa-regular fa-calendar-arrow-down"></i> ' + calFechaInicio + ':</b> '+val.inicio+'</li>';
                  //   content += '<li><b><i class="fa-regular fa-calendar-arrow-up"></i> ' + calFechaFinal + ':</b> '+val.final+'</li>';
                  //   if (val.usern != null || val.usera != null) {
                  //     content += '<li><b><i class="fa-regular fa-user"></i> ' + calClientex + ':</b> '+val.usern+' '+val.usera+'</li>';
                  //   }
                  //   if (val.userv != null || val.userva != null) {
                  //     content += '<li><b><i class="fa-regular fa-user-tie-hair"></i> ' + calPropx + ':</b> '+val.userv+' '+val.userva+'</li>';
                  //   }
                  //   if (val.property != 'null' || val.property != '') {
                  //     content += '<li><b><i class="fa-regular fa-building"></i> ' + calPropiedad + ':</b> '+val.ref+'</li>';
                  //   }
                  //   if (val.lugar != null) {
                  //     content += '<li><b><i class="fa-regular fa-location-dot"></i> ' + calLugar + ':</b> '+val.lugar+'</li>';
                  //   }
                  //   content += '</ul>';
                  //   if (val.notas != null) {
                  //     content += '<div style="height: 100px; overflow: scroll; margin: 5px;">';
                  //     content += ''+val.notas+'';
                  //     content += '</div>';
                  //   }
                  //   content += '</div>';
                  //   content += '<div class="modal-footer  bg-soft-primary">';
                  //   content += '<a href="" class="btn btn-success btn-sm edit-event mt-4" data-id="'+val.id+'"><i class="fa-regular fa-pencil "></i> '+dtEditar+'</a>';
                  //   content += '<a href="" class="btn btn-danger btn-sm delete-event mt-4" data-id="'+val.id+'"><i class="fa-regular fa-trash-can "></i> '+dtEliminar+'</a>';
                  //   content += '</div>';

                    $('#event-text').html(content);
                    $('#myModal3').modal('show');
                }
            });
        });

        // setTimeout(function (){ $('#calendario').fullCalendar('clientEvents', '20'); alert('xxxx'); }, 5000);
    });
    </script>

    <?php } ?>

    <div id="myModal3" class="modal fade" data-bs-focus="false" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="event-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal2" class="modal fade" data-bs-focus="false" tabindex="-1" aria-labelledby="myModal2Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModal2Label"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir a tu programa de correo'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <?php __('Copia la url para suscribirte en tu programa') ?>:</p>
                    <p><b><i class="icon icon-calendar"></i>
                            <?php __('ICS Español'); ?>:</b> <br> http://
                        <?php echo $_SERVER['HTTP_HOST']; ?>/intramedianet/calendar/ical.php?lang=es</p>
                    <p><b><i class="icon icon-calendar"></i>
                            <?php __('ICS Inglés'); ?>:</b> <br> http://
                        <?php echo $_SERVER['HTTP_HOST']; ?>/intramedianet/calendar/ical.php?lang=en</p>
                    <div>
                        <hr>
                        <?php do { ?>
                            <?php if($_SESSION['kt_login_level'] == '9' || $row_rsUsuariosCal['id_usr'] == $_SESSION['kt_login_id']) { ?>
                            <p>
                                <strong><?php echo $row_rsUsuariosCal['nombre_usr']?>:</strong> <br>
                                <span style="white-space: nowrap; font-size: 13.5px;"> <b>ES: </b> https://<?php echo $_SERVER['HTTP_HOST']; ?>/intramedianet/calendar/ical.php?lang=es&id_usr=<?php echo $row_rsUsuariosCal['id_usr']?></span> <br>
                                <span style="white-space: nowrap; font-size: 13.5px;"> <b>EN: </b> https://<?php echo $_SERVER['HTTP_HOST']; ?>/intramedianet/calendar/ical.php?lang=en&id_usr=<?php echo $row_rsUsuariosCal['id_usr']?></span>
                            </p>
                            <?php } ?>
                        <?php } while ($row_rsUsuariosCal = mysqli_fetch_assoc($rsUsuariosCal)); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" id="btn-close" data-dismiss="modal">
                        <?php __('Cerrar'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

<div class="mb-4">
  <label for="vzxcv" class="form-label"><?php __('Fecha final'); ?>:</label>
  <input type="text" name="vzxcv" id="vzxcv" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
</div>


    <div id="myModal" class="modal fade" data-bs-focus="false" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-calendar-circle-plus me-2 fs-4"></i> <?php __('Añadir cita'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body bg-light">

                    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>

                    <div class="row">

                        <div class="col-md-7">

                            <div class="mb-4">
                                <label for="titulo_ct" class="form-label"><?php __('Título'); ?>:</label>
                                <input type="text" name="titulo_ct" id="titulo_ct" value="" size="32" maxlength="255" class="form-control required" required>
                                <input type="hidden" name="id_ct" id="id_ct" value="">
                            </div>

                            <div class="row">

                              <div class="col-md-6">

                                  <div class="mb-4">
                                      <label for="inicio_ct" class="form-label"><?php __('Fecha inicio'); ?>:</label>
                                      <input type="text" name="inicio_ct" id="inicio_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                  </div>

                              </div>

                              <div class="col-md-6">

                                  <div class="mb-4">
                                      <label for="final_ct" class="form-label"><?php __('Fecha final'); ?>:</label>
                                      <input type="text" name="final_ct" id="final_ct" value="" size="32" maxlength="255" class="form-control datepicktime required" required>
                                  </div>

                              </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="categoria_ct" class="form-label"><?php __('Categoría'); ?>:</label>
                                        <select name="categoria_ct" id="categoria_ct" class="form-select required" required>
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php
                                            do {
                                            ?>
                                            <option value="<?php echo $row_rscategorias['id_ct']?>"><?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?></option>
                                            <?php
                                            } while ($row_rscategorias = mysqli_fetch_assoc($rscategorias));
                                              $rows = mysqli_num_rows($rscategorias);
                                              if($rows > 0) {
                                                  mysqli_data_seek($rscategorias, 0);
                                                $row_rscategorias = mysqli_fetch_assoc($rscategorias);
                                              }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="user_ct" class="form-label"><?php __('Usuario'); ?>:</label>
                                        <select name="user_ct" id="user_ct" class="required select2" required data-dropdown-parent="#myModal">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php
                                            do {
                                            ?>
                                            <option value="<?php echo $row_rsusuarios['id_usr']?>"<?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {echo " SELECTED";} ?>><?php echo $row_rsusuarios['nombre_usr']?></option>
                                            <?php
                                            } while ($row_rsusuarios = mysqli_fetch_assoc($rsusuarios));
                                              $rows = mysqli_num_rows($rsusuarios);
                                              if($rows > 0) {
                                                  mysqli_data_seek($rsusuarios, 0);
                                                $row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
                                              }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="users_ct" class="form-label"><?php __('Clientex'); ?>:</label>
                                        <select name="users_ct" id="users_ct" class="select2" data-dropdown-parent="#myModal">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php
                                            do {
                                                ?>
                                            <option value="<?php if(isset($row_rsclientes) && isset($row_rsclientes['id_cli'])) echo $row_rsclientes['id_cli'] ?>" <?php if ( isset($_GET['id_cli']) && $_GET['id_cli'] == $row_rsclientes['id_cli']): ?>selected<?php endif ?>><?php echo $row_rsclientes['nombre_cli']?> <?php echo $row_rsclientes['apellidos_cli']?></option>
                                            <?php
                                            } while ($row_rsclientes = mysqli_fetch_assoc($rsclientes));
                                            $rows = mysqli_num_rows($rsclientes);
                                            if($rows > 0) {
                                                mysqli_data_seek($rsclientes, 0);
                                                $row_rsclientes = mysqli_fetch_assoc($rsclientes);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="users_ct" class="form-label"><?php __('Propietario'); ?>:</label>
                                        <select name="vendedores_ct" id="vendedores_ct" class="select2" data-dropdown-parent="#myModal">
                                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                            <?php
                                            do {
                                            ?>
                                            <option value="<?php echo $row_rsvendor['id_pro']?>" <?php if (isset($_GET['id_pro']) && $_GET['id_pro'] == $row_rsvendor['id_pro']): ?>selected<?php endif ?>><?php echo $row_rsvendor['nombre_pro']?> <?php echo $row_rsvendor['apellidos_pro']?></option>
                                            <?php
                                            } while ($row_rsvendor = mysqli_fetch_assoc($rsvendor));
                                              $rows = mysqli_num_rows($rsvendor);
                                              if($rows > 0) {
                                                  mysqli_data_seek($rsvendor, 0);
                                                $row_rsvendor = mysqli_fetch_assoc($rsvendor);
                                              }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="lugar_ct" class="form-label"><?php __('Lugar'); ?>:</label>
                                <input type="text" name="lugar_ct" id="lugar_ct" value="" size="32" maxlength="255" class="form-control">
                            </div>

                            <div class="mb-4">
                                <label for="property_ct" class="form-label"><?php __('Propiedades'); ?>:</label>
                                <input type="text" class="select2references" id="property_ct" name="property_ct[]" value="" tabindex="-1">
                            </div>

                        </div>

                        <div class="col-md-5">

                            <div class="mb-4">
                                <label for="notas_ct" class="form-label"><?php __('Notas'); ?>:</label>
                                <textarea name="notas_ct" id="notas_ct" cols="40" rows="19" class="form-control"></textarea>
                            </div>

                            <hr>

                            <a href="#" class="btn btn-success addHist pull-right"><?php __('Añadir fecha'); ?></a>

                        </div>

                    </div>

                    </form>

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" id="btn-close-save" name="KT_Insert1"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar y guardar'); ?>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm mt-4" id="btn-close"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar'); ?>
                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
        dropdownParent: $('#myModal')
    });
    $('.select2vendors').select2({
      ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-vendors-select.php?q=' + params;
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
        dropdownParent: $('#myModal')
    });
    $('.select2references').select2({
        multiple:true,
        ajax: {
        url: function (params) {
            return '/intramedianet/properties/properties-references-select.php?q=' + params;
        },
        dataType: 'json',
        delay: 250,
        results: function (data, params) {
            return {
                results: data.results
            };
        },
        // cache: true,
        },
        placeholder: '',
        minimumInputLength: 3,
        dropdownParent: $('#myModal')
    });
    <?php if(isset($_GET['add']) && $_GET['add'] == 'ok') { ?>
    $( document ).ready(function() {
        $('.add-cita').click();
    });
    <?php } ?>

    $('.select-all').click(function () {
        let $select2 = $('#comercial_cal');
        $select2.find('option').prop('selected', 'selected');
        $select2.trigger('change');
    });
    $('.deselect-all').click(function () {
        let $select2 = $('#comercial_cal');
        $select2.find('option').prop('selected', '');
        $select2.trigger('change');
    });

</script>

</body>
</html>
