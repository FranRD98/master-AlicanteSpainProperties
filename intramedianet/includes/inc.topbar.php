<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon <?php if(isset($_COOKIE['sidebarComp'])) {echo ($_COOKIE['sidebarComp'] == 'sm')?'open':'';}  ?>">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <div class="app-search d-none d-lg-block position-relative">

                    <a href="/intramedianet/properties/properties.php" class="btn btn-link text-uppercase btn-sm waves-effect waves-light mt-n1 <?php if(preg_match('/\/properties\/properties/', $_SERVER['PHP_SELF'])){ ?>btn-soft-primary<?php } ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Inmuebles'); ?>"><?php __('Inmuebles'); ?></a>

                    <i class="fa-regular fa-pipe mt-3"></i>

                    <?php if($actClients == 1) { ?>
                    <a href="/intramedianet/properties/clients.php" class="btn btn-link text-uppercase btn-sm waves-effect waves-light mt-n1 <?php if(preg_match('/\/properties\/clients.php/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/clients-form.php/', $_SERVER['PHP_SELF'])){ ?>btn-soft-primary<?php } ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Clientes'); ?>"><?php __('Clientes'); ?></a>
                    <?php } ?>

                    <i class="fa-regular fa-pipe mt-3"></i>

                    <?php if($actPropietarios == 1) { ?>
                    <a href="/intramedianet/properties/owners.php" class="btn btn-link text-uppercase btn-sm waves-effect waves-light mt-n1 <?php if(preg_match('/\/properties\/owners.php/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/owners-form.php/', $_SERVER['PHP_SELF'])){ ?>btn-soft-primary<?php } ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Propietarios'); ?>"><?php __('Propietarios'); ?></a>
                    <?php } ?>

                    <i class="fa-regular fa-pipe mt-3"></i>

                    <a href="/intramedianet/asistencia/index.php" class="btn btn-link text-uppercase btn-sm waves-effect waves-light mt-n1 <?php if(preg_match('/\/asistencia/', $_SERVER['PHP_SELF'])){ ?>btn-soft-primary<?php } ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php __('Asistencia'); ?>"><?php __('Asistencia'); ?></a>

                </div>
            </div>

            <div class="d-flex align-items-center">

                <?php if ($actClients == 1 || $actPropietarios == 1): ?>
                    <?php

                    if ($_SESSION['kt_login_level'] == 9) {
                            $query_rsLlamadasDeman = "
                            SELECT
                             id_cli
                            FROM   properties_client
                            WHERE next_call_cli != '' AND next_call_cli <= NOW()
                            ORDER BY next_call_cli ASC
                            ";
                            $rsLlamadasDeman = $inmoconn->query($query_rsLlamadasDeman); if(!$rsLlamadasDeman) {die("Error en la consulta: " . $inmoconn->error);}
                            $row_rsLlamadasDeman = mysqli_fetch_assoc($rsLlamadasDeman);
                            $totalRows_rsLlamadasDeman = mysqli_num_rows($rsLlamadasDeman);

                            $query_rsLlamadasProp = "
                            SELECT
                                id_pro
                                FROM properties_owner
                                WHERE next_call_pro != '0000-00-00'  AND next_call_pro <= NOW()
                                ORDER BY next_call_pro ASC
                            ";
                            $rsLlamadasProp = $inmoconn->query($query_rsLlamadasProp); if(!$rsLlamadasProp) {die("Error en la consulta: " . $inmoconn->error);}
                            $row_rsLlamadasProp = mysqli_fetch_assoc($rsLlamadasProp);
                            $totalRows_rsLlamadasProp = mysqli_num_rows($rsLlamadasProp);
                      } else {
                            $query_rsLlamadasDeman = "
                                SELECT SQL_CALC_FOUND_ROWS
                                 id_cli
                                FROM properties_client
                                 WHERE next_call_cli != ''  AND atendido_por_cli = '".$_SESSION['kt_login_id']."'
                            ";
                            $rsLlamadasDeman = $inmoconn->query($query_rsLlamadasDeman); if(!$rsLlamadasDeman) {die("Error en la consulta: " . $inmoconn->error);}
                            $row_rsLlamadasDeman = mysqli_fetch_assoc($rsLlamadasDeman);
                            $totalRows_rsLlamadasDeman = mysqli_num_rows($rsLlamadasDeman);

                            $query_rsLlamadasProp = "
                            SELECT
                                id_pro
                                FROM properties_owner
                                WHERE next_call_pro != '0000-00-00'  AND next_call_pro <= NOW()
                                ORDER BY next_call_pro ASC
                            ";
                            $rsLlamadasProp = $inmoconn->query($query_rsLlamadasProp); if(!$rsLlamadasProp) {die("Error en la consulta: " . $inmoconn->error);}
                            $row_rsLlamadasProp = mysqli_fetch_assoc($rsLlamadasProp);
                            $totalRows_rsLlamadasProp = mysqli_num_rows($rsLlamadasProp);
                        if($sWhere != '') {
                            $sWhere .= " AND  next_call_pro != ''  AND captado_por_pro = '" . $_SESSION['kt_login_id'] . "' "; //
                        } else {
                            $sWhere .= "  WHERE  next_call_pro != ''  AND captado_por_pro = '" . $_SESSION['kt_login_id']. "' "; //
                        }
                      }

                    ?>
                    <div class="ms-1 header-item">
                        <a href="/intramedianet/llamadas/clients.php" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                            <i class="fa-regular fa-phone fs-22 fw- fw-light"></i>
                            <?php if($totalRows_rsLlamadasDeman > 0 || $totalRows_rsLlamadasProp > 0) { ?>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?></span>
                            <?php } ?>
                        </a>
                    </div>
                <?php endif ?>

                <?php if ($actTasks == 1) { ?>
                    <?php
                    $sWhere = ' WHERE DATE(date_due_tsk) <= CURRENT_DATE() AND status_tsk != 2 ';
                    if ($_SESSION['kt_login_level'] < 9) {
                        $sWhere .= ' AND admin_tsk = ' . $_SESSION['kt_login_id'];
                    }
                    
                    $query_rsTotalTareas = "
                    SELECT
                        id_tsk
                    FROM tasks
                    $sWhere
                    ";
                    
                    $rsTotalTareas = $inmoconn->query($query_rsTotalTareas); if(!$rsTotalTareas) {die("Error en la consulta: " . $inmoconn->error);}
                    $row_rsTotalTareas = mysqli_fetch_assoc($rsTotalTareas);
                    $totalRows_rsTotalTareas = mysqli_num_rows($rsTotalTareas);
                    
                    ?>
                    <div class="ms-1 header-item">
                        <a href="/intramedianet/tasks/tasks.php" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                            <i class="fa-regular fa-list-check fs-22 fw- fw-light"></i>
                            <?php if($totalRows_rsTotalTareas > 0) { ?><span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php echo $totalRows_rsTotalTareas; ?></span><?php } ?>
                        </a>
                    </div>
                <?php } ?>

                <?php if ($actCalendar == 1): ?>
                <?php
                if ($_SESSION['kt_login_level'] == 9) {
                    $query_rsTotalEventos = "SELECT citas.id_ct, citas_categories.category_en_ct, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC";
                    $rsTotalEventos = $inmoconn->query($query_rsTotalEventos); if(!$rsTotalEventos) {die("Error en la consulta: " . $inmoconn->error);}
                    $row_rsTotalEventos = mysqli_fetch_assoc($rsTotalEventos);
                    $totalRows_rsTotalEventos = mysqli_num_rows($rsTotalEventos);
                } else {
                    $query_rsTotalEventos = "SELECT citas.id_ct, citas_categories.category_en_ct, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() AND user_ct = '".$_SESSION['kt_login_id']."' ORDER BY citas.inicio_ct ASC";
                    $rsTotalEventos = $inmoconn->query($query_rsTotalEventos); if(!$rsTotalEventos) {die("Error en la consulta: " . $inmoconn->error);}
                    $row_rsTotalEventos = mysqli_fetch_assoc($rsTotalEventos);
                    $totalRows_rsTotalEventos = mysqli_num_rows($rsTotalEventos);
                }
                ?>
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-bell fs-22 fw- fw-light"></i>
                        <?php if($totalRows_rsTotalEventos > 0) { ?>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php echo $totalRows_rsTotalEventos; ?></span>
                        <?php } ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> <?php __('Calendario'); ?> </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <?php if($totalRows_rsTotalEventos > 0) { ?>
                                            <span class="badge badge-soft-light fs-13"> <?php echo $totalRows_rsTotalEventos; ?> <?php __('Nuevos'); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <?php if ($totalRows_rsTotalEventos > 0): ?>
                                    <?php
                                    $query_rsEventosMenu = "SELECT citas.id_ct, citas_categories.category_" . $lang_adm . "_ct as cat, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC LIMIT 15";
                                    $rsEventosMenu = $inmoconn->query($query_rsEventosMenu); if(!$rsEventosMenu) {die("Error en la consulta: " . $inmoconn->error);}
                                    $row_rsEventosMenu = mysqli_fetch_assoc($rsEventosMenu);
                                    $totalRows_rsEventosMenu = mysqli_num_rows($rsEventosMenu);
                                    ?>
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <?php do { ?>
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title <?php if(date("d-m-Y", strtotime($row_rsEventosMenu['inicio_ct'])) == date("d-m-Y")) { ?>bg-soft-success text-success<?php } else { ?>bg-soft-info text-info<?php } ?> rounded-circle fs-16">
                                                    <i class="fa-regular fa-calendar-clock"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="/intramedianet/calendar/calendario.php?cit=<?php echo $row_rsEventosMenu['id_ct'] ?>" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">
                                                        <?php echo $row_rsEventosMenu['titulo_ct'] ?>
                                                        <small class="d-block text-uppercase text-muted"><?php echo $row_rsEventosMenu['cat'] ?> </small>
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <i class="fa-regular fa-clock me-"></i> <?php echo date("d-m-Y", strtotime($row_rsEventosMenu['inicio_ct'])) ?> // <?php echo date("d-m-Y", strtotime($row_rsEventosMenu['final_ct'])) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } while ($row_rsEventosMenu = mysqli_fetch_assoc($rsEventosMenu)); ?>
                                    </div>

                                <?php else: ?>
                                <div class="empty-notification-elem">
                                    <div class="w-25 w-sm-50 pt-3 mx-auto text-danger">
                                        <i class="fa-regular fa-bells display-4"></i>
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base"><?php __('No hay eventos que mostrar'); ?> </h6>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="text-center view-all bg-soft-primary ms-n2 mb-n2 rounded-bottom">
                                    <a href="/intramedianet/calendar/calendario.php" class="btn btn-primary waves-effect waves-light m-3">
                                        <?php __('Administrar eventos'); ?> <i class="ri-arrow-right-line align-middle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <?php
                $query_rsbajadasCount = "
                    SELECT
                    properties_bajada.id_baj,
                    properties_properties.referencia_prop as prop_baj,
                    properties_bajada.name_baj,
                    properties_bajada.email_baj,
                    properties_bajada.phone_baj,
                    properties_bajada.lang_baj,
                    properties_bajada.date_baj,
                    email_cli
                    FROM properties_bajada
                    INNER JOIN properties_properties ON properties_bajada.prop_baj = properties_properties.id_prop
                    LEFT OUTER JOIN properties_client ON properties_bajada.email_baj = properties_client.email_cli
                    WHERE email_cli is null
                ";
                $rsbajadasCount = $inmoconn->query($query_rsbajadasCount); if(!$rsbajadasCount) {die("Error en la consulta: " . $inmoconn->error);}
                $row_rsbajadasCount = mysqli_fetch_assoc($rsbajadasCount);
                $totalRows_rsbajadasCount = mysqli_num_rows($rsbajadasCount);

                $query_rsConsultasCount = "SELECT SQL_CALC_FOUND_ROWS properties_consultas_log.id_con, text_con, properties_consultas_log.name_con, properties_consultas_log.email_con, properties_consultas_log.phone_con, properties_consultas_log.lang_con, properties_consultas_log.date_con, properties_consultas_log.lang_con as lang_sort FROM properties_consultas_log ";
                $rsConsultasCount = $inmoconn->query($query_rsConsultasCount); if(!$rsConsultasCount) {die("Error en la consulta: " . $inmoconn->error);}
                $row_rsConsultasCount = mysqli_fetch_assoc($rsConsultasCount);
                $totalRows_rsConsultasCount = mysqli_num_rows($rsConsultasCount);

                $query_rsConsultasWhatsapp = "SELECT SQL_CALC_FOUND_ROWS whatsapp_log.id_con, text_con, whatsapp_log.name_con, whatsapp_log.phone_con, whatsapp_log.lang_con, whatsapp_log.date_con, whatsapp_log.lang_con as lang_sort FROM whatsapp_log ";
                $rsConsultasWhatsapp = $inmoconn->query($query_rsConsultasWhatsapp); if(!$rsConsultasWhatsapp) {die("Error en la consulta: " . $inmoconn->error);}
                $row_rsConsultasWhatsapp = mysqli_fetch_assoc($rsConsultasWhatsapp);
                $totalRows_rsConsultasWhatsapp = mysqli_num_rows($rsConsultasWhatsapp);

                $query_rsConsultas = "SELECT * FROM properties_enquiries WHERE read_cons = 0";
                $rsConsultas = $inmoconn->query($query_rsConsultas); if(!$rsConsultas) {die("Error en la consulta: " . $inmoconn->error);}
                $row_rsConsultas = mysqli_fetch_assoc($rsConsultas);
                $totalRows_rsConsultas = mysqli_num_rows($rsConsultas);
                ?>
                <div class="ms-1 header-item">
                    <a href="/intramedianet/properties/enquiries.php" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle">
                        <i class="fa-regular fa-envelope fs-22 fw- fw-light"></i>
                        <?php $totconsultasCount = $totalRows_rsConsultas + $totalRows_rsbajadasCount + $totalRows_rsConsultasCount + $totalRows_rsConsultasWhatsapp; ?>
                        <?php if($totconsultasCount > 0) { ?><span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php echo $totconsultasCount; ?></span><?php } ?>
                    </a>
                </div>
                <?php /* ?>
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-envelope fs-22 fw- fw-light"></i>
                        <?php if($totalRows_rsConsultas > 0) { ?>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php echo $totalRows_rsConsultas + $totalRows_rsbajadasCount + $totalRows_rsConsultasCount; ?></span>
                        <?php } ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> <?php __('Consultas'); ?> </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <?php if($totalRows_rsConsultas > 0) { ?>
                                            <span class="badge badge-soft-light fs-13"> <?php echo $totalRows_rsConsultas; ?> <?php __('Nuevos'); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <?php if ($totalRows_rsConsultas > 0): ?>
                                    <?php
                                    mysqli_select_db($database_inmoconn, $inmoconn);
                                    $query_rsConsultasMenu = "SELECT properties_enquiries.id_cons, properties_properties.referencia_prop, properties_enquiries.nombre_cons, (SELECT id_img FROM properties_images WHERE property_img = id_prop ORDER BY order_img LIMIT 1) as id_img, properties_enquiries.fecha_cons, properties_enquiries.read_cons FROM properties_enquiries  INNER JOIN properties_properties ON properties_enquiries.inmueble_cons = properties_properties.id_prop ORDER BY properties_enquiries.fecha_cons DESC LIMIT 5";
                                    $rsConsultasMenu = mysqli_query($query_rsConsultasMenu, $inmoconn) or die(mysqli_error());
                                    $row_rsConsultasMenu = mysqli_fetch_assoc($rsConsultasMenu);
                                    $totalRows_rsConsultasMenu = mysqli_num_rows($rsConsultasMenu);
                                    ?>
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <?php do { ?>
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title rounded-circle- fs-16">
                                                    <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsConsultasMenu['id_img'] .'_md.jpg')) { ?>
                                                        <img src="/media/images/properties/thumbnails/<?php echo $row_rsConsultasMenu['id_img'] ?>_sm.jpg" alt="" class="rounded-2" style="height: 40px !important;">
                                                    <?php } else { ?>
                                                        <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="" class="rounded-2" style="height: 40px !important;">
                                                    <?php } ?>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="/intramedianet/properties/enquiries-form.php?id_cons=<?php echo $row_rsConsultasMenu['id_cons'] ?>&amp;KT_back=1" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">
                                                        <?php __('Ref.'); ?>: <?php echo $row_rsConsultasMenu['referencia_prop'] ?>
                                                        <small class="d-block text-uppercase text-muted"><?php echo $row_rsConsultasMenu['nombre_cons'] ?></small>
                                                        <?php if($row_rsConsultasMenu['read_cons'] == 0) { ?>
                                                            <span class="position-absolute topbar-badge mt-2 fs-10 translate-middle badge rounded-pill bg-danger"><?php __('Nuevo'); ?></span>
                                                        <?php } else { ?>
                                                        <span class="position-absolute topbar-badge mt-2 fs-10 translate-middle badge rounded-pill bg-danger"><?php __('Leido'); ?></span>
                                                        <?php } ?>
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <i class="fa-regular fa-clock me-"></i> <?php echo relativeTime( strtotime($row_rsConsultasMenu['fecha_cons']) ) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } while ($row_rsConsultasMenu = mysqli_fetch_assoc($rsConsultasMenu)); ?>
                                    </div>

                                <?php else: ?>
                                <div class="empty-notification-elem">
                                    <div class="w-25 w-sm-40 pt-3 mx-auto text-danger">
                                        <i class="fa-regular fa-envelopes-bulk display-4"></i>
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base"><?php __('No hay consultas que mostrar'); ?> </h6>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="text-center view-all bg-soft-primary ms-n2 mb-n2 rounded-bottom">
                                    <a href="/intramedianet/properties/enquiries.php" class="btn btn-primary waves-effect waves-light m-3 ms-n3">
                                        <?php __('Administrar consultas'); ?> <i class="ri-arrow-right-line align-middle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php */ ?>

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown topbar-head-dropdown ms-1 header-item d-none d-md-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-regular fa-grid-2 fs-22 fw-light"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fw-semibold fs-15"><?php __('Enlaces de interés'); ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="p-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="http://mlsmediaelx.com" target="_blank">
                                        <img src="/intramedianet/includes/assets/img/mls-mediaelx.svg" alt="" class="w-75">
                                        <span>MLS - Mediaelx </span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="https://acumbamail.com" target="_blank">
                                        <img src="/intramedianet/includes/assets/img/acumbamail.svg" alt="" class="w-75">
                                        <span>Acumbamail</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="https://analytics.google.com" target="_blank">
                                        <img src="/intramedianet/includes/assets/img/g_analytics.svg" alt="" class="w-75">
                                        <span>Google Analytics</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="https://search.google.com/" target="_blank">
                                        <img src="/intramedianet/includes/assets/img/g_search_console.svg" alt="" class="w-75">
                                        <span>Search Console</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="/intramedianet/includes/assets//images/flags/<?php echo $lang_adm; ?>.svg" alt="Header Language" height="20"
                            class="rounded">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'en'); ?>" class="dropdown-item notify-item language py-2" data-lang="en"
                            title="English">
                            <img src="/intramedianet/includes/assets//images/flags/en.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'es'); ?>" class="dropdown-item notify-item language py-2 language" data-lang="sp"
                            title="Spanish">
                            <img src="/intramedianet/includes/assets//images/flags/es.svg" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">Español</span>
                        </a>
                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <a href="/" class="btn btn-icon btn-topbar btn-sitemap rounded-circle" target="_blank">
                        <i class='fa-regular fa-sitemap fs-22 fw-light'></i>
                    </a>
                </div>

                <!-- <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div> -->

                <?php
                function getUserLevel($level) {
                    switch ($level) {
                        case '10':
                            return __('Superadmin', true);
                            break;
                        case '9':
                            return __('Administrador', true);
                            break;
                        case '8':
                            return __('Empleado', true);
                            break;
                        case '7':
                            return __('Agente', true);
                            break;
                        default:
                            return '';
                            break;
                    }
                }
                ?>

                <?php
                $query_rsAdminIMG = "SELECT * FROM users WHERE id_usr = '".$_SESSION['kt_login_id']."'";
                $rsAdminIMG = $inmoconn->query($query_rsAdminIMG); if(!$rsAdminIMG) {die("Error en la consulta: " . $inmoconn->error);}
                $row_rsAdminIMG = mysqli_fetch_assoc($rsAdminIMG);
                $totalRows_rsAdminIMG = mysqli_num_rows($rsAdminIMG);
                ?>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <?php if ($_SERVER["DOCUMENT_ROOT"] . '/media/images/users/' . $row_rsAdminIMG['image_usr'] && $row_rsAdminIMG['image_usr'] != ''): ?>
                                <img src="/media/images/users/<?php echo $row_rsAdminIMG['image_usr'] ?>?id=<?php echo time(); ?>" class="rounded-circle header-profile-user" alt="<?php echo $_SESSION['kt_login_name'] ?>" />
                            <?php else: ?>
                                <img src="/intramedianet/includes/assets/imgs/user-dummy-img.jpg" id="product-img" class="rounded-circle header-profile-user" alt="<?php echo $_SESSION['kt_login_name'] ?>">
                            <?php endif ?>
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $_SESSION['kt_login_name'] ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo getUserLevel($_SESSION['kt_login_level']) ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"><?php echo __('Bienvenido'); ?> <?php echo $_SESSION['kt_login_name'] ?></h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/" target="_blank">
                            <i class="fa-solid fa-browser text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"><?php __('Ir a la Web'); ?></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/intramedianet/users/users-form.php?id_usr=<?php echo $_SESSION['kt_login_id'] ?>&KT_back=1">
                            <i class="fa-solid fa-circle-user text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle"><?php __('Tu cuenta'); ?></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/intramedianet/logout.php">
                            <i class="fa-solid fa-right-from-bracket fa-fw text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key=t-logout><?php __('Desconectar'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

