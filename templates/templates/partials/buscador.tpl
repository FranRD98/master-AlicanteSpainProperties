{if $actMapaPropiedades && $seccion == $url_property_map}
<form action="{$urlStart}{$url_property_map}/" method="get" id="searchHomeForm{$dupl}" role="form" class="validate">
{else}
<form action="{$urlStart}{$url_properties}/" method="get" id="searchHomeForm{$dupl}" role="form" class="validate">
{/if}
    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <div class="d-none col-lg-3">
                    <div class="form-group mb-3 d-lg-none text-right">
                        {if $seccion != ''}
                        <a href="#" class="responsive-search-button"><i class="fa fa-times" aria-hidden="true"></i></a>
                        {/if}
                    </div>

                    <div class="d-none form-group mb-3">
                        <select name="st[]" id="st{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_estado}">
                            {* <option value="">{$lng_estado}</option> *}
                            {section name=st loop=$status}
                            {if $status[st].visible}
                                <option value="{$status[st].id}" {if isset($smarty.get.st) && in_array($status[st].id, $smarty.get.st)}selected{/if}>{$status[st].sale}</option>
                            {/if}
                            {/section}
                        </select>
                    </div>
                </div>
                {if $actCostas == 0}
                
                <!-- Input Costa -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">        
                        <select name="coast[]" id="coast{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_costa}">
                            <option value="">{$lng_costa}</option>
                            {section name=lz loop=$coast}
                                {if isset($coast[lz].coast) && $coast[lz].coast != ''}
                                    <option value="{$coast[lz].id}" {if isset($smarty.get.coast) && in_array($coast[lz].id, $smarty.get.coast)}selected{/if}>{$coast[lz].coast}</option>
                                {/if}
                            {/section}
                        </select>
                    </div>
                </div>
                {/if}
                
                <!-- Input Población -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">
                        <select name="loct[]" id="loct{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_ciudad}">
                            {* <option value="">{$lng_ciudad}</option> *}
                            {section name=lz loop=$city}
                            <option value="{$city[lz].id}" {if isset($smarty.get.loct) &&  in_array($city[lz].id, $smarty.get.loct)}selected{/if}>{$city[lz].area}</option>
                            {/section}
                        </select>
                    </div>
                </div>

                <!-- Input Zona -->
                <div class="d-none col-lg-3">
                    <div class="form-group mb-3">
                        <select name="lozn[]" id="lozn{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_zona}">
                            {* <option value="">{$lng_zona}</option> *}
                            {section name=lz loop=$localizacion}
                            <option value="{$localizacion[lz].id}" {if isset($smarty.get.lozn) && in_array($localizacion[lz].id, $smarty.get.lozn)}selected{/if}>{$localizacion[lz].town}</option>
                            {/section}
                        </select>
                    </div>
                </div>

                <!-- Input Tipo -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">
                        <select name="tp[]" id="tp{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_tipo}">
                            {section name=tp loop=$type}
                                {if {$type[tp].type} != 'Array'}
                                    <option value="{$type[tp].id_type}" {if isset($smarty.get.tp) && in_array($type[tp].id_type, $smarty.get.tp)}selected{/if}>{$type[tp].type}</option>
                                {/if}
                            {/section}
                        </select>
                    </div>
                </div>

                 <!-- Input habitaciones -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">
                        <select name="bd" id="bd{$dupl}" class="form-control">
                            <option value="" {if isset($smarty.get.bd) && $smarty.get.bd == ''}selected{/if}>{$lng_habitaciones}</option>
                            {for $i=1 to 5}
                            <option value="{$i}" {if isset($smarty.get.bd) && $smarty.get.bd == $i}selected{/if}>{if $i == 5}+{/if}{$i}</option>
                            {/for}
                        </select>
                    </div>
                </div>

                <!-- Precio hasta -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">
                        <select name="prhs" id="prhs{$dupl}" class="form-control prhs">
                            <option value="" {if isset($smarty.get.prhs) && $smarty.get.prhs == ""}selected{/if}>{$lng_precio_hasta}</option>
                            <option value="200" {if isset($smarty.get.prhs) && $smarty.get.prhs == 200}selected{/if}>200 €</option>
                            <option value="400" {if isset($smarty.get.prhs) && $smarty.get.prhs == 400}selected{/if}>400 €</option>
                            <option value="600" {if isset($smarty.get.prhs) && $smarty.get.prhs == 600}selected{/if}>600 €</option>
                            <option value="800" {if isset($smarty.get.prhs) && $smarty.get.prhs == 800}selected{/if}>800 €</option>
                            <option value="1000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1000}selected{/if}>1.000 €</option>
                            <option value="1200" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1200}selected{/if}>1.200 €</option>
                            <option value="1400" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1400}selected{/if}>1.400 €</option>
                            <option value="1600" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1600}selected{/if}>1.600 €</option>
                            <option value="1800" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1800}selected{/if}>1.800 €</option>
                            <option value="2000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 2000}selected{/if}>2.000 €</option>
                            <option value="3000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 3000}selected{/if}>+3.000 €</option>
                            <option value="50000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 50000}selected{/if}>50.000 €</option>
                            <option value="100000" {if isset($smarty.get.prhs) && $smarty.get.prhs == '100000'}selected{/if}>100.000€</option>
                            <option value="150000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 150000}selected{/if}>150.000 €</option>
                            <option value="200000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 200000}selected{/if}>200.000 €</option>
                            <option value="250000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 250000}selected{/if}>250.000 €</option>
                            <option value="300000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 300000}selected{/if}>300.000 €</option>
                            <option value="350000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 350000}selected{/if}>350.000 €</option>
                            <option value="400000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 400000}selected{/if}>400.000 €</option>
                            <option value="450000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 450000}selected{/if}>450.000 €</option>
                            <option value="500000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 500000}selected{/if}>500.000 €</option>
                            <option value="550000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 550000}selected{/if}>550.000 €</option>
                            <option value="600000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 600000}selected{/if}>600.000 €</option>
                            <option value="650000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 650000}selected{/if}>650.000 €</option>
                            <option value="700000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 700000}selected{/if}>700.000 €</option>
                            <option value="800000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 800000}selected{/if}>800.000 €</option>
                            <option value="900000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 900000}selected{/if}>900.000 €</option>
                            <option value="1000000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1000000}selected{/if}>+1.000.000 €</option>
                        </select>
                    </div>
                </div>

                <!-- Input Referencia -->
                <div class="col-lg-2">
                    <div class="form-group mb-3">
                        <input type="text" name="rf" id="rf{$dupl}" class="form-control" value="{if isset($smarty.get.rf)}{$smarty.get.rf}{/if}" placeholder="{$lng_referencia}" />
                    </div>
                </div>

            </div>

            </div>
        </div>
        <div class="col-lg-12">
    <div class="row d-flex justify-content-between">


        <!-- Bloque izquierda -->
        <div class="col-lg-3 d-flex justify-content-start">

            <!-- Reset Button -->
            <div class="col-lg-2 col-2">
                <div class="form-group mb-3 d-grid">
                    <a href="javascript:void(0);" class="btn  btn-light button-search-reset">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25.506" height="26.636" viewBox="0 0 25.506 26.636">
                        <path data-name="Trazado 8449" d="M24.688 33.527a12.143 12.143 0 1 0 9.762-16.059c-4.4.619-7.31 3.81-10.45 6.627m0 0V16m0 8.1h8.1" transform="translate(-23.294 -15.5)" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round"/>
                    </svg>
                    </a>
                </div>
            </div>

            <!-- Advanced Search Button -->
            <div class="col-lg-2 col-2">
                <div class="form-group mb-3 d-grid">
                    <input type="hidden" name="date" id="date{$dupl}" value="{$smarty.now}" />
                    <input type="hidden" name="langx" id="langx{$dupl}" value="{$lang}">
                    <div class="d-grid">
                        <a href="{$urlStart}{$url_advanced_search}/" class="btn btn-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27.665" height="27.483" viewBox="0 0 27.665 27.483">
                                <g data-name="Grupo 8516">
                                    <g data-name="Grupo 7461">
                                        <g data-name="Grupo 7460">
                                            <g data-name="Grupo 7454">
                                                <g data-name="Grupo 19">
                                                    <g data-name="Grupo 6330">
                                                        <g data-name="Grupo 6329">
                                                            <g data-name="Grupo 20">
                                                                <path data-name="Línea 2" transform="translate(13.513 9.172)" style="fill:none;stroke:#000;stroke-linecap:round" d="M0 9.391V0"/>
                                                                <path data-name="Línea 3" transform="rotate(90 2.171 16.038)" style="fill:none;stroke:#000;stroke-linecap:round" d="M0 9.391V0"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                                <g data-name="Grupo 7139">
                                                    <g data-name="Grupo 7133">
                                                        <path data-name="Trazado 10514" d="M23.413 23.386A13.241 13.241 0 1 1 26.326 19" transform="translate(-.316 -.272)" style="stroke-miterlimit:10;stroke-linejoin:round;fill:none;stroke:#000;stroke-linecap:round"/>
                                                    </g>
                                                    <path data-name="Línea 1115" transform="translate(22.82 22.839)" style="stroke-miterlimit:10;fill:none;stroke:#000;stroke-linecap:round" d="m0 0 3.692 3.692"/>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-10">
                <a href="/mapa-de-propiedades/" class="btn-dark w-100 btn btn-search save-search">
                    <span class="d-inline-flex align-items-center">
                        Buscar por mapa
                        <svg xmlns="http://www.w3.org/2000/svg" width="31.406" height="31.671" viewBox="0 0 31.406 31.671">
                            <path data-name="Trazado 10931" d="M44.271 24v27.028m0-27.028-10.136 3.378M44.271 24l10.135 3.378v27.028l-10.135-3.378m0 0-10.136 3.378m0-27.028v27.028m0-27.028L24 24v27.028l10.135 3.378"
                                transform="translate(-23.5 -23.368)"
                                style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>

        <!-- Bloque derecha -->
        <div class="col-lg-4 d-flex justify-content-end align-items-start">
                <!-- Botón guardar búsqueda -->
                {if $actSaveSearch == 1}

                    {if $isLevel1 == false}
                    
                <div class="col-lg-6">
                            <a href="javascript:void(0);" class="btn-dark w-100 btn" data-bs-toggle="modal" data-bs-target="#saveSearchModal">
                               {$lng_save_search}
                            </a>
                        </div>
                        
                    {else}
            <div class="col-lg-6">
                            <input type="hidden" name="usrSS" id="usrSS" value="{$smarty.session.kt_login_id}">
                            <a href="/modules/login/save.php" class="btn-dark w-100 btn btn-search save-search">
                                {$lng_save_search}
                            </a>
                        </div>
                    {/if}

                {/if}


                <!-- Buscar propiedades button -->
            <div class="col-lg-6">
                    <div class="form-group mb-3 d-grid">
                        <button type="submit" class="btn btn-primary">{$lng_buscar_propiedades}</button>
                    </div>
                </div>

</div>

            </div>
            <div class="d-none">
                <div class="result"><span></span> {$lng_propiedades}</div>
            </div>

        </div>
    </div>
</form>
