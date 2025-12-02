<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 8 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 04-10-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Descripciones HTML Entities en servidores no de RAN</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Bug envio de emails sin casas en clientes/propietarios en servidores no de RAN</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Bug en la Exportacion a Habitaclia</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Al añadir citas al calendario desde ficha clientes/propietarios, al elegir la fecha, el calendario sale abajo y no se puede seleccionar</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Eliminado recapcha del formulario de solicitar información de inmuebles, no se puede tener dos recaptchas en la misma página</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Si se envía una propiedad desde la pestaña de criterios de búsqueda a un cliente no respeta el idioma</a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador para Todo Piso Alicante</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador para Yaencontre</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Descripciones HTML Entities en servidores no de RAN
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/partials/property-list.tpl:68
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{$resource.descr|strip_tags|truncate:150:&quot;...&quot;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{$resource.descr|html_entity_decode|strip_tags|truncate:150:&quot;...&quot;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/properties/view/partials/property-list.tpl:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{$lng_sin_descripcion|strip_tags}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{$lng_sin_descripcion|html_entity_decode|strip_tags}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-descripcion.tpl:3
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{$property[0].description}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{$property[0].description|html_entity_decode}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/tab-descripcion.tpl:5
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;p&gt;{$property[0].description}&lt;/p&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;p&gt;{$property[0].description|html_entity_decode}&lt;/p&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug envio de emails sin casas en clientes/propietarios en servidores no de RAN
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send-email.php:44
/intramedianet/properties/owners-send-email.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  &#039;&#039;,  &#039;&quot;.mysql_real_escape_string($_GET[&#039;email&#039;]).&quot;&#039;,  &#039;&quot;.mysql_real_escape_string($_GET[&#039;tipo&#039;]).&quot;&#039;, &#039;&quot;.mysql_real_escape_string($_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysql_real_escape_string($_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
INSERT INTO  `properties_log_mails_props` ( `id_log` , `usr_log`, `prop_id_log`, `email_log`, `type_log`, `text_log`, `date_log`) VALUES
( NULL, &#039;&quot;.$_SESSION[&#039;kt_login_id&#039;].&quot;&#039;,  0,  &#039;&quot;.mysql_real_escape_string($_GET[&#039;email&#039;]).&quot;&#039;,  &quot;.mysql_real_escape_string($_GET[&#039;tipo&#039;]).&quot;, &#039;&quot;.mysql_real_escape_string($_GET[&#039;subject&#039;]).&#039;&lt;hr&gt;&#039;.mysql_real_escape_string($_GET[&#039;message&#039;]).&quot;&#039;, &#039;&quot;.date(&quot;Y-m-d H:i:s&quot;).&quot;&#039; )
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug en la Exportacion a Habitaclia
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/xml/habitaclia.php:74
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;venta_01&gt;&lt;?php echo ($row_rsProperties[&#039;saleId&#039;] == 1 || $row_rsProperties[&#039;saleId&#039;] == 2)? 1 : 0; ?&gt;&lt;/venta_01&gt;
&lt;alquiler_01&gt;&lt;?php echo ($row_rsProperties[&#039;saleId&#039;] == 3 || $row_rsProperties[&#039;saleId&#039;] == 4) ? 1 : 0; ?&gt;&lt;/alquiler_01&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;venta_01&gt;&lt;?php echo ($row_rsProperties[&#039;slug_sta&#039;] == &quot;new_build&quot; || $row_rsProperties[&#039;slug_sta&#039;] == &quot;sale&quot;)? 1 : 0; ?&gt;&lt;/venta_01&gt;
&lt;alquiler_01&gt;&lt;?php echo ($row_rsProperties[&#039;slug_sta&#039;] == &quot;month&quot; || $row_rsProperties[&#039;slug_sta&#039;] == &quot;week&quot;) ? 1 : 0; ?&gt;&lt;/alquiler_01&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/xml/habitaclia.php:80
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;tipo&gt;&lt;?php echo ($row_rsProperties[&#039;partypID&#039;] == 9)?&#039;Local&#039;:&#039;Vivienda&#039;; ?&gt;&lt;/tipo&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;tipo&gt;&lt;?php echo in_array($row_rsProperties[&#039;partypID&#039;],  $habitacliaTipo)?&#039;Local&#039;:&#039;Vivienda&#039;; ?&gt;&lt;/tipo&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/* @group Datos: Habitaclia */
$habitacliaTipo = array(9); // Aqu&iacute; hay que indicar los IDs de los tipos de propiedad que correspondan a LOCAL
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Al añadir citas al calendario desde ficha clientes/propietarios, al elegir la fecha, el calendario sale abajo y no se puede seleccionar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2295
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
      &lt;div class=&quot;modal-content&quot;&gt;
        &lt;div class=&quot;modal-header&quot;&gt;
            &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
            &lt;h4&gt;&lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-body&quot;&gt;
          &lt;form method=&quot;post&quot; id=&quot;form10&quot; action=&quot;&lt;?php echo KT_escapeAttribute(KT_getFullUri()); ?&gt;&quot; class=&quot;validate&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-7&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;titulo_ct&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rscategorias = mysql_fetch_assoc($rscategorias));
                              $rows = mysql_num_rows($rscategorias);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rscategorias, 0);
                                $row_rscategorias = mysql_fetch_assoc($rscategorias);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                              $rows = mysql_num_rows($rsusuarios);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsusuarios, 0);
                                $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsclientes[&#039;id_cli&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsclientes[&#039;nombre_cli&#039;]?&gt; &lt;?php echo $row_rsclientes[&#039;apellidos_cli&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsclientes = mysql_fetch_assoc($rsclientes));
                              $rows = mysql_num_rows($rsclientes);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsclientes, 0);
                                $row_rsclientes = mysql_fetch_assoc($rsclientes);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                              $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;property_ct&#039;]);
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rspropiedad[&#039;id_prop&#039;]?&gt;&quot; &lt;?php if (in_array($row_rspropiedad[&#039;id_prop&#039;], $vals)) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rspropiedad[&#039;referencia_prop&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rspropiedad = mysql_fetch_assoc($rspropiedad));
                              $rows = mysql_num_rows($rspropiedad);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rspropiedad, 0);
                                $row_rspropiedad = mysql_fetch_assoc($rspropiedad);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;row&quot;&gt;

                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-5&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;notas_ct&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                        &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHistCit pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;
          &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-footer&quot;&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-success&quot; id=&quot;btn-close-save&quot; name=&quot;KT_Insert1&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar y guardar&#039;); ?&gt;
            &lt;/a&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-danger&quot; id=&quot;btn-close&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar&#039;); ?&gt;
            &lt;/a&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
      &lt;div class=&quot;modal-content&quot;&gt;
        &lt;div class=&quot;modal-header&quot;&gt;
            &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
            &lt;h4&gt;&lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-body&quot;&gt;
          &lt;form method=&quot;post&quot; id=&quot;form10&quot; action=&quot;&lt;?php echo KT_escapeAttribute(KT_getFullUri()); ?&gt;&quot; class=&quot;validate&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-7&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;titulo_ct&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;row&quot;&gt;

                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rscategorias = mysql_fetch_assoc($rscategorias));
                              $rows = mysql_num_rows($rscategorias);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rscategorias, 0);
                                $row_rscategorias = mysql_fetch_assoc($rscategorias);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                              $rows = mysql_num_rows($rsusuarios);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsusuarios, 0);
                                $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsclientes[&#039;id_cli&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsclientes[&#039;nombre_cli&#039;]?&gt; &lt;?php echo $row_rsclientes[&#039;apellidos_cli&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsclientes = mysql_fetch_assoc($rsclientes));
                              $rows = mysql_num_rows($rsclientes);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsclientes, 0);
                                $row_rsclientes = mysql_fetch_assoc($rsclientes);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                              $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;property_ct&#039;]);
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rspropiedad[&#039;id_prop&#039;]?&gt;&quot; &lt;?php if (in_array($row_rspropiedad[&#039;id_prop&#039;], $vals)) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rspropiedad[&#039;referencia_prop&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rspropiedad = mysql_fetch_assoc($rspropiedad));
                              $rows = mysql_num_rows($rspropiedad);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rspropiedad, 0);
                                $row_rspropiedad = mysql_fetch_assoc($rspropiedad);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-5&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;notas_ct&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                        &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHistCit pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;
          &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-footer&quot;&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-success&quot; id=&quot;btn-close-save&quot; name=&quot;KT_Insert1&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar y guardar&#039;); ?&gt;
            &lt;/a&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-danger&quot; id=&quot;btn-close&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar&#039;); ?&gt;
            &lt;/a&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1440
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
      &lt;div class=&quot;modal-content&quot;&gt;
        &lt;div class=&quot;modal-header&quot;&gt;
            &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
            &lt;h4&gt;&lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-body&quot;&gt;
          &lt;form method=&quot;post&quot; id=&quot;form10&quot; action=&quot;&lt;?php echo KT_escapeAttribute(KT_getFullUri()); ?&gt;&quot; class=&quot;validate&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-7&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;titulo_ct&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rscategorias = mysql_fetch_assoc($rscategorias));
                              $rows = mysql_num_rows($rscategorias);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rscategorias, 0);
                                $row_rscategorias = mysql_fetch_assoc($rscategorias);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                              $rows = mysql_num_rows($rsusuarios);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsusuarios, 0);
                                $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsclientes[&#039;id_cli&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsclientes[&#039;nombre_cli&#039;]?&gt; &lt;?php echo $row_rsclientes[&#039;apellidos_cli&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsclientes = mysql_fetch_assoc($rsclientes));
                              $rows = mysql_num_rows($rsclientes);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsclientes, 0);
                                $row_rsclientes = mysql_fetch_assoc($rsclientes);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                              $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;property_ct&#039;]);
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rspropiedad[&#039;id_prop&#039;]?&gt;&quot; &lt;?php if (in_array($row_rspropiedad[&#039;id_prop&#039;], $vals)) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rspropiedad[&#039;referencia_prop&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rspropiedad = mysql_fetch_assoc($rspropiedad));
                              $rows = mysql_num_rows($rspropiedad);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rspropiedad, 0);
                                $row_rspropiedad = mysql_fetch_assoc($rspropiedad);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;row&quot;&gt;

                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-5&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;notas_ct&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                        &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHistCit pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;
          &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-footer&quot;&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-success&quot; id=&quot;btn-close-save&quot; name=&quot;KT_Insert1&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar y guardar&#039;); ?&gt;
            &lt;/a&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-danger&quot; id=&quot;btn-close&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar&#039;); ?&gt;
            &lt;/a&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div id=&quot;myModal&quot; class=&quot;modal fade&quot;&gt;
    &lt;div class=&quot;modal-dialog modal-lg&quot;&gt;
      &lt;div class=&quot;modal-content&quot;&gt;
        &lt;div class=&quot;modal-header&quot;&gt;
            &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;modal&quot; aria-label=&quot;Close&quot;&gt;&lt;span aria-hidden=&quot;true&quot;&gt;&amp;times;&lt;/span&gt;&lt;/button&gt;
            &lt;h4&gt;&lt;?php __(&#039;A&ntilde;adir cita&#039;); ?&gt;&lt;/h4&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-body&quot;&gt;
          &lt;form method=&quot;post&quot; id=&quot;form10&quot; action=&quot;&lt;?php echo KT_escapeAttribute(KT_getFullUri()); ?&gt;&quot; class=&quot;validate&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-md-7&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;titulo_ct&quot;&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;titulo_ct&quot; id=&quot;titulo_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required&quot;&gt;
                        &lt;input type=&quot;hidden&quot; name=&quot;id_ct&quot; id=&quot;id_ct&quot; value=&quot;&quot;&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;row&quot;&gt;

                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;inicio_ct&quot;&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;inicio_ct&quot; id=&quot;inicio_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                      &lt;div class=&quot;col-md-6&quot;&gt;
                          &lt;div class=&quot;form-group&quot;&gt;
                              &lt;label for=&quot;final_ct&quot;&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;:&lt;/label&gt;
                              &lt;input type=&quot;text&quot; name=&quot;final_ct&quot; id=&quot;final_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control required datetimepicker&quot;&gt;
                          &lt;/div&gt;
                      &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rscategorias[&#039;id_ct&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rscategorias[&#039;category_&#039;.$lang_adm.&#039;_ct&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rscategorias = mysql_fetch_assoc($rscategorias));
                              $rows = mysql_num_rows($rscategorias);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rscategorias, 0);
                                $row_rscategorias = mysql_fetch_assoc($rscategorias);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __(&#039;Usuario&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsusuarios[&#039;id_usr&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios[&#039;id_usr&#039;], $_SESSION[&#039;kt_login_id&#039;]))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios[&#039;nombre_usr&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsusuarios = mysql_fetch_assoc($rsusuarios));
                              $rows = mysql_num_rows($rsusuarios);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsusuarios, 0);
                                $row_rsusuarios = mysql_fetch_assoc($rsusuarios);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __(&#039;Clientex&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rsclientes[&#039;id_cli&#039;]?&gt;&quot;&gt;&lt;?php echo $row_rsclientes[&#039;nombre_cli&#039;]?&gt; &lt;?php echo $row_rsclientes[&#039;apellidos_cli&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rsclientes = mysql_fetch_assoc($rsclientes));
                              $rows = mysql_num_rows($rsclientes);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rsclientes, 0);
                                $row_rsclientes = mysql_fetch_assoc($rsclientes);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;:&lt;/label&gt;
                        &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
                            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                            &lt;?php
                            do {
                              $vals = explode(&#039;,&#039;, $row_rsproperties_client[&#039;property_ct&#039;]);
                            ?&gt;
                            &lt;option value=&quot;&lt;?php echo $row_rspropiedad[&#039;id_prop&#039;]?&gt;&quot; &lt;?php if (in_array($row_rspropiedad[&#039;id_prop&#039;], $vals)) {echo &quot;selected=\&quot;selected\&quot;&quot;;} ?&gt;&gt;&lt;?php echo $row_rspropiedad[&#039;referencia_prop&#039;]?&gt;&lt;/option&gt;
                            &lt;?php
                            } while ($row_rspropiedad = mysql_fetch_assoc($rspropiedad));
                              $rows = mysql_num_rows($rspropiedad);
                              if($rows &gt; 0) {
                                  mysql_data_seek($rspropiedad, 0);
                                $row_rspropiedad = mysql_fetch_assoc($rspropiedad);
                              }
                            ?&gt;
                        &lt;/select&gt;
                    &lt;/div&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;:&lt;/label&gt;
                        &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-md-5&quot;&gt;
                    &lt;div class=&quot;form-group&quot;&gt;
                        &lt;label for=&quot;notas_ct&quot;&gt;&lt;?php __(&#039;Notas&#039;); ?&gt;:&lt;/label&gt;
                        &lt;textarea name=&quot;notas_ct&quot; id=&quot;notas_ct&quot; cols=&quot;40&quot; rows=&quot;19&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
                    &lt;/div&gt;
                    &lt;hr&gt;
                    &lt;a href=&quot;#&quot; class=&quot;btn btn-success addHistCit pull-right&quot;&gt;&lt;?php __(&#039;A&ntilde;adir fecha&#039;); ?&gt;&lt;/a&gt;
                &lt;/div&gt;
            &lt;/div&gt;
          &lt;/form&gt;
        &lt;/div&gt;
        &lt;div class=&quot;modal-footer&quot;&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-success&quot; id=&quot;btn-close-save&quot; name=&quot;KT_Insert1&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar y guardar&#039;); ?&gt;
            &lt;/a&gt;
            &lt;a href=&quot;#&quot; class=&quot;btn btn-danger&quot; id=&quot;btn-close&quot;&gt;&lt;!-- data-dismiss=&quot;modal&quot; --&gt;
            &lt;?php __(&#039;Cerrar&#039;); ?&gt;
            &lt;/a&gt;
          &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Eliminado recapcha del formulario de solicitar información de inmuebles, no se puede tener dos recaptchas en la misma página
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/view/partials/contactar.tpl:28
            </code>
        </pre>
        Eliminar:
        <pre>
            <code class="php">
&lt;div&gt;
    &lt;div class=&quot;g-recaptcha&quot; data-sitekey=&quot;{$google_captcha_sitekey}&quot;&gt;&lt;/div&gt;
    &lt;input type=&quot;hidden&quot; class=&quot;hiddenRecaptcha required&quot; name=&quot;hiddenRecaptcha&quot; id=&quot;hiddenRecaptcha&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/property/enquiry.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$recaptcha = $_GET[&quot;g-recaptcha-response&quot;];
$url = &#039;https://www.google.com/recaptcha/api/siteverify&#039;;
$data = array(
    &#039;secret&#039; =&gt; $google_captcha_privatekey,
    &#039;response&#039; =&gt; $recaptcha
);
$options = array(
    &#039;http&#039; =&gt; array (
        &#039;method&#039; =&gt; &#039;POST&#039;,
        &#039;content&#039; =&gt; http_build_query($data)
    )
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success-&gt;success) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$antiSpam = &quot;f&quot; . date(&quot;dmy&quot;);

if (isset($_GET[$antiSpam]) &amp;&amp; $_GET[$antiSpam] == &#039;&#039;) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Si se envía una propiedad desde la pestaña de criterios de búsqueda a un cliente no respeta el idioma
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/properties-form.js:764
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &#039;clients-send.php?ids=&#039;+idProperty+&#039;&amp;email=&#039;+$(this).data(&#039;email&#039;)+&#039;&amp;lang=&#039;+appLang+&#039;&amp;tipo=4&#039;,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &#039;clients-send.php?ids=&#039;+idProperty+&#039;&amp;email=&#039;+$(this).data(&#039;email&#039;)+&#039;&amp;lang=&#039;+$(this).data(&#039;lang&#039;)+&#039;&amp;tipo=4&#039;,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador para Todo Piso Alicante
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `export_todopisoalicante_prop` INT(1) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `export_pisos_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:35
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$expFotoCasa= 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$expFotoCasa= 0;
$expTodoPisoAlicante= 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php:
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Exportar a Todo Piso Alicante&#039;] = &#039;Exportar a Todo Piso Alicante&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Exportar a Todo Piso Alicante&#039;] = &#039;Export to Todo Piso Alicante&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:871
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expTodoPisoAlicante == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_todopisoalicante_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_todopisoalicante_prop&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expTodoPisoAlicante == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_todopisoalicante_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_todopisoalicante_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:196
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsPropertiesFotocasa = mysql_num_rows($rsPropertiesFotocasa);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsPropertiesFotocasa = mysql_num_rows($rsPropertiesFotocasa);

$query_rsPropertiesTodoPisoAlicante = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_todopisoalicante_prop = 1
&quot;;
$rsPropertiesTodoPisoAlicante = mysql_query($query_rsPropertiesTodoPisoAlicante, $inmoconn) or die(mysql_error());
$row_rsPropertiesTodoPisoAlicante = mysql_fetch_assoc($rsPropertiesTodoPisoAlicante);
$totalRows_rsPropertiesTodoPisoAlicante = mysql_num_rows($rsPropertiesTodoPisoAlicante);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expFotoCasa) {$tot = $tot + 1;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expFotoCasa) {$tot = $tot + 1;}
if ($expTodoPisoAlicante) {$tot = $tot + 1;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:438
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
&lt;?php if ($expTodoPisoAlicante) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
      &lt;label for=&quot;todopiso&quot;&gt;&lt;?php __(&#039;Todo Piso Alicante&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;todopiso&quot; id=&quot;todopiso&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:531
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
&lt;?php if ($expTodoPisoAlicante == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Todo Piso Alicante&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsPropertiesTodoPisoAlicante,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:568
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var showFotocasa = &lt;?php echo $expFotoCasa ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var showFotocasa = &lt;?php echo $expFotoCasa ?&gt;;
var showTodoPisoAlicante = &lt;?php echo $expTodoPisoAlicante ?&gt;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:80
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expTodoPisoAlicante == 1) {
    array_push($aColumns, &#039;export_todopisoalicante_prop&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:310
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
$todopiso = &#039;&#039;;
if( isset($_GET[&#039;todopiso&#039;]) &amp;&amp; $_GET[&#039;todopiso&#039;] != &#039;&#039; ){
    $todopiso = &quot;AND export_todopisoalicante_prop = &quot; . $_GET[&#039;todopiso&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:375
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
end as export_fotocasa_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
end as export_fotocasa_prop,
case properties_properties.export_todopisoalicante_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_todopisoalicante_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:382
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$fotocasa
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$fotocasa $todopiso
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js:69
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}

if (showTodoPisoAlicante == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_todopisoalicante_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_todopisoalicante_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_todopisoalicante_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1): ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
&lt;?php if ($expTodoPisoAlicante == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/todopisoalicante.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/todopisoalicante.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/xml/todopisoalicante.php</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido exportador para Yaencontre
    </h6>
    <div class="card-body">
        Ejecutar la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `export_yaencontre_prop` INT(1) NULL DEFAULT 0  COMMENT &#039;&#039; AFTER `export_fotocasa_fields_prop`;
ALTER TABLE `properties_properties` ADD COLUMN `export_yaencontre_fields_prop` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL  COMMENT &#039;&#039; AFTER `export_yaencontre_prop`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:36
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$expTodoPisoAlicante= 0;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$expTodoPisoAlicante= 0;
$expYaencontre= 0;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/* @group Datos: Yaencontre */
$numOficina = &#039;00000000&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php:
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Exportar a Yaencontre&#039;] = &#039;Exportar a Yaencontre&#039;;
$lang[&#039;Campos obligatorios para la exportaci&oacute;n a Yaencontre&#039;] = &#039;Campos obligatorios para la exportaci&oacute;n a Yaencontre&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;Exportar a Yaencontre&#039;] = &#039;Export to Yaencontre&#039;;
$lang[&#039;Campos obligatorios para la exportaci&oacute;n a Yaencontre&#039;] = &#039;Required fields for export to Yaencontre&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:650
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Idealista_Fields trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Idealista_Fields trigger

//start Trigger_Yaencontre_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Yaencontre_Fields(&amp;$tNG) {
    $tNG-&gt;setColumnValue( &#039;export_yaencontre_fields_prop&#039;, json_encode( $tNG-&gt;getColumnValue(&#039;export_yaencontre_fields_prop&#039;) ) );
}
//end Trigger_Yaencontre_Fields trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:739
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expYaencontre == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:894
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expYaencontre == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_yaencontre_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_yaencontre_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;export_yaencontre_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_yaencontre_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:931
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expYaencontre == 1) {
    $upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1087
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expYaencontre == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_yaencontre_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_yaencontre_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;export_yaencontre_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_yaencontre_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Añadir al final del <tag>body</tag>:
        <pre>
            <code class="php">
&lt;script&gt;
// Si cambia el checkbox de yaencontre muestra el formulario
$(&#039;#export_yaencontre_prop&#039;).change(function(e) {
  e.preventDefault();
  if ($(this).is(&#039;:checked&#039;) == true) {
    $(&#039;#basicYaencontre&#039;).fadeIn(&#039;slow&#039;);
    var $val1 = $(&#039;#yaencontrePropertyStatusId&#039;).val();
    var $val2 = $(&#039;#yaencontreTransactionTypeId&#039;).val();
    var $val3 = $(&#039;#yaencontreTypeId&#039;).val();
    if ( $val1 != &quot;&quot; &amp;&amp; $val2 != &quot;&quot; &amp;&amp; $val3 != &quot;&quot; ) {
      $(&#039;#featuresYaencontre&#039;).fadeIn(&#039;slow&#039;);
    }
  } else{
    $(&#039;#basicYaencontre, #featuresYaencontre&#039;).fadeOut(&#039;slow&#039;);
  }
});
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:208
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$totalRows_rsPropertiesTodoPisoAlicante = mysql_num_rows($rsPropertiesTodoPisoAlicante);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$totalRows_rsPropertiesTodoPisoAlicante = mysql_num_rows($rsPropertiesTodoPisoAlicante);

$query_rsPropertiesYaencontre = &quot;
SELECT properties_properties.id_prop
FROM properties_properties
      LEFT OUTER JOIN rightmove_locations ON properties_properties.rightmove_loc_prop = rightmove_locations.id_rml
      LEFT OUTER JOIN rightmove_tipos ON properties_properties.rightmove_tipo_prop = rightmove_tipos.id_rmt
      LEFT OUTER JOIN properties_status ON properties_properties.operacion_prop = properties_status.id_sta
WHERE properties_properties.activado_prop = 1 AND properties_properties.export_yaencontre_prop = 1
&quot;;
$rsPropertiesYaencontre = mysql_query($query_rsPropertiesYaencontre, $inmoconn) or die(mysql_error());
$row_rsPropertiesYaencontre = mysql_fetch_assoc($rsPropertiesYaencontre);
$totalRows_rsPropertiesYaencontre = mysql_num_rows($rsPropertiesYaencontre);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:224
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expTodoPisoAlicante) {$tot = $tot + 1;}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expTodoPisoAlicante) {$tot = $tot + 1;}
if ($expYaencontre) {$tot = $tot + 1;}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:465
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
&lt;?php if ($expYaencontre) { ?&gt;
&lt;div class=&quot;col-md-2&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
      &lt;label for=&quot;yaencontre&quot;&gt;&lt;?php __(&#039;Yaencontre&#039;); ?&gt;:&lt;/label&gt;
      &lt;div class=&quot;controls&quot;&gt;
        &lt;select name=&quot;yaencontre&quot; id=&quot;yaencontre&quot; class=&quot;form-control&quot;&gt;
            &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            &lt;option value=&quot;0&quot;&gt;&lt;?php echo __(&#039;No&#039;) ?&gt;&lt;/option&gt;
            &lt;option value=&quot;1&quot;&gt;&lt;?php echo __(&#039;S&iacute;&#039;) ?&gt;&lt;/option&gt;
        &lt;/select&gt;
      &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:561
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php } ?&gt;
&lt;?php if ($expYaencontre == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Yaencontre&#039;); ?&gt;&lt;br&gt;&lt;span class=&quot;label label-info&quot;&gt;&lt;?php echo number_format($totalRows_rsPropertiesYaencontre,0, &#039;,&#039;, &#039;.&#039;); ?&gt;&lt;/span&gt;&lt;/th&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported.php:599
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var showTodoPisoAlicante = &lt;?php echo $expTodoPisoAlicante ?&gt;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var showTodoPisoAlicante = &lt;?php echo $expTodoPisoAlicante ?&gt;;
var showYaencontre = &lt;?php echo $expYaencontre ?&gt;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:83
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
if ($expYaencontre == 1) {
    array_push($aColumns, &#039;export_yaencontre_prop&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:317
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}
$yaencontre = &#039;&#039;;
if( isset($_GET[&#039;yaencontre&#039;]) &amp;&amp; $_GET[&#039;yaencontre&#039;] != &#039;&#039; ){
    $yaencontre = &quot;AND export_yaencontre_prop = &quot; . $_GET[&#039;yaencontre&#039;];
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:386
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
end as export_todopisoalicante_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
end as export_todopisoalicante_prop,
case properties_properties.export_yaencontre_prop
  when &#039;1&#039; then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
  when &#039;0&#039; then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
end as export_yaencontre_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/exported-data.php:393
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$todopiso
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$todopiso $yaencontre
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/seguimiento/_js/report-export-search.js:73
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
}

if (showYaencontre == 1) {
    columnas.push({&quot;sName&quot;: &quot;export_yaencontre_prop&quot;,&quot;bSearchable&quot;: true,&quot;bSortable&quot;: true,&quot;sClass&quot;: &quot;ticks&quot;,&quot;render&quot;: function ( data, type, row ) {if (data == &#039;No&#039;) {return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_yaencontre_prop&amp;v=1&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/delete.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;} else{return &#039;&lt;a href=&quot;../properties/properties-change.php?s=export_yaencontre_prop&amp;v=0&amp;id_prop=&#039; +  row[totalFLDS] + &#039;&quot; class=&quot;update-status&quot; data-toggle=&quot;tooltip&quot; data-placement=&quot;bottom&quot; title=&quot;&#039; + titleExtraAction + &#039;&quot;&gt;&lt;img src=&quot;/intramedianet/includes/assets/img/done.gif&quot; alt=&quot;&quot;&gt;&lt;/a&gt;&#039;;}}});
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:76
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1): ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($expFacilisimo == 1 || $expPrian == 1 || $expPisos == 1 || $expGreenAcres == 1 || $expThinkSpain == 1 || $expHabitaclia == 1 || $expHemnet == 1 || $expTodoPisoAlicante == 1 || $expYaencontre == 1): ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/exportar.php:102
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
&lt;?php if ($expYaencontre == 1): ?&gt;
    &lt;p&gt;&lt;a href=&quot;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/yaencontre.php&quot; target=&quot;_blank&quot;&gt;https://&lt;?php echo $_SERVER[&#039;HTTP_HOST&#039;] ?&gt;/xml/yaencontre.php&lt;/a&gt;&lt;/p&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        Subir el archivo <code>/xml/yaencontre.php</code>
        <hr>
        Subir la carpeta <code>/intramedianet/properties/yaencontre</code>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
