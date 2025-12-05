{if $actMapaPropiedades && $seccion == $url_property_map}
<form action="{$urlStart}{$url_property_map}/" method="get" id="searchHomeForm{$dupl}" role="form" class="validate">
{else}
<form action="{$urlStart}{$url_properties}/" method="get" id="searchHomeForm{$dupl}" role="form" class="validate">
{/if}
    <div class="row" style="background-color:#f0f0f0; padding:15px; border-radius:8px;">

            <!-- Container Checks-->
    <div class="col-12 mb-2">
        <div class="row justify-content-center">
            
            <!-- Obra Nueva -->
            <div class="col-6 col-lg-3 col-xl-2 d-flex justify-content-center">
                <label class="custom-label-checkbox d-flex align-items-center">
                    <input type="checkbox" name="newbuild" value="2" id="newbuild">
                    <span class="checkmark"></span>
                    <span class="checkbox-text">{$lng_obra_nueva}</span>
                </label>
            </div>

            <!-- Venta -->
            <div class="col-6 col-lg-3 col-xl-2 d-flex justify-content-center">
                <label class="custom-label-checkbox d-flex align-items-center">
                    <input type="checkbox" name="resale" value="1" id="resale">
                    <span class="checkmark"></span>
                    <span class="checkbox-text">{$lng_segunda_mano}</span>
                </label>
            </div>

        </div>
    </div>

        <!-- Input Población (Town) -->
        <div class="col-12 mb-2">
            <div class="form-group">
                <select name="loct[]" id="loct{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_ciudad}">
                    {section name=lz loop=$city}
                        <option value="{$city[lz].id}" {if isset($smarty.get.loct) &&  in_array($city[lz].id, $smarty.get.loct)}selected{/if}>{$city[lz].area}</option>
                    {/section}
                </select>
            </div>
        </div>

                    <!-- Input Zona -->
        <div class="col-12 mb-2">
                <div class="form-group">
                    <select name="lozn[]" id="lozn{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_zona}">
                        {* <option value="">{$lng_zona}</option> *}
                        {section name=lz loop=$localizacion}
                        <option value="{$localizacion[lz].id}" {if isset($smarty.get.lozn) && in_array($localizacion[lz].id, $smarty.get.lozn)}selected{/if}>{$localizacion[lz].town}</option>
                        {/section}
                    </select>
                </div>
            </div>

        <!-- Input Tipo -->
        <div class="col-6 mb-2">
            <div class="form-group">
                <select name="tp[]" id="tp{$dupl}" class="form-control select2" multiple data-placeholder="{$lng_tipo}">
                    {section name=tp loop=$type}
                        {if {$type[tp].type} != 'Array'}
                            <option value="{$type[tp].id_type}" {if isset($smarty.get.tp) && in_array($type[tp].id_type, $smarty.get.tp)}selected{/if}>{$type[tp].type}</option>
                        {/if}
                    {/section}
                </select>
            </div>
        </div>

        <!-- Input Habitaciones -->
        <div class="col-6 mb-2">
            <div class="form-group">
                <select name="bd" id="bd{$dupl}" class="form-control">
                    <option value="" {if isset($smarty.get.bd) && $smarty.get.bd == ''}selected{/if}>{$lng_habitaciones}</option>
                    {for $i=1 to 5}
                        <option value="{$i}" {if isset($smarty.get.bd) && $smarty.get.bd == $i}selected{/if}>{if $i == 5}+{/if}{$i}</option>
                    {/for}
                </select>
            </div>
        </div>

        <!-- Precio hasta -->
        <div class="col-6 mb-2">
            <div class="form-group">
                <select name="prhs" id="prhs{$dupl}" class="form-control prhs">
                    <option value="" {if isset($smarty.get.prhs) && $smarty.get.prhs == ""}selected{/if}>{$lng_precio_hasta}</option>
                    <option value="200" {if isset($smarty.get.prhs) && $smarty.get.prhs == 200}selected{/if}>200 €</option>
                    <option value="400" {if isset($smarty.get.prhs) && $smarty.get.prhs == 400}selected{/if}>400 €</option>
                    <option value="600" {if isset($smarty.get.prhs) && $smarty.get.prhs == 600}selected{/if}>600 €</option>
                    <option value="800" {if isset($smarty.get.prhs) && $smarty.get.prhs == 800}selected{/if}>800 €</option>
                    <option value="1000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1000}selected{/if}>1.000 €</option>
                    {* Añadir más opciones según necesites *}
                </select>
            </div>
        </div>

        <!-- Input Referencia -->
        <div class="col-6 mb-3">
            <div class="form-group">
                <input type="text" name="rf" id="rf{$dupl}" class="form-control" value="{if isset($smarty.get.rf)}{$smarty.get.rf}{/if}" placeholder="{$lng_referencia}" />
            </div>
        </div>

        <!-- Search -->
        <div class="col-12 flex-grow-1">
            <button type="submit" class="btn-search">
                {$lng_buscar_propiedades}
                <svg xmlns="http://www.w3.org/2000/svg" width="28.12" height="27.935" viewBox="0 0 28.12 27.935">
                    <g data-name="Grupo 7456">
                        <g data-name="Grupo 7139">
                            <g data-name="Grupo 7133">
                                <path data-name="Trazado 10514" d="M23.8 23.772a13.466 13.466 0 1 1 2.962-4.459" transform="translate(-.317 -.272)" style="stroke-linejoin:round;fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10"/>
                            </g>
                            <path data-name="Línea 1115" transform="translate(23.311 23.331)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10" d="m0 0 3.656 3.656"/>
                        </g>
                    </g>
                </svg>
            </button>
        </div>

        <div class="reset-buttons d-flex col-2">
        <a href="javascript:void(0);" class="btn-search-reset">
            <svg xmlns="http://www.w3.org/2000/svg" width="25.506" height="26.636" viewBox="0 0 25.506 26.636">
                <path data-name="Trazado 8449" d="M24.688 33.527a12.143 12.143 0 1 0 9.762-16.059c-4.4.619-7.31 3.81-10.45 6.627m0 0V16m0 8.1h8.1" transform="translate(-23.294 -15.5)" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round"/>
            </svg>

        </a>
    </div>

    <div class="col-10 flex-grow-1">
        <a href="/mapa-de-propiedades/" class="btn-search-map">
            {$lng_buscar_por_mapa}
            <svg xmlns="http://www.w3.org/2000/svg" width="31.406" height="31.671" viewBox="0 0 31.406 31.671">
                <path data-name="Trazado 10931" d="M44.271 24v27.028m0-27.028-10.136 3.378M44.271 24l10.135 3.378v27.028l-10.135-3.378m0 0-10.136 3.378m0-27.028v27.028m0-27.028L24 24v27.028l10.135 3.378" transform="translate(-23.5 -23.368)" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round"/>
            </svg>
        </a>
    </div>

        <div class="col-12 flex-grow-1">
<a href="{$urlStart}{$url_advanced_search}/" class="btn-search-reset">
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
</form>