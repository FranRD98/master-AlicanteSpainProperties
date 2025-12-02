<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 12-12-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Fix generación de miniaturas</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido valoración de inmuebles a criterios de búsqueda</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadidos videos a costas</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadimos foto de cabecera a Zonas</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Se repiten los tipos de propiedad al importar</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Enlace al área privada</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Se añade HTML en plantillas de email</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> Fix cascade delete tags</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix generación de miniaturas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/translate.php:397
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (preg_match(&#039;/https?:\/\//&#039;, $image)) {
    $image = (file_get_last_url($image));
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
// if (preg_match(&#039;/https?:\/\//&#039;, $image)) {
//     $image = (file_get_last_url($image));
// }
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido valoración de inmuebles a criterios de búsqueda
    </h6>
    <div class="card-body">
        <div class="alert alert-info" role="alert">
         Para poder hacer esta actualización hay que hacer esta mejora antes: <a href="/_install/updates.php?v=Updates-113.php#sec7" target="_blank">/_install/updates.php?v=Updates-113.php#sec7</a>
        </div>
        Añadimos los archivos:
        <pre>
            <code class="makefile">
/media/images/website/thumbs-down-solid.svg
/media/images/website/thumbs-up-solid.svg
/modules/mail_partials/view/
/modules/mail_partials/property_rate.php
/modules/mail_partials/rate.php
/modules/mail_partials/ratesave.php
/modules/properties/view/partials/property-list-rate.tpl
/intramedianet/properties/clients-send2.php
/intramedianet/properties/clients-rates-data.php
/intramedianet/properties/clients-rates.php
/intramedianet/properties/_js/clients-rates-list.js
            </code>
        </pre>
        <hr>
        Sustituimos los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli-int.php
/intramedianet/properties/properties-client-data-cli-intno.php
/intramedianet/properties/properties-client-data-cli.php
/intramedianet/properties/clients-send-search-criteria.php
/intramedianet/properties/_js/clients-form.js
            </code>
        </pre>
        <hr>
        Ejecutamos la query:
        <pre>
            <code class="sql">
CREATE TABLE `cli_prop_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client` int(11) NOT NULL DEFAULT 0,
  `property` int(11) NOT NULL DEFAULT 0,
  `rate` int(11) NOT NULL DEFAULT 0,
  `location` int(1) DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0,
  `price` int(1) NOT NULL DEFAULT 0,
  `bedrooms` int(1) NOT NULL DEFAULT 0,
  `other` int(1) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:239
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/archived.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/properties\/archived/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;
        &lt;?php __(&#039;Clientes archivados&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/archived.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/properties\/archived/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;
        &lt;?php __(&#039;Clientes archivados&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/clients-rates.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/properties\/clients-rates/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;
        &lt;?php __(&#039;Valoraciones&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2483
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;tab-content&quot;&gt;

  &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane active&quot; id=&quot;resultados&quot;&gt;
      &lt;table class=&quot;table w-lg-100 table-striped table-bordered align-middle&quot; id=&quot;records-tables&quot;&gt;
        &lt;thead class=&quot;table-light&quot;&gt;
          &lt;tr&gt;
            &lt;th style=&quot;min-width: 60px !important;&quot;&gt;&amp;nbsp;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Im&aacute;gen&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Operaci&oacute;n&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Precio&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Activado&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Propietario&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;&lt;/th&gt;
            &lt;th id=&quot;actionsOrder&quot; style=&quot;min-width: 150px !important;&quot;&gt;
                &lt;div class=&quot;row&quot;&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-1&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-2&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/th&gt;
          &lt;/tr&gt;
          &lt;tr&gt;
              &lt;td&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-sm&quot; id=&quot;records-tables-all&quot;&gt;&lt;i class=&quot;fa-regular fa-square-check&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-sm&quot; id=&quot;records-tables-none&quot;&gt;&lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
              &lt;/td&gt;
              &lt;td&gt;
                  &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
                  &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
              &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;referencia_prop&quot; id=&quot;referencia_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;status_en_sta&quot; id=&quot;status_en_sta&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;types_en_typ&quot; id=&quot;types_en_typ&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;town_en_twn&quot; id=&quot;town_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;zona_en_twn&quot; id=&quot;zona_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;precio&quot; id=&quot;precio&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activado_prop&quot; id=&quot;activado_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;
                  &lt;select name=&quot;activado_prop_sel&quot; id=&quot;activado_prop_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
                 &lt;/select&gt;
             &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;th class=&quot;actions&quot;&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;btn btn-primary btn-sm w-100 search-clear&quot;&gt; &lt;?php __(&#039;Limpiar&#039;); ?&gt; &lt;/a&gt;&lt;/th&gt;
          &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
          &lt;tr&gt;
            &lt;td colspan=&quot;11&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
          &lt;/tr&gt;
        &lt;/tbody&gt;
      &lt;/table&gt;
  &lt;/div&gt;

  &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane&quot; id=&quot;interesantes&quot;&gt;
      &lt;table class=&quot;table table-striped table-bordered align-middle&quot; id=&quot;records-tables2&quot;&gt;
        &lt;thead class=&quot;table-light&quot;&gt;
          &lt;tr&gt;
            &lt;th style=&quot;min-width: 60px !important;&quot;&gt;&amp;nbsp;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Im&aacute;gen&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Operaci&oacute;n&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Precio&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Activado&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Propietario&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;&lt;/th&gt;
            &lt;th id=&quot;actionsOrder2&quot; style=&quot;min-width: 150px !important;&quot;&gt;
                &lt;div class=&quot;row&quot;&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-1&quot;&gt;

                    &lt;/div&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-2&quot;&gt;

                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/th&gt;
          &lt;/tr&gt;
          &lt;tr&gt;
              &lt;td&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-sm&quot; id=&quot;interesantes-all&quot;&gt;&lt;i class=&quot;fa-regular fa-square-check&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-sm&quot; id=&quot;interesantes-none&quot;&gt;&lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
              &lt;/td&gt;
              &lt;td&gt;
              &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
              &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;referencia_prop&quot; id=&quot;referencia_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;status_en_sta&quot; id=&quot;status_en_sta&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;types_en_typ&quot; id=&quot;types_en_typ&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;town_en_twn&quot; id=&quot;town_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;zona_en_twn&quot; id=&quot;zona_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;precio&quot; id=&quot;precio&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activado_prop&quot; id=&quot;activado_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;
                  &lt;select name=&quot;activado_prop_sel&quot; id=&quot;activado_prop_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
                 &lt;/select&gt;
             &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;th class=&quot;actions&quot;&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;btn btn-primary btn-sm btn-block search-clear&quot;&gt; &lt;?php __(&#039;Limpiar&#039;); ?&gt; &lt;/a&gt;&lt;/th&gt;
          &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
          &lt;tr&gt;
            &lt;td colspan=&quot;11&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
          &lt;/tr&gt;
        &lt;/tbody&gt;
      &lt;/table&gt;
  &lt;/div&gt;

  &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane&quot; id=&quot;descartados&quot;&gt;
      &lt;table class=&quot;table table-striped table-bordered align-middle&quot; id=&quot;records-tables3&quot;&gt;
        &lt;thead class=&quot;table-light&quot;&gt;
          &lt;tr&gt;
            &lt;th style=&quot;min-width: 60px !important;&quot;&gt;&amp;nbsp;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Im&aacute;gen&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Referencia&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Operaci&oacute;n&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Ciudad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Zona&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Precio&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Activado&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Propietario&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt;&lt;/th&gt;
            &lt;th id=&quot;actionsOrder3&quot; style=&quot;min-width: 150px !important;&quot;&gt;
                &lt;div class=&quot;row&quot;&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-1&quot;&gt;

                    &lt;/div&gt;
                    &lt;div class=&quot;col-6&quot; id=&quot;col-2&quot;&gt;

                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/th&gt;
          &lt;/tr&gt;
          &lt;tr&gt;
              &lt;td&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-sm&quot; id=&quot;descartados-all&quot;&gt;&lt;i class=&quot;fa-regular fa-square-check&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
                  &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-sm&quot; id=&quot;descartados-none&quot;&gt;&lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/button&gt;
              &lt;/td&gt;
              &lt;td&gt;
              &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
              &lt;input type=&quot;text&quot; name=&quot;image_img&quot; id=&quot;image_img&quot; style=&quot;display: none&quot;&gt;
              &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;referencia_prop&quot; id=&quot;referencia_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;status_en_sta&quot; id=&quot;status_en_sta&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;types_en_typ&quot; id=&quot;types_en_typ&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;town_en_twn&quot; id=&quot;town_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;zona_en_twn&quot; id=&quot;zona_en_twn&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;precio&quot; id=&quot;precio&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;activado_prop&quot; id=&quot;activado_prop&quot; class=&quot;form-control form-control-sm&quot;&gt;
                  &lt;select name=&quot;activado_prop_sel&quot; id=&quot;activado_prop_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
                      &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
                      &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
                 &lt;/select&gt;
             &lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;nombre_pro&quot; id=&quot;nombre_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;telefono_fijo_pro&quot; id=&quot;telefono_fijo_pro&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
              &lt;th class=&quot;actions&quot;&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;btn btn-primary btn-sm btn-block search-clear&quot;&gt; &lt;?php __(&#039;Limpiar&#039;); ?&gt; &lt;/a&gt;&lt;/th&gt;
          &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
          &lt;tr&gt;
            &lt;td colspan=&quot;11&quot; class=&quot;dataTables_empty&quot;&gt;&lt;?php __(&#039;Cargando datos del servidor&#039;); ?&gt;&lt;/td&gt;
          &lt;/tr&gt;
        &lt;/tbody&gt;
      &lt;/table&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;tab-content&quot;&gt;

    &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane active&quot; id=&quot;resultados&quot;&gt;
        &lt;p&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-xs&quot; id=&quot;records-tables-all&quot;&gt;
                &lt;i class=&quot;fa-regular fa-check-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-xs&quot; id=&quot;records-tables-none&quot;&gt;
                &lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
        &lt;/p&gt;
        &lt;div id=&quot;unprocessed&quot;&gt;&lt;/div&gt;
    &lt;/div&gt;

    &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane&quot; id=&quot;interesantes&quot;&gt;
        &lt;p&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-xs&quot; id=&quot;interesantes-all&quot;&gt;
                &lt;i class=&quot;fa-regular fa-check-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-xs&quot; id=&quot;interesantes-none&quot;&gt;
                &lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
        &lt;/p&gt;
        &lt;div id=&quot;interesantes&quot;&gt;&lt;/div&gt;
    &lt;/div&gt;

    &lt;div role=&quot;tabpanel&quot; class=&quot;tab-pane&quot; id=&quot;descartados&quot;&gt;
        &lt;p&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-success btn-xs&quot; id=&quot;descartados-all&quot;&gt;
                &lt;i class=&quot;fa-regular fa-check-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
            &lt;button type=&quot;button&quot; class=&quot;btn btn-danger btn-xs&quot; id=&quot;descartados-none&quot;&gt;
                &lt;i class=&quot;fa-regular fa-square&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;
            &lt;/button&gt;
        &lt;/p&gt;
        &lt;div id=&quot;descartados&quot;&gt;&lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3176
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var selected =  new Array();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var selected = new Array();

var $pageNum_rsProperties = &#039;&lt;?php echo $_SESSION[&#039;pageNum_rsProperties&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;
var $totalRows_rsProperties = &#039;&lt;?php echo $_SESSION[&#039;totalRows_rsProperties&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;

var $pageNum_rsProperties2 = &#039;&lt;?php echo $_SESSION[&#039;pageNum_rsProperties2&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;
var $totalRows_rsProperties2 = &#039;&lt;?php echo $_SESSION[&#039;totalRows_rsProperties2&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;

var $pageNum_rsProperties3 = &#039;&lt;?php echo $_SESSION[&#039;pageNum_rsProperties3&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;
var $totalRows_rsProperties3 = &#039;&lt;?php echo $_SESSION[&#039;totalRows_rsProperties3&#039; . $_GET[&#039;id_cli&#039;]] ?&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;Valoraci&oacute;n&#039;] = &#039;Valoraci&oacute;n&#039;;
$lang[&#039;Otro&#039;] = &#039;Otro&#039;;
$lang[&#039;Otros&#039;] = &#039;Otros&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;Valoraci&oacute;n&#039;] = &#039;Rating&#039;;
$lang[&#039;Otro&#039;] = &#039;Others&#039;;
$lang[&#039;Otros&#039;] = &#039;Other&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Añadir antes de la etiqueta <code>&lt;/body&gt;</code>:
        <pre>
            <code class="php">
{if $seccion == &#039;rate&#039;}
&lt;script&gt;
$(&#039;.btn-ratecont&#039;).click(function(e) {
    e.preventDefault();
    var $parent = $(this).parent(&#039;.ratecont&#039;);

    if ($parent.find(&#039;.check-rate&#039;).is(&#039;:checked&#039;)) {} else {
        alert(&#039;{$lng_select_a_rating|escape}&#039;);
        return false;
    }

    $client = &#039;{$idClientRate}&#039;;
    $id_prop = $parent.find(&quot;.id_prop_rate&quot;).val();
    $rate = $parent.find(&quot;.check-rate:checked&quot;).val();
    $location = ($parent.find(&quot;.locationchck&quot;).is(&#039;:checked&#039;))?1:0;
    $type = ($parent.find(&quot;.typechck&quot;).is(&#039;:checked&#039;))?1:0;
    $price = ($parent.find(&quot;.pricechck&quot;).is(&#039;:checked&#039;))?1:0;
    $bedrooms = ($parent.find(&quot;.bedroomschck&quot;).is(&#039;:checked&#039;))?1:0;
    $other = ($parent.find(&quot;.otherchck&quot;).is(&#039;:checked&#039;))?1:0;

    $.get(&quot;/modules/mail_partials/ratesave.php?id_cli=&quot; + $client + &quot;&amp;id_prop=&quot; + $id_prop + &quot;&amp;rate=&quot; + $rate + &quot;&amp;location=&quot; + $location + &quot;&amp;type=&quot; + $type + &quot;&amp;price=&quot; + $price + &quot;&amp;bedrooms=&quot; + $bedrooms + &quot;&amp;other=&quot; + $other, function(data) {
      if(data != &#039;&#039;) {
          $parent.parent().html(&#039;&lt;h2&gt;{$lng_thank_you_for_your_review|escape}&lt;/h2&gt;&lt;br&gt;&lt;br&gt;&lt;p&gt;{$lng_we_will_adjust_your_purchase_criteria_to_offer_you_the_best_service|escape}&lt;/p&gt;&#039;);
      }
    });

});
&lt;/script&gt;
{/if}
            </code>
        </pre>
        <hr>
        Añadir las traducciones según los idiomas que tenga la web, carpeta /resources:
        <pre>
            <code class="php">
// Catal&aacute;n (ca)
$langStr[&quot;Rate this property&quot;] = &quot;Valora aquesta propietat&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Digues-nos el motiu&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Gr&agrave;cies per la teva ressenya&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Ajustarem els teus criteris de compra per oferir-te el millor servei&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Selecciona una puntuaci&oacute;&quot;;

// Dan&eacute;s (da)
$langStr[&quot;Rate this property&quot;] = &quot;Vurder denne ejendom&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Fort&aelig;l os grunden&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Tak for din anmeldelse&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Vi vil tilpasse dine k&oslash;bekriterier for at give dig den bedste service&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;V&aelig;lg en vurdering&quot;;

// Alem&aacute;n (de)
$langStr[&quot;Rate this property&quot;] = &quot;Bewerten Sie diese Immobilie&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Teilen Sie uns den Grund mit&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Vielen Dank f&uuml;r Ihre Bewertung&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Wir passen Ihre Kaufkriterien an, um Ihnen den besten Service zu bieten&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;W&auml;hlen Sie eine Bewertung aus&quot;;

// Ingl&eacute;s (en)
$langStr[&quot;Rate this property&quot;] = &quot;Rate this property&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Tell Us the reason&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Thank you for your review&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;We will adjust your purchase criteria to offer you the best service&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Select a rating&quot;;


// Espa&ntilde;ol (es)
$langStr[&quot;Rate this property&quot;] = &quot;Valora esta propiedad&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Dinos el motivo&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Gracias por tu rese&ntilde;a&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Ajustaremos tus criterios de compra para ofrecerte el mejor servicio&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Selecciona una calificaci&oacute;n&quot;;

// Fin&eacute;s (fi)
$langStr[&quot;Rate this property&quot;] = &quot;Arvioi t&auml;m&auml; kiinteist&ouml;&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Kerro meille syy&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Kiitos arvostelustasi&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;S&auml;&auml;d&auml;mme ostokriteerej&auml;si tarjotaksemme parasta palvelua&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Valitse arvio&quot;;

// Franc&eacute;s (fr)
$langStr[&quot;Rate this property&quot;] = &quot;&Eacute;valuez cette propri&eacute;t&eacute;&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Dites-nous la raison&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Merci pour votre avis&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Nous ajusterons vos crit&egrave;res d&#039;achat pour vous offrir le meilleur service&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;S&eacute;lectionnez une note&quot;;

// Island&eacute;s (is)
$langStr[&quot;Rate this property&quot;] = &quot;Gef&eth;u &thorn;essari eign einkunn&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Seg&eth;u okkur &aacute;st&aelig;&eth;una&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Takk fyrir ums&ouml;gnina &thorn;&iacute;na&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Vi&eth; munum a&eth;laga kaupvi&eth;mi&eth; &thorn;&iacute;n til a&eth; bj&oacute;&eth;a upp &aacute; bestu &thorn;j&oacute;nustu&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Veldu einkunn&quot;;

// Neerland&eacute;s (nl)
$langStr[&quot;Rate this property&quot;] = &quot;Beoordeel deze woning&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Vertel ons de reden&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Bedankt voor je beoordeling&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;We zullen je aankoopcriteria aanpassen om de beste service te bieden&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Selecteer een beoordeling&quot;;

// Noruego (no)
$langStr[&quot;Rate this property&quot;] = &quot;Vurder denne eiendommen&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Fortell oss grunnen&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Takk for din anmeldelse&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Vi vil justere kj&oslash;pskriteriene dine for &aring; tilby den beste servicen&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Velg en vurdering&quot;;

// Polaco (pl)
$langStr[&quot;Rate this property&quot;] = &quot;Oce&#x144; t&#x119; nieruchomo&#x15b;&#x107;&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Powiedz nam pow&oacute;d&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Dzi&#x119;kujemy za twoj&#x105; opini&#x119;&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Dostosujemy twoje kryteria zakupu, aby zaoferowa&#x107; najlepsz&#x105; us&#x142;ug&#x119;&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;Wybierz ocen&#x119;&quot;;

// Ruso (ru)
$langStr[&quot;Rate this property&quot;] = &quot;&#x41e;&#x446;&#x435;&#x43d;&#x438;&#x442;&#x435; &#x44d;&#x442;&#x443; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x44c;&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;&#x420;&#x430;&#x441;&#x441;&#x43a;&#x430;&#x436;&#x438;&#x442;&#x435; &#x43d;&#x430;&#x43c; &#x43f;&#x440;&#x438;&#x447;&#x438;&#x43d;&#x443;&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;&#x421;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x432;&#x430;&#x448; &#x43e;&#x442;&#x437;&#x44b;&#x432;&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;&#x41c;&#x44b; &#x441;&#x43a;&#x43e;&#x440;&#x440;&#x435;&#x43a;&#x442;&#x438;&#x440;&#x443;&#x435;&#x43c; &#x432;&#x430;&#x448;&#x438; &#x43a;&#x440;&#x438;&#x442;&#x435;&#x440;&#x438;&#x438; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x43a;&#x438;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43f;&#x440;&#x435;&#x434;&#x43b;&#x43e;&#x436;&#x438;&#x442;&#x44c; &#x432;&#x430;&#x43c; &#x43b;&#x443;&#x447;&#x448;&#x438;&#x439; &#x441;&#x435;&#x440;&#x432;&#x438;&#x441;&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;&#x412;&#x44b;&#x431;&#x435;&#x440;&#x438;&#x442;&#x435; &#x43e;&#x446;&#x435;&#x43d;&#x43a;&#x443;&quot;;

// Sueco (se)
$langStr[&quot;Rate this property&quot;] = &quot;Betygs&auml;tt denna fastighet&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;Ber&auml;tta f&ouml;r oss anledningen&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;Tack f&ouml;r din recension&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;Vi kommer att justera dina k&ouml;pkriterier f&ouml;r att erbjuda dig b&auml;sta m&ouml;jliga service&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;V&auml;lj ett betyg&quot;;

// Chino Simplificado (zh)
$langStr[&quot;Rate this property&quot;] = &quot;&#x8bc4;&#x4ef7;&#x6b64;&#x623f;&#x4ea7;&quot;;
$langStr[&quot;Tell Us the reason&quot;] = &quot;&#x544a;&#x8bc9;&#x6211;&#x4eec;&#x539f;&#x56e0;&quot;;
$langStr[&quot;Thank you for your review&quot;] = &quot;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x8bc4;&#x4ef7;&quot;;
$langStr[&quot;We will adjust your purchase criteria to offer you the best service&quot;] = &quot;&#x6211;&#x4eec;&#x5c06;&#x8c03;&#x6574;&#x60a8;&#x7684;&#x8d2d;&#x4e70;&#x6807;&#x51c6;&#xff0c;&#x4ee5;&#x63d0;&#x4f9b;&#x6700;&#x4f73;&#x670d;&#x52a1;&quot;;
$langStr[&quot;Select a rating&quot;] = &quot;&#x9009;&#x62e9;&#x8bc4;&#x5206;&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php
            </code>
        </pre>
        Añadir la ruta:
        <pre>
            <code class="php">
case &#039;rate&#039;:
    $numpag = 29;
    $smarty-&gt;assign(&quot;noIndex&quot;, 1);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/pages/pages.php&#039;);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/mail_partials/rate.php&#039;);
    $smarty-&gt;display(&#039;modules/mail_partials/view/index.tpl&#039;);
break;
            </code>
        </pre>
        <hr>
        Ejecutar la query:
        <pre>
            <code class="php">
INSERT INTO `news` (`id_nws`, `categoria_nws`, `title_ca_nws`, `title_da_nws`, `title_de_nws`, `title_en_nws`, `title_es_nws`, `title_fi_nws`, `title_fr_nws`, `title_is_nws`, `title_nl_nws`, `title_no_nws`, `title_ru_nws`, `title_se_nws`, `title_zh_nws`, `title_pl_nws`, `content_ca_nws`, `content_da_nws`, `content_de_nws`, `content_en_nws`, `content_es_nws`, `content_fi_nws`, `content_fr_nws`, `content_is_nws`, `content_nl_nws`, `content_no_nws`, `content_ru_nws`, `content_se_nws`, `content_zh_nws`, `content_pl_nws`, `date_nws`, `type_nws`, `titlew_ca_nws`, `titlew_da_nws`, `titlew_de_nws`, `titlew_en_nws`, `titlew_es_nws`, `titlew_fi_nws`, `titlew_fr_nws`, `titlew_is_nws`, `titlew_nl_nws`, `titlew_no_nws`, `titlew_ru_nws`, `titlew_se_nws`, `titlew_zh_nws`, `titlew_pl_nws`, `description_ca_nws`, `description_da_nws`, `description_de_nws`, `description_en_nws`, `description_es_nws`, `description_fi_nws`, `description_fr_nws`, `description_is_nws`, `description_nl_nws`, `description_no_nws`, `description_ru_nws`, `description_se_nws`, `description_zh_nws`, `description_pl_nws`, `keywords_ca_nws`, `keywords_da_nws`, `keywords_de_nws`, `keywords_en_nws`, `keywords_es_nws`, `keywords_fi_nws`, `keywords_fr_nws`, `keywords_is_nws`, `keywords_nl_nws`, `keywords_no_nws`, `keywords_ru_nws`, `keywords_se_nws`, `keywords_zh_nws`, `keywords_pl_nws`, `featured_properties_nws`, `quick_location_nws`, `quick_type_nws`, `quick_status_nws`, `quick_town_nws`, `quick_province_nws`, `direccion_gp_prop`, `lat_long_gp_prop`, `zoom_gp_prop`, `zonas_nws`, `activate_nws`, `destacado_nws`, `tags_ca_nws`, `tags_da_nws`, `tags_de_nws`, `tags_en_nws`, `tags_es_nws`, `tags_fi_nws`, `tags_fr_nws`, `tags_is_nws`, `tags_nl_nws`, `tags_no_nws`, `tags_ru_nws`, `tags_se_nws`, `tags_zh_nws`, `tags_pl_nws`, `quick_price_from_nws`, `quick_price_up_to_nws`, `quick_features_nws`, `quick_tags_nws`) VALUES
(29, 0, NULL, &#039;Bed&oslash;m disse ejendomme&#039;, &#039;Bewerten Sie diese Eigenschaften&#039;, &#039;Rate these properties&#039;, &#039;Valora estas propiedaddes&#039;, &#039;Arvioi n&auml;m&auml; ominaisuudet&#039;, &#039;&Eacute;valuez ces propri&eacute;t&eacute;s&#039;, &#039;Gef&eth;u &thorn;essum eignum einkunn&#039;, &#039;Beoordeel deze eigendommen&#039;, &#039;Vurder disse egenskapene&#039;, &#039;&#x41e;&#x446;&#x435;&#x43d;&#x438;&#x442;&#x435; &#x44d;&#x442;&#x438; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x44b;&#039;, &#039;Betygs&auml;tt dessa egenskaper&#039;, &#039;&#x8bc4;&#x4ef7;&#x8fd9;&#x4e9b;&#x5c5e;&#x6027;&#039;, &#039;Oce&#x144; te nieruchomo&#x15b;ci&#039;, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, &#039;2025-01-10 09:17:28&#039;, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadidos videos a costas
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
CREATE TABLE `news_categories_videos` (
  `id_vid` int(11) NOT NULL AUTO_INCREMENT,
  `news_vid` int(11) NOT NULL,
  `video_vid` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ca_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_da_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_de_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_es_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_fi_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_fr_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_is_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_nl_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_no_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ru_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_se_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_pl_vid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_vid` int(11) DEFAULT &apos;0&apos;,
  PRIMARY KEY (`id_vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            </code>
        </pre>
        <hr>
        Sustituimos los archivos:
        <pre>
            <code class="makefile">
/intramedianet/zonas/categories-form.php
/intramedianet/zonas/videos_add2.php
/intramedianet/zonas/videos_del2.php
/intramedianet/zonas/videos_order2.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadimos foto de cabecera a Zonas
    </h6>
    <div class="card-body">
        Ejecutamos las queries:
        <pre>
            <code class="makefile">
ALTER TABLE `news_fotos` ADD COLUMN `destacada_img` INT(1) NULL DEFAULT 0 AFTER `orden_img`;
ALTER TABLE `zonas_images` ADD COLUMN `destacada_img` INT(1) NULL DEFAULT 0 AFTER `active_img`;
            </code>
        </pre>
        <hr>
        Sustituimos los archivos:
        <pre>
            <code class="makefile">
/intramedianet/events/images_alts.php
/intramedianet/zonas/categories-form.php
/intramedianet/zonas/images_alts.php
/intramedianet/zonas/imagesz_alts.php
/modules/zonas/properties.php
/modules/zonas/view/index.tpl
/modules/ciudades/properties.php
/modules/ciudades/view/index.tpl
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Se repiten los tipos de propiedad al importar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/importadores/_utils.php:389
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsType = &quot;SELECT id_typ, types_en_typ FROM properties_types WHERE LOWER(types_en_typ) = &#039;&quot; . strtolower($type) . &quot;&#039;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsType = &quot;SELECT id_typ, types_en_typ FROM properties_types WHERE LOWER(TRIM(types_en_typ)) = &#039;&quot; . strtolower(trim($type)) . &quot;&rsquo;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Enlace al área privada
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/users/users-form.php:84
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
 $link=&quot;https://&quot;.$_SERVER[&#039;HTTP_HOST&#039;].&quot;.test/intramedianet/index.php&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$link=&quot;https://&quot; . $_SERVER[&#039;HTTP_HOST&#039;] . &quot;/intramedianet/index.php&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Se añade HTML en plantillas de email
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1574
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;).replace(/(&lt;([^&gt;]+)&gt;)/gi, &quot;&quot;));
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix cascade delete tags
    </h6>
    <div class="card-body">
        Ejecutamos esta query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_property_tag` DROP FOREIGN KEY `properties_property_tag_ibfk_1`; ALTER TABLE `properties_property_tag` ADD CONSTRAINT `properties_property_tag_ibfk_1` FOREIGN KEY (`property`) REFERENCES `properties_properties`(`id_prop`) ON DELETE RESTRICT ON UPDATE CASCADE;
            </code>
        </pre>
        <hr>
        Si sigue fallando ejecutamos la siguiente query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_property_tag` DROP FOREIGN KEY `properties_property_tag_ibfk_2`; ALTER TABLE `properties_property_tag` ADD CONSTRAINT `properties_property_tag_ibfk_2` FOREIGN KEY (`property`) REFERENCES `properties_properties`(`id_prop`) ON DELETE RESTRICT ON UPDATE CASCADE;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>