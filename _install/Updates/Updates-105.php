<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 26-09-2023</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Cambios realizados por Luis en back y front</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-bug text-danger"></i> El formulario de ventas no esta tomando en cuenta el campo de teléfono</a></li>
        <li><a href="#tres"><i class="fas fz-fw fa-bug text-danger"></i> Añadido enlace a consultas portales en el lateral del panel</a></li>
        <li><a href="#cuatro"><i class="fas fz-fw fa-bug text-danger"></i> El formulario de favoritos no muestra los * en los campos obligatorios</a></li>
        <li><a href="#cinco"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes en las plantillas de correo</a></li>
        <li><a href="#seis"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes de niveles de usuarios y otros ajustes</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Cambios realizados por Luis en back y front
    </h6>
    <div class="card-body">
        <p>Se han realiazado los siguientes cambios:</p>

        <h6 class="mt-4"><b>En connections:</b></h6>
        <ul>
            <li>pdf.php //para configurar el pdf</li>
            <li>galerias.php // para el tipo de galeria de las propiedades y activar/descactivar el modal con las fotos (por defecto lo dejo activado)</li>
            <li>datos-cli.php // con los datos de contacto que se usan en la web</li>
        </ul>

        <h6 class="mt-4"><b>Promociones:</b></h6>
        <ul>
            <li>En connections/conf/propiedades.php he añadido $actPromociones = 1/0 para activar proyectos o promociones en el panel.</li>
            <li>No están maquetados en la web. Solamente lo he dejado funcionando en el panel por si nos lo vuelven a pedir.</li>
            <li>En la próxima web con promociones podría subir algo ya maquetado.</li>
        </ul>

        <h6 class="mt-4"><b>Login y Register:</b></h6>
        <ul>
            <li>En connections/conf/niveles.php he añadido el $actRegister = 1/0 que activa los formularios de login y register (están medio maquetados y funcionales)</li>
            <li>El registro lleva el filtro que añadimos para los teléfonos que empiezan por 8.</li>
            <li>El recaptcha también está puesto pero lo dejo comentado por si hay que probar los formularios en local (o por si no se quiere poner)</li>
        </ul>

        <h6 class="mt-4"><b>Guardar Búsquedas:</b></h6>
        <ul>
            <li>He usado la variable que teníamos en connections/conf/propiedades.php<br>
        $actSaveSearch = 1/0;</li>
        </ul>

        <div class="ajert alert-info p-2 mb-3 rounded">
            He añadido Guadar búsquedas tanto en el front como en la ficha del cliente en el panel (No he añadido la columna de cliente registrado que hay que poner en el listado de clientes)
        </div>

        <h6 class="mt-4"><b>Zonas/Áreas:</b></h6>
        <ul>
            <li>He arreglado la galería de fotos de  Zonas/areas en el panel.</li>
            <li>No se actualizaban las fotos al publicar una costa o una zona. Había que guardar, salir y volver a entrar para ver las fotos.</li>
        </ul>

        <h6 class="mt-4"><b>Base de datos:</b></h6>
        <ul>
            <li>La he actualizado con las columnas que hacían falta para las promociones y para el guardar búsquedas</li>
        </ul>

        <h6 class="mt-4"><b>Otros:</b></h6>
        <ul>
            <li>También he remaquetado algunas cosillas en la ficha y la cabecera para dejarlas más fáciles.</li>
            <li>Seguramente se me han quedado mil cosas de bootstrap 4 y cosas de CSS que no sirven para nada, pero no me podía poner ahora a revisar toda la maquetación</li>
        </ul>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> El formulario de ventas no esta tomando en cuenta el campo de teléfono
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/vender/send-quote.php:40
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$mensaHTML .= &quot;&lt;p&gt;&lt;strong&gt;Email&lt;/strong&gt;: &quot; . $_GET[&#039;email&#039;] . &quot;&lt;/p&gt;&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$mensaHTML .= &quot;&lt;p&gt;&lt;strong&gt;Email&lt;/strong&gt;: &quot; . $_GET[&#039;email&#039;] . &quot;&lt;/p&gt;&quot;;
$mensaHTML .= &quot;&lt;p&gt;&lt;strong&gt;Phone&lt;/strong&gt;: &quot; . $_GET[&#039;telefono&#039;] . &quot;&lt;/p&gt;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="tres">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadido enlace a consultas portales en el lateral del panel
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.sidebar.php:481
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/seguimiento/emails.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/emails.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Env&iacute;o de emails&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php endif ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/seguimiento/emails.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/emails.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Env&iacute;o de emails&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php if ($actPortalsEnquiries == 1): ?&gt;
&lt;li class=&quot;nav-item&quot;&gt;
    &lt;a href=&quot;/intramedianet/email/email.php&quot; class=&quot;nav-link &lt;?php if(preg_match(&#039;/\/email.php/&#039;, $_SERVER[&#039;PHP_SELF&#039;])){ ?&gt;active&lt;?php } ?&gt;&quot;&gt;&lt;?php __(&#039;Portales&#039;); ?&gt;&lt;/a&gt;
&lt;/li&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cuatro">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> El formulario de favoritos no muestra los * en los campos obligatorios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/favorites/view/partials/modal-send.tpl:12
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-3&quot;&gt;
    &lt;label for=&quot;name&quot;&gt;{$lng_nombre}&lt;/label&gt;
    &lt;input type=&quot;text&quot; class=&quot;form-control required&quot; name=&quot;name&quot; id=&quot;name&quot;
        placeholder=&quot;{$lng_nombre}&quot;&gt;
&lt;/div&gt;
&lt;div class=&quot;mb-3&quot;&gt;
    &lt;label for=&quot;email&quot;&gt;{$lng_email}&lt;/label&gt;
    &lt;input type=&quot;text&quot; class=&quot;form-control required email&quot; name=&quot;email&quot; id=&quot;email&quot;
        placeholder=&quot;{$lng_email}&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;mb-3&quot;&gt;
    &lt;label for=&quot;name&quot;&gt;{$lng_nombre}*&lt;/label&gt;
    &lt;input type=&quot;text&quot; class=&quot;form-control required&quot; name=&quot;name&quot; id=&quot;name&quot; placeholder=&quot;{$lng_nombre}*&quot;&gt;
&lt;/div&gt;
&lt;div class=&quot;mb-3&quot;&gt;
    &lt;label for=&quot;email&quot;&gt;{$lng_email}*&lt;/label&gt;
    &lt;input type=&quot;text&quot; class=&quot;form-control required email&quot; name=&quot;email&quot; id=&quot;email&quot; placeholder=&quot;{$lng_email}*&quot;&gt;
&lt;/div&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="cinco">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes en las plantillas de correo
    </h6>
    <div class="card-body">
        <p>Hay que sustituir los siguientes archivos:</p>
        <ul>
            <li>/modules/mail_partials/property-acumba.php</li>
            <li>/modules/mail_partials/property.php</li>
            <li>/modules/mail_partials/property-acumba-one.php</li>
            <li>/includes/mailtemplates/template.html</li>
            <li>/includes/mailtemplates/template_semanal.html</li>
        </ul>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="seis">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes de niveles de usuarios y otros ajustes
    </h6>
    <div class="card-body">
        <p>Se han ajustado las siguientes cosas reportadas por Luis y Miguel:</p>
        <ul>
            <li>El listado de propiedades del agente tiene un error y no carga nada.</li>
            <li>Un agente al dar de alta clientes no aparecen en su listado</li>
            <li>En el calendario del nivel admin no se puede filtrar por agentes o empleados</li>
            <li>Tanto el nivel de agente como el empleado por defecto pueden ver todo lo relacionado con: import xml y export xml </li>
            <li>En la ficha de propiedad se ha perdido la referencia al check de "vendido (Oculto en listados y exportadores)"</li>
            <li>Al check de "Ocultar (importada de XML” le falta el paréntesis de la derecha y hace que la traducción al inglés no funcione</li>
            <li>Al geolocalizar una casa no deja copiar de maps las coordenadas (tanto público como privado)</li>
            <li>Dijimos también de ocultar el mapa de google en el CRM y poner link a Google Maps</li>
            <li>En el mapa de propiedades general, si pinchas en una casa te lleva a propiedades</li>
            <li>En Propiedades / General / Features poner link a features </li>
            <li>Ocultado en el front lo del clima ya que accuweather ya no funciona</li>
        </ul>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
