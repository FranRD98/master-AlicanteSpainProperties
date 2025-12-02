<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <?php if ($actLestinmo == 0): ?>
            <!-- Dark Logo-->
            <a href="/intramedianet/inicio/inicio.php" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/intramedianet/inicio/inicio.php" class="logo logo-light">
                <span class="logo-sm">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm.svg" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg.svg" alt="" height="17">
                </span>
            </a>
        <?php else: ?>
            <!-- Dark Logo-->
            <a href="/intramedianet/inicio/inicio.php" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm-letsinmo.svg" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo.svg" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/intramedianet/inicio/inicio.php" class="logo logo-light">
                <span class="logo-sm">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-sm-letsinmo.svg" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="/intramedianet/includes/assets/imgs/mediaelx-1l-wg-letsinmo.svg" alt="" height="17">
                </span>
            </a>
        <?php endif ?>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link <?php if(preg_match('/\/inicio\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" href="/intramedianet/inicio/inicio.php">
                        <i class="fa-regular fa-gauge fa-fw-"></i> <span><?php __('Inicio'); ?></span>
                    </a>
                </li>

                <!-- <li class="menu-title"><span><?php __('Inmuebles'); ?></span></li> -->

                <?php
                if(
                    (preg_match('/\/properties\//', $_SERVER['PHP_SELF']) || preg_match('/\/map\//', $_SERVER['PHP_SELF']) || preg_match('/\/promotions\//', $_SERVER['PHP_SELF']) || preg_match('/\/hystory.php/', $_SERVER['PHP_SELF']). preg_match('/\/seg.php/', $_SERVER['PHP_SELF']))
                    && !preg_match('/\/properties\/clients/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties\/owners/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/loc2all/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/loc3all/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/loc4all/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/duplicates.php/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties-archived/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/enquiries/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties\/bajada/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/properties\/consultas/', $_SERVER['PHP_SELF'])
                    && !preg_match('/\/llamadas\//', $_SERVER['PHP_SELF'])
                ) {
                    $showSecProp = true;
                } else {
                    $showSecProp = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecProp){ ?>active<?php } ?>" href="#sidebarProperties" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecProp){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarProperties">
                        <i class="fa-regular fa-building"></i> <span><?php __('Inmuebles'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecProp){ ?>show<?php } ?>" id="sidebarProperties">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/intramedianet/properties/properties.php" class="nav-link <?php if(preg_match('/\/properties\/properties/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Inmuebles'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/properties/search-properties.php" class="nav-link <?php if(preg_match('/\/properties\/search-properties/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Búsqueda avanzada'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/map/properties.php" class="nav-link <?php if(preg_match('/\/map\/properties/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Mapa'); ?></a>
                            </li>                            
                            <li class="nav-item">
                                <a href="/intramedianet/properties/history.php" class="nav-link <?php if(preg_match('/\/history.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Historialpropiedades'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/seguimiento/seg.php" class="nav-link <?php if(preg_match('/\/seg.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Seguimiento de propiedades'); ?></a>
                            </li>

                            <?php if ($actPromociones == 1): ?>
                                <li class="nav-item">
                                    <a href="/intramedianet/promotions/news.php" class="nav-link <?php if(preg_match('/\/promotions\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                        <?php __('Promociones'); ?>
                                    </a>
                                </li>
                            <?php endif ?>
                            

                            <?php
                            if(
                                preg_match('/\/types/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/features/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/prifeatures/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/status/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/tags/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/pool/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/parking/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/kitchen/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/condition/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/planta/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/nacionalidades/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/costas/', $_SERVER['PHP_SELF']) ||
                                preg_match('/\/loc/', $_SERVER['PHP_SELF'])
                            ) {
                                $showSecPropOpt = true;
                            } else {
                                $showSecPropOpt = false;
                            }
                            ?>
                            <li class="nav-item">
                                <a href="#sidebarPropZonas" class="nav-link <?php if($showSecPropOpt){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if($showSecPropOpt){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarPropZonas" data-key="t-level-zonas">
                                    <?php __('Options'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if($showSecPropOpt){ ?>show<?php } ?>" id="sidebarPropZonas">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/loc1.php" class="nav-link <?php if((preg_match('/\/loc1/', $_SERVER['PHP_SELF']) || preg_match('/\/loc2/', $_SERVER['PHP_SELF']) || preg_match('/\/loc3/', $_SERVER['PHP_SELF']) || preg_match('/\/loc4/', $_SERVER['PHP_SELF'])) && !preg_match('/\/loc2all/', $_SERVER['PHP_SELF']) && !preg_match('/\/loc3all/', $_SERVER['PHP_SELF']) && !preg_match('/\/loc4all/', $_SERVER['PHP_SELF']) ){ ?>active<?php } ?>"><?php __('Localización'); ?></a>
                                        </li>
                                        <?php if ($actCostas == 1): ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/costas.php" class="nav-link <?php if(preg_match('/\/costas/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Costas'); ?></a>
                                        </li>
                                        <?php endif ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/types.php" class="nav-link <?php if(preg_match('/\/types/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Tipos'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/features.php" class="nav-link <?php if(preg_match('/\/features/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Características'); ?></a>
                                        </li>
                                        <?php if ($xmlImport == 1) { ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/prifeatures.php" class="nav-link <?php if(preg_match('/\/prifeatures/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Características privadas'); ?></a>
                                        </li>
                                        <?php } ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/status.php" class="nav-link <?php if(preg_match('/\/status/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Operaciones'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/tags.php" class="nav-link <?php if(preg_match('/\/tags/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Etiquetas'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/pool.php" class="nav-link <?php if(preg_match('/\/pool/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Piscina'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/parking.php" class="nav-link <?php if(preg_match('/\/parking/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Parking'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/kitchen.php" class="nav-link <?php if(preg_match('/\/kitchen/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Cocinas'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/condition.php" class="nav-link <?php if(preg_match('/\/condition/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Conditions'); ?></a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a href="/intramedianet/properties/planta.php" class="nav-link <?php if(preg_match('/\/planta/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Plantas'); ?></a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/nacionalidades.php" class="nav-link <?php if(preg_match('/\/nacionalidades/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Nacionalidades'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>





                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->

                <!-- <li class="menu-title"><span><?php __('CRM'); ?></span></li> -->

                <?php
                if(
                    (
                    preg_match('/\/properties\/clients/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/properties\/owners/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/templates\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/agencias\//', $_SERVER['PHP_SELF'])
                    )
                    && !preg_match('/\/enquiries/', $_SERVER['PHP_SELF'])
                ) {
                    $showSecClients = true;
                } else {
                    $showSecClients = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecClients){ ?>active<?php } ?>" href="#sidebarClients" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecClients){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarClients">
                        <i class="fa-regular fa-people-arrows"></i> <span><?php __('Clientesx'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecClients){ ?>show<?php } ?>" id="sidebarClients">
                        <ul class="nav nav-sm flex-column">
                            <?php if ($actClients == 1) { ?>
                            <li class="nav-item">
                                <a href="#sidebarClient" class="nav-link <?php if(preg_match('/\/properties\/clients/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF']) || preg_match('/\/templates/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/properties\/clients/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF'])|| preg_match('/\/templates/', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarClient" data-key="t-level-blog">
                                    <?php __('Clientes'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/properties\/clients/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF'])|| preg_match('/\/templates/', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarClient">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/clients.php" class="nav-link <?php if(preg_match('/\/properties\/clients.php/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/clients-form.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Clientes'); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/archived.php" class="nav-link <?php if(preg_match('/\/properties\/archived/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Clientes archivados'); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/clients-rates.php" class="nav-link <?php if(preg_match('/\/properties\/clients-rates/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Valoraciones'); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/clients-search.php" class="nav-link <?php if(preg_match('/\/properties\/clients\-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Búsqueda avanzada'); ?></a>
                                        </li>
                                        <?php
                                        if(
                                            preg_match('/\/properties\/clients\-captado/', $_SERVER['PHP_SELF']) ||
                                            preg_match('/\/properties\/clients-status/', $_SERVER['PHP_SELF']) ||
                                            preg_match('/\/properties\/clients-sources/', $_SERVER['PHP_SELF']) ||
                                            preg_match('/\/templates/', $_SERVER['PHP_SELF'])
                                        ) {
                                            $showSecBuyOpt = true;
                                        } else {
                                            $showSecBuyOpt = false;
                                        }
                                        ?>
                                        <li class="nav-item">
                                            <a href="#sidebarBuyOpt" class="nav-link <?php if($showSecBuyOpt){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if($showSecBuyOpt){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarBuyOpt" data-key="t-level-zonas">
                                                <?php __('Options'); ?>
                                            </a>
                                            <div class="collapse menu-dropdown <?php if($showSecBuyOpt){ ?>show<?php } ?>" id="sidebarBuyOpt">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/clients-captado.php" class="nav-link <?php if(preg_match('/\/properties\/clients\-captado/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar Captado por'); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/clients-status.php" class="nav-link <?php if(preg_match('/\/properties\/clients-status/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar estados'); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/clients-sources.php" class="nav-link <?php if(preg_match('/\/properties\/clients-sources/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar origenes'); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/templates/news.php" class="nav-link <?php if(preg_match('/\/templates\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Plantillas correo'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php } ?>
                            <?php if ($actPropietarios == 1) { ?>
                            <li class="nav-item">
                                <a href="#sidebarOwner" class="nav-link <?php if(preg_match('/\/properties\/owners/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/properties\/owners/', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarOwner" data-key="t-level-blog">
                                    <?php __('Propietarios'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/properties\/owners/', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarOwner">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/owners.php" class="nav-link <?php if(preg_match('/\/properties\/owners.php/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/owners-form.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Propietarios'); ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/owners-search.php" class="nav-link <?php if(preg_match('/\/properties\/owners\-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Búsqueda avanzada'); ?></a>
                                        </li>
                                        <?php
                                        if(
                                            preg_match('/\/properties\/owners\-captado/', $_SERVER['PHP_SELF']) ||
                                            preg_match('/\/properties\/owners-status/', $_SERVER['PHP_SELF']) ||
                                            preg_match('/\/properties\/owners-sources/', $_SERVER['PHP_SELF'])
                                        ) {
                                            $showSecOwnOpt = true;
                                        } else {
                                            $showSecOwnOpt = false;
                                        }
                                        ?>
                                        <li class="nav-item">
                                            <a href="#sidebarOwnOpt" class="nav-link <?php if($showSecOwnOpt){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if($showSecOwnOpt){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarOwnOpt" data-key="t-level-zonas">
                                                <?php __('Options'); ?>
                                            </a>
                                            <div class="collapse menu-dropdown <?php if($showSecOwnOpt){ ?>show<?php } ?>" id="sidebarOwnOpt">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/owners-captado.php" class="nav-link <?php if(preg_match('/\/properties\/owners\-captado/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar Captado por'); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/owners-status.php" class="nav-link <?php if(preg_match('/\/properties\/owners-status/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar estados'); ?></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="/intramedianet/properties/owners-sources.php" class="nav-link <?php if(preg_match('/\/properties\/owners-sources/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Administrar origenes'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php } ?>
                            <?php if ($actAgencias == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/agencias/owners.php" class="nav-link <?php if(preg_match('/\/agencias\/owners/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Agencias'); ?></a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->

                <?php
                if(
                    preg_match('/\/tasks\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/acumbamail\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/llamadas\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/enquiries/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/emails.php/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/properties\/bajada.php/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/properties\/consultas.php/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/email\/email.php/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/calendar\//', $_SERVER['PHP_SELF']) 
                    
                ) {
                    $showSecCRM = true;
                } else {
                    $showSecCRM = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecCRM){ ?>active<?php } ?>" href="#sidebarCRM" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecCRM){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarCRM">
                        <i class="fa-regular fa-people-group"></i> <span><?php __('CRM'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecCRM){ ?>show<?php } ?>" id="sidebarCRM">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/intramedianet/properties/enquiries.php" class="nav-link <?php if(preg_match('/\/properties\/enquiries/', $_SERVER['PHP_SELF']) || preg_match('/\/properties\/bajada/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                    <?php __('Consultas'); ?>
                                    <?php if ($totconsultasCount > 0): ?>
                                    <span class="badge badge-pill bg-danger" data-key="t-hot"><?php echo $totconsultasCount ?></span>
                                    <?php endif ?>
                                </a>
                            </li>
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
                                <li class="nav-item">
                                    <a href="/intramedianet/llamadas/clients.php" class="nav-link <?php if(preg_match('/\/llamadas\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                        <?php __('Llamadas'); ?>
                                        <?php if($totalRows_rsLlamadasDeman > 0 || $totalRows_rsLlamadasProp > 0) { ?><span class="badge badge-pill bg-danger"><?php echo $totalRows_rsLlamadasDeman + $totalRows_rsLlamadasProp; ?></span><?php } ?>
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if ($actTasks == 1): ?>
                            <li class="nav-item">
                                <a href="#sidebarTasks" class="nav-link <?php if(preg_match('/\/tasks\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/tasks\//', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarTasks" data-key="t-level-blog">
                                    <?php __('Tareas'); ?>
                                    <?php if($totalRows_rsTotalTareas > 0) { ?>
                                    <span class="badge badge-pill bg-danger" data-key="t-hot"><?php echo $totalRows_rsTotalTareas ?></span>
                                    <?php } ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/tasks\//', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarTasks">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/tasks/tasks.php" class="nav-link <?php if(preg_match('/\/tasks\/tasks/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Tareas'); ?>
                                                <?php if($totalRows_rsTotalTareas > 0) { ?>
                                                <span class="badge badge-pill bg-danger" data-key="t-hot"><?php echo $totalRows_rsTotalTareas ?></span>
                                                <?php } ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/tasks/categories.php" class="nav-link <?php if(preg_match('/\/tasks\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Estados'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php endif ?>
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
                            <li class="nav-item">
                                <a href="#sidebarCalendar" class="nav-link <?php if(preg_match('/\/calendar\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/calendar\//', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarCalendar" data-key="t-level-blog">
                                    <?php __('Calendario'); ?>
                                    <?php if ($totalRows_rsTotalEventos > 0): ?>
                                    <span class="badge badge-pill bg-danger" data-key="t-hot"><?php echo $totalRows_rsTotalEventos ?></span>
                                    <?php endif ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/calendar\//', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarCalendar">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/calendar/calendario.php" class="nav-link <?php if(preg_match('/\/calendar\/calendario/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">
                                                <?php __('Calendario'); ?>
                                                <?php if ($totalRows_rsTotalEventos > 0): ?>
                                                <span class="badge badge-pill bg-danger" data-key="t-hot"><?php echo $totalRows_rsTotalEventos ?></span>
                                                <?php endif ?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/calendar/categories.php" class="nav-link <?php if(preg_match('/\/calendar\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Categorías'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php endif ?>
                            <?php if ($actMailchimp == 1): ?>
                            <li class="nav-item">
                                <a href="#sidebarAcumba" class="nav-link <?php if(preg_match('/\/acumbamail\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/acumbamail\//', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarAcumba" data-key="t-level-blog">
                                    <?php __('Newsletter'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/acumbamail\//', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarAcumba">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/acumbamail/index.php" class="nav-link <?php if(preg_match('/\/acumbamail\/index/', $_SERVER['PHP_SELF']) && !preg_match('/\/news\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Newsletter'); ?></a>
                                        </li>
                                        <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/acumbamail/listas.php" class="nav-link <?php if((preg_match('/\/acumbamail\/listas/', $_SERVER['PHP_SELF']) || preg_match('/\/acumbamail\/usuarios/', $_SERVER['PHP_SELF'])) && !preg_match('/\/acumbamail\/usuarios-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Listas'); ?></a>
                                        </li>
                                        <?php else: ?>
                                        <li class="nav-item">
                                            <a href="javascript:;" class="nav-link <?php if((preg_match('/\/acumbamail\/listas/', $_SERVER['PHP_SELF']) || preg_match('/\/acumbamail\/usuarios/', $_SERVER['PHP_SELF'])) && !preg_match('/\/acumbamail\/usuarios-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" onclick="return false"><?php __('Listas'); ?></a>
                                        </li>
                                        <?php endif ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/acumbamail/campanas.php" class="nav-link <?php if(preg_match('/\/acumbamail\/campanas/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Campañas'); ?></a>
                                        </li>
                                        <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info'): ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/acumbamail/usuarios-search.php" class="nav-link <?php if(preg_match('/\/acumbamail\/usuarios-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Buscar usuarios'); ?></a>
                                        </li>
                                        <?php else: ?>
                                        <li class="nav-item">
                                            <a href="/intramedianet/acumbamail/usuarios-search.php" class="nav-link <?php if(preg_match('/\/acumbamail\/usuarios-search/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" onclick="return false"><?php __('Buscar usuarios'); ?></a>
                                        </li>
                                        <?php endif ?>
                                        <li class="nav-item">
                                            <a href="javascript:;" class="nav-link <?php if(preg_match('/\/acumbamail\/pendientes/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Mensajes pendientes'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php endif ?>
                            <?php if ($actColaboradores == 1): ?>
                            <li class="nav-item">
                                <a href="#sidebarCollab" class="nav-link <?php if(preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarCollab" data-key="t-level-blog">
                                    <?php __('Contactos'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarCollab">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/collaborators.php" class="nav-link <?php if(preg_match('/\/properties\/collaborators/', $_SERVER['PHP_SELF']) && !preg_match('/\/properties\/collaborators-categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Contactos'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/properties/collaborators-categories.php" class="nav-link <?php if(preg_match('/\/properties\/collaborators-categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Categorías'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php endif ?>
                            <li class="nav-item">
                                <a href="/intramedianet/seguimiento/emails.php" class="nav-link <?php if(preg_match('/\/emails.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Envío de emails'); ?></a>
                            </li>
                            <?php if ($actPortalsEnquiries == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/email/email.php" class="nav-link <?php if(preg_match('/\/email.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Portales'); ?></a>
                            </li>
                            <?php endif ?>
                            <?php if ($actContactos == 1): ?>
                            <!-- <li class="nav-item">
                                <a href="/intramedianet/contactos/owners.php" class="nav-link <?php if(preg_match('/\/contactos\/owners/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Contactos'); ?></a>
                            </li> -->
                            <?php endif ?>
                            
                            <?php if ($actArchivadoEn == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/properties/properties-archived.php" class="nav-link <?php if(preg_match('/\/properties-archived/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Archivado en'); ?></a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->
                <?php if ($_SESSION['kt_login_level'] == 9): ?>

                <?php if ($xmlImport == 1) { ?>
                <!-- <li class="menu-title"><span><?php __('Importación'); ?></span></li> -->

                <?php
                if(
                    (
                        preg_match('/\/xml/', $_SERVER['PHP_SELF']) ||
                        preg_match('/\/duplicates.php/', $_SERVER['PHP_SELF']) ||
                        preg_match('/\/loc2all/', $_SERVER['PHP_SELF']) ||
                        preg_match('/\/loc3all/', $_SERVER['PHP_SELF']) ||
                        preg_match('/\/loc4all/', $_SERVER['PHP_SELF'])
                    )
                    && !preg_match('/\/xml\/exportar/', $_SERVER['PHP_SELF'])
                ) {
                    $showSecIMP = true;
                } else {
                    $showSecIMP = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecIMP){ ?>active<?php } ?>" href="#sidebarImport" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecIMP){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarImport">
                        <i class="fa-regular fa-file-import"></i> <span><?php __('Importar'); ?> XML</span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecIMP){ ?>show<?php } ?>" id="sidebarImport">
                        <ul class="nav nav-sm flex-column">
                            <?php if ($actLestinmo == 0): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/xml/proveedores.php" class="nav-link <?php if(preg_match('/\/xml\/proveedores/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('XML de agencias'); ?></a>
                            </li>
                            <?php endif ?>
                            <li class="nav-item">
                                <a href="/intramedianet/xml/importar.php" class="nav-link <?php if(preg_match('/\/xml\/importar/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Importar'); ?> XML</a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="/intramedianet/properties/loc2all.php" class="nav-link <?php if(preg_match('/\/loc2all/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Mapear provincias'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/properties/loc3all.php" class="nav-link <?php if(preg_match('/\/loc3all/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Mapear ciudades'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/properties/loc4all.php" class="nav-link <?php if(preg_match('/\/loc4all/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Mapear zonas'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/properties/duplicates.php" class="nav-link <?php if(preg_match('/\/duplicates.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Inmuebles duplicados'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/xml/delete.php" class="nav-link <?php if(preg_match('/\/xml\/delete/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Eliminar Propiedades de XML'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->
                <?php } ?>



                <!-- <li class="menu-title"><span><?php __('Exportación'); ?></span></li> -->

                <?php
                if(
                    preg_match('/\/xml\/exportar/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/exported.php/', $_SERVER['PHP_SELF'])
                ) {
                    $showSecEXP = true;
                } else {
                    $showSecEXP = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecEXP){ ?>active<?php } ?>" href="#sidebarExportar" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecEXP){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarExportar">
                        <i class="fa-regular fa-file-export"></i> <span><?php __('Exportar XML'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecEXP){ ?>show<?php } ?>" id="sidebarExportar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/intramedianet/xml/exportar.php" class="nav-link <?php if(preg_match('/\/xml\/exportar/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Crear XML'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="/intramedianet/seguimiento/exported.php" class="nav-link <?php if(preg_match('/\/exported.php/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Propiedades exportadas'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->

                <!-- <li class="menu-title"><span><?php __('Website'); ?>/CMS</span></li> -->
                <?php endif ?>
                <?php
                if(
                    preg_match('/\/banner\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/team\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/testimonials\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/traducciones/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/news\//', $_SERVER['PHP_SELF']) ||  
                    preg_match('/\/zonas\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/events\//', $_SERVER['PHP_SELF'])
                ) {
                    $showSecWeb = true;
                } else {
                    $showSecWeb = false;
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecWeb){ ?>active<?php } ?>" href="#sidebarWebsite" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecWeb){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarWebsite">
                        <i class="fa-regular fa-sitemap"></i> <span><?php __('Website'); ?>/CMS</span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecWeb){ ?>show<?php } ?>" id="sidebarWebsite">
                        <ul class="nav nav-sm flex-column">
                            <?php if ($actNoticias == 1) { ?>
                                <?php if ($actNoticiasCats == 0): ?>
                                    <li class="nav-item">
                                        <a href="/intramedianet/news/news.php" class="nav-link <?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Noticias'); ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a href="#sidebarBlog" class="nav-link <?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarBlog" data-key="t-level-blog">
                                            <?php __('Noticias'); ?>
                                        </a>
                                        <div class="collapse menu-dropdown <?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarBlog">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="/intramedianet/news/news.php" class="nav-link <?php if(preg_match('/\/news\//', $_SERVER['PHP_SELF']) && !preg_match('/\/news\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Noticias'); ?></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/intramedianet/news/categories.php" class="nav-link <?php if(preg_match('/\/news\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Categorías'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif ?>
                            <?php } ?>
                            <?php if ($actTestimonials == 1) { ?>
                            <li class="nav-item">
                                <a href="/intramedianet/testimonials/news.php" class="nav-link <?php if(preg_match('/\/testimonials\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Testimonials'); ?></a>
                            </li>
                            <?php } ?>
                            <?php if ($showTeam == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/team/teams.php" class="nav-link <?php if(preg_match('/\/team\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Equipo'); ?></a>
                            </li>
                            <?php endif ?>
                            <?php if ($actZonas == 1) { ?>
                            <li class="nav-item">
                                <a href="#sidebarZonas" class="nav-link <?php if(preg_match('/\/zonas\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?php if(preg_match('/\/zonas\//', $_SERVER['PHP_SELF'])){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarZonas" data-key="t-level-zonas">
                                    <?php __('Áreas'); ?>
                                </a>
                                <div class="collapse menu-dropdown <?php if(preg_match('/\/zonas\//', $_SERVER['PHP_SELF'])){ ?>show<?php } ?>" id="sidebarZonas">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/intramedianet/zonas/news.php" class="nav-link <?php if(preg_match('/\/zonas\//', $_SERVER['PHP_SELF']) && !preg_match('/\/zonas\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Ciudades'); ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/intramedianet/zonas/categories.php" class="nav-link <?php if(preg_match('/\/zonas\/categories/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Costas'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <?php } ?>
                            <?php if ($actBanner == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/banner/index.php" class="nav-link <?php if(preg_match('/\/banner\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Banner'); ?></a>
                            </li>
                            <?php endif ?>
                            <?php if ($actTradduccions == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/translate/traducciones.php?lang=<?php echo $language ?>" class="nav-link <?php if(preg_match('/\/traducciones/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Traducciones'); ?></a>
                            </li>
                            <?php endif ?>
                            <?php if ($actEventos == 1): ?>
                                <li class="nav-item">
                                    <a href="/intramedianet/events/news.php?lang=<?php echo $language ?>" class="nav-link <?php if(preg_match('/\/events/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Eventos'); ?></a>
                                </li>
                             <?php endif ?>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->

                <!-- <li class="menu-title"><span><?php __('SEO'); ?></span></li> -->
                <?php
                if(
                    preg_match('/\/pages\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/landing\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/quicklinks\//', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/llms\//', $_SERVER['PHP_SELF'])
                ) {
                    $showSecWeb = true;
                } else {
                    $showSecWeb = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecWeb){ ?>active<?php } ?>" href="#sidebarSEO" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecWeb){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarSEO">
                        <i class="fa-regular fa-magnifying-glass"></i> <span><?php __('SEO'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecWeb){ ?>show<?php } ?>" id="sidebarSEO">
                        <ul class="nav nav-sm flex-column">
                            <?php if ($actQuicklinks == 1) { ?>
                            <li class="nav-item">
                                <a href="/intramedianet/quicklinks/news.php" class="nav-link <?php if(preg_match('/\/quicklinks\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Quicklinks'); ?></a>
                            </li>
                            <?php } ?>
                            <?php if ($actLanding == 1) { ?>
                            <li class="nav-item">
                                <a href="/intramedianet/landing/news.php" class="nav-link <?php if(preg_match('/\/landing\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php __('Landing Pages'); ?></a>
                            </li>
                            <?php } ?>
                            
                            <?php if ($actPaginas == 1) { ?>
                            <li class="nav-item">
                                <a href="/intramedianet/pages/news.php" class="nav-link <?php if(preg_match('/\/pages\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">Metas/<?php __('Páginas'); ?></a>
                            </li>
                            <?php } ?>

                            <li class="nav-item">
                                <a href="/intramedianet/llms/llms.php" class="nav-link <?php if(preg_match('/\/llms\//', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>">Metas/<?php __('Info IA'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->

                <?php if ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info' || ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info' && ($_SESSION['kt_login_id'] == 47 || $_SESSION['kt_login_id'] == 1691 || $_SESSION['kt_login_id'] == 1692))): ?>
                <!-- <li class="menu-title"><span><?php __('Usuarios'); ?></span></li> -->

                <?php if ($_SESSION['kt_login_level'] == 9): ?>
                <?php
                if(
                    preg_match('/\/users/', $_SERVER['PHP_SELF']) ||
                    preg_match('/\/webuser/', $_SERVER['PHP_SELF'])
                ) {
                    $showSecUsers = true;
                } else {
                    $showSecUsers = false;
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link menu-link <?php if($showSecUsers){ ?>active<?php } ?>" href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                        aria-expanded="<?php if($showSecUsers){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarUsers">
                        <i class="fa-regular fa-users"></i> <span><?php __('Usuarios'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown <?php if($showSecUsers){ ?>show<?php } ?>" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/intramedianet/users/users.php" class="nav-link <?php if (preg_match('/\/users\//', $_SERVER['PHP_SELF']) && !preg_match('/\/webuser\//', $_SERVER['PHP_SELF']) && ($_SERVER["HTTP_HOST"] != 'demo.mediaelx.info' || ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info' && ($_SESSION['kt_login_id'] == 47 || $_SESSION['kt_login_id'] == 1691 || $_SESSION['kt_login_id'] == 1692)))){ ?>active<?php } ?>"><?php __('Usuarios'); ?></a>
                            </li>
                            <?php if ($actUsuarios == 1): ?>
                            <li class="nav-item">
                                <a href="/intramedianet/webuser/users.php" class="nav-link <?php if(preg_match('/\/webuser/', $_SERVER['PHP_SELF'])){ ?>active<?php } ?>"><?php if ($lang_adm == 'es'): ?><?php __('Usuarios'); ?> Website<?php else: ?>Website <?php __('Usuarios'); ?><?php endif ?></a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li> <!-- end Properties Menu -->
                <?php endif ?>
                <?php endif ?>

                <?php
                if(
                    preg_match('/\/ferias/', $_SERVER['PHP_SELF']) 
                ) 
                {
                    $showSecFairs = true;
                } 
                else 
                {
                    $showSecFairs = false;
                }
                ?>
                <?php if ($actFerias == 1): ?>
                <li class="nav-item">

                    <a class="nav-link menu-link <?php if($showSecFairs){ ?>active<?php } ?>" href="/intramedianet/ferias/clients.php" 
                        aria-expanded="<?php if($showSecFairs){ ?>true<?php } else { ?>false<?php } ?>" aria-controls="sidebarFairs">
                        <i class="fal fa-calendar-edit"></i> <span><?php __('Ferias'); ?> </span>
                    </a>

                    <?php if ($showSecFairs != 'true'): ?>
                        <a style="position: fixed; bottom: 20px; left: 20px" class="d-xl-none btn btn-success btn-ferias <?php if($showSecFairs){ ?>active<?php } ?>" href="/intramedianet/ferias/clients.php">
                        <i style="font-size: 18px" class="fal fa-calendar-edit me-2"></i> <span><?php __('Ferias'); ?> </span>
                         </a> 
                    <?php endif ?>
                   
                </li> <!-- end Properties Menu -->
                <?php endif ?>
            </ul>

            <?php if ($_SERVER["HTTP_HOST"] == 'demo.mediaelx.info'): ?>
                <?php /* ?>
                <?php if ($lang_adm == 'es'): ?>
                    <a href="https://mediaelx.net/contact-form/" target="_blank" class="btn btn-light mt-4 mx-2">Solicita una DEMO GUIADA a uno de nuestros expertos</a>
                    <a href="https://mediaelx.net/contact-form/" target="_blank" class="btn btn-success mt-4 mx-2">Estoy interesado en contratar con Mediaelx</a>
                <?php else: ?>
                    <a href="https://mediaelx.net/en/contact-form/" target="_blank" class="btn btn-light mt-4 mx-2">Request a GUIDED DEMO with one of our experts.</a>
                    <a href="https://mediaelx.net/en/contact-form/" target="_blank" class="btn btn-success mt-4 mx-2">I am interested in buying Mediaelx web + crm</a>
                <?php endif ?>
                <?php */ ?>
            <?php endif ?>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>


