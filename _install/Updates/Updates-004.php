<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 14 min.</span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 23-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadir mapeo a las graficas de inicio del panel</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> Mejoras email de bienvenida</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Bug en el contador de tareas</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> Bug envío de citas/tareas por email</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Añadir el mapeo de tipos a la busqueda de inmuebles en la ficha del cliente</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Corrección en la traducción de Served </a></li>
        <li><a href="#siete"><i class="fas fz-fw fa-bug text-danger"></i> Calendario al anadir una segunda cita después de haber añadido antes una, te copia los datos de la primera</a></li>
        <li><a href="#ocho"><i class="fas fz-fw fa-bug text-danger"></i> En el calendario al elegir la fecha, el calendario sale abajo y no se puede seleccionar</a></li>
        <li><a href="#nueve"><i class="fas fz-fw fa-bug text-danger"></i> Remaquetación de los puntos informativos en el  listado inmuebles </a></li>
        <li><a href="#diez"><i class="fas fz-fw fa-plus-circle text-success"></i> Mejoras en la página de login y recordar contraseña</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir mapeo a las graficas de inicio del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/inicio.php:99
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT properties_loc4.name_&quot;.$lang_adm.&quot;_loc4 AS `name`,
  properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 AS sname,
  COUNT(id_loc4) AS total
FROM properties_properties INNER JOIN properties_loc4 ON properties_properties.localidad_prop = properties_loc4.id_loc4
   INNER JOIN properties_loc3 ON properties_loc4.loc3_loc4 = properties_loc3.id_loc3
GROUP BY id_loc4
ORDER BY total DESC
LIMIT 10
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT
  COUNT(CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END) AS total,
  CASE WHEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 IS NOT NULL THEN properties_loc3.name_&quot;.$lang_adm.&quot;_loc3 ELSE areas1.name_&quot;.$lang_adm.&quot;_loc3  END AS sname,
  CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id
FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
        LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
        LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3
        LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
        LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2
        LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1
        LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4
GROUP BY CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END
ORDER BY total DESC
LIMIT 10
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/inicio.php:74
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT properties_types.types_&quot;.$lang_adm.&quot;_typ as name, COUNT(id_typ) as total
FROM properties_properties INNER JOIN properties_types ON properties_properties.tipo_prop = properties_types.id_typ
GROUP BY id_typ
ORDER BY total DESC
LIMIT 10
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT
CASE WHEN properties_types.types_&quot;.$lang_adm.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang_adm.&quot;_typ ELSE types.types_&quot;.$lang_adm.&quot;_typ END AS name,
COUNT(CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END) as total
FROM  properties_properties
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
GROUP BY CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END
ORDER BY total DESC
LIMIT 10
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
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Mejoras email de bienvenida
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mailtemplates/welcome_es.html:240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;{kt_login_page}&quot; target=&quot;_blank&quot;&gt;Acceder al área privada de la web&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;{kt_login_page}&quot; target=&quot;_blank&quot; style=&quot;text-decoration: none; color: #fff;&quot;&gt;Acceder al área privada de la web&lt;/a&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/includes/mailtemplates/welcome_en.html:240
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;{kt_login_page}&quot; target=&quot;_blank&quot;&gt;Access the private area of the website&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;{kt_login_page}&quot; target=&quot;_blank&quot; style=&quot;text-decoration: none; color: #fff;&quot;&gt;Access the private area of the website&lt;/a&gt;
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
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug en el contador de tareas
    </h6>
    <div class="card-body">
        Actualizar la base de datos:
        <pre>
            <code class="makefile">
