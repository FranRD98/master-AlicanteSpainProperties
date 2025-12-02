<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 21-03-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Error al contar los inmuebles de critérios de búsqueda</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Añadido nuevo advertencia en la interface de ChatGPT</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Eliminado que el usuario CRM añada promociones</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Fix envío email bienvenida en ferias </a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Nueva plantilla TV</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Error Master convertir en cliente si ya está creado</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-bug text-danger"></i> Fix metros cuadrados de inmuebles, deja poner cualquier texto</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al contar los inmuebles de critérios de búsqueda
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/properties/_count_news.php:751
/intramedianet/properties/_count_news2.php:753
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
AND activado_prop = 1 AND vendido_prop = 0 AND alquilado_prop = 0 AND vendido_tag_prop = 0 AND reservado_prop = 0 AND force_hide_prop != 1
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido nuevo advertencia en la interface de ChatGPT
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2650
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
&lt;/div&gt;

&lt;div class=&quot;alert alert-warning alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-exclamation label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;ChatGPTAdv1&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4944
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;alert alert-info alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;Recuerde salvar el inmueble antes de utitizar ChatGPT&#039;); ?&gt;
&lt;/div&gt;
&lt;div class=&quot;alert alert-warning alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-exclamation label-icon&quot;&gt;&lt;/i&gt; &lt;?php echo __(&#039;ChatGPTAdv1&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;ChatGPTAdv1&#039;] = &#039;&lt;b&gt;IMPORTANTE:&lt;/b&gt; si vas a cambiar la descripci&oacute;n de una casa importada por XML, aseg&uacute;rate de desmarcar el campo Descripci&oacute;n en la ficha de proveedores XML para que no se actualiza cada noche en la sincronizaci&oacute;n o perder&aacute;s los textos generados &#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;ChatGPTAdv1&#039;] = &#039;&lt;b&gt;IMPORTANT:&lt;/b&gt; If you are going to change the description of a house imported via XML, make sure to uncheck the &ldquo;Description&rdquo; field in the XML provider&rsquo;s record. Otherwise, it will be updated every night during synchronization, and you will lose the generated texts.&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminado que el usuario CRM añada promociones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/promotions/news.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if($_SESSION[&#039;kt_login_id&#039;] == 47) { ?&gt;
    &lt;a href=&quot;news-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;news-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix envío email bienvenida en ferias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/ferias/clients-form.php:385
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function Trigger_SendEmail($tNG)
{

  global $fromMail, $lang_adm, $_POST;

  // die(&#039;test&#039;);

  $emailObj = new tNG_Email($tNG);
  $emailObj-&gt;setFrom($fromMail);
  $emailObj-&gt;setTo(&quot;{email_cli}&quot;);
  $emailObj-&gt;setCC(&quot;{skype_cli}&quot;);
  $emailObj-&gt;setBCC(&quot;&quot;);
  $emailObj-&gt;setSubject(&#039;Welcome&#039;);
  $emailObj-&gt;setContentFile(&quot;../../includes/mailtemplates/welcome_&quot;.$_POST[&#039;idioma_cli&#039;].&quot;_cli.html&quot;);
  $emailObj-&gt;setEncoding(&quot;UTF-8&quot;);
  $emailObj-&gt;setFormat(&quot;HTML/Text&quot;);
  $emailObj-&gt;setImportance(&quot;High&quot;);
  return $emailObj-&gt;Execute();

  // ob_start();
  // include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;../../includes/mailtemplates/welcome_nl_cli.html&#039;);
  // $html = ob_get_contents();
  // ob_end_clean();

  // $subject = &#039;Beste bezoeker van de Nelemans stand&#039;;


  //  if (sendAppEmail(array($_POST[&#039;email_cli&#039;] =&gt; $_POST[&#039;nombre_cli&#039;]), array($_POST[&#039;skype_cli&#039;] =&gt; $_POST[&#039;nombre2_cli&#039;]), &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html))
  //  {
  //     return true;
  //  }
  //  else
  //  {
  //     return false;
  //  }

}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function Trigger_SendEmail($tNG) {

    global $fromMail, $lang_adm, $_POST, $nombreEmpresa;

    ob_start();
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;../../includes/mailtemplates/welcome_&#039;.$_POST[&#039;idioma_cli&#039;].&#039;_cli.html&#039;);
    $html = ob_get_contents();
    ob_end_clean();

    $subject = &#039;Beste bezoeker van de &#039; . $nombreEmpresa . &#039; stand&#039;;

    if (sendAppEmail(array($_POST[&#039;email_cli&#039;] =&gt; $_POST[&#039;nombre_cli&#039;]), array($_POST[&#039;skype_cli&#039;] =&gt; $_POST[&#039;nombre2_cli&#039;]), &#039;&#039;, array($_SESSION[&#039;kt_login_user&#039;] =&gt; $_SESSION[&#039;kt_login_user&#039;]), $subject, $html)) {
      return true;
    }
    else {
      return false;
    }

}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Nueva plantilla TV
    </h6>
    <div class="card-body">
        Añadir la carpeta: <code>/media/images/tv</code>
        <hr>
        Susutituir el archivo: <code>/modules/pages/view/tv.tpl</code>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Error Master convertir en cliente si ya está creado
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/report-consultas-search.j:56
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
btns = &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
    btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
        btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
    btns += &#039;&lt;/button&gt;&#039;;
    btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;
        btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/add_client_from_consulta.php?c=&#039; + idBajClient + &#039;&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtn + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user-plus align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertClientText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
        btns += &#039;&lt;li&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtnOwn + &#039; btn-modal-convertir-propietario&quot; data-client-id=&quot;&#039; + idBajClient + &#039;&quot; data-client-name=&quot;&#039; + nameBajClient + &#039;&quot; data-client-lang=&quot;&#039; + langBajClient + &#039;&quot; data-client-mail=&quot;&#039; + mailBajClient + &#039;&quot; data-client-phone=&quot;&#039; + phoneBajClient + &#039;&quot; data-client-nota=\&#039;&#039; + notaBajClient + &#039;\&#039; data-client-date=&quot;&#039; + dateBajClient + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user-plus align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertPropietarioText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
        if (canDel == 1) {
            btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
            btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/remove_client_from_consulta.php?c=&#039; + full[6] + &#039;&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
        }
    btns += &#039;&lt;/ul&gt;&#039;;
btns += &#039;&lt;/div&gt;&#039;;
return  btns;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
btns = &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
    btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
        btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
    btns += &#039;&lt;/button&gt;&#039;;
    btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;

    if(existClient &gt; 0) {
    btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/clients-form.php?id_cli=&#039; + existClient + &#039;&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtn + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertClientText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
    } else {
        btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/add_client_from_consulta.php?c=&#039; + idBajClient + &#039;&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtn + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user-plus align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertClientText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
    }

    if(existOwner &gt; 0) {
        btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/owners-form.php?id_pro=&#039; + existOwner + &#039;&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtnOwn + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertPropietarioText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
    } else {
        btns += &#039;&lt;li&gt;&lt;a href=&quot;javascript:void(0);&quot; class=&quot;dropdown-item edit-item-btn &#039; + colorBtnOwn + &#039; btn-modal-convertir-propietario&quot; data-client-id=&quot;&#039; + idBajClient + &#039;&quot; data-client-name=&quot;&#039; + nameBajClient + &#039;&quot; data-client-lang=&quot;&#039; + langBajClient + &#039;&quot; data-client-mail=&quot;&#039; + mailBajClient + &#039;&quot; data-client-phone=&quot;&#039; + phoneBajClient + &#039;&quot; data-client-nota=\&#039;&#039; + notaBajClient + &#039;\&#039; data-client-date=&quot;&#039; + dateBajClient + &#039;&quot;&gt;&lt;i class=&quot;fa-regular fa-user-plus align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + convertPropietarioText + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
    }

    if (canDel == 1) {
        btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
        btns += &#039;&lt;li&gt;&lt;a href=&quot;/intramedianet/properties/remove_client_from_consulta.php?c=&#039; + full[6] + &#039;&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
    }

    btns += &#039;&lt;/ul&gt;&#039;;
btns += &#039;&lt;/div&gt;&#039;;
return  btns;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Fix metros cuadrados de inmuebles, deja poner cualquier texto
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1071
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_utiles_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_utiles_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_parcela_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_parcela_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_balcon_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_balcon_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_terraza_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_terraza_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_garaje_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_garaje_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_sotano_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_sotano_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_fachada_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_fachada_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_solarium_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_solarium_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;m2_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_utiles_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_utiles_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_parcela_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_parcela_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_balcon_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_balcon_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_terraza_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_terraza_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_garaje_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_garaje_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_sotano_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_sotano_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_fachada_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_fachada_prop&quot;);
$ins_properties_properties-&gt;addColumn(&quot;m2_solarium_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_solarium_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1130
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1326
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_utiles_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_utiles_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_parcela_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_parcela_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_balcon_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_balcon_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_terraza_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_terraza_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_garaje_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_garaje_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_sotano_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_sotano_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_fachada_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_fachada_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_solarium_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;m2_solarium_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;m2_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_utiles_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_utiles_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_parcela_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_parcela_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_balcon_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_balcon_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_terraza_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_terraza_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_garaje_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_garaje_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_sotano_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_sotano_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_fachada_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_fachada_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;m2_solarium_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;m2_solarium_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1384
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_properties_properties-&gt;addColumn(&quot;garden_m2_prop&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;garden_m2_prop&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2109
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;m2 construidos&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;m2_prop&quot; id=&quot;m2_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_utiles_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_utiles_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;m2 &uacute;tiles&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;m2_utiles_prop&quot; id=&quot;m2_utiles_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_utiles_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_utiles_prop&quot;); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;m2 construidos&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;m2_prop&quot; id=&quot;m2_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_utiles_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_utiles_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;m2 &uacute;tiles&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;m2_utiles_prop&quot; id=&quot;m2_utiles_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_utiles_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_utiles_prop&quot;); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2176
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;garden_m2_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;garden_m2_prop&quot; id=&quot;garden_m2_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;garden_m2_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_parcela_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_parcela_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Parcela&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Parcela&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;m2_parcela_prop&quot; id=&quot;m2_parcela_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_parcela_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_parcela_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;garden_m2_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Jard&iacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;garden_m2_prop&quot; id=&quot;garden_m2_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;garden_m2_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;garden_m2_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_parcela_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_parcela_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Parcela&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Parcela&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;m2_parcela_prop&quot; id=&quot;m2_parcela_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_parcela_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_parcela_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:2226
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_balcon_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Terraza&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;m2_balcon_prop&quot; id=&quot;m2_balcon_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_balcon_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_solarium_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_solarium_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Solarium&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;text&quot; name=&quot;m2_solarium_prop&quot; id=&quot;m2_solarium_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_solarium_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_solarium_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_balcon_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php if ($lang_adm == &#039;es&#039;) { ?&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Terraza&#039;); ?&gt;&lt;?php } else { ?&gt;&lt;?php __(&#039;Balc&oacute;n&#039;); ?&gt; &lt;?php __(&#039;M2&#039;); ?&gt;&lt;?php } ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;m2_balcon_prop&quot; id=&quot;m2_balcon_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_balcon_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_balcon_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;

&lt;div class=&quot;col-lg-3&quot;&gt;

  &lt;div class=&quot;mb-4 &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_solarium_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
      &lt;label for=&quot;m2_solarium_prop&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;M2&#039;); ?&gt; &lt;?php __(&#039;Solarium&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;input-group&quot;&gt;
          &lt;input type=&quot;number&quot; name=&quot;m2_solarium_prop&quot; id=&quot;m2_solarium_prop&quot; value=&quot;&lt;?php echo KT_escapeAttribute($row_rsproperties_properties[&#039;m2_solarium_prop&#039;]); ?&gt;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
          &lt;span class=&quot;input-group-text&quot;&gt;m&lt;sup&gt;2&lt;/sup&gt;&lt;/span&gt;
      &lt;/div&gt;
      &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;m2_solarium_prop&quot;); ?&gt;
  &lt;/div&gt;

&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>