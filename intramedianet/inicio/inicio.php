<?php


// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

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

if($_SESSION['kt_login_level'] != 9) {
    header("Location: ../properties/properties.php");
}

$query_rsHistorial = "
SELECT
  users.nombre_usr,
  properties_log.referencia_log,
  properties_log.action_log,
  properties_log.date_log,
  properties_log.id_log
FROM properties_log LEFT OUTER JOIN users ON properties_log.user_log = users.id_usr
ORDER BY date_log DESC
LIMIT 15
";

$rsHistorial = $inmoconn->query($query_rsHistorial);
if (!$rsHistorial) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsHistorial = mysqli_fetch_assoc($rsHistorial);

$query_rsEmails = "
SELECT
    properties_log_mails.id_log,
    properties_properties.referencia_prop as prop_id_log,
    (SELECT CONCAT_WS(' ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = send_id_log) AS send_id_log,
    properties_log_mails.email_log,
    properties_log_mails.type_log,
    properties_log_mails.date_log
FROM properties_log_mails INNER JOIN properties_properties ON properties_log_mails.prop_id_log = properties_properties.id_prop
ORDER BY date_log DESC
LIMIT 15
";

$rsEmails = $inmoconn->query($query_rsEmails);if(!$rsEmails) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsEmails = mysqli_fetch_assoc($rsEmails);


$query_rsActivos = "
SELECT
case properties_properties.activado_prop
    when '1' then '". __('Activados', true) . "'
    when '0' then '" . __('Desactivados', true) . "'
end as name,
COUNT(id_prop) AS total
FROM properties_properties
GROUP BY activado_prop
ORDER BY total DESC
";
$rsActivos = $inmoconn->query($query_rsActivos); if(!$rsActivos) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsActivos = mysqli_fetch_assoc($rsActivos);
$totalRows_rsActivos = mysqli_num_rows($rsActivos);


$query_rsTipos = "
SELECT
CASE WHEN properties_types.types_".$lang_adm."_typ IS NOT NULL THEN properties_types.types_".$lang_adm."_typ ELSE types.types_".$lang_adm."_typ END AS name,
COUNT(CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END) as total
FROM  properties_properties
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
WHERE  force_hide_prop != 1
GROUP BY CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END
ORDER BY total DESC
LIMIT 10
";

$rsTipos = $inmoconn->query($query_rsTipos); if(!$rsTipos) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTipos = mysqli_fetch_assoc($rsTipos);
$totalRows_rsTipos = mysqli_num_rows($rsTipos);


$query_rsOperations = "
SELECT properties_status.status_".$lang_adm."_sta AS `name`,
  COUNT(id_sta) AS total
FROM properties_properties INNER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE  force_hide_prop != 1
GROUP BY id_sta
ORDER BY total DESC
LIMIT 10
";
$rsOperations = $inmoconn->query($query_rsOperations);if(!$rsOperations) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsOperations = mysqli_fetch_assoc($rsOperations);
$totalRows_rsOperations = mysqli_num_rows($rsOperations);

$query_rsLocations = "
SELECT
  COUNT(CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) AS total,
  CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS sname,
  CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
WHERE  force_hide_prop != 1
GROUP BY CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END
ORDER BY total DESC
LIMIT 10
";
$rsLocations = $inmoconn->query($query_rsLocations); if(!$rsLocations) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsLocations = mysqli_fetch_assoc($rsLocations);
$totalRows_rsLocations = mysqli_num_rows($rsLocations);



$query_rsImportados = "
SELECT
  COUNT(id_prop) AS total,
  (SELECT site_xml FROM xml WHERE id_xml = xml_xml_prop) AS `name`
FROM properties_properties
WHERE  force_hide_prop != 1 AND (SELECT site_xml FROM xml WHERE id_xml = xml_xml_prop) != ''
GROUP BY xml_xml_prop
ORDER BY total DESC
";
$rsImportados = $inmoconn->query($query_rsImportados); if(!$rsImportados) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsImportados = mysqli_fetch_assoc($rsImportados);
$totalRows_rsImportados = mysqli_num_rows($rsImportados);



$query_rsNacionalidades = "
SELECT COUNT(nacionalidad_cli) AS total,
(SELECT nacionalidad_".$lang_adm."_ncld FROM nacionalidades WHERE id_ncld = nacionalidad_cli) AS `name`
FROM properties_client
WHERE nacionalidad_cli != ''
GROUP BY nacionalidad_cli
ORDER BY total DESC
LIMIT 10
";
$rsNacionalidades = $inmoconn->query($query_rsNacionalidades); if(!$rsNacionalidades) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsNacionalidades = mysqli_fetch_assoc($rsNacionalidades);
$totalRows_rsNacionalidades = mysqli_num_rows($rsNacionalidades);

$query_rsCaptado = "
SELECT
COUNT(category_".$lang_adm."_cap) as total,
properties_client_captado.category_en_cap as name
FROM properties_client INNER JOIN properties_client_captado ON properties_client.captado_por2_cli = properties_client_captado.id_cap
GROUP BY properties_client_captado.id_cap
ORDER BY total DESC
LIMIT 10
";
$rsCaptado = $inmoconn->query($query_rsCaptado); if(!$rsCaptado) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsCaptado = mysqli_fetch_assoc($rsCaptado);
$totalRows_rsCaptado = mysqli_num_rows($rsCaptado);



$query_rsReviewPropsUsrs = "SELECT * FROM prop_user ORDER BY fecha_prp";
$rsReviewPropsUsrs = $inmoconn->query($query_rsReviewPropsUsrs); if(!$rsReviewPropsUsrs) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsReviewPropsUsrs = mysqli_fetch_assoc($rsReviewPropsUsrs);
$totalRows_rsReviewPropsUsrs = mysqli_num_rows($rsReviewPropsUsrs);


$query_rscategorias = "SELECT category_".$lang_adm."_ct, id_ct FROM citas_categories ORDER BY category_".$lang_adm."_ct";
$rscategorias = $inmoconn->query($query_rscategorias); if(!$rscategorias) {die("Error en la consulta: " . $inmoconn->error);}
$row_rscategorias = mysqli_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysqli_num_rows($rscategorias);


$query_rsusuarios = "SELECT nombre_usr, id_usr FROM users WHERE nivel_usr  = 9 OR nivel_usr  = 8 OR nivel_usr  = 10 ORDER BY nombre_usr";
$rsusuarios = $inmoconn->query($query_rsusuarios); if(!$rsusuarios) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsusuarios = mysqli_fetch_assoc($rsusuarios);
$totalRows_rsusuarios = mysqli_num_rows($rsusuarios);


$query_rsclientes = "SELECT nombre_cli, apellidos_cli, id_cli FROM properties_client ORDER BY nombre_cli, apellidos_cli";
$rsclientes = $inmoconn->query($query_rsclientes); if(!$rsclientes) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsclientes = mysqli_fetch_assoc($rsclientes);
$totalRows_rsclientes = mysqli_num_rows($rsclientes);


$query_rspropiedad = "SELECT id_prop, referencia_prop FROM properties_properties ORDER BY referencia_prop";
$rspropiedad = $inmoconn->query($query_rspropiedad); if(!$rspropiedad) {die("Error en la consulta: " . $inmoconn->error);}
$row_rspropiedad = mysqli_fetch_assoc($rspropiedad);
$totalRows_rspropiedad = mysqli_num_rows($rspropiedad);


$sWhere = ' WHERE status_tsk != 2 AND status_tsk != \'\' ';
$query_rsTareas = "
SELECT SQL_CALC_FOUND_ROWS
  (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk,
  subject_tsk,
  date_due_tsk,
  priority_tsk,
  (SELECT categorias_".$lang_adm."_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
  case contact_type_tsk
      when '1' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-male\"></i> ', nombre_cnt, apellidos_cnt) FROM contactos WHERE id_cnt = contact_tsk)
      when '2' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-users\"></i> ', nombre_cli, apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
      when '3' then (SELECT CONCAT_WS(' ', '<i class=\"fa fa-fw fa-key\"></i> ', nombre_pro, apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
      when '' then ''
  end as contact_type_tsk,
  id_tsk
FROM tasks
$sWhere
ORDER BY date_due_tsk DESC, subject_tsk ASC
LIMIT 15
";
$rsTareas = $inmoconn->query($query_rsTareas); if(!$rsTareas) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTareas = mysqli_fetch_assoc($rsTareas);
$totalRows_rsTareas = mysqli_num_rows($rsTareas);


$query_rsTotalContact = "SELECT id_cons FROM properties_enquiries";
$rsTotalContact = $inmoconn->query($query_rsTotalContact); if(!$rsTotalContact) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalContact = mysqli_fetch_assoc($rsTotalContact);
$totalRows_rsTotalContact = mysqli_num_rows($rsTotalContact);


$query_rsTotalBajada = "SELECT SQL_CALC_FOUND_ROWS properties_bajada.id_baj, properties_properties.referencia_prop as prop_baj, properties_bajada.name_baj, properties_bajada.email_baj, properties_bajada.phone_baj, properties_bajada.lang_baj, properties_bajada.date_baj FROM properties_bajada INNER JOIN properties_properties ON properties_bajada.prop_baj = properties_properties.id_prop";
$rsTotalBajada = $inmoconn->query($query_rsTotalBajada); if(!$rsTotalBajada) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalBajada = mysqli_fetch_assoc($rsTotalBajada);
$totalRows_rsTotalBajada = mysqli_num_rows($rsTotalBajada);


$query_rsTotalContactForm = "SELECT id_con FROM properties_consultas_log";
$rsTotalContactForm = $inmoconn->query($query_rsTotalContactForm); if(!$rsTotalContactForm) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalContactForm = mysqli_fetch_assoc($rsTotalContactForm);
$totalRows_rsTotalContactForm = mysqli_num_rows($rsTotalContactForm);


$query_rsTotalPropActv = "SELECT id_prop FROM properties_properties WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1";
$rsTotalPropActv = $inmoconn->query($query_rsTotalPropActv); if(!$rsTotalPropActv) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalPropActv = mysqli_fetch_assoc($rsTotalPropActv);
$totalRows_rsTotalPropActv = mysqli_num_rows($rsTotalPropActv);


$query_rsTotalPropProp = "SELECT id_prop FROM properties_properties WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND (xml_xml_prop IS NULL OR xml_xml_prop = '')";
$rsTotalPropProp = $inmoconn->query($query_rsTotalPropProp); if(!$rsTotalPropProp) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalPropProp = mysqli_fetch_assoc($rsTotalPropProp);
$totalRows_rsTotalPropProp = mysqli_num_rows($rsTotalPropProp);


$query_rsTotalPropImport = "SELECT id_prop FROM properties_properties WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND (xml_xml_prop != '')";
$rsTotalPropImport = $inmoconn->query($query_rsTotalPropImport); if(!$rsTotalPropImport) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalPropImport = mysqli_fetch_assoc($rsTotalPropImport);
$totalRows_rsTotalPropImport = mysqli_num_rows($rsTotalPropImport);


$query_rsTotalCliCalls = "SELECT id_cli FROM properties_client WHERE atendido_por_cli = '".$_SESSION['kt_login_id']."' AND next_call_cli != ''";
$rsTotalCliCalls = $inmoconn->query($query_rsTotalCliCalls); if(!$rsTotalCliCalls) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalCliCalls = mysqli_fetch_assoc($rsTotalCliCalls);
$totalRows_rsTotalCliCalls = mysqli_num_rows($rsTotalCliCalls);


$query_rsTotalCliCallsPend = "SELECT id_cli FROM properties_client WHERE atendido_por_cli = '".$_SESSION['kt_login_id']."' AND next_call_cli != '' AND next_call_cli <= CURRENT_DATE";
$rsTotalCliCallsPend = $inmoconn->query($query_rsTotalCliCallsPend); if(!$rsTotalCliCallsPend) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalCliCallsPend = mysqli_fetch_assoc($rsTotalCliCallsPend);
$totalRows_rsTotalCliCallsPend = mysqli_num_rows($rsTotalCliCallsPend);


$query_rsTotalCliCallsNext = "SELECT id_cli FROM properties_client WHERE atendido_por_cli = '".$_SESSION['kt_login_id']."' AND next_call_cli != '' AND next_call_cli > CURRENT_DATE";
$rsTotalCliCallsNext = $inmoconn->query($query_rsTotalCliCallsNext); if(!$rsTotalCliCallsNext) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalCliCallsNext = mysqli_fetch_assoc($rsTotalCliCallsNext);
$totalRows_rsTotalCliCallsNext = mysqli_num_rows($rsTotalCliCallsNext);

$query_rsTotalOwnerCalls = "SELECT id_pro FROM properties_owner WHERE next_call_pro != ''"; // captado_por_pro = '".$_SESSION['kt_login_id']."'
$rsTotalOwnerCalls = $inmoconn->query($query_rsTotalOwnerCalls); if(!$rsTotalOwnerCalls) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalOwnerCalls = mysqli_fetch_assoc($rsTotalOwnerCalls);
$totalRows_rsTotalOwnerCalls = mysqli_num_rows($rsTotalOwnerCalls);


$query_rsTotalOwnerCallsPend = "SELECT id_pro FROM properties_owner WHERE next_call_pro <= CURRENT_DATE AND  next_call_pro != ''"; // captado_por_pro = '".$_SESSION['kt_login_id']."' AND
$rsTotalOwnerCallsPend = $inmoconn->query($query_rsTotalOwnerCallsPend); if(!$rsTotalOwnerCallsPend) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalOwnerCallsPend = mysqli_fetch_assoc($rsTotalOwnerCallsPend);
$totalRows_rsTotalOwnerCallsPend = mysqli_num_rows($rsTotalOwnerCallsPend);


$query_rsTotalOwnerCallsNext = "SELECT id_pro FROM properties_owner WHERE next_call_pro > CURRENT_DATE AND  next_call_pro != ''"; // captado_por_pro = '".$_SESSION['kt_login_id']."' AND
$rsTotalOwnerCallsNext = $inmoconn->query($query_rsTotalOwnerCallsNext); if(!$rsTotalOwnerCallsNext) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsTotalOwnerCallsNext = mysqli_fetch_assoc($rsTotalOwnerCallsNext);
$totalRows_rsTotalOwnerCallsNext = mysqli_num_rows($rsTotalOwnerCallsNext);


$query_rsMLSexported = "SELECT id_prop FROM properties_properties WHERE export_mlsmediaelx_prop = 1  AND activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1";
$rsMLSexported = $inmoconn->query($query_rsMLSexported); if(!$rsMLSexported) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsMLSexported = mysqli_fetch_assoc($rsMLSexported);
$totalRows_rsMLSexported = mysqli_num_rows($rsMLSexported);


$query_rsMLSimported = "SELECT id_prop FROM properties_properties WHERE activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1 AND xml_xml_prop = '" . $expMLSMediaelxID . "'";
$rsMLSimported = $inmoconn->query($query_rsMLSimported); if(!$rsMLSimported) {die("Error en la consulta: " . $inmoconn->error);}
$row_rsMLSimported = mysqli_fetch_assoc($rsMLSimported);
$totalRows_rsMLSimported = mysqli_num_rows($rsMLSimported);


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php if(isset($_COOKIE['sidebarComp'])){ echo ($_COOKIE['sidebarComp'] != '')?$_COOKIE['sidebarComp']:'lg'; } ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable" class="htmltag">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

  <style>
      .fc-header-toolbar {
          display: none !important;
      }
  </style>

</head>

<body class="dashboard">

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <?php /* ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card position-relative">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-memheck"></i> <?php echo __('xxxxx'); ?></h4>
                    <div class="flex-shrink-0">
                        <a href="news-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                    </div>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
    <?php */ ?>

    <div id="main-content">

        <div class="container-fluid px-0">

            <div class="sortable">

                <div class="row">

                    <div class="col-md-6" id="section1">

                        <?php if($actCalendar == 1) { ?>
                        <div class="card position-relative" id="calendar">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-calendar"></i> <?php echo __('Calendario'); ?></h4>
                                <div class="flex-shrink-0">
                                    <a href="/intramedianet/calendar/calendario.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-calendar me-1"></i> <?php __('Ver calendario'); ?></a>
                                    <!-- <a href="#" class="btn btn-success btn-sm add-cita"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="calendario"></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($actTasks == 1) { ?>
                        <div class="card position-relative" id="tareas">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-list-check"></i> <?php echo __('Tareas'); ?></h4>
                                <div class="flex-shrink-0">
                                    <a href="/intramedianet/tasks/tasks.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-list-check me-1"></i> <?php __('Tareas'); ?></a>
                                    <a href="/intramedianet/tasks/tasks-form.php?KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-plus me-1"></i> <?php __('Añadir'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-bordered align-middle" width="100%">
                                      <thead class="table-light">
                                        <tr>
                                          <th class="d-md-none"></th>
                                          <th><?php __('Responsable'); ?></th>
                                          <th><?php __('Asunto'); ?></th>
                                          <th><?php __('Vencimiento'); ?></th>
                                          <th><?php __('Prioridad'); ?></th>
                                          <th><?php __('Status'); ?></th>
                                          <th><?php __('Contacto'); ?></th>
                                          <th class="d-none d-md-block"></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php if ($row_rsTareas) { ?>
                                        <?php do { ?>
                                        <tr>
                                          <td class="d-md-none"><a href="/intramedianet/tasks/tasks-form.php?id_tsk=<?php echo $row_rsTareas['id_tsk']; ?>&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-pencil"></i></a></td>
                                          <td><?php echo $row_rsTareas['admin_tsk']; ?></td>
                                          <td><?php echo $row_rsTareas['subject_tsk']; ?></td>
                                          <td>
                                            <?php if ($row_rsTareas['date_due_tsk'] != ''): ?>
                                                <?php echo date("d-m-Y", strtotime($row_rsTareas['date_due_tsk'])); ?>
                                            <?php endif ?>
                                          </td>
                                          <td><?php echo __($row_rsTareas['priority_tsk']); ?></td>
                                          <td><?php echo $row_rsTareas['status_tsk']; ?></td>
                                          <td><?php echo $row_rsTareas['contact_type_tsk']; ?></td>
                                          <td class="d-none d-md-block"><a href="/intramedianet/tasks/tasks-form.php?id_tsk=<?php echo $row_rsTareas['id_tsk']; ?>&amp;KT_back=1" class="btn btn-success btn-sm"><i class="fa-regular fa-pencil"></i></a></td>
                                        </tr>
                                        <?php } while ($row_rsTareas = mysqli_fetch_assoc($rsTareas)); ?>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsReviewPropsUsrs > 0) { ?>
                        <div class="card position-relative" id="review">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-building-circle-check"></i> <?php echo __('Propiedades de usuarios para revisar'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-bordered align-middle" width="100%">
                                      <thead class="table-light">
                                            <tr>
                                                <th><?php __('Nombre'); ?></th>
                                                <th><?php __('Email'); ?></th>
                                                <th><?php __('Fecha'); ?></th>
                                                <th class="actions"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php do { ?>
                                            <tr>
                                                <td><?php echo $row_rsReviewPropsUsrs['name_prp']; ?></td>
                                                <td><?php echo $row_rsReviewPropsUsrs['email_prp']; ?></td>
                                                <td><?php echo date("d-m-Y H:i", strtotime($row_rsReviewPropsUsrs['fecha_prp'])); ?></td>
                                                <td><a href="/intramedianet/properties/properties-review.php?id_prp=<?php echo $row_rsReviewPropsUsrs['id_prp']; ?>&amp;KT_back=1" class="btn btn-success btn-sm btn-block"><i class="fa-regular fa-eye"></i></a></td>

                                            </tr>
                                            <?php } while ($row_rsReviewPropsUsrs = mysqli_fetch_assoc($rsReviewPropsUsrs)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="card position-relative" id="history">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-landmark"></i> <?php echo __('Historialpropiedades'); ?></h4>
                                <div class="flex-shrink-0">
                                    <a href="/intramedianet/properties/history.php" class="btn btn-primary btn-sm"><i class="fa-regular fa-landmark me-1"></i> <?php __('Historialpropiedades'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-bordered align-middle" width="100%">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Referencia'); ?></th>
                                          <th><?php __('Usuario'); ?></th>
                                          <th><?php __('Fecha'); ?></th>
                                          <th><?php __('Acción'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php if ($row_rsHistorial) { ?>
                                        <?php do { ?>
                                        <tr>
                                          <td><?php echo $row_rsHistorial['referencia_log'] ?></td>
                                          <td><?php echo $row_rsHistorial['nombre_usr'] ?></td  >
                                          <td><?php echo date("d-m-Y", strtotime($row_rsHistorial['date_log'])); ?></td>
                                          <td class="text-center"><?php
                                              switch ($row_rsHistorial['action_log']) {
                                                case '1':
                                                  echo '<span class="badge bg-success">' . __('Añadido', true) . '</span>';
                                                  break;
                                                case '2':
                                                  echo '<span class="badge bg-info">' . __('Editado', true) . '</span>';
                                                  break;
                                                case '3':
                                                  echo '<span class="badge bg-info">' . __('Editado: Bajada de precio', true) . '</span>';
                                                  break;
                                                case '4':
                                                  echo '<span class="badge bg-warning">' . __('Editado: Subida de precio', true) . '</span>';
                                                  break;
                                                case '5':
                                                  echo '<span class="badge bg-danger">' . __('Borrado', true) . '</span>';
                                                  break;
                                              }
                                          ?></td>
                                        </tr>
                                        <?php } while ($row_rsHistorial = mysqli_fetch_assoc($rsHistorial)); ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card position-relative" id="emails">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-paper-plane"></i> <?php echo __('Envío de propiedades a clientes'); ?></h4>
                                <div class="flex-shrink-0">
                                    <a href="/intramedianet/seguimiento/emails.php" class="btn btn-primary btn-sm"><?php __('Ver todos'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display table table-bordered align-middle" width="100%">
                                      <thead class="table-light">
                                        <tr>
                                          <th><?php __('Referencia'); ?></th>
                                          <th><?php __('Cliente'); ?></th>
                                          <th><?php __('Email'); ?></th>
                                          <th><?php __('Enviado'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php if ($row_rsEmails) { ?>
                                        <?php do { ?>
                                        <tr>
                                          <td><?php echo $row_rsEmails['prop_id_log'] ?></td  >
                                          <td><?php echo $row_rsEmails['send_id_log'] ?></td>
                                          <td><?php echo $row_rsEmails['email_log'] ?></td>
                                          <td><?php echo date("d-m-Y", strtotime($row_rsEmails['date_log'])); ?></td>
                                        </tr>
                                        <?php } while ($row_rsEmails = mysqli_fetch_assoc($rsEmails)); ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6" id="section2">

                        <div class="card position-relative" id="propest">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><img src="/intramedianet/includes/assets/imgs/mls.png" alt="<?php echo __('MLS Mediaelx'); ?>" style="height: 18px;" class="mt-n1"> <?php echo __('MLS Mediaelx'); ?></h4>
                                <div class="flex-shrink-0">
                                    <a href="https://mediaelxmls.com/<?php echo $lang_adm ?>/" class="btn btn-primary btn-sm" target="_blank"><i class="fa-regular fa-circle-info me-1"></i> <?php __('Más información'); ?></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card crm-widget bg-light m-0">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><?php __('Exportadas'); ?></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-file-export fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsMLSexported; ?>">0</span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><?php __('Importadas'); ?></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-file-import fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsMLSimported; ?>">0</span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div>
                            </div>
                        </div>

                        <div class="card position-relative" id="propest">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-building"></i> <?php echo __('Inmuebles'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div class="card crm-widget bg-light m-0">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><?php __('Activados'); ?></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-building-circle-check fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalPropActv; ?>"></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg border-end">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><?php __('Propias'); ?></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-building-user fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalPropProp; ?>"></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><?php __('Importadas'); ?></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-file-import fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalPropImport; ?>"></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div>
                            </div>
                        </div>

                        <div class="card position-relative" id="contest">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-envelope"></i> <?php echo __('Consultas'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div class="card crm-widget bg-light m-0">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/properties/enquiries.php"><?php __('Consultas'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-envelope fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalContact; ?>"><a style="display: block;" href="/intramedianet/properties/enquiries.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg border-end">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/properties/bajada.php"><?php __('Bajada de precios'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-money-bill-trend-up fa-rotate-180 fa-flip-vertical fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalBajada; ?>"><a style="display: block;" href="/intramedianet/properties/bajada.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/properties/consultas.php"><?php __('Formulario de contacto'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-address-card fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalContactForm; ?>"><a style="display: block;" href="/intramedianet/properties/consultas.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div>
                            </div>
                        </div>

                        <div class="card position-relative" id="callsest">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-phone"></i> <?php echo __('Llamadas'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div class="card crm-widget bg-light m-0 mb-3">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/clients.php"><?php __('Clientes'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-house-person-return fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalCliCalls; ?>"><a style="display: block;" href="/intramedianet/properties/enquiries.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg border-end">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/clients.php"><?php __('Vencidas'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-calendar-circle-exclamation fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalCliCallsPend; ?>"><a style="display: block;" href="/intramedianet/properties/bajada.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/clients.php"><?php __('Próximas'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-calendar-clock fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo $totalRows_rsTotalCliCallsNext; ?>"><a style="display: block;" href="/intramedianet/properties/consultas.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div>
                                <div class="card crm-widget bg-light m-0">
                                    <div class="card-body p-0">
                                        <div class="row row-cols-md-3 row-cols-1">
                                            <div class="col col-lg border-end">
                                                <div class="py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/owners.php"><?php __('Propietarios'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-house-person-leave fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo number_format($totalRows_rsTotalOwnerCalls, 0, '.', ','); ?>"><a style="display: block;" href="/intramedianet/properties/enquiries.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg border-end">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/owners.php"><?php __('Vencidas'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-calendar-circle-exclamation fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo number_format($totalRows_rsTotalOwnerCallsPend, 0, '.', ','); ?>"><a style="display: block;" href="/intramedianet/properties/bajada.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col col-lg">
                                                <div class="mt-3 mt-md-0 py-4 px-3">
                                                    <h5 class="text-muted text-uppercase fs-13"><a style="display: block;" href="/intramedianet/llamadas/owners.php"><?php __('Próximas'); ?></a></h5>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <i class="fa-regular fa-calendar-clock fs-4 text-primary fw-light"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h2 class="mb-0 fw-light"><span class="counter-value" data-target="<?php echo number_format($totalRows_rsTotalOwnerCallsNext, 0, '.', ','); ?>"><a style="display: block;" href="/intramedianet/properties/consultas.php">0</a></span></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div><!-- end card body -->
                                </div>
                            </div>
                        </div>

                        <?php if($totalRows_rsLocations > 0) { ?>
                        <div class="card position-relative" id="chart-loc">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Localizacion'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="locations-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsTipos > 0) { ?>
                        <div class="card position-relative" id="chart-tip">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Tipos'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="tipos-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsOperations > 0) { ?>
                        <div class="card position-relative" id="chart-ope">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('operación'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="operations-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsActivos > 0) { ?>
                        <div class="card position-relative" id="chart-act">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Activado'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="activos-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsNacionalidades > 0) { ?>
                        <div class="card position-relative" id="chart-nac">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Nacionalidades de los clientes'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="nacionalidades-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsCaptado > 0) { ?>
                        <div class="card position-relative" id="chart-cap">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Captado por'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="captado-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($totalRows_rsImportados > 0) { ?>

                        <?php if($xmlImport == 1) { ?>
                        <div class="card position-relative" id="chart-imp">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-chart-pie"></i> <?php __('Top 10'); ?> <?php __('Propiedades importada'); ?></h4>
                                <div class="flex-shrink-0"></div>
                            </div>
                            <div class="card-body">
                                <div id="importados-chart" class="e-charts" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php } ?>

                    </div> <!--/#section2 -->

                </div>

            </div> <!--/.sortable -->

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

    <script>
    var AppLang = '<?php echo $lang_adm ?>';
    var next31 = '<?php __('Próximos 31 días'); ?>';
    var Allevents = '<?php __('Todos'); ?>';
    var $eventBgColor = '<?php echo $eventBgColor; ?>';
    </script>

    <script src="/intramedianet/includes/assets/libs/echarts/echarts.min2.js" type="text/javascript"></script>

    <script src="_js/dashboard.js?id=<?php echo time(); ?>" type="text/javascript"></script>

    <!-- <script src="/intramedianet/includes/assets/js/source/amcharts5/index.js" type="text/javascript"></script>
    <script src="/intramedianet/includes/assets/js/source/amcharts5/percent.js" type="text/javascript"></script>
    <script src="/intramedianet/includes/assets/js/source/amcharts5/themes/Animated.js" type="text/javascript"></script>
    <script src="/intramedianet/includes/assets/js/source/amcharts5/fonts/notosans-sc.js" type="text/javascript"></script> -->



    <script>
        var counterValue = document.querySelector('.counter-value');
        if (counterValue) {

            (counter = document.querySelectorAll(".counter-value")),
            (speed = 250);
            counter &&
                Array.from(counter).forEach(function (a) {
                    !(function e() {
                        var t = +a.getAttribute("data-target"),
                            n = +a.innerText,
                            o = t / speed;
                        o < 1 && (o = 1),
                            n < t ?
                            ((a.innerText = (n + o).toFixed(0)), setTimeout(e, 1)) :
                            (a.innerText = t);
                    })();
                });
        }

        function getChartColorsArray(chartId) {
          if (document.getElementById(chartId) !== null) {
              var colors = document.getElementById(chartId).getAttribute("data-colors");
              colors = JSON.parse(colors);
              return colors.map(function (value) {
                  var newValue = value.replace(" ", "");
                  if (newValue.indexOf(",") === -1) {
                      var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                      if (color) return color; else return newValue;;
                  } else {
                      var val = value.split(',');
                      if(val.length == 2){
                          var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                          rgbaColor = "rgba("+rgbaColor+","+val[1]+")";
                          return rgbaColor;
                      } else {
                          return newValue;
                      }
                  }
              });
          }
        }
        function showChart(elm, data, text) {
            var chartDom = document.getElementById(elm);
            var myChart = echarts.init(chartDom);
            var option;

            option = {
                tooltip: {
                    trigger: 'item',
                    formatter: '<b>{a0}:</b><br>{b0}: {c0} ({d0}%)'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    // formatter: '{b0}: ({d}%)',
                    textStyle: {
                        color: 'rgb(64, 81, 137)',
                    },
                },
                // color: ['#C1232B','#27727B','#FCCE10','#E87C25','#B5C334','#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD','#D7504B','#C6E579','#F4E001','#F0805A','  #26C0C0'],
                color: ['#252f38','#0ab39c','#f7b84b','#f06548','#299cdb'],
                series: [{
                    name: text,
                    type: 'pie',
                    radius: '40%',
                    center: ['60%', '50%'],
                    data: data,
                    label: {
                        formatter: '{b}: ({d}%)',
                    },
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }],
                textStyle: {
                    fontFamily: 'Poppins, sans-serif'
                },
            };

            option && myChart.setOption(option);

        }

        <?php if($totalRows_rsLocations > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsLocations['total'] ?>,
                        name: '<?php echo $row_rsLocations['sname'] ?>'
                    },
                    <?php } while ($row_rsLocations = mysqli_fetch_assoc($rsLocations)); ?>
                    ];
            showChart('locations-chart', data, '<?php __('Localizacion'); ?>');
        <?php } ?>

        <?php if($totalRows_rsActivos > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsActivos['total'] ?>,
                        name: '<?php echo $row_rsActivos['name'] ?>'
                    },
                    <?php } while ($row_rsActivos = mysqli_fetch_assoc($rsActivos)); ?>
                    ];
            showChart('activos-chart', data, '<?php __('Activado'); ?>');
        <?php } ?>

        <?php if($totalRows_rsTipos > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsTipos['total'] ?>,
                        name: '<?php echo $row_rsTipos['name'] ?>'
                    },
                    <?php } while ($row_rsTipos = mysqli_fetch_assoc($rsTipos)); ?>
                    ];
            showChart('tipos-chart', data, '<?php __('Tipos'); ?>');
        <?php } ?>

        <?php if($totalRows_rsOperations > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsOperations['total'] ?>,
                        name: '<?php echo $row_rsOperations['name'] ?>'
                    },
                    <?php } while ($row_rsOperations = mysqli_fetch_assoc($rsOperations)); ?>
                    ];
            showChart('operations-chart', data, '<?php __('operación'); ?>');
        <?php } ?>

        <?php if($xmlImport == 1) { ?>
        <?php if($totalRows_rsImportados > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsImportados['total'] ?>,
                        name: '<?php echo $row_rsImportados['name'] ?>'
                    },
                    <?php } while ($row_rsImportados = mysqli_fetch_assoc($rsImportados)); ?>
                    ];
            showChart('importados-chart', data, '<?php __('Propiedades importada'); ?>');
        <?php } ?>
        <?php } ?>

        <?php if($totalRows_rsNacionalidades > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsNacionalidades['total'] ?>,
                        name: '<?php echo $row_rsNacionalidades['name'] ?>'
                    },
                    <?php } while ($row_rsNacionalidades = mysqli_fetch_assoc($rsNacionalidades)); ?>
                    ];
            showChart('nacionalidades-chart', data, '<?php __('Nacionalidades de los clientes'); ?>');
        <?php } ?>

        <?php if($totalRows_rsCaptado > 0) { ?>
            data =  [
                    <?php do { ?>
                    {
                        value: <?php echo $row_rsCaptado['total'] ?>,
                        name: '<?php echo $row_rsCaptado['name'] ?>'
                    },
                    <?php } while ($row_rsCaptado = mysqli_fetch_assoc($rsCaptado)); ?>
                    ];
            showChart('captado-chart', data, '<?php __('Captado por'); ?>');
        <?php } ?>
    </script>

    <div id="myModal3" class="modal fade" tabindex="-1" aria-labelledby="myModal3Label" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div id="event-text"></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white pb-3" id="myModalLabel"><i class="fa-regular fa-calendar-circle-plus me-2 fs-4"></i> <?php __('Añadir cita'); ?></h5>
                    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" class="needs-validation" novalidate>
                <div class="modal-body bg-light">


                    <div class="row">

                        <div class="col-md-7">

                            <div class="mb-4">
                                <label for="titulo_ct" class="form-label"><?php __('Título'); ?>:</label>
                                <input type="text" name="titulo_ct" id="titulo_ct" value="" size="32" maxlength="255" class="form-control  required" required>
                                <input type="hidden" name="id_ct" id="id_ct" value="">
                            </div>

                            <div class="row">

                              <div class="col-md-6">

                                  <div class="mb-4">
                                      <label for="inicio_ct" class="form-label"><?php __('Fecha inicio'); ?>:</label>
                                      <input type="text" name="inicio_ct" id="inicio_ct" value="" size="32" maxlength="255" class="form-control required datepicktime " data-provider="flatpickr" data-date-format="d-m-Y" required>
                                  </div>

                              </div>

                              <div class="col-md-6">

                                  <div class="mb-4">
                                      <label for="final_ct" class="form-label"><?php __('Fecha final'); ?>:</label>
                                      <input type="text" name="final_ct" id="final_ct" value="" size="32" maxlength="255" class="form-control required datepicktime " data-provider="flatpickr" data-date-format="d-m-Y" required>
                                  </div>

                              </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="categoria_ct" class="form-label"><?php __('Categoría'); ?>:</label>
                                        <select name="categoria_ct" id="categoria_ct" class="form-control required" required>
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
                                        <select name="user_ct" id="user_ct" class="required select2" required>
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
                                        <input type="text" class="select2clientes" id="users_ct" name="users_ct" value="" tabindex="-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="users_ct" class="form-label"><?php __('Propietario'); ?>:</label>
                                        <input type="text" class="select2vendors" id="vendedores_ct" name="vendedores_ct" value="" tabindex="-1">
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

                </div>
                <div class="modal-footer bg-soft-primary">
                    <a href="#" class="btn btn-success btn-sm mt-4" id="btn-close-save" name="KT_Update1"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar y guardar'); ?>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm mt-4" id="btn-close"><!-- data-dismiss="modal" -->
                    <?php __('Cerrar'); ?>
                    </a>
                </div>
                </form>
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
    });
</script>

</body>
</html>