ALTER TABLE `tasks` CHANGE COLUMN `status_tsk` `status_tsk` INT(11) NULL DEFAULT '0'  COMMENT '' AFTER `priority_tsk`;
ALTER TABLE `tasks` CHANGE COLUMN `status_tsk` `status_tsk` INT(11) NOT NULL DEFAULT 0  COMMENT '' AFTER `priority_tsk`;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/tasks/tasks-form.php:117
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$ins_tasks-&gt;addColumn(&quot;status_tsk&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;status_tsk&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$ins_tasks-&gt;addColumn(&quot;status_tsk&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;status_tsk&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/tasks/tasks-form.php:139
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$upd_tasks-&gt;addColumn(&quot;status_tsk&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;status_tsk&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$upd_tasks-&gt;addColumn(&quot;status_tsk&quot;, &quot;NUMERIC_TYPE&quot;, &quot;POST&quot;, &quot;status_tsk&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:525
/intramedianet/includes/inc.header-empleado.php:294
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sWhere = ' WHERE date_due_tsk &lt;= CURRENT_DATE() AND status_tsk != 2 ';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sWhere = ' WHERE DATE(date_due_tsk) &lt;= CURRENT_DATE() AND status_tsk != 2 ';
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:531
/intramedianet/includes/inc.header-empleado.php:300
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
SELECT SQL_CALC_FOUND_ROWS
  (SELECT nombre_usr FROM users WHERE id_usr  = admin_tsk) as admin_tsk,
  subject_tsk,
  date_due_tsk,
  priority_tsk,
  (SELECT categorias_&quot;.$lang_adm.&quot;_cat as cat FROM tasks_categories WHERE id_cat = status_tsk) as status_tsk,
  case contact_type_tsk
      when '1' then (SELECT CONCAT ('&lt;i class=\&quot;fa fa-fw fa-male\&quot;&gt;&lt;/i&gt; ', nombre_cnt, ' ', apellidos_cnt) FROM contactos WHERE id_cnt = contact_tsk)
      when '2' then (SELECT CONCAT ('&lt;i class=\&quot;fa fa-fw fa-users\&quot;&gt;&lt;/i&gt; ', nombre_cli, ' ', apellidos_cli) FROM properties_client WHERE id_cli = contact_tsk)
      when '3' then (SELECT CONCAT ('&lt;i class=\&quot;fa fa-fw fa-key\&quot;&gt;&lt;/i&gt; ', nombre_pro, ' ', apellidos_pro) FROM properties_owner WHERE id_pro = contact_tsk)
      when '' then ''
  end as contact_type_tsk,
  id_tsk
FROM tasks
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
SELECT
    id_tsk
FROM tasks
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 3 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Bug envío de citas/tareas por email
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/send-citas.php:111
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
WHERE DATE(date_due_tsk) = DATE(NOW()) AND admin_tsk = '&quot; . $row_rsusuarios['id_usr'] . &quot;'&quot;;
            </code>
        </pre>
        por:
        <pre>
            <code class="php">
WHERE DATE(date_due_tsk) &lt;= DATE(NOW()) AND admin_tsk = '&quot; . $row_rsusuarios['id_usr'] . &quot;'&quot;;
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
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir el mapeo de tipos a la busqueda de inmuebles en la ficha del cliente
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:83
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsTipos = &quot;SELECT types_&quot;.$lang_adm.&quot;_typ, id_typ FROM properties_types ORDER BY types_&quot;.$lang_adm.&quot;_typ&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsTipos = &quot;
SELECT
  CASE WHEN properties_types.types_&quot;.$lang_adm.&quot;_typ IS NOT NULL THEN properties_types.types_&quot;.$lang_adm.&quot;_typ ELSE types.types_&quot;.$lang_adm.&quot;_typ END AS types_&quot;.$lang_adm.&quot;_typ,
  CASE WHEN properties_types.id_typ IS NOT NULL THEN properties_types.id_typ ELSE types.id_typ END AS id_typ
FROM  properties_properties
    INNER JOIN properties_types types ON properties_properties.tipo_prop = types.id_typ
    LEFT OUTER JOIN properties_types ON types.parent_typ = properties_types.id_typ
WHERE activado_prop = 1 AND alquilado_prop = 0 AND vendido_prop = 0
GROUP BY id_typ
ORDER BY types_&quot;.$lang_adm.&quot;_typ
&quot;;
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Corrección en la traducción de Served
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php:641
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang['Atendido'] = 'Served';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$lang['Atendido'] = 'Attended';
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="siete">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-bug text-danger"></i> Calendario al anadir una segunda cita después de haber añadido antes una, te copia los datos de la primera
    </h6>
    <div class="card-body">
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/calendar/_js/calendar-view.js:90
/intramedianet/inicio/_js/dashboard.js:68
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$('#final_ct').val(date.format('DD-MM-YYYY') + roundTimeQuarterHour(1));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$('#final_ct').val(date.format('DD-MM-YYYY') + roundTimeQuarterHour(1));
$('#titulo_ct').val('');
$('#lugar_ct').val('');
$('#notas_ct').val('');
$('#categoria_ct').val('');
$('#users_ct').val('').select2('destroy').select2();
$('#property_ct').val('').select2('destroy').select2();
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/calendar/_js/calendar-view.js:183
/intramedianet/inicio/_js/dashboard.js:164
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
});//.on('hide', myHandler);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
});//.on('hide', myHandler);
$('.add-cita').attr('name','KT_Insert1');
$('#titulo_ct').val('');
$('#lugar_ct').val('');
$('#notas_ct').val('');
$('#categoria_ct').val('');
$('#users_ct').val('').select2('destroy').select2();
$('#property_ct').val('').select2('destroy').select2();
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/inicio/inicio.php:818
            </code>
        </pre>
        Eliminar la línea:
        <pre>
            <code class="php">
&lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="ocho">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> En el calendario al elegir la fecha, el calendario sale abajo y no se puede seleccionar
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/calendar/calendario.php:
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __('Categoría'); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;?php
        do {
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rscategorias['id_ct']?&gt;&quot;&gt;&lt;?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?&gt;&lt;/option&gt;
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
    &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __('Usuario'); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;?php
        do {
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rsusuarios['id_usr']?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios['nombre_usr']?&gt;&lt;/option&gt;
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
    &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __('Clientex'); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
        &lt;?php
        do {
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rsclientes['id_cli']?&gt;&quot;&gt;&lt;?php echo $row_rsclientes['nombre_cli']?&gt; &lt;?php echo $row_rsclientes['apellidos_cli']?&gt;&lt;/option&gt;
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
    &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __('Propiedades'); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
        &lt;?php
        do {
          $vals = explode(',', $row_rsproperties_client['property_ct']);
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rspropiedad['id_prop']?&gt;&quot; &gt;&lt;?php echo $row_rspropiedad['referencia_prop']?&gt;&lt;/option&gt;
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
    &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __('Lugar'); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;categoria_ct&quot;&gt;&lt;?php __('Categoría'); ?&gt;:&lt;/label&gt;
            &lt;select name=&quot;categoria_ct&quot; id=&quot;categoria_ct&quot; class=&quot;form-control required&quot;&gt;
                &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                &lt;?php
                do {
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rscategorias['id_ct']?&gt;&quot;&gt;&lt;?php echo $row_rscategorias['category_'.$lang_adm.'_ct']?&gt;&lt;/option&gt;
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
    &lt;/div&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;user_ct&quot;&gt;&lt;?php __('Usuario'); ?&gt;:&lt;/label&gt;
            &lt;select name=&quot;user_ct&quot; id=&quot;user_ct&quot; class=&quot;required select2&quot;&gt;
                &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                &lt;?php
                do {
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsusuarios['id_usr']?&gt;&quot;&lt;?php if (!(strcmp($row_rsusuarios['id_usr'], $_SESSION['kt_login_id']))) {echo &quot; SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsusuarios['nombre_usr']?&gt;&lt;/option&gt;
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
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;users_ct&quot;&gt;&lt;?php __('Clientex'); ?&gt;:&lt;/label&gt;
            &lt;select name=&quot;users_ct&quot; id=&quot;users_ct&quot; class=&quot;form-control select2&quot;&gt;
                &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                &lt;?php
                do {
                ?&gt;
                &lt;option value=&quot;&lt;?php echo $row_rsclientes['id_cli']?&gt;&quot;&gt;&lt;?php echo $row_rsclientes['nombre_cli']?&gt; &lt;?php echo $row_rsclientes['apellidos_cli']?&gt;&lt;/option&gt;
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
    &lt;/div&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group&quot;&gt;
            &lt;label for=&quot;lugar_ct&quot;&gt;&lt;?php __('Lugar'); ?&gt;:&lt;/label&gt;
            &lt;input type=&quot;text&quot; name=&quot;lugar_ct&quot; id=&quot;lugar_ct&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;property_ct&quot;&gt;&lt;?php __('Propiedades'); ?&gt;:&lt;/label&gt;
    &lt;select name=&quot;property_ct[]&quot; id=&quot;property_ct&quot; multiple class=&quot;form-control select2&quot;&gt;
        &lt;?php
        do {
          $vals = explode(',', $row_rsproperties_client['property_ct']);
        ?&gt;
        &lt;option value=&quot;&lt;?php echo $row_rspropiedad['id_prop']?&gt;&quot; &gt;&lt;?php echo $row_rspropiedad['referencia_prop']?&gt;&lt;/option&gt;
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
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="nueve">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Remaquetación de los puntos informativos en el  listado inmuebles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties.php:89
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __('Referencia'); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __('Referencia'); ?&gt;&lt;?php echo str_repeat(&quot;&amp;nbsp;&quot;, 7); ?&gt;&lt;/th&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="diez">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-plus-circle text-success"></i>  Mejoras en la página de login y recordar contraseña
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/feed.php
            </code>
        </pre>
        Cambiar todo por:
        <pre>
            <code class="php">
&lt;?php
if($lang_adm == &quot;es&quot;) {
  $feed = &quot;https://mediaelx.net/rss-paneles-es.php?idm=1&quot;;
} else {
  $feed = &quot;https://mediaelx.net/rss-paneles-en.php?idm=2&quot;;
}
$xml = simplexml_load_file($feed);
?&gt;
&lt;div class=&quot;slider&quot;&gt;
    &lt;?php
    $x = 0;
    foreach($xml-&gt;channel-&gt;item as $entry){ ?&gt;
            &lt;div class=&quot;well well-sm&quot;&gt;
                &lt;?php if ($entry-&gt;img != ''): ?&gt;
                &lt;?php echo showThumbnail($entry-&gt;img, '/media/images/news/', 300, 300); ?&gt;
                &lt;?php endif ?&gt;
                &lt;!-- &lt;img src=&quot;&lt;?= $entry-&gt;img ?&gt;&quot; class=&quot;img-fluid&quot;&gt; --&gt;
                &lt;a href=&quot;&lt;?= $entry-&gt;link ?&gt;&quot; target=&quot;_blank&quot;&gt;&lt;?= $entry-&gt;title ?&gt;&lt;/a&gt;
                &lt;div&gt;&lt;?= strftime('%d-%m-%Y', strtotime($entry-&gt;pubDate)) ?&gt;&lt;/div&gt;
            &lt;/div&gt;
    &lt;?php
        if ($entry-&gt;title != '') {
            if ($x++ == 3) {
                break;
            }
        }
    }
    ?&gt;
&lt;/div&gt;
&lt;br&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/index.php:58
/intramedianet/forgot_password.php:86
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php include(&quot;includes/inc.head.php&quot;); ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php include(&quot;includes/inc.head.php&quot;); ?&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css&quot;&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css&quot; /&gt;
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/index.php:200
/intramedianet/forgot_password.php:227
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
.copyrr {
    font-size: 10px;
    letter-spacing: .1em;
    text-transform: uppercase;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
.copyrr {
    font-size: 10px;
    letter-spacing: .1em;
    text-transform: uppercase;
}
.slick-dots {
    bottom: -5px;
}
.slick-dots li button:before {
    font-size: 30px;
    line-height: 30px;
    width: 30px;
    height: 30px;
    content: '●';
    -moz-osx-font-smoothing: grayscale;
}
            </code>
        </pre>
        <hr>
        En los archivos:
        <pre>
            <code class="makefile">
/intramedianet/index.php:317
/intramedianet/forgot_password.php:332
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script src=&quot;//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js&quot;&gt;&lt;/script&gt;
&lt;script src=&quot;https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js&quot;&gt;&lt;/script&gt;
&lt;script&gt;
    $(document).ready(function(){
      $('.slider').slick({
          infinite: true,
          dots: true,
          arrows: false,
          slidesToShow: 1,
          slidesToScroll: 1,
          adaptiveHeight: true,
          autoplay: true,
          autoplaySpeed: 10000,
      });
    });
  &lt;/script&gt;
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 2 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
