<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-10-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Nuevo popup de Whatsapp</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejora importador Habihub</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Nuevo popup de Whatsapp
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
CREATE TABLE `whatsapp_log` (
  `id_con` int(11) NOT NULL AUTO_INCREMENT,
  `lang_con` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT &#039;&#039;,
  `name_con` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT &#039;&#039;,
  `phone_con` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_con` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_con` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_con`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            </code>
        </pre>
        <hr>
        Añadir los archivos:
        <pre>
            <code class="php">
/intramedianet/properties/whatsapp.php
/intramedianet/properties/whatsapp-data.php
/intramedianet/properties/remove_client_from_whatsapp.php
/intramedianet/properties/_js/report-whatsapp-search.js
/modules/contact/send-quote-nocaptcha-whatsapp.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/partials/barra-responsiva.tpl:2
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;bottom-bar-new&quot;&gt;

    {if $seccion == $url_property }
        &lt;a onclick=&quot;gtag(&#039;event&#039;, &#039;evento&#039;, { &#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;whats&#039; });&quot; href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}&quot;|escape:&#039;url&#039;}&quot; target=&quot;_blank&quot; class=&quot;btn-whatsapp&quot;&gt;&lt;img src=&quot;/media/images/website/icon-whatsp-property.svg&quot; alt=&quot;WhatsApp&quot;&gt;&lt;/a&gt;
    {else}
        &lt;a onclick=&quot;gtag(&#039;event&#039;, &#039;evento&#039;, { &#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;whats&#039; });&quot; href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;&quot;|escape:&#039;url&#039;}&quot; target=&quot;_blank&quot; class=&quot;btn-whatsapp&quot;&gt;&lt;img src=&quot;/media/images/website/icon-whatsp-property.svg&quot; alt=&quot;WhatsApp&quot;&gt;&lt;/a&gt;
    {/if}

&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;bottom-bar-new&quot;&gt;
    &lt;a href=&quot;#&quot; data-bs-toggle=&quot;modal&quot; data-bs-target=&quot;#contactFootFormWhatsappModal&quot;  class=&quot;btn-whatsapp d-none d-xl-inline-flex-&quot;&gt;
        &lt;span&gt;
            &lt;img height=&quot;62&quot; src=&quot;/media/images/website/icon-whatsp-property.svg&quot; alt=&quot;WhatsApp&quot;&gt;
        &lt;/span&gt;
        &lt;strong&gt;
            {$lng_chat_with_us_now}
        &lt;/strong&gt;
    &lt;/a&gt;
&lt;/div&gt;

&lt;div class=&quot;modal fade bg-gray modal-whatsapp&quot; tabindex=&quot;-1&quot; role=&quot;dialog&quot; id=&quot;contactFootFormWhatsappModal&quot;&gt;


    &lt;div class=&quot;modal-dialog&quot; role=&quot;document&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;

            &lt;div class=&quot;modal-header bg-primary py-2&quot;&gt;
                &lt;h3 class=&quot;text-white text-center my-2&quot;&gt;{$lng_contactar_por_whatsapp}&lt;/h3&gt;
                &lt;a class=&quot;close mr-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;
                    &lt;img src=&quot;/media/images/website/icon-close-modal.svg&quot; alt=&quot;cerrar&quot;&gt;
                &lt;/a&gt;
            &lt;/div&gt;


           &lt;div class=&quot;p-4&quot;&gt;

                &lt;p class=&quot;text-center text-dark px-4 mb-0&quot;&gt;
                    {$lng_deja_tu_nombre_y_telefono_para_iniciar_la_conversacion_en_whatsapp}.
                &lt;/p&gt;

                &lt;div class=&quot;pe-xl-2&quot;&gt;
                      &lt;form action=&quot;#&quot; id=&quot;contactFootFormWhatsapp&quot; method=&quot;post&quot; role=&quot;form&quot; class=&quot;validate custom-form&quot;&gt;

                         &lt;div class=&quot;row&quot;&gt;
                            &lt;div class=&quot;col-lg-12&quot;&gt;
                                &lt;div class=&quot;mb-3&quot;&gt;
                                    &lt;label class=&quot;hide-label&quot;&gt;
                                        {$lng_nombre} *
                                    &lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;form-control required&quot; name=&quot;name&quot; id=&quot;name&quot; placeholder=&quot;{$lng_nombre} *&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                            &lt;div class=&quot;col-lg-12&quot;&gt;
                                &lt;div class=&quot;mb-3&quot;&gt;
                                    &lt;label class=&quot;hide-label&quot;&gt;
                                        {$lng_telefono} *
                                    &lt;/label&gt;
                                    &lt;input type=&quot;text&quot; class=&quot;form-control  telefono required&quot; name=&quot;telefono&quot; id=&quot;telefono&quot; placeholder=&quot;{$lng_telefono} *&quot;&gt;
                                &lt;/div&gt;
                            &lt;/div&gt;
                        &lt;/div&gt;

                        &lt;div&gt;
                            &lt;label class=&quot;checkcontainer mb-4&quot;&gt;
                                &lt;span class=&quot;tag-name&quot;&gt;{assign var=&quot;urlPPRV&quot; value=sprintf(&#039;&lt;a href=&quot;%s%s/&quot; target=&quot;_blank&quot;&gt;&#039;, {$urlStart},
                                    {$url_privacy})}
                                    {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:&#039;&lt;/a&gt;&#039;}*
                                &lt;/span&gt;
                                &lt;input type=&quot;checkbox&quot; name=&quot;lpd&quot; id=&quot;lpd&quot; class=&quot;required&quot; /&gt;
                                &lt;span class=&quot;checkmark&quot;&gt;&lt;/span&gt;
                            &lt;/label&gt;
                        &lt;/div&gt;

                        &lt;input type=&quot;hidden&quot; name=&quot;lang&quot; value=&quot;{$lang}&quot;&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;f{$smarty.now|date_format:&quot;%d%m%y&quot;|replace:&quot; &quot;:&quot;0&quot;}&quot;&gt;

                        &lt;div class=&quot;d-grid&quot;&gt;
                            &lt;button type=&quot;submit&quot; class=&quot;btn btn-primary text-light mb-2&quot;&gt;
                               {$lng_solicitar_informacion}
                           &lt;/button&gt;
                        &lt;/div&gt;

                        {* &lt;div class=&quot;gdpr mb-4&quot;&gt;{$texto_formularios_GDPR}&lt;/div&gt; *}
                    &lt;/form&gt;
                &lt;/div&gt;

           &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;


&lt;div class=&quot;modal fade bg-gray modal-whatsapp&quot; tabindex=&quot;-1&quot; role=&quot;dialog&quot; id=&quot;respuesta&quot;&gt;


    &lt;div class=&quot;modal-dialog&quot; role=&quot;document&quot;&gt;
        &lt;div class=&quot;modal-content&quot;&gt;

            &lt;div class=&quot;modal-header bg-primary py-2&quot;&gt;
                &lt;h3 class=&quot;text-white text-center my-2&quot;&gt;{$lng_contactar_por_whatsapp}&lt;/h3&gt;
                &lt;a class=&quot;close mr-2&quot; data-bs-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;
                    &lt;img src=&quot;/media/images/website/icon-close-modal.svg&quot; alt=&quot;cerrar&quot;&gt;
                &lt;/a&gt;
            &lt;/div&gt;
           &lt;div class=&quot;p-4&quot;&gt;

                &lt;div class=&quot;pe-xl-2&quot;&gt;
                    {if $seccion == $url_property }
                        &lt;a onclick=&quot;gtag(&#039;event&#039;, &#039;evento&#039;, { &#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;whats&#039; });&quot;  href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}&quot;|escape:&#039;url&#039;}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary w-100 my-4&quot;&gt;{$lng_hablar_por_whatsapp_ahora}&lt;/a&gt;
                    {else}
                        &lt;a onclick=&quot;gtag(&#039;event&#039;, &#039;evento&#039;, { &#039;event_category&#039;: &#039;Contact Form&#039;, &#039;event_action&#039;: &#039;Contact&#039;, &#039;event_label&#039;: &#039;whats&#039; });&quot;  href=&quot;https://wa.me/{$phoneRespBar}/?text={&quot;&quot;|escape:&#039;url&#039;}&quot; target=&quot;_blank&quot; class=&quot;btn btn-primary w-100 my-4&quot;&gt;{$lng_hablar_por_whatsapp_ahora}&lt;/a&gt;
                    {/if}
                &lt;/div&gt;

           &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;

&lt;/div&gt;


&lt;style type=&quot;text/css&quot;&gt;
    .modal.bg-gray.modal-whatsapp
    {
        -webkit-backdrop-filter: blur(50px);
        backdrop-filter: blur(50px);
        background-color: rgba(0,0,0,0.1);
    }
    .modal.modal-whatsapp .modal-content, .modal.modal-whatsapp .modal-header
    {
        border-radius: 0;
        border: 0;
    }

    .modal.modal-whatsapp .modal-header span
    {
        display: inline-flex;
        background-color: #000000;
        border-radius: 50%;
        height: 50px;
        width: 50px;
        justify-content: center;
        align-items: center;
    }
    .modal.modal-whatsapp p
    {
        font-size: 17px;
      font-weight: 300;
      font-stretch: normal;
      font-style: normal;
      line-height: 1.5;
    }
    .modal.modal-whatsapp .close
    {
        width: auto;
    }
    .modal.modal-whatsapp .close img
    {
        height: 21px;
        width: auto;
    }
    .modal.modal-whatsapp .custom-form .customSelectInner
    {
        color: #212529;
    }
    .modal.modal-whatsapp h3
    {
          font-size: 20px;
          font-weight: 500;
          font-stretch: normal;
          font-style: normal;
          line-height: 1.45;
          letter-spacing: 0.2px;
    }
    .modal.modal-whatsapp .modal-dialog
    {
        margin: 0;
        position: absolute;
        bottom: 30px;
        right: 50px;
        min-width: 460px;
    }
    .bottom-bar-new .btn.btn-primary
    {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 260px;
        padding: 4px 14px;
        border-radius: 0 !important;
        height: 60px !important;
        color: #000 !important;
        text-transform: none;
        font-size: 18px !important;
        letter-spacing: normal !important;
        box-shadow: 0 0px 18px rgba(0, 0, 0, 0.1) !important;
    }

    .bottom-bar-new.left
    {
        left: 20px;
        right: auto;
        bottom: 20px;
    }

    @media (max-width: 960px)
    {
        .bottom-bar-new .btn.btn-primary
        {
            min-width: 240px;
            font-size: 17px !important;
        }
        .bottom-bar-new.left
        {
            bottom: -100px;
        }
        .bottom-bar-new.left.show
        {
            bottom: 20px;
        }
    }

    .bottom-bar-new .btn.btn-primary img
    {
        margin-top: 0 !important;
    }



    .bottom-bar-whatsapp .btn-whatsapp {
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .bottom-bar-whatsapp .btn-whatsapp span {
      background-color: #2ed9c3;
      display: inline-flex;
      height: 64px;
      width: 64px;
      border-radius: 50%;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 1;
/*      border: solid 1px #fff;*/
    }
    @media (max-width: 1022.98px) {
      .bottom-bar-whatsapp .btn-whatsapp span {
        transform: translateX(10px);
      }
    }
    .bottom-bar-whatsapp .btn-whatsapp img {
      height: 62px;
    }
    .bottom-bar-whatsapp .btn-whatsapp strong {
      display: none;
      font-size: 15px;
      height: 42px;
      color: #fff;
      padding: 8px 18px 8px 32px;
      border-radius: 50px;
      background-color: #2ed9c3;
      transform: translateX(-16px);
      transition: all ease-in-out 0.3s;
    }
    @media (min-width: 768px) {
      .bottom-bar-whatsapp .btn-whatsapp strong {
        padding: 8px 18px 8px 43px;
        display: inline-block;
        font-size: 16px;
        transform: translateX(-36px);
      }
      .bottom-bar-whatsapp .btn-whatsapp span {
        border: solid 1px #fff;
      }
    }
    .bottom-bar-whatsapp .btn-whatsapp:hover strong {
      transform: translateX(-10px);
    }
    @media (min-width: 768px) {
      .bottom-bar-whatsapp .btn-whatsapp:hover strong {
        transform: translateX(-30px);
      }
    }

&lt;/style&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
&lt;script type=&quot;text/javascript&quot;&gt;
    $(&#039;#contactFootFormWhatsapp&#039;).submit(function (e) {
        e.preventDefault();
        if ($(this).valid()) {
              $(this).append(&#039;&lt;div class=&quot;loading&quot;&gt;&#039;);
              $.get(&quot;/modules/contact/send-quote-nocaptcha-whatsapp.php?&quot; + $(this).serialize()).done(function (data) {
                    if (data == &#039;ok&#039;){
                        $(&#039;#contactFootFormWhatsapp input[type=text], #contactFootFormWhatsapp textarea&#039;).val(&#039;&#039;);
                        $(&#039;#contactFootFormWhatsapp input[type=checkbox]&#039;).removeAttr(&#039;checked&#039;);
                        $(&#039;#contactFootFormWhatsapp .loading&#039;).remove();
                        $(&#039;#contactFootFormWhatsappModal&#039;).modal(&#039;hide&#039;);
                        setTimeout(function() {
                            var modalElement = document.getElementById(&quot;respuesta&quot;);
                            var modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        }, 100);
                    }
              });
        }
      });
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.topbar.php:249
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsConsultasCount = &quot;SELECT SQL_CALC_FOUND_ROWS properties_consultas_log.id_con, text_con, properties_consultas_log.name_con, properties_consultas_log.email_con, properties_consultas_log.phone_con, properties_consultas_log.lang_con, properties_consultas_log.date_con, properties_consultas_log.lang_con as lang_sort FROM properties_consultas_log &quot;;
$rsConsultasCount = $inmoconn-&gt;query($query_rsConsultasCount); if(!$rsConsultasCount) {die(&quot;Error en la consulta: &quot; . $inmoconn-&gt;error);}
$row_rsConsultasCount = mysqli_fetch_assoc($rsConsultasCount);
$totalRows_rsConsultasCount = mysqli_num_rows($rsConsultasCount);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsConsultasCount = &quot;SELECT SQL_CALC_FOUND_ROWS properties_consultas_log.id_con, text_con, properties_consultas_log.name_con, properties_consultas_log.email_con, properties_consultas_log.phone_con, properties_consultas_log.lang_con, properties_consultas_log.date_con, properties_consultas_log.lang_con as lang_sort FROM properties_consultas_log &quot;;
$rsConsultasCount = $inmoconn-&gt;query($query_rsConsultasCount); if(!$rsConsultasCount) {die(&quot;Error en la consulta: &quot; . $inmoconn-&gt;error);}
$row_rsConsultasCount = mysqli_fetch_assoc($rsConsultasCount);
$totalRows_rsConsultasCount = mysqli_num_rows($rsConsultasCount);

$query_rsConsultasWhatsapp = &quot;SELECT SQL_CALC_FOUND_ROWS whatsapp_log.id_con, text_con, whatsapp_log.name_con, whatsapp_log.phone_con, whatsapp_log.lang_con, whatsapp_log.date_con, whatsapp_log.lang_con as lang_sort FROM whatsapp_log &quot;;
$rsConsultasWhatsapp = $inmoconn-&gt;query($query_rsConsultasWhatsapp); if(!$rsConsultasWhatsapp) {die(&quot;Error en la consulta: &quot; . $inmoconn-&gt;error);}
$row_rsConsultasWhatsapp = mysqli_fetch_assoc($rsConsultasWhatsapp);
$totalRows_rsConsultasWhatsapp = mysqli_num_rows($rsConsultasWhatsapp);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.topbar.php:267
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php $totconsultasCount = $totalRows_rsConsultas + $totalRows_rsbajadasCount + $totalRows_rsConsultasCount; ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php $totconsultasCount = $totalRows_rsConsultas + $totalRows_rsbajadasCount + $totalRows_rsConsultasCount + $totalRows_rsConsultasWhatsapp; ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/consultas.php:58
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link active&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link active&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;whatsapp.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasWhatsapp &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasWhatsapp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Whatsapp&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/bajada.php:63
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;whatsapp.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasWhatsapp &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasWhatsapp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Whatsapp&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/enquiries.php:57
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;whatsapp.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasWhatsapp &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasWhatsapp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Whatsapp&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/email/email.php:132
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;consultas.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasCount &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasCount; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Formulario de contacto&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
&lt;li class=&quot;nav-item&quot; role=&quot;presentation&quot;&gt;
    &lt;a class=&quot;nav-link&quot; href=&quot;whatsapp.php&quot; role=&quot;tab&quot; aria-selected=&quot;false&quot; tabindex=&quot;-1&quot;&gt;
        &lt;?php if($totalRows_rsConsultasWhatsapp &gt; 0) { ?&gt;&lt;span class=&quot;badge bg-danger ms-2 float-end&quot;&gt;&lt;?php echo $totalRows_rsConsultasWhatsapp; ?&gt;&lt;/span&gt;&lt;?php } ?&gt;
        &lt;?php __(&#039;Whatsapp&#039;); ?&gt;
    &lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        <hr>
        En la carpeta:
        <pre>
            <code class="makefile">
/resources/
            </code>
        </pre>
        Añadir los textos a los idiomas:
        <pre>
            <code class="php">
// Catal&aacute;n (ca)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;ca&quot;] = &quot;Deixa el teu nom i tel&egrave;fon per iniciar la conversa a WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;ca&quot;] = &quot;Parlar per WhatsApp ara&quot;;

// Dan&eacute;s (da)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;da&quot;] = &quot;Indtast dit navn og telefonnummer for at starte samtalen p&aring; WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;da&quot;] = &quot;Chat p&aring; WhatsApp nu&quot;;

// Alem&aacute;n (de)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;de&quot;] = &quot;Gib deinen Namen und deine Telefonnummer ein, um das Gespr&auml;ch auf WhatsApp zu beginnen&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;de&quot;] = &quot;Jetzt &uuml;ber WhatsApp chatten&quot;;

// Ingl&eacute;s (en)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;en&quot;] = &quot;Enter your name and phone number to start the conversation on WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;en&quot;] = &quot;Chat on WhatsApp now&quot;;

// Espa&ntilde;ol (es)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;es&quot;] = &quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;es&quot;] = &quot;Hablar por WhatsApp ahora&quot;;

// Fin&eacute;s (fi)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;fi&quot;] = &quot;Anna nimesi ja puhelinnumerosi aloittaaksesi keskustelun WhatsAppissa&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;fi&quot;] = &quot;Keskustele WhatsAppissa nyt&quot;;

// Franc&eacute;s (fr)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;fr&quot;] = &quot;Laissez votre nom et votre t&eacute;l&eacute;phone pour d&eacute;marrer la conversation sur WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;fr&quot;] = &quot;Discuter sur WhatsApp maintenant&quot;;

// Island&eacute;s (is)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;is&quot;] = &quot;Sl&aacute;&eth;u inn nafn og s&iacute;man&uacute;mer til a&eth; hefja samtal &aacute; WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;is&quot;] = &quot;Spjalla &aacute; WhatsApp n&uacute;na&quot;;

// Neerland&eacute;s (nl)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;nl&quot;] = &quot;Vul je naam en telefoonnummer in om het gesprek op WhatsApp te starten&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;nl&quot;] = &quot;Chat nu via WhatsApp&quot;;

// Noruego (no)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;no&quot;] = &quot;Skriv inn navnet og telefonnummeret ditt for &aring; starte samtalen p&aring; WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;no&quot;] = &quot;Chat p&aring; WhatsApp n&aring;&quot;;

// Polaco (pl)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;pl&quot;] = &quot;Podaj swoje imi&#x119; i numer telefonu, aby rozpocz&#x105;&#x107; rozmow&#x119; na WhatsAppie&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;pl&quot;] = &quot;Rozmawiaj na WhatsAppie teraz&quot;;

// Ruso (ru)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;ru&quot;] = &quot;&#x412;&#x432;&#x435;&#x434;&#x438;&#x442;&#x435; &#x441;&#x432;&#x43e;&#x435; &#x438;&#x43c;&#x44f; &#x438; &#x43d;&#x43e;&#x43c;&#x435;&#x440; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x430;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43d;&#x430;&#x447;&#x430;&#x442;&#x44c; &#x440;&#x430;&#x437;&#x433;&#x43e;&#x432;&#x43e;&#x440; &#x432; WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;ru&quot;] = &quot;&#x41d;&#x430;&#x43f;&#x438;&#x441;&#x430;&#x442;&#x44c; &#x432; WhatsApp &#x441;&#x435;&#x439;&#x447;&#x430;&#x441;&quot;;

// Sueco (se)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;se&quot;] = &quot;Ange ditt namn och telefonnummer f&ouml;r att starta konversationen p&aring; WhatsApp&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;se&quot;] = &quot;Chatta p&aring; WhatsApp nu&quot;;

// Chino simplificado (zh)
$langStr[&quot;Deja tu nombre y tel&eacute;fono para iniciar la conversaci&oacute;n en WhatsApp&quot;][&quot;zh&quot;] = &quot;&#x8f93;&#x5165;&#x60a8;&#x7684;&#x59d3;&#x540d;&#x548c;&#x7535;&#x8bdd;&#x53f7;&#x7801;&#x4ee5;&#x5728; WhatsApp &#x4e0a;&#x5f00;&#x59cb;&#x5bf9;&#x8bdd;&quot;;
$langStr[&quot;Hablar por whatsapp ahora&quot;][&quot;zh&quot;] = &quot;&#x7acb;&#x5373;&#x901a;&#x8fc7; WhatsApp &#x804a;&#x5929;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Mejora importador Habihub
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/_utils_habihub.php:151
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
foreach($allLanguages as $value) {
   if ($value == &#039;se&#039;) {
       if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
            $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
            $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
            $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
       }
   } else {
       if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
            $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
            $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
            $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
       }
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
foreach($allLanguages as $value) {
   if ($value == &#039;se&#039;) {
       if ((string)$property-&gt;desc-&gt;sv != &#039;&#039;) {
            $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;metadescription-&gt;sv != &#039;&#039;) {
            $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ($property-&gt;seo-&gt;h1-&gt;sv != &#039;&#039;) {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;sv)).&quot;&#039;, \n&quot;;
       } else {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
       }
       if ($property-&gt;seo-&gt;title-&gt;sv != &#039;&#039;) {
            $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
       }
   } else {
       if ((string)$property-&gt;desc-&gt;$value != &#039;&#039;) {
            $query .= &quot;content_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;desc-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;metadescription-&gt;$value != &#039;&#039;) {
            $query .= &quot;description_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;metadescription-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;h1-&gt;$value != &#039;&#039;) {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;h1-&gt;$value)).&quot;&#039;, \n&quot;;
       } else {
            $query .= &quot;titulo_prom_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;title-&gt;$value)).&quot;&#039;, \n&quot;;
       }
       if ((string)$property-&gt;seo-&gt;title-&gt;$value != &#039;&#039;) {
            $query .= &quot;titlew_&quot;.$value.&quot;_nws = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;seo-&gt;title-&gt;sv)).&quot;&#039;, \n&quot;;
       }
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
