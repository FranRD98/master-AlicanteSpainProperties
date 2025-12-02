<div id="wrapper">

    <div class="navbar navbar-default navbar-fixed-topx" role="navigation" id="main-nav">

        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Menú principal'); ?>">
                        <i class="fa fa-align-justify fa-lg"></i>
                        <span class="caret"></span><span class="text-mt hidden-xs hidden-sm"><?php __('Menu'); ?></span>
                    </a>
                    <div class="dropdown-menu animated zoomIn" role="menu" id="mega-menu">

                        <a href="/intramedianet/inicio/inicio.php" <?php if(preg_match('/\/inicio\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-tachometer fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Inicio'); ?>
                        </a>

                        <div class="divider"></div>

                        <a href="/intramedianet/properties/properties.php?KT_back=1" <?php if(preg_match('/\/properties\/properties/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Inmuebles'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <?php if ($actNewsletter == 1) { ?>
                        <a href="/intramedianet/newsletter/index.php" <?php if(preg_match('/\/newsletter/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Newsletter'); ?>
                            </a>
                        <?php } ?>

                    </div>
                </li>

            </ul>
            <ul class="nav navbar-nav nav-favs">
                <li class="dropdown hidden-xs withtext">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Buscar'); ?>"> <i class="fa fa-search"></i> <span class="caret"></span><span class="text-mt hidden-xs hidden-sm"><?php __('Buscar'); ?></span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn" role="menu">
                        <li><a href="/intramedianet/properties/search-properties.php?KT_back=1"><i class="fa fa-fw fa-building-o"></i> <?php __('Buscar propiedades'); ?></a></li>
                        <?php if($actClients == 1) { ?>
                            <li><a href="/intramedianet/properties/clients-search.php?KT_back=1"><i class="fa fa-fw fa-users"></i> <?php __('Buscar'); ?> <?php __('Cliente'); ?></a></li>
                        <?php } ?>
                        <?php if($actPropietarios == 1) { ?>
                            <li><a href="/intramedianet/properties/owners-search.php?KT_back=1"><i class="fa fa-fw fa-key"></i> <?php __('Buscar'); ?> <?php __('propietario'); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown hidden-xs withtext">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Añadir'); ?>"> <i class="fa fa-plus"></i> <span class="caret"></span><span class="text-mt hidden-xs hidden-sm"><?php __('Añadir'); ?></span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn" role="menu">
                        <li><a href="#" data-toggle="modal" data-target="#myModalProp"><i class="fa fa-fw fa-building-o"></i> <?php __('Añadir'); ?>  <?php __('inmueble'); ?></a></li>
                        <?php if($actClients == 1) { ?>
                            <li><a href="#" data-toggle="modal" data-target="#myModalCli"><i class="fa fa-fw fa-users"></i> <?php __('Añadir'); ?>  <?php __('Cliente'); ?></a></li>
                        <?php } ?>
                        <?php if($actPropietarios == 1) { ?>
                            <li><a href="#" data-toggle="modal" data-target="#myModalOwn"><i class="fa fa-fw fa-key"></i> <?php __('Añadir'); ?> <?php __('propietario'); ?></a></li>
                        <?php } ?>
                        <?php if ($actNoticias == 1) { ?>
                            <li><a href="/intramedianet/news/news-form.php?KT_back=1"><i class="fa fa-fw fa-newspaper-o"></i> <?php __('Añadir'); ?> <?php __('Noticia'); ?></a></li>
                        <?php } ?>
                        <?php if ($actTasks == 1) { ?>
                            <li><a href="/intramedianet/tasks/tasks-form.php?KT_back=1"><i class="fa fa-fw fa-tasks"></i> <?php __('Añadir'); ?> <?php __('Tarea'); ?></a></li>
                        <?php } ?>
                        <?php if ($actCalendar == 1) { ?>
                            <li><a href="/intramedianet/calendar/calendario.php?add=ok"><i class="fa fa-fw fa-calendar"></i> <?php __('Añadir cita'); ?></a></li>
                        <?php } ?>
                        <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info' || ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info' && $_SESSION['kt_login_id'] == 47)): ?>
                            <li><a href="/intramedianet/users/users-form.php?KT_back=1"><i class="fa fa-fw fa-user"></i> <?php __('Añadir'); ?> <?php __('Usuario'); ?></a></li>
                        <?php endif ?>
                    </ul>
                </li>
                <li class="withtext"><a href="/intramedianet/properties/properties.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Inmuebles'); ?>"><i class="fa fa-fw fa-building-o"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Inmuebles'); ?></span></a></li>
                <?php if($actClients == 1) { ?>
                <li class="withtext"><a href="/intramedianet/properties/clients.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Clientes'); ?>"><i class="fa fa-fw fa-users"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Clientes'); ?></span></a></li>
                <?php } ?>
                <?php if($actPropietarios == 1) { ?>
                <li class="withtext"><a href="/intramedianet/properties/owners.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Propietarios'); ?>"><i class="fa fa-fw fa-key"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Propietarios'); ?></span></a></li>
                <?php } ?>
                <?php if ($actColaboradores == 1) { ?>
                <li class="withtext"><a href="/intramedianet/properties/collaborators.php" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Colaboradores'); ?>"><i class="fa fa-fw fa-users"></i><span class="text-mt"><?php __('Colaboradores'); ?></span></a></li>
                <?php } ?>
                <?php if ($actNoticias == 1) { ?>
                <li class="withtext"><a href="/intramedianet/news/news.php" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Noticias'); ?>"><i class="fa fa-fw fa-newspaper-o"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Noticias'); ?></span></a></li>
                <?php } ?>
                <?php if ($actContactos == 1) { ?>
                <li class="withtext hidden-xs hidden-sm hidden-md"><a href="/intramedianet/contactos/owners.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Contactos'); ?>"><i class="fa fa-fw fa-male"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Contactos'); ?></span></a></li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if ($actClients == 1 || $actPropietarios == 1) { ?>
                <li class="withtext">
                    <a href="/intramedianet/llamadas/clients.php?KT_back=1" title="<?php __('Llamadas'); ?>"><i class="fa fa-phone
                        "></i>
                        <?php if($totalRows_rsLlamadasDeman > 0 || $totalRows_rsLlamadasProp > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?></span><?php } ?> <span class="text-mt hidden-xs hidden-sm"><?php __('Llamadas'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if ($actTasks == 1) { ?>
                <li class="withtext">
                    <a href="/intramedianet/tasks/tasks.php" class="hidden-xs" title="<?php __('Tareas'); ?>"><i class="fa fa-tasks"></i>
                    <?php if($totalRows_rsTotalTareas > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsTotalTareas; ?></span><?php } ?> <span class="text-mt hidden-xs hidden-sm"><?php __('Tareas'); ?></span></a>
                </li>
                <?php } ?>
                <?php if ($actCalendar == 1) { ?>
                <li class="withtext">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Eventos'); ?>"><i class="fa fa-bell"></i>
                        <?php if($totalRows_rsTotalEventos > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsTotalEventos ?><?php } ?></span> <b class="caret"></b><span class="text-mt hidden-xs hidden-sm"><?php __('Calendario'); ?></span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn" id="notices-menu">
                        <li class="header"><?php __('Eventos'); ?></li>
                        <?php if($totalRows_rsTotalEventos > 0) { ?>
                        <?php
                        $query_rsEventosMenu = "SELECT citas.id_ct, citas_categories.category_" . $lang_adm . "_ct as cat, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC LIMIT 5";
                        $rsEventosMenu = mysqli_query($inmoconn,$query_rsEventosMenu) or die(mysqli_error());
                        $row_rsEventosMenu = mysqli_fetch_assoc($rsEventosMenu);
                        $totalRows_rsEventosMenu = mysqli_num_rows($rsEventosMenu);
                        ?>
                        <li>
                        <?php do { ?>
                        <li class="notice">
                            <a href="/intramedianet/calendar/calendario.php?cit=<?php echo $row_rsEventosMenu['id_ct'] ?>" class="">
                                <span class="date"><i class="fa fa-clock-o"></i> <?php echo date("d-m-Y", strtotime($row_rsEventosMenu['inicio_ct'])) ?> // <?php echo date("d-m-Y", strtotime($row_rsEventosMenu['final_ct'])) ?> // <?php echo $row_rsEventosMenu['cat'] ?> <?php if(date("d-m-Y", strtotime($row_rsEventosMenu['inicio_ct'])) == date("d-m-Y")) { ?> // <span class="label label-danger"><?php __('Hoy'); ?></span><?php } ?></span>
                                <h2><?php echo $row_rsEventosMenu['titulo_ct'] ?></h2>

                                <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                        <?php } while ($row_rsEventosMenu = mysqli_fetch_assoc($rsEventosMenu)); ?>
                        <?php } else { ?>
                        <li class="footer">
                            <p class="lead"><?php __('No hay eventos que mostrar'); ?></p>
                        </li>
                        <?php } ?>
                        <li class="footer">
                            <a href="/intramedianet/calendar/calendario.php" class="btn btn-primary"><?php __('Administrar eventos'); ?></a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <li class="withtext">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Consultas'); ?>"><i class="fa fa-envelope"></i>
                        <?php if($totalRows_rsConsultas > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsConsultas; ?></span><?php } ?> <b class="caret"></b><span class="text-mt hidden-xs hidden-sm"><?php __('Consultas'); ?></span>
                    </a>
                    <?php
                    $query_rsConsultasMenu = "SELECT properties_enquiries.id_cons, properties_properties.referencia_prop, properties_enquiries.nombre_cons, (SELECT id_img FROM properties_images WHERE property_img = id_prop ORDER BY order_img LIMIT 1) as id_img, properties_enquiries.fecha_cons, properties_enquiries.read_cons FROM properties_enquiries  INNER JOIN properties_properties ON properties_enquiries.inmueble_cons = properties_properties.id_prop ORDER BY properties_enquiries.fecha_cons DESC LIMIT 5";
                    $rsConsultasMenu = mysqli_query($inmoconn,$query_rsConsultasMenu) or die(mysqli_error());
                    $row_rsConsultasMenu = mysqli_fetch_assoc($rsConsultasMenu);
                    $totalRows_rsConsultasMenu = mysqli_num_rows($rsConsultasMenu);
                    ?>
                    <ul class="dropdown-menu animated zoomIn" id="enquiries-menu">
                        <li class="header"><?php __('Consultas'); ?></li>
                        <?php if($totalRows_rsConsultasMenu > 0) { ?>
                        <?php do { ?>
                       <li class="enquiry">
                        <a href="/intramedianet/properties/enquiries-form.php?id_cons=<?php echo $row_rsConsultasMenu['id_cons'] ?>&amp;KT_back=1">
                                <?php if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/media/images/properties/thumbnails/'.$row_rsConsultasMenu['id_img'] .'_md.jpg')) { ?>
                                    <img src="/media/images/properties/thumbnails/<?php echo $row_rsConsultasMenu['id_img'] ?>_sm.jpg" alt="">
                                <?php } else { ?>
                                    <img src="/intramedianet/includes/assets/img/no_image.jpg" alt="">
                                <?php } ?>
                        <span class="date"><i class="fa fa-clock-o"></i> <?php echo relativeTime( strtotime($row_rsConsultasMenu['fecha_cons']) ) ?></span>
                        <h2><?php echo $row_rsConsultasMenu['nombre_cons'] ?></h2>
                        <span class="ref"><?php __('Ref.'); ?>: <?php echo $row_rsConsultasMenu['referencia_prop'] ?></span>
                                <div><?php if($row_rsConsultasMenu['read_cons'] == 0) { ?>
                                <span class="label label-danger"><?php __('Nuevo'); ?></span>
                                <?php } else { ?>
                                <span class="label label-default"><?php __('Leido'); ?></span>
                                <?php } ?></div>
                                <i class="fa fa-arrow-circle-o-right"></i>
                        </a>
                        </li>
                        <?php } while ($row_rsConsultasMenu = mysqli_fetch_assoc($rsConsultasMenu)); ?>
                        <?php } else { ?>
                        <li class="footer">
                            <p class="lead"><?php __('No hay consultas que mostrar'); ?></p>
                        </li>
                        <?php } ?>
                        <li class="footer">
                            <a href="/intramedianet/properties/enquiries.php" class="btn btn-primary"><?php __('Administrar consultas'); ?></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown dropdown-flags withtext"> <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Idiomas'); ?>"><img src="/intramedianet/includes/assets/img/flags/<?php echo $lang_adm; ?>.png" alt="" class="nav-flag"> <b class="caret"></b><span class="text-mt hidden-xs hidden-sm"><?php __('Idioma'); ?></span></a>
                    <ul class="dropdown-menu" id="lang-menu">
                        <li><a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'es'); ?>"><img src="/intramedianet/includes/assets/img/flags/es.png" width="16" height="16" alt=""></a></li>
                        <li><a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'en'); ?>"><img src="/intramedianet/includes/assets/img/flags/en.png" width="16" height="16" alt=""></a></li>
                        <!-- <li><a href="<?php echo KT_addReplaceParamLang($_SERVER['REQUEST_URI'], 'lang_adm', 'fr'); ?>"><img src="/intramedianet/includes/assets/img/flags/fr.png" width="16" height="16" alt=""></a></li> -->
                    </ul>
                </li>
                <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                <li class="withtext hidden-xs hidden-sm">
                    <a href="/" target="_blank" data-toggle="tooltip" data-placement="bottom" title="<?php __('Ir a la Web'); ?>"><i class="fa fa-sitemap"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Ir a la Web'); ?></span></a>
                </li>
                <?php endif ?>
                <li class="withtext">
                    <a href="/intramedianet/logout.php" data-toggle="tooltip" data-placement="bottom" title="<?php __('Desconectar'); ?>"><i class="fa fa-power-off"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Desconectar'); ?></span></a>
                </li>
            </ul>

        </div>
        <!--/.container-fluid -->

    </div>
