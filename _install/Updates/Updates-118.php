<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 1106-03-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Actualización Habihub y promociones</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al convertir consulta en cliente</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Si no hay usuarios en una lista de usuarios de acumbamail rompe la página</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Fix error al contar los inmubles en criterios de búsqueda</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Mejora para alert de casas vendidas en el máster</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes de la sección ferias</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadir automáticamente los textos legales a la BBDD</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-plus-circle text-success"></i> Traducciones para el texto GDPR</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> Fix cron importar inmuebles</a></li>
        <li><a href="#sec10"><i class="fas fz-fw fa-bug text-danger"></i> Fix Fotocasa Insert/Update inmuebles importados</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Actualización Habihub y promociones
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` CHANGE COLUMN `entraga_date_prop` `entraga_date_prop` TEXT NULL  COMMENT &#039;&#039;;
INSERT INTO `news` (`id_nws`, `categoria_nws`, `title_ca_nws`, `title_da_nws`, `title_de_nws`, `title_en_nws`, `title_es_nws`, `title_fi_nws`, `title_fr_nws`, `title_is_nws`, `title_nl_nws`, `title_no_nws`, `title_ru_nws`, `title_se_nws`, `title_zh_nws`, `title_pl_nws`, `content_ca_nws`, `content_da_nws`, `content_de_nws`, `content_en_nws`, `content_es_nws`, `content_fi_nws`, `content_fr_nws`, `content_is_nws`, `content_nl_nws`, `content_no_nws`, `content_ru_nws`, `content_se_nws`, `content_zh_nws`, `content_pl_nws`, `date_nws`, `type_nws`, `titlew_ca_nws`, `titlew_da_nws`, `titlew_de_nws`, `titlew_en_nws`, `titlew_es_nws`, `titlew_fi_nws`, `titlew_fr_nws`, `titlew_is_nws`, `titlew_nl_nws`, `titlew_no_nws`, `titlew_ru_nws`, `titlew_se_nws`, `titlew_zh_nws`, `titlew_pl_nws`, `description_ca_nws`, `description_da_nws`, `description_de_nws`, `description_en_nws`, `description_es_nws`, `description_fi_nws`, `description_fr_nws`, `description_is_nws`, `description_nl_nws`, `description_no_nws`, `description_ru_nws`, `description_se_nws`, `description_zh_nws`, `description_pl_nws`, `keywords_ca_nws`, `keywords_da_nws`, `keywords_de_nws`, `keywords_en_nws`, `keywords_es_nws`, `keywords_fi_nws`, `keywords_fr_nws`, `keywords_is_nws`, `keywords_nl_nws`, `keywords_no_nws`, `keywords_ru_nws`, `keywords_se_nws`, `keywords_zh_nws`, `keywords_pl_nws`, `featured_properties_nws`, `quick_location_nws`, `quick_type_nws`, `quick_status_nws`, `quick_town_nws`, `quick_province_nws`, `direccion_gp_prop`, `lat_long_gp_prop`, `zoom_gp_prop`, `zonas_nws`, `activate_nws`, `destacado_nws`, `tags_ca_nws`, `tags_da_nws`, `tags_de_nws`, `tags_en_nws`, `tags_es_nws`, `tags_fi_nws`, `tags_fr_nws`, `tags_is_nws`, `tags_nl_nws`, `tags_no_nws`, `tags_ru_nws`, `tags_se_nws`, `tags_zh_nws`, `tags_pl_nws`, `quick_price_from_nws`, `quick_price_up_to_nws`, `quick_features_nws`, `quick_tags_nws`) VALUES
    (30, 0, &#039;Promocions&#039;, &#039;Kampagner&#039;, &#039;Werbeaktionen&#039;, &#039;Developments&#039;, &#039;Promociones&#039;, &#039;Kampanjat&#039;, &#039;Promotions&#039;, &#039;Kynningar&#039;, &#039;Promoties&#039;, &#039;Kampanjer&#039;, &#039;&#x410;&#x43a;&#x446;&#x438;&#x438;&#039;, &#039;Kampanjer&#039;, &#039;&#x4fc3;&#x9500;&#039;, &#039;Promocje&#039;, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, &#039;2022-12-13 01:00:00&#039;, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL);
ALTER TABLE `properties_properties` ADD INDEX `ref_xml_prop` (`ref_xml_prop`);
ALTER TABLE `properties_properties` ADD INDEX `xml_xml_prop` (`xml_xml_prop`);
            </code>
        </pre>
        <hr>
        Sustituimos los archivos:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php
/intramedianet/xml/importadores/_utils.php
/intramedianet/xml/importadores/Habihub.php
/intramedianet/promotions/news-form.php
            </code>
        </pre>
        <hr>
        Subimos la carpeta:
        <pre>
            <code class="makefile">
/modules/promociones/
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1101
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1355
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;DATE_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;entraga_date_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;entraga_date_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2218
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;entraga_date_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha de entrega&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;entraga_date_prop&quot; id=&quot;entraga_date_prop&quot; value=&quot;&lt;?php echo KT_formatDate($row_rsproperties_properties[&#039;entraga_date_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; data-provider=&quot;flatpickr&quot; data-date-format=&quot;d-m-Y&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;entraga_date_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Fecha de entrega&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;entraga_date_prop&quot; id=&quot;entraga_date_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;entraga_date_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;entraga_date_prop&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/urls.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$urlStr[&quot;promociones&quot;] = array(
    &#039;ca&#039; =&gt; &quot;promocions&quot;,
    &#039;da&#039; =&gt; &quot;kampagner&quot;,
    &#039;de&#039; =&gt; &quot;aktionen&quot;,
    &#039;en&#039; =&gt; &quot;promotions&quot;,
    &#039;es&#039; =&gt; &quot;promociones&quot;,
    &#039;fi&#039; =&gt; &quot;tarjoukset&quot;,
    &#039;fr&#039; =&gt; &quot;promotions&quot;,
    &#039;is&#039; =&gt; &quot;tilbo&eth;&quot;,
    &#039;nl&#039; =&gt; &quot;promoties&quot;,
    &#039;no&#039; =&gt; &quot;kampanjer&quot;,
    &#039;ru&#039; =&gt; &quot;aktsii&quot;,
    &#039;se&#039; =&gt; &quot;kampanjer&quot;,
    &#039;pl&#039; =&gt; &quot;promocje&quot;,
    &#039;ct&#039; =&gt; &quot;promocions&quot;,
    &#039;zh&#039; =&gt; &quot;cu&ograve;sh&#x1d0;&quot;,
    &#039;mostrar-en-sitemap&#039; =&gt; &#039;1&#039;
);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:186
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actVenderPropiedad&quot;, $actVenderPropiedad);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;actVenderPropiedad&quot;, $actVenderPropiedad);
$smarty-&gt;assign(&quot;actPromociones&quot;, $actPromociones);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:885
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
case &#039;favorites-print&#039;:
    $numpag = 7;
    $smarty-&gt;assign(&quot;noIndex&quot;, 1);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/pages/pages.php&#039;);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/favorites/properties-adm.php&#039;);
    $smarty-&gt;display(&#039;modules/favorites/view/index-adm.tpl&#039;);
    break;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
case &#039;favorites-print&#039;:
    $numpag = 7;
    $smarty-&gt;assign(&quot;noIndex&quot;, 1);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/pages/pages.php&#039;);
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/favorites/properties-adm.php&#039;);
    $smarty-&gt;display(&#039;modules/favorites/view/index-adm.tpl&#039;);
    break;

case $urlStr[&#039;promociones&#039;][&#039;url&#039;]:
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/promociones/sidebar.php&#039;);
    $numpag = 416;
    $actWatermark = 0;
    if (isset($tokens[3]) &amp;&amp; $tokens[3] == &#039;&#039; &amp;&amp; isset($tokens[2]) &amp;&amp; $tokens[2] != $urlStr[&#039;category&#039;][&#039;url&#039;] &amp;&amp; $tokens[2] != &#039;&#039;) {
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/promociones/new.php&#039;);
        $smarty-&gt;display(&#039;modules/promociones/view/new.tpl&#039;);
    } else {
        $smarty-&gt;assign(&quot;addCanonical&quot;, 1);
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/pages/pages.php&#039;);
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/modules/promociones/news.php&#039;);
        $smarty-&gt;display(&#039;modules/promociones/view/index.tpl&#039;);
    }
    break;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/menu.tpl:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{if $actVenderPropiedad == 1}
&lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_sell_your_property}} active{/if}&quot;{else}{if $seccion == &#039;&#039;}class=&quot;active&quot;{/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_sell_your_property}/&quot;&gt;{$lng_venda_su_propiedad}&lt;/a&gt;&lt;/li&gt;
{/if}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $actVenderPropiedad == 1}
&lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_sell_your_property}} active{/if}&quot;{else}{if $seccion == &#039;&#039;}class=&quot;active&quot;{/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_sell_your_property}/&quot;&gt;{$lng_venda_su_propiedad}&lt;/a&gt;&lt;/li&gt;
{/if}
{if $actPromociones == 1}
    &lt;li {if $submenu == 1}class=&quot;list-inline-item{if $seccion == {$url_promociones}} active{/if}&quot;
        {else}{if $seccion == &#039;&#039;}class=&quot;active&quot; {/if}{/if}&gt;&lt;a href=&quot;{$urlStart}{$url_promociones}/&quot;&gt;{$lng_promotions}&lt;/a&gt;
    &lt;/li&gt;
{/if}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js
            </code>
        </pre>
        Añadit y compilar:
        <pre>
            <code class="php">
//  ================================================================
//  /* @group SOLICITAR INFORMACI&Oacute;N PROMOCI&Oacute;N */
//  ================================================================

$(&#039;#requestInfoForm2&#039;).submit(function(e) {

    e.preventDefault();

    if ($(this).valid()) {

        $(this).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $.get(&quot;/modules/property/enquiry.php?&quot; + $(this).serialize()).done(function(data) {
            if (data == &#039;ok&#039;) {

                $(&#039;#requestInfoForm2 input[type=text], #requestInfoForm2 textarea&#039;).val(&#039;&#039;);
                $(&#039;#requestInfoForm2 input[type=checkbox]&#039;).removeAttr(&#039;checked&#039;);
                $(&#039;#requestInfoForm2 .loading&#039;).remove();
                if (opcionSimilares == 0) {
                    swal(&#039;&#039;, okConsult, &#039;success&#039;);
                } else {
                    $(&#039;#similarModal&#039;).modal(&#039;toggle&#039;);
                    $(&#039;#similares-properties-modal .slides&#039;).resize();
                }
                gtag(&#039;event&#039;, &#039;evento&#039;, {&#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;property&#039;});

            }

        });

    }

});
            </code>
        </pre>
        <hr>
        Añadimos a los archivos de idiomas:
        <pre>
            <code class="makefile">
$langStr[&quot;Promotions&quot;] = &quot;Promocions&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Promotions&quot;] = &quot;Kampagner&quot;; // Dan&eacute;s (da)
$langStr[&quot;Promotions&quot;] = &quot;Aktionen&quot;; // Alem&aacute;n (de)
$langStr[&quot;Promotions&quot;] = &quot;Promotions&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Promotions&quot;] = &quot;Promociones&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Promotions&quot;] = &quot;Tarjoukset&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Promotions&quot;] = &quot;Promotions&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Promotions&quot;] = &quot;Tilbo&eth;&quot;; // Island&eacute;s (is)
$langStr[&quot;Promotions&quot;] = &quot;Aanbiedingen&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Promotions&quot;] = &quot;Kampanjer&quot;; // Noruego (no)
$langStr[&quot;Promotions&quot;] = &quot;Promocje&quot;; // Polaco (pl)
$langStr[&quot;Promotions&quot;] = &quot;&#x410;&#x43a;&#x446;&#x438;&#x438;&quot;; // Ruso (ru)
$langStr[&quot;Promotions&quot;] = &quot;Kampanjer&quot;; // Sueco (se)
$langStr[&quot;Promotions&quot;] = &quot;&#x4fc3;&#x9500;&quot;; // Chino (zh)

            </code>
        </pre>
        <pre>
            <code class="makefile">
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Veure tota l&#039;obra nova&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Se alt nybyggeri&quot;; // Dan&eacute;s (da)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Alle Neubauten anzeigen&quot;; // Alem&aacute;n (de)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;View all new build&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Ver toda la obra nueva&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;N&auml;yt&auml; kaikki uudet rakennukset&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Voir tous les biens neufs&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Sj&aacute; allar n&yacute;byggingar&quot;; // Island&eacute;s (is)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Bekijk alle nieuwbouwwoningen&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Se alt nybygg&quot;; // Noruego (no)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Zobacz wszystkie nowe budynki&quot;; // Polaco (pl)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x432;&#x441;&#x435; &#x43d;&#x43e;&#x432;&#x43e;&#x441;&#x442;&#x440;&#x43e;&#x439;&#x43a;&#x438;&quot;; // Ruso (ru)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;Visa alla nyproduktioner&quot;; // Sueco (se)
$langStr[&quot;Ver toda la obra nueva&quot;] = &quot;&#x67e5;&#x770b;&#x6240;&#x6709;&#x65b0;&#x697c;&#x76d8;&quot;; // Chino (zh)
            </code>
        </pre>
        <pre>
            <code class="makefile">
$langStr[&quot;Photos&quot;] = &quot;Fotos&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Photos&quot;] = &quot;Fotos&quot;; // Dan&eacute;s (da)
$langStr[&quot;Photos&quot;] = &quot;Fotos&quot;; // Alem&aacute;n (de)
$langStr[&quot;Photos&quot;] = &quot;Photos&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Photos&quot;] = &quot;Fotos&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Photos&quot;] = &quot;Valokuvat&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Photos&quot;] = &quot;Photos&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Photos&quot;] = &quot;Myndir&quot;; // Island&eacute;s (is)
$langStr[&quot;Photos&quot;] = &quot;Foto&#039;s&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Photos&quot;] = &quot;Bilder&quot;; // Noruego (no)
$langStr[&quot;Photos&quot;] = &quot;Zdj&#x119;cia&quot;; // Polaco (pl)
$langStr[&quot;Photos&quot;] = &quot;&#x424;&#x43e;&#x442;&#x43e;&#x433;&#x440;&#x430;&#x444;&#x438;&#x438;&quot;; // Ruso (ru)
$langStr[&quot;Photos&quot;] = &quot;Foton&quot;; // Sueco (se)
$langStr[&quot;Photos&quot;] = &quot;&#x7167;&#x7247;&quot;; // Chino (zh)
            </code>
        </pre>
        <pre>
            <code class="makefile">
$langStr[&quot;Property listings&quot;] = &quot;Llistats de propietats&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Property listings&quot;] = &quot;Boligannoncer&quot;; // Dan&eacute;s (da)
$langStr[&quot;Property listings&quot;] = &quot;Immobilienangebote&quot;; // Alem&aacute;n (de)
$langStr[&quot;Property listings&quot;] = &quot;Property listings&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Property listings&quot;] = &quot;Listado de propiedades&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Property listings&quot;] = &quot;Kiinteist&ouml;ilmoitukset&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Property listings&quot;] = &quot;Annonces immobili&egrave;res&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Property listings&quot;] = &quot;Fasteignalisti&quot;; // Island&eacute;s (is)
$langStr[&quot;Property listings&quot;] = &quot;Woningaanbod&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Property listings&quot;] = &quot;Boligannonser&quot;; // Noruego (no)
$langStr[&quot;Property listings&quot;] = &quot;Oferty nieruchomo&#x15b;ci&quot;; // Polaco (pl)
$langStr[&quot;Property listings&quot;] = &quot;&#x41e;&#x431;&#x44a;&#x44f;&#x432;&#x43b;&#x435;&#x43d;&#x438;&#x44f; &#x43e; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;&quot;; // Ruso (ru)
$langStr[&quot;Property listings&quot;] = &quot;Fastighetsannonser&quot;; // Sueco (se)
$langStr[&quot;Property listings&quot;] = &quot;&#x623f;&#x4ea7;&#x5217;&#x8868;&quot;; // Chino (zh)
            </code>
        </pre>
        <pre>
            <code class="makefile">
$langStr[&quot;Files&quot;] = &quot;Fitxers&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Files&quot;] = &quot;Filer&quot;; // Dan&eacute;s (da)
$langStr[&quot;Files&quot;] = &quot;Dateien&quot;; // Alem&aacute;n (de)
$langStr[&quot;Files&quot;] = &quot;Files&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Files&quot;] = &quot;Archivos&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Files&quot;] = &quot;Tiedostot&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Files&quot;] = &quot;Fichiers&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Files&quot;] = &quot;Skr&aacute;r&quot;; // Island&eacute;s (is)
$langStr[&quot;Files&quot;] = &quot;Bestanden&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Files&quot;] = &quot;Filer&quot;; // Noruego (no)
$langStr[&quot;Files&quot;] = &quot;Pliki&quot;; // Polaco (pl)
$langStr[&quot;Files&quot;] = &quot;&#x424;&#x430;&#x439;&#x43b;&#x44b;&quot;; // Ruso (ru)
$langStr[&quot;Files&quot;] = &quot;Filer&quot;; // Sueco (se)
$langStr[&quot;Files&quot;] = &quot;&#x6587;&#x4ef6;&quot;; // Chino (zh)
            </code>
        </pre>
        <pre>
            <code class="makefile">
$langStr[&quot;Meters&quot;] = &quot;Metres&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Meters&quot;] = &quot;Meter&quot;; // Dan&eacute;s (da)
$langStr[&quot;Meters&quot;] = &quot;Meter&quot;; // Alem&aacute;n (de)
$langStr[&quot;Meters&quot;] = &quot;Meters&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Meters&quot;] = &quot;Metros&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Meters&quot;] = &quot;Metrit&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Meters&quot;] = &quot;M&egrave;tres&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Meters&quot;] = &quot;Metrar&quot;; // Island&eacute;s (is)
$langStr[&quot;Meters&quot;] = &quot;Meters&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Meters&quot;] = &quot;Meter&quot;; // Noruego (no)
$langStr[&quot;Meters&quot;] = &quot;Metry&quot;; // Polaco (pl)
$langStr[&quot;Meters&quot;] = &quot;&#x41c;&#x435;&#x442;&#x440;&#x44b;&quot;; // Ruso (ru)
$langStr[&quot;Meters&quot;] = &quot;Meter&quot;; // Sueco (se)
$langStr[&quot;Meters&quot;] = &quot;&#x7c73;&quot;; // Chino (zh)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al convertir consulta en cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:662
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsUpdateDate = &quot;UPDATE properties_client SET updated_atendido_cli = &#039;&quot; . date(&quot;Y-m-d H:i:s&quot;) . &quot;&#039; WHERE id_cli = &quot; . $tNG-&gt;getColumnValue(&#039;id_cli&#039;);
$rsUpdateDate = mysql_query($query_rsUpdateDate, $inmoconn) or die(mysql_error());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsUpdateDate = &quot;UPDATE properties_client SET updated_cli = &#039;&quot; . date(&quot;Y-m-d H:i:s&quot;) . &quot;&#039; WHERE id_cli = &quot; . $tNG-&gt;getColumnValue(&#039;id_cli&#039;);
$rsUpdateDate = mysqli_query($inmoconn, $query_rsUpdateDate) or die(mysqli_error());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Si no hay usuarios en una lista de usuarios de acumbamail rompe la página
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:67
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;i class=&quot;fa-regular fa-rectangle-list&quot;&gt;&lt;/i&gt; &lt;a href=&quot;listas.php&quot;&gt;&lt;?php echo $_GET[&#039;name&#039;] ?&gt;&lt;/a&gt; &lt;i class=&quot;fa-regular fa-chevron-right&quot;&gt;&lt;/i&gt; &lt;?php echo number_format(count($miembros), 0, &#039;,&#039;, &#039;.&#039;); ?&gt; &lt;?php __(&#039;Usuarios&#039;); ?&gt;&lt;/h4&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;i class=&quot;fa-regular fa-rectangle-list&quot;&gt;&lt;/i&gt; &lt;a href=&quot;listas.php&quot;&gt;&lt;?php echo $_GET[&#039;name&#039;] ?&gt;&lt;/a&gt; &lt;i class=&quot;fa-regular fa-chevron-right&quot;&gt;&lt;/i&gt; &lt;?php if($miembros) { echo number_format(count($miembros), 0, &#039;,&#039;, &#039;.&#039;);  } ?&gt; &lt;?php __(&#039;Usuarios&#039;); ?&gt;&lt;/h4&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:107
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-12 text-right&quot;&gt;
        &lt;?php
        $paginas = count($miembros)/20;

        echo __(&#039;Ir a p&aacute;gina:&#039;, true) . &#039; &lt;select name=&quot;start&quot; id=&quot;start&quot; class=&quot;form-select form-select-sm&quot; style=&quot;display: inline-block; width: auto;&quot;&gt;&#039;;
        for ($i=1; $i &lt;= intval($paginas); $i++) {
            $selected = ((($i*20)-20) == $_GET[&#039;start&#039;])?&#039;selected&#039;:&#039;&#039;;
            echo &#039;&lt;option value=&quot;&#039; . (($i*20)-20) . &#039;&quot; &#039; . $selected . &#039;&gt;&#039; . $i . &#039;&lt;/option&gt;&#039;;
        }
        if ((count($miembros)/20) &gt;= intval($paginas)) {
            $selected = ((($i*20)-20) == $_GET[&#039;start&#039;])?&#039;selected&#039;:&#039;&#039;;
            echo &#039;&lt;option value=&quot;&#039; . (($i*20)-20) . &#039;&quot; &#039; . $selected . &#039;&gt;&#039; . ($i) . &#039;&lt;/option&gt;&#039;;
        }
        echo &#039;&lt;/select&gt;&#039;;
        ?&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($miembros) {  ?&gt;
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-12 text-right&quot;&gt;
        &lt;?php
        $paginas = count($miembros)/20;

        echo __(&#039;Ir a p&aacute;gina:&#039;, true) . &#039; &lt;select name=&quot;start&quot; id=&quot;start&quot; class=&quot;form-select form-select-sm&quot; style=&quot;display: inline-block; width: auto;&quot;&gt;&#039;;
        for ($i=1; $i &lt;= intval($paginas); $i++) {
            $selected = ((($i*20)-20) == $_GET[&#039;start&#039;])?&#039;selected&#039;:&#039;&#039;;
            echo &#039;&lt;option value=&quot;&#039; . (($i*20)-20) . &#039;&quot; &#039; . $selected . &#039;&gt;&#039; . $i . &#039;&lt;/option&gt;&#039;;
        }
        if ((count($miembros)/20) &gt;= intval($paginas)) {
            $selected = ((($i*20)-20) == $_GET[&#039;start&#039;])?&#039;selected&#039;:&#039;&#039;;
            echo &#039;&lt;option value=&quot;&#039; . (($i*20)-20) . &#039;&quot; &#039; . $selected . &#039;&gt;&#039; . ($i) . &#039;&lt;/option&gt;&#039;;
        }
        echo &#039;&lt;/select&gt;&#039;;
        ?&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix error al contar los inmubles en criterios de búsqueda
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2341
            </code>
        </pre>
        Mover:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
  &lt;div class=&quot;col-md-12&quot;&gt;

      &lt;?php if ($actUsuarios == 1) { ?&gt;

      &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;favs&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
          &lt;label for=&quot;favs&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Favoritos&#039;); ?&gt;:&lt;/label&gt;
          &lt;select name=&quot;favs[]&quot; id=&quot;favs&quot; multiple class=&quot;select2&quot;&gt;
            &lt;?php

              $query_rsFavs = &quot;SELECT * FROM users_favorites WHERE user= &#039;&quot;.KT_escapeAttribute($row_rsproperties_client[&#039;user_cli&#039;]).&quot;&#039; GROUP BY user, property ORDER BY id&quot;;
              $rsFavs = mysqli_query($inmoconn ,$query_rsFavs) or die(mysqli_error());
              $row_rsFavs = mysqli_fetch_assoc($rsFavs);
              $totalRows_rsFavs = mysqli_num_rows($rsFavs);
              $favs = array();
              do {
                  array_push($favs, $row_rsFavs[&#039;property&#039;]);
              } while ($row_rsFavs = mysqli_fetch_assoc($rsFavs));
              do { ?&gt;
            &lt;option value=&quot;&lt;?php echo $row_rsReferencias2[&#039;name&#039;] ?&gt;&quot; &lt;?php if (in_array($row_rsReferencias2[&#039;id&#039;], $favs)) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsReferencias2[&#039;name&#039;] ?&gt;&lt;/option&gt;
            &lt;?php } while ($row_rsReferencias2 = mysqli_fetch_assoc($rsReferencias2)); ?&gt;
          &lt;/select&gt;
          &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client&quot;, &quot;favs&quot;); ?&gt;
      &lt;/div&gt;

      &lt;?php } ?&gt;

  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Tras el <code>&lt;br&gt;</code> de la línea 2397
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejora para alert de casas vendidas en el máster
    </h6>
    <div class="card-body">
        Sustituimos el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/alertas.tpl
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/galeria3.tpl:4
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;main-photo pb-lg-0 pb-2&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;main-photo pb-lg-0 pb-2&quot;&gt;

    {if $property[0].vendido_prop == 1 || $property[0].vendido_tag_prop == 1}
        &lt;div class=&quot;vendido-tag-big&quot;&gt;
            {$lng_vendido}
        &lt;/div&gt;
    {/if}
            </code>
        </pre>
        En el archivo:
        <pre>
            <code class="makefile">
/css/_property.scss
            </code>
        </pre>
        Añadimos al final:
        <pre>
            <code class="php">
//  ============================================================================
//  /* @group Alerta de casa vendida */
//  ============================================================================


.vendido-tag-big
{
    position: absolute;
    z-index: 3;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%) rotate(-25deg);
    font-size: 90px;
    font-weight: bold;
    color: $danger;
    text-transform: uppercase;
}

.alert-danger
{
    color: #fff;
    text-align: center;
    background-color: rgba($danger,0.85);
    font-size: 18px;
    font-weight: normal;
}
            </code>
        </pre>
        Añadir este texto a los archivos de idiomas:
        <pre>
            <code class="php">
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Veure altres propietats&quot;; // Catal&aacute;n (ca)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Se andre ejendomme&quot;; // Dan&eacute;s (da)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Weitere Immobilien anzeigen&quot;; // Alem&aacute;n (de)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;View other properties&quot;; // Ingl&eacute;s (en)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Ver otras propiedades&quot;; // Espa&ntilde;ol (es)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;N&auml;yt&auml; muut kohteet&quot;; // Fin&eacute;s (fi)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Voir d&#039;autres propri&eacute;t&eacute;s&quot;; // Franc&eacute;s (fr)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Sj&aacute; a&eth;rar eignir&quot;; // Island&eacute;s (is)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Bekijk andere woningen&quot;; // Neerland&eacute;s (nl)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Se andre eiendommer&quot;; // Noruego (no)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Zobacz inne nieruchomo&#x15b;ci&quot;; // Polaco (pl)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x434;&#x440;&#x443;&#x433;&#x438;&#x435; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x44b; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;&quot;; // Ruso (ru)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;Visa andra fastigheter&quot;; // Sueco (se)
$langStr[&quot;Ver otras propiedades&quot;] = &quot;&#x67e5;&#x770b;&#x5176;&#x4ed6;&#x623f;&#x4ea7;&quot;; // Chino (zh)
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes de la sección ferias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources.php:56
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;&lt;?php echo &#039;feature_en_feat&#039;; ?&gt;&quot; id=&quot;&lt;?php echo &#039;feature_en_feat&#039;; ?&gt;&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;&lt;?php echo &#039;feature_en_feat&#039;; ?&gt;&quot; id=&quot;&lt;?php echo &#039;feature_en_feat&#039;; ?&gt;&quot; class=&quot;form-control form-control-sm&quot;&gt;&lt;/td&gt;
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot;&gt;
    &lt;select name=&quot;active_fair_sts_sel&quot; id=&quot;active_fair_sts_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
    &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-data.php:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$aColumns = array( &#039;category_&#039; . $lang_adm . &#039;_sts&#039;, &#039;id_sts&#039; );
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$aColumns = array(&#039;category_&#039; . $lang_adm . &#039;_sts&#039;, &#039;active_fair_sts&#039;, &#039;id_sts&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-data.php:182
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;inmueble_cons&#039;) {

    $sWhere .= &quot;(SELECT referencia_clip FROM properties_cliperties WHERE id_stsp = inmueble_cons LIMIT 1) LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;

} else {
    $sWhere .= $aColumns[$i].&quot; LIKE &#039;%&quot;.mysqli_real_escape_string($gaSql[&#039;link&#039;],$_GET[&#039;sSearch_&#039;.$i]).&quot;%&#039; &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($aColumns[$i] == &#039;inmueble_cons&#039;) {
    $sWhere .= &quot;(SELECT referencia_clip FROM properties_cliperties WHERE id_stsp = inmueble_cons LIMIT 1) LIKE &#039;%&quot; . mysqli_real_escape_string($gaSql[&#039;link&#039;], $_GET[&#039;sSearch_&#039; . $i]) . &quot;%&#039; &quot;;
} else {
    if ($aColumns[$i] == &#039;active_fair_sts&#039;) {
        if (preg_match(&#039;/&#039; . strtolower($_GET[&#039;sSearch_&#039; . $i]) . &#039;/&#039;, strtolower(__(&#039;S&iacute;&#039;, true)))) {
          $sWhere .= $aColumns[$i] . &quot; = &#039;1&#039; &quot;;
        }
        if (preg_match(&#039;/&#039; . strtolower($_GET[&#039;sSearch_&#039; . $i]) . &#039;/&#039;, strtolower(__(&#039;No&#039;, true)))) {
          $sWhere .= $aColumns[$i] . &quot; = &#039;0&#039; &quot;;
        }
    } else {
        $sWhere .= $aColumns[$i] . &quot; LIKE &#039;%&quot; . mysqli_real_escape_string($gaSql[&#039;link&#039;], $_GET[&#039;sSearch_&#039; . $i]) . &quot;%&#039; &quot;;
    }
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-data.php:221204
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
category_&quot; . $lang_adm . &quot;_sts,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
category_&quot; . $lang_adm . &quot;_sts,
active_fair_sts,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-form.ph:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_client_sources-&gt;addColumn(&quot;category_es_sts&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;category_es_sts&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_client_sources-&gt;addColumn(&quot;category_es_sts&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;category_es_sts&quot;);
$ins_properties_client_sources-&gt;addColumn(&quot;active_fair_sts&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;active_fair_sts&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-form.ph:86
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_client_sources-&gt;addColumn(&quot;category_es_sts&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;category_es_sts&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_client_sources-&gt;addColumn(&quot;category_es_sts&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;category_es_sts&quot;);
$upd_properties_client_sources-&gt;addColumn(&quot;active_fair_sts&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;active_fair_sts&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-form.ph:178
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;category_es_sts&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;category_es_sts&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Origen&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
      &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/es.svg&quot; alt=&quot;&quot; style=&quot;height: 20px;&quot;&gt;&lt;/span&gt;
      &lt;input type=&quot;text&quot; name=&quot;category_es_sts&quot; id=&quot;category_es_sts&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_client_sources[&#039;category_es_sts&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
      &lt;div class=&quot;invalid-feedback&quot;&gt;
          &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
      &lt;/div&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;category_es_sts&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group &lt;?php if ($tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;category_es_sts&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
    &lt;label for=&quot;category_es_sts&quot; class=&quot;form-label required&quot;&gt;&lt;?php __(&#039;Origen&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;input-group&quot;&gt;
        &lt;span class=&quot;input-group-text&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/es.svg&quot; alt=&quot;&quot; style=&quot;height: 20px;&quot;&gt;&lt;/span&gt;
       &lt;input type=&quot;text&quot; name=&quot;category_es_sts&quot; id=&quot;category_es_sts&quot; value=&quot;&lt;?php echo KT_escapeAttribute($ row_rsproperties_client_sources[&#039;category_es_sts&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot; required&gt;
        &lt;div class=&quot;invalid-feedback&quot;&gt;
            &lt;?php __(&#039;Este campo es obligatorio.&#039;); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;category_es_sts&quot;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
   &lt;input type=&quot;checkbox&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp( KT_escapeAttribute($row_rsproperties_client_sources[&#039;active_fair_sts&#039;]), &quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;active_fair_sts&quot;&gt;
        &lt;?php __(&#039;Active Fair&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;active_fair_sts&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/js/clients-sources-list.js:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&quot;thead input&quot;).keyup( function () {
    oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
        oTable.fnSettings(), $(&quot;thead input&quot;).index(this) ) );
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&quot;thead input&quot;).keyup( function () {
    oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
        oTable.fnSettings(), $(&quot;thead input&quot;).index(this) ) );
});

$(&#039;#active_fair_sts_sel&#039;).change(function(e) {
    $(&#039;#active_fair_sts&#039;).val($(this).val()).trigger(&#039;keyup&#039;);
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/js/clients-sources-list.js:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
toggleScrollBarIcon();
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
toggleScrollBarIcon();
if ($(&#039;#active_fair_sts&#039;).val() != &#039;&#039;) {
    $(&#039;#active_fair_sts_sel&#039;).val($(&#039;#active_fair_sts&#039;).val() );
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
intramedianet/ferias/clients-data.php:227
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($sWhere != &#039;&#039;) {
    $sWhere .= &#039; AND feria_cli = 1 &#039;;
} else {
    $sWhere .= &#039; WHERE feria_cli = 1 &#039;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($sWhere != &#039;&#039;) {
    $sWhere .= &#039; AND feria_cli = 1  AND active_fair_sts = 1&#039;;
} else {
    $sWhere .= &#039; WHERE  (feria_cli = 1   AND active_fair_sts = 1)&#039;;
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/ferias/clients-form.php:106
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsSources = &quot;SELECT * FROM properties_client_sources ORDER BY id_sts desc,  category_en_sts ASC&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsSources = &quot;SELECT * FROM properties_client_sources WHERE active_fair_sts = 1 ORDER BY id_sts desc,  category_en_sts ASC&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadir automáticamente los textos legales a la BBDD
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/gdpr.php:2904
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;form&gt;
    &lt;div class=&quot;form-group&quot;&gt;
        &lt;select name=&quot;document&quot; id=&quot;document&quot; class=&quot;form-control form-control-sm&quot;&gt;
            &lt;option value=&quot;&quot;&gt;Seleccione un documento...&lt;/option&gt;
            &lt;?php
            $path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates&#039;;
            $files = array_diff(scandir($path), array(&#039;.&#039;, &#039;..&#039;));
            ?&gt;
            &lt;?php foreach ($files as $file) { ?&gt;
                &lt;?php if (preg_match(&#039;/\.txt/&#039;, $file)): ?&gt;
                    &lt;?php $sel = ($_GET[&#039;doc&#039;] == $file)?&#039; selected=&quot;selected&quot;&#039;:&#039;&#039;; ?&gt;
                    &lt;option value=&quot;&lt;?php echo $file ?&gt;&quot; &lt;?php echo $sel; ?&gt;&gt;&lt;?php echo ucfirst(str_replace(array(&#039;.txt&#039;, &#039;_&#039;), array(&#039;&#039;, &#039; &#039;), $file)); ?&gt;&lt;/option&gt;
                &lt;?php endif ?&gt;
            &lt;?php } ?&gt;
        &lt;/select&gt;
        &lt;?php if ($_GET[&#039;doc&#039;] != &#039;&#039; &amp;&amp; file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;])): ?&gt;
        &lt;?php $doc_text = file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;]); ?&gt;
        &lt;?php $doc_text = htmlentities($doc_text); ?&gt;
            &lt;hr&gt;
            &lt;?php $campos = getContents($doc_text, &#039;@@&#039;, &#039;@@&#039;); ?&gt;
            &lt;?php foreach (array_unique($campos) as $campo) { ?&gt;
                &lt;?php $parts = explode(&#039;||&#039;, $campo) ?&gt;
                &lt;div class=&quot;form-group&quot;&gt;
                    &lt;input type=&quot;text&quot; class=&quot;form-control form-control-sm entrada-texto&quot; name=&quot;&lt;?php echo clean($parts[0]); ?&gt;-txt&quot; id=&quot;&lt;?php echo clean($parts[0]); ?&gt;-txt&quot; placeholder=&quot;&lt;?php echo $parts[0]; ?&gt;&quot;&gt;
                    &lt;small class=&quot;form-text text-muted&quot;&gt;&lt;?php echo $parts[1]; ?&gt;&lt;/small&gt;
                &lt;/div&gt;
                &lt;hr&gt;
                &lt;?php $doc_text = str_replace(&#039;@@&#039; . $campo . &#039;@@&#039;, &#039;&lt;span class=&quot;&#039;. clean($parts[0]) . &#039;-span text-danger&quot;&gt;&lt;/span&gt;&#039;, $doc_text); ?&gt;
            &lt;?php } ?&gt;
        &lt;?php endif ?&gt;
    &lt;/div&gt;
&lt;/form&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;form method=&quot;POST&quot;&gt;
   &lt;div class=&quot;form-group&quot;&gt;
      &lt;select name=&quot;document&quot; id=&quot;document&quot; class=&quot;form-control form-control-sm&quot;&gt;
         &lt;option value=&quot;&quot;&gt;Seleccione un documento...&lt;/option&gt;
         &lt;?php
            $path = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates&#039;;
            $files = array_diff(scandir($path), array(&#039;.&#039;, &#039;..&#039;));
        ?&gt;
         &lt;?php foreach ($files as $file) { ?&gt;
         &lt;?php if (preg_match(&#039;/\.txt/&#039;, $file)): ?&gt;
         &lt;?php $sel = ($_GET[&#039;doc&#039;] == $file) ? &#039; selected=&quot;selected&quot;&#039; : &#039;&#039;; ?&gt;
         &lt;option value=&quot;&lt;?php echo $file ?&gt;&quot; &lt;?php echo $sel; ?&gt;&gt;&lt;?php echo ucfirst(str_replace(array(&#039;.txt&#039;, &#039;_&#039;), array(&#039;&#039;, &#039; &#039;), $file)); ?&gt;&lt;/option&gt;
         &lt;?php endif ?&gt;
         &lt;?php } ?&gt;
      &lt;/select&gt;
      &lt;?php if ($_GET[&#039;doc&#039;] != &#039;&#039; &amp;&amp; file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;])): ?&gt;
      &lt;?php $doc_text = file_get_contents($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;]); ?&gt;
      &lt;?php $doc_text = htmlentities($doc_text); ?&gt;
      &lt;hr&gt;
      &lt;?php $campos = getContents($doc_text, &#039;@@&#039;, &#039;@@&#039;); ?&gt;
      &lt;?php foreach (array_unique($campos) as $campo) { ?&gt;
      &lt;?php $parts = explode(&#039;||&#039;, $campo) ?&gt;
      &lt;div class=&quot;form-group&quot;&gt;
         &lt;input type=&quot;text&quot; class=&quot;form-control form-control-sm entrada-texto&quot; name=&quot;&lt;?php echo clean($parts[0]); ?&gt;-txt&quot; id=&quot;&lt;?php echo clean($parts[0]); ?&gt;-txt&quot; placeholder=&quot;&lt;?php echo $parts[0]; ?&gt;&quot;&gt;
         &lt;small class=&quot;form-text text-muted&quot;&gt;&lt;?php echo $parts[1]; ?&gt;&lt;/small&gt;
      &lt;/div&gt;
      &lt;hr&gt;
      &lt;?php $doc_text = str_replace(&#039;@@&#039; . $campo . &#039;@@&#039;, &#039;&lt;span class=&quot;&#039; . clean($parts[0]) . &#039;-span text-danger&quot;&gt;&lt;/span&gt;&#039;, $doc_text); ?&gt;
      &lt;?php } ?&gt;
      &lt;?php endif ?&gt;
   &lt;/div&gt;
   &lt;?php if ($_GET[&#039;doc&#039;] != &#039;&#039; &amp;&amp; file_exists($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/_herramientas/templates/&#039; . $_GET[&#039;doc&#039;])): ?&gt;
   &lt;div class=&quot;form-group&quot;&gt;
      &lt;input type=&quot;submit&quot; class=&quot;btn btn-primary text-white&quot; value=&quot;&lt;?php if ($_GET[&#039;doc&#039;] == &#039;texto correos.txt&#039;) {
         echo &#039;Actualizar archivos&#039;;
         } else {
         echo &#039;Guardar texto&#039;;
         }; ?&gt;&quot;&gt;
   &lt;/div&gt;
   &lt;?php endif ?&gt;
&lt;/form&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/includes/mailtemplates/template_acumba.html
/includes/mailtemplates/template_semanal.html
/includes/mailtemplates/template.html
            </code>
        </pre>
        Donde se supone que van los avisos legales substituir por:
        <pre>
            <code class="php">
{AVISOLEGAL}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Traducciones para el texto GDPR
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:289
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR[$lang]);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/gdpr.php:10
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$texto_formularios_GDPR = &quot;
&lt;b&gt;Responsable del tratamiento:&lt;/b&gt; $empresa_GDPR,
&lt;b&gt;Finalidad del tratamiento:&lt;/b&gt; Gesti&oacute;n y control de los servicios ofrecidos a trav&eacute;s de la p&aacute;gina Web de Servicios inmobiliarios, Env&iacute;o de informaci&oacute;n a traves de newsletter y otros,
 &lt;b&gt;Legitimaci&oacute;n:&lt;/b&gt; Por consentimiento,
 &lt;b&gt;Destinatarios:&lt;/b&gt; No se cederan los datos, salvo para elaborar contabilidad,
 &lt;b&gt;Derechos de las personas interesadas:&lt;/b&gt; Acceder, rectificar y suprimir los datos, solicitar la portabilidad de los mismos, oponerse altratamiento y solicitar la limitaci&oacute;n de &eacute;ste,
 &lt;b&gt;Procedencia de los datos: &lt;/b&gt; El Propio interesado,
 &lt;b&gt;Informaci&oacute;n Adicional: &lt;/b&gt; Puede consultarse la informaci&oacute;n adicional y detallada sobre protecci&oacute;n de datos &lt;a href=\&quot;$url_privacidad_GDPR\&quot; target=\&quot;_blank\&quot;&gt;Aqu&iacute;&lt;/a&gt;.
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER["DOCUMENT_ROOT"] . '/resources/textos_legales.php');
            </code>
        </pre>
        <hr>
        Añadimos el archivo:
        <pre>
            <code class="makefile">
/resources/textos_legales.php
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix cron importar inmuebles
    </h6>
    <div class="card-body">
        El nuevo cron para <code>/intramedianet/xml/import-cron.php</code> es 0 */2 * * *
        </pre>
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec10">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix Fotocasa Insert/Update inmuebles importados
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:829
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ( $tNG-&gt;getColumnValue(&#039;export_fotocasa_prop&#039;) ==  1 &amp;&amp;
     $tNG-&gt;getColumnValue(&#039;activado_prop&#039;) == 1 &amp;&amp;
     $tNG-&gt;getColumnValue(&#039;vendido_prop&#039;) == 0 &amp;&amp;
     $tNG-&gt;getColumnValue(&#039;reservado_prop&#039;) == 0 &amp;&amp;
     $tNG-&gt;getColumnValue(&#039;alquilado_prop&#039;) == 0
 ) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ( $tNG-&gt;getColumnValue(&#039;export_fotocasa_prop&#039;) ==  1 &amp;&amp;
     $tNG-&gt;getColumnValue(&#039;activado_prop&#039;) == 1 &amp;&amp;
     ($tNG-&gt;getColumnValue(&#039;vendido_prop&#039;) == 0 || $tNG-&gt;getColumnValue(&#039;vendido_prop&#039;) == NULL) &amp;&amp;
     ($tNG-&gt;getColumnValue(&#039;reservado_prop&#039;) == 0 || $tNG-&gt;getColumnValue(&#039;reservado_prop&#039;) == NULL) &amp;&amp;
     ($tNG-&gt;getColumnValue(&#039;alquilado_prop&#039;) == 0 || $tNG-&gt;getColumnValue(&#039;alquilado_prop&#039;) == NULL)
) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>