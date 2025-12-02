<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 18-05-2023</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador fotocasa</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes en los templates de los emails de newsletter</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Ajuste en clientes interesados</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Ajuste formulario de propitarios</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadir costas a ciudades</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes exportador fotocasa
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes en los inmuebles de los emails de newsletter
    </h6>
    <div class="card-body">
        Subir la carpeta:
        <pre>
            <code class="makefile">
/modules/mail_partials/
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajuste en clientes interesados
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/interested-clients.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajuste formulario de propitarios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-owner-data.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir costas a ciudades
    </h6>
    <div class="card-body">
        Ejecutar SQL:
        <pre>
            <code class="sql">
CREATE TABLE `properties_coast` (
  `id_cst` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coast_ca_cst` varchar(255) DEFAULT NULL,
  `coast_da_cst` varchar(255) DEFAULT NULL,
  `coast_de_cst` varchar(255) DEFAULT NULL,
  `coast_en_cst` varchar(255) DEFAULT NULL,
  `coast_es_cst` varchar(255) DEFAULT NULL,
  `coast_fi_cst` varchar(255) DEFAULT NULL,
  `coast_fr_cst` varchar(255) DEFAULT NULL,
  `coast_is_cst` varchar(255) DEFAULT NULL,
  `coast_nl_cst` varchar(255) DEFAULT NULL,
  `coast_no_cst` varchar(255) DEFAULT NULL,
  `coast_ru_cst` varchar(255) DEFAULT NULL,
  `coast_se_cst` varchar(255) DEFAULT NULL,
  `coast_zh_cst` varchar(255) DEFAULT NULL,
  `coast_pl_cst` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cst`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `properties_coast` (`id_cst`, `coast_ca_cst`, `coast_da_cst`, `coast_de_cst`, `coast_en_cst`, `coast_es_cst`, `coast_fi_cst`, `coast_fr_cst`, `coast_is_cst`, `coast_nl_cst`, `coast_no_cst`, `coast_ru_cst`, `coast_se_cst`, `coast_zh_cst`, `coast_pl_cst`) VALUES
  (1,&#039;Costa Blanca North&#039;,&#039;Costa Blanca Nord&#039;,&#039;Costa Blanca Nord&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca Norte&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;,&#039;Costa Blanca North&#039;),
  (2,&#039;Costa Blanca South&#039;,&#039;Costa Blanca Syd&#039;,&#039;Costa Blanca S&uuml;d&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca Sur&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;,&#039;Costa Blanca South&#039;),
  (3,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;,&#039;Costa Calida&#039;),
  (4,&#039;Coast of Almeria&#039;,&#039;Kysten af Almeria&#039;,&#039;K&uuml;ste von Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Costa de Almer&iacute;a&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;,&#039;Coast of Almeria&#039;),
  (5,&#039;Costa de Valencia&#039;,&#039;Valencia-kysten&#039;,&#039;Valencia-K&uuml;ste&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;,&#039;Costa de Valencia&#039;);

ALTER TABLE `properties_loc3` ADD COLUMN `coast_loc3` INT(11) NULL DEFAULT NULL AFTER `name_pl_loc3`;

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/propiedades.php:166
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Almacenamiento de logs */
/*--------------------------------------------------------------------------
|
| Gestiona el n&uacute;mero de meses de registros que se guardan en el log
|
*/
$logDMounths = 6;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Almacenamiento de logs */
/*--------------------------------------------------------------------------
|
| Gestiona el n&uacute;mero de meses de registros que se guardan en el log
|
*/
$logDMounths = 6;

/*
|--------------------------------------------------------------------------
| Costas
|--------------------------------------------------------------------------
|
| Activar las costas de los inmuebles
| 0 - Desactivado
| 1 - Activado
|
*/

$actCostas = 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/public_html/intramedianet/includes/inc.sidebar.php:114
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/loc1.php&quot; class=&quot;nav-link &lt;?php if((preg_match(&#039;/\/loc1/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc2/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc3/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc4/&#039;, $_SERVER[&#039;PHP_SELF&#039;])) &amp;&amp; !preg_match(&#039;/\/loc2all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) &amp;&amp; !preg_match(&#039;/\/loc3all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) &amp;&amp; !preg_match(&#039;/\/loc4all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/loc1.php&quot; class=&quot;nav-link &lt;?php if((preg_match(&#039;/\/loc1/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc2/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc3/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) || preg_match(&#039;/\/loc4/&#039;, $_SERVER[&#039;PHP_SELF&#039;])) &amp;&amp; !preg_match(&#039;/\/loc2all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) &amp;&amp; !preg_match(&#039;/\/loc3all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) &amp;&amp; !preg_match(&#039;/\/loc4all/&#039;, $_SERVER[&#039;PHP_SELF&#039;]) ){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php if ($actCostas == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/properties/costas.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/costas/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Costas&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subir los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/costas-data.php
/intramedianet/properties/costas-form.php
/intramedianet/properties/costas.php
/intramedianet/properties/_js/costas-list.js
/intramedianet/properties/loc3all-data.php
/intramedianet/properties/loc3all-form.php
/intramedianet/properties/loc3all.php
/intramedianet/properties/_js/loc3all-list.js
/intramedianet/properties/loc3-data.php
/intramedianet/properties/loc3-form.php
/intramedianet/properties/loc3.php
/intramedianet/properties/_js/loc3-list.js
/modules/properties/properties-map.php
/modules/properties/properties.php
/modules/search/coasts.php
/js/source/website.js
/js/website.js
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:340
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$cityQuery = &quot;
    SELECT DISTINCT
        CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END AS area,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY area ASC
&quot;;

$smarty-&gt;assign(&quot;city&quot;, getRecordsAndCache($cityQuery, &#039;city-search&#039;));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$cityQuery = &quot;
    SELECT DISTINCT
        CASE WHEN properties_loc3.name_&quot;.$lang.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang.&quot;_loc3 ELSE areas1.name_&quot;.$lang.&quot;_loc3  END AS area,
        CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY area ASC
&quot;;

$smarty-&gt;assign(&quot;city&quot;, getRecordsAndCache($cityQuery, &#039;city-search&#039;));

$coastQuery = &quot;
    SELECT DISTINCT
        (SELECT coast_&quot;.$lang.&quot;_cst FROM properties_coast WHERE id_cst = (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END))  AS coast,
        CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END AS id
    FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
    WHERE properties_properties.activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0 AND force_hide_prop != 1
    GROUP BY id
    ORDER BY (SELECT coast_&quot;.$lang.&quot;_cst FROM properties_coast WHERE id_cst = (CASE WHEN properties_loc3.coast_loc3 IS NOT NULL THEN properties_loc3.coast_loc3 ELSE areas1.coast_loc3  END)) ASC
&quot;;

$smarty-&gt;assign(&quot;coast&quot;, getRecordsAndCache($coastQuery, &#039;coast-search&#039;));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/buscador.tpl
            </code>
        </pre>
        Añadir si el cliente quiere costas en su web:
        <pre>
            <code class="php">
&lt;select name=&quot;coast[]&quot; id=&quot;coast{$dupl}&quot; class=&quot;form-control select2&quot; multiple data-placeholder=&quot;{$lng_costa}&quot;&gt;
    &lt;option value=&quot;&quot;&gt;{$lng_costa}&lt;/option&gt;
    {section name=lz loop=$coast}
        {if $coast[lz].coast != &#039;&#039;}
            &lt;option value=&quot;{$coast[lz].id}&quot; {if in_array($coast[lz].id, $smarty.get.coast)}selected{/if}&gt;{$coast[lz].coast}&lt;/option&gt;
        {/if}
    {/section}
&lt;/select&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
