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

                        <a href="https://mlsmediaelx.com" target="_blank">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-exchange fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('MLS'); ?>
                        </a>

                        <?php if ($actTradduccions == 1) { ?>
                        <a href="/intramedianet/translate/traducciones.php?lang=<?php echo $language ?>" <?php if(preg_match('/\/translate/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-globe fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Traducciones'); ?>
                        </a>
                        <?php } ?>

                        <a href="/intramedianet/seguimiento/emails.php" <?php if(preg_match('/\/emails.php/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bar-chart fa-stack-1x fa-inverse stats-down"></i>
                                <i class="fa fa-envelope fa-stack-1x fa-inverse stats"></i>
                            </span>
                            <?php __('Envío de emails'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <a href="/intramedianet/asistencia/" <?php if(preg_match('/\/asistencia\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-comments fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Asistencia'); ?>
                        </a>

                        <div class="divider"></div>

                        <a href="/intramedianet/properties/properties.php?KT_back=1" <?php if(preg_match('/\/properties\/properties/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Inmuebles'); ?>
                        </a>

                        <a href="/intramedianet/map/properties.php?KT_back=1" <?php if(preg_match('/\/map\/properties/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-map fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Mapa'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <a href="/intramedianet/properties/loc1.php" <?php if((preg_match('/\/loc1/', $_SERVER['PHP_SELF']) || preg_match('/\/loc2/', $_SERVER['PHP_SELF']) || preg_match('/\/loc3/', $_SERVER['PHP_SELF']) || preg_match('/\/loc4/', $_SERVER['PHP_SELF'])) && !preg_match('/\/loc2all/', $_SERVER['PHP_SELF']) && !preg_match('/\/loc3all/', $_SERVER['PHP_SELF']) && !preg_match('/\/loc4all/', $_SERVER['PHP_SELF']) ){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Localización'); ?>
                        </a>

                        <a href="/intramedianet/properties/types.php" <?php if(preg_match('/\/types/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-home fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Tipos'); ?>
                        </a>

                        <a href="/intramedianet/properties/features.php" <?php if(preg_match('/\/features/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Características'); ?>
                        </a>

                        <?php if ($xmlImport == 1) { ?>
                        <a href="/intramedianet/properties/prifeatures.php" <?php if(preg_match('/\/prifeatures/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-reply-all fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Características privadas'); ?>
                        </a>
                        <?php } ?>

                        <a href="/intramedianet/properties/tags.php" <?php if(preg_match('/\/tags/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-tags fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Etiquetas'); ?>
                        </a>

                        <a href="/intramedianet/properties/pool.php" <?php if(preg_match('/\/pool/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-tint fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Piscina'); ?>
                        </a>

                        <a href="/intramedianet/properties/parking.php" <?php if(preg_match('/\/parking/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-car fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Parking'); ?>
                        </a>

                        <a href="/intramedianet/properties/kitchen.php" <?php if(preg_match('/\/kitchen/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-cutlery fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Cocinas'); ?>
                        </a>

                        <a href="/intramedianet/properties/condition.php" <?php if(preg_match('/\/condition/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-wrench fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Conditions'); ?>
                        </a>

                        <a href="/intramedianet/properties/planta.php" <?php if(preg_match('/\/planta/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-building fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Plantas'); ?>
                        </a>

                        <a href="/intramedianet/properties/nacionalidades.php" <?php if(preg_match('/\/nacionalidades/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-flag fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Nacionalidades'); ?>
                        </a>

                        <div class="divider"></div>

                        <?php
                        
                        $query_rsConsultas = "SELECT * FROM properties_enquiries WHERE read_cons = 0";
                        $rsConsultas = mysqli_query($inmoconn,$query_rsConsultas) or die(mysqli_error());
                        $row_rsConsultas = mysqli_fetch_assoc($rsConsultas);
                        $totalRows_rsConsultas = mysqli_num_rows($rsConsultas);
                        ?>
                        <a href="/intramedianet/properties/enquiries.php" <?php if(preg_match('/\/enquiries/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Consultas'); ?>
                            <?php if($totalRows_rsConsultas > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsConsultas; ?></span><?php } ?>
                        </a>

                        <div class="hor-divider"></div>

                        <?php if ($actPortalsEnquiries == 1): ?>

                        <a href="/intramedianet/email/email.php" <?php if(preg_match('/\/email/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Portales'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <?php endif ?>

                        <?php if ($actClients == 1) { ?>
                        <a href="/intramedianet/properties/clients.php?KT_back=1" <?php if(preg_match('/\/clients/', $_SERVER['PHP_SELF']) && !preg_match('/llamadas\/clients/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Clientes'); ?>
                        </a>

                        <a href="/intramedianet/properties/archived.php?KT_back=1" <?php if(preg_match('/\/archived/', $_SERVER['PHP_SELF']) && !preg_match('/llamadas\/clients/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Clientes archivados'); ?>
                        </a>
                        <?php } ?>

                        <?php if ($actPropietarios == 1) { ?>
                        <a href="/intramedianet/properties/owners.php?KT_back=1" <?php if(preg_match('/\/owners/', $_SERVER['PHP_SELF']) && !preg_match('/llamadas\/owners/', $_SERVER['PHP_SELF']) && !preg_match('/contactos\/owners/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-key fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Propietarios'); ?>
                        </a>
                        <?php } ?>

                        <?php if ($actCalendar == 1) { ?>

                            <?php
                            
                            $query_rsTotalEventos = "SELECT citas.id_ct, citas_categories.category_en_ct, citas.inicio_ct, citas.final_ct, citas.titulo_ct FROM citas INNER JOIN citas_categories ON citas.categoria_ct = citas_categories.id_ct WHERE citas.inicio_ct >= CURRENT_DATE() ORDER BY citas.inicio_ct ASC LIMIT 5";
                            $rsTotalEventos = mysqli_query($inmoconn,$query_rsTotalEventos) or die(mysqli_error());
                            $row_rsTotalEventos = mysqli_fetch_assoc($rsTotalEventos);
                            $totalRows_rsTotalEventos = mysqli_num_rows($rsTotalEventos);
                            ?>
                        <a href="/intramedianet/calendar/calendario.php" <?php if(preg_match('/\/calendar/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-calendar fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Calendario'); ?> <?php if($totalRows_rsTotalEventos > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsTotalEventos ?><?php } ?></span>
                        </a>
                        <?php } ?>

                        <?php if ($actClients == 1 || $actPropietarios == 1) { ?>

                        <a href="/intramedianet/llamadas/clients.php?KT_back=1" <?php if(preg_match('/\/llamadas/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Llamadas'); ?>
                            <?php
                            
                            $query_rsLlamadasDeman = "
                            SELECT
                             id_cli
                            FROM   properties_client
                            WHERE next_call_cli != '' AND next_call_cli <= NOW()
                            ORDER BY next_call_cli ASC
                            ";
                            $rsLlamadasDeman = mysqli_query($inmoconn,$query_rsLlamadasDeman) or die(mysqli_error());
                            $row_rsLlamadasDeman = mysqli_fetch_assoc($rsLlamadasDeman);
                            $totalRows_rsLlamadasDeman = mysqli_num_rows($rsLlamadasDeman);

                            
                            $query_rsLlamadasProp = "
                            SELECT
                                id_pro
                                FROM properties_owner
                                WHERE next_call_pro != '0000-00-00'  AND next_call_pro <= NOW()
                                ORDER BY next_call_pro ASC
                            ";
                            $rsLlamadasProp = mysqli_query($inmoconn,$query_rsLlamadasProp) or die(mysqli_error());
                            $row_rsLlamadasProp = mysqli_fetch_assoc($rsLlamadasProp);
                            $totalRows_rsLlamadasProp = mysqli_num_rows($rsLlamadasProp);
                            ?>
                            <?php if($totalRows_rsLlamadasDeman > 0 || $totalRows_rsLlamadasProp > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?></span><?php } ?>
                        </a>
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

                        <a href="/intramedianet/tasks/tasks.php" <?php if(preg_match('/\/tasks/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-tasks fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Tareas'); ?> <?php if($totalRows_rsTotalTareas > 0) { ?><span class="label label-danger"><?php echo $totalRows_rsTotalTareas; ?></span><?php } ?>
                        </a>
                        <?php } ?>

                        <div class="hor-divider"></div>

                        <a href="/intramedianet/seguimiento/seg.php" <?php if(preg_match('/\/seg.php/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bar-chart fa-stack-1x fa-inverse stats-down"></i>
                                <i class="fa fa-building fa-stack-1x fa-inverse stats"></i>
                            </span>
                            <?php __('Seguimiento de propiedades'); ?>
                        </a>

                        <?php if ($actMailchimp == 1) { ?>
                            <a href="/intramedianet/acumbamail/index.php" <?php if(preg_match('/\/acumbamail/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Newsletter'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actNewsletter == 1) { ?>
                        <a href="/intramedianet/newsletter/index.php" <?php if(preg_match('/\/newsletter/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Newsletter'); ?>
                            </a>
                        <?php } ?>

                        <div class="hor-divider"></div>

                        <a href="/intramedianet/templates/news.php" <?php if(preg_match('/\/templates\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Plantillas correo'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <?php if ($actContactos == 1) { ?>
                        <a href="/intramedianet/contactos/owners.php?KT_back=1" <?php if(preg_match('/\/contactos/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-male fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Contactos'); ?>
                        </a>
                        <?php } ?>

                        <div class="divider"></div>

    <!--                     <a href="/intramedianet/xml/exportar.php"  <?php if( preg_match('/\/xml\/exportar/', $_SERVER['PHP_SELF']) ){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-cloud-upload fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Exportar XML'); ?>
                        </a> -->

                        <a href="/intramedianet/seguimiento/exported.php" <?php if(preg_match('/\/exported.php/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bar-chart fa-stack-1x fa-inverse stats-down"></i>
                                <i class="fa fa-cloud-download fa-stack-1x fa-inverse stats"></i>
                            </span>
                            <?php __('Propiedades exportadas'); ?>
                        </a>

                        <a href="/intramedianet/properties/history.php" <?php if(preg_match('/\/history.php/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-bar-chart fa-stack-1x fa-inverse stats-down"></i>
                                <i class="fa fa-history fa-stack-1x fa-inverse stats"></i>
                            </span>
                            <?php __('Historialpropiedades'); ?>
                        </a>

                        <div class="hor-divider"></div>

                        <?php if ($xmlImport == 1) { ?>
                        <a href="/intramedianet/xml/importar.php" <?php if( preg_match('/\/xml\//', $_SERVER['PHP_SELF']) &&  !preg_match('/\/exportar/', $_SERVER['PHP_SELF']) && !preg_match('/\/backup/', $_SERVER['PHP_SELF']) ){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-cloud-download fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Importar'); ?> XML
                        </a>
                        <?php } ?>

                        <?php if ($xmlImport == 1) { ?>
                        <a href="/intramedianet/properties/duplicates.php" <?php if(preg_match('/\/duplicates.php/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-files-o fa-stack-1x fa-inverse stats-down"></i>
                                <i class="fa fa-building fa-stack-1x fa-inverse stats"></i>
                            </span>
                            <?php __('Inmuebles duplicados'); ?>
                        </a>

                        <a href="/intramedianet/properties/loc2all.php" <?php if(preg_match('/\/loc2all/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-map-signs fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Mapear provincias'); ?>
                        </a>

                        <a href="/intramedianet/properties/loc3all.php" <?php if(preg_match('/\/loc3all/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-map-signs fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Mapear ciudades'); ?>
                        </a>

                        <a href="/intramedianet/properties/loc4all.php" <?php if(preg_match('/\/loc4all/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-map-signs fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Mapear zonas'); ?>
                        </a>

                        <?php } ?>

                        <div class="divider"></div>

                        <?php if ($actNoticias == 1) { ?>
                        <a href="/intramedianet/news/news.php" <?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-newspaper-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Noticias'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actQuicklinks == 1) { ?>
                            <a href="/intramedianet/quicklinks/news.php" <?php if(preg_match('/\/quicklinks\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-link fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Quicklinks'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actLanding == 1) { ?>
                            <a href="/intramedianet/landing/news.php" <?php if(preg_match('/\/landing\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-file-text-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Landing Pages'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actZonas == 1) { ?>
                        <a href="/intramedianet/zonas/news.php" <?php if(preg_match('/\/zonas\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                             <span class="fa-stack fa-lg">
                                 <i class="fa fa-circle fa-stack-2x"></i>
                                 <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                             </span>
                             <?php __('Zonas'); ?>
                         </a>
                        <?php } ?>

                        <?php if ($actTestimonials == 1) { ?>
                        <a href="/intramedianet/testimonials/news.php" <?php if(preg_match('/\/testimonials\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-commenting-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Testimonials'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actPaginas == 1) { ?>
                            <a href="/intramedianet/pages/news.php" <?php if(preg_match('/\/pages\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-sitemap fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Páginas'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($showTeam == 1) { ?>
                            <a href="/intramedianet/team/teams.php" <?php if(preg_match('/\/team\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-id-card-o fa-stack-1x fa-inverse"></i>
                                </span>
                                <?php __('Equipo'); ?>
                            </a>
                        <?php } ?>

                        <?php if ($actBanner == 1) { ?>
                        <a href="/intramedianet/banner/index.php" <?php if(preg_match('/\/banner\//', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-image fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Banner'); ?>
                        </a>
                        <?php } ?>

                        <div class="divider"></div>

                        <?php if ($actColaboradores == 1) { ?>

                        <a href="/intramedianet/properties/collaborators.php" <?php if(preg_match('/\/collaborators/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Colaboradores'); ?>
                        </a>
                        <?php } ?>

                        <?php if ($actArchivadoEn == 1) { ?>
                        <a href="/intramedianet/properties/properties-archived.php" <?php if(preg_match('/\/properties-archived/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-archive fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Archivado en'); ?>
                        </a>
                        <?php } ?>

                        <a href="/intramedianet/properties/status.php" <?php if(preg_match('/\/status/', $_SERVER['PHP_SELF'])){ ?>class="active"<?php } ?>>
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                            </span>
                            <?php __('Operaciones'); ?>
                        </a>

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
