<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 30-01-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Error en Properties last changes</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Error en importador de mediaelx</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> En compradores no se añaden sources sin añadir un idioma de los dos requeridos</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido ChatGPT a los inmuebles</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en Properties last changes
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/history-data.php:250
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if($row_rsMenu)
  $row[] = &#039;&lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&#039;.$row_rsMenu[&#039;id_prop&#039;].&#039;&quot; target=&quot;_blank&quot; class=&quot;btn btn-soft-primary btn-sm&quot;&gt;&#039;. $aRow[ $aColumns[$i] ] . &#039;&lt;/a&gt;&rsquo;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($row_rsMenu) {
    $row[] = &#039;&lt;a href=&quot;/intramedianet/properties/properties-form.php?id_prop=&#039;.$row_rsMenu[&#039;id_prop&#039;].&#039;&quot; target=&quot;_blank&quot; class=&quot;btn btn-soft-primary btn-sm&quot;&gt;&#039;. $aRow[ $aColumns[$i] ] . &#039;&lt;/a&gt;&#039;;
} else  {
    $row[]  = &#039;&#039;;
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en importador de mediaelx
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Mediaelx.php:68
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// $townName = setTown((string)$property-&gt;town, $provinceID, $provinceName);
$townName = setTown2((string)$property-&gt;town, $provinceID, $provinceName, (string)$property-&gt;costa);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($property-&gt;costa != &#039;&#039;) {
     $townName = setTown2((string)$property-&gt;town, $provinceID, $provinceName, (string)$property-&gt;costa);
} else {
    $townName = setTown((string)$property-&gt;town, $provinceID, $provinceName);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> En compradores no se añaden sources sin añadir un idioma de los dos requeridos
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function myHandler999() {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function myHandler999() {
    if ($(&#039;#myModal5 #category_es_sts&#039;).val() ==&#039;&#039; || $(&#039;#myModal5 #category_en_sts&#039;).val() == &#039;&#039;) {
        return false;
    }
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido ChatGPT a los inmuebles
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `chatgpt_prompt_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
            </code>
        </pre>
        <hr>
        Añadimos el archivos:
        <pre>
            <code>
/Connections/conf/chatgpt.php
/intramedianet/properties/prompt.php
/intramedianet/properties/prompt-trans.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/inmoconn.php:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/secciones.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/secciones.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/chatgpt.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1172
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;precio_desde_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;precio_desde_prop&quot;, &quot;0&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;precio_desde_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;precio_desde_prop&quot;, &quot;0&quot;);
if ($actChatGPT == 1) {
$ins_properties_properties-&gt;addColumn(&quot;chatgpt_prompt_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;chatgpt_prompt_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1426
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;precio_desde_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;precio_desde_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;precio_desde_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;precio_desde_prop&quot;);
if ($actChatGPT == 1) {
$upd_properties_properties-&gt;addColumn(&quot;chatgpt_prompt_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;chatgpt_prompt_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2632
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;/div&gt;

&lt;?php if ($actChatGPT == 1): ?&gt;

&lt;?php if ($_SERVER[&quot;HTTP_HOST&quot;] != &#039;demo.mediaelx.info&#039; || ($_SERVER[&quot;HTTP_HOST&quot;] == &#039;demo.mediaelx.info&#039; &amp;&amp; ($_SESSION[&#039;kt_login_id&#039;] == 47 || $_SESSION[&#039;kt_login_id&#039;] == 48 || $_SESSION[&#039;kt_login_id&#039;] == 49 || $_SESSION[&#039;kt_login_id&#039;] == 238))): ?&gt;

&lt;div class=&quot;card position-relative&quot;&gt;
    &lt;div class=&quot;card-header align-items-center d-flex&quot;&gt;
        &lt;div class=&quot;flex-grow-1 oveflow-hidden&quot;&gt;
            &lt;h4 class=&quot;card-title mb-0 flex-grow-1&quot;&gt;&lt;?php __(&#039;ChatGPT&#039;); ?&gt;: &lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;referencia_prop&#039;]); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;card-body&quot;&gt;

        &lt;div class=&quot;row&quot;&gt;

            &lt;div class=&quot;col&quot;&gt;

                &lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
                    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
                &lt;/div&gt;

            &lt;/div&gt;

        &lt;/div&gt; &lt;!--/.row --&gt;

        &lt;div class=&quot;row&quot;&gt;

            &lt;div class=&quot;col-6 col-md-4&quot;&gt;
                &lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-primary w-100 gratgptmodal&quot; data-action=&quot;getText&quot; data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#ChatGPTModal&quot;&gt;&lt;i class=&quot;fa-solid fa-fw fa-message-captions me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Generar&#039;); ?&gt;&lt;/a&gt;
            &lt;/div&gt;

            &lt;div class=&quot;col-6 col-md-4&quot;&gt;
                &lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-primary w-100 gratgptmodal&quot; data-action=&quot;getTrans&quot; data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#ChatGPTransModal&quot;&gt;&lt;i class=&quot;fa-regular fa-fw fa-language me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Traducir&#039;); ?&gt;&lt;/a&gt;
            &lt;/div&gt;

        &lt;/div&gt;

    &lt;/div&gt;&lt;!-- end card-body --&gt;
&lt;/div&gt;

&lt;?php endif ?&gt;

&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2683
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
        &lt;ul class=&quot;nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0&quot; role=&quot;tablist&quot;&gt;
            &lt;?php foreach($languages as $value) { ?&gt;
                &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                    &lt;a class=&quot;nav-link &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langdescprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                        &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;?php } ?&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;card-body&quot;&gt;

    &lt;ul class=&quot;nav nav-pills nav-custom nav-custom-light mb-3 d-md-none&quot; role=&quot;tablist&quot;&gt;
        &lt;?php foreach($languages as $value) { ?&gt;
            &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                &lt;a class=&quot;nav-link &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langdescprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                    &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                &lt;/a&gt;
            &lt;/li&gt;
        &lt;?php } ?&gt;
    &lt;/ul&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
        &lt;ul class=&quot;nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0&quot; role=&quot;tablist&quot;&gt;
            &lt;?php foreach($languages as $value) { ?&gt;
                &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                    &lt;a class=&quot;nav-link tabdescr tabdescr-&lt;?php echo $value; ?&gt; &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langdescprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot; data-lang=&quot;&lt;?php echo $value; ?&gt;&quot;&gt;
                        &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                    &lt;/a&gt;
                &lt;/li&gt;
            &lt;?php } ?&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;card-body&quot;&gt;

    &lt;ul class=&quot;nav nav-pills nav-custom nav-custom-light mb-3 d-md-none&quot; role=&quot;tablist&quot;&gt;
        &lt;?php foreach($languages as $value) { ?&gt;
            &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                &lt;a class=&quot;nav-link tabdescr-&lt;?php echo $value; ?&gt; &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langdescprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                    &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                &lt;/a&gt;
            &lt;/li&gt;
        &lt;?php } ?&gt;
    &lt;/ul&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:3131
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
        &lt;ul class=&quot;nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0&quot; role=&quot;tablist&quot;&gt;
            &lt;?php foreach($languages as $value) { ?&gt;
            &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                &lt;a class=&quot;nav-link &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langseoprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                    &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                &lt;/a&gt;
            &lt;/li&gt;
            &lt;?php } ?&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;card-body&quot;&gt;

    &lt;ul class=&quot;nav nav-pills nav-custom nav-custom-light mb-3 d-md-none&quot; role=&quot;tablist&quot;&gt;
        &lt;?php foreach($languages as $value) { ?&gt;
        &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
            &lt;a class=&quot;nav-link &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langseoprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
            &lt;/a&gt;
        &lt;/li&gt;
        &lt;?php } ?&gt;
    &lt;/ul&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
        &lt;ul class=&quot;nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0&quot; role=&quot;tablist&quot;&gt;
            &lt;?php foreach($languages as $value) { ?&gt;
            &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
                &lt;a class=&quot;nav-link tabmet-&lt;?php echo $value; ?&gt; &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langseoprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                    &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
                &lt;/a&gt;
            &lt;/li&gt;
            &lt;?php } ?&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;card-body&quot;&gt;

    &lt;ul class=&quot;nav nav-pills nav-custom nav-custom-light mb-3 d-md-none&quot; role=&quot;tablist&quot;&gt;
        &lt;?php foreach($languages as $value) { ?&gt;
        &lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
            &lt;a class=&quot;nav-link tabmet-&lt;?php echo $value; ?&gt; &lt;?php if($value == $language) { ?&gt;active&lt;?php } ?&gt;&quot; data-bs-toggle=&quot;tab&quot; href=&quot;#langseoprop-&lt;?php echo $value; ?&gt;&quot; role=&quot;tab&quot; aria-selected=&quot;true&quot;&gt;
                &lt;img src=&quot;/intramedianet/includes/assets/imgs/flags/&lt;?php echo $value; ?&gt;.svg&quot; alt=&quot;&quot; class=&quot;border rounded-circle&quot; height=&quot;20&quot;&gt;
            &lt;/a&gt;
        &lt;/li&gt;
        &lt;?php } ?&gt;
    &lt;/ul&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4930
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;/form&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
        &lt;div class=&quot;modal fade&quot; id=&quot;ChatGPTModal&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;ChatGPTModalLabel&quot; aria-hidden=&quot;true&quot;&gt;
            &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
                &lt;div class=&quot;modal-content&quot;&gt;
                    &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                        &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModalLabel&quot;&gt;&lt;i class=&quot;fa-solid fa-fw fa-message-captions me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Generar&#039;); ?&gt;&lt;/h5&gt;
                        &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-body&quot;&gt;
                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-12&quot;&gt;
                                &lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
                                    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-12&quot;&gt;
                                &lt;div class=&quot;mb-2 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;chatgpt_prompt_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
                                    &lt;label for=&quot;chatgpt_prompt_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Extra prompt&#039;); ?&gt;:&lt;/label&gt;
                                    &lt;textarea name=&quot;chatgpt_prompt_prop&quot; id=&quot;chatgpt_prompt_prop&quot; cols=&quot;50&quot; rows=&quot;4&quot; class=&quot;form-control&quot;&gt;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;chatgpt_prompt_prop&#039;]); ?&gt;&lt;/textarea&gt;
                                    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;chatgpt_prompt_prop&quot;); ?&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-12&quot;&gt;

                                &lt;label for=&quot;toLng&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Idioma&#039;); ?&gt;:&lt;/label&gt;
                                &lt;select name=&quot;toLng&quot; id=&quot;toLng&quot; class=&quot;form-select required&quot; required&gt;
                                    &lt;!-- &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt; --&gt;
                                    &lt;?php
                                    if ($lang_adm == &#039;es&#039;) {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catal&aacute;n&#039;, &#039;da&#039; =&gt; &#039;Dan&eacute;s&#039;, &#039;de&#039; =&gt; &#039;Alem&aacute;n&#039;, &#039;el&#039; =&gt; &#039;Griego&#039;, &#039;en&#039; =&gt; &#039;Ingl&eacute;s&#039;, &#039;es&#039; =&gt; &#039;Espa&ntilde;ol&#039;, &#039;fi&#039; =&gt; &#039;Finland&eacute;s&#039;, &#039;fr&#039; =&gt; &#039;Franc&eacute;s&#039;, &#039;is&#039; =&gt; &#039;Island&eacute;s&#039;, &#039;it&#039; =&gt; &#039;Italiano&#039;, &#039;nl&#039; =&gt; &#039;Holand&eacute;s&#039;, &#039;no&#039; =&gt; &#039;Noruego&#039;, &#039;pt&#039; =&gt; &#039;Portugu&eacute;s&#039;, &#039;ru&#039; =&gt; &#039;Ruso&#039;, &#039;se&#039; =&gt; &#039;Sueco&#039;, &#039;zh&#039; =&gt; &#039;Chino&#039;, &#039;pl&#039; =&gt; &#039;Polaco&#039;);
                                    } else {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catalan&#039;, &#039;da&#039; =&gt; &#039;Danish&#039;, &#039;de&#039; =&gt; &#039;German&#039;, &#039;el&#039; =&gt; &#039;Greek&#039;, &#039;en&#039; =&gt; &#039;English&#039;, &#039;es&#039; =&gt; &#039;Spanish&#039;, &#039;fi&#039; =&gt; &#039;Finnish&#039;, &#039;fr&#039; =&gt; &#039;French&#039;, &#039;is&#039; =&gt; &#039;Icelandic&#039;, &#039;it&#039; =&gt; &#039;Italian&#039;, &#039;nl&#039; =&gt; &#039;Dutch&#039;, &#039;no&#039; =&gt; &#039;Norwegian&#039;, &#039;pt&#039; =&gt; &#039;Portuguese&#039;, &#039;ru&#039; =&gt; &#039;Russian&#039;, &#039;se&#039; =&gt; &#039;Swedish&#039;, &#039;zh&#039; =&gt; &#039;Chinese&#039;, &#039;pl&#039; =&gt; &#039;Polish&#039;);
                                    }
                                    foreach ($languages as $value) {
                                        echo &#039;&lt;option value=&quot;&#039;.$value.&#039;&quot;&gt;&#039;.$idiomas[$value].&#039;&lt;/option&gt;&#039;;
                                    }
                                    ?&gt;
                                &lt;/select&gt;

                            &lt;/div&gt;

                            &lt;div class=&quot;col-12&quot;&gt;
                                &lt;hr&gt;
                            &lt;/div&gt;

                            &lt;div class=&quot;col-12 mb-3&quot; id=&quot;gentextradios&quot;&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction1&quot; value=&quot;titulo__prop&quot; checked&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction1&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction2&quot; value=&quot;descripcion__prop&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;?php /* ?&gt;
                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction3&quot; value=&quot;title__prop&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction3&quot;&gt;&lt;?php __(&#039;Meta title&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptAction&quot; id=&quot;gptAction4&quot; value=&quot;description__prop&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptAction4&quot;&gt;&lt;?php __(&#039;Meta description&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;
                                &lt;?php */ ?&gt;

                            &lt;/div&gt;

                        &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-footer bg-soft-primary&quot;&gt;
                        &lt;a href=&quot;#&quot; class=&quot;btn btn-success mt-4 generateTXTgpt&quot;&gt;&lt;?php __(&#039;Generar&#039;); ?&gt;&lt;/a&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal fade&quot; id=&quot;ChatGPTransModal&quot; tabindex=&quot;-1&quot; aria-labelledby=&quot;ChatGPTransModalLabel&quot; aria-hidden=&quot;true&quot;&gt;
            &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
                &lt;div class=&quot;modal-content&quot;&gt;
                    &lt;div class=&quot;modal-header bg-primary&quot;&gt;
                        &lt;h5 class=&quot;modal-title text-white pb-3&quot; id=&quot;myModalLabel&quot;&gt;&lt;i class=&quot;fa-regular fa-fw fa-language me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;Traducir&#039;); ?&gt;&lt;/h5&gt;
                        &lt;button type=&quot;button&quot; class=&quot;btn-close bg-white mb-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt; &lt;/button&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-body&quot;&gt;
                        &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-12&quot;&gt;
                                &lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
                                    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-12 mb-3&quot; id=&quot;gentextradios&quot;&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans1&quot; value=&quot;titulo_&quot; checked&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans1&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans2&quot; value=&quot;descripcion_&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans2&quot;&gt;&lt;?php __(&#039;Descripci&oacute;n&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;?php /* ?&gt;
                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans3&quot; value=&quot;title_&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans3&quot;&gt;&lt;?php __(&#039;Meta title&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;

                                &lt;div class=&quot;form-check form-switch form-switch-lg form-check-inline&quot;&gt;
                                    &lt;input class=&quot;form-check-input actransgpt&quot; type=&quot;radio&quot; role=&quot;switch&quot; name=&quot;gptActionTrans&quot; id=&quot;gptActionTrans4&quot; value=&quot;description_&quot;&gt;
                                    &lt;label class=&quot;form-check-label&quot; for=&quot;gptActionTrans4&quot;&gt;&lt;?php __(&#039;Meta description&#039;); ?&gt;&lt;/label&gt;
                                &lt;/div&gt;
                                &lt;?php */ ?&gt;

                            &lt;/div&gt;

                            &lt;hr&gt;

                            &lt;div class=&quot;col-6&quot;&gt;

                                &lt;label for=&quot;fromtrans&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Traducir desde&#039;); ?&gt;:&lt;/label&gt;
                                &lt;select name=&quot;fromtrans&quot; id=&quot;fromtrans&quot; class=&quot;form-select required&quot; required&gt;
                                    &lt;!-- &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt; --&gt;
                                    &lt;?php
                                    if ($lang_adm == &#039;es&#039;) {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catal&aacute;n&#039;, &#039;da&#039; =&gt; &#039;Dan&eacute;s&#039;, &#039;de&#039; =&gt; &#039;Alem&aacute;n&#039;, &#039;el&#039; =&gt; &#039;Griego&#039;, &#039;en&#039; =&gt; &#039;Ingl&eacute;s&#039;, &#039;es&#039; =&gt; &#039;Espa&ntilde;ol&#039;, &#039;fi&#039; =&gt; &#039;Finland&eacute;s&#039;, &#039;fr&#039; =&gt; &#039;Franc&eacute;s&#039;, &#039;is&#039; =&gt; &#039;Island&eacute;s&#039;, &#039;it&#039; =&gt; &#039;Italiano&#039;, &#039;nl&#039; =&gt; &#039;Holand&eacute;s&#039;, &#039;no&#039; =&gt; &#039;Noruego&#039;, &#039;pt&#039; =&gt; &#039;Portugu&eacute;s&#039;, &#039;ru&#039; =&gt; &#039;Ruso&#039;, &#039;se&#039; =&gt; &#039;Sueco&#039;, &#039;zh&#039; =&gt; &#039;Chino&#039;, &#039;pl&#039; =&gt; &#039;Polaco&#039;);
                                    } else {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catalan&#039;, &#039;da&#039; =&gt; &#039;Danish&#039;, &#039;de&#039; =&gt; &#039;German&#039;, &#039;el&#039; =&gt; &#039;Greek&#039;, &#039;en&#039; =&gt; &#039;English&#039;, &#039;es&#039; =&gt; &#039;Spanish&#039;, &#039;fi&#039; =&gt; &#039;Finnish&#039;, &#039;fr&#039; =&gt; &#039;French&#039;, &#039;is&#039; =&gt; &#039;Icelandic&#039;, &#039;it&#039; =&gt; &#039;Italian&#039;, &#039;nl&#039; =&gt; &#039;Dutch&#039;, &#039;no&#039; =&gt; &#039;Norwegian&#039;, &#039;pt&#039; =&gt; &#039;Portuguese&#039;, &#039;ru&#039; =&gt; &#039;Russian&#039;, &#039;se&#039; =&gt; &#039;Swedish&#039;, &#039;zh&#039; =&gt; &#039;Chinese&#039;, &#039;pl&#039; =&gt; &#039;Polish&#039;);
                                    }
                                    foreach ($languages as $value) {
                                        $selected = (isset($lang_adm) &amp;&amp; !(strcmp($value, $lang_adm)))?&quot; SELECTED&quot;:&quot;&quot;;
                                        echo &#039;&lt;option value=&quot;&#039;.$value.&#039;&quot;&#039;.$selected.&#039;&gt;&#039;.$idiomas[$value].&#039;&lt;/option&gt;&#039;;
                                    }
                                    ?&gt;
                                &lt;/select&gt;

                            &lt;/div&gt;
                            &lt;div class=&quot;col-6&quot;&gt;

                                &lt;label for=&quot;totrans&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Traducir a&#039;); ?&gt;:&lt;/label&gt;
                                &lt;select name=&quot;totrans&quot; id=&quot;totrans&quot; class=&quot;form-select required&quot; required&gt;
                                    &lt;!-- &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt; --&gt;
                                    &lt;?php
                                    if ($lang_adm == &#039;es&#039;) {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catal&aacute;n&#039;, &#039;da&#039; =&gt; &#039;Dan&eacute;s&#039;, &#039;de&#039; =&gt; &#039;Alem&aacute;n&#039;, &#039;el&#039; =&gt; &#039;Griego&#039;, &#039;en&#039; =&gt; &#039;Ingl&eacute;s&#039;, &#039;es&#039; =&gt; &#039;Espa&ntilde;ol&#039;, &#039;fi&#039; =&gt; &#039;Finland&eacute;s&#039;, &#039;fr&#039; =&gt; &#039;Franc&eacute;s&#039;, &#039;is&#039; =&gt; &#039;Island&eacute;s&#039;, &#039;it&#039; =&gt; &#039;Italiano&#039;, &#039;nl&#039; =&gt; &#039;Holand&eacute;s&#039;, &#039;no&#039; =&gt; &#039;Noruego&#039;, &#039;pt&#039; =&gt; &#039;Portugu&eacute;s&#039;, &#039;ru&#039; =&gt; &#039;Ruso&#039;, &#039;se&#039; =&gt; &#039;Sueco&#039;, &#039;zh&#039; =&gt; &#039;Chino&#039;, &#039;pl&#039; =&gt; &#039;Polaco&#039;);
                                    } else {
                                        $idiomas = array(&#039;ca&#039; =&gt; &#039;Catalan&#039;, &#039;da&#039; =&gt; &#039;Danish&#039;, &#039;de&#039; =&gt; &#039;German&#039;, &#039;el&#039; =&gt; &#039;Greek&#039;, &#039;en&#039; =&gt; &#039;English&#039;, &#039;es&#039; =&gt; &#039;Spanish&#039;, &#039;fi&#039; =&gt; &#039;Finnish&#039;, &#039;fr&#039; =&gt; &#039;French&#039;, &#039;is&#039; =&gt; &#039;Icelandic&#039;, &#039;it&#039; =&gt; &#039;Italian&#039;, &#039;nl&#039; =&gt; &#039;Dutch&#039;, &#039;no&#039; =&gt; &#039;Norwegian&#039;, &#039;pt&#039; =&gt; &#039;Portuguese&#039;, &#039;ru&#039; =&gt; &#039;Russian&#039;, &#039;se&#039; =&gt; &#039;Swedish&#039;, &#039;zh&#039; =&gt; &#039;Chinese&#039;, &#039;pl&#039; =&gt; &#039;Polish&#039;);
                                    }
                                    foreach ($languages as $value) {
                                        echo &#039;&lt;option value=&quot;&#039;.$value.&#039;&quot;&gt;&#039;.$idiomas[$value].&#039;&lt;/option&gt;&#039;;
                                    }
                                    ?&gt;
                                &lt;/select&gt;

                            &lt;/div&gt;

                        &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;modal-footer bg-soft-primary&quot;&gt;
                        &lt;a href=&quot;#&quot; class=&quot;btn btn-success mt-4 generateTXTTradgpt&quot;&gt;&lt;?php __(&#039;Generar&#039;); ?&gt;&lt;/a&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;

    &lt;/form&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Añadir antes de <code>&lt;/body&gt;</code>:
        <pre>
            <code class="php">
&lt;script&gt;
    $(&#039;.generateTXTgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actgpt:checked&quot;).val();
        $toLng = $(&quot;#toLng option:selected&quot;).text();
        $toLngVal = $(&quot;#toLng option:selected&quot;).val();
        $prompt = $(&quot;#chatgpt_prompt_prop&quot;).val();

        if ($action == &#039;titulo__prop&#039;) { // Titular
            action = &#039;title&#039;;
        }
        if ($action == &#039;descripcion__prop&#039;) { // Descripci&oacute;n
            action = &#039;description&#039;;
        }
        if ($action == &#039;title__prop&#039;) { // Meta Title
            action = &#039;metatit&#039;;
        }
        if ($action == &#039;description__prop&#039;) { // Meta Description
            action = &#039;metades&#039;;
        }

        $.get(&quot;prompt.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&quot; + $toLngVal +  &quot;&amp;langto=&quot; + $toLng + &quot;&amp;action=&quot; + action + &quot;&amp;prompt=&quot; + $prompt, function(data) {
            $field = &#039;#&#039; + $action.replace(&#039;__&#039;, &#039;_&#039; + $toLngVal + &#039;_&#039;);

            if ($action == &#039;descripcion__prop&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $toLngVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $toLngVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });
&lt;/script&gt;
&lt;script&gt;
    $(&#039;.generateTXTTradgpt&#039;).click(function(e) {
        e.preventDefault();

        $(&#039;#ChatGPTransModal .modal-body&#039;).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);

        $action = $(&quot;.actransgpt:checked&quot;).val();
        $fromtrans = $(&quot;#fromtrans option:selected&quot;).text();
        $fromtransVal = $(&quot;#fromtrans option:selected&quot;).val();
        $totrans = $(&quot;#totrans option:selected&quot;).text();
        $totransVal = $(&quot;#totrans option:selected&quot;).val();

        $.get(&quot;prompt-trans.php?id_prop=&lt;?php echo $property_id; ?&gt;&amp;lang=&lt;?php echo $lang_adm; ?&gt;&amp;action=&quot; + $action + &quot;&amp;from=&quot; + $fromtrans + &quot;&amp;to=&quot; + $totrans + &quot;&quot; , function(data) {
            $field = &#039;#&#039; + $action + $totransVal + &#039;_prop&#039;;
            if ($action == &#039;descripcion_&#039;) {
                $($field).redactor(&#039;source.setCode&#039;, data);
            } else {
                $($field).val(data).keyup();
            }
            $(&#039;#ChatGPTransModal .loading&#039;).remove().keyup();

            const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $totransVal);
            const tabInstance = new bootstrap.Tab(contactTab);
            tabInstance.show();
            const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $totransVal);
            const tabInstance2 = new bootstrap.Tab(contactTab2);
            tabInstance2.show();
        });

    });

    $(&#039;.tabdescr&#039;).click(function(e) {
        e.preventDefault();
        $(&#039;#toLng option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
        $(&#039;#fromtrans option[value=&quot;&#039; + $(this).data(&#039;lang&#039;) + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#toLng&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#toLng option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#fromtrans option[value=&quot;&#039; + $( &quot;#toLng option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });

    $(&#039;#fromtrans&#039;).change(function(e) {
        const contactTab = document.querySelector(&#039;.tabdescr-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance = new bootstrap.Tab(contactTab);
        tabInstance.show();
        const contactTab2 = document.querySelector(&#039;.tabmet-&#039; + $( &quot;#fromtrans option:selected&quot;).val());
        const tabInstance2 = new bootstrap.Tab(contactTab2);
        tabInstance2.show();
        $(&#039;#toLng option[value=&quot;&#039; + $( &quot;#fromtrans option:selected&quot;).val() + &#039;&quot;]&#039;).prop(&#039;selected&#039;, true);
    });
&lt;/script&gt;
&lt;style&gt;
#ChatGPTModal .modal-body,
#ChatGPTransModal .modal-body {
    position: relative;
    min-height: 150px;
}
#ChatGPTModal .loading,
#ChatGPTransModal .loading {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9) url(/media/images/website/large-loading.gif) no-repeat center center;
}
&lt;/style&gt;
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
$lang[&#039;Extra prompt&#039;] = &#039;Informaci&oacute;n adicional para ChatGPT del inmueble&#039;;
$lang[&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;] = &#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;;
$lang[&#039;A&ntilde;adir al meta title&#039;] = &#039;A&ntilde;adir al meta title&#039;;
$lang[&#039;Traducir desde&#039;] = &#039;Traducir desde&#039;;
$lang[&#039;Traducir a&#039;] = &#039;Traducir a&#039;;
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
$lang[&#039;Extra prompt&#039;] = &#039;Additional property information for ChatGPT&#039;;
$lang[&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;] = &#039;Remember to save the property before using ChatGPT&#039;;
$lang[&#039;A&ntilde;adir al meta title&#039;] = &#039;Add to meta title&#039;;
$lang[&#039;Traducir desde&#039;] = &#039;Translate from&#039;;
$lang[&#039;Traducir a&#039;] = &#039;Translate to&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>