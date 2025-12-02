<div id="wrapper">

    <div class="navbar navbar-default navbar-fixed-topx" role="navigation" id="main-nav">

        <div class="container-fluid">

            <ul class="nav navbar-nav nav-favs">


                <li class="withtext"><a href="/intramedianet/properties/properties.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Inmuebles'); ?>"><i class="fa fa-fw fa-building-o"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Inmuebles'); ?></span></a></li>
                <li class="withtext"><a href="/intramedianet/map/properties.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Mapa'); ?>"><i class="fa fa-fw fa-map"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Mapa'); ?></span></a></li>
                <?php if($actClients == 1) { ?>
                <li class="withtext"><a href="/intramedianet/properties/clients.php?KT_back=1" class="hidden-xs" data-toggle="tooltip" data-placement="bottom"  title="<?php __('Clientes'); ?>"><i class="fa fa-fw fa-users"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Clientes'); ?></span></a></li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                            <?php
                            $query_rsLlamadasDeman = "
                            SELECT
                             id_cli
                            FROM   properties_client
                            WHERE next_call_cli != '' AND next_call_cli <= NOW() AND atendido_por_cli = ".$_SESSION['kt_login_id']."
                            ORDER BY next_call_cli ASC
                            ";
                            $rsLlamadasDeman = mysqli_query($inmoconn,$query_rsLlamadasDeman) or die(mysqli_error());
                            $row_rsLlamadasDeman = mysqli_fetch_assoc($rsLlamadasDeman);
                            $totalRows_rsLlamadasDeman = mysqli_num_rows($rsLlamadasDeman);


                            ?>

                <?php if ($actClients == 1 || $actPropietarios == 1) { ?>
                <li class="withtext">
                    <a href="/intramedianet/llamadas/clients.php?KT_back=1" title="<?php __('Llamadas'); ?>"><i class="fa fa-phone
                        "></i>
                        <?php if($totalRows_rsLlamadasDeman > 0 ) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsLlamadasDeman; ?></span><?php } ?> <span class="text-mt hidden-xs hidden-sm"><?php __('Llamadas'); ?></span>
                    </a>
                </li>
                <?php } ?>
                <?php if ($actTasks == 1) { ?>
                <?php
                $sWhere = ' WHERE DATE(date_due_tsk) <= CURRENT_DATE() AND status_tsk != 2 ';
                if ($_SESSION['kt_login_id'] < 9) {
                    $sWhere .= ' AND admin_tsk = ' . $_SESSION['kt_login_id'];
                }
                $query_rsTotalTareas = "
                SELECT
                    id_tsk
                FROM tasks
                $sWhere
                ";
                $rsTotalTareas = mysqli_query($inmoconn,$query_rsTotalTareas) or die(mysqli_error());
                $row_rsTotalTareas = mysqli_fetch_assoc($rsTotalTareas);
                $totalRows_rsTotalTareas = mysqli_num_rows($rsTotalTareas);
                ?>
                <li class="withtext">
                    <a href="/intramedianet/tasks/tasks.php" class="hidden-xs" title="<?php __('Tareas'); ?>"><i class="fa fa-tasks"></i>
                    <?php if($totalRows_rsTotalTareas > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsTotalTareas; ?></span><?php } ?> <span class="text-mt hidden-xs hidden-sm"><?php __('Tareas'); ?></span></a>
                </li>
                <?php } ?>
                <?php if ($actCalendar == 1) { ?>
                <?php
                $query_rsTotalEventos = "SELECT citas.id_ct, citas_categories.category_en_ct, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC LIMIT 5";
                $rsTotalEventos = mysqli_query($inmoconn,$query_rsTotalEventos) or die(mysqli_error());
                $row_rsTotalEventos = mysqli_fetch_assoc($rsTotalEventos);
                $totalRows_rsTotalEventos = mysqli_num_rows($rsTotalEventos);
                ?>
                <li class="withtext">
                    <a href="#" class="dropdown-toggle" data-placement="bottom" data-toggle="dropdown" title="<?php __('Eventos'); ?>"><i class="fa fa-bell"></i>
                        <?php if($totalRows_rsTotalEventos > 0) { ?><span class="badge top-nav-badge"><?php echo $totalRows_rsTotalEventos ?><?php } ?></span> <b class="caret"></b><span class="text-mt hidden-xs hidden-sm"><?php __('Calendario'); ?></span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn" id="notices-menu">
                        <li class="header"><?php __('Eventos'); ?></li>
                        <?php if($totalRows_rsTotalEventos > 0) { ?>
                        <?php
                        $query_rsEventosMenu = "SELECT citas.id_ct, citas_categories.category_" . $lang_adm . "_ct as cat, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC LIMIT 5";
                        $rsEventosMenu = mysqli_query($inmoconn, $query_rsEventosMenu) or die(mysqli_error());
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
                <?php endif; ?>
                <li class="withtext">
                    <a href="/intramedianet/logout.php" data-toggle="tooltip" data-placement="bottom" title="<?php __('Desconectar'); ?>"><i class="fa fa-power-off"></i><span class="text-mt hidden-xs hidden-sm"><?php __('Desconectar'); ?></span></a>
                </li>
            </ul>

        </div>
        <!--/.container-fluid -->

    </div>
